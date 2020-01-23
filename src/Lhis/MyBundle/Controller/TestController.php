<?php

namespace App\Lhis\MyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class TestController extends AbstractController
{
    public function index()
    {
        return new JsonResponse(['message' => 'welcome to this world']);
    }
}
