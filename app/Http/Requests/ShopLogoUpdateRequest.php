<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ShopLogoUpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'light_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
            'user_id' => 'required|exists:users,id|integer',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json(['errors' => $validator->errors(), 'status' => 403], 200);
        throw new ValidationException($validator, $response);
    }
}
