<?php

namespace App\Command;

use App\Service\NbpApiService;
use App\Service\ExchangeRateProcessService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FetchLatestCurrencyRatesCommand extends Command
{
    protected static $defaultName = 'nbp:fetch-latest-currency-rates';

    public function __construct(
        private readonly NbpApiService $nbpApiService,
        private readonly ExchangeRateProcessService $exchangeRateProcessService
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Pobiera aktualne kursy walut, przelicza i zapisuje do plików');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $tableDto = $this->nbpApiService->fetchTable('A');
        if (!$tableDto) {
            $output->writeln('Brak danych');
            return 1; // FAILURE
        }

        $this->exchangeRateProcessService->processAndSaveCurrencyRates($tableDto);
        $output->writeln('Dane pobrane, przeliczone i zapisane.');
        return 0; // SUCCESS
    }
}