<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdukRequest;
use App\Models\Produk;
use Yajra\DataTables\DataTables;

class ProdukController extends Controller
{
    public function data()
    {
        $produk = Produk::with('resep:id,nama', 'satuan:id,nama')->get();
        return DataTables::of($produk)
            ->addColumn('resep_nama', function ($row) {
                return $row->resep ? $row->resep->nama : '-';
            })
            ->addColumn('satuan_nama', function ($row) {
                return $row->satuan ? $row->satuan->nama : '-';
            })
            ->addColumn('jumlah', function ($row) {
                return $row->jumlah . ' ' . $row->satuan->nama;
            })
            ->addColumn('action', function ($row) {
                return view('produk.action', compact('row'));
            })
            ->rawColumns(['action', 'resep_nama', 'satuan_nama', 'jumlah'])
            ->addIndexColumn()
            ->make(true);
    }

    public function select2()
    {
        $req = request()->get('resep_id');
        $produk = Produk::query()->select('id', 'nama', 'isi')
            ->when($req, function ($query) use ($req) {
                return $query->where('resep_id', $req);
            })
            ->get()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'text' => $item->nama . ' (' . $item->isi . ' pcs)'
                ];
            });
        return response()->json([
            "results" => $produk,
            "pagination" => [
                "more" => false
            ]
        ]);
    }

    public function index()
    {
        return view('produk.index');
    }

    public function store(ProdukRequest $request)
    {
        Produk::create($request->validated());

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function update(ProdukRequest $request, $id)
    {
        $produk = Produk::find($id);
        $produk->update($request->validated());

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diubah');
    }

    public function destroy($id)
    {
        $produk = Produk::find($id);
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus');
    }
}
