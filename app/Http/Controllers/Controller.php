<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function sendResponse($status = 'Failed', $msg = 'data not found', $data = null, $code = 404)
    {
        return response()->json([
            'status' => $status,
            'message' => $msg,
            'data' => $data 
        ], $code);
    }
}
