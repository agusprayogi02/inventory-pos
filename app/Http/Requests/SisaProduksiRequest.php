<?php

namespace App\Http\Requests;

use App\Enums\StatusSisaProduksi;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SisaProduksiRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'produk_id' => ['required', 'exists:produk,id'],
            'tanggal' => ['required', 'date'],
            'jumlah' => ['required', 'integer'],
            'status' => ['required', Rule::in(StatusSisaProduksi::BAIK->value, StatusSisaProduksi::RUSAK->value, StatusSisaProduksi::KEDALUARSA->value, StatusSisaProduksi::KECIL->value, StatusSisaProduksi::BESAR->value)],
            'keterangan' => ['nullable', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
