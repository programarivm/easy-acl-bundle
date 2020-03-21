<?php

namespace Programarivm\EasyAclBundle\Tests\DataFixtures;

use Programarivm\EasyAclBundle\Entity\Identity;
use Programarivm\EasyAclBundle\Tests\EasyAclTestCase;

class IdentityFixturesTest extends EasyAclTestCase
{
    /**
     * @test
     * @doesNotPerformAssertions
     * @dataProvider loadData
     */
    public function load($username, $rolename)
    {
        $user = self::$em->getRepository('App:User')->findOneBy(['username' => $username]);
        $role = self::$em->getRepository('EasyAclBundle:Role')->findOneBy(['name' => $rolename]);

        self::$em->persist(
            (new Identity())
                ->setUser($user)
                ->setRole($role)
        );

        self::$em->flush();
    }

    public function loadData()
    {
        return [
            ['alice', 'Superadmin'],
            ['bob', 'Admin'],
        ];
    }
}
