<?php

namespace App\Http\Controllers;

use App\Http\Requests\BahanRequest;
use App\Models\Bahan;
use Illuminate\Http\Request;
use Yajra\DataTables\Exceptions\Exception;
use Yajra\DataTables\Facades\DataTables;

class BahanController extends Controller
{
    /**
     * @throws Exception
     */
    public function data()
    {
        $query = Bahan::with('satuan:id,nama');

        return DataTables::eloquent(builder: $query)
            ->addColumn('satuan_nama', function (Bahan $row) {
                return $row->satuan ? $row->satuan->nama : '-';
            })
            ->addColumn('action', function (Bahan $row) {
                return view('bahan.action', compact('row'))->render();
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function index()
    {
        return view('bahan.index');
    }

    public function create()
    {
    }

    public function store(BahanRequest $request)
    {
        Bahan::create($request->validated());
        return redirect()->route('bahan.index')->with('success', 'Bahan berhasil ditambahkan');
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
