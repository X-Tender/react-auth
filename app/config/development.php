<?php

return [
    "app"      => [
        "phpDebugMode" => true,
        "rootPath"     => __DIR__ . "/../../",
        "public"       => __DIR__ . "/../../public/",
    ],

    "db"       => [
        "enabled"   => true,
        "driver"    => "mysql",
        "charset"   => "utf8",
        "collation" => "utf8_unicode_ci",
        "prefix"    => "",
        "port"      => "3306",
        "host"      => "localhost",
        "database"  => "react-auth",
        "username"  => "root",
        "password"  => "genesis",
    ],

    "twig"     => [
        "debug" => true,
    ],

    "jwt"      => [
        "secret"     => "dev",
        "secure"     => false,
        "authCookie" => "authToken",
        "dataCookie" => "dataToken",
    ],

    "password" => [
        "cryptmode" => PASSWORD_DEFAULT,
        "cost"      => 10,
    ],

];
