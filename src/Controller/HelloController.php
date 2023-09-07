<?php
// src/Controller/HelloController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{

    #[Route('/test', name:'test')]
    public function helloWorld()
    {
        $response = [
            'message' => 'Hello, World!',
        ];

        return new JsonResponse($response);
    }
}
