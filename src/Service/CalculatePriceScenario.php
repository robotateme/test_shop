<?php

namespace App\Service;

use App\Dto\CalculatePriceInput;
use App\Dto\CalculatePriceOutput;
use App\Enum\CouponTypesEnum;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use App\Repository\TaxRepository;
use App\Service\CalculatePriceStrategies\FixedStrategy;
use App\Service\CalculatePriceStrategies\NoDiscountStrategy;
use App\Service\CalculatePriceStrategies\PercentStrategy;
use App\Service\Exceptions\CalculatePriceException;

final readonly class CalculatePriceScenario
{
    public function __construct(
        private ProductRepository $productRepository,
        private CouponRepository  $couponRepository,
        private TaxRepository     $taxRepository,
    )
    {
    }

    /**
     * @throws CalculatePriceException
     */
    public function handle(CalculatePriceInput $input): CalculatePriceOutput|iterable
    {
        $product = $this->productRepository->find($input->product);

        if ($product === null) {
            throw new CalculatePriceException('Product not found');
        }

        $tax = $this->taxRepository->findOneBy(['number' => $input->taxNumber]);

        if ($tax === null) {
            throw new CalculatePriceException('Tax not found');
        }

        if (!is_null($input->couponCode)) {
            $coupon = $this->couponRepository->findOneBy(['code' => $input->couponCode]);
            if ($coupon === null) {
                throw new CalculatePriceException('Coupon not found');
            }

            switch (true) {
                case ($coupon->getType() === CouponTypesEnum::TypeFixed) :
                    return FixedStrategy::handle($product, $tax, $coupon);
                case ($coupon->getType() === CouponTypesEnum::TypePercent) :
                    return PercentStrategy::handle($product, $tax, $coupon);
            }
        }

        return NoDiscountStrategy::handle($product, $tax, null);
    }
}
