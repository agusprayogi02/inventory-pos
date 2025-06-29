<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdukRequest;
use App\Models\Produk;

class ProdukController extends Controller
{
    public function index()
    {
        return Produk::all();
    }

    public function store(ProdukRequest $request)
    {
        return Produk::create($request->validated());
    }

    public function show(Produk $produk)
    {
        return $produk;
    }

    public function update(ProdukRequest $request, Produk $produk)
    {
        $produk->update($request->validated());

        return $produk;
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();

        return response()->json();
    }
}
