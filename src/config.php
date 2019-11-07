<?php
// application configuration be here

use GeekhubShop\Controllers\HelloController;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();
$routes->add('index', new Route('/', [
    '_controller' =>'GeekhubShop\Controllers\StoreController::index'
]));
// TODO: this should be POST
$routes->add('createProduct', new Route('/createProduct/{name}/{price}/{qty}', [
    'price' => 0.0,
    'qty' => 0,
    '_controller' =>'GeekhubShop\Controllers\StoreController::createProduct'
]));
// TODO: this should be POST
$routes->add('moveProduct', new Route('/moveProduct/{productId}/{target}', [
    '_controller' =>'GeekhubShop\Controllers\StoreController::moveProduct'
]));

return $routes;
