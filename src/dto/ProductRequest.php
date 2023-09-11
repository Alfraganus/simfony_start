<?php

namespace App\dto;

class ProductRequest
{
    /**
     * @Assert\NotBlank()
     */
    public $product;

    /**
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^(DE|IT|GR|FR)\d+$/")
     */
    public $taxNumber;

    public $couponCode;
    public $paymentProcessor;
}
