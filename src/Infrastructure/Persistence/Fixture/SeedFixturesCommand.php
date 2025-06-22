<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\Persistence\Fixture;

use Legends\Game\Infrastructure\Persistence\World\LocationRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('legends:seed-fixtures', 'Populates database with fixtures')]
final class SeedFixturesCommand extends Command
{
    public function __construct(
        private readonly LocationRepository $locationRepository,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $confirmation = $io->askQuestion(new ConfirmationQuestion(
            'This command will populate database with fixtures and can override existing ones. Proceed?',
            false,
        ));

        if ($confirmation === false) {
            $io->info('Terminated');

            return Command::SUCCESS;
        }

        $io->section('Seeding locations...');
        $progress = $io->createProgressBar(count($locationFixtures = LocationFixture::yield()));

        foreach ($locationFixtures as $locationFixture) {
            $this->locationRepository->persist($locationFixture);
            $progress->advance();
        }
        $progress->finish();

        $io->newLine(2);
        $io->success('Seeding completed');

        return Command::SUCCESS;
    }
}
