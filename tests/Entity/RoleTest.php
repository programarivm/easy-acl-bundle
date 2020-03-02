<?php

namespace Programarivm\EasyAclBundle\Tests\Entity;

use Programarivm\EasyAclBundle\Entity\Role;
use PHPUnit\Framework\TestCase;

class RoleTest extends TestCase
{
    /**
     * @test
     */
    public function choices()
    {
        $expected = [
            Role::TYPE_ADMIN,
            Role::TYPE_BASIC,
            Role::TYPE_SUPERADMIN,
        ];

        $actual = Role::getChoices()->type;

        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider sampleData
     * @test
     */
    public function setters_and_getters($type)
    {
        $role = (new Role())->setType($type);

        $expected = [
            $type,
        ];

        $actual = [
            $role->getType(),
        ];

        $this->assertEquals($expected, $actual);
    }

    public function sampleData()
    {
        return [
            [Role::TYPE_ADMIN],
            [Role::TYPE_BASIC],
            [Role::TYPE_SUPERADMIN],
        ];
    }
}
