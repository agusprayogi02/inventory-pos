<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProduksiRequest;
use App\Http\Requests\StokProdukRequest;
use App\Models\Produksi;
use App\Models\StokProduk;
use Yajra\DataTables\DataTables;

class ProduksiController extends Controller
{
    public function data()
    {
        $produksi = Produksi::with('resep:id,nama')->get();
        return DataTables::of($produksi)
            ->addColumn('resep_nama', function (Produksi $row) {
                return $row->resep ? $row->resep->nama : '-';
            })
            ->addColumn('sisa_produksi', function (Produksi $row) {
                return $row->sisaProduksi();
            })
            ->addColumn('action', function (Produksi $row) {
                return view('produksi.action', compact('row'));
            })
            ->addColumn('tanggal', function (Produksi $row) {
                return $row->tanggal ? date('d M Y', $row->tanggal) : '-';
            })
            ->rawColumns(['action', 'resep_nama', 'tanggal', 'sisa_produksi'])
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

    public function show($id)
    {
        $produksi = Produksi::with('resep:id,nama')->find($id);
        return view('produksi.show', compact('produksi'));
    }

    public function storeStokProduk(StokProdukRequest $request, $id)
    {
        $produksi = Produksi::query()->find($id);
        $produksi->stokProduk()->create($request->validated());

        return redirect()->route('produksi.show', $id)->with('success', 'Stok produk berhasil ditambahkan');
    }

    public function dataStokProduk($id)
    {
        $stokProduk = StokProduk::with('produk:id,nama,satuan_id')
            ->where('produksi_id', $id)
            ->orderBy('created_at', 'desc');
        return DataTables::of($stokProduk)
            ->addColumn('produk_nama', function ($row) {
                return $row->produk ? $row->produk->nama : '-';
            })
            ->addColumn('tanggal', function (StokProduk $row) {
                return $row->created_at ? date('d M Y', strtotime($row->created_at)) : '-';
            })
            ->addColumn('jumlah', function ($row) {
                return $row->jumlah . ' ' . $row->produk->satuan->nama;
            })
            ->addColumn('action', function ($row) {
                return view('produksi.action-stok', compact('row'));
            })
            ->rawColumns(['produk_nama', 'action', 'tanggal', 'jumlah'])
            ->make(true);
    }
}
