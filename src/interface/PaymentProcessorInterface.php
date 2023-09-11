<?php

namespace App\interface;

use App\dto\ProductRequest;
use App\Entity\Coupon;

interface PaymentProcessorInterface
{
    public function run(int $price);
}
