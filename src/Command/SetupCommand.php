<?php

namespace Programarivm\EasyAclBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class SetupCommand extends Command
{
    protected static $defaultName = 'easy-acl:setup';

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

        return 0;
    }
}
