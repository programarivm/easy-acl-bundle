<?php

namespace Programarivm\EasyAclBundle\Tests\DataFixtures;

use Programarivm\EasyAclBundle\EasyAcl;
use Programarivm\EasyAclBundle\Entity\Access;
use Programarivm\EasyAclBundle\Entity\Role;
use Programarivm\EasyAclBundle\Entity\Route;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Yaml\Yaml;

class EasyAclTest extends WebTestCase
{
    private static $easyAcl;

    private static $em;

    private static $routes;

    public static function setUpBeforeClass()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        self::$container = $kernel->getContainer();

        self::$easyAcl = self::$container->get('programarivm.easy_acl');
        self::$em = self::$container->get('doctrine.orm.entity_manager');
        self::$routes = Yaml::parseFile("{$kernel->getProjectDir()}/config/routes.yaml");
    }

    public static function tearDownAfterClass()
    {
        self::$em->getRepository('EasyAclBundle:Access')->deleteAll();
        self::$em->getRepository('EasyAclBundle:Role')->deleteAll();
        self::$em->getRepository('EasyAclBundle:Route')->deleteAll();
    }

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

        foreach (self::$easyAcl->getAccess() as $access) {
            self::$em->persist(
                (new Role())->setName($access['role'])
            );
            foreach ($access['routes'] as $route) {
                self::$em->persist(
                    (new Access())
                        ->setRole($access['role'])
                        ->setRoute($route)
                );
            }
        }

        try {
            self::$em->flush();
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }

        $this->assertTrue(true);
    }
}
