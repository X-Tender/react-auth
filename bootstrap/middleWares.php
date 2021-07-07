<?php

use Slim\Views\Twig;
use App\Utils\Config;
use App\Middleware\AuthViewMiddleware;
use Slim\Interfaces\RouteParserInterface;
use Tuupola\Middleware\JwtAuthentication;
use Zeuxisoo\Whoops\Slim\WhoopsMiddleware;
use App\Middleware\LoginCookieRefreshMiddleware;
use Tuupola\Middleware\JwtAuthentication\RequestPathRule;
use Tuupola\Middleware\JwtAuthentication\RequestMethodRule;

$app->add(new AuthViewMiddleware($container->get(Twig::class), $container->get(Config::class)));
$app->add(new LoginCookieRefreshMiddleware($container->get(Config::class)));

$app->add(new WhoopsMiddleware([
    'enable' => true,
    'title'  => '🤦🏻‍♂️ You killed ' . $_ENV['APP_NAME'],
]));

$app->add(new JwtAuthentication(
    [
        'secret' => $_ENV['JWT_SECRET'],
        'secure' => $_ENV['JWT_SECURE'],
        'cookie' => $_ENV['JWT_AUTH_COOKIE_NAME'],
        'before' => function ($request, $arguments) use ($container) {
            $decoded = $arguments['decoded'];
            //$decodedJWT = $container->get(DecodedJWT::class)->set($decoded);
            return $request;
        },
        'error'  => function (\Slim\Psr7\Response $response, $arguments) use ($container) {
            $path = $container->get(RouteParserInterface::class)->urlFor('index');
            return $response->withHeader('Location', $path)->withStatus(301);
        },
        'rules'  => [
            new RequestPathRule([
                'path'   => ['/api'],
                'ignore' => [
                    '/login',
                    '/api/login',
                ],
            ]),
            new RequestMethodRule([
                'passthrough' => ['OPTIONS'],
            ]),
        ],
    ]
));
