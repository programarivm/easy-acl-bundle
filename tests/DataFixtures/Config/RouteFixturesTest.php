<?php

namespace Programarivm\EasyAclBundle\Tests\DataFixtures\Config;

use Programarivm\EasyAclBundle\Entity\Route;
use Programarivm\EasyAclBundle\Tests\DataFixturesTestCase;

class RouteFixturesTest extends DataFixturesTestCase
{
    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function load()
    {
        foreach (self::$routes as $name => $item) {
            self::$em->persist(
                (new Route())
                    ->setName($name)
                    ->setMethods($item['methods'])
                    ->setPath($item['path'])
            );
        }

        self::$em->flush();
    }
}
