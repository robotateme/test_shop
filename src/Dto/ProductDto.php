<?php

namespace App\Dto;

class ProductDto
{
    public function __construct(public string $title, public float $price)
    {
    }
}
