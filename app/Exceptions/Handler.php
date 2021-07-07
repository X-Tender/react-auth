<?php

namespace App\Exceptions;

use Psr\Http\Message\ResponseFactoryInterface as ResponseFactory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\RouteParserInterface as Router;
use Slim\Views\Twig;

class Handler
{
    protected $responseFactory;

    protected $view;

    public function __construct(ResponseFactory $responseFactory, Twig $view, Router $router)
    {
        $this->responseFactory = $responseFactory;
        $this->view            = $view;
        $this->router          = $router;
    }

    public function __invoke(Request $request, \Throwable $exception)
    {
        if (method_exists($this, $handler = 'handle' . (new \ReflectionClass($exception))->getShortName())) {
            return $this->{$handler}($request);
        }

        throw $exception;
    }

    public function handleHttpNotFoundException(Request $request)
    {
        // Return for redirect
        return $this->responseFactory->createResponse()->withRedirect($this->router->urlFor('index'));

        // Return for Rendering 404 Page
        return $this->view->render(
            $this->responseFactory->createResponse(),
            'errors/404.twig'
        )->withStatus(404);
    }
}
