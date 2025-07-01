<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResepBahanRequest;
use App\Http\Requests\ResepRequest;
use App\Models\Bahan;
use App\Models\Resep;
use App\Models\ResepBahan;
use Yajra\DataTables\DataTables;

class ResepController extends Controller
{
    public function data()
    {
        $query = Resep::query()->with('user:id,name');

        return DataTables::of($query)
            ->addColumn('user_name', function (Resep $row) {
                return $row->user ? $row->user->name : '-';
            })
            ->addColumn('action', function (Resep $row) {
                return view('resep.action', compact('row'))->render();
            })
            ->rawColumns(['action', 'user_name'])
            ->make();
    }

    public function index()
    {
        return view('resep.index');
    }

    public function select2()
    {
        $data = Resep::query()->select('id', 'nama')->get()->map(function ($item) {
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

    public function store(ResepRequest $request)
    {
        $resep = Resep::query()->create($request->validated());

        return redirect()->route('resep.show', $resep->id)->with('success', 'Resep berhasil ditambahkan');
    }

    public function show($id)
    {
        $resep = Resep::query()->findOrFail($id);

        return view('resep.show', compact('resep'));
    }

    public function showBahan($resepId)
    {
        $query = ResepBahan::query()
            ->with('bahan:id,nama')->where('resep_id', $resepId);

        return DataTables::of($query)
            ->addColumn('bahan_name', function (ResepBahan $row) {
                return $row->bahan ? $row->bahan->nama : '-';
            })
            ->addColumn('jumlah', function (ResepBahan $row) {
                return $row->jumlah . ' Gram';
            })
            ->addColumn('action', function (ResepBahan $row) {
                return view('resep.action_bahan', compact('row'))->render();
            })
            ->rawColumns(['action', 'bahan_name', 'jumlah'])
            ->make();
    }

    public function storeBahan(ResepBahanRequest $request, $resepId)
    {
        $validated = $request->validated();
        $validated['resep_id'] = $resepId;

        $resepBahan = ResepBahan::query()->create($validated);

        return redirect()->route('resep.show', $resepBahan->resep_id)->with('success', 'Bahan berhasil ditambahkan');
    }

    public function updateBahan(ResepBahanRequest $request, $resepId, $id)
    {
        $validated = $request->validated();
        $validated['resep_id'] = $resepId;

        $resepBahan = ResepBahan::query()->findOrFail($id);
        $resepBahan->update($validated);

        return redirect()->route('resep.show', $resepBahan->resep_id)->with('success', 'Bahan berhasil diubah');
    }

    public function destroyBahan($resepId, $id)
    {
        $resepBahan = ResepBahan::query()->findOrFail($id);
        $resepBahan->delete();

        return redirect()->route('resep.show', $resepBahan->resep_id)->with('success', 'Bahan berhasil dihapus');
    }

    public function update(ResepRequest $request, Resep $resep)
    {
        $resep->update($request->validated());

        return redirect()->route('resep.show', $resep->id)->with('success', 'Resep berhasil diubah');
    }

    public function destroy(Resep $resep)
    {
        $resep->delete();

        return redirect()->route('resep.index')->with('success', 'Resep berhasil dihapus');
    }
}
