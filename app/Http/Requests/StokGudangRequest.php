<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StokGudangRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'bahan_id' => ['required', 'exists:bahan'],
            'user_id' => ['required', 'exists:users'],
            'jumlah' => ['required', 'integer'],
            'tanggal' => ['required', 'date'],
            'status' => ['required', 'integer'],
            'keterangan' => ['required'],
            'exp_date' => ['required', 'date'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
