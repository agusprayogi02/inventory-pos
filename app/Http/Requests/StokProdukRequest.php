<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StokProdukRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'produksi_id' => ['required', 'exists:produksi'],
            'produk_id' => ['required', 'exists:produk'],
            'jumlah' => ['required', 'integer'],
            'keterangan' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
