<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Angkatan;
use App\Models\Kelas;
use App\Models\Matkul;
use App\Models\Qrcode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class QrcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): mixed
    {   
        $isAdmin = Helper::isAdmin();

        if(request()->ajax()){
            $group = Qrcode::orderBy('id', 'desc')->with(['angkatan', 'kelas', 'matkul']);

            $group = $group->where(function ($query) use ($request, $isAdmin) {
                if($request->filterKelas){
                    $query->where('id_kelas', $request->filterKelas);
                }
                
                if(!$isAdmin){
                    $query->where('id_kelas', Auth::user()->kelas);
                }

                if($request->filterAngkatan){
                    $query->where('id_angkatan', $request->filterAngkatan);
                }
                if($request->filterMatkul){
                    $query->where('id_matkul', $request->filterMatkul);
                }
                if($request->filterHari){
                    list($tahun, $bulan, $tanggal) = explode("-", $request->filterHari);
                    $query->where('tahun', $tahun);
                    $query->where('bulan', $bulan);
                    $query->where('tanggal', $tanggal);
                }
            })->get();

            return DataTables::of($group)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="float-end">';
                    $btn .= '<a
                                href="'.route('admin.qrcode.edit', $row->id).'"
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

        $angkatan = Angkatan::all();
        $kelas = Kelas::all();
        
        $matkul = Matkul::query();
        if(!$isAdmin){
            $matkul->where('id_kelas', Auth::user()->kelas);
        }

        $matkul = $matkul->get();

        return view('pages.admin.qrcode.index')->with([
            'angkatan' => $angkatan,
            'kelas' => $kelas,
            'matkul' => $matkul,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.qrcode.create');
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
                $uniqueCode = "{". $uniqueCode ."}";
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
        $data = Qrcode::find($id);

        return view('pages.admin.qrcode.edit')->with([
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Qrcode::find($id);

        $req = [
            'teachingId' => $request->teachingId,
            'periodId' => $request->periodId,
            'date' => $request->date,
            'meetingTo' => $request->meetingTo,
            'uniqueCode' => $request->uniqueCode,
        ];

        $data->update($req);

        return redirect()->route('admin.qrcode.index')->with('success', 'Berhasil mengubah data');
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

    public function createJson()
    {
        return view('pages.admin.qrcode.json')->with([]);
    }

    public function storeJson(Request $request)
    {
        DB::beginTransaction();
        try{

            $listData = json_decode($request->dataQrCode);
    
            $qrcode = [];
            foreach($listData as $data){
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
                    'jam' => $data->jam,
                    'menit' => $data->menit,
                    'detik' => "00",
                    'uniqueCode' => $data->uniqueCode,
                    'nama' => $request->nama,
                ];
            }
            Qrcode::insert($qrcode);
            
            DB::commit();
            return redirect()->route('admin.qrcode.index')->with('success', 'Berhasil menambahkan data');
        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->route('admin.qrcode.index')->with('error', 'Gagal menambahkan data');
        }
    }
}