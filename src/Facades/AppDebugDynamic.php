<?php

namespace Benjaminhu\LaravelAppDebugDynamic\Facades;

use Illuminate\Support\Facades\Facade;

class AppDebugDynamic extends Facade
{
    public static function getFacacdeAccessor(): string
    {
        return 'laravel-app-debug-dynamic';
    }
}
