<?php

namespace Bhry98\LaravelUsersCore\Database\Seeders;

use Bhry98\LaravelUsersCore\Models\UsersCoreTypesModel;
use Bhry98\LaravelUsersCore\Services\UsersCoreTypesService;
use Illuminate\Database\Seeder;

class UsersCoreTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UsersCoreTypesModel::create(UsersCoreTypesService::NORMAL_USER);
        UsersCoreTypesModel::create(UsersCoreTypesService::ADMIN_USER);
        foreach (config(key: "bhry98-users-core.types_to_add", default: []) ?? [] as $type) {
            UsersCoreTypesModel::create($type);
        }
    }
}