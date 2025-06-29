<?php

namespace App\Http\Controllers;

use App\Http\Requests\BahanRequest;
use App\Models\Bahan;

class BahanController extends Controller
{
    public function index()
    {
        return Bahan::all();
    }

    public function store(BahanRequest $request)
    {
        return Bahan::create($request->validated());
    }

    public function show(Bahan $bahan)
    {
        return $bahan;
    }

    public function update(BahanRequest $request, Bahan $bahan)
    {
        $bahan->update($request->validated());

        return $bahan;
    }

    public function destroy(Bahan $bahan)
    {
        $bahan->delete();

        return response()->json();
    }
}
