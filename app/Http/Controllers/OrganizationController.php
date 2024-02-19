<?php

namespace App\Http\Controllers;

use App\Models\Token;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class OrganizationController extends SatuSehatController
{
    public function index()
    {
        $unit = Unit::with(['lokasi'])->get();
        return view('simrs.organization_index', compact(['unit']));
    }

    public function organization_sync(Request $request)
    {
        $unit = Unit::where('kode_unit', $request->kode)->first();
        if ($unit->id_satusehat) {
            Alert::error('Sudah memiliki id satu sehat');
        } else {
            $request['organization_id'] = "100025921";
            $request['identifier'] = $unit->nama_unit;
            $request['name'] = $unit->nama_unit;
            $request['phone'] = "08983311118";
            $request['email'] = "brsud.waled@gmail.com";
            $request['url'] = "rsudwaled.id";
            $request['address'] = "Jl. Prabu Kiansantang No.4";
            $request['postalCode'] = "45187";
            $request['province'] = "Jawa Barat";
            $request['city'] = "Kab. Cirebon";
            $request['district'] = "Waled";
            $request['village'] = "Waled Kota";
            $res = $this->store($request);
            $json = $res->response;
            if ($json->resourceType == "Organization") {
                $unit->update([
                    'id_satusehat' => $json->id,
                ]);
                Alert::success('Success', 'Berhasil Sync Organization');
            } else {
                Alert::error('Mohon Maaf', $res->metadata->message);
            }
        }
        return redirect()->back();
    }
    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "organization_id" => "required",
            "identifier" => "required",
            "name" => "required",
            "phone" => "required",
            "email" => "required|email",
            "url" => "required",
            "address" => "required",
            "postalCode" => "required",
            "province" => "required",
            "city" => "required",
            "district" => "required",
            "village" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $token = Token::latest()->first()->access_token;
        $url =  env('SATUSEHAT_BASE_URL') . "/Organization";
        $data = [
            "resourceType" => "Organization",
            "active" => true,
            "identifier" => [
                [
                    "use" => "official",
                    "system" => "http://sys-ids.kemkes.go.id/organization/100025921",
                    "value" => $request->identifier
                ]
            ],
            "type" => [
                [
                    "coding" => [
                        [
                            "system" => "http://terminology.hl7.org/CodeSystem/organization-type",
                            "code" => "dept",
                            "display" => "Hospital Department"
                        ]
                    ]
                ]
            ],
            "name" => $request->name,
            "telecom" => [
                [
                    "system" => "phone",
                    "value" => $request->phone,
                    "use" => "work"
                ],
                [
                    "system" => "email",
                    "value" => $request->email,
                    "use" => "work"
                ],
                [
                    "system" => "url",
                    "value" => $request->url,
                    "use" => "work"
                ]
            ],
            "address" => [
                [
                    "use" => "work",
                    "type" => "both",
                    "line" => [
                        $request->address
                    ],
                    "city" => $request->city,
                    "postalCode" => $request->postalCode,
                    "country" => "ID",
                    "extension" => [
                        [
                            "url" => "https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode",
                            "extension" => [
                                [
                                    "url" => "province",
                                    "valueCode" => $request->province,
                                ],
                                [
                                    "url" => "city",
                                    "valueCode" =>  $request->city,
                                ],
                                [
                                    "url" => "district",
                                    "valueCode" =>  $request->district,
                                ],
                                [
                                    "url" => "village",
                                    "valueCode" =>  $request->village,
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            "partOf" => [
                "reference" => "Organization/100025921",
            ]
        ];
        $response = Http::withToken($token)->post($url, $data);
        $res = $response->json();
        return $this->responseSatuSehat($res);
    }
}
