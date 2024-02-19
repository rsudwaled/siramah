<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SatuSehatController extends APIController
{
    public function token_generate()
    {
        $url = env('SATUSEHAT_AUTH_URL') . "/accesstoken?grant_type=client_credentials";
        $response = Http::asForm()->post($url, [
            'client_id' => env('SATUSEHAT_CLIENT_ID'),
            'client_secret' => env('SATUSEHAT_SECRET_ID'),
        ]);
        if ($response->successful()) {
            $json = $response->json();
            Token::create([
                'access_token' => $json['access_token'],
                'application_name' => $json['application_name'],
                'organization_name' => $json['organization_name'],
                'token_type' => $json['token_type'],
                'issued_at' => $json['issued_at'],
            ]);
            Log::notice('Auth Token Satu Sehat : ' . $json['access_token']);
        }
        return response()->json($response->json(), $response->status());
    }
    public function responseSatuSehat($data)
    {
        if ($data['resourceType'] == "OperationOutcome") {
            $response = [
                'response' => $data,
                'metadata' => [
                    'message' => $data['issue'][0]['code'],
                    'code' => 500,
                ],
            ];
            if ($data['issue'][0]['code'] == "invalid-access-token") {
                $token = $this->token_generate();
            }
        } else {
            $response = [
                'response' => $data,
                'metadata' => [
                    'message' => "Ok",
                    'code' => 200,
                ],
            ];
        }
        return json_decode(json_encode($response));
    }
}
