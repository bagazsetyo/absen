<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Angkatan;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()){
            $group = User::orderBy('id', 'desc');
            return DataTables::of($group)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="float-end">';
                    $btn .= '<a
                                type="button"
                                data-remote="'.route('admin.user.edit', $row->id).'"
                                data-title="Ubah Group"
                                data-bs-toggle="modal"
                                data-bs-target="#modal"
                                class="btn btn-primary btn-sm"
                                style="margin-right: 3px;">Edit</a>';
                    $btn .= '<a
                                type="button"
                                data-remote="'.route('admin.user.destroy', $row->id).'"
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
        return view('pages.admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $angkatan = Angkatan::all();
        return view('pages.admin.user.create')->with([
            'angkatan' => $angkatan
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name',
            'email',
            'wa',
            'npm',
            'angkatan',
            'kelas',
        ]);

        DB::beginTransaction();
        try{
            $user = $request->only([
                'name',
                'email',
                'wa',
                'npm',
                'angkatan',
                'kelas',
            ]);
    
            $createUser = User::create($user);
            
            $createUser->assignRole(['mahasiswa']);
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil ditambah!'
            ]);
        }catch(\Exception $e){
            DB::rollback();
            
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
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
        $angkatan = Angkatan::all();
        $user = User::find($id);
        $kelas = Kelas::where('id_angkatan', $user->angkatan)->get();
        return view('pages.admin.user.edit')->with([
            'angkatan' => $angkatan,
            'user' => $user,
            'kelas' => $kelas
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name',
            'email',
            'wa',
            'npm',
            'angkatan',
            'kelas',
        ]);

        DB::beginTransaction();
        try{
            $user = $request->only([
                'name',
                'email',
                'wa',
                'npm',
                'angkatan',
                'kelas',
            ]);
    
            $createUser = User::find($id);
            $createUser->update($user);
        }catch(\Exception $e){
            DB::rollback();
            
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id)->delete($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus!'
        ]);
    }
}
