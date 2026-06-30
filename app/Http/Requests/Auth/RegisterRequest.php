<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;


class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'login' => ['required', 'string', 'unique:' . User::class . ',login'],
            'email' => ['required', 'string', 'email', 'unique:' . User::class . ',email'],
            'password' => ['required', Rules\Password::defaults()]
        ];
    }

}
