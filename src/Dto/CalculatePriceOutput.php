<?php

namespace App\Dto;

use App\Enum\CouponTypesEnum;

final class CalculatePriceOutput
{
    public float $price;
    public int $taxRate;
    public float $finalPrice;
    public ?int $discountValue = null;
    public ?CouponTypesEnum $couponType = null;
}
