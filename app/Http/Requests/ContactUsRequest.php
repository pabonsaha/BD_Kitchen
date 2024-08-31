<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ContactUsRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'first_name'    => 'required|string',
            'email'         => 'required|email',
            'phone'         => 'required|numeric',
            'message'       => 'required|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json(['errors' => $validator->errors(), 'status' => 500], 200);
        throw new ValidationException($validator, $response);
    }
}
