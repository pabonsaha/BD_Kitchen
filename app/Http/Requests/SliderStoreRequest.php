<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderStoreRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'slider_type' => 'required',
            'active_status' => 'required',
        ];
    }
}
