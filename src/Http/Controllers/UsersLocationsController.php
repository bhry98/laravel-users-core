<?php

namespace Bhry98\LaravelUsersCore\Http\Controllers;

use App\Http\Controllers\Controller;
use Bhry98\LaravelUsersCore\Http\Requests\locations\{GetAllCitiesRequest,
    GetAllCountriesRequest,
    GetAllGovernoratesRequest,
    GetCityDetailsRequest,
    GetCountryDetailsRequest,
    GetGovernorateDetailsRequest
};
use Bhry98\LaravelUsersCore\Services\{
    UsersCoreLocationsService
};
use Bhry98\LaravelUsersCore\Http\Resources\{CityResource, CountryResource, GovernorateResource};

class UsersLocationsController extends Controller
{
    function getAllCountries(GetAllCountriesRequest $request, UsersCoreLocationsService $locationsService): \Illuminate\Http\JsonResponse
    {
        try {
            $countriesData = $locationsService->getAllCountries($request->pageNumber, $request->perPage, $request->searchForWord);
            if ($countriesData) {
                return bhry98_response_success_with_data(CountryResource::collection($countriesData)->response()->getData(true));
            } else {
                return bhry98_response_success_without_data();
            }
        } catch (\Exception $e) {
            return bhry98_response_internal_error([
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
            ]);
        }

    }

    function getCountryDetails($countryDetails, GetCountryDetailsRequest $request, UsersCoreLocationsService $locationsService): \Illuminate\Http\JsonResponse
    {
        try {
            $countriesData = $locationsService->getCountryDetails($countryDetails);
            if ($countriesData) {
//                return bhry98_response_success_with_data((array)$countriesData);
                return bhry98_response_success_with_data(CountryResource::make($countriesData));
            } else {
                return bhry98_response_success_without_data();
            }
        } catch (\Exception $e) {
            return bhry98_response_internal_error([
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
            ]);
        }

    }

    function getAllGovernorates(GetAllGovernoratesRequest $request, UsersCoreLocationsService $locationsService): \Illuminate\Http\JsonResponse
    {
        try {
            $countriesData = $locationsService->getAllGovernoratesByCountryCode($request->country_code, $request->pageNumber, $request->perPage, $request->searchForWord, $request->with);
            if ($countriesData) {
                return bhry98_response_success_with_data(GovernorateResource::collection($countriesData)->response()->getData(true));
            } else {
                return bhry98_response_success_without_data();
            }
        } catch (\Exception $e) {
            return bhry98_response_internal_error([
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
            ]);
        }

    }

    function getGovernorateDetails(GetGovernorateDetailsRequest $request, UsersCoreLocationsService $locationsService): \Illuminate\Http\JsonResponse
    {
        try {
            $governorateDetails = $locationsService->getGovernorateDetails($request->governorate_code, $request->with);
            if ($governorateDetails) {
                return bhry98_response_success_with_data(GovernorateResource::make($governorateDetails));
            } else {
                return bhry98_response_success_without_data();
            }
        } catch (\Exception $e) {
            return bhry98_response_internal_error([
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
            ]);
        }

    }

    function getAllCities(GetAllCitiesRequest $request, UsersCoreLocationsService $locationsService): \Illuminate\Http\JsonResponse
    {
        try {
            $citiesData = $locationsService->getAllCitiesByGovernorateCode($request->governorate_code, $request->pageNumber, $request->perPage, $request->searchForWord, $request->with);
            if ($citiesData) {
                return bhry98_response_success_with_data(CityResource::collection($citiesData)->response()->getData(true));
            } else {
                return bhry98_response_success_without_data();
            }
        } catch (\Exception $e) {
            return bhry98_response_internal_error([
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
            ]);
        }

    }

    function getCityDetails(GetCityDetailsRequest $request, UsersCoreLocationsService $locationsService): \Illuminate\Http\JsonResponse
    {
        try {
            $governorateDetails = $locationsService->getCityDetails($request->city_code, $request->with);
            if ($governorateDetails) {
                return bhry98_response_success_with_data(CityResource::make($governorateDetails));
            } else {
                return bhry98_response_success_without_data();
            }
        } catch (\Exception $e) {
            return bhry98_response_internal_error([
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
            ]);
        }

    }
}
