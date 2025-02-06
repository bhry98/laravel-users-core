<?php

namespace Bhry98\LaravelUsersCore\Http\Requests\auth;

use Bhry98\LaravelUsersCore\Models\UsersCoreUsersModel;
use Illuminate\Foundation\Http\FormRequest;

//use\HttpResponseException;


class RegistrationNormalUserRequest extends FormRequest
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
        $roles = [
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
        ];
        $roles["birthdate"] = [
            "nullable",
            "date",
            "before:" . date('Y') - 10,
        ];
        $roles["national_id"] = [
            "nullable",
            "numeric",
            "digits:14",
        ];
        return $roles;
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

    public function messages(): array
    {
        return [];
    }
}
