<?php

namespace Bhry98\LaravelUsersCore;

use Bhry98\LaravelUsersCore\Commands\UsersTypeRunSeedCommand;
use Bhry98\LaravelUsersCore\Models\UsersCorePersonalAccessToken;
use Bhry98\LaravelUsersCore\Models\UsersCoreSessionsModel;
use Bhry98\LaravelUsersCore\Models\UsersCoreTypesModel;
use Bhry98\LaravelUsersCore\Models\UsersCoreUsersModel;
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
        $ds = DIRECTORY_SEPARATOR;
        // add commands
        self::PackageCommands();
        // Overwrite auth config
        self::PackageOverwriteConfigs();
        // Load package Translation
        self::PackageLocales();
        // Load package routes
        $this->loadRoutesFrom(path: __DIR__ . "{$ds}Routes{$ds}users-core.php");
        // Load migrations
        $this->loadMigrationsFrom(paths: __DIR__ . "{$ds}Database{$ds}Migrations");
        // Automatically publish migrations
        if ($this->app->runningInConsole()) {
            // Publish migration file
            $this->publishes([
                __DIR__ . "{$ds}Database{$ds}Migrations{$ds}" => database_path('migrations'),
            ], 'bhry98-users-core');
            // Publish config file
            $this->publishes([
                __DIR__ . "{$ds}Config{$ds}bhry98-users-core.php" => config_path('bhry98-users-core.php'),
            ], 'bhry98-users-core');
        }
    }

    function PackageOverwriteConfigs(): void
    {
        config()->set('auth.providers.users.model', UsersCoreUsersModel::class);
        config()->set('session.table', UsersCoreSessionsModel::TABLE_NAME);
        // Overriding Default Personal Access Token Models
        Sanctum::usePersonalAccessTokenModel(model: UsersCorePersonalAccessToken::class);

    }

    function PackageCommands(): void
    {
        $this->commands([
            UsersTypeRunSeedCommand::class
        ]);
    }

    function PackageLocales(): void
    {
        $ds = DIRECTORY_SEPARATOR;
        $this->loadTranslationsFrom(
            path: __DIR__ . "{$ds}Lang", namespace: "bhry98");
    }
}
