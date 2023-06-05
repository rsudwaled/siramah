<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse($data, $code = 200)
    {
        $response = [
            'response' => $data,
            'metadata' => [
                'message' => 'Success',
                'code' => $code,
            ],
        ];
        return response()->json($response, 200);
    }
    public function sendError($error,  $code = 404)
    {
        $code = $code ?? 404;
        $response = [
            'metadata' => [
                'message' => $error,
                'code' => $code,
            ],
        ];
        return response()->json($response, 200);
    }
}
