<?php

namespace App\Controller;

use App\dto\ProductRequest;
use App\interface\ProductServiceInterface;
use App\service\payment\PaymentService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;


class ProductController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private PaymentService $paymentService;

    const PAYMENT_PROCESSOR_STRIPE = 'paypal';
    const PAYMENT_PROCESSOR_PAYPAL = 'stripe';

    public function __construct(EntityManagerInterface $entityManage, PaymentService $paymentService)
    {
        $this->entityManager = $entityManage;
        $this->paymentService = $paymentService;
    }

    #[Route('/product/get-price', name: 'get_product_price', methods: ['POST'])]
    public function getPrice(Request $request, ProductServiceInterface $productService): JsonResponse
    {
        $productRequest = new ProductRequest();
        $productRequest->product = $request->request->get('product');
        $productRequest->taxNumber = $request->request->get('taxNumber');
        $productRequest->couponCode = $request->request->get('couponCode');

        return new JsonResponse($productService->calculatePrice($productRequest), 200);
    }

    #[Route('/product/pay', name: 'pay_product', methods: ['POST'])]
    public function executePayment(Request $request, ProductServiceInterface $productService)
    {
        $productRequest = new ProductRequest();
        $productRequest->product = $request->request->get('product');
        $productRequest->taxNumber = $request->request->get('taxNumber');
        $productRequest->couponCode = $request->request->get('couponCode');
        $productRequest->paymentProcessor = $request->request->get('paymentProcessor');

       $result =  $this->paymentService->executePurchase(
            $productService->calculatePrice($productRequest),
            self::PAYMENT_PROCESSOR_PAYPAL
        );
        return new JsonResponse($result, 200);
    }


}
