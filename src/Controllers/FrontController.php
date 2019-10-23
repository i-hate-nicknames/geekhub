<?php

namespace GeekhubShop\Controllers;

class FrontController
{
    /**
     * Find an appropriate controller for action in the request and call it. Called controller
     * is responsible for printing output.
     * Print error page in case no controller for given action can be found.
     */
    public function dispatch()
    {
        echo 'Actual controller output be here';
    }
}
