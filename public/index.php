<?php

use GeekhubShop\Framework\Kernel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';

function render_template($request)
{
    extract($request->attributes->all(), EXTR_SKIP);
    ob_start();
    include sprintf(__DIR__ . '/../src/templates/%s.php', $_route);
    return new Response(ob_get_clean());
}

$routes = include __DIR__ . '/../src/config.php';

$request = Request::createFromGlobals();

$context = new RequestContext();
$matcher = new UrlMatcher($routes, $context);

$controllerResolver = new ControllerResolver();
$argumentResolver = new ArgumentResolver();

$kernel = new Kernel($matcher, $controllerResolver, $argumentResolver);
$response = $kernel->handle($request);

$response->prepare($request);
$response->send();
