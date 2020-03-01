<?php

namespace Programarivm\EasyAclBundle\Command;

use Programarivm\EasyAclBundle\HelloWorld;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GreetCommand extends Command
{
    private $helloWorld;

    protected static $defaultName = 'easy-acl:greet';

    public function __construct(HelloWorld $helloWorld)
    {
        $this->helloWorld = $helloWorld;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Greet someone.')
            ->setHelp('This command allows you to greet someone...')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Greeting command',
            '================',
            '',
        ]);

        $output->writeln($this->helloWorld->signal());

        return 0;
    }
}
