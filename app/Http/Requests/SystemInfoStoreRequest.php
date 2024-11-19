<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class SystemInfoStoreRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'shop_name' =>  ['required', 'alpha', 'string', 'max:50'],
            'address' => 'required|string',
            'phone' => ['required', 'string', 'regex:/^(?:\+88|88)?(01[3-9]\d{8})$/'],
            'email' => 'required|email',
            'delivery_charge' => 'required|numeric',
            'delivery_time' => 'required',
            'order_per_hour' => 'required|numeric',
            'map_location' => 'nullable|string',
            'copy_right' => 'nullable|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json(['errors' => $validator->errors(), 'status' => 403], 200);
        throw new ValidationException($validator, $response);
    }
}
