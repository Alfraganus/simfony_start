<?php

namespace App\service\payment;

use App\interface\PaymentProcessorInterface;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;
class StripePaymentProcessorService implements PaymentProcessorInterface
{
    private $stripePaymentProcessor;

    public function __construct(StripePaymentProcessor $stripePaymentProcessor)
    {
        $this->stripePaymentProcessor = $stripePaymentProcessor;
    }

    public function run(int $price) : bool
    {
       return  $this->stripePaymentProcessor->processPayment($price);
    }
}
