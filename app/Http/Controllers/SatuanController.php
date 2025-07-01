<?php

namespace App\Http\Controllers;

use App\Http\Requests\SatuanRequest;
use App\Models\Satuan;
use Yajra\DataTables\DataTables;

class SatuanController extends Controller
{
    public function data()
    {
        $query = Satuan::query();
        return DataTables::of($query)
            ->addColumn('action', function ($row) {
                return view('satuan.action', compact('row'));
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function select2()
    {
        $data = Satuan::select('id', 'nama')->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'text' => $item->nama
            ];
        });
        return response()->json(
            [
                "results" => $data,
                "pagination" => [
                    "more" => false
                ]
            ]
        );
    }

    public function index()
    {
        return view('satuan.index');
    }

    public function store(SatuanRequest $request)
    {
        Satuan::create($request->validated());

        return redirect()->route('satuan.index')->with('success', 'Satuan berhasil ditambahkan');
    }

    public function show(Satuan $satuan)
    {
        return $satuan;
    }

    public function update(SatuanRequest $request, $id)
    {
        $satuan = Satuan::find($id);
        $satuan->update($request->validated());

        return redirect()->route('satuan.index')->with('success', 'Satuan berhasil diubah');
    }

    public function destroy($id)
    {
        $satuan = Satuan::find($id);
        $satuan->delete();

        return redirect()->route('satuan.index')->with('success', 'Satuan berhasil dihapus');
    }
}
