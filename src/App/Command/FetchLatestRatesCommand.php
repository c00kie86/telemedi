<?php

namespace App\Command;

use App\Service\NbpApiService;
use App\Service\ExchangeRateProcessService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FetchLatestRatesCommand extends Command
{
    protected static $defaultName = 'nbp:fetch-latest-rates';

    public function __construct(
        private readonly NbpApiService $nbpApiService,
        private readonly ExchangeRateProcessService $exchangeRateProcessService
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Pobiera aktualną tabele z kursami walut z NBP, przelicza i zapisuje do plików');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $tableDto = $this->nbpApiService->fetchTable('A', 'last');
        if (!$tableDto) {
            $output->writeln('Nie udało się pobrać danych z NBP dla dzisiejszej daty.');
            return 1; // FAILURE
        }
        
        $this->exchangeRateProcessService->processAndSaveLatestRates($tableDto);
        $output->writeln("Dane dla daty {$tableDto->getEffectiveDate()} zostały zapisane.");
        return 0; // SUCCESS
    }
}