<?php

namespace Programarivm\EasyAclBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BootstrapTest extends EasyAclTestCase
{
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        self::$em->getRepository('EasyAclBundle:Identity')->deleteAll();
        self::$em->getRepository('EasyAclBundle:Permission')->deleteAll();
        self::$em->getRepository('EasyAclBundle:Role')->deleteAll();
        self::$em->getRepository('EasyAclBundle:Route')->deleteAll();
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function do_nothing()
    {
    }
}
