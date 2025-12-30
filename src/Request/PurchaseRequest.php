<?php

namespace App\Request;

use App\Request\Contract\AbstractRequest;
use Symfony\Component\HttpFoundation\Request;

class PurchaseRequest extends Contract\AbstractRequest
{


    /**
     * @inheritDoc
     */
    public static function fromHttpRequest(Request $request): static
    {
        // TODO: Implement fromHttpRequest() method.
    }
}
