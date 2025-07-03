<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProduksiRequest;
use App\Models\Produksi;
use Yajra\DataTables\DataTables;

class ProduksiController extends Controller
{
    public function data()
    {
        $produksi = Produksi::with('resep:id,nama')->get();
        return DataTables::of($produksi)
            ->addColumn('resep_nama', function ($row) {
                return $row->resep ? $row->resep->nama : '-';
            })
            ->addColumn('action', function ($row) {
                return view('produksi.action', compact('row'));
            })
            ->addColumn('tanggal', function ($row) {
                return $row->tanggal ? date('d M Y', $row->tanggal) : '-';
            })
            ->rawColumns(['action', 'resep_nama', 'tanggal'])
            ->make(true);
    }

    public function select2()
    {
        $produksi = Produksi::query()->select('id', 'nama')->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'text' => $item->nama
            ];
        });
        return response()->json([
            "results" => $produksi,
            "pagination" => [
                "more" => false
            ]
        ]);
    }

    public function index()
    {
        return view('produksi.index');
    }

    public function store(ProduksiRequest $request)
    {
        Produksi::create($request->validated());

        return redirect()->route('produksi.index')->with('success', 'Produksi berhasil ditambahkan');
    }

    public function update(ProduksiRequest $request, $id)
    {
        $produksi = Produksi::find($id);
        $produksi->update($request->validated());

        return redirect()->route('produksi.index')->with('success', 'Produksi berhasil diubah');
    }

    public function destroy($id)
    {
        $produksi = Produksi::find($id);
        $produksi->delete();

        return redirect()->route('produksi.index')->with('success', 'Produksi berhasil dihapus');
    }
}
