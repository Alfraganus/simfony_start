<?php
namespace App\service;

use App\Entity\Country;

class TaxCalculationService
{
    public function calculateTaxPercentage(Country $country): float
    {
        return $country->getTaxPercentage();
    }
}