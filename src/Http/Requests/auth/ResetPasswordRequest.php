<?php

namespace Bhry98\LaravelUsersCore\Http\Requests\auth;

use Bhry98\LaravelUsersCore\Models\UsersCoreUsersModel;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        return $this->merge([]);
    }

    public function rules(): array
    {
        $loginWay = config(key: "bhry98-users-core.reset_password_via");
        switch ($loginWay) {
            case "email":
                $roles["email"] = ["required", "string", "exists:" . UsersCoreUsersModel::TABLE_NAME . ",email"];
                break;
            default:
                $roles["email"] = ["required", "string", "exists:" . UsersCoreUsersModel::TABLE_NAME . ",email"];
        }
        return $roles;
    }

    public function messages(): array
    {
        return [];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator): void
    {
        if ($this->expectsJson()) {
            throw new \Illuminate\Http\Exceptions\HttpResponseException(
                bhry98_response_validation_error(
                    data: (new \Illuminate\Validation\ValidationException($validator))->errors(),
                    message: (new \Illuminate\Validation\ValidationException($validator))->getMessage()
                )
            );
        }
        parent::failedValidation($validator);
    }
}
