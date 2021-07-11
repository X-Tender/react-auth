<?php

use League\Container\ReflectionContainer;
use Slim\Factory\AppFactory;

session_start();

date_default_timezone_set('Europe/Berlin');
setlocale(LC_ALL, 'de_DE.UTF-8');

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/dotEnv.php';

if ($_ENV['APP_DEBUG'] === 'true') {
    error_reporting(-1);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
}

$container = new League\Container\Container();
$container->delegate(new ReflectionContainer);

AppFactory::setContainer($container);
$app = AppFactory::create();

require_once __DIR__ . '/providers.php';
require_once __DIR__ . '/middleWares.php';
require_once __DIR__ . '/errorHandling.php';
require_once __DIR__ . '/../routes/api.php';
require_once __DIR__ . '/../routes/web.php';

$app->run();
