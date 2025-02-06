<?php

namespace Bhry98\LaravelUsersCore\Requests\auth;

use Bhry98\LaravelUsersCore\Models\UsersCoreTypesModel;
use Bhry98\LaravelUsersCore\Models\UsersCoreUsersModel;
use Illuminate\Foundation\Http\FormRequest;

class RegistrationByTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        return $this->merge([
            "redirect_link" => is_null($this->redirect_link) ? session("redirect_link") : $this->redirect_link,
            "display_name" => is_null($this->display_name) ? $this->first_name . " " . $this->last_name : $this->display_name,
        ]);
    }

    public function rules(): array
    {
        return [
            "username" => [
                "required",
                "string",
                "unique:" . UsersCoreUsersModel::TABLE_NAME . ",username",
            ],
            "email" => [
                "required",
                "email",
                "unique:" . UsersCoreUsersModel::TABLE_NAME . ",email",
            ],
            "password" => [
                "required",
                "string",
                "between:8,50",
                "confirmed",
            ],
            "redirect_link" => [
                "nullable"
            ],
            "display_name" => [
                "nullable",
                "string",
                "max:50",
            ],
            "first_name" => [
                "required",
                "string",
                "max:50",
            ],
            "last_name" => [
                "required",
                "string",
                "max:50",
            ],
//            "type" => [
//                "required",
//                "exists:" . UsersCoreTypesModel::TABLE_NAME . ",id",
//            ],
        ];
    }

    public function messages(): array
    {
        return [];
    }
}
