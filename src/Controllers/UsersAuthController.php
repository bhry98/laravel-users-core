<?php

namespace Bhry98UsersCore\Controllers;

use App\Http\Controllers\Controller;
use Bhry98UsersCore\Models\UsersCoreUsersModel;
use Bhry98UsersCore\Requests\auth\LoginRequest;
use Bhry98UsersCore\Requests\auth\RegistrationNormalUserRequest;
use Bhry98UsersCore\Services\UsersCoreUsersService;

class UsersAuthController extends Controller
{
    function registration(RegistrationNormalUserRequest $request, UsersCoreUsersService $usersCoreServices)
    {
        try {
            // add user in database with type = normal user
            $user = $usersCoreServices->registerNormalUser($request->validated());
            if ($user) {
                return $user;
            } else {
                return null;
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    function login(LoginRequest $request)
    {
        return $request->validated();
    }


}
