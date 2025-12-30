<?php

namespace App\Service\CalculatePriceStrategies;

use App\Dto\CalculatePriceOutput;
use App\Entity\Coupon;
use App\Entity\Product;
use App\Entity\Tax;
use App\Service\CalculatePriceStrategies\Contract\StrategyInterface;
use App\Service\Exceptions\CalculatePriceException;
use Symfony\Component\VarExporter\Hydrator;

class FixedStrategy implements StrategyInterface
{
    /**
     * @param Product $product
     * @param Tax|null $tax
     * @param Coupon|null $coupon
     * @return CalculatePriceOutput
     * @throws CalculatePriceException
     */
    public static function handle(Product $product, ?Tax $tax, ?Coupon $coupon): CalculatePriceOutput
    {
        $rateValue = ($tax->getRate() / 100);
        $taxPrice = $product->getPrice() + ($product->getPrice() * $rateValue);
        $finalPrice = $taxPrice - $coupon->getValue();

        if ($finalPrice <= 0) {
            throw new CalculatePriceException("The price of the item is less than or equal to zero.");
        }

        return Hydrator::hydrate(new CalculatePriceOutput(), [
            'price' => $product->getPrice(),
            'taxRate' => $tax->getRate(),
            'finalPrice' => $finalPrice,
            'discountValue' => $coupon->getValue(),
            'couponType' => $coupon->getType(),
        ]);
    }
}
