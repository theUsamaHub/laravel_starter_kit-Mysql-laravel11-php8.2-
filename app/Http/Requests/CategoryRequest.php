<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category')?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'min:1',
                'alpha_dash',
                Rule::unique('categories', 'slug')->ignore($categoryId),
            ],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
            'attachments' => ['nullable', 'array', 'max:10'],
            'attachments.*' => ['file', 'mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,xls,xlsx,csv', 'max:10240'],
            'is_active' => ['boolean'],
            'sort_order' => ['integer', 'min:0'],
            'remove_image' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter a category name.',
            'name.max' => 'Category name cannot exceed 255 characters.',
            'slug.unique' => 'This slug is already taken.',
            'sort_order.integer' => 'Sort order must be a whole number.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a JPG, PNG, GIF, or WebP file.',
            'image.max' => 'The image must not be larger than 5MB.',
            'attachments.*.mimes' => 'The file must be a supported type (JPG, PNG, PDF, Excel, CSV).',
            'attachments.*.max' => 'Each file must not be larger than 10MB.',
        ];
    }
}
