<?php

namespace Programarivm\EasyAclBundle\Tests\DataFixtures;

use Programarivm\EasyAclBundle\Entity\Identity;
use Programarivm\EasyAclBundle\Tests\DataFixturesTestCase;

class IdentityFixturesTest extends DataFixturesTestCase
{
    /**
     * @test
     * @doesNotPerformAssertions
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

        self::$em->flush();
    }
}
