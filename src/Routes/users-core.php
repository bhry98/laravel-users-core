<?php

use Bhry98\LaravelUsersCore\Http\Controllers\{
    UsersCoreController,
    UsersLocationsController,
    UsersAuthController,
    UsersTypeController
};
use Illuminate\Support\Facades\Route;
use Bhry98\LaravelUsersCore\Http\Middlewares\{
    GlobalResponseLocale
};

Route::middleware([
    GlobalResponseLocale::class
])->group(function () {
    // locations
    Route::middleware(config(key: 'laravel-users-core.auth_apis.middleware', default: ['api']))
        ->prefix(config(key: 'laravel-users-core.auth_apis.prefix', default: 'locations'))
        ->name(config(key: 'laravel-users-core.auth_apis.name', default: 'bhry98-users-core') . ".locations.")
        ->group(function () {
            Route::get('/countries', [UsersLocationsController::class, 'getAllCountries'])
                ->name(name: 'get-all-countries'); // without auth
            Route::get('/countries/{country_code}', [UsersLocationsController::class, 'getCountryDetails'])
                ->name(name: 'get-country-details'); // without auth
        });
    // users auth
    Route::middleware(config(key: 'laravel-users-core.auth_apis.middleware', default: ['api']))
        ->prefix(config(key: 'laravel-users-core.auth_apis.prefix', default: 'auth'))
        ->name(config(key: 'laravel-users-core.auth_apis.name', default: 'bhry98-users-core') . ".auth.")
        ->group(function () {
            Route::post('/login', [UsersAuthController::class, 'login'])
                ->name(name: 'login'); // without auth
            Route::post('/registration', [UsersAuthController::class, 'registration'])
                ->name(name: 'registration'); // without auth
        });

    // types management
    Route::middleware(config(key: 'laravel-users-core.apis_middlewares', default: ['api']))
        ->prefix(config(key: 'laravel-users-core.apis_prefix', default: 'types'))
        ->name(config(key: 'laravel-users-core.apis.name', default: 'bhry98-users-core') . ".types.")
        ->group(function () {
            Route::get('/', [UsersTypeController::class, 'getAll'])
                ->name(name: 'all-types'); // without auth
        });

    // users management
    Route::middleware(config(key: 'laravel-users-core.apis_middlewares', default: ['api','auth:sanctum']))
        ->prefix(config(key: 'laravel-users-core.apis_prefix', default: 'users'))
        ->name(config(key: 'laravel-users-core.apis.name', default: 'bhry98-users-core') . ".users.")
        ->group(function () {
            Route::get('/my', [UsersCoreController::class, 'getMyProfile'])
                ->name(name: 'my-profile'); // with auth
        });


});