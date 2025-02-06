<?php

namespace Bhry98\LaravelUsersCore\Services;

use Bhry98\LaravelUsersCore\Models\UsersCoreTypesModel;

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
        return UsersCoreTypesModel::where('default_name', self::NORMAL_USER['default_name'])->first();
    }

    static function getAllTypes(int $perPage = 10, string|null $searchForWord = null)
    {
        $data = UsersCoreTypesModel::withCount('Users');
        if (!empty($searchForWord)) {
            $data->where('default_name', 'like', '%' . $searchForWord . '%');
        }
        return $data->paginate(
            columns: [
                "*"
            ],
            perPage: $perPage,
            pageName: "Types"
        );
    }
}
