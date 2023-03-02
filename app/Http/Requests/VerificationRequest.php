<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerificationRequest extends FormRequest
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
    public function rules():array
    {
        return [
            'email' => 'required|string|email',
            'code' => 'required|int|max:6',
        ];
    }
    public function messages(): array
    {
        return [
            "email.required" => "Email hissəsi mütləq əlavə olunmalıdır",
            "code.required" => "OTP code mütləq əlavə olunmalıdır",
            "code.max" => "6 simvoldan cox ola bilmez",

        ];
    }
}
