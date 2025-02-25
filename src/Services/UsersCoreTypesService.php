<?php

namespace Bhry98\LaravelUsersCore\Services;

use Bhry98\LaravelUsersCore\Models\UsersCoreTypesModel;

class UsersCoreTypesService
{
    const ADMIN_USER = [
        "default_name" => "Admin User",
        "names" => [
            "ar" => "مستخدم مسؤول",
            "en" => "Admin User",
        ],
        "api_access" => false,
        "can_delete" => false
    ];
    const NORMAL_USER = [
        "default_name" => "Normal User",
        "names" => [
            "ar" => "مستخدم عادي",
            "en" => "Normal User",
        ],
        "api_access" => true,
        "can_delete" => true
    ];

    static function getNormalUserType()
    {
        return UsersCoreTypesModel::where('default_name', self::NORMAL_USER['default_name'])->first();
    }

    static function getByCode(string $code, array|null $relations = null)
    {
        $type = UsersCoreTypesModel::where('api_access', true)->where('code', $code);
        if (!is_null($relations)) {
            $type->with($relations);
        }
        return $type->first();
    }

    static function getAllTypes(int $perPage = 10, string|null $searchForWord = null)
    {
        $data = UsersCoreTypesModel::where('api_access', true)->withCount('Users');
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
