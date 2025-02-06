<?php

namespace Bhry98\LaravelUsersCore\Services;

use Bhry98\LaravelUsersCore\Models\UsersCoreExtraColumnsModel;
use Bhry98\LaravelUsersCore\Models\UsersCoreUsersModel;
use Illuminate\Support\Facades\Log;

class UsersCoreUsersService
{
    public function registerNormalUser(array $data)
    {
        // check if normal user exists
        $normalUserType = UsersCoreTypesService::getNormalUserType();
        // if normal user type not found return null
        throw_if(!$normalUserType,"No user type [normal] found");
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
}
