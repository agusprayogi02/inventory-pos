<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProduksiRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'resep_id' => ['required', 'exists:resep,id'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'tanggal' => ['required', 'date'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
