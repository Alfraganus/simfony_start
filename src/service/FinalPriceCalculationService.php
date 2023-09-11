<?php
namespace App\service;
class FinalPriceCalculationService
{
    public function calculateFinalPrice(float $basePrice, float $taxAmount, float $discount): float
    {
        return $basePrice - $discount + $taxAmount;
    }
}