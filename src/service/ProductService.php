<?php

namespace App\service;

use App\DTO\ProductRequest;
use App\Entity\Country;
use App\Entity\Coupon;
use App\Entity\Product;
use App\interface\ProductServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class ProductService implements ProductServiceInterface
{

    private $entityManager;
    private $validationService;
    private $taxCalculationService;
    private $discountCalculationService;
    private $finalPriceCalculationService;
    public function __construct(
        EntityManagerInterface $entityManager,
        ValidationService $validationService,
        TaxCalculationService $taxCalculationService,
        DiscountCalculationService $discountCalculationService,
        FinalPriceCalculationService $finalPriceCalculationService
)
    {
        $this->entityManager = $entityManager;
        $this->validationService = $validationService;
        $this->taxCalculationService = $taxCalculationService;
        $this->discountCalculationService = $discountCalculationService;
        $this->finalPriceCalculationService = $finalPriceCalculationService;
    }

    public function calculatePrice(ProductRequest $request): array
    {
        $validationErrors = $this->validationService->validateInput($request);

        if ($validationErrors) {
            return ['errors' => $validationErrors];
        }

        $product = $this->entityManager->getRepository(Product::class)->find($request->product);
        if (!$product) {
            return ['error' => 'Product not found'];
        }
        $basePrice = $product->getPrice();

        $taxBycountry = $this->getCountryByTaxNumber($request->taxNumber);
        if (!$taxBycountry) {
            return ['error' => 'Invalid tax number format'];
        }

        /*check if we have discount*/
        $coupon = $this->entityManager->getRepository(Coupon::class)->findOneBy(['code' => $request->couponCode ?? null]);
        $discount = $coupon ? $this->discountCalculationService->calculateDiscount($coupon, $basePrice) : 0;
        $taxPercentage = $this->taxCalculationService->calculateTaxPercentage($taxBycountry); //taxing
        $taxAmount = ($basePrice * ($taxPercentage / 100));
        $finalPrice = $this->finalPriceCalculationService->calculateFinalPrice($basePrice, $taxAmount, $discount);

        return [
            'total_price' => $finalPrice,
            'price' => $basePrice,
            'tax' => $taxAmount,
            'discount' => $discount,
        ];
    }

    private function getCountryByTaxNumber(string $taxNumber): ?Country
    {
        return $this->entityManager->getRepository(Country::class)->findOneBy(['regex_tax_number' => $taxNumber]);
    }
}