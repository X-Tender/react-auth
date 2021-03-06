<?php

namespace App\Controllers;

use App\Models\User;
use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\SetCookie;
use Firebase\JWT\JWT;
use Noodlehaus\Config;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Router;
use Slim\Views\Twig;

class AuthController
{
    protected $view;
    protected $router;

    public function __construct(Twig $view, Router $router, Config $config)
    {
        $this->view   = $view;
        $this->router = $router;
        $this->config = $config;
    }

    public function index(Request $request, Response $response)
    {
        return $response->withJson(["access" => true]);
    }

    public function ping(Request $request, Response $response)
    {
        $token  = $request->getAttribute("token");
        $userId = $token["data"]->id;
        $user   = User::find($userId);

        if (!$user) {
            return $response->withJson([
                "error"   => 1,
                "message" => "ERROR USER",
            ]);
        }

        $response = $this->setAuthCookie($user, $response);

        $responseData = [
            "error"    => 0,
            "message"  => "SUCCESS",
            "authData" => [
                "email" => $user->email,
            ],
        ];

        return $response->withJson($responseData);
    }

    public function logout(Request $request, Response $response)
    {
        $authCookieName = $this->config->get('jwt.authCookie');
        $dataCookieName = $this->config->get('jwt.dataCookie');

        $authCookie = SetCookie::create($authCookieName)
            ->withValue('')
            ->withExpires(new \DateTime('-6 hour'))
            ->withHttpOnly(true)
            ->withPath("/");
        $response = FigResponseCookies::set($response, $authCookie);

        $dataCookie = SetCookie::create($dataCookieName)
            ->withValue('')
            ->withExpires(new \DateTime('-6 hour'))
            ->withHttpOnly(false)
            ->withPath("/");

        $response = FigResponseCookies::set($response, $dataCookie);

        return $response->withJson(["access" => true]);
    }

    public function login(Request $request, Response $response)
    {
        $postData = $request->getParsedBody();
        $username = $postData["email"];
        $password = $postData["password"];

        $user = User::where("email", $username)->first();

        if (!$user) {
            return $response->withJson([
                "error"   => 1,
                "message" => "ERROR USER",
            ]);
        }

        // if ($user->password != $password) {
        //     return $response->withJson([
        //         "error"   => 2,
        //         "message" => "ERROR PASSWORD",
        //     ]);
        // }

        $response = $this->setAuthCookie($user, $response, $request);

        $responseData = [
            "error"    => 0,
            "message"  => "SUCCESS",
            "authData" => [
                "email" => $user->email,
            ],
        ];

        return $response->withJson($responseData);
    }

    public function setAuthCookie($user, $response)
    {
        $now = new \DateTime();

        $key = $this->config->get('jwt.secret');

        $authCookieName = $this->config->get('jwt.authCookie');
        $dataCookieName = $this->config->get('jwt.dataCookie');

        $authJWT = [
            "iat"  => $now->getTimeStamp(),
            "exp"  => \Carbon\Carbon::now()->addHour(6)->timestamp,
            "data" => ["id" => $user->id],
        ];

        $authToken = JWT::encode($authJWT, $key);

        $authCookie = SetCookie::create($authCookieName)
            ->withValue($authToken)
            ->withExpires(new \DateTime('+6 hour'))
            ->withHttpOnly(true)
            ->withPath("/");
        $response = FigResponseCookies::set($response, $authCookie);

        $dataJWT = [
            "iat"  => $now->getTimeStamp(),
            "exp"  => \Carbon\Carbon::now()->addHour(6)->timestamp,
            "data" => ["username" => $user->username],
        ];

        $dataToken = JWT::encode($dataJWT, $key);

        $dataCookie = SetCookie::create($dataCookieName)
            ->withValue($dataToken)
            ->withExpires(new \DateTime('+6 hour'))
            ->withHttpOnly(false)
            ->withPath("/");

        $response = FigResponseCookies::set($response, $dataCookie);

        return $response;
    }
}
