<?php

namespace App\Controller\Api;

use App\Dto\CalculatePriceInput;
use App\Request\CalculatePriceRequest;
use App\Service\CalculatePriceScenario;
use App\Service\Exceptions\CalculatePriceException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\VarExporter\Hydrator;

final class PriceController extends AbstractController
{
    /**
     * @param CalculatePriceScenario $calculatePrice
     */
    public function __construct(private readonly CalculatePriceScenario $calculatePrice)
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/calculate-price', name: 'api_calculate_price', methods: 'POST')]
    public function calculate(Request $request): JsonResponse
    {
        $requestData = CalculatePriceRequest::fromHttpRequest($request);
        if(!$requestData->validate()) {
            return $this->json([
                'success' => false,
                'errors' => $requestData->getErrors()
            ], 422);
        } else {
            $dto = Hydrator::hydrate(new CalculatePriceInput(), [
                'product' => $requestData->product,
                'taxNumber' => $requestData->taxNumber,
                'couponCode' => $requestData->couponCode,
            ]);

            try {
                $resultData = $this->calculatePrice->handle($dto);
                return $this->json([
                    'success' => true,
                    'data' => $resultData
                ]);
            } catch (CalculatePriceException $e) {
                return $this->json([
                    'success' => false,
                    'errors' => $e->getMessage()
                ], 400);
            }
        }
    }
}
