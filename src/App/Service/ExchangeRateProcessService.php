<?php

namespace App\Service;

use App\DTO\NbpExchangeRateTableDto;
use App\DTO\NbpExchangeRateDto;

class ExchangeRateProcessService
{
    public function __construct(
        private readonly ExchangeRateRulesService $exchangeRateRulesService,
        private readonly ExchangeRateCalculatorService $exchangeRateCalculatorService,
        private readonly ExchangeRateWriteDataService $exchangeRateWriteDataService
    ) {}

    /**
     * Przetwarza dane z NBP i zwraca DTO z przeliczonymi kursami.
     */
    public function processRates(NbpExchangeRateTableDto $tableDto): NbpExchangeRateTableDto
    {
        $rules = $this->exchangeRateRulesService->getRules();
        $calculatedRates = [];

        foreach ($tableDto->getRates() as $rate) {
            $rule = current(array_filter($rules, fn($r) => $r->getCode() === $rate->getCode()));
            
            if ($rule) {
                $calculatedRates[] = $this->exchangeRateCalculatorService->calculateRate(
                    $rule,
                    $rate->getCurrencyRate(),
                    $rate->getMid()
                );
            } else {
                $calculatedRates[] = $rate;
            }
        }

        return new NbpExchangeRateTableDto(
            table: $tableDto->getTable(),
            no: $tableDto->getNo(),
            effectiveDate: $tableDto->getEffectiveDate(),
            rates: $calculatedRates
        );
    }

    /**
     * Przetwarza i zapisuje najnowszą tabelę kursów.
     */
    public function processAndSaveLatestRates(NbpExchangeRateTableDto $tableDto): void
    {
        $calculatedTableDto = $this->processRates($tableDto);
        $this->exchangeRateWriteDataService->saveTableToFile($calculatedTableDto);
    }

    /**
     * Przetwarza i zapisuje pojedyncze kursy walut do plików.
     */
    public function processAndSaveCurrencyRates(NbpExchangeRateTableDto $tableDto): void
    {
        $calculatedRates = $this->processRates($tableDto)->getRates();
        foreach ($calculatedRates as $rate) {
            $filename = sprintf('data/currency/%s.json', strtolower($rate->getCode()));
            $this->exchangeRateWriteDataService->saveSingleRateToFile($rate, $filename);
        }
    }
}
