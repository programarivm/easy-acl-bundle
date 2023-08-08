<?php

namespace Programarivm\EasyAclBundle\Tests\Repository;

use Programarivm\EasyAclBundle\Tests\EasyAclTestCase;

class PermissionTest extends EasyAclTestCase
{
    /**
     * @test
     * @dataProvider isAllowedData
     */
    public function is_allowed($rolename, $routename)
    {
        $isAllowed = self::$em
                        ->getRepository('EasyAclBundle:Permission')
                        ->isAllowed($rolename, $routename);

        $this->assertTrue($isAllowed);
    }

    /**
     * @test
     * @dataProvider isNotAllowedData
     */
    public function is_not_allowed($rolename, $routename)
    {
        $isAllowed = self::$em
                        ->getRepository('EasyAclBundle:Permission')
                        ->isAllowed($rolename, $routename);

        $this->assertFalse($isAllowed);
    }

    public function isAllowedData()
    {
        return [
            ['Superadmin', 'api_post_create'],
            ['Superadmin', 'api_post_delete'],
            ['Superadmin', 'api_post_edit'],
            ['Admin', 'api_post_create'],
            ['Admin', 'api_post_edit'],
            ['Basic', 'api_post_create'],
        ];
    }

    public function isNotAllowedData()
    {
        return [
            ['foo', 'bar'],
            ['foobar', 'foo'],
        ];
    }
}
