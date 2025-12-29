<?php

namespace App\Dto;

final class CalculatePriceInput
{
    /**
     * @var int|null
     */
    public ?int $product;
    /**
     * @var string|null
     */
    public ?string $couponCode = null;
    /**
     * @var string
     */
    public string $taxNumber;
}
