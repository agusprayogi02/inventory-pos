<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProduksiRequest;
use App\Models\Produksi;

class ProduksiController extends Controller
{
    public function index()
    {
        return Produksi::all();
    }

    public function store(ProduksiRequest $request)
    {
        return Produksi::create($request->validated());
    }

    public function show(Produksi $produksi)
    {
        return $produksi;
    }

    public function update(ProduksiRequest $request, Produksi $produksi)
    {
        $produksi->update($request->validated());

        return $produksi;
    }

    public function destroy(Produksi $produksi)
    {
        $produksi->delete();

        return response()->json();
    }
}
