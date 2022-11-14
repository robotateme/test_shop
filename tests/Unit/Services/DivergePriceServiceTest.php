<?php

namespace Tests\Unit\Services;

use App\Services\DivergePriceService;
use PHPUnit\Framework\TestCase;

class DivergePriceServiceTest extends TestCase
{
    private ?DivergePriceService $service = null;

    public function setUp(): void
    {
        $this->service = new DivergePriceService();
    }

    public function testDiffPriceFail()
    {
        $this->assertFalse($this->service->diffPrice(50, 100));
    }

    public function testDiffPriceSuccess()
    {
        $this->assertTrue($this->service->diffPrice(99, 100));
    }


}
