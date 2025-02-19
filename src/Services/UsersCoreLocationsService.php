<?php

namespace Bhry98\LaravelUsersCore\Services;

use Bhry98\LaravelUsersCore\Models\{UsersCoreCitiesModel, UsersCoreCountriesModel, UsersCoreGovernoratesModel};

class UsersCoreLocationsService
{
    /////////////////////////////////////////////////////////////////////////////////
    /////////                      Countries Functions                  /////////////
    /////////////////////////////////////////////////////////////////////////////////
    static function getAllCountries(int $pageNumber = 0, int $perPage = 10, string|null $searchForWord = null)
    {
        $data = UsersCoreCountriesModel::withCount('users', 'cities', 'governorates');
        if (!empty($searchForWord)) {
            $data->where('name', 'like', '%' . $searchForWord . '%')
                ->orWhere('local_name', 'like', '%' . $searchForWord . '%');
            $pageNumber = 0;
        }
        return $data->paginate(
            columns: [
                "*"
            ],
            perPage: $perPage,
            page: $pageNumber,
//            pageName: $pageNumber
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
    static function getAllGovernoratesByCountryCode(string $country_code, int $pageNumber = 0, int $perPage = 10, string|null $searchForWord = null, array|null $relations = null)
    {
        $country = UsersCoreCountriesModel::where('code', "$country_code")->first();
        $data = UsersCoreGovernoratesModel::where('country_id', $country?->id)->withCount('users', 'cities');
        if (!empty($searchForWord)) {
            $data->where('name', 'like', '%' . $searchForWord . '%')
                ->orWhere('local_name', 'like', '%' . $searchForWord . '%');
            $pageNumber = 0;
        }
        if (!empty($relations)) {
            $data->with($relations);
        }
        return $data->paginate(
            columns: [
                "*"
            ],
            perPage: $perPage,
            page: $pageNumber,
        );
    }

    static function getGovernorateDetails($governorateCode, array|null $relations = null)
    {
        $data = UsersCoreGovernoratesModel::where('code', $governorateCode)
            ->withCount('users', 'cities');
        if (!is_null($relations)) {
            $data->with($relations);
        }
        return $data->first();
    }
    /////////////////////////////////////////////////////////////////////////////////
    /////////                      Cities Functions                  //////////
    /////////////////////////////////////////////////////////////////////////////////
    static function getAllCitiesByGovernorateCode(string $governorate_code, int $pageNumber = 0, int $perPage = 10, string|null $searchForWord = null, array|null $relations = null)
    {
        $governorate = UsersCoreGovernoratesModel::where('code', "$governorate_code")->first();
        $data = UsersCoreCitiesModel::where('governorate_id', $governorate?->id)->withCount('users');
        if (!empty($searchForWord)) {
            $data->where('name', 'like', '%' . $searchForWord . '%')
                ->orWhere('local_name', 'like', '%' . $searchForWord . '%');
            $pageNumber = 0;
        }
        if (!empty($relations)) {
            $data->with($relations);
        }
        return $data->paginate(
            columns: [
                "*"
            ],
            perPage: $perPage,
            page: $pageNumber,
        );
    }

    static function getCityDetails($cityCode, array|null $relations = null)
    {
        $data = UsersCoreCitiesModel::where('code', $cityCode)
            ->withCount('users');
        if (!is_null($relations)) {
            $data->with($relations);
        }
        return $data->first();
    }

}
