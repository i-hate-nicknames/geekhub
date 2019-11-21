<?php

namespace App\Controller;

use App\Message\TelegramMessage;
use App\Services\Store;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StoreController extends AbstractController
{
    /**
     * @Route("/")
     * @return Response
     */
    public function hello(Store $store)
    {
        return $this->render('categories.html.twig', ['categories' => $store->getProductsGroupedByCategory()]);
    }

    /**
     * @Route("/createProduct/{name}/{price}/{qty}")
     * @param $name
     * @param float $price
     * @param int $qty
     * @return Response
     */
    public function createProduct(Store $store, $name, $price = 0.0, $qty = 0)
    {
        $store->createProduct($name, $qty, $price);
        return $this->redirect('/');
    }

    /**
     * @Route("/moveProduct/{productId}/{target}")
     * @param $productId
     * @param $target
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function moveProduct(Store $store, $productId, $target)
    {
        $store->move($productId, $target);
        return $this->redirect('/');
    }
}
