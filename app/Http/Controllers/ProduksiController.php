<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProduksiRequest;
use App\Http\Requests\StokProdukRequest;
use App\Models\Produksi;
use App\Models\StokProduk;
use Yajra\DataTables\DataTables;
use App\Exports\ProduksiExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ProduksiController extends Controller
{
    public function data()
    {
        $produksi = Produksi::with('produk:id,nama')->get();
        return DataTables::of($produksi)
            ->addColumn('produk_nama', function (Produksi $row) {
                return $row->produk ? $row->produk->nama : '-';
            })
            ->addColumn('target', function (Produksi $row) {
                return $row->jumlah;
            })
            ->addColumn('tercapai', function (Produksi $row) {
                return $row->jumlah_produksi;
            })
            ->addColumn('sisa_produksi', function (Produksi $row) {
                return $row->jumlah_produksi - $row->jumlah;
            })
            ->addColumn('action', function (Produksi $row) {
                return view('produksi.action', compact('row'));
            })
            ->addColumn('tanggal', function (Produksi $row) {
                return $row->tanggal ? date('d M Y', $row->tanggal) : '-';
            })
            ->rawColumns(['action', 'produk_nama', 'tanggal', 'target', 'tercapai', 'sisa_produksi'])
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
        $produksi = Produksi::with('produk:id,nama')->find($id);
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
        $stokProduk = StokProduk::with('produksi:id,produk_id', 'produksi.produk:id,nama,satuan_id', 'produksi.produk.satuan:id,nama')
            ->where('produksi_id', $id)
            ->orderBy('created_at', 'desc');
        return DataTables::of($stokProduk)
            ->addColumn('produk_nama', function ($row) {
                return $row->produksi->produk ? $row->produksi->produk->nama : '-';
            })
            ->addColumn('tanggal', function (StokProduk $row) {
                return $row->created_at ? date('d M Y', strtotime($row->created_at)) : '-';
            })
            ->addColumn('jumlah', function ($row) {
                return $row->jumlah . ' ' . $row->produksi->produk->satuan->nama;
            })
            ->addColumn('action', function ($row) {
                return view('produksi.action-stok', compact('row'));
            })
            ->rawColumns(['produk_nama', 'action', 'tanggal', 'jumlah'])
            ->make(true);
    }

    public function export(Request $request)
    {
        $dateRange = $request->input('date_range');
        $dates = null;
        if ($dateRange) {
            $dates = explode(' - ', $dateRange);
        }
        if ($dates) {
            return Excel::download(new ProduksiExport($dates), 'rekapan-produksi.xlsx');
        }
        return redirect()->back()->with('error', 'Tanggal tidak boleh kosong');
    }
}
