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
        $fixedData = [];
        if ($this->country || !is_null($this->country)) {
            $fixedData["country_id"] = $user->country;
        }
        if ($this->governorate || !is_null($this->governorate)) {
            $fixedData["governorate_id"] = $user->governorate;
        }
        if ($this->city || !is_null($this->city)) {
            $fixedData["city_id"] = $user->city;
        }
        if ($this->username || !is_null($this->username)) {
            $fixedData["username"] = $user->username;
        }
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
            $errors = collect((new \Illuminate\Validation\ValidationException($validator))->errors())->mapWithKeys(function ($messages, $key) {
                return [self::attributes()[$key] ?? $key => $messages];
            })->toArray();
            throw new \Illuminate\Http\Exceptions\HttpResponseException(
                bhry98_response_validation_error(
                    data: $errors,
                    message: (new \Illuminate\Validation\ValidationException($validator))->getMessage()
                )
            );
        }
        parent::failedValidation($validator);
    }

    public function attributes(): array
    {
        $message["country_id"] = "country";
        $message["governorate_id"] = "governorate";
        $message["city_id"] = "city";
        return $message;
    }

    public function messages(): array
    {
        return [];
    }
}
