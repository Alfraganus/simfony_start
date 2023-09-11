<?php
namespace App\service;

use App\Entity\Coupon;

class DiscountCalculationService
{
    const FIXED = 'fixed';
    const PERCENTAGE = 'percentage';
    public function calculateDiscount(Coupon $coupon, float $basePrice): float
    {
        $discount = 0;

        $couponType = $coupon->getType();
        $couponValue = $coupon->getValue();

        if ($couponType === self::FIXED) {
            $discount = $couponValue;
        } elseif ($couponType === self::PERCENTAGE) {
            $percentageDiscount = ($couponValue / 100) * $basePrice;
            $discount = $percentageDiscount;
        }

        return $discount;
    }
}