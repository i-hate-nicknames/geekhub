<?php

namespace GeekhubShop;

use GeekhubShop\Controllers\FrontController;

class App
{
    /** @var FrontController */
    private $frontController;

    private function init()
    {
        // application-wide things can be initialized and injected here
        $this->frontController = new FrontController();
    }

    /**
     * Run application and produce output for the client
     */
    public function run()
    {
        $this->init();
        $this->frontController->dispatch();
    }
}
