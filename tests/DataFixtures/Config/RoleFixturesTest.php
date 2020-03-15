<?php

namespace Programarivm\EasyAclBundle\Tests\DataFixtures\Config;

use Programarivm\EasyAclBundle\Entity\Role;
use Programarivm\EasyAclBundle\Tests\DataFixturesTestCase;

class RoleFixturesTest extends DataFixturesTestCase
{
    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function load()
    {
        foreach (self::$easyAcl->getPermission() as $access) {
            self::$em->persist(
                (new Role())->setName($access['role'])
            );
        }

        self::$em->flush();
    }
}
