<?php

namespace GeekhubShop\Controllers;

use GeekhubShop\App;
use GeekhubShop\Models\Database;
use GeekhubShop\Models\Store;
use GeekhubShop\Views\BaseView;
use Symfony\Component\HttpFoundation\Response;

class StoreController extends BaseController
{
    public function index()
    {
        $store = $this->getStore();
        $view = new BaseView();
        $body = $view->renderTemplate(['productsGrouped' => $store->getProductsGroupedByCategory()], 'main.php');
        return new Response($body);
    }

    public function createProduct($name, $price = 0.0, $qty = 0)
    {
        $store = $this->getStore();
        $store->createProduct($name, $qty, $price);
        // TODO: redirect with success message
        return new Response("Successfully created product $name, price $price qty $qty");
    }

    public function moveProduct($productId, $target)
    {
        $this->getStore()->move($productId, $target);
        // TODO: redirect with success message
        return new Response("Moved product $productId to $target");
    }

    private function getStore()
    {
        $db = new Database(App::DB_FILE);
        return new Store($db);
    }
}
