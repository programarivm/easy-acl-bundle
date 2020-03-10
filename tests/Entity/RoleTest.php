<?php

namespace Programarivm\EasyAclBundle\Tests\Entity;

use Programarivm\EasyAclBundle\Entity\Role;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RoleTest extends WebTestCase
{
    /**
     * @dataProvider sampleData
     * @test
     */
    public function setters_and_getters($name)
    {
        $role = (new Role())->setName($name);

        $this->assertEquals($name, $role->getName());
    }

    public function sampleData()
    {
        return [
            ['Superadmin'],
            ['Admin'],
            ['Basic'],
        ];
    }
}
