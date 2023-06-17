<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Matkul;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MatkulController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()){
            $group = Matkul::orderBy('id', 'desc');
            return DataTables::of($group)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="float-end">';
                    $btn .= '<a
                                type="button"
                                data-remote="'.route('admin.matkul.edit', $row->id).'"
                                data-title="Ubah Group"
                                data-bs-toggle="modal"
                                data-bs-target="#modal"
                                class="btn btn-primary btn-sm"
                                style="margin-right: 3px;">Edit</a>';
                    $btn .= '<a
                                type="button"
                                data-remote="'.route('admin.matkul.destroy', $row->id).'"
                                data-title="Hapus Group"
                                data-table="group"
                                data-bs-toggle="modal"
                                data-bs-target="#danger"
                                class="btn btn-danger btn-sm hapus"
                                style="margin-right: 3px;">Hapus</a>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.admin.matkul.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pages.admin.matkul.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Matkul::create($request->only([
            'nama',
            'kode',
            'jadwal',
            'jam_mulai',
            'jam_selesai',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambahkan data matkul',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Matkul::findOrFail($id);
        return view('pages.admin.matkul.edit')->with([
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Matkul::findOrFail($id)->update($request->only([
            'nama',
            'kode',
            'jadwal',
            'jam_mulai',
            'jam_selesai',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengubah data matkul',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
