<?php

use Symfony\Component\HttpFoundation\Request;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';

$routes = include __DIR__ . '/../src/config.php';

$container = include __DIR__ . '/../src/container.php';

$request = Request::createFromGlobals();

$response = $container->get('kernel')->handle($request);

$response->prepare($request);
$response->send();
