<?php

namespace Bhry98UsersCore\Controllers;

use App\Http\Controllers\Controller;
use Bhry98UsersCore\Models\UsersCoreUsersModel;
use Bhry98UsersCore\Resources\UserResource;

class UsersCoreController extends Controller
{
    function getAll()
    {
//        $usersPaginator = UsersCoreUsersModel::whereNull('deleted_at')->paginate(
//            perPage: 10,
//            pageName: "Users"
//        );

        $usersPaginator = UsersCoreUsersModel::all();
        dd($usersPaginator);
        return UserResource::collection($usersPaginator)->response()->getData(true);
    }
}
