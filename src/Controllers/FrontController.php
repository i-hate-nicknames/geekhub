<?php

namespace GeekhubShop\Controllers;

use GeekhubShop\Views\BaseView;

class FrontController
{
    /**
     * Find an appropriate controller for action in the request and call it. Called controller
     * is responsible for printing output.
     * Print error page in case no controller for given action can be found.
     */
    public function dispatch()
    {
        $view = new BaseView();
        $view->renderTemplate(['items' => [1, 2, 3]], 'main.php');
        echo 'Actual controller output be here';
    }
}
