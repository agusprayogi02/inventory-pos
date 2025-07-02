<?php

namespace App\Http\Controllers;

use App\Enums\StokStatus;
use App\Http\Requests\StokGudangRequest;
use App\Models\Bahan;
use App\Models\StokGudang;
use Yajra\DataTables\Facades\DataTables;

class StokGudangController extends Controller
{
    public function data()
    {
        $stokGudang = Bahan::with('satuan:id,nama')->get();
        return DataTables::of($stokGudang)
            ->addIndexColumn()
            ->addColumn('jumlah', function (Bahan $row) {
                return $row->jumlahStokGudang();
            })
            ->addColumn('isi', function (Bahan $row) {
                return $row->jumlah_min . " " . ($row->satuan ? $row->satuan->nama : '-');
            })
            ->addColumn('nama', function (Bahan $row) {
                return $row->nama ?? '-';
            })
            ->addColumn('action', function (Bahan $row) {
                return view('stok-gudang.action', compact('row'));
            })
            ->rawColumns(['action', 'jumlah', 'isi', 'nama'])
            ->make(true);
    }

    public function select2()
    {
        $stokGudang = StokGudang::with('bahan')->get()->map(function ($row) {
            return [
                'id' => $row->id,
                'text' => $row->bahan->nama ?? '-',
            ];
        })->toArray();
        return response()->json([
            'results' => $stokGudang,
            'pagination' => [
                'more' => false,
            ],
        ]);
    }

    public function index()
    {
        return view('stok-gudang.index');
    }

    public function store(StokGudangRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        StokGudang::create($data);

        return redirect()->route('stok-gudang.index')->with('success', 'Stok Gudang berhasil ditambahkan');
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
