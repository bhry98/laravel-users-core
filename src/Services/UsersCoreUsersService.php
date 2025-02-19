<?php

namespace Bhry98\LaravelUsersCore\Services;

use Bhry98\LaravelUsersCore\Models\UsersCoreExtraColumnsModel;
use Bhry98\LaravelUsersCore\Models\UsersCoreUsersModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UsersCoreUsersService
{
    public function registerNormalUser(array $data)
    {
        // check if normal user exists
        $normalUserType = UsersCoreTypesService::getNormalUserType();
        // if normal user type not found return null
        throw_if(!$normalUserType, "No user type [normal] found");
        // add normal user in database
        $data['type_id'] = $normalUserType->id;
        $user = UsersCoreUsersModel::create($data);
        if ($user) {
            // if added successfully add log [info] and return user
            Log::info("User registered successfully with id {$user->id}", ['user' => $user]);
            return $user;
        } else {
            // if added successfully add log [error] and return user
            Log::error("User registered field");
            return null;
        }
    }

    public function registerByType(array $data)
    {
        // check if normal user exists
        $userType = UsersCoreTypesService::getByCode(code: $data['type_code']);
        // if normal user type not found return null
        throw_if(!$userType, "No user type found");
        // add normal user in database
        $data['type_id'] = $userType->id;
        $user = UsersCoreUsersModel::create($data);
        if ($user) {
            // if added successfully add log [info] and return user
            Log::info("User registered successfully with id {$user->id}", ['user' => $user]);
            return $user;
        } else {
            // if added successfully add log [error] and return user
            Log::error("User registered field");
            return null;
        }
    }

    public function loginViaUser(UsersCoreUsersModel|\Illuminate\Contracts\Auth\Authenticatable $user): string
    {
        Auth::guard(name: config(key: "bhry98-users-core.guard"))->loginUsingId($user->id);
        $tokenResult = $user->createToken($user->code);
        return $tokenResult->plainTextToken;
    }

    static public function getAuthUser(array|null $relations = null): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        $authUser = Auth::user();
        $user = UsersCoreUsersModel::where('code', $authUser?->code);
        if ($user && $relations) {
            $user->with($relations);
        }
        return $user->first();
    }

    public function loginViaUsernameAndPassword(array $data): string|null
    {
        if (Auth::attempt(['username' => $data['username'], 'password' => $data['password']])) {
            $user = self::getAuthUser();
            Log::info("User login successfully with id {$user?->id}", ['user' => $user]);
            return self::loginViaUser($user);
        } else {
            Log::error("User login failed", ['credential' => $data]);
            return null;
        }
    }

    public function loginViaPhoneAndPassword(array $data): string|null
    {
        if (Auth::attempt(['phone_number' => $data['phone_number'], 'password' => $data['password']])) {
            $user = self::getAuthUser();
            Log::info("User login successfully with id {$user?->id}", ['user' => $user]);
            return self::loginViaUser($user);
        } else {
            Log::error("User login failed", ['credential' => $data]);
            return null;
        }
    }

    public function logout(): bool
    {
        Auth::user()?->currentAccessToken()->delete();
        Auth::forgetUser();
        return !auth()->check();
    }
}
