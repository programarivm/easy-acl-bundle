<?php

namespace Programarivm\EasyAclBundle\Tests\DataFixtures;

use Programarivm\EasyAclBundle\Entity\Permission;

class PermissionFixturesTest extends DataFixturesTestCase
{
    /**
     * @test
     */
    public function load()
    {
        foreach (self::$easyAcl->getPermission() as $access) {
            foreach ($access['routes'] as $route) {
                self::$em->persist(
                    (new Permission())
                        ->setRole($access['role'])
                        ->setRoute($route)
                );
            }
        }

        try {
            self::$em->flush();
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }

        $this->assertTrue(true);
    }
}
