<?php

namespace GeekhubShop\Framework;

use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use function call_user_func_array;

class Kernel
{
    /** @var UrlMatcher */
    private $matcher;

    /** @var ControllerResolver */
    private $controllerResolver;

    /** @var ArgumentResolver */
    private $argumentResolver;

    /**
     * Kernel constructor.
     * @param UrlMatcher $matcher
     * @param ControllerResolver $controllerResolver
     * @param ArgumentResolver $argumentResolver
     */
    public function __construct(UrlMatcher $matcher, ControllerResolver $controllerResolver, ArgumentResolver $argumentResolver)
    {
        $this->matcher = $matcher;
        $this->controllerResolver = $controllerResolver;
        $this->argumentResolver = $argumentResolver;
    }

    public function handle(Request $request): Response
    {
        $this->matcher->getContext()->fromRequest($request);

        try {
            $request->attributes->add($this->matcher->match($request->getPathInfo()));
            $controller = $this->controllerResolver->getController($request);
            $arguments = $this->argumentResolver->getArguments($request, $controller);
            $response = call_user_func_array($controller, $arguments);
            $response->headers->set('Content-Type', 'text/html');
        } catch (ResourceNotFoundException $exception) {
            $response = new Response('Not Found', 404);
        } catch (Exception $exception) {
            $response = new Response('Internal server error', 500);
        }
        return $response;
    }
}
