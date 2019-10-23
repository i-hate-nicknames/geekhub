<?php

require_once 'init.php';

$app = new \GeekhubShop\Cli\ConsoleApp();
$app->createProduct($argv);
