<?php

namespace App\dto;

use Symfony\Component\Validator\Constraints as Assert;

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
