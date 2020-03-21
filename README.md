# EasyAcl Bundle

`EasyAclBundle` is the easiest to use access control list (ACL) bundle.

### Install

Via composer:

    $ composer require programarivm/easy-acl-bundle

### Configuration

First things first, configure your application's `config/routes.yaml`.

```yaml
# config/routes.yaml
api_post_show:
    path:       /api/posts/{id}
    controller: App\Controller\BlogApiController::show
    methods:    GET|HEAD

api_post_edit:
    path:       /api/posts/{id}
    controller: App\Controller\BlogApiController::edit
    methods:    PUT
```

Set up `EasyAclBundle` as in the example shown below.

```yaml
# config/packages/programarivm_easy_acl.yaml
programarivm_easy_acl:
  target: App\Entity\User
  permission:
    -
      role: Superadmin
      routes:
        - api_post_show
        - api_post_edit
    -
      role: Admin
      routes:
        - api_post_show
        - api_post_edit
    -
      role: Basic
      routes:
        - api_post_show
```

Update your `config/services.yaml` file.

```yaml
# config/services.yaml
services:
    Programarivm\EasyAclBundle\Command\SetupCommand:
        arguments:
            $projectDir: '%kernel.project_dir%'
        tags: ['console.command']

    Programarivm\EasyAclBundle\Repository\:
        resource: '../vendor/programarivm/easy-acl-bundle/src/Repository'
        autowire: true
        tags: ['doctrine.repository_service']

    Programarivm\EasyAclBundle\EventListener\IdentitySubscriber:
        tags: ['doctrine.event_subscriber']
```

Don't forget to update your database schema:

    php bin/console doctrine:schema:update --force

This will create four empty tables in your database:

- `easy_acl_identity`
- `easy_acl_permission`
- `easy_acl_role`
- `easy_acl_route`

### Load the ACL Data

    php bin/console easy-acl:setup
    This will reset the ACL. Are you sure to continue? (y) y

Three `EasyAcl` tables are populated with the data contained in `config/packages/programarivm_easy_acl.yaml`:

    mysql> select * from easy_acl_permission;
    +----+------------+---------------+
    | id | rolename   | routename     |
    +----+------------+---------------+
    |  1 | Superadmin | api_post_show |
    |  2 | Superadmin | api_post_edit |
    |  3 | Admin      | api_post_show |
    |  4 | Admin      | api_post_edit |
    |  5 | Basic      | api_post_show |
    +----+------------+---------------+
    5 rows in set (0.00 sec)

    mysql> select * from easy_acl_role;
    +----+------------+
    | id | name       |
    +----+------------+
    |  1 | Superadmin |
    |  2 | Admin      |
    |  3 | Basic      |
    +----+------------+
    3 rows in set (0.00 sec)

    mysql> select * from easy_acl_route;
    +----+---------------+----------+-----------------+
    | id | name          | methods  | path            |
    +----+---------------+----------+-----------------+
    |  1 | api_post_show | GET|HEAD | /api/posts/{id} |
    |  2 | api_post_edit | PUT      | /api/posts/{id} |
    +----+---------------+----------+-----------------+
    2 rows in set (0.00 sec)

It is up to you to define your users' identities with the help of `Programarivm\EasyAclBundle\Entity\Identity` as in the following example:

```php
use Programarivm\EasyAclBundle\Entity\Identity;

...

$user = self::$em->getRepository('App:User')->findOneBy(['username' => 'alice');
$role = self::$em->getRepository('EasyAclBundle:Role')->findOneBy(['name' => 'Superadmin']);

$this->em->persist(
    (new Identity())
        ->setUser($user)
        ->setRole($role)
);

...

$this->em->flush();
```

    mysql> select * from easy_acl_identity;
    +----+---------+---------+
    | id | role_id | user_id |
    +----+---------+---------+
    |  1 |       1 |       1 |
    +----+---------+---------+
    1 row in set (0.00 sec)

Finally, you are ready to determine whether or not a particular role can access a given resource:

```php
$isAllowed = $this->em
                ->getRepository('EasyAclBundle:Permission')
                ->isAllowed('Superadmin', 'api_post_show');
```

### Contributions

Would you help make this Symfony bundle better?

- Feel free to send a pull request
- Drop an email at info@programarivm.com with the subject "EasyAcl"
- Leave me a comment on [Twitter](https://twitter.com/programarivm)

Thank you.
