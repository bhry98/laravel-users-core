<?php

namespace Bhry98\LaravelUsersCore\Http\Requests\locations;

use Bhry98\LaravelUsersCore\Models\UsersCoreCitiesModel;
use Bhry98\LaravelUsersCore\Models\UsersCoreCountriesModel;
use Bhry98\LaravelUsersCore\Models\UsersCoreGovernoratesModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetCityDetailsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        return $this->merge([
            "with" => $this->with ? explode(separator: ',', string: $this->with) : null,
            "city_code" => $this->city_code
        ]);
    }

    public function rules(): array
    {

        return [
            "with" => [
                "nullable",
                "array",
                "between:1,5",
            ],
            "with.*" => [
                "nullable",
                Rule::in(values: UsersCoreCitiesModel::RELATIONS),
            ],
            "city_code" => [
                "required",
                "string",
                "exists:" . UsersCoreCitiesModel::TABLE_NAME . ",code",
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
                    message: (new \Illuminate\Validation\ValidationException($validator))->getMessage()
                )
            );
        }
        parent::failedValidation($validator);
    }
}
