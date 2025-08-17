<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use InvalidArgumentException;
use DateTime;

class ExchangeRateReadDataService
{
    public function __construct(
        private readonly ContainerBagInterface $params
    ) {}

    public function getCurrencyByCode(string $code): ?array
    {
        $projectDir = $this->params->get('kernel.project_dir');
        $filePath = "{$projectDir}/data/currency/{$code}.json";

        if (!is_file($filePath)) {
            return null;
        }

        $jsonData = file_get_contents($filePath);
        $data = json_decode($jsonData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException("Nieprawidłowy format JSON w pliku '{$filePath}'.");
        }

        return $data;
    }

    public function getTabelByDate(string $date, string $code): ?array
    {
        $projectDir = $this->params->get('kernel.project_dir');
        $filePath = "{$projectDir}/data/date/{$date}.json";
        
        if (!is_file($filePath)) {
            return null;
        }

        $jsonData = file_get_contents($filePath);
        $data = json_decode($jsonData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException("Nieprawidłowy format JSON w pliku '{$filePath}'.");
        }

        $foundRate = array_filter($data['rates'], fn($rate) => $rate['code'] === $code);

        if ($foundRate) {
            $rateData = reset($foundRate);
            $rateData['effectiveDate'] = $data['effectiveDate'];
            return $rateData;
        }

        return null;
    }
}