<?php

namespace App\service\payment;

use App\interface\PaymentProcessorInterface;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;

class PaypalPaymentProcessorService implements PaymentProcessorInterface
{
    private $paypalPaymentProcessor;

    public function __construct(PaypalPaymentProcessor $paypalPaymentProcessor)
    {
        $this->paypalPaymentProcessor = $paypalPaymentProcessor;
    }

    public function run(int $price)
    {
        try {
            $this->paypalPaymentProcessor->pay($price);
            return [
              'message'=>'Payment is successfull'
            ];
        }  catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
