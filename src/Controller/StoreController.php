<?php

namespace App\Controller;

use App\Message\TelegramMessage;
use App\Services\Store;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class StoreController extends AbstractController
{
    /**
     * @Route("/")
     * @return Response
     * @throws \Exception
     */
    public function hello(Store $store)
    {
        return $this->render('categories.html.twig', ['categories' => $store->getProductsGroupedByCategory()]);
    }

    /**
     * @Route("/createProduct/{name}/{price}/{qty}/{description}")
     * @param $name
     * @param int $price
     * @param int $qty
     * @param string $description
     * @return Response
     * @throws \Exception
     */
    public function createProduct(Store $store, $name, $price = 0, $qty = 0, $description='')
    {
        $store->createProduct($name, $qty, $price, $description);
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

    /**
     * @Route("/createCategory/{name}")
     * @param Store $store
     * @param string $name
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createCategory(Store $store, string $name)
    {
        $store->createCategory($name);
        return $this->redirect('/');
    }
}
