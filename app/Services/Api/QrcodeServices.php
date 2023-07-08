<?php 

namespace App\Services\Api;

use App\Models\Qrcode;
use App\Models\User;
use Illuminate\Http\Response;

class QrcodeServices
{
    protected $messagePattern = [
        '-k' => 'kode',
        'absen' => 'message'
    ];

    protected User $user;
    protected Qrcode $qrcode;

    public function __construct()
    {
    }

    public function getCode($request)
    {
        // * inital user
        $user = User::where('wa', $request->phone)->first();
        if(!$user){
            return [
                'code' => Response::HTTP_NOT_FOUND,
                'message' => __('messages.userNotFound')
            ];
        }
        $this->user = $user;
        
        // initial qrcode
        $qrcode = $this->getQrcode();
        if(isset($qrcode['code']) && $qrcode['code'] != Response::HTTP_OK){
            return $qrcode;
        }
        
        $caption = $this->captionQrcode($request->message);
        return [
            'code' => Response::HTTP_OK,
            'caption' => $caption,
            'data' => $this->qrcode->uniqueCode ?? '',
        ];
    }

    protected function getQrcode()
    {
        $date = date('Y-m-d');
        list($year, $month, $day) = explode('-', $date);

        $qrcode = Qrcode::where('id_kelas', $this->user->kelas)
                    ->where('id_angkatan', $this->user->angkatan)
                    ->where('tahun', $year)
                    ->where('bulan', $month)
                    ->where('tanggal', $day)
                    ->with('matkul')
                    ->get();

        if($qrcode->isEmpty()){
            return [
                'code' => Response::HTTP_NOT_FOUND,
                'message' => __('messages.qrcodeNotFound')
            ];
        }
        // loop qrcode 
        foreach ($qrcode as $key => $value) {
            if(date('H:i:s') >= $value->matkul->jam_mulai && date('H:i:s') <= $value->matkul->jam_selesai){
                $this->qrcode = $value;
                break;
            } 
        }
        return $qrcode;
    }

    protected function captionQrcode($message)
    {
        $message = explode(' ', $message);
        krsort($message);

        $caption = '';
        foreach ($message as $key => $value) {
            if(isset($this->messagePattern[$value])){
                $caption .= $this->{$this->messagePattern[$value]}();
            }
        }

        return $caption;
    }

    protected function kode()
    {
        $qecode = $this->qrcode;
        $caption = "";

        list($jam, $menit) = explode(":", $qecode->matkul->jam_selesai);
        $newDate = "{$qecode->tahun}{$qecode->bulan}{$qecode->tanggal}{$jam}{$menit}00";
        $formatterData = "teachingId:".$qecode->teachingId."|periodId:".$qecode->periodId."|date:".$newDate."|meetingTo:".$qecode->meetingTo;
        $caption .= "Data : {$formatterData} \n";
        $caption .= "Kode : {$this->qrcode->uniqueCode} \n\n";

        return $caption;
    }

    protected function message()
    {
        $matkul = $this->qrcode->matkul;
        $caption = "";
        $caption .= "Hai {$this->user->name}, \n";
        $caption .= "Jam : {$matkul->jam_mulai} - {$matkul->jam_selesai} \n";
        $caption .= "Matkul : {$matkul->nama} \n";
        $caption .= "\n";
        $caption .= "Silahkan scan qrcode diatas untuk absen ";
        $caption .= "sebelum jam {$matkul->jam_selesai}. apabila sudah diabsenkan oleh dosen,";
        $caption .= "maka qrcode akan otomatis tidak berlaku. Segera hubungi dosen jika terjadi kesalahan. ";
        $caption .= "*Kami tidak bertanggung jawab atas keterlambatan anda";
        $caption .= "untuk absen*";

        return $caption;
    }

}