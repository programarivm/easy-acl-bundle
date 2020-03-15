<?php

namespace Programarivm\EasyAclBundle\Tests\Repository;

use Programarivm\EasyAclBundle\Tests\RepositoryTestCase;

class PermissionTest extends RepositoryTestCase
{
    /**
     * @test
     */
    public function is_not_allowed()
    {
        $isAllowed = self::$em->getRepository('EasyAclBundle:Permission')->isAllowed('foo', 'bar');

        $this->assertFalse($isAllowed);
    }

    /**
     * @test
     */
    public function is_allowed()
    {
        $isAllowed = self::$em->getRepository('EasyAclBundle:Permission')->isAllowed('Superadmin', 'api_post_show');

        $this->assertTrue($isAllowed);
    }

    /**
     * @test
     */
    public function identities()
    {
        $users = self::$em->getRepository('App:User')->findAll();
        $identities = self::$em->getRepository('EasyAclBundle:Identity')->findAll();

        foreach ($users as $user) {
            foreach ($identities as $identity) {
                $isAllowed = self::$em->getRepository('EasyAclBundle:Permission')->isAllowed(
                    $identity->getRole()->getName(),
                    'api_post_show'
                );
                $this->assertTrue($isAllowed);
            }
        }
    }
}
