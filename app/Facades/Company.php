<?php

namespace App\Facades;

class Company
{
    protected static function resolveFacade($name)
    {
        return app()[$name];
    }

    public static function __callStatic($method, $args)
    {
        return (self::resolveFacade('Company'))->$method(...$args);
    }
}
