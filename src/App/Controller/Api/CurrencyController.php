<?php
// src/Controller/Api/CurrencyController.php
namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

// /api/currency?code=usd
class CurrencyController extends AbstractController
{
    public function getCurrency(Request $request): JsonResponse
    {
        $code = strtolower($request->query->get('code'));

        if (!$code) {
            return $this->json(['error' => 'Brak parametru "?code=usd"'], 400);
        }

        $filePath = $this->getParameter('kernel.project_dir') . "/data/currency/{$code}.json";

        if (!file_exists($filePath)) {
            return $this->json(['error' => "Plik dla waluty '{$code}' nie istnieje"], 404);
        }

        $json = file_get_contents($filePath);
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return $this->json(['error' => 'Nieprawidłowy format JSON'], 500);
        }

        return $this->json($data);
    }
}