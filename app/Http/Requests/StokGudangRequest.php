<?php

namespace App\Http\Requests;

use App\Enums\StokStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StokGudangRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'bahan_id' => ['required', 'exists:bahan,id'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'tanggal' => ['required', 'date'],
            'status' => ['required', 'string', Rule::in(StokStatus::PLUS->value, StokStatus::MINUS->value)],
            'exp_date' => ['required', 'date', 'after:today'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
