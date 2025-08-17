<?php

namespace App\Controller\Api;

use App\Service\NbpApiService;
use App\Service\ExchangeRateReadDataService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CurrencyController extends AbstractController
{
    public function __construct(
        private readonly ContainerBagInterface $params,
        private readonly NbpApiService $nbpApiService,
        private readonly ExchangeRateReadDataService $exchangeRateReadDataService
    ) {}

    public function getCurrencyRate(Request $request): JsonResponse
    {
        $code = strtolower(trim($request->query->get('code')));

        if (empty($code)) {
            return $this->json(['error' => 'Brak wymaganego parametru: code'], Response::HTTP_BAD_REQUEST);
        }

        try {
            $data = $this->exchangeRateReadDataService->getCurrencyByCode($code);
            
            if (null === $data) {
                return $this->json(['error' => "Plik dla waluty '{$code}' nie istnieje lub dane są niepoprawne"], Response::HTTP_NOT_FOUND);
            }

            return $this->json($data, Response::HTTP_OK);
        } catch (\InvalidArgumentException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Wystąpił błąd serwera.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getCurrencyRateTable(Request $request): JsonResponse
    {
        $code = strtoupper(trim($request->query->get('code')));
        $date = trim($request->query->get('date'));
        
        if (empty($code) || empty($date)) {
            return $this->json(['error' => 'Brak wymaganych parametrów: code i date'], Response::HTTP_BAD_REQUEST);
        }

        try {
            $rate = $this->exchangeRateReadDataService->getTabelByDate($date, $code);
            
            if (null === $rate) {
                return $this->json(['error' => "Brak danych dla waluty {$code} w dniu {$date}"], Response::HTTP_NOT_FOUND);
            }

            return $this->json($rate, Response::HTTP_OK);
        } catch (\InvalidArgumentException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Wystąpił błąd serwera.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}