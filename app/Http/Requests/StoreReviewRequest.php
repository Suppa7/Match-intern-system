<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
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
            'company_name' => 'required|string',
            'selection' => 'required|string',
            'comment' => 'nullable|string',
            'province' => 'required|string',
            'task' => 'required|string',
            'img' => 'nullable|array',
            'img.*' => 'image',
            'score' => 'required|integer|in:1,2,3,4,5',
            'type' => 'required|string',
            'welfare' => 'required|array',
            'welfare.*' => 'string',
            'submajor' => 'required|string',

            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:image_reviews,id', // เช็คว่ามี id นี้จริงในตาราง image_reviews
        ];
    }
}
