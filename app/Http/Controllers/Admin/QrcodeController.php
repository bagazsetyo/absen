<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Angkatan;
use App\Models\Kelas;
use App\Models\Matkul;
use App\Models\Qrcode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class QrcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): mixed
    {
        
        if(request()->ajax()){
            $group = Qrcode::orderBy('id', 'desc')->with(['angkatan', 'kelas', 'matkul'])->get();
            return DataTables::of($group)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="float-end">';
                    $btn .= '<a
                                type="button"
                                data-remote="'.route('admin.qrcode.edit', $row->id).'"
                                data-title="Ubah Group"
                                data-bs-toggle="modal"
                                data-bs-target="#modal"
                                class="btn btn-primary btn-sm"
                                style="margin-right: 3px;">Edit</a>';
                    $btn .= '<a
                                type="button"
                                data-remote="'.route('admin.qrcode.destroy', $row->id).'"
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
        return view('pages.admin.qrcode.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $angkatan = Angkatan::all();
        $kelas = Kelas::all();
        $matkul = Matkul::all();
        return view('pages.admin.qrcode.create')->with([
            'angkatan' => $angkatan,
            'kelas' => $kelas,
            'matkul' => $matkul,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $matkul = Matkul::find($request->matkul);
    
            list($jam, $menit) = explode(":", $matkul->jam_selesai);
    
            $listData = json_decode($request->jsonData);
            $qrcode = [];
            foreach($listData as $data){
                $newDate = "{$data->tahun}{$data->bulan}{$data->tanggal}{$jam}{$menit}00";
                $uniqueCode = "teachingId:".$data->teachingId."|periodId:".$data->periodId."|date:".$newDate."|meetingTo:".$data->meetingTo;
    
                $uniqueCode = base64_encode($uniqueCode);
                $qrcode[] = [
                    'id_angkatan' => $request->angkatan,
                    'id_kelas' => $request->kelas,
                    'id_matkul' => $request->matkul,
                    'teachingId' => $data->teachingId,
                    'periodId' => $data->periodId,
                    'date' => $data->date,
                    'meetingTo' => $data->meetingTo,
                    'tahun' => $data->tahun,
                    'bulan' => $data->bulan,
                    'tanggal' => $data->tanggal,
                    'jam' => $jam,
                    'menit' => $menit,
                    'detik' => "00",
                    'uniqueCode' => $uniqueCode,
                    'nama' => $request->nama,
                ];
            }
            Qrcode::insert($qrcode);

            DB::commit();
    
            return redirect()->route('admin.qrcode.index')->with('success', 'Berhasil menambahkan data');
        }catch (\Exception $e){
            dd($e->getMessage());
            DB::rollBack();
            return redirect()->route('admin.qrcode.index')->with('error', 'Gagal menambahkan data');
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
        //
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
        Qrcode::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus data'
        ]);
    }
}
