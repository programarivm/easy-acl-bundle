# Easy Access Control List (ACL) Bundle

`EasyAclBundle` is the easiest to use access control list (ACL) bundle.

## Configuration

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

Update your database schema:

    php bin/console doctrine:schema:update --force

## To Do List

- Continue developing the bundle
- Write documentation
