<?php

namespace Programarivm\EasyAclBundle\Tests\DataFixtures\Config;

use Programarivm\EasyAclBundle\Entity\Permission;
use Programarivm\EasyAclBundle\Tests\EasyAclTestCase;

class PermissionFixturesTest extends EasyAclTestCase
{
    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function load()
    {
        foreach (self::$easyAcl->getPermission() as $access) {
            foreach ($access['routes'] as $route) {
                self::$em->persist(
                    (new Permission())
                        ->setRolename($access['role'])
                        ->setRoutename($route)
                );
            }
        }

        self::$em->flush();
    }
}
