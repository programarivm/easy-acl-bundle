<?php

namespace Programarivm\EasyAclBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Programarivm\EasyAclBundle\EasyAcl;
use Programarivm\EasyAclBundle\Entity\Role;
use Programarivm\EasyAclBundle\Entity\Route;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class SetupCommand extends Command
{
    private $easyAcl;

    private $em;

    private $projectDir;

    private $routes;

    protected static $defaultName = 'easy-acl:setup';

    public function __construct(string $projectDir, EasyAcl $easyAcl, EntityManagerInterface $em)
    {
        $this->easyAcl = $easyAcl;
        $this->em = $em;
        $this->projectDir = $projectDir;
        $this->routes = Yaml::parseFile("{$this->projectDir}/config/routes.yaml");

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('EasyACL setup.')
            ->setHelp('This command sets up the ACL.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'ACL setup',
            '=========',
            '',
        ]);

        $output->writeln('Hi there!');

        foreach ($this->easyAcl->getRoles() as $item) {
            $role = (new Role())
                        ->setName($item['name'])
                        ->setHierarchy($item['hierarchy']);

            $this->em->persist($role);
        }

        foreach ($this->routes as $key => $val) {
            $route = (new Route())
                        ->setName($key)
                        ->setMethods($val['methods'])
                        ->setPath($val['path']);

            $this->em->persist($route);
        }

        $this->em->flush();

        // TODO ...

        return 0;
    }
}
