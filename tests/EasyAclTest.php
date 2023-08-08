<?php

namespace Programarivm\EasyAclBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EasyAclTest extends WebTestCase
{
    private static $easyAcl;

    public static function setUpBeforeClass()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        self::$container = $kernel->getContainer();

        self::$easyAcl = self::$container->get('programarivm.easy_acl');
    }

    /**
     * @test
     */
    public function get_target()
    {
        $this->assertEquals(self::$easyAcl->getTarget(), 'App\Entity\User');
    }

    /**
     * @test
     */
    public function get_roles()
    {
        $this->assertEquals(self::$easyAcl->getRoles(), [
            'Superadmin',
            'Admin',
            'Basic',
        ]);
    }
}
