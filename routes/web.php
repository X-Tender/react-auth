<?php

use App\Controllers\IndexController;

$app->get("/[{rest:.*}]", IndexController::class . ':index')->setName("index");
