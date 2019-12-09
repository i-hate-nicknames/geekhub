<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StoreController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @return Response
     * @throws \Exception
     */
    public function hello()
    {
        return $this->render('categories.html.twig', ['categories' => '']);
    }
}
