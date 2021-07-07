<?php

namespace App\Middleware;

use App\Utils\Config;
use Dflydev\FigCookies\FigRequestCookies;
use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\SetCookie;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class LoginCookieRefreshMiddleware
{

    protected $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function __invoke(Request $request, RequestHandler $handler)
    {
        $response = $handler->handle($request);

        $cookieLifetime = $_ENV['JWT_LIFETIME_HOURS'];

        $authCookieName = $_ENV['JWT_AUTH_COOKIE_NAME'];
        $dataCookieName = $_ENV['JWT_DATA_COOKIE_NAME'];

        // AUTH COOKIE
        $cookie        = FigRequestCookies::get($request, $authCookieName);
        $requestToken  = $cookie->getValue();
        $responseToken = FigResponseCookies::get($response, $authCookieName)->getValue();

        if ($requestToken != null && $responseToken === null) {
            $setCookie = SetCookie::create($authCookieName)
                ->withValue($requestToken)
                ->withExpires(new \DateTime("+$cookieLifetime hour"))
                ->withHttpOnly(true)
                ->withPath('/');

            $response = FigResponseCookies::set($response, $setCookie);
        }

        // DATA COOKIE
        $cookie        = FigRequestCookies::get($request, $dataCookieName);
        $requestToken  = $cookie->getValue();
        $responseToken = FigResponseCookies::get($response, $dataCookieName)->getValue();
        if ($requestToken != null && $responseToken === null) {
            $setCookie = SetCookie::create($dataCookieName)
                ->withValue($requestToken)
                ->withExpires(new \DateTime("+$cookieLifetime hour"))
                ->withHttpOnly(false)
                ->withPath('/');

            $response = FigResponseCookies::set($response, $setCookie);
        }

        return $response;
    }
}
