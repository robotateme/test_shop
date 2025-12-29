<?php

namespace App\Service\CalculatePriceStrategies\Contract;

use App\Entity\Coupon;
use App\Entity\Product;
use App\Entity\Tax;

interface StrategyInterface
{
    public static function handle(Product $product, ?Tax $tax, ?Coupon $coupon);

}
