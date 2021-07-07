<?php

namespace App\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Slim\Interfaces\RouteParserInterface;

class RouterServiceProvider extends AbstractServiceProvider
{

    protected $provides = [
        RouteParserInterface::class,
    ];

    protected $routeParser;

    public function __construct(RouteParserInterface $routeParser)
    {
        $this->routeParser = $routeParser;
    }

    public function register()
    {
        $container = $this->getContainer();
        $container->share(RouteParserInterface::class, $this->routeParser);
    }
}
