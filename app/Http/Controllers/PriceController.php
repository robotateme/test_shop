<?php

namespace App\Http\Controllers;

use App\Http\Requests\SetPriceRequest;
use Illuminate\Http\JsonResponse;

class PriceController extends Controller
{
    public function setPrice(SetPriceRequest $request): JsonResponse
    {
        return response()->json($request->validated());
    }

}
