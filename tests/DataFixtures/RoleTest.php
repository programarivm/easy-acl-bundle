<?php

namespace Programarivm\EasyAclBundle\Tests\DataFixtures;

use Programarivm\EasyAclBundle\EasyAcl;
use Programarivm\EasyAclBundle\Entity\Role;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RoleTest extends WebTestCase
{
    private static $easyAcl;

    private static $em;

    public static function setUpBeforeClass()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        self::$container = $kernel->getContainer();

        self::$easyAcl = self::$container->get('programarivm.easy_acl');
        self::$em = self::$container->get('doctrine.orm.entity_manager');
    }

    /**
     * @test
     */
    public function load()
    {
        foreach (self::$easyAcl->getRoles() as $item) {
            $role = (new Role())
                ->setName($item['name'])
                ->setHierarchy($item['hierarchy']);

            self::$em->persist($role);
        }

        self::$em->flush();

        $this->assertTrue(true);
    }
}
