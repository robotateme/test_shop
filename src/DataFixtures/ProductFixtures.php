<?php

namespace App\DataFixtures;

use App\Dto\ProductDto;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $products = [
            new ProductDto('IPhone', 100.00),
            new ProductDto('Phones', 20.00),
            new ProductDto('Phone case', 10.00),
        ];

        foreach ($products as $productData) {
            $product = new Product();
            $product->setTitle($productData->title);
            $product->setPrice($productData->price);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
