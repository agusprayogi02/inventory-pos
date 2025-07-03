<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KurangiStokGudangRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'stok_gudang_ref' => ['required', 'exists:stok_gudang,id'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'tanggal' => ['required', 'date'],
            'keterangan' => ['nullable', 'string', 'max:255'],
            'changed_id' => ['nullable', 'exists:stok_gudang,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
