<?php

namespace App\Http\Controllers;

use App\Http\Requests\SisaProduksiRequest;
use App\Models\SisaProduksi;

class SisaProduksiController extends Controller
{
    public function index()
    {
        return SisaProduksi::all();
    }

    public function store(SisaProduksiRequest $request)
    {
        return SisaProduksi::create($request->validated());
    }

    public function show(SisaProduksi $sisaProduksi)
    {
        return $sisaProduksi;
    }

    public function update(SisaProduksiRequest $request, SisaProduksi $sisaProduksi)
    {
        $sisaProduksi->update($request->validated());

        return $sisaProduksi;
    }

    public function destroy(SisaProduksi $sisaProduksi)
    {
        $sisaProduksi->delete();

        return response()->json();
    }
}
