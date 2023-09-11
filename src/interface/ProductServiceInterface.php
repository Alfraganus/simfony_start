<?php

namespace App\interface;

use App\dto\ProductRequest;
use App\Entity\Coupon;

interface ProductServiceInterface
{
    public function calculatePrice(ProductRequest $request): array;
}
