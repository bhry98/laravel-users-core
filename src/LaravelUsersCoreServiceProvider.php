<?php

namespace Bhry98\LaravelUsersCore;

use Illuminate\Support\ServiceProvider;

class LaravelUsersCoreServiceProvider extends ServiceProvider
{

    public function register(): void
    {

        // Merge package config
        $this->mergeConfigFrom(path: __DIR__ . '/Config/bhry98-users-core.php', key: 'bhry98-users-core');
    }

    public function boot(): void
    {
        // Load package routes
        $this->loadRoutesFrom(path: __DIR__ . '/Routes/users-core.php');
        // Load migrations
        $this->loadMigrationsFrom(paths: __DIR__ . '/Migrations');
        // Publish files for customization
        $this->publishes([
            __DIR__ . '/Config/bhry98-users-core.php' => config_path(path: 'bhry98-users-core.php'),
        ], groups: 'bhry98');
    }
}
