<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|string|email',
            'password' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            "email.required" => "Email hissəsi mütləq əlavə olunmalıdır",
            "password.required" => "password hissəsi mütləq əlavə olunmalıdır",
        ];
    }
}
