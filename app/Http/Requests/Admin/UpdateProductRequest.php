<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->is_admin === true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => ['nullable', Rule::exists('categories', 'id')],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products')->ignore($this->route('product')),
            ],
            'sku' => [
                'required',
                'string',
                'max:80',
                Rule::unique('products')->ignore($this->route('product')),
            ],
            'short_description' => ['required', 'string', 'max:180'],
            'description' => ['required', 'string', 'max:5000'],
            'price' => ['required', 'numeric', 'min:0', 'max:9999999999.99'],
            'compare_at_price' => ['nullable', 'numeric', 'gt:price', 'max:9999999999.99'],
            'stock' => ['required', 'integer', 'min:0', 'max:1000000'],
            'image_url' => ['nullable', 'url:http,https', 'max:2048'],
            'is_featured' => ['sometimes', 'boolean'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
