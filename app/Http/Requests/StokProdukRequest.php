<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StokProdukRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'produksi_id' => ['required', 'exists:produksi,id'],
            'produk_id' => ['required', 'exists:produk,id'],
            'jumlah' => ['required', 'integer'],
            'keterangan' => ['nullable'],
            'is_produksi' => ['nullable', 'boolean'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
