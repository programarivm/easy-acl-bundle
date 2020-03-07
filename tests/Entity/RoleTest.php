<?php

namespace Programarivm\EasyAclBundle\Tests\Entity;

use Programarivm\EasyAclBundle\EasyAcl;
use Programarivm\EasyAclBundle\Entity\Role;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RoleTest extends WebTestCase
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
     * @dataProvider sampleData
     * @test
     */
    public function setters_and_getters($type, $hierarchy)
    {
        foreach (self::$easyAcl->getRoles() as $item) {
            $role = (new Role())
                ->setType($type)
                ->setHierarchy($hierarchy);

            $expected = [
                $type,
                $hierarchy,
            ];

            $actual = [
                $role->getType(),
                $role->getHierarchy(),
            ];

            $this->assertEquals($expected, $actual);
        }
    }

    public function sampleData()
    {
        return [
            ['Superadmin', 0],
            ['Admin', 1],
            ['Basic', 2],
        ];
    }
}
