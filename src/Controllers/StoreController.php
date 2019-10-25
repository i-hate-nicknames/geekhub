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
        $price = $this->getRequestFloatParam('price', 0.0);
        $qty = $this->getRequestIntParam('qty', 0);
        if ($productName === '') {
            throw new \Exception('Product name is empty');
        }
        $store = $this->getStore();
        $store->createProduct($productName, $qty, $price);
        // TODO: redirect with success message
        echo "Create product $productName, price $price qty $qty";
    }

    public function moveProductAction()
    {
        $productId = $this->getRequestStringParam('productId', '');
        $targetCat = $this->getRequestStringParam('targetCategory', '');
        if ($productId === '') {
            throw new \Exception('Product id is empty');
        }
        if ($targetCat === '') {
            throw new \Exception('Category name is empty');
        }
        $this->getStore()->move($productId, $targetCat);
        // TODO: redirect with success message
        echo "Moved product $productId to $targetCat";
    }

    private function getStore()
    {
        $db = new Database(App::DB_FILE);
        return new Store($db);
    }
}
