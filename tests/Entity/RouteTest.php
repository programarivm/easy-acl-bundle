<?php

namespace Programarivm\EasyAclBundle\Tests\Entity;

use Programarivm\EasyAclBundle\Entity\Route;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RouteTest extends WebTestCase
{
    /**
     * @dataProvider sampleData
     * @test
     */
    public function setters_and_getters($name, $methods, $path)
    {
        $route = (new Route())
                    ->setName($name)
                    ->setMethods($methods)
                    ->setPath($path);

        $expected = [
            $name,
            $methods,
            $path,
        ];

        $actual = [
            $route->getName(),
            $route->getMethods(),
            $route->getPath(),
        ];

        $this->assertEquals($expected, $actual);
    }

    public function sampleData()
    {
        return [
            ['api_post_show', 'GET|HEAD', '/api/posts/{id}'],
            ['api_post_edit', 'PUT', '/api/posts/{id}'],
        ];
    }
}
