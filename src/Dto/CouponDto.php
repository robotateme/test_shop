<?php

namespace App\Dto;

use App\Enum\CouponTypesEnum;

class CouponDto
{
    public function __construct(public string $code, public int $value, public CouponTypesEnum $type)
    {
    }
}
