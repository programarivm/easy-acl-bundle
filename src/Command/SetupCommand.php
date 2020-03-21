<?php

namespace Programarivm\EasyAclBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Programarivm\EasyAclBundle\EasyAcl;
use Programarivm\EasyAclBundle\Entity\Permission;
use Programarivm\EasyAclBundle\Entity\Role;
use Programarivm\EasyAclBundle\Entity\Route;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
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
            ->setHelp('This command sets up the access control list.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion(
            'This will reset the ACL. Are you sure to continue? (y) ',
            false,
            '/^(y)/i'
        );

        if (!$helper->ask($input, $output, $question)) {
            return 0;
        }

        $this->em->getRepository('EasyAclBundle:Identity')->deleteAll();
        $this->em->getRepository('EasyAclBundle:Permission')->deleteAll();
        $this->em->getRepository('EasyAclBundle:Role')->deleteAll();
        $this->em->getRepository('EasyAclBundle:Route')->deleteAll();

        foreach ($this->routes as $name => $item) {
            $this->em->persist(
                (new Route())
                    ->setName($name)
                    ->setMethods($item['methods'])
                    ->setPath($item['path'])
            );
        }

        foreach ($this->easyAcl->getPermission() as $access) {
            $this->em->persist(
                (new Role())->setName($access['role'])
            );
            foreach ($access['routes'] as $route) {
                $this->em->persist(
                    (new Permission())
                        ->setRolename($access['role'])
                        ->setRoutename($route)
                );
            }
        }

        $this->em->flush();

        return 0;
    }
}
