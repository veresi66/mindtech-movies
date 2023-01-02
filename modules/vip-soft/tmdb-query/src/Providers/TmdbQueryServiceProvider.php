<?php

namespace VipSoft\TmdbQuery\Providers;

use Illuminate\Support\ServiceProvider;
use VipSoft\TmdbQuery\Console\Commands\TmdbInitialize;
use VipSoft\TmdbQuery\Console\Commands\TmdbUpdate;

class TmdbQueryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'core');

        $this->publishes([
            __DIR__ . '/../resources/views' => base_path('modules/vip-soft/tmdb-query/resources/views')
        ]);
        
        $this->commands([
            TmdbUpdate::class,
            TmdbInitialize::class,
        ]);
    }
}
