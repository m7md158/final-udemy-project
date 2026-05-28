<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class JobVacancyCreateRequest extends FormRequest
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
            'title' => 'bail|required|string|max:255|unique:job_vacancies,title,' . $this->route('job_vacancy'),
            'description' => 'bail|required|string|max:255',
            'location' => 'bail|required|string|max:255',
            'salary' => 'bail|required|numeric|min:0',
            'type' => 'bail|required|string|max:255',
            'jobCategoryId' => 'bail|required|uuid|exists:job_categories,id',
            'companyId' => 'bail|required|uuid|exists:companies,id',
        ];
    }
    
    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title field must be a string.',
            'title.max' => 'The title field must be less than 255 characters.',
            'description.required' => 'The description field is required.',
            'description.string' => 'The description field must be a string.',
            'description.max' => 'The description field must be less than 255 characters.',
            'location.required' => 'The location field is required.',
            'location.string' => 'The location field must be a string.',
            'location.max' => 'The location field must be less than 255 characters.',
            'salary.required' => 'The salary field is required.',
            'salary.numeric' => 'The salary field must be a number.',
            'salary.min' => 'The salary field must be greater than 0.',
            'type.required' => 'The type field is required.',
        ];
    }
}
