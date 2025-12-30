<?php

namespace App\Controller\Api;

use App\Dto\PurchaseInput;
use App\Request\PurchaseRequest;
use App\Service\CalculatePriceScenario;
use App\Service\Exceptions\CalculatePriceException;
use App\Service\Exceptions\PurchaseException;
use App\Service\PurchaseScenario;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\VarExporter\Hydrator;

final class PurchaseController extends AbstractController
{
    public function __construct(
        private CalculatePriceScenario $calculatePriceScenario,
        private PurchaseScenario $purchaseScenario,
    )
    {
    }

    #[Route('/purchase', name: 'api_purchase', methods: 'POST')]
    public function index(Request $request): JsonResponse
    {
        $requestData = PurchaseRequest::fromHttpRequest($request);
        if(!$requestData->validate()) {
            return $this->json([
                'success' => false,
                'errors' => $requestData->getErrors()
            ], 422);
        } else {
            $dto = Hydrator::hydrate(new PurchaseInput(), [
                'product' => $requestData->product,
                'taxNumber' => $requestData->taxNumber,
                'couponCode' => $requestData->couponCode,
                'paymentProcessor' => $requestData->paymentProcessor,
            ]);

            try {
                $resultDto = $this->calculatePriceScenario->handle($dto);
                return $this->json([
                    'success' => $this->purchaseScenario->handle($resultDto, $requestData->paymentProcessor),
                ]);
            } catch (CalculatePriceException|PurchaseException $exception) {
                return $this->json([
                    'success' => false,
                    'errors' => $exception->getMessage()
                ]);
            }
        }
    }
}
