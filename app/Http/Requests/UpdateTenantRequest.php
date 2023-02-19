<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTenantRequest extends FormRequest
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
            'company' => 'required|string|max:255',
            // 'domain' => 'required|string|max:48|unique:domains',
            'logo' => 'nullable|mimes:jpeg,png,jpg|max:5120'
        ];
    }


    public function prepareForValidation()
    {
        // $this->merge([
        //     'domain' => $this->domain . '.' . config('tenancy.central_domains')[0],
        // ]);
    }
}
