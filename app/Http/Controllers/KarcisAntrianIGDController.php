<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\AntrianPasienIGD;
use App\Models\TriaseIGD;
use App\Models\Kunjungan;
use App\Models\Pasien;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MiningExport;


class KarcisAntrianIGDController extends Controller
{
    public function daftarKarcis()
    {
        return view('simrs.igd.antrian.karcis_antrian');
    }

    public function createKarcisAntrian(Request $request)
    {
        $incre  = '001'; 
        $carbon = Carbon::now()->format('Ymd');
        $kode   = 'A'.Str::substr($carbon, 2);
        $karc_first =$kode.$incre;
        $last_karc = AntrianPasienIGD::where(substr('created_at', 8),Str::substr(Carbon::now()->format('Y-m-d'), 8))->first();
        dd($last_karc);
        if($last_karc)
        {
            AntrianPasienIGD::create([
                'no_antri' => $karc_first,
                'tgl' => now(),
                'status' => 1,
                'created_at' => now(),
            ]);
        }else{
            $create_karc = Str::substr($last_karc->no_antri, 7);
            $new_kacr= $last_karc->no_antri+1;
        }
    }

    // controller tambang data ugd
    public function getPasienIGD(Request $request)
    {
        $year = '2023';
        $month = '09';
        // $pasienIn = Pasien::join('ts_kunjungan', 'mt_pasien.no_rm', '=', 'ts_kunjungan.no_rm')
        // ->where('kode_unit', '1002')->whereYear('tgl_masuk', $year)->whereMonth('tgl_masuk', $month)->limit(500)->get();

        // $join_knj = Kunjungan::join('mt_pasien', 'ts_kunjungan.no_rm', '=', 'mt_pasien.no_rm')
        // ->where('kode_unit', '1002')->whereYear('tgl_masuk', $year)->limit(10)->get();
        // dd($join_knj, $pasienIn);
        $namaFile = 'mining_pasien_'.$year.'-'.$month.'.xlsx';
        return Excel::download(new MiningExport($request), $namaFile);

    }
}
