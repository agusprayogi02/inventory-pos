<?php

namespace App\Http\Controllers;

use App\Http\Requests\SisaProduksiRequest;
use App\Models\SisaProduksi;
use Yajra\DataTables\DataTables;

class SisaProduksiController extends Controller
{

    public function data()
    {
        $produksi = SisaProduksi::with('produk:id,nama,satuan_id', 'produk.satuan:id,nama')->get();
        return DataTables::of($produksi)
            ->addColumn('produk_nama', function (SisaProduksi $row) {
                return $row->produk ? $row->produk->nama : '-';
            })
            ->addColumn('action', function (SisaProduksi $row) {
                return view('sisa-produksi.action', compact('row'));
            })
            ->addColumn('tanggal', function (SisaProduksi $row) {
                return $row->tanggal ? date('Y-m-d', strtotime($row->tanggal)) : '-';
            })
            ->addColumn('jumlah', function (SisaProduksi $row) {
                return $row->jumlah . ' ' . ($row->produk?->satuan?->nama ?? '-');
            })
            ->addColumn('status', function (SisaProduksi $row) {
                return $row->status;
            })
            ->rawColumns(['action', 'produk_nama', 'tanggal', 'jumlah', 'status'])
            ->make(true);
    }

    public function index()
    {
        return view('sisa-produksi.index');
    }

    public function store(SisaProduksiRequest $request)
    {
        $data = $request->validated();
        $data['tanggal'] = date('Y-m-d', strtotime($data['tanggal']));
        SisaProduksi::create($data);
        return redirect()->route('sisa-produksi.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function show(SisaProduksi $sisaProduksi)
    {
        return $sisaProduksi;
    }

    public function update(SisaProduksiRequest $request, $id)
    {
        $validatedData = $request->validated();
        $validatedData['tanggal'] = date('Y-m-d', strtotime($validatedData['tanggal']));
        $sisaProduksi = SisaProduksi::findOrFail($id);
        $sisaProduksi->update($validatedData);

        return redirect()->route('sisa-produksi.index')->with('success', 'Data berhasil diubah');
    }

    public function destroy(SisaProduksi $sisaProduksi)
    {
        $sisaProduksi->delete();

        return redirect()->route('sisa-produksi.index')->with('success', 'Data berhasil dihapus');
    }
}
