# EasyAcl Bundle

Easy-to-use access control list (ACL) bundle in Symfony 5.

### Install

Via composer:

```text
$ composer require programarivm/easy-acl-bundle
```

### Configuration

Configure your app's routes in `config/routes.yaml`.

```yaml
# config/routes.yaml
api_post_create:
    path:       /api/posts
    controller: App\Controller\Post\CreateController::index
    methods:    POST

api_post_delete:
    path:       /api/posts/{id}
    controller: App\Controller\Post\DeleteController::index
    methods:    DELETE

api_post_edit:
    path:       /api/posts/{id}
    controller: App\Controller\Post\EditController::index
    methods:    PUT
```

Set up permissions as in the example shown below.

```yaml
# config/packages/programarivm_easy_acl.yaml
programarivm_easy_acl:
  target: App\Entity\User
  permission:
    -
      role: Superadmin
      routes:
        - api_post_create
        - api_post_delete
        - api_post_edit
    -
      role: Admin
      routes:
        - api_post_create
        - api_post_edit
    -
      role: Basic
      routes:
        - api_post_create
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

Which go hand in hand with the entities:

- [`Programarivm\EasyAclBundle\Entity\Identity`](https://github.com/programarivm/easy-acl-bundle/blob/master/src/Entity/Identity.php)
- [`Programarivm\EasyAclBundle\Entity\Permission`](https://github.com/programarivm/easy-acl-bundle/blob/master/src/Entity/Permission.php)
- [`Programarivm\EasyAclBundle\Entity\Role`](https://github.com/programarivm/easy-acl-bundle/blob/master/src/Entity/Role.php)
- [`Programarivm\EasyAclBundle\Entity\Route`](https://github.com/programarivm/easy-acl-bundle/blob/master/src/Entity/Route.php)

And the repositories:

- [`Programarivm\EasyAclBundle\Repository\IdentityRepository`](https://github.com/programarivm/easy-acl-bundle/blob/master/src/Repository/IdentityRepository.php)
- [`Programarivm\EasyAclBundle\Repository\PermissionRepository`](https://github.com/programarivm/easy-acl-bundle/blob/master/src/Repository/PermissionRepository.php)
- [`Programarivm\EasyAclBundle\Repository\RoleRepository`](https://github.com/programarivm/easy-acl-bundle/blob/master/src/Repository/RoleRepository.php)
- [`Programarivm\EasyAclBundle\Repository\RouteRepository`](https://github.com/programarivm/easy-acl-bundle/blob/master/src/Repository/RouteRepository.php)

### `easy-acl:setup` command

Command line:

    php bin/console easy-acl:setup
    This will reset the ACL. Are you sure to continue? (y) y

MySQL console:

    mysql> select * from easy_acl_identity;
    Empty set (0.01 sec)

    mysql> select * from easy_acl_permission;
    +----+------------+-----------------+
    | id | rolename   | routename       |
    +----+------------+-----------------+
    |  1 | Superadmin | api_post_create |
    |  2 | Superadmin | api_post_delete |
    |  3 | Superadmin | api_post_edit   |
    |  4 | Admin      | api_post_create |
    |  5 | Admin      | api_post_edit   |
    |  6 | Basic      | api_post_create |
    +----+------------+-----------------+
    6 rows in set (0.00 sec)

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
    +----+-----------------+---------+-----------------+
    | id | name            | methods | path            |
    +----+-----------------+---------+-----------------+
    |  1 | api_post_create | POST    | /api/posts      |
    |  2 | api_post_delete | DELETE  | /api/posts/{id} |
    |  3 | api_post_edit   | PUT     | /api/posts/{id} |
    +----+-----------------+---------+-----------------+
    3 rows in set (0.00 sec)

As you can see, three `EasyAcl` tables are populated with the data contained in `config/packages/programarivm_easy_acl.yaml`, however it is up to you to define your users' identities.

Example on how to set the `Superadmin` identity to `alice`:

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

Finally, the permission repository helps you determine whether or not a particular role can access a given resource:

```php
$isAllowed = $this->em
                ->getRepository('EasyAclBundle:Permission')
                ->isAllowed('Superadmin', 'api_post_show');
```

More specifically, the example below shows how a JWT token can be authorized in an [event subscriber](https://symfony.com/doc/current/event_dispatcher/before_after_filters.html#creating-an-event-subscriber) with the help of the permission repository.

```php
// src/EventSubscriber/TokenSubscriber.php

namespace App\EventSubscriber;

use App\Controller\AccessTokenController;
use Doctrine\ORM\EntityManagerInterface;
use Firebase\JWT\JWT;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class TokenSubscriber implements EventSubscriberInterface
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $controller = $event->getController();

        // when a controller class defines multiple action methods, the controller
        // is returned as [$controllerInstance, 'methodName']
        if (is_array($controller)) {
            $controller = $controller[0];
        }

        if ($controller instanceof AccessTokenController) {
            $jwt = substr($event->getRequest()->headers->get('Authorization'), 7);

            try {
                $decoded = JWT::decode($jwt, getenv('JWT_SECRET'), ['HS256']);
            } catch (\Exception $e) {
                throw new AccessDeniedHttpException('Whoops! Access denied.');
            }

            $user = $this->em->getRepository('App:User')
                        ->findOneBy(['id' => $decoded->sub]);

            $identity = $this->em->getRepository('EasyAclBundle:Identity')
                            ->findBy(['user' => $user]);

            $rolename = $identity[0]->getRole()->getName();
            $routename = $event->getRequest()->get('_route');

            $isAllowed = $this->em->getRepository('EasyAclBundle:Permission')
                            ->isAllowed($rolename, $routename);

            if (!$isAllowed) {
                throw new AccessDeniedHttpException('Whoops! Access denied.');
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
```

### `EasyAcl` usage

The bundle provides you with `Programarivm\EasyAclBundle\EasyAcl` which can be used to access the bundle information in the YAML config file in a friendly, object-oriented way.

Example:

```php
// src/DataFixtures/EasyAcl/RoleFixtures.php

namespace App\DataFixtures\EasyAcl;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Programarivm\EasyAclBundle\EasyAcl;
use Programarivm\EasyAclBundle\Entity\Role;

class RoleFixtures extends Fixture implements FixtureGroupInterface
{
    private $easyAcl;

    public function __construct(EasyAcl $easyAcl)
    {
        $this->easyAcl = $easyAcl;
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->easyAcl->getPermission() as $key => $permission) {
            $role = (new Role())->setName($permission['role']);
            $manager->persist($role);
            $this->addReference("role-$key", $role);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return [
            'easy-acl',
        ];
    }
}
```

Example:

```php
// src/DataFixtures/EasyAcl/IdentityFixtures.php

namespace App\DataFixtures\EasyAcl;

use App\DataFixtures\UserFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Programarivm\EasyAclBundle\EasyAcl;
use Programarivm\EasyAclBundle\Entity\Identity;

class IdentityFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    private $easyAcl;

    public function __construct(EasyAcl $easyAcl)
    {
        $this->easyAcl = $easyAcl;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < UserFixtures::N; $i++) {
            $index = rand(0, count($this->easyAcl->getPermission())-1);
            $user = $this->getReference("user-$i");
            $role = $this->getReference("role-$index");
            $manager->persist(
                (new Identity())
                    ->setUser($user)
                    ->setRole($role)
            );
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return [
            'easy-acl',
        ];
    }

    public function getDependencies(): array
    {
        return [
            RoleFixtures::class,
            UserFixtures::class,
        ];
    }
}
```

### Contributions

Would you help make this Symfony bundle better?

- Feel free to send a pull request
- Drop an email at info@programarivm.com with the subject "EasyAcl"
- Leave me a comment on [Twitter](https://twitter.com/programarivm)

Thank you.
