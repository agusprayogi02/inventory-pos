<?php

namespace App\Http\Controllers;

use App\Http\Requests\SatuanRequest;
use App\Models\Satuan;

class SatuanController extends Controller
{
    public function index()
    {
        return Satuan::all();
    }

    public function store(SatuanRequest $request)
    {
        return Satuan::create($request->validated());
    }

    public function show(Satuan $satuan)
    {
        return $satuan;
    }

    public function update(SatuanRequest $request, Satuan $satuan)
    {
        $satuan->update($request->validated());

        return $satuan;
    }

    public function destroy(Satuan $satuan)
    {
        $satuan->delete();

        return response()->json();
    }
}
