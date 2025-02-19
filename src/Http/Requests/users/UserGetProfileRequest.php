<?php

namespace Bhry98\LaravelUsersCore\Http\Requests\users;

use Bhry98\LaravelUsersCore\Models\UsersCoreCitiesModel;
use Bhry98\LaravelUsersCore\Models\UsersCoreCountriesModel;
use Bhry98\LaravelUsersCore\Models\UsersCoreGovernoratesModel;
use Bhry98\LaravelUsersCore\Models\UsersCoreUsersModel;
use Bhry98\LaravelUsersCore\Services\UsersCoreUsersService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

//use\HttpResponseException;


class UserGetProfileRequest extends FormRequest
{
    public function prepareForValidation()
    {
        $fixedData["with"] = $this->with ? explode(separator: ',', string: $this->with) : null;
        return $this->merge($fixedData);
    }

    public function rules(): array
    {
        $roles["with"] = [
            "nullable",
            "array",
            "between:1,5",
        ];
        $roles["with.*"] = [
            "nullable",
            Rule::in(values: UsersCoreUsersModel::RELATIONS),
        ];
        return $roles;
    }

    public function authorize(): bool
    {
        return true;
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
}
