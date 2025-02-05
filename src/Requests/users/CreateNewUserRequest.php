<?php

namespace Bhry98UsersCore\Requests\users;

use Bhry98\LaravelUsersCore\Models\UsersCoreTypesModel;
use Bhry98\LaravelUsersCore\Models\UsersCoreUsersModel;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\ParameterBag;

class CreateNewUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        return $this->merge([
        ]);
    }

    public function rules(): array
    {
        $users_types_table = UsersCoreTypesModel::TABLE_NAME;
        $users_core_table = UsersCoreUsersModel::TABLE_NAME;
        return [
            "type_id" => "required|exists:$users_types_table,id",
            "display_name" => "required|string|max:50",
            "first_name" => "required|string|max:50",
            "last_name"=>"required|string|max:50",
            "username"=>"required|string|max:50|unique:$users_core_table,username",
//            "email"=>,
            "email_verified_at",
            "password",
        ];
    }

    public function attributes(): array
    {
        return [
            "type_id" => "typeId",
            "display_name" => "displayName",
            "first_name" => "firstName",
            "last_name" => "lastName",
            "username" => "username",
            "email" => "email",
            "password" => "password",
        ];
    }

    public function messages(): array
    {
        return [
            "username.exists" => __("auth.failed"),
        ];
    }
}
