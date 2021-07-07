<?php

namespace App\Providers;

use App\Utils\Config;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ConfigServiceProvider extends AbstractServiceProvider
{

    protected $provides = [
        Config::class,
    ];

    public function register()
    {
        $container = $this->getContainer();
        $container->share(Config::class, function () {
            $rootPath = realpath(__DIR__ . '/../../');

            $config = new Config([
                'paths' => [
                    'root'      => $rootPath,
                    'resources' => realpath($rootPath . '/resources/'),
                    'views'     => realpath($rootPath . '/resources/views/'),
                    'public'    => realpath($rootPath . '/public/'),
                ],

                'views' => [
                    'cache' => $_ENV['VIEW_CACHE_DISABLED'] === 'true' ? false : realpath($rootPath . '/cache/views/'),
                ],
            ]);

            return $config;
        });
    }
}
