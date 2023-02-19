<?php

namespace App\Http\Requests;

use Hash;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class CreateEmployeeRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => [
                'required', 'max:255', Password::defaults(),
            ],
        ];
    }

    public function prepareForValidation()
    {
        if($this->filled('password')) {
            $this->merge(['password' => Hash::make($this->password)]);
        }
    }
}
