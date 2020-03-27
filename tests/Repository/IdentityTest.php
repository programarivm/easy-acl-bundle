<?php

namespace Programarivm\EasyAclBundle\Tests\Repository;

use Programarivm\EasyAclBundle\Tests\EasyAclTestCase;

class IdentityTest extends EasyAclTestCase
{
    /**
     * @test
     * @dataProvider isAllowedData
     */
    public function is_allowed($username, $routename)
    {
        $user = self::$em
                    ->getRepository('App:User')
                    ->findOneBy(['username' => $username]);

        $isAllowed = self::$em
                    ->getRepository('EasyAclBundle:Identity')
                    ->isAllowed($user, $routename);

        $this->assertTrue($isAllowed);
    }

    /**
     * @test
     * @dataProvider isNotAllowedData
     */
    public function is_not_allowed($username, $routename)
    {
        $user = self::$em
                    ->getRepository('App:User')
                    ->findOneBy(['username' => $username]);

        $isAllowed = self::$em
                    ->getRepository('EasyAclBundle:Identity')
                    ->isAllowed($user, $routename);

        $this->assertFalse($isAllowed);
    }

    public function isAllowedData()
    {
        return [
            ['alice', 'api_post_create'],
            ['alice', 'api_post_delete'],
            ['alice', 'api_post_edit'],
            ['bob', 'api_post_create'],
            ['bob', 'api_post_edit'],
        ];
    }

    public function isNotAllowedData()
    {
        return [
            ['foo', 'bar'],
            ['foobar', 'foo'],
            ['alice', 'foo'],
            ['bob', 'foo'],
            ['foo', 'api_post_show'],
            ['bar', 'api_post_edit'],
            ['bob', 'api_post_delete'],
        ];
    }
}
