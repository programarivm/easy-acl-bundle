<?php

namespace Programarivm\EasyAclBundle\Tests\DataFixtures;

use Programarivm\EasyAclBundle\EasyAcl;
use Programarivm\EasyAclBundle\Entity\Permission;
use Programarivm\EasyAclBundle\Entity\Role;
use Programarivm\EasyAclBundle\Entity\Route;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Yaml\Yaml;

class EasyAclFixturesTest extends WebTestCase
{
    private static $easyAcl;

    private static $em;

    private static $routes;

    public function __construct()
    {
        if ($_ENV['APP_ENV'] !== 'test') {
            throw new \DomainException('Whoops! The data fixtures can only be loaded in a testing environment.');
        }

        parent::__construct();
    }

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
        self::$em->getRepository('EasyAclBundle:Permission')->deleteAll();
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

        foreach (self::$easyAcl->getPermission() as $access) {
            self::$em->persist(
                (new Role())->setName($access['role'])
            );
            foreach ($access['routes'] as $route) {
                self::$em->persist(
                    (new Permission())
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

    /**
     * @test
     * @depends load
     */
    public function is_not_allowed()
    {
        $isAllowed = self::$em->getRepository('EasyAclBundle:Permission')->isAllowed('foo', 'bar');

        $this->assertFalse($isAllowed);
    }

    /**
     * @test
     * @depends load
     */
    public function is_allowed()
    {
        $isAllowed = self::$em->getRepository('EasyAclBundle:Permission')->isAllowed('Superadmin', 'api_post_show');

        $this->assertTrue($isAllowed);
    }
}
