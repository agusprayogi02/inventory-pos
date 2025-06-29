<?php

namespace App\Http\Controllers;

use App\Http\Requests\StokKitchenRequest;
use App\Models\StokKitchen;

class StokKitchenController extends Controller
{
    public function index()
    {
        return StokKitchen::all();
    }

    public function store(StokKitchenRequest $request)
    {
        return StokKitchen::create($request->validated());
    }

    public function show(StokKitchen $stokKitchen)
    {
        return $stokKitchen;
    }

    public function update(StokKitchenRequest $request, StokKitchen $stokKitchen)
    {
        $stokKitchen->update($request->validated());

        return $stokKitchen;
    }

    public function destroy(StokKitchen $stokKitchen)
    {
        $stokKitchen->delete();

        return response()->json();
    }
}
