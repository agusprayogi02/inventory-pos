<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdukRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'resep_id' => ['required', 'exists:resep,id'],
            'satuan_id' => ['required', 'exists:satuan,id'],
            'nama' => ['required', 'string', 'max:255'],
            'isi' => ['required', 'integer', 'min:1'],
            'jumlah' => ['required', 'integer', 'min:1'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
