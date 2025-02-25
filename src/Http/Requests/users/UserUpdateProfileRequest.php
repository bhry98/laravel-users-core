<?php

namespace Bhry98\LaravelUsersCore\Http\Requests\users;

use Bhry98\LaravelUsersCore\Http\Resources\UserResource;
use Bhry98\LaravelUsersCore\Models\UsersCoreCitiesModel;
use Bhry98\LaravelUsersCore\Models\UsersCoreCountriesModel;
use Bhry98\LaravelUsersCore\Models\UsersCoreGovernoratesModel;
use Bhry98\LaravelUsersCore\Models\UsersCoreUsersModel;
use Bhry98\LaravelUsersCore\Services\UsersCoreUsersService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

//use\HttpResponseException;


class UserUpdateProfileRequest extends FormRequest
{
    public function prepareForValidation()
    {
        $user = request()->user();
        $fixedData["country_id"] = !$this->country || is_null($this->country) ? $user->country_id : $this->country;
        $fixedData["governorate_id"] = !$this->governorate || is_null($this->governorate) ? $user->governorate_id : $this->governorate;
        $fixedData["city_id"] = !$this->city || is_null($this->city) ? $user->city_id : $this->city;
        $fixedData["username"] = !$this->username || is_null($this->username) ? $user->username : $this->username;
        return $this->merge($fixedData);
    }

    public function rules(): array
    {
        $user = request()->user();
        $roles["username"] = [
            "nullable",
            "string",
            "unique:" . UsersCoreUsersModel::TABLE_NAME . ",username," . $user->id,
        ];
        $roles["country_id"] = [
            "nullable",
            "uuid",
            "exists:" . UsersCoreCountriesModel::TABLE_NAME . ",code",
        ];
        $roles["governorate_id"] = [
            "nullable",
            "uuid",
            "exists:" . UsersCoreGovernoratesModel::TABLE_NAME . ",code",
        ];
        $roles["city_id"] = [
            "nullable",
            "uuid",
            "exists:" . UsersCoreCitiesModel::TABLE_NAME . ",code",
        ];
        $roles["email"] = [
            "nullable",
            "email",
            "unique:" . UsersCoreUsersModel::TABLE_NAME . ",email," . $user->id,
        ];
        $roles["display_name"] = [
            "nullable",
            "string",
            "max:50",
        ];
        $roles["first_name"] = [
            "nullable",
            "string",
            "max:50",
        ];
        $roles["last_name"] = [
            "nullable",
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
            "unique:" . UsersCoreUsersModel::TABLE_NAME . ",national_id," . $user->id,
        ];
        $roles["phone_number"] = [
            "nullable",
            "numeric",
            "digits:11",
            "unique:" . UsersCoreUsersModel::TABLE_NAME . ",phone_number," . $user->id,

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
