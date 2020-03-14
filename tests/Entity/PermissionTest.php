<?php

namespace Programarivm\EasyAclBundle\Tests\Entity;

use Programarivm\EasyAclBundle\Entity\Permission;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PermissionTest extends WebTestCase
{
    /**
     * @dataProvider sampleData
     * @test
     */
    public function setters_and_getters($role, $route)
    {
        $access = (new Permission())
                    ->setRole($role)
                    ->setRoute($route);

        $expected = [
            $role,
            $route,
        ];

        $actual = [
            $access->getRole(),
            $access->getRoute(),
        ];

        $this->assertEquals($expected, $actual);
    }

    public function sampleData()
    {
        return [
            ['Superadmin', 'api_post_show'],
            ['Admin', 'api_post_show'],
            ['Basic', 'api_post_show'],
            ['Superadmin', 'api_post_edit'],
            ['Admin', 'api_post_edit'],
        ];
    }
}
