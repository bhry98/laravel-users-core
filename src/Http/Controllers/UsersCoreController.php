<?php

namespace Bhry98\LaravelUsersCore\Http\Controllers;

use App\Http\Controllers\Controller;
use Bhry98\LaravelUsersCore\Http\Requests\auth\LoginRequest;
use Bhry98\LaravelUsersCore\Http\Requests\users\UserGetProfileRequest;
use Bhry98\LaravelUsersCore\Http\Requests\users\UserUpdateProfileRequest;
use Bhry98\LaravelUsersCore\Http\Resources\UserResource;
use Bhry98\LaravelUsersCore\Services\UsersCoreUsersService;

class UsersCoreController extends Controller
{
    function getMyProfile(UserGetProfileRequest $request, UsersCoreUsersService $usersCoreServices): \Illuminate\Http\JsonResponse
    {

        try {
            $userData = $usersCoreServices->getAuthUser($request->with);
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

    function updateMyProfile(UserUpdateProfileRequest $request, UsersCoreUsersService $usersCoreServices): \Illuminate\Http\JsonResponse
    {
        try {
//            dd($request->validated());
            $action = $usersCoreServices->updateProfile($request->validated());
            if ($action) {
                return bhry98_response_success_with_data(message: __("bhry98::users.profile-update-success"));
            }
            return bhry98_response_success_without_data();
        } catch (\Exception $e) {
            return bhry98_response_internal_error([
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
            ]);
        }
    }
}
