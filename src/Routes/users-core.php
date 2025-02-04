<?php


use Illuminate\Support\Facades\Route;
use \Bhry98\LaravelUsersCore\Controllers\{
    UsersCoreController,
    UsersAuthController
};

// users auth
Route::middleware(config(key: 'laravel-users-core.auth_apis.middleware', default: ['api']))
    ->prefix(config(key: 'laravel-users-core.auth_apis.prefix', default: 'auth'))
    ->name(config(key: 'laravel-users-core.auth_apis.name', default: 'bhry98-users-core') . ".auth.")
    ->group(function () {
        Route::post('/login', [UsersAuthController::class, 'login'])->name(name: 'login');
        Route::post('/registration', [UsersAuthController::class, 'registration'])->name(name: 'registration');
    });

// users management
Route::middleware(config(key: 'laravel-users-core.apis_middlewares', default: ['web']))
    ->prefix(config(key: 'laravel-users-core.apis_prefix', default: 'users'))
    ->name(config(key: 'laravel-users-core.apis.name', default: 'bhry98-users-core').".users.")
    ->group(function () {
        Route::get('/', [UsersCoreController::class, 'getAll'])->name(name: 'all-users');
    });
