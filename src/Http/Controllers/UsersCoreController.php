<?php

namespace Bhry98\LaravelUsersCore\Http\Controllers;

use App\Http\Controllers\Controller;
use Bhry98\LaravelUsersCore\Http\Requests\auth\LoginRequest;
use Bhry98\LaravelUsersCore\Http\Resources\UserResource;
use Bhry98\LaravelUsersCore\Services\UsersCoreUsersService;

class UsersCoreController extends Controller
{
    function getMyProfile(UsersCoreUsersService $usersCoreServices): \Illuminate\Http\JsonResponse
    {

        try {
            $userData = $usersCoreServices->getAuthUser();
            if (!$userData) return bhry98_response_success_without_data();
            return bhry98_response_success_with_data(UserResource::make($userData));
        } catch (\Exception $e) {
            return bhry98_response_internal_error([
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
            ]);
        }
    }
}
