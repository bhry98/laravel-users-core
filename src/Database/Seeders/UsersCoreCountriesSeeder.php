<?php

namespace Bhry98\LaravelUsersCore\Database\Seeders;

use Bhry98\LaravelUsersCore\Models\UsersCoreCountriesModel;
use Bhry98\LaravelUsersCore\Models\UsersCoreTypesModel;
use Bhry98\LaravelUsersCore\Services\UsersCoreTypesService;
use Illuminate\Database\Seeder;

class UsersCoreCountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ds = DIRECTORY_SEPARATOR;
        $countriesArray = include __DIR__ . "{$ds}..{$ds}Data{$ds}countries.php";
        foreach ($countriesArray ?? [] as $country) {
            $fixData=[
                "country_code"=>$country["code"],
                "name"=>$country["name"],
                "local_name"=>$country["local_name"],
                "flag"=>$country["flag"],
                "lang_key"=>$country["lang_key"],
                "system_lang" => false,
            ];
            UsersCoreCountriesModel::create($fixData);
        }
    }
}