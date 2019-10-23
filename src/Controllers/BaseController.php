<?php

namespace GeekhubShop\Controllers;

use GeekhubShop\Views\BaseView;

abstract class BaseController
{
    abstract public function run();

    public function error($responseCode, $errorText, $template=null)
    {
        http_response_code($responseCode);
        $view = new BaseView();
        $view->renderTemplate(['responseCode' => $responseCode, 'errorText' => $errorText], 'error.php');
    }
}
