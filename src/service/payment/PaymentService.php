<?php

namespace App\service\payment;

use App\Entity\Product;
use Exception;

class PaymentService
{
    private $paypalPaymentProcessor;
    private $stripePaymentProcessor;
    private $validation;

    public function __construct(
        PaypalPaymentProcessorService $paypalPaymentProcessor,
        StripePaymentProcessorService $stripePaymentProcessor,
        ValidationService $validationService
    )
    {
        $this->paypalPaymentProcessor = $paypalPaymentProcessor;
        $this->stripePaymentProcessor = $stripePaymentProcessor;
        $this->validation = $validationService;
    }

    public function executePurchase($sum, $paymentProcessor)/*: array*/
    {
        try {
            $paymentResult = match ($paymentProcessor) {
                'paypal' => $this->paypalPaymentProcessor->run($sum),
                'stripe' => $this->stripePaymentProcessor->run($sum),
                default => ['error' => 'Invalid payment processor'],
            };
        } catch (Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }

        if ($paymentResult) return ['message' => 'Payment successful'];

        return ['error' => 'Payment failed'];
    }
}