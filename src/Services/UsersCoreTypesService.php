<?php

namespace Bhry98\LaravelUsersCore\Services;

use Bhry98\LaravelUsersCore\Models\UsersCoreTypesModel;

class UsersCoreTypesService
{
    private const DEFAULT_TYPES = [
        "code" => "admin-user",
        "default_name" => "Admin User",
        "names" => [
            "ar" => "مستخدم مسؤول",
            "en" => "Admin User",
        ]
    ];
    private const NORMAL_USER = [
        "code" => "normal-user",
        "default_name" => "Normal User",
        "names" => [
            "ar" => "مستخدم عادي",
            "en" => "Normal User",
        ],
    ];

    static function getNormalUserType(): UsersCoreTypesModel|null
    {
        $data= UsersCoreTypesModel::where('code', 'normal-user')->first();
        dd($data);
    }
}
