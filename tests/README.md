# Testing the Bundle

`EasyAclBundle` has been tested within the context of [`Zebra`](https://github.com/programarivm/zebra), which is a host application to help develop and test Symfony bundles.

### `phpunit.xml.dist`

```xml
<?xml version="1.0" encoding="UTF-8"?>

<!-- https://phpunit.readthedocs.io/en/latest/configuration.html -->
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="bin/.phpunit/phpunit.xsd"
         backupGlobals="false"
         colors="true"
         bootstrap="config/bootstrap.php"
>
    <php>
        <ini name="error_reporting" value="-1" />
        <env name="APP_ENV" value="test" force="true" />
        <env name="JWT_SECRET" value="secret" force="true" />
        <server name="SHELL_VERBOSITY" value="-1" />
        <server name="SYMFONY_PHPUNIT_REMOVE" value="" />
        <server name="SYMFONY_PHPUNIT_VERSION" value="7.5" />
    </php>

    <testsuites>
        <testsuite name="Zebra">
            <directory>tests</directory>
        </testsuite>
        <testsuite name="EasyAcl bootstrap">
            <directory>vendor/programarivm/easy-acl-bundle/tests/BootstrapTest.php</directory>
        </testsuite>
        <testsuite name="EasyAcl test">
            <directory>vendor/programarivm/easy-acl-bundle/tests/EasyAclTest.php</directory>
        </testsuite>
        <testsuite name="EasyAcl fixtures">
            <file>vendor/programarivm/easy-acl-bundle/tests/DataFixtures/Config/RouteFixturesTest.php</file>
            <file>vendor/programarivm/easy-acl-bundle/tests/DataFixtures/Config/RoleFixturesTest.php</file>
            <file>vendor/programarivm/easy-acl-bundle/tests/DataFixtures/Config/PermissionFixturesTest.php</file>
            <file>vendor/programarivm/easy-acl-bundle/tests/DataFixtures/IdentityFixturesTest.php</file>
        </testsuite>
        <testsuite name="EasyAcl repository">
            <file>vendor/programarivm/easy-acl-bundle/tests/Repository/PermissionTest.php</file>
            <file>vendor/programarivm/easy-acl-bundle/tests/Repository/IdentityTest.php</file>
        </testsuite>
    </testsuites>

    <filter>
        <whitelist processUncoveredFilesFromWhitelist="true">
            <directory suffix=".php">src</directory>
        </whitelist>
    </filter>

    <listeners>
        <listener class="Symfony\Bridge\PhpUnit\SymfonyTestsListener" />
    </listeners>
</phpunit>
```

Load the host fixtures:

    docker exec -itu 1000:1000 zebra_php_fpm php bin/console doctrine:fixtures:load --group=zebra

     Careful, database "zebra" will be purged. Do you want to continue? (yes/no) [no]:
     > y

       > purging database
       > loading App\DataFixtures\UserFixtures
       > loading App\DataFixtures\AddressFixtures

Run the `EasyAclBundle` tests:

    docker exec -it zebra_php_fpm php bin/phpunit
