<?php

namespace Bhry98\LaravelUsersCore\Http\Requests\auth;

use Bhry98\LaravelUsersCore\Models\UsersCoreUsersModel;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        return $this->merge([
            "redirect_link" => is_null($this->redirect_link) ? session("redirect_link") : $this->redirect_link
        ]);
    }

    public function rules(): array
    {
        $loginWay = config(key: "bhry98-users-core.login_via");
        switch ($loginWay) {
            case "username":
                $roles["username"] = ["required", "string", "exists:" . UsersCoreUsersModel::TABLE_NAME . ",username"];
                break;
            case "email":
                $roles["email"] = ["required", "string", "exists:" . UsersCoreUsersModel::TABLE_NAME . ",email"];
                break;
            case "phone":
                $roles["phone_number"] = ["required", "string", "exists:" . UsersCoreUsersModel::TABLE_NAME . ",phone_number"];
                break;
            default:
                $roles["username"] = ["required", "string", "exists:" . UsersCoreUsersModel::TABLE_NAME . ",username"];
        }
        $roles["password"] = [
            "required",
            "string",
            "min:6",
        ];
        $roles["redirect_link"] = [
            "nullable"
        ];
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
