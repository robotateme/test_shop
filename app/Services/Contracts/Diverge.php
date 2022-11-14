<?php

namespace App\Services\Contracts;

interface Diverge
{

    public function diffPrice(float $new, float $out): bool;

    public function getDeviation(): float;

}
