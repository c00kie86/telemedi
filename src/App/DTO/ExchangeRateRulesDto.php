<?php

namespace App\DTO;

class ExchangeRateRulesDto
{
    public function __construct(
        private string $code,
        private ?float $buyOffset,
        private ?float $sellOffset
    ) {}

    public function getCode(): string { return $this->code; }
    public function getBuyOffset(): ?float { return $this->buyOffset; }
    public function getSellOffset(): ?float { return $this->sellOffset; }
}