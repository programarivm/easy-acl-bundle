# Easy Access Control List (ACL) Bundle

`EasyAclBundle` is the easiest to use access control list (ACL) bundle for Symfony 5 applications.

## Configuration

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

```yaml
# config/services.yaml
services:
    Programarivm\EasyAclBundle\Command\SetupCommand:
        arguments:
            $projectDir: '%kernel.project_dir%'
        tags: ['console.command']
```

## To Do List

- Continue developing the bundle
- Write documentation
