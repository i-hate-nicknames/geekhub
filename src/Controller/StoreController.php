<?php

namespace App\Controller;

use App\Models\Database;
use App\Models\Store;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StoreController extends AbstractController
{
    public const DB_FILE = '/data/database.json';

    /**
     * @Route("/")
     * @return Response
     */
    public function hello()
    {
        $store = $this->getStore();
        return $this->render('categories.html.twig', ['categories' => $store->getProductsGroupedByCategory()]);
    }

    /**
     * @Route("/createProduct/{name}/{price}/{qty}")
     * @param $name
     * @param float $price
     * @param int $qty
     * @return Response
     */
    public function createProduct($name, $price = 0.0, $qty = 0)
    {
        $store = $this->getStore();
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
    public function moveProduct($productId, $target)
    {
        $store = $this->getStore();
        $this->getStore()->move($productId, $target);
        return $this->redirect('/');
    }

    private function getStore()
    {
        $db = new Database(self::DB_FILE);
        return new Store($db);
    }
}
