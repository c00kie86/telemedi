<?php

namespace App\DTO;

class NbpExchangeRateDto
{
    public function __construct(
        private string $code,
        private string $currency,
        private float $mid,
        private ?float $buy = null,
        private ?float $sell = null,
    ) {}

    public function getCode(): string { return $this->code; }
    public function getCurrencyRate(): string { return $this->currency; }
    public function getMid(): float { return $this->mid; }
    public function getBuy(): ?float { return $this->buy; }
    public function getSell(): ?float { return $this->sell; }
    public function hasBuy(): bool { return $this->buy !== null; }
    public function hasSell(): bool { return $this->sell !== null; }

    public function toArray(): array
    {
        return array_filter([
            'code'     => $this->code,
            'currency' => $this->currency,
            'mid'      => $this->mid,
            'buy'      => $this->buy,
            'sell'     => $this->sell,
        ], fn($value) => $value !== null);
    }
}