<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailStoreRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email_engine_type' => 'required',
            'from_name' => 'required',
            'from_email' => 'email|required',
            'mail_driver' => 'string|required',
            'mail_host' => 'required|string',
            'mail_port' => 'required|string',

            'mail_username' => 'required|string',
            'mail_password' => 'required|string',
            'mail_encryption' => 'required|string',
        ];
    }

}
