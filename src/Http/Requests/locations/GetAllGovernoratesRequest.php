<?php

namespace Bhry98\LaravelUsersCore\Http\Requests\locations;

use Bhry98\LaravelUsersCore\Models\UsersCoreCountriesModel;
use Bhry98\LaravelUsersCore\Models\UsersCoreGovernoratesModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class GetAllGovernoratesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        return $this->merge([
            "pageNumber" => $this->pageNumber ?? 1,
            "perPage" => $this->perPage ?? 10,
            "with" => $this->with ? explode(separator: ',', string: $this->with) : null,
            "country_code" => $this->country_code,
        ]);
    }

    public function rules(): array
    {
        return [
            "pageNumber" => [
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
            ],
            "with" => [
                "nullable",
                "array",
                "between:1,5",
            ],
            "with.*" => [
                "nullable",
                Rule::in(values: UsersCoreGovernoratesModel::RELATIONS),
            ],
            "country_code" => [
                "required",
                "string",
                "exists:" . UsersCoreCountriesModel::TABLE_NAME . ",code",
            ]
        ];
    }

    public function attributes(): array
    {
        $attributes = [];
        foreach ($this->with ?? [] as $withKey => $with) {
            $attributes["with.$withKey"] = "$with";
        }
        return $attributes;
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
                    message: (new \Illuminate\Validation\ValidationException($validator))->getMessage(),

                )
            );
        }
        parent::failedValidation($validator);
    }
}
