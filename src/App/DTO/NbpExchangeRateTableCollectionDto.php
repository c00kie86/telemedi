<?php

namespace App\DTO;

class NbpExchangeRateTableCollectionDto
{
    /** @var NbpExchangeRateTableDto[] */
    private array $tables;

    public function __construct(array $tables)
    {
        $this->tables = $tables;
    }

    public function getTables(): array { return $this->tables; }
    public function getLatest(): ?NbpExchangeRateTableDto { return $this->tables[0] ?? null; }
}