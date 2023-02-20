<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
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
            'leader' => 'nullable|array',
            'leader.*' => 'required|exists:users,id',
            'member' => 'nullable|array',
            'member.*' => 'required|exists:users,id',
        ];
    }

    public function prepareForValidation()
    {
        if($this->filled('leader')) {
            $this->merge(['leader' => array_keys($this->leader)]);
        }
        if($this->filled('member')) {
            $this->merge(['member' => array_keys($this->member)]);
        }
    }
}
