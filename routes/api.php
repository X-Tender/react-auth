<?php

use App\Controllers\AuthController;
use Slim\Routing\RouteCollectorProxy;

$app->group("/api", function (RouteCollectorProxy $group) {
    $group->post("/edit", AuthController::class . ':index');
    $group->post("/login", AuthController::class . ':login');
    $group->post("/logout", AuthController::class . ':logout');
    $group->post("/ping", AuthController::class . ':ping');
});
