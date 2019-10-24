<?php

namespace GeekhubShop\Controllers;

use GeekhubShop\App;
use GeekhubShop\Store\Database;
use GeekhubShop\Store\Store;
use GeekhubShop\Views\BaseView;

class StoreController extends BaseController
{
    public function run()
    {
        $db = new Database(App::DB_FILE);
        $store = new Store($db);
        $view = new BaseView();
        $view->renderTemplate(['productsGrouped' => $store->getProductsGroupedByCategory()], 'main.php');
    }
}
