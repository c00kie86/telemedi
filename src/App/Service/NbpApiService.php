<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\DTO\NbpExchangeRateDto;
use App\DTO\NbpExchangeRateTableDto;
use App\DTO\NbpExchangeRateTableCollectionDto;


class NbpApiService
{
    public function __construct(
        private Client $client,
        private string $baseUrl
    ) {}

    public function fetchTable(string $tableType = 'A', ?string $date = null): ?NbpExchangeRateTableDto
    {
        $url = $this->baseUrl . "/tables/$tableType" . ($date ? "/$date" : '') . '?format=json';

        try {
            $response = $this->client->request('GET', $url);
            $body = $response->getBody()->getContents();
            $data = json_decode($body, true)[0] ?? null;

            if (!$data) {
                return null;
            }

            $rates = array_map(fn($rate) => new NbpExchangeRateDto(
                code: $rate['code'],
                currency: $rate['currency'],
                mid: $rate['mid']
            ), $data['rates']);

            return new NbpExchangeRateTableDto(
                table: $data['table'],
                no: $data['no'],
                effectiveDate: $data['effectiveDate'],
                rates: $rates
            );
        } catch (RequestException $e) {
            // $logger->error($e->getMessage());
            return null;
        }
    }

    public function fetchCurrencyRates(string $code, string $startDate, string $endDate): NbpExchangeRateTableCollectionDto
    {
        $url = $this->baseUrl . "/rates/A/$code/$startDate/$endDate?format=json";

        try {
            $response = $this->client->request('GET', $url);
            $body = $response->getBody()->getContents();
            $data = json_decode($body, true)['rates'] ?? [];

            $tables = array_map(fn($rate) => new NbpExchangeRateTableDto(
                table: 'A',
                no: '',
                effectiveDate: $rate['effectiveDate'],
                rates: [new NbpExchangeRateDto(
                    code: $code,
                    currency: '',
                    mid: $rate['mid']
                )]
            ), $data);

            return new NbpExchangeRateTableCollectionDto($tables);
        } catch (RequestException $e) {
            return new NbpExchangeRateTableCollectionDto([]);
        }
    }
}
