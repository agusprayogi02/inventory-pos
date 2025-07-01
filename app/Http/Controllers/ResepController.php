<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResepRequest;
use App\Models\Resep;
use Yajra\DataTables\DataTables;

class ResepController extends Controller
{
    public function data()
    {
        $query = Resep::with('user:id,name');

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
        $data = Resep::select('id', 'nama')->get()->map(function ($item) {
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
        return Resep::create($request->validated());
    }

    public function show(Resep $resep)
    {
        return $resep;
    }

    public function update(ResepRequest $request, Resep $resep)
    {
        $resep->update($request->validated());

        return $resep;
    }

    public function destroy(Resep $resep)
    {
        $resep->delete();

        return response()->json();
    }
}
