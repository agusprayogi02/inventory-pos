<?php

namespace App\Http\Controllers;

use App\Enums\StokStatus;
use App\Http\Requests\StokKitchenRequest;
use App\Models\StokKitchen;
use Yajra\DataTables\DataTables;
use App\Models\Resep;
use App\Models\ResepBahan;
use App\Models\Bahan;
use App\Models\StokGudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokKitchenController extends Controller
{
    public function data()
    {
        $bahanList = Bahan::with('satuan')->get();
        return DataTables::of($bahanList)
            ->addIndexColumn()
            ->addColumn('sisa', function (Bahan $row) {
                $satuan = $row->satuan ? $row->satuan->nama : '';
                return $row->sisaStokReal() . ' ' . $satuan;
            })
            ->addColumn('action', function (Bahan $row) {
                return view('stok-kitchen.action', compact('row'));
            })
            ->rawColumns(['action', 'sisa'])
            ->make(true);
    }

    public function select2()
    {

    }

    public function index()
    {
        return view('stok-kitchen.index');
    }

    public function store(StokKitchenRequest $request)
    {
        $data = $request->validated();
        if ($request->status == StokStatus::MINUS->value) {
            $data['jumlah'] = 0;
        }
        $jumlah = Bahan::query()->find($request->bahan_id)->jumlahStokGudang();
        if ($request->jumlah > $jumlah) {
            return redirect()->route('stok-kitchen.index')->with('error', 'Jumlah tidak boleh lebih dari sisa stok');
        }
        if ($request->status == StokStatus::MINUS->value) {
            $stok = Bahan::query()->find($request->bahan_id)->sisaStokReal();
            if ($request->jumlah_real > $stok) {
                return redirect()->route('stok-kitchen.index')->with('error', 'Jumlah tidak boleh lebih dari sisa stok');
            }
            $data['jumlah_real'] = $stok - $request->jumlah;
        }
        StokKitchen::create($data);
        return redirect()->route('stok-kitchen.index')->with('success', 'Stok Kitchen berhasil ditambahkan');
    }

    public function show(StokKitchen $stokKitchen)
    {
        return $stokKitchen;
    }

    public function update(StokKitchenRequest $request, StokKitchen $stokKitchen)
    {
        $stokKitchen->update($request->validated());

        return $stokKitchen;
    }

    public function destroy(StokKitchen $stokKitchen)
    {
        $stokKitchen->delete();

        return response()->json();
    }

    public function getResepBahan($resepId)
    {
        Resep::findOrFail($resepId, ['id']);
        $bahanList = ResepBahan::with('bahan')
            ->where('resep_id', $resepId)
            ->get()
            ->map(function ($item) {
                $jumlah_min = $item->bahan->jumlah_min;
                $dibutuhkan = $item->jumlah;
                $kali = ceil($dibutuhkan / $jumlah_min);
                $total_diambil = $kali * $jumlah_min;
                $stok_tersedia = $item->bahan->jumlahStokGudang() * $jumlah_min;
                return [
                    'bahan_id' => $item->bahan_id,
                    'nama' => $item->bahan->nama,
                    'jumlah_min' => $jumlah_min,
                    'dibutuhkan' => $dibutuhkan,
                    'total_diambil' => $total_diambil,
                    'stok_tersedia' => $stok_tersedia,
                    'satuan' => $item->bahan->satuan ? $item->bahan->satuan->nama : '',
                ];
            });
        return response()->json(['bahan' => $bahanList]);
    }

    public function prosesResepBahan(Request $request, $resepId)
    {
        Resep::findOrFail($resepId);
        $bahanList = ResepBahan::with('bahan')
            ->where('resep_id', $resepId)
            ->get();
        $errors = [];
        $stokKitchenData = [];
        foreach ($bahanList as $item) {
            $jumlah_min = $item->bahan->jumlah_min;
            $dibutuhkan = $item->jumlah;
            $kali = ceil($dibutuhkan / $jumlah_min);
            $total_diambil = $kali * $jumlah_min;
            $stok_tersedia = $item->bahan->jumlahStokGudang() * $jumlah_min;
            if ($stok_tersedia < $total_diambil) {
                $errors[] = "Bahan {$item->bahan->nama} kurang, butuh {$total_diambil} {$item->bahan->satuan?->nama}, stok hanya {$stok_tersedia} {$item->bahan->satuan?->nama}";
            } else {
                $stokKitchenData[] = [
                    'bahan_id' => $item->bahan_id,
                    'jumlah' => $kali,
                    'tanggal' => now(),
                    'status' => StokStatus::PLUS->value, // PLUS
                    'jumlah_real' => $total_diambil,
                ];
            }
        }
        if (count($errors) > 0) {
            return response()->json(['success' => false, 'errors' => $errors], 422);
        }
        // Simpan batch
        DB::beginTransaction();
        try {
            foreach ($stokKitchenData as $data) {
                StokKitchen::create($data);
            }
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'errors' => [$e->getMessage()]], 500);
        }
    }

    public function detail($bahanId)
    {
        $stokKitchen = StokKitchen::with(['stokGudang', 'bahan'])
            ->where('bahan_id', $bahanId)
            ->orderByDesc('tanggal')
            ->get();
        return view('stok-kitchen.detail', compact('stokKitchen'));
    }
}
