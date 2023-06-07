<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APIController extends Controller
{
    public function sendResponse($data, $code = 200)
    {
        $response = [
            'response' => $data,
            'metadata' => [
                'message' => 'OK',
                'code' => $code,
            ],
        ];
        return json_decode(json_encode($response));
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
        return json_decode(json_encode($response));
    }
}
