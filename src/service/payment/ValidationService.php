<?php
// src/Service/ValidationService.php

namespace App\service\payment;

use App\DTO\ProductRequest;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidationService
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validateInput(ProductRequest $request): array
    {
        $violations = $this->validator->validate($request);

        $errors = [];
        foreach ($violations as $violation) {
            $propertyPath = $violation->getPropertyPath();
            $message = $violation->getMessage();
            $errors[$propertyPath] = $message;
        }
        if (empty($request->product)) {
            $errors['product'] = 'Product cannot be blank';
        }
        if (empty($request->taxNumber)) {
            $errors['taxNumber'] = 'Tax number cannot be blank';
        }
        if (empty($request->paymentProcessor)) {
            $errors['paymentProcessor'] = 'paymentProcessor  cannot be blank';
        }
        return $errors;
    }
}