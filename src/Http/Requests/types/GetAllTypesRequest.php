<?php

namespace Bhry98\LaravelUsersCore\Http\Requests\types;

use Illuminate\Foundation\Http\FormRequest;

class GetAllTypesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        return $this->merge([
            "Types" => $this->Types ?? 1,
            "perPage" => $this->perPage ?? 10,
        ]);
    }

    public function rules(): array
    {
        return [
            "Types" => [
                "nullable",
                "numeric",
            ],
            "perPage" => [
                "nullable",
                "numeric",
                "between:5,50",
            ],
            "searchForWord" => [
                "nullable",
                "string",
                "between:1,50",
            ]
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
