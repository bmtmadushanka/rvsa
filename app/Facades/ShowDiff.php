<?php

namespace App\Facades;

class ShowDiff
{
    protected static function resolveFacade($name)
    {
        return app()[$name];
    }

    public static function __callStatic($method, $args)
    {
        return (self::resolveFacade('Diff'))->$method(...$args);
    }
}
