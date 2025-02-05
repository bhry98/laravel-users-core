<?php

namespace Bhry98UsersCore\Requests\auth;

use Bhry98\LaravelUsersCore\Models\UsersCoreUsersModel;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        return $this->merge([
            "redirect_link" => is_null($this->redirect_link) ? session("redirect_link") : $this->redirect_link
        ]);
    }

    public function rules(): array
    {
        return [
            "username" => [
                "required",
                "string",
                "exists:" . UsersCoreUsersModel::TABLE_NAME . ",username",
            ],
            "password" => [
                "required",
                "string",
                "min:6",
            ],
            "redirect_link" => [
                "nullable"
            ],
        ];
    }

    public function messages(): array
    {
        return [];
    }
}
