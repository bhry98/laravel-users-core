<?php


use Bhry98\LaravelUsersCore\Http\Controllers\{
    UsersTypeController
};
use Bhry98\LaravelUsersCore\Http\Controllers\UsersAuthController;
use Bhry98\LaravelUsersCore\Http\Controllers\UsersCoreController;
use Illuminate\Support\Facades\Route;
use Bhry98\LaravelUsersCore\Http\Middlewares\{GlobalResponseLocale};

Route::middleware([
    GlobalResponseLocale::class
])->group(function () {
// users auth
    Route::middleware(config(key: 'laravel-users-core.auth_apis.middleware', default: ['api']))
        ->prefix(config(key: 'laravel-users-core.auth_apis.prefix', default: 'auth'))
        ->name(config(key: 'laravel-users-core.auth_apis.name', default: 'bhry98-users-core') . ".auth.")
        ->group(function () {
            Route::post('/login', [UsersAuthController::class, 'login'])->name(name: 'login');
            Route::post('/registration', [UsersAuthController::class, 'registration'])->name(name: 'registration');
        });

// users management
    Route::middleware(config(key: 'laravel-users-core.apis_middlewares', default: ['api']))
        ->prefix(config(key: 'laravel-users-core.apis_prefix', default: 'users'))
        ->name(config(key: 'laravel-users-core.apis.name', default: 'bhry98-users-core') . ".users.")
        ->group(function () {
            Route::get('/', [UsersCoreController::class, 'getAll'])->name(name: 'all-users');
        });

// types management
    Route::middleware(config(key: 'laravel-users-core.apis_middlewares', default: ['api']))
        ->prefix(config(key: 'laravel-users-core.apis_prefix', default: 'types'))
        ->name(config(key: 'laravel-users-core.apis.name', default: 'bhry98-users-core') . ".types.")
        ->group(function () {
            Route::get('/', [UsersTypeController::class, 'getAll'])->name(name: 'all-types');
        });

});