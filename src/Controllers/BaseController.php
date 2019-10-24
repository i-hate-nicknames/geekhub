<?php

namespace GeekhubShop\Controllers;

use GeekhubShop\Views\BaseView;

class BaseController
{
    public function error($responseCode, $errorText, $template=null)
    {
        http_response_code($responseCode);
        $view = new BaseView();
        $view->renderTemplate(['responseCode' => $responseCode, 'errorText' => $errorText], 'error.php');
    }

    protected function getRequestValue(string $key, string $default): string
    {
        $val = $default;
        if (array_key_exists($key, $_REQUEST)) {
            $val = $_REQUEST[$key];
        }
        return $val;
    }
}
