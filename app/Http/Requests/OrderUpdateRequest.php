<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id|integer',
            'shippingAddressId' => 'nullable|exists:shipping_addresses,id|integer',
            'discount_type' => 'required|in:0,1,2',
            'discount_value' => 'numeric',
            'discount_amount' => 'numeric',
            'tax_value' => 'required|in:0,1,2',
            'tax_value' => 'numeric',
            'tax_amount' => 'numeric',
            'sub_total' => 'required|numeric',
            'total' => 'required|numeric',
            'product' => 'required|array',
            'product.required' => 'There have to have at least one poduct in the cart before place order.',
        ];
    }
}
