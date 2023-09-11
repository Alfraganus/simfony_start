<?php

namespace App\DataFixtures;

use App\Entity\Country;
use App\Entity\Coupon;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CouponFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $couponData = [
            ['code' => 'C12345', 'type' => 'fixed', 'value' => 50, 'is_active' => 1],
            ['code' => 'C12346', 'type' => 'fixed', 'value' => 10, 'is_active' => 1],
            ['code' => 'C12347', 'type' => 'fixed', 'value' => 25, 'is_active' => 1],
            ['code' => 'C12348', 'type' => 'percentage', 'value' => 15, 'is_active' => 1],
            ['code' => 'C12349', 'type' => 'percentage', 'value' => 5, 'is_active' => 1],
        ];

        foreach ($couponData as $couponInfo) {
            $coupon = new Coupon();
            $coupon->setCode($couponInfo['code']);
            $coupon->setType($couponInfo['type']);
            $coupon->setValue($couponInfo['value']);
            $coupon->setIsActive($couponInfo['is_active']);
            $manager->persist($coupon);
        }

        $manager->flush();
    }
}
