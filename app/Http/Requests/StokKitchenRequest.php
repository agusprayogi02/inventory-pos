<?php

namespace App\Http\Requests;

use App\Enums\StokStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StokKitchenRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'bahan_id' => ['required', 'exists:bahan,id'],
            'tanggal' => ['required', 'date'],
            'status' => ['required', Rule::in(StokStatus::PLUS->value, StokStatus::MINUS->value)],
            'jumlah_real' => ['required', 'integer'],
            'keterangan' => ['nullable', 'string'],
        ];

        // jumlah hanya required jika status = PLUS
        if ($this->input('status') == StokStatus::PLUS->value) {
            $rules['jumlah'] = ['required', 'integer'];
        } else {
            $rules['jumlah'] = ['nullable', 'integer'];
        }

        return $rules;
    }

    public function authorize(): bool
    {
        return true;
    }
}
