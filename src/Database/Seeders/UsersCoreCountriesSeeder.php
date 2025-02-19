<?php

namespace Bhry98\LaravelUsersCore\Database\Seeders;

use Bhry98\LaravelUsersCore\Models\UsersCoreCitiesModel;
use Bhry98\LaravelUsersCore\Models\UsersCoreCountriesModel;
use Bhry98\LaravelUsersCore\Models\UsersCoreGovernoratesModel;
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
            $fixData = [
                "country_code" => $country["code"],
                "name" => $country["name"],
                "local_name" => $country["local_name"],
                "flag" => $country["flag"],
                "lang_key" => $country["lang_key"],
                "system_lang" => false,
            ];
            $countryAfterAdd = UsersCoreCountriesModel::create($fixData);
            if ($countryAfterAdd) {
                match ($country["code"]) {
                    "EG" => self::addEgyptGovernorates($countryAfterAdd?->id),
                    "SA" => self::addSaudiArabiaGovernorates($countryAfterAdd?->id),
                    default => null,
                };
            }
        }
    }

    /**
     * @param $egypt_id
     * @return void
     * to add all egypt governorates and call add cities method for each governorate
     */
    static function addEgyptGovernorates($egypt_id): void
    {
        $ds = DIRECTORY_SEPARATOR;
        $egyptGovernoratesArray = include __DIR__ . "{$ds}..{$ds}Data{$ds}governorates{$ds}egypt.php";
        foreach ($egyptGovernoratesArray ?? [] as $governorate) {
            $fixData = [
                "name" => $governorate["name"],
                "local_name" => $governorate["local_name"],
                "country_id" => $egypt_id
            ];
            $governorateAfterAdd = UsersCoreGovernoratesModel::create($fixData);
            if ($governorateAfterAdd) {
                match ($governorate["name"]) {
                    "Cairo" => self::addEgyptCairoCities($egypt_id, $governorateAfterAdd?->id),
                    "Giza" => self::addEgyptGizaCities($egypt_id, $governorateAfterAdd?->id),
                    "Alexandria" => self::addEgyptAlexandriaCities($egypt_id, $governorateAfterAdd?->id),
                    default => null,
                };
            }
        }
    }

    /**
     * @param $egypt_id
     * @param $cairo_id
     * @return void
     * to add all cities in cairo
     */
    static function addEgyptCairoCities($egypt_id, $cairo_id): void
    {
        $ds = DIRECTORY_SEPARATOR;
        $egyptCairoCitiesArray = include __DIR__ . "{$ds}..{$ds}Data{$ds}cities{$ds}egypt{$ds}cairo.php";
        foreach ($egyptCairoCitiesArray ?? [] as $city) {
            $fixData = [
                "name" => $city["name"],
                "local_name" => $city["local_name"],
                "country_id" => $egypt_id,
                "governorate_id" => $cairo_id
            ];
            UsersCoreCitiesModel::create($fixData);
        }
    }

    /**
     * @param $egypt_id
     * @param $giza_id
     * @return void
     * to add all cities in giza
     */
    static function addEgyptGizaCities($egypt_id, $giza_id): void
    {
        $ds = DIRECTORY_SEPARATOR;
        $egyptCairoCitiesArray = include __DIR__ . "{$ds}..{$ds}Data{$ds}cities{$ds}egypt{$ds}giza.php";
        foreach ($egyptCairoCitiesArray ?? [] as $city) {
            $fixData = [
                "name" => $city["name"],
                "local_name" => $city["local_name"],
                "country_id" => $egypt_id,
                "governorate_id" => $giza_id
            ];
            UsersCoreCitiesModel::create($fixData);
        }
    }

    /**
     * @param $egypt_id
     * @param $alexandria_id
     * @return void
     * to add all cities in alexandria
     */
    static function addEgyptAlexandriaCities($egypt_id, $alexandria_id): void
    {
        $ds = DIRECTORY_SEPARATOR;
        $egyptCairoCitiesArray = include __DIR__ . "{$ds}..{$ds}Data{$ds}cities{$ds}egypt{$ds}alexandria.php";
        foreach ($egyptCairoCitiesArray ?? [] as $city) {
            $fixData = [
                "name" => $city["name"],
                "local_name" => $city["local_name"],
                "country_id" => $egypt_id,
                "governorate_id" => $alexandria_id
            ];
            UsersCoreCitiesModel::create($fixData);
        }
    }

    static function addSaudiArabiaGovernorates($saudi_arabia_id): void
    {
        $ds = DIRECTORY_SEPARATOR;
        $egyptGovernoratesArray = include __DIR__ . "{$ds}..{$ds}Data{$ds}governorates{$ds}saudi_arabia.php";
        foreach ($egyptGovernoratesArray ?? [] as $governorate) {
            $fixData = [
                "name" => $governorate["name"],
                "local_name" => $governorate["local_name"],
                "country_id" => $saudi_arabia_id
            ];
            UsersCoreGovernoratesModel::create($fixData);
        }
    }
}