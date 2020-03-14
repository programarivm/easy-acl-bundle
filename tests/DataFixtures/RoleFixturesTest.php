<?php

namespace Programarivm\EasyAclBundle\Tests\DataFixtures;

use Programarivm\EasyAclBundle\Entity\Role;

class RoleFixturesTest extends DataFixturesTestCase
{
    /**
     * @test
     */
    public function load()
    {
        foreach (self::$easyAcl->getPermission() as $access) {
            self::$em->persist(
                (new Role())->setName($access['role'])
            );
        }

        try {
            self::$em->flush();
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }

        $this->assertTrue(true);
    }
}
