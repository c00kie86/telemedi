<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SetupCheckController extends AbstractController
{
    public function setupCheck(Request $request): JsonResponse
    {
        $testParam = $request->get('testParam');
        
        $responseContent = [
            'testParam' => $testParam !== null ? (int) $testParam : null
        ];

        return $this->json($responseContent, Response::HTTP_OK);
    }
}