<?php

namespace Bhry98\LaravelUsersCore\Http\Requests\auth;

use Bhry98\LaravelUsersCore\Models\UsersCoreCitiesModel;
use Bhry98\LaravelUsersCore\Models\UsersCoreCountriesModel;
use Bhry98\LaravelUsersCore\Models\UsersCoreGovernoratesModel;
use Bhry98\LaravelUsersCore\Models\UsersCoreUsersModel;
use Illuminate\Foundation\Http\FormRequest;

//use\HttpResponseException;


class RegistrationUserRequest extends FormRequest
{
    public function prepareForValidation()
    {
        $fixedData["country_id"] = $this->country;
        $fixedData["governorate_id"] = $this->governorate;
        $fixedData["city_id"] = $this->city;
        $fixedData["redirect_link"] = is_null($this->redirect_link) ? session("redirect_link") : $this->redirect_link;
        $fixedData["display_name"] = is_null($this->display_name) ? $this->first_name . " " . $this->last_name : $this->display_name;
        return $this->merge($fixedData);
    }

    public function rules(): array
    {
        $roles["username"] = [
            "required",
            "string",
            "unique:" . UsersCoreUsersModel::TABLE_NAME . ",username",
        ];
        $roles["country_id"] = [
            "nullable",
            "uuid",
            "exists:" . UsersCoreCountriesModel::TABLE_NAME . ",id",
        ];
        $roles["governorate_id"] = [
            "nullable",
            "uuid",
            "exists:" . UsersCoreGovernoratesModel::TABLE_NAME . ",id",
        ];
        $roles["city_id"] = [
            "nullable",
            "uuid",
            "exists:" . UsersCoreCitiesModel::TABLE_NAME . ",id",
        ];
        $roles["email"] = [
            "required",
            "email",
            "unique:" . UsersCoreUsersModel::TABLE_NAME . ",email",
        ];
        $roles["password"] = [
            "required",
            "string",
            "between:8,50",
            "confirmed",
        ];
        $roles["redirect_link"] = [
            "nullable"
        ];
        $roles["display_name"] = [
            "nullable",
            "string",
            "max:50",
        ];
        $roles["first_name"] = [
            "required",
            "string",
            "max:50",
        ];
        $roles["last_name"] = [
            "required",
            "string",
            "max:50",
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
            "unique:" . UsersCoreUsersModel::TABLE_NAME . ",national_id",
        ];
        $roles["phone_number"] = [
            "nullable",
            "numeric",
            "digits:11",
            "unique:" . UsersCoreUsersModel::TABLE_NAME . ",phone_number",

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

    public function messages(): array
    {
        return [];
    }
}
