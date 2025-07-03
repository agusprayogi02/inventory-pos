<?php

namespace App\Http\Controllers;

use App\Http\Requests\StokKitchenRequest;
use App\Models\StokKitchen;
use Yajra\DataTables\DataTables;

class StokKitchenController extends Controller
{
    public function data()
    {
        $stokKitchen = StokKitchen::with('stokGudang:id,nama')->get();
        return DataTables::of($stokKitchen)
            ->addIndexColumn()
            ->addColumn('action', function (StokKitchen $row) {
                return view('stok-kitchen.action', compact('row'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function select2()
    {

    }

    public function index()
    {
        return view('stok-kitchen.index');
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
