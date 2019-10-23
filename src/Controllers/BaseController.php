<?php

namespace GeekhubShop\Controllers;

abstract class BaseController
{
    abstract public function run();

    public function error($httpStatus, $text, $template=null)
    {
        echo "Error $httpStatus: $text";
    }
}
