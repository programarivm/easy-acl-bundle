<?php

namespace Programarivm\EasyAclBundle\Tests\Entity;

use Programarivm\EasyAclBundle\EasyAcl;
use Programarivm\EasyAclBundle\Entity\Route;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RouteTest extends WebTestCase
{
    private static $easyAcl;

    public static function setUpBeforeClass()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        self::$container = $kernel->getContainer();

        self::$easyAcl = self::$container->get('programarivm.easy_acl');
    }

    /**
     * @dataProvider sampleData
     * @test
     */
    public function setters_and_getters($name, $method, $path)
    {
        foreach (self::$easyAcl->getRoutes() as $item) {
            $route = (new Route())
                        ->setName($name)
                        ->setMethod($method)
                        ->setPath($path);

            $expected = [
                $name,
                $method,
                $path,
            ];

            $actual = [
                $route->getName(),
                $route->getMethod(),
                $route->getPath(),
            ];

            $this->assertEquals($expected, $actual);
        }
    }

    public function sampleData()
    {
        return [
            ['homepage', 'ANY', '/'],
            ['contact', 'GET', '/contact'],
            ['contact_process', 'POST', '/contact'],
            ['article_show', 'ANY', '/articles/{_locale}/{year}/{title}.{_format}'],
            ['blog', 'ANY', '/blog/{page}'],
            ['blog_show', 'ANY', '/blog/{slug}'],
        ];
    }
}
