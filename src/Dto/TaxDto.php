<?php

namespace App\Dto;

class TaxDto
{
    public function __construct(public string $number, public int $rate)
    {
    }
}
