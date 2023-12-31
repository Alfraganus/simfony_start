<?php

namespace App\DataFixtures;

use App\Entity\Country;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $products = [
            ['name' => 'Iphone', 'price' => 100],
            ['name' => 'Наушники', 'price' => 20],
            ['name' => 'Чехол', 'price' => 10],
        ];

        foreach ($products as $product) {
            $new_product = new Product();
            $new_product->setName($product['name']);
            $new_product->setPrice($product['price']);
            $manager->persist($new_product);
        }

        $manager->flush();
    }
}
