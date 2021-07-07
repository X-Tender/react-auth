<?php

$errorMiddleware = $app->addErrorMiddleware($_ENV['APP_DEBUG'] === 'true', false, false);
$errorHandler    = new App\Exceptions\Handler(
    $app->getResponseFactory(),
    $container->get(\Slim\Views\Twig::class),
    $app->getRouteCollector()->getRouteParser()
);
$errorMiddleware->setDefaultErrorHandler($errorHandler);
