<?php

namespace App\Dto;

final class PurchaseInput
{
    /**
     * @var int
     */
    public int $product;
    /**
     * @var string|null
     */
    public ?string $couponCode = null;
    /**
     * @var string
     */
    public string $taxNumber;
    /**
     * @var string
     */
    public string $paymentProcessor;
}
