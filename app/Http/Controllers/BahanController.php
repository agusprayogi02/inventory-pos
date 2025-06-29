<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use Illuminate\Http\Request;
use Yajra\DataTables\Exceptions\Exception;
use Yajra\DataTables\Facades\DataTables;

class BahanController extends Controller
{
    /**
     * @throws Exception
     */
    public function data()
    {
        try {
            $query = Bahan::with('satuan:id,nama');

            return DataTables::eloquent($query)
                ->addColumn('satuan_nama', function (Bahan $bahan) {
                    return $bahan->satuan ? $bahan->satuan->nama : '-';
                })
                ->addColumn('action', function (Bahan $bahan) {
                    return view('bahan.action', compact('bahan'))->render();
                })
                ->rawColumns(['action'])
                ->toJson();
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'data' => [],
                'recordsTotal' => 0,
                'recordsFiltered' => 0
            ]);
        }
    }

    public function index()
    {
        return view('bahan.index');
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
