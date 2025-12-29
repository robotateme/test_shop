<?php

namespace App\Service\CalculatePriceStrategies;

use App\Dto\CalculatePriceOutput;
use App\Entity\Coupon;
use App\Entity\Product;
use App\Entity\Tax;
use App\Service\CalculatePriceStrategies\Contract\StrategyInterface;
use Symfony\Component\VarExporter\Hydrator;

class PercentStrategy implements StrategyInterface
{

    /**
     * @param Product $product
     * @param Tax|null $tax
     * @param Coupon|null $coupon
     * @return CalculatePriceOutput
     */
    public static function handle(Product $product, ?Tax $tax, ?Coupon $coupon): CalculatePriceOutput
    {
        $rateValue = $tax->getRate() / 100;
        $taxPrice = $product->getPrice() + ($product->getPrice() * $rateValue);
        $discountValue = $coupon->getValue() / 100;

        return Hydrator::hydrate(new CalculatePriceOutput(), [
            'price' => $product->getPrice(),
            'taxRate' => $tax->getRate(),
            'finalPrice' => $taxPrice - ($taxPrice * $discountValue),
            'discountValue' => $coupon->getValue(),
            'couponType' => $coupon->getType(),
        ]);
    }
}
