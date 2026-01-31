<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSearchRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'company_name' => 'nullable|string',
            'selection' => 'nullable|string',
            'province' => 'nullable|string',
            'task' => 'nullable|string',
            'score' => 'nullable|integer|in:1,2,3,4,5',
            'type' => 'nullable|string',
            'welfare' => 'nullable|string',
            'submajor' => 'nullable|string'
        ];
    }
}
