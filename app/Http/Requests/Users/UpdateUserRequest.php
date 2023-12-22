<?php

namespace App\Http\Requests\Users;

use App\Rules\CPF;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'document' => [
                'bail',
                'nullable',
                new CPF(),
                Rule::unique('users')->ignore($this->route('user')),
            ],
            'password' => [
                'nullable',
                'string',
                Password::min(8)->mixedCase()->numbers(),
            ],
        ];
    }
}
