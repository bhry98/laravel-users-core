<?php

namespace Bhry98\LaravelUsersCore\Services;

use Bhry98\LaravelUsersCore\Models\{
    UsersCoreCountriesModel
};

class UsersCoreLocationsService
{
    static function getAllCountries(int $perPage = 10, string|null $searchForWord = null)
    {
        $data = UsersCoreCountriesModel::withCount('users', 'cities');
        if (!empty($searchForWord)) {
            $data->where('name', 'like', '%' . $searchForWord . '%')
                ->orWhere('local_name', 'like', '%' . $searchForWord . '%');
        }
        return $data->paginate(
            columns: [
                "*"
            ],
            perPage: $perPage,
            pageName: "Countries"
        );
    }

    static function getCountryDetails($countryCode, array|null $relations = null)
    {
        $data = UsersCoreCountriesModel::where('code', $countryCode)->withCount('users', 'cities','governorates');
        if (!is_null($relations)) {
            $data->with($relations);
        }
        return $data->first();
    }

}
