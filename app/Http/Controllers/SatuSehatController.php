<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SatuSehatController extends Controller
{
    public string $baseurl = "https://api-satusehat.kemkes.go.id/oauth2/v1";
    public function token_generate(Request $request)
    {
        $url = $this->baseurl . "/accesstoken?grant_type=client_credentials";
        $response = Http::asForm()->post($url, [
            'client_id' => "85ElTXsaYvakYMw26qcyGn24B6AD7rTrKcrYWZEn9qaolHX4",
            'client_secret' => "ZgmUth7OQwHR8sVNVw7Wtu0ABG3loIgsjqSvo64ui59zArRtXzGeDqANLob4skyQ",
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

}
