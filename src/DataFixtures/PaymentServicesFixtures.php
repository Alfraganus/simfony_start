<?php

namespace App\DataFixtures;

use App\Entity\Country;
use App\Entity\PaymentService;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PaymentServicesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $products = [
            ['name' => 'Stripe'],
            ['name' => 'Paypal'],
        ];

        foreach ($products as $product) {
            $new_product = new PaymentService();
            $new_product->setName($product['name']);
            $manager->persist($new_product);
        }

        $manager->flush();
    }
}
