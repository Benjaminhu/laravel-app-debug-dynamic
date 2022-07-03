<?php

namespace Benjaminhu\LaravelAppDebugDynamic;

use Benjaminhu\LaravelAppDebugDynamic\Facades\AppDebugDynamic;
use Illuminate\Support\ServiceProvider;

class AppDebugDynamicServiceProvider extends ServiceProvider
{
    private string $configFile = __DIR__ . '/../config/app-debug-dynamic.php';

    public function boot()
    {
        $this->publishes([$this->configFile => config_path('app-debug-dynamic.php')], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom($this->configFile, AppDebugDynamic::getFacacdeAccessor());
    }
}
