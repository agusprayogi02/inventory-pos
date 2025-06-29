<?php

namespace App\Http\Controllers;

use App\Http\Requests\SatuanRequest;
use App\Models\Satuan;
use Yajra\DataTables\DataTables;

class SatuanController extends Controller
{
    public function data()
    {
        return DataTables::eloquent(Satuan::query())
            ->addColumn('action', function ($row) {
                return view('satuan.action', compact('row'));
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function select2()
    {
        return Satuan::select('id', 'nama')->toJson();
    }

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
