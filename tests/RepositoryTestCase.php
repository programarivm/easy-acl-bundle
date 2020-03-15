<?php

namespace Programarivm\EasyAclBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RepositoryTestCase extends WebTestCase
{
    protected static $em;

    public static function setUpBeforeClass()
    {
        if ($_ENV['APP_ENV'] !== 'test') {
            throw new \DomainException('Whoops! The repository tests can only be loaded in a testing environment.');
        }

        $kernel = static::createKernel();
        $kernel->boot();

        self::$container = $kernel->getContainer();

        self::$em = self::$container->get('doctrine.orm.entity_manager');
    }
}
