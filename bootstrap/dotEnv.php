<?php

use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;

try {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
    $dotenv->required('APP_DEBUG')->isBoolean();
    $dotenv->required('VIEW_CACHE_DISABLED')->isBoolean();
} catch (InvalidPathException $e) {
    die("ERROR: Couldn't find configuration");
} catch (RuntimeException $e) {
    dump($e);
    die();
}
