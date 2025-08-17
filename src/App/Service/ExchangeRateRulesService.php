<?php

namespace App\Service;

use App\DTO\ExchangeRateRulesDto;

class ExchangeRateRulesService
{
    /** @var ExchangeRateRulesDto[] */
    private array $rules;

    /**
     * @param array $rulesData
     */
    public function __construct(array $rulesData)
    {
        $this->rules = array_map(
            fn(array $rule) => new ExchangeRateRulesDto(
                $rule['code'],
                $rule['buy_offset'] ?? null,
                $rule['sell_offset'] ?? null
            ),
            $rulesData
        );
    }

    /**
     * @return ExchangeRateRulesDto[]
     */
    public function getRules(): array
    {
        return $this->rules;
    }
}