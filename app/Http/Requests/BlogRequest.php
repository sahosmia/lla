<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:blog_categories,id',
            'status'      => 'required|string|in:draft,published',
            // 'tags'        => 'nullable|array',
            // 'tags.*'      => 'exists:tags,id', // Ensure each tag exists
        ];
    }

    public function attributes(): array
    {
        return [
            // 'status' => 'status',
            'category_id' => 'category',
        ];
    }
}
