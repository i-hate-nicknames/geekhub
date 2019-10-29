<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';

$request = Request::createFromGlobals();
$response = new Response();
$response->setStatusCode(200);
$response->setContent('deth');
$response->headers->set('Content-Type', 'text/html');
$response->prepare($request);
$response->send();
die();
$app = new \GeekhubShop\App();
$app->run();