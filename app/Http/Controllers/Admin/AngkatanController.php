<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AngkatanRequest;
use App\Models\Angkatan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class AngkatanController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(): mixed
    {
        if(request()->ajax()){
            $group = Angkatan::orderBy('id', 'desc');
            return DataTables::of($group)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="float-end">';
                    $btn .= '<a
                                type="button"
                                data-remote="'.route('admin.angkatan.edit', $row->id).'"
                                data-title="Ubah Group"
                                data-bs-toggle="modal"
                                data-bs-target="#modal"
                                class="btn btn-primary btn-sm"
                                style="margin-right: 3px;">Edit</a>';
                    $btn .= '<a
                                type="button"
                                data-remote="'.route('admin.angkatan.destroy', $row->id).'"
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
        return view('pages.admin.angkatan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // $user = Auth::user();
        // return $user->roles()->where('name', 'mahasiswa')->with('permissions')->get();
        
        $this->authorize('add', Angkatan::class);
        return view('pages.admin.angkatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AngkatanRequest $request): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil ditambahkan!'
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
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
