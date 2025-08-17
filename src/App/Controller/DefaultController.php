<?php

namespace App\Controller;

use App\Service\ExchangeRateRulesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    public function __construct(
        private readonly ExchangeRateRulesService $exchangeRateRulesService
    ) {}

    public function index(): Response
    {
        $rules = $this->exchangeRateRulesService->getRules();
        $currencyCodes = array_map(fn($rule) => $rule->getCode(), $rules);

        return $this->render(
            'app-root.html.twig',
            ['currency_codes' => json_encode($currencyCodes)]
        );
    }
}