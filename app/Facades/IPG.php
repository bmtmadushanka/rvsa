<?php

namespace App\Facades;

class IPG
{
    protected static function resolveFacade($name)
    {
        return app()[$name];
    }

    public static function __callStatic($method, $args)
    {
        return (self::resolveFacade('IPG'))->$method(...$args);
    }
}
