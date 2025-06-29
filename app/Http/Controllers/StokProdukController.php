<?php

namespace App\Http\Controllers;

use App\Http\Requests\StokProdukRequest;
use App\Models\StokProduk;

class StokProdukController extends Controller
{
    public function index()
    {
        return StokProduk::all();
    }

    public function store(StokProdukRequest $request)
    {
        return StokProduk::create($request->validated());
    }

    public function show(StokProduk $stokProduk)
    {
        return $stokProduk;
    }

    public function update(StokProdukRequest $request, StokProduk $stokProduk)
    {
        $stokProduk->update($request->validated());

        return $stokProduk;
    }

    public function destroy(StokProduk $stokProduk)
    {
        $stokProduk->delete();

        return response()->json();
    }
}
