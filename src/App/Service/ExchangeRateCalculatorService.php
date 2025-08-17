<?php

namespace App\Service;

use App\DTO\ExchangeRateRulesDto;
use App\DTO\NbpExchangeRateDto;

class ExchangeRateCalculatorService
{
    public function calculateRate(ExchangeRateRulesDto $rule, string $currency, float $mid): NbpExchangeRateDto
    {
        $buy = $rule->getBuyOffset() !== null ? round($mid - $rule->getBuyOffset(), 2) : null;
        $sell = $rule->getSellOffset() !== null ? round($mid + $rule->getSellOffset(), 2) : null;

        return new NbpExchangeRateDto(
            code: $rule->getCode(),
            currency: $currency,
            mid: $mid,
            buy: $buy,
            sell: $sell
        );
    }
}