<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StokKitchenRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'bahan_id' => ['required', 'exists:bahan'],
            'jumlah' => ['required', 'integer'],
            'tanggal' => ['required', 'date'],
            'status' => ['required', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
