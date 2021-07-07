<?php

namespace App\Middleware;

use App\Utils\Config;
use Dflydev\FigCookies\FigRequestCookies;
use Firebase\JWT\JWT;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Views\Twig;

class AuthViewMiddleware
{
    protected $view;

    public function __construct(Twig $view, Config $config)
    {
        $this->view   = $view;
        $this->config = $config;
    }

    public function __invoke(Request $request, RequestHandler $handler)
    {
        $cookieName = $_ENV['JWT_DATA_COOKIE_NAME'];
        $token      = FigRequestCookies::get($request, $cookieName)->getValue();

        $jwtUser = [
            'loggedIn' => false,
        ];

        if ($token != '') {
            $key = $_ENV['JWT_SECRET'];
            try {
                $jwt = JWT::decode($token, $key, ['HS256']);
                if (isset($jwt->data->user)) {
                    $jwtUser = [
                        'loggedIn'  => true,
                        'firstName' => $jwt->data->user->firstName,
                    ];
                }
            } catch (\Firebase\JWT\SignatureInvalidException $e) {
                echo 'Token Decode failed. Clearch Cookies or change cookie name.';
            }
        };
        $this->view->getEnvironment()->addGlobal('jwtUser', $jwtUser);

        $response = $handler->handle($request);

        return $response;
    }
}
