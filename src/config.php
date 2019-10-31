<?php
// application configuration be here

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();
$routes->add('hello', new Route('/hello/{name}', [
    'name' => 'kurwa',
    '_controller' => 'render_template'
]));
$routes->add('bye', new Route('/bye'));

return $routes;
