<?php
// src/Controller/HelloController.php

namespace App\Controller;

use App\Entity\Country;
use App\Entity\Coupon;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;


class ProductController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/product/get-price', name: 'test', methods: ['POST'])]
    public function getPrice(Request $request, ValidatorInterface $validator)
    {
        $data = $request->request->all();

        $validationErrors = $this->validateInput($data, $validator);
        if ($validationErrors) {
            return new JsonResponse(['errors' => $validationErrors], 400);
        }

        $productId = $data['product'];
        $taxNumber = $data['taxNumber'];
        $couponCode = $data['couponCode']??null;

        $product = $this->entityManager->getRepository(Product::class)->find($productId);

        if (!$product) {
            return new JsonResponse(['error' => 'Product not found'], 400);
        }

        $country = $this->getCountryByTaxNumber($taxNumber);

        if (!$country) {
            return new JsonResponse(['error' => 'Invalid tax number format'], 400);
        }

        $taxPercentage = $this->calculateTaxPercentage($country);

        $basePrice = $product->getPrice();

        $discount = 0;
        $coupon = $this->entityManager->getRepository(Coupon::class)->findOneBy(['code' => $couponCode]);

        if ($coupon) {
            $couponType = $coupon->getType();
            $couponValue = $coupon->getValue();

            if ($couponType === 'fixed') {
                $discount = $couponValue;
            } elseif ($couponType === 'percentage') {
                $percentageDiscount = ($couponValue / 100) * $basePrice;
                $discount = $percentageDiscount;
            }
        }

        $taxAmount = ($basePrice * ($taxPercentage / 100));
        $finalPrice = $basePrice - $discount + $taxAmount;

        return new JsonResponse([
            'total_price' => $finalPrice,
            'price'=>$basePrice,
            'tax'=>$taxAmount,
            'discount'=>$discount
        ], 200);
    }


    private function getCountryByTaxNumber(string $taxNumber)
    {
        $country = $this->entityManager->getRepository(Country::class)->findOneBy(['regex_tax_number' => $taxNumber]);

        return $country;
    }

    private function calculateTaxPercentage(Country $country)
    {
        return $country->getTaxPercentage();
    }


    private function validateInput(array $data, ValidatorInterface $validator)
    {
        $commonConstraints = [
            new Assert\NotBlank(),
            new Assert\Regex(['pattern' => '/^(DE|IT|GR|FR)\d+$/']),
        ];

        $constraints = [
            'product' =>  new Assert\NotBlank(),
            'taxNumber' => $commonConstraints,
        ];

        if (isset($data['couponCode'])) {
            $constraints['couponCode'] = [];
        }

        $collectionConstraint = new Assert\Collection($constraints);

        $violations = $validator->validate($data, $collectionConstraint);

        $errors = [];
        foreach ($violations as $violation) {
            $propertyPath = $violation->getPropertyPath();
            $message = $violation->getMessage();
            $errors[$propertyPath] = $message;
        }

        return $errors;
    }
}
