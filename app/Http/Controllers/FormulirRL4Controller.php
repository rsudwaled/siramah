<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanRLEmpatSatuVersi6;
use App\Exports\LaporanRLEmpatDuaVersi6;
use App\Exports\LaporanRLEmpatTigaVersi6;
use App\Models\Kunjungan;
use DB;

class FormulirRL4Controller extends Controller
{
    public function FormulirRL41Versi6(Request $request)
    {

        $from = $request->dari;
        $to = $request->sampai;
        $data = null;

        if ($from && $to) {
           $data = Kunjungan::select('kode_kunjungan', 'counter', 'no_rm', 'tgl_masuk', 'tgl_keluar', 'status_kunjungan', 'diagx', 'id_alasan_pulang')
           ->with([
               'laporanDiagnosa',
               'pasien:no_rm,jenis_kelamin,tgl_lahir'
           ])
           ->whereDate('tgl_masuk', '>=', $from)
           ->whereDate('tgl_keluar', '<=', $to)
           ->whereNotIn('status_kunjungan', ['1', '8', '9', '11'])
           ->get();
        }

       return view('simrs.formulir.f_r_l_4.formulir_rl_4_1_versi_6',compact('data','from','to','request'));
    }

    public function FormulirRL42Versi6(Request $request)
    {

        $from = $request->dari;
        $to = $request->sampai;
        $data = null;

        if ($from && $to) {
            $data = Kunjungan::select('kode_kunjungan', 'counter', 'no_rm', 'tgl_masuk', 'tgl_keluar', 'status_kunjungan', 'diagx', 'id_alasan_pulang')
           ->with([
               'laporanDiagnosa',
               'pasien:no_rm,jenis_kelamin,tgl_lahir'
           ])
           ->whereDate('tgl_masuk', '>=', $from)
           ->whereDate('tgl_keluar', '<=', $to)
           ->whereNotIn('status_kunjungan', ['1', '8', '9', '11'])
           ->get();
        }

       return view('simrs.formulir.f_r_l_4.formulir_rl_4_2_versi_6',compact('data','from','to','request'));
    }

    public function FormulirRL43Versi6(Request $request)
    {

        $from = $request->dari;
        $to = $request->sampai;
        $data = null;

        if ($from && $to) {
            $data = Kunjungan::select('kode_kunjungan', 'counter', 'no_rm', 'tgl_masuk', 'tgl_keluar', 'status_kunjungan', 'diagx', 'id_alasan_pulang')
            ->with([
                'laporanDiagnosa',
                'pasien:no_rm,jenis_kelamin,tgl_lahir'
            ])
            ->whereDate('tgl_masuk', '>=', $from)
            ->whereDate('tgl_keluar', '<=', $to)
            ->whereNotIn('status_kunjungan', ['1', '8', '9', '11'])
            ->get();
        }

       return view('simrs.formulir.f_r_l_4.formulir_rl_4_3_versi_6',compact('data','from','to','request'));
    }

    public function FormulirRL41Export(Request $request)
    {
        if($request->dari == null && $request->sampai == null )
        {
            Alert::error('EXPORT ERROR!', 'untuk export data, dimohon untuk memilih data umur terlebih dahulu.');
            return back();
        }

        $start = Carbon::parse($request->dari)->format('d-m-Y');
        $finish = Carbon::parse($request->sampai)->format('d-m-Y');
        $namaFile = $start.'_'.$finish.' Laporan Rl 4.1 Versi 6.xlsx';
        return Excel::download(new LaporanRLEmpatSatuVersi6($request), $namaFile);
    }

    public function FormulirRL42Export(Request $request)
    {
        if($request->dari == null && $request->sampai == null )
        {
            Alert::error('EXPORT ERROR!', 'untuk export data, dimohon untuk memilih data umur terlebih dahulu.');
            return back();
        }
        $start = Carbon::parse($request->dari)->format('d-m-Y');
        $finish = Carbon::parse($request->sampai)->format('d-m-Y');
        $namaFile = $start.'_'.$finish.' Laporan Rl 4.2 Versi 6.xlsx';
        return Excel::download(new LaporanRLEmpatDuaVersi6($request), $namaFile);
    }

    public function FormulirRL43Export(Request $request)
    {
        if($request->dari == null && $request->sampai == null )
        {
            Alert::error('EXPORT ERROR!', 'untuk export data, dimohon untuk memilih data umur terlebih dahulu.');
            return back();
        }
        $start = Carbon::parse($request->dari)->format('d-m-Y');
        $finish = Carbon::parse($request->sampai)->format('d-m-Y');
        $namaFile = $start.'_'.$finish.' Laporan Rl 4.3 Versi 6.xlsx';
        return Excel::download(new LaporanRLEmpatTigaVersi6($request), $namaFile);
    }
    public function FormulirRL4AK(Request $request)
    {
        $from       = $request->dari;
        $to         = $request->sampai;
        $yearsFrom  = Carbon::parse($request->dari)->format('Y');
        $yearsTo    = Carbon::parse($request->sampai)->format('Y');

        $laporanFM = null;

        if ($from && $to) {
            $laporanFM = \DB::connection('mysql2')->select("CALL `SP_LAPORAN_DIAGNOSA_MORBIDITAS_RANAP_KECELAKAAN`('$from','$to')");
            $laporanFM = collect($laporanFM);

        }
        return view('simrs.formulir.f_r_l_4.formulir_rl_4AK',compact('laporanFM','from','to','request','yearsFrom','yearsTo'));
    }

    public function FormulirRL4B(Request $request)
    {
        $from       = $request->dari;
        $to         = $request->sampai;
        $yearsFrom  = Carbon::parse($request->dari)->format('Y');
        $yearsTo    = Carbon::parse($request->sampai)->format('Y');

        $laporanFM = null;
        if ($from && $to) {
            $laporanFM = \DB::connection('mysql2')->select("CALL `SP_LAPORAN_DIAGNOSA_MORBIDITAS_RAJAL`('$from','$to')");
            $laporanFM = collect($laporanFM);
        }
        // dd($laporanFM);
        return view('simrs.formulir.f_r_l_4.formulir_rl_4B',compact('laporanFM','from','to','request','yearsFrom','yearsTo'));
    }
    public function FormulirRL4BK(Request $request)
    {
        $from       = $request->dari;
        $to         = $request->sampai;
        $yearsFrom  = Carbon::parse($request->dari)->format('Y');
        $yearsTo    = Carbon::parse($request->sampai)->format('Y');
        $laporanFM = null;
        if ($from && $to) {
            $laporanFM = \DB::connection('mysql2')->select("CALL `SP_LAPORAN_DIAGNOSA_MORBIDITAS_RAJAL_KECELAKAAN`('$from','$to')");
            $laporanFM = collect($laporanFM);
        }
        return view('simrs.formulir.f_r_l_4.formulir_rl_4BK',compact('laporanFM','from','to','request','yearsFrom','yearsTo'));
    }

}
