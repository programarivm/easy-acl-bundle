<?php

namespace Programarivm\EasyAclBundle\Tests\DataFixtures;

use App\Entity\User;
use Programarivm\EasyAclBundle\EasyAcl;
use Programarivm\EasyAclBundle\Entity\Identity;
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

    public static function setUpBeforeClass()
    {
        if ($_ENV['APP_ENV'] !== 'test') {
            throw new \DomainException('Whoops! The data fixtures can only be loaded in a testing environment.');
        }

        $kernel = static::createKernel();
        $kernel->boot();

        self::$container = $kernel->getContainer();

        self::$easyAcl = self::$container->get('programarivm.easy_acl');
        self::$em = self::$container->get('doctrine.orm.entity_manager');
        self::$routes = Yaml::parseFile("{$kernel->getProjectDir()}/config/routes.yaml");
    }

    public static function tearDownAfterClass()
    {
        self::$em->getRepository('EasyAclBundle:Identity')->deleteAll();
        self::$em->getRepository('EasyAclBundle:Permission')->deleteAll();
        self::$em->getRepository('EasyAclBundle:Role')->deleteAll();
        self::$em->getRepository('EasyAclBundle:Route')->deleteAll();

        self::$em->getRepository('App:User')->deleteAll();
    }

    /**
     * @dataProvider userData
     * @test
     */
    public function load_user($username, $email, $password)
    {
        self::$em->persist(
            (new User())
                ->setUsername($username)
                ->setEmail($email)
                ->setPassword($password)
        );

        try {
            self::$em->flush();
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }

        $this->assertTrue(true);
    }

    /**
     * @test
     * @depends load_user
     */
    public function load_permission()
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
     * @depends load_permission
     */
    public function load_identity()
    {
        $users = self::$em->getRepository('App:User')->findAll();
        $roles = self::$em->getRepository('EasyAclBundle:Role')->findAll();

        foreach ($users as $user) {
            foreach ($roles as $role) {
                self::$em->persist(
                    (new Identity())
                        ->setUser($user)
                        ->setRole($role)
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
     * @depends load_permission
     */
    public function permission_is_not_allowed()
    {
        $isAllowed = self::$em->getRepository('EasyAclBundle:Permission')->isAllowed('foo', 'bar');

        $this->assertFalse($isAllowed);
    }

    /**
     * @test
     * @depends load_permission
     */
    public function permission_is_allowed()
    {
        $isAllowed = self::$em->getRepository('EasyAclBundle:Permission')->isAllowed('Superadmin', 'api_post_show');

        $this->assertTrue($isAllowed);
    }

    /**
     * @test
     * @depends load_identity
     */
    public function permission_identities()
    {
        $user = self::$em->getRepository('App:User')->findOneBy(['username' => 'alice']);
        $identities = self::$em->getRepository('EasyAclBundle:Identity')->findBy(['user' => $user]);

        foreach ($identities as $identity) {
            $isAllowed = self::$em->getRepository('EasyAclBundle:Permission')->isAllowed(
                $identity->getRole()->getName(),
                'api_post_show'
            );
            $this->assertTrue($isAllowed);
        }
    }

    public function userData()
    {
        return [
            ['alice', 'alice@foo.bar', 'password'],
            ['bob', 'bob@foo.bar', 'password'],
        ];
    }
}
