<?php

namespace GeekhubShop;

use GeekhubShop\Controllers\FrontController;

class App
{
    public const TEMPLATES_DIR = __DIR__ . '/templates/';

    public const DB_FILE = __DIR__ . '/../data/database.json';

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
        $this->frontController->run();
    }
}
