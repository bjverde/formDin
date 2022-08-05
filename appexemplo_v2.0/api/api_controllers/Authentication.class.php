<?php

namespace api_controllers;

use Tuupola\Middleware\HttpBasicAuthentication;

class Authentication
{

    public function __construct()
    {
    }

    public static function basicAuth(): HttpBasicAuthentication
    {
        return new HttpBasicAuthentication([
            "users" => [
                "root" => "teste123"
            ]
        ]);
    }
}