<?php

namespace App\Facades;

class SMS
{
    protected static function resolveFacade($name)
    {
        return app()[$name];
    }

    public static function __callStatic($method, $args)
    {
        return (self::resolveFacade('SMS'))->$method(...$args);
    }
}
