<?php

namespace Programarivm\EasyAclBundle\Tests\DataFixtures;

use Programarivm\EasyAclBundle\Entity\Identity;

class IdentityFixturesTest extends DataFixturesTestCase
{
    /**
     * @test
     */
    public function load()
    {
        $users = self::$em->getRepository('App:User')->findAll();
        $roles = self::$em->getRepository('EasyAclBundle:Role')->findAll();

        foreach ($users as $user) {
            foreach ($roles as $role) {
                self::$em->persist(
                    (new Identity())
                        ->setUser($user)
                        ->setRole($role)
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
