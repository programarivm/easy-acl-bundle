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
    public function setters_and_getters($name, $hierarchy)
    {
        $role = (new Role())
                    ->setName($name)
                    ->setHierarchy($hierarchy);

        $expected = [
            $name,
            $hierarchy,
        ];

        $actual = [
            $role->getName(),
            $role->getHierarchy(),
        ];

        $this->assertEquals($expected, $actual);
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
