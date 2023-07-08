<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Angkatan;
use App\Models\Kelas;
use App\Models\Matkul;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function angkatan(Request $request)
    {
        $angkatan = Angkatan::where('id', $request->angkatan)->get();
        return response()->json($angkatan);
    }
    
    public function kelas(Request $request)
    {
        $kelas = Kelas::where('id_angkatan', $request->angkatan)->get();
        return response()->json($kelas);
    }

    public function matkul(Request $request)
    {
        $matkul = Matkul::where('id_kelas', $request->kelas)->get();
        return response()->json($matkul);
    }

    
    public function selectAngkatan(Request $request)
    {
        $angkatan = Angkatan::select('id', 'nama as text')
                    ->where('id', $request->angkatan)
                    ->orWhere('nama', 'like', '%'.$request->q.'%')
                    ->get();
        
        $result = [
            'results' => $angkatan,
        ];
        return response()->json($result);
    }
    
    public function selectKelas(Request $request)
    {
        $kelas = Kelas::select('id', 'nama as text')
                    ->where('id_angkatan', $request->angkatan)
                    ->where('nama', 'like', '%'.$request->term.'%')
                    ->get();
        
        $result = [
            'results' => $kelas,
        ];
        return response()->json($result);
    }

    public function selectMatkul(Request $request)
    {
        $matkul = Matkul::select('id', 'nama as text')
                ->where('id_kelas', $request->kelas)
                ->where('nama', 'like', '%'.$request->term.'%')
                ->get();
        
        $result = [
            'results' => $matkul,
        ];
        return response()->json($result);
    }
}
