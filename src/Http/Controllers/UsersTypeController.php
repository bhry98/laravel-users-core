<?php

namespace Bhry98\LaravelUsersCore\Http\Controllers;

use App\Http\Controllers\Controller;
use Bhry98\LaravelUsersCore\Http\Requests\types\GetAllCountriesRequest;
use Bhry98\LaravelUsersCore\Http\Requests\types\GetAllTypesRequest;
use Bhry98\LaravelUsersCore\Http\Resources\TypeResource;
use Bhry98\LaravelUsersCore\Services\UsersCoreTypesService;

class UsersTypeController extends Controller
{
    function getAll(GetAllTypesRequest $request, UsersCoreTypesService $usersTypesService): \Illuminate\Http\JsonResponse
    {
        try {
            $typeData = $usersTypesService->getAllTypes($request->perPage, $request->searchForWord);
            if ($typeData) {
                return bhry98_response_success_with_data(TypeResource::collection($typeData)->response()->getData(true));
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
