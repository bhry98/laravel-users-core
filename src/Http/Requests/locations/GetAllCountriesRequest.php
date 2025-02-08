<?php

namespace Bhry98\LaravelUsersCore\Http\Requests\locations;

use Illuminate\Foundation\Http\FormRequest;

class GetAllCountriesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        return $this->merge([
            "Countries" => $this->Countries ?? 1,
            "perPage" => $this->perPage ?? 10,
        ]);
    }

    public function rules(): array
    {
        return [
            "Countries" => [
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
        return [];
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
