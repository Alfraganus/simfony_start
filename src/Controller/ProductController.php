<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\dto\ProductRequest;
use App\interface\ProductServiceInterface;
use App\service\payment\PaymentService;
use App\service\payment\ValidationService;


class ProductController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private PaymentService $paymentService;
    private ValidationService $paymentValidation;

    const PAYMENT_PROCESSOR_STRIPE = 'paypal';
    const PAYMENT_PROCESSOR_PAYPAL = 'stripe';

    public function __construct(
        EntityManagerInterface $entityManage,
        PaymentService $paymentService,
        ValidationService $paymentValidation
    )
    {
        $this->entityManager = $entityManage;
        $this->paymentService = $paymentService;
        $this->paymentValidation = $paymentValidation;
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
    public function pay(Request $request, ProductServiceInterface $productService)
    {
        $productRequest = new ProductRequest();
        $productRequest->product = $request->request->get('product');
        $productRequest->taxNumber = $request->request->get('taxNumber');
        $productRequest->couponCode = $request->request->get('couponCode');
        $productRequest->paymentProcessor = $request->request->get('paymentProcessor');

        $validationErrors = $this->paymentValidation->validateInput($productRequest);
        if ($validationErrors) {
            return new JsonResponse($validationErrors, 200);
        }
        $result = $this->paymentService->executePurchase(
            $productService->calculatePrice($productRequest)['total_price'],
            self::PAYMENT_PROCESSOR_PAYPAL
        );
        return new JsonResponse($result, 200);
    }


}
