<?php

use App\Providers\ConfigServiceProvider;
use App\Providers\EloquentServiceProvider;
use App\Providers\FlashMessageServiceProvider;
use App\Providers\RouterServiceProvider;
use App\Providers\ViewServiceProvider;

$container->addServiceProvider(new ConfigServiceProvider());
$container->addServiceProvider(new EloquentServiceProvider());
$container->addServiceProvider(new FlashMessageServiceProvider());
$container->addServiceProvider(new ViewServiceProvider($app->getRouteCollector()->getRouteParser()));
$container->addServiceProvider(new RouterServiceProvider($app->getRouteCollector()->getRouteParser()));
