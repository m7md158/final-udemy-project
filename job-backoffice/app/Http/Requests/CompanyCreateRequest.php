<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CompanyCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'bail|required|string|max:255|unique:companies,name,' . $this->route('company'),
            'owner_name' => 'bail|required|string|max:255',
            'owner_email' => 'bail|required|email|unique:users,email',
            'owner_password' => 'bail|required|string|min:8',
            'address' => 'bail|required|string|max:255',
            'industry' => 'bail|required|string|max:255',
            'website' => 'bail|nullable|string|max:255',
        ];
    }
    
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name field must be a string.',
            'name.max' => 'The name field must be less than 255 characters.',
            'address.required' => 'The address field is required.',
            'address.string' => 'The address field must be a string.',
            'address.max' => 'The address field must be less than 255 characters.',
        ];
    }
}
