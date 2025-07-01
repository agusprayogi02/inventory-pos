<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResepBahanRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'bahan_id' => ['required', 'exists:bahan,id'],
            'jumlah' => ['required', 'numeric', 'min:1'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
