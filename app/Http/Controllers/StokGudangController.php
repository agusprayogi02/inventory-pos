<?php

namespace App\Http\Controllers;

use App\Enums\StokStatus;
use App\Http\Requests\KurangiStokGudangRequest;
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

    public function kurangiStok(KurangiStokGudangRequest $request)
    {
        $data = $request->validated();
        $stokGudang = StokGudang::query()->find($data['stok_gudang_ref']);
        if ($data['changed_id']) {
            $stokGudang = StokGudang::query()->find($data['changed_id']);
            $stokGudang->update([
                'jumlah' => $data['jumlah'],
                'tanggal' => $data['tanggal'],
                'keterangan' => $data['keterangan'],
            ]);
        } else {
            StokGudang::query()->create([
                'bahan_id' => $stokGudang->bahan_id,
                'user_id' => auth()->id(),
                'stok_gudang_ref' => $stokGudang->id,
                'jumlah' => $data['jumlah'],
                'tanggal' => $data['tanggal'],
                'status' => StokStatus::MINUS->value,
                'keterangan' => $data['keterangan'],
                'exp_date' => $stokGudang->exp_date,
            ]);
        }

        return redirect()->route('stok-gudang.show', $stokGudang->bahan_id)->with('success', 'Stok Gudang berhasil dikurangi');
    }

    public function show(int $id)
    {
        $bahan = Bahan::query()->with('satuan:id,nama')->find($id);
        return view('stok-gudang.show', compact('bahan'));
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

    public function dataDetail($bahan_id)
    {
        $bahan = Bahan::query()->with('satuan:id,nama')->find($bahan_id);
        $stokGudang = StokGudang::with(['user:id,name'])
            ->where('bahan_id', $bahan_id)
            ->orderByDesc('tanggal');
        return DataTables::of($stokGudang)
            ->addIndexColumn()
            ->addColumn('jumlah', function ($row) use ($bahan) {
                return $row->jumlah . ' x (' . ($bahan->satuan ? $bahan->jumlah_min . ' ' . $bahan->satuan->nama : '-') . ')';
            })
            ->addColumn('status', function ($row) {
                return $row->status == StokStatus::PLUS->value ? 'Masuk' : 'Keluar';
            })
            ->addColumn('tanggal', function ($row) {
                return $row->tanggal ? date('d-m-Y', $row->tanggal) : '-';
            })
            ->addColumn('user', function ($row) {
                return $row->user->name ?? '-';
            })
            ->addColumn('exp_date', function ($row) {
                return $row->exp_date ? date('d-m-Y', strtotime($row->exp_date)) : '-';
            })
            ->addColumn('action', function (StokGudang $row) {
                return view('stok-gudang.action-show', compact('row'));
            })
            ->rawColumns(['jumlah', 'status', 'tanggal', 'user', 'exp_date', 'action'])
            ->make(true);
    }
}
