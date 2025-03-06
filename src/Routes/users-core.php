<?php

use Bhry98\LaravelUsersCore\Http\Controllers\{
    UsersCoreController,
    UsersLocationsController,
    UsersAuthController,
    UsersTypeController
};
use Illuminate\Support\Facades\Route;
use Bhry98\LaravelUsersCore\Http\Middlewares\{
    GlobalResponseLocale,
};

Route::middleware([
    GlobalResponseLocale::class
])->group(function () {
    // helpers
    Route::middleware(config(key: 'bhry98-users-core.helpers_apis.middleware', default: ['api']))
        ->prefix(config(key: 'bhry98-users-core.helpers_apis.prefix', default: 'helpers'))
        ->name(config(key: 'bhry98-users-core.helpers_apis.name', default: 'bhry98-users-core') . ".helpers.")
        ->group(function () {
            Route::name("locations.")
                ->prefix("locations")
                ->group(function () {
                    Route::get('/countries', [UsersLocationsController::class, 'getAllCountries'])
                        ->name(name: 'get-all-countries'); // without auth
                    Route::get('/countries/{country_code}', [UsersLocationsController::class, 'getCountryDetails'])
                        ->name(name: 'get-country-details'); // without auth
                    Route::get('/countries/{country_code}/governorates', [UsersLocationsController::class, 'getAllGovernorates'])
                        ->name(name: 'get-all-governorates'); // without auth
                    Route::get('/countries/{country_code}/governorates/{governorate_code}', [UsersLocationsController::class, 'getGovernorateDetails'])
                        ->name(name: 'get-governorate-details'); // without auth
                    Route::get('/countries/{country_code}/governorates/{governorate_code}/cities', [UsersLocationsController::class, 'getAllCities'])
                        ->name(name: 'get-all-cities'); // without auth
                    Route::get('/countries/{country_code}/governorates/{governorate_code}/cities/{city_code}', [UsersLocationsController::class, 'getCityDetails'])
                        ->name(name: 'get-city-details'); // without auth
                });
            Route::name("types.")
                ->prefix("types")
                ->group(function () {
                    Route::get('/', [UsersTypeController::class, 'getAll'])
                        ->name(name: 'all-types'); // without auth
                });
        });
    // auth
    Route::middleware(config(key: 'bhry98-users-core.auth_apis.middleware', default: ['api']))
        ->prefix(config(key: 'bhry98-users-core.auth_apis.prefix', default: 'auth'))
        ->name(config(key: 'bhry98-users-core.auth_apis.name', default: 'bhry98-users-core') . ".auth.")
        ->group(function () {
            Route::post('/login', [UsersAuthController::class, 'login'])
                ->name(name: 'login'); // without auth
            Route::post('/resetPassword', [UsersAuthController::class, 'resetPassword'])
                ->name(name: 'reset-password'); // without auth
            Route::post('/verifyOtp', [UsersAuthController::class, 'verifyOtp'])
                ->name(name: 'verify-otp'); // without auth
            Route::post('/registration', [UsersAuthController::class, 'registration'])
                ->name(name: 'registration'); // without auth
            Route::post('/registrationByType', [UsersAuthController::class, 'registrationByType'])
                ->name(name: 'registration-by-type'); // without auth
            Route::get('/logout', [UsersAuthController::class, 'logout'])
                ->name(name: 'logout')
                ->middleware(['auth:sanctum']); // without auth
             Route::post('/updatePassword', [UsersAuthController::class, 'updatePassword'])
                ->name(name: 'update-password')
                ->middleware(['auth:sanctum']); // without auth
        });
    // users management
    Route::middleware(config(key: 'bhry98-users-core.users_apis.middleware', default: ['api', 'auth:sanctum']))
        ->prefix(config(key: 'bhry98-users-core.users_apis.prefix', default: 'users'))
        ->name(config(key: 'bhry98-users-core.users_apis.name', default: 'bhry98-users-core') . ".users.")
        ->group(function () {
            Route::get('/my', [UsersCoreController::class, 'getMyProfile'])
                ->name(name: 'my-profile'); // with auth
            Route::put('/my', [UsersCoreController::class, 'updateMyProfile'])
                ->name(name: 'update-my-profile'); // with auth
        });
});