<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\QrcodeRrquest;
use App\Http\Resources\Api\QrcodeResource;
use App\Services\Api\QrcodeServices;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QrcodeController extends Controller
{

    private QrcodeServices $qrcodeServices ;

    public function __construct(QrcodeServices $qrcodeServices)
    {
        $this->qrcodeServices = $qrcodeServices;
    }

    public function getCode(QrcodeRrquest $request)
    {
        try {
            $data = $this->qrcodeServices->getCode($request);
            if($data['code'] != Response::HTTP_OK){
                return Response::responseError($data['message'], $data['code']);
            }
            return Response::responseMessage(new QrcodeResource($data), $data['code']);
        }catch(\Exception $e){
            return Response::responseError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }
}
