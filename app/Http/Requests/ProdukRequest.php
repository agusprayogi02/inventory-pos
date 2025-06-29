<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdukRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'resep_id' => ['required', 'exists:resep'],
            'satuan_id' => ['required', 'exists:satuan'],
            'jumlah' => ['required', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
