<?php

namespace Programarivm\EasyAclBundle\Tests\DataFixtures;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Yaml\Yaml;

class DataFixturesTestCase extends WebTestCase
{
    protected static $easyAcl;

    protected static $em;

    protected static $routes;

    public static function setUpBeforeClass()
    {
        if ($_ENV['APP_ENV'] !== 'test') {
            throw new \DomainException('Whoops! The data fixtures can only be loaded in a testing environment.');
        }

        $kernel = static::createKernel();
        $kernel->boot();

        self::$container = $kernel->getContainer();

        self::$easyAcl = self::$container->get('programarivm.easy_acl');
        self::$em = self::$container->get('doctrine.orm.entity_manager');
        self::$routes = Yaml::parseFile("{$kernel->getProjectDir()}/config/routes.yaml");
    }
}
