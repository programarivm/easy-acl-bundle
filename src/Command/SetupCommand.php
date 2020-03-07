<?php

namespace Programarivm\EasyAclBundle\Command;

use Programarivm\EasyAclBundle\EasyAcl;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SetupCommand extends Command
{
    private $easyAcl;

    protected static $defaultName = 'easy-acl:setup';

    public function __construct(EasyAcl $easyAcl)
    {
        $this->easyAcl = $easyAcl;

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

        // print_r($this->easyAcl->getRoles());

        return 0;
    }
}
