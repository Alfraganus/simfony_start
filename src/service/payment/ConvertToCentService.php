<?php
namespace App\Service;

class ConvertToCentService
{
    public function convertToCents(float $amount): int
    {
        return (int) ($amount * 100);
    }
}