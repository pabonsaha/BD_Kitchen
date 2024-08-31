<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventStoreRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => 'required',
            'event_type' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'active_status' => 'required',
            'file' => 'sometimes|file|mimes:jpg,jpeg,png,gif,pdf,docx,csv,xlsx|max:2048', // Optional file validation
        ];
    }
}
