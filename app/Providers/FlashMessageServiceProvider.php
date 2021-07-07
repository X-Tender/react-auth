<?php

namespace App\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Slim\Flash\Messages;

class FlashMessageServiceProvider extends AbstractServiceProvider
{

    protected $provides = [
        Messages::class,
    ];

    public function register()
    {
        $container = $this->getContainer();
        $container->share(Messages::class, new Messages());
    }
}
