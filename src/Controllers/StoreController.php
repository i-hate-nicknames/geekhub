<?php

namespace GeekhubShop\Controllers;

use GeekhubShop\App;
use GeekhubShop\Store\Database;
use GeekhubShop\Store\Store;
use GeekhubShop\Views\BaseView;

class StoreController extends BaseController
{
    public function indexAction()
    {
        $store = $this->getStore();
        $view = new BaseView();
        $view->renderTemplate(['productsGrouped' => $store->getProductsGroupedByCategory()], 'main.php');
    }

    public function createProductAction()
    {
        $productName = $this->getRequestStringParam('name', '');
        $price = $this->getRequestFloatParam('name', 0.0);
        $qty = $this->getRequestIntParam('name', 0);
        if ($productName === '') {
            throw new \Exception('Product name is empty');
        }
        $store = $this->getStore();
        $store->createProduct($productName, $qty, $price);
        echo 'success';
    }

    public function moveProductAction()
    {

    }

    private function getStore()
    {
        $db = new Database(App::DB_FILE);
        return new Store($db);
    }
}
