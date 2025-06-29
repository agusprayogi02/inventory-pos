<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SisaProduksiRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'produksi_id' => ['required', 'exists:produksi'],
            'jumlah' => ['required', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
