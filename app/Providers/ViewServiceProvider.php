<?php

namespace App\Providers;

use App\Utils\Config;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Slim\Flash\Messages;
use Slim\Interfaces\RouteParserInterface;
use Slim\Psr7\Factory\UriFactory;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

class ViewServiceProvider extends AbstractServiceProvider
{

    protected $provides = [
        Twig::class,
    ];

    protected $routeParser;

    public function __construct(RouteParserInterface $routeParser)
    {
        $this->routeParser = $routeParser;
    }

    public function register()
    {
        $container = $this->getContainer();

        $twig = Twig::create(__DIR__ . '/../../resources/views', [
            'cache' => $container->get(Config::class)->get('views.cache'),
        ]);

        $twig->addExtension(new TwigExtension(
            $this->routeParser,
            (new UriFactory)->createFromGlobals($_SERVER)

        ));

        $twig->getEnvironment()->addGlobal("flash", $container->get(Messages::class));

        $container->share(Twig::class, $twig);
    }
}
