<?php

namespace GeekhubShop\Controllers;

use GeekhubShop\Views\BaseView;

class StoreController extends BaseController
{
    public function run()
    {
        $view = new BaseView();
        $view->renderTemplate(['items' => [1, 2, 3]], 'main.php');
    }
}
