<?php

namespace App\Http\Controllers;

use App\Http\Requests\StokProdukRequest;
use App\Models\StokProduk;
use Yajra\DataTables\DataTables;

class StokProdukController extends Controller
{
    public function data()
    {
        $stokProduk = StokProduk::with('produk:id,nama,satuan_id', 'produksi:id,jumlah,tanggal')->get();
        return DataTables::of($stokProduk)
            ->addColumn('produk_nama', function ($row) {
                return $row->produk ? $row->produk->nama : '-';
            })
            ->addColumn('jumlah', function ($row) {
                return $row->jumlah . ' ' . $row->produk->satuan->nama;
            })
            ->addColumn('tanggal', function ($row) {
                return $row->produksi ? date('d M Y', $row->produksi->tanggal) : '-';
            })
            ->addColumn('action', function ($row) {
                return view('stok-produk.action', compact('row'));
            })
            ->rawColumns(['produk_nama', 'tanggal', 'jumlah', 'action'])
            ->make(true);
    }

    public function select2()
    {
        $stokProduk = StokProduk::query()->select('id', 'nama')->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'text' => $item->nama
            ];
        });
        return response()->json([
            "results" => $stokProduk,
            "pagination" => [
                "more" => false
            ]
        ]);
    }

    public function index()
    {
        return view('stok-produk.index');
    }

    public function store(StokProdukRequest $request)
    {
        StokProduk::create($request->validated());
        return redirect()->route('stok-produk.index')->with('success', 'Stok produk berhasil ditambahkan');
    }

    public function update(StokProdukRequest $request, $id)
    {
        $stokProduk = StokProduk::find($id);
        $stokProduk->update($request->validated());
        if ($request->is_produksi) {
            return redirect()->route('produksi.show', $request->produksi_id)->with('success', 'Stok produk berhasil diubah');
        }
        return redirect()->route('stok-produk.index')->with('success', 'Stok produk berhasil diubah');
    }

    public function destroy($id)
    {
        $stokProduk = StokProduk::find($id);
        $stokProduk->delete();
        if (request()->has('produksi_id')) {
            return redirect()->route('produksi.show', request()->get('produksi_id'))->with('success', 'Stok produk berhasil dihapus');
        }
        return redirect()->route('stok-produk.index')->with('success', 'Stok produk berhasil dihapus');
    }
}
