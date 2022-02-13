<?php
declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class TestCommand extends Command
{
    protected function configure()
    {
        $this->setName('test');
    }

    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        echo "Hola Mundo";

        return self::SUCCESS;
    }
}
