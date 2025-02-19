<?php

namespace Bhry98\LaravelUsersCore\Services;

use Bhry98\LaravelUsersCore\Models\{UsersCoreCountriesModel, UsersCoreGovernoratesModel};

class UsersCoreLocationsService
{
    /////////////////////////////////////////////////////////////////////////////////
    /////////                      Countries Functions                  /////////////
    /////////////////////////////////////////////////////////////////////////////////
    static function getAllCountries(int $perPage = 10, string|null $searchForWord = null)
    {
        $data = UsersCoreCountriesModel::withCount('users', 'cities', 'governorates');
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
        $data = UsersCoreCountriesModel::where('code', $countryCode)
            ->withCount('users', 'cities', 'governorates');
        if (!is_null($relations)) {
            $data->with($relations);
        }
        return $data->first();
    }

    /////////////////////////////////////////////////////////////////////////////////
    /////////                      Governorates Functions                  //////////
    /////////////////////////////////////////////////////////////////////////////////
    static function getAllGovernoratesByCountryCode(string $country_code, int $perPage = 10, string|null $searchForWord = null, array|null $relations = null)
    {
        $country = UsersCoreCountriesModel::where('code', "$country_code")->first();
        $data = UsersCoreGovernoratesModel::where('country_id', $country?->id)->withCount('users', 'cities');
        if (!empty($searchForWord)) {
            $data->where('name', 'like', '%' . $searchForWord . '%')
                ->orWhere('local_name', 'like', '%' . $searchForWord . '%');
        }
        if (!empty($relations)) {
            $data->with($relations);
        }
        return $data->paginate(
            columns: [
                "*"
            ],
            perPage: $perPage,
            pageName: "Governorates"
        );
    }

}
