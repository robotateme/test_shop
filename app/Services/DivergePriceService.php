<?php

namespace App\Services;

use App\Services\Contracts\Diverge;

class DivergePriceService implements Diverge
{
    /**
     * @var float
     */
    private float $permissibleDeviation = 30;

    /**
     * @var float
     */
    private float $deviationResult = 0;

    /**
     * @param float $new
     * @param float $out
     * @return bool
     */
    public function diffPrice(float $new, float $out): bool
    {
        $this->deviationResult = abs(((1 - $new / $out) * 100));
        return $this->deviationResult <= $this->permissibleDeviation;
    }

    /**
     * @return float
     */
    public function getDeviation(): float
    {
        return $this->deviationResult;
    }
}
