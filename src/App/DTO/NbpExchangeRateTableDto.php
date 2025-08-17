<?php

namespace App\DTO;

class NbpExchangeRateTableDto
{
    public function __construct(
        private string $table,
        private string $no,
        private string $effectiveDate,
        /** @var NbpExchangeRateDto[] */
        private array $rates
    ) {}

    public function getTable(): string { return $this->table; }
    public function getNo(): string { return $this->no; }
    public function getEffectiveDate(): string { return $this->effectiveDate; }
    public function getRates(): array { return $this->rates; }
}