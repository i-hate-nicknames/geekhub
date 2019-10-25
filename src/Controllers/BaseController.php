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

    protected function getRequestStringParam(string $key, string $default): string
    {
        return $this->getRequestParam($key, $default, FILTER_SANITIZE_STRING);
    }

    protected function getRequestFloatParam(string $key, float $default): float
    {
        return $this->getRequestParam($key, $default, FILTER_VALIDATE_FLOAT);
    }

    protected function getRequestIntParam(string $key, int $default): int
    {
        return $this->getRequestParam($key, $default, FILTER_VALIDATE_INT);
    }

    private function getRequestParam(string $key, $default, $filter)
    {
        $val = false;
        if (array_key_exists($key, $_REQUEST)) {
            $val = filter_var($_REQUEST[$key], $filter);
        }
        return ($val !== false) ? $val : $default;
    }
}
