<?php

namespace App\Controllers;

use Slim\Http\Response;
use Slim\Http\ServerRequest as Request;
use Slim\Interfaces\RouteParserInterface as Router;
use Slim\Views\Twig;

class IndexController
{
    protected $view;
    protected $router;

    public function __construct(Twig $view, Router $router)
    {
        $this->view   = $view;
        $this->router = $router;
    }

    public function index(Request $request, Response $response)
    {
        // how to get route arguments
        // $route = $request->getAttribute( "route" );
        // $foobar = $route->getArgument( "foobar" );

        return $this->view->render($response, "index.twig");
    }

    public function post(Request $request, Response $response)
    {
        // how to get post data
        // $postData = $request->getParsedBody();
        // $fooBar = $postData["fooBar"];

        $responseData = [
            "error"   => 0,
            "message" => "SUCCESS",
        ];

        return $response->withJson($responseData);
    }
}
