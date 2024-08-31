<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{


    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'role' => 'required|integer',
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
            'status' => 'required|integer',
        ];
    }
}
