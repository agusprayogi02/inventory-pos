<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResepRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nama' => ['required'],
            'user_id' => ['required', 'exists:users'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
