<?php

namespace Bhry98\LaravelUsersCore\Http\Controllers;

use App\Http\Controllers\Controller;
use Bhry98\LaravelUsersCore\Http\Requests\locations\{
    GetAllCountriesRequest,
    GetCountryDetailsRequest
};
use Bhry98\LaravelUsersCore\Services\{
    UsersCoreLocationsService
};
use Bhry98\LaravelUsersCore\Http\Resources\{
    CountryResource
};

class UsersLocationsController extends Controller
{
    function getAllCountries(GetAllCountriesRequest $request, UsersCoreLocationsService $locationsService): \Illuminate\Http\JsonResponse
    {
        try {
            $countriesData = $locationsService->getAllCountries($request->perPage, $request->searchForWord);
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
}
