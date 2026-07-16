<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'token'  => ['required', 'string'],
            'status' => ['required', 'in:Berangkat,Pulang'],
        ];
    }

    public function messages(): array
    {
        return [
            'status.in' => 'Status harus Berangkat atau Pulang.',
        ];
    }
}
