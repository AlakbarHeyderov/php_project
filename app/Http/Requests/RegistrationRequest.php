<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            "email.required" => "Email hissəsi mütləq əlavə olunmalıdır",
            "name.required" => "Name hissəsi mütləq əlavə olunmalıdır",
            "password.required" => "password hissəsi mütləq əlavə olunmalıdır",
            "email.unique" => "Bu email artıq qeydiyyatdan keçib",

        ];
    }
}
