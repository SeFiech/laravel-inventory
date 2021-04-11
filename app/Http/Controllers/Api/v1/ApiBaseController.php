<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiBaseController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 401;

    private function sendRespose($data, $statusCode) {
        return response()->json(['data' => $data], $statusCode, ['Content-Type' => 'application/json;charset=UTF-8'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public function sendError(\Exception $e)
    {
        $data['status'] = false;
        $statusCode = $this->errorStatus;
        $data['code'] = $statusCode;
        $data['msg'] = $e->getTraceAsString();
        return $this->sendRespose($data, $statusCode);
    }

    public function sendFailMessage($msg)
    {
        $data['status'] = false;
        $data['code'] = $this->errorStatus;
        $data['msg'] = $msg;
        return $this->sendRespose($data, $this->errorStatus);
    }

    public function sendSuccessData($data)
    {
        $data['status'] = true;
        $data['code'] = $this->successStatus;
        $data['msg'] = $data;
        return $this->sendRespose($data, $this->successStatus);
    }
}
