<?php

namespace Bhry98\LaravelUsersCore\Services;

use Bhry98\LaravelUsersCore\Models\UsersCoreTypesModel;
use Bhry98\LaravelUsersCore\UsersCoreTypesModelTest;

class UsersCoreTypesService
{
     const ADMIN_USER = [
        "code" => "admin-user",
        "default_name" => "Admin User",
        "names" => [
            "ar" => "مستخدم مسؤول",
            "en" => "Admin User",
        ]
    ];
     const NORMAL_USER = [
        "code" => "normal-user",
        "default_name" => "Normal User",
        "names" => [
            "ar" => "مستخدم عادي",
            "en" => "Normal User",
        ],
    ];

    static function getNormalUserType()
    {
        return UsersCoreTypesModel::where('code', self::NORMAL_USER['code'])->first();
    }
}
