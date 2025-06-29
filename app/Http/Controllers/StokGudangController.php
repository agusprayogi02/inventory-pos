<?php

namespace App\Http\Controllers;

use App\Http\Requests\StokGudangRequest;
use App\Models\StokGudang;

class StokGudangController extends Controller
{
    public function index()
    {
        return StokGudang::all();
    }

    public function store(StokGudangRequest $request)
    {
        return StokGudang::create($request->validated());
    }

    public function show(StokGudang $stokGudang)
    {
        return $stokGudang;
    }

    public function update(StokGudangRequest $request, StokGudang $stokGudang)
    {
        $stokGudang->update($request->validated());

        return $stokGudang;
    }

    public function destroy(StokGudang $stokGudang)
    {
        $stokGudang->delete();

        return response()->json();
    }
}
