<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'attributes' => 'nullable|array',
            'attribute_values' => 'nullable|array',
            'variant' => 'nullable|array',
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
        ];
    }
}
