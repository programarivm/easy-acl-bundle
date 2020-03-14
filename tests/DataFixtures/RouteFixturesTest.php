<?php

namespace Programarivm\EasyAclBundle\Tests\DataFixtures;

use Programarivm\EasyAclBundle\Entity\Route;

class RouteFixturesTest extends DataFixturesTestCase
{
    /**
     * @test
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

        try {
            self::$em->flush();
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }

        $this->assertTrue(true);
    }
}
