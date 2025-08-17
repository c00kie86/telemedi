<?php

namespace App\Command;

use App\Service\NbpApiService;
use App\Service\ExchangeRateWriteDataService;
use App\Service\ExchangeRateProcessService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FetchRateByDateCommand extends Command
{
    protected static $defaultName = 'nbp:fetch-rate-by-date';

    public function __construct(
        private readonly NbpApiService $nbpApiService,
        private readonly ExchangeRateProcessService $exchangeRateProcessService,
        private readonly ExchangeRateWriteDataService $exchangeRateWriteDataService
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Pobiera tabele z kursami z danego dnia, przelicza i zapisuje do pliku [tabela, ścieżka, data]')
            ->addArgument('table', InputArgument::REQUIRED, 'Tabela NBP (A, B, C)')
            ->addArgument('filePath', InputArgument::REQUIRED, 'Ścieżka do pliku')
            ->addArgument('date', InputArgument::OPTIONAL, 'Data (YYYY-MM-DD)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $table = $input->getArgument('table');
        $filePath = $input->getArgument('filePath');
        $date = $input->getArgument('date');

        $tableDto = $this->nbpApiService->fetchTable($table, $date);
        if (!$tableDto) {
            $output->writeln('Brak danych');
            return 1; // FAILURE
        }
        
        $calculatedTableDto = $this->exchangeRateProcessService->processRates($tableDto);
        
        $this->exchangeRateWriteDataService->saveToFile($calculatedTableDto, $filePath);
        $output->writeln("Dane pobrane, przeliczone i zapisane do pliku: $filePath");

        return 0; // SUCCESS
    }
}