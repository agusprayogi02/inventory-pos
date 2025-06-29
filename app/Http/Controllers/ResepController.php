<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResepRequest;
use App\Models\Resep;

class ResepController extends Controller
{
    public function index()
    {
        return Resep::all();
    }

    public function store(ResepRequest $request)
    {
        return Resep::create($request->validated());
    }

    public function show(Resep $resep)
    {
        return $resep;
    }

    public function update(ResepRequest $request, Resep $resep)
    {
        $resep->update($request->validated());

        return $resep;
    }

    public function destroy(Resep $resep)
    {
        $resep->delete();

        return response()->json();
    }
}
