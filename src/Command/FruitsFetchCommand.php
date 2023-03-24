<?php

namespace App\Command;

use App\Service\FruitsManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'fruits:fetch',
    description: 'Command to fetch fruits from fruityvice.com',
)]
class FruitsFetchCommand extends Command
{
    public function __construct(private readonly FruitsManager $fruitsManager)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->fruitsManager->fetchAndStore();

        $io->success('Completed.');

        return Command::SUCCESS;
    }
}
