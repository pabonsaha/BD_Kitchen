<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|unique:products,name|max:255',
            'weightAndDiamensions' => 'nullable|array',
            'specifications' => 'nullable|array',
            'ecommerce_product_tags' => 'nullable',
            'video_link' => 'nullable|string|max:255',
            'barcode' => 'nullable|string|max:255',
            'description' => 'nullable',
            'shipping_policy' => 'nullable',
            'return_policy' => 'nullable',
            'disclaimer' => 'nullable',
            'unit_price' => 'required|numeric',
            'discount_type' => 'required|in:0,1,2',
            'discount_value' => 'required_if:discount_type,1,2',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'status' => 'required|in:0,1',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,webp|max:1024',
            'meta_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'discount_value.required_if' => 'Discount value is required when product has discount type: Fixed or Percentage',
            'unit_price.required' => 'Base Price is required.'
        ];
    }
}
