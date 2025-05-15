<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VindaController extends Controller
{
    public function get_biaya_sep($sep, Request $request)
    {
        try {
            Log::info("Vinda Get SEP " . $request);
            $kunjungan = Kunjungan::where('no_sep', $sep)->first();
            if ($kunjungan) {
                $request['norm'] = $kunjungan->no_rm;
                $request['counter'] = $kunjungan->counter;
                $response = collect(DB::connection('mysql2')->select("CALL RINCIAN_BIAYA_FINAL('" . $request->norm . "','" . $request->counter . "','','')"));
                $data = [
                    "SEP" => $kunjungan->no_sep,
                    "KODE_TARIF" => "BP",
                    "DISCHARGE_DATE" => Carbon::parse($kunjungan->tgl_keluar)->format('Y-m-d') ?? now()->format('Y-m-d'),
                    "CARA_MASUK" => $kunjungan->alasan_masuk?->kode ?? 'other',
                    "DISCHARGE_STATUS" => $kunjungan->alasan_pulang?->kode_discharge_status ?? 5,
                    "DPJP" => $kunjungan->dokter->nama_paramedis,
                    "PROSEDUR_NON_BEDAH" => number_format($response->where('nama_group_vclaim', "PROSEDURE NON BEDAH")->sum("GRANTOTAL_LAYANAN"), 1, '.', ''),
                    "PROSEDUR_BEDAH" => number_format($response->where('nama_group_vclaim', "PROSEDURE BEDAH")->sum("GRANTOTAL_LAYANAN"), 1, '.', ''),
                    "KONSULTASI" => number_format($response->where('nama_group_vclaim', "KONSULTASI")->sum("GRANTOTAL_LAYANAN"), 1, '.', ''),
                    "TENAGA_AHLI" => number_format($response->where('nama_group_vclaim', "TENAGA AHLI")->sum("GRANTOTAL_LAYANAN"), 1, '.', ''),
                    "KEPERAWATAN" => number_format($response->where('nama_group_vclaim', "KEPERAWATAN")->sum("GRANTOTAL_LAYANAN"), 1, '.', ''),
                    "PENUNJANG" => number_format($response->where('nama_group_vclaim', "PENUNJANG MEDIS")->sum("GRANTOTAL_LAYANAN"), 1, '.', ''),
                    "RADIOLOGI" => number_format($response->where('nama_group_vclaim', "RADIOLOGI")->sum("GRANTOTAL_LAYANAN"), 1, '.', ''),
                    "LABORATORIUM" => number_format($response->where('nama_group_vclaim', "LABORATORIUM")->sum("GRANTOTAL_LAYANAN"), 1, '.', ''),
                    "PELAYANAN_DARAH" => number_format($response->where('nama_group_vclaim', "PELAYANAN DARAH")->sum("GRANTOTAL_LAYANAN"), 1, '.', ''),
                    "REHABILITASI" => number_format($response->where('nama_group_vclaim', "REHABILITASI MEDIK")->sum("GRANTOTAL_LAYANAN"), 1, '.', ''),
                    "KAMAR_AKOMODASI" => number_format($response->where('nama_group_vclaim', "KAMAR/AKOMODASI")->sum("GRANTOTAL_LAYANAN"), 1, '.', ''),
                    "RAWAT_INTENSIF" => number_format($response->where('nama_group_vclaim', "RAWAT INTENSIF")->sum("GRANTOTAL_LAYANAN"), 1, '.', ''),
                    "OBAT" => number_format($response->where('nama_group_vclaim', "OBAT")->sum("GRANTOTAL_LAYANAN"), 1, '.', ''),
                    "OBAT_KRONIS" => number_format($response->where('nama_group_vclaim', "OBAT KRONIS")->sum("GRANTOTAL_LAYANAN"), 1, '.', ''),
                    "OBAT_KEMO" => number_format($response->where('nama_group_vclaim', "OBAT KEMOTERAPI")->sum("GRANTOTAL_LAYANAN"), 1, '.', ''),
                    "ALKES" => number_format($response->where('nama_group_vclaim', "ALKES")->sum("GRANTOTAL_LAYANAN"), 1, '.', ''),
                    "BMHP" => number_format($response->where('nama_group_vclaim', "BMHP")->sum("GRANTOTAL_LAYANAN"), 1, '.', ''),
                    "SEWA_ALAT" => number_format($response->where('nama_group_vclaim', "SEWA ALAT")->sum("GRANTOTAL_LAYANAN"), 1, '.', ''),
                    "TARIF_RS" => number_format($response->sum("GRANTOTAL_LAYANAN"), 1, '.', ''),
                    "BIRTH_WEIGHT" => 0,
                    "SITB_REG_ID" => "",
                    "ICU_LOS" => 0,
                    "UPGRADE_CLASS_LOS" => 0,
                ];
                $response = [
                    'metadata' => [
                        'message' => "Data KLaim No.SEP " . $kunjungan->no_sep,
                        'code' =>  200,
                    ],
                    'response' => $data,
                ];
                return json_decode(json_encode($response));
            } else {
                $response = [
                    'metadata' => [
                        'message' => "No SEP tidak memiliki kunjungan di RS",
                        'code' =>  400,
                    ],
                ];
                return json_decode(json_encode($response));
            }
        } catch (\Throwable $th) {
            Log::info("Vinda ERROR SEP " . $th->getMessage());
            $response = [
                'metadata' => [
                    'message' => $th->getMessage(),
                    'code' =>  400,
                ],
            ];
            return json_decode(json_encode($response));
        }
    }
}
