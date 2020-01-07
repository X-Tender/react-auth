<?php

$app->post("/api/edit", ["App\Controllers\AuthController", "index"]);
$app->post("/api/login", ["App\Controllers\AuthController", "login"]);
$app->post("/api/logout", ["App\Controllers\AuthController", "logout"]);
$app->post("/api/ping", ["App\Controllers\AuthController", "ping"]);

$app->get("/[{rest:.*}]", ["App\Controllers\IndexController", "index"])->setName("index");
