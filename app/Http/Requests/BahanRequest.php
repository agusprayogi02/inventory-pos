<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BahanRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nama' => ['required'],
            'jumlah_min' => ['required', 'integer'],
            'satuan_id' => ['required', 'exists:satuan'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
