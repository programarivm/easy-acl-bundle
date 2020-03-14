<?php

namespace Programarivm\EasyAclBundle\Tests\Entity;

use App\Entity\User;
use Programarivm\EasyAclBundle\Entity\ToBe;
use Programarivm\EasyAclBundle\Entity\Role;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ToBeTest extends WebTestCase
{
    /**
     * @dataProvider sampleData
     * @test
     */
    public function setters_and_getters($userData, $roleData)
    {
        $user = (new User())
                    ->setUsername($userData[0])
                    ->setEmail($userData[1])
                    ->setPassword($userData[2]);

        $role = (new Role())
                    ->setName($roleData);

        $toBe = (new ToBe())
                    ->setUser($user)
                    ->setRole($role);

        $expected = [
            $userData,
            $roleData,
        ];

        $actual = [
            [
                $toBe->getUser()->getUsername(),
                $toBe->getUser()->getEmail(),
                $toBe->getUser()->getPassword(),
            ],
                $toBe->getRole()->getName(),
        ];

        $this->assertEquals($expected, $actual);
    }

    public function sampleData()
    {
        return [
            [
                ['alice', 'alice@foo.bar', 'password'],
                'Superadmin',
            ],
            [
                ['bob', 'bob@foo.bar', 'password'],
                'Admin',
            ],
        ];
    }
}
