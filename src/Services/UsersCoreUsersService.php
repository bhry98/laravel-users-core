<?php

namespace Bhry98UsersCore\Services;

use Bhry98\LaravelUsersCore\Models\UsersCoreExtraColumnsModel;
use Bhry98\LaravelUsersCore\Models\UsersCoreUsersModel;

class UsersCoreUsersService
{


    public function registerNormalUser(array $data)
    {
        // check if normal user exists
//        $normalUserType = UsersCoreTypesService::getNormalUserType();
        $normalUserType = null;
        dd(UsersCoreExtraColumnsModel::count());
        // if normal user type not found return null
        if (!$normalUserType) return null;
        // add normal user in database
        $data['type_id'] = $normalUserType->id;
        return UsersCoreUsersModel::create($data);
    }
}
