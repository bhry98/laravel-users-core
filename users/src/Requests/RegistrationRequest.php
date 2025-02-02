<?php

namespace Bhry98\LaravelUsersCore\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
        return [
            "username" => "required|exists:hr_employees,username",
            "password" => "required",
            "redirect_link" => "nullable",
        ];
    }
    public function messages(): array
    {
        return [
            "username.exists" => __("auth.failed"),
        ];
    }
}