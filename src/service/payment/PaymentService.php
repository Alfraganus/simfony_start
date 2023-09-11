<?php

namespace App\service\payment;

use Exception;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class PaymentService
{
    private $paypalPaymentProcessor;
    private $stripePaymentProcessor;

    public function __construct(PaypalPaymentProcessorService $paypalPaymentProcessor, StripePaymentProcessorService $stripePaymentProcessor)
    {
        $this->paypalPaymentProcessor = $paypalPaymentProcessor;
        $this->stripePaymentProcessor = $stripePaymentProcessor;
    }

    public function executePurchase($sum, $paymentProcessor): array
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