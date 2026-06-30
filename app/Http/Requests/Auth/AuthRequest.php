<?php

namespace App\Http\Requests\Auth\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'login' => 'required',
            'password' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'login.required' => 'The login is required',
            'password.required' => 'The activation code is required',
        ];
    }
}
