<?php

namespace App\Service;

use App\DTO\NbpExchangeRateDto;
use App\DTO\NbpExchangeRateTableDto;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class ExchangeRateWriteDataService
{

    public function __construct(
        private readonly ContainerBagInterface $params
    ) {}

    public function saveCurrencyRateToFile(NbpExchangeRateDto $rate, string $filePath): void
    {
        $this->saveDataToFile($rate->toArray(), $filePath);
    }

    public function saveToFile(NbpExchangeRateTableDto $table, string $filePath): void
    {
        $data = [
            'table' => $table->getTable(),
            'no' => $table->getNo(),
            'effectiveDate' => $table->getEffectiveDate(),
            'rates' => array_map(fn($rate) => $rate->toArray(), $table->getRates())
        ];

        $this->saveDataToFile($data, $filePath);
    }

    public function saveTableToFile(NbpExchangeRateTableDto $table): void
    {
        $projectDir = $this->params->get('kernel.project_dir');
        $date = $table->getEffectiveDate();
        $filePath = "{$projectDir}/data/date/{$date}.json";
        
        $data = [
            'table' => $table->getTable(),
            'no' => $table->getNo(),
            'effectiveDate' => $table->getEffectiveDate(),
            'rates' => array_map(fn($rate) => $rate->toArray(), $table->getRates())
        ];

        $this->saveDataToFile($data, $filePath);
    }

    private function saveDataToFile(array $data, string $filePath): void
    {
        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        
        $dir = dirname($filePath);
        if (!is_dir($dir)) {
            mkdir($dir, recursive: true);
        }

        file_put_contents($filePath, $json);
    }
}