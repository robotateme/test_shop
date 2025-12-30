<?php

namespace App\Request;

use App\Enum\PaymentProcessorsEnum;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as CustomAssert;

class PurchaseRequest extends Contract\AbstractRequest
{

    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    #[Assert\Positive]
    public ?int $product = null;

    #[Assert\Type('string')]
    public ?string $couponCode;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[CustomAssert\TaxNumber]
    public ?string $taxNumber = null;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Choice(callback: [PaymentProcessorsEnum::class, 'getValues'])]
    public ?string $paymentProcessor;


    /**
     * @inheritDoc
     */
    public static function fromHttpRequest(Request $request): static
    {
        $self = new static();
        $self->product = $request->getPayload()->get('product');
        $self->couponCode = $request->getPayload()->get('couponCode');
        $self->taxNumber = $request->getPayload()->get('taxNumber');
        $self->paymentProcessor = $request->getPayload()->get('paymentProcessor');
        return $self;
    }
}
