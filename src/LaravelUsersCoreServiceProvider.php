<?php

namespace Bhry98\LaravelUsersCore;

use Bhry98\LaravelUsersCore\Models\UsersCorePersonalAccessToken;
use Bhry98\LaravelUsersCore\Models\UsersCoreTypesModel;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class LaravelUsersCoreServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        // Merge package config
        $this->mergeConfigFrom(path: __DIR__ . '/Config/bhry98-users-core.php', key: 'bhry98-users-core');
    }

    public function boot(): void
    {
        // Overriding Default Personal Access Token Models
        Sanctum::usePersonalAccessTokenModel(UsersCorePersonalAccessToken::class);
        // Load package routes
        $this->loadRoutesFrom(path: __DIR__ . '/Routes/users-core.php');
        // Load migrations
        $this->loadMigrationsFrom(paths: __DIR__ . '/Migrations');
        // Automatically publish migrations
        if ($this->app->runningInConsole()) {
            // Publish migration file
            $this->publishes([
                __DIR__ . '/Migrations/' => database_path('migrations'),
            ], 'bhry98-users-core');
            // Publish config file
            $this->publishes([
                __DIR__ . '/Config/bhry98-users-core.php' => config_path('bhry98-users-core.php'),
            ], 'bhry98-users-core');
        }
    }

    static function testOutput(): string
    {
        return "run successfully";
    }
}
