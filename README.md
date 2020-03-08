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
# config/services.yaml
services:
    Programarivm\EasyAclBundle\Command\SetupCommand:
        arguments:
            $projectDir: '%kernel.project_dir%'
        tags: ['console.command']
```

```yaml
# config/packages/programarivm_easy_acl.yaml
programarivm_easy_acl:
  roles:
    -
      hierarchy: 0
      name: Superadmin
    -
      hierarchy: 1
      name: Admin
    -
      hierarchy: 2
      name: Basic
```

Update your database schema:

    php bin/console doctrine:schema:update --force

## To Do List

- Continue developing the bundle
- Write documentation
