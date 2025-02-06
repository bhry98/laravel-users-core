<?php

namespace Bhry98\LaravelUsersCore\Controllers;

use App\Http\Controllers\Controller;
use Bhry98\LaravelUsersCore\Requests\auth\LoginRequest;
use Bhry98\LaravelUsersCore\Requests\auth\RegistrationNormalUserRequest;
use Bhry98\LaravelUsersCore\Services\UsersCoreUsersService;
use Illuminate\Support\Facades\Auth;

class UsersAuthController extends Controller
{
    function registration(RegistrationNormalUserRequest $request, UsersCoreUsersService $usersCoreServices): \Illuminate\Http\JsonResponse
    {
        try {
            $user = $usersCoreServices->registerNormalUser($request->validated());
            if ($user) {
                // login user to return with token
                Auth::guard(name: config(key: "bhry98-users-core"))->login($user);
                $tokenResult = $user->createToken($user->code);
                $token = $tokenResult->plainTextToken;
                return bhry98_response_success_with_data([
                    'accessType' => 'Bearer',
                    'accessToken' => $token,
                    "user" => $user,
                ]);
            } else {
                return bhry98_response_success_without_data();
            }
        } catch (\Exception $e) {
            return bhry98_response_internal_error([
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
            ]);
        }
    }

    function login(LoginRequest $request)
    {
        return $request->validated();
    }


}
