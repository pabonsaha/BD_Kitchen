<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class SubscriberMailStoreRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'email' => 'required|string|email:rfc,dns|unique:subscribers,email'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json(['errors' => $validator->errors(), 'status' => 403], 200);
        throw new ValidationException($validator, $response);
    }
}
