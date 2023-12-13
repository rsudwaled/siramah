<?php

namespace App\Http\Controllers\IGD\Kunjungan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use Carbon\Carbon;
use App\Models\Unit;
use App\Models\PenjaminSimrs;
use App\Models\DiagnosaFrunit;
use App\Models\HistoriesIGDBPJS;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Auth;
use DB;

class KunjunganController extends Controller
{
    public function daftarKunjungan(Request $request)
    {

        $query = DB::connection('mysql2')->table('ts_kunjungan')
        ->join('mt_pasien','ts_kunjungan.no_rm','=', 'mt_pasien.no_rm' )
        // ->join('erm_cppt_dokter', 'ts_kunjungan.kode_kunjungan', '=', 'erm_cppt_dokter.kode_kunjungan')
        // ->join('di_pasien_diagnosa_frunit', 'ts_kunjungan.kode_kunjungan', '=', 'di_pasien_diagnosa_frunit.kode_kunjungan')
        ->join('mt_unit', 'ts_kunjungan.kode_unit', '=', 'mt_unit.kode_unit')
        ->join('ts_jp_igd', 'ts_kunjungan.kode_kunjungan', '=', 'ts_jp_igd.kunjungan')
        ->join('mt_status_kunjungan', 'ts_kunjungan.status_kunjungan', '=', 'mt_status_kunjungan.ID')
        ->select(
            'mt_pasien.no_Bpjs as noKartu', 'mt_pasien.nik_bpjs as nik', 'mt_pasien.no_rm as rm','mt_pasien.nama_px as pasien','mt_pasien.alamat as alamat','mt_pasien.jenis_kelamin as jk',
            // 'erm_cppt_dokter.is_ranap as is_ranap','erm_cppt_dokter.kode_paramedis as kode_dokter','erm_cppt_dokter.tgl_input as tgl_assesment',
            'ts_kunjungan.kode_kunjungan as kunjungan','ts_kunjungan.status_kunjungan as stts_kunjungan','ts_kunjungan.no_sep as sep',
            'ts_kunjungan.tgl_masuk as tgl_kunjungan','ts_kunjungan.kode_unit as unit', 'ts_kunjungan.diagx as diagx',
            // 'di_pasien_diagnosa_frunit.diag_00 as diagnosa_assesment',
            'mt_unit.nama_unit as nama_unit',
            'mt_status_kunjungan.status_kunjungan as status',
        )
        ->orderBy('tgl_kunjungan', 'desc');


        $query2 = DiagnosaFrunit::whereBetween('input_date', ['2023-11-01', now()])
            ->where('status_bridging', 0)->orderBy('input_date','desc');
            
       
        if($request->tanggal && !empty($request->tanggal))
        {
            $dataYesterday = Carbon::createFromFormat('Y-m-d',  $request->tanggal);
            $yesterday = $dataYesterday->subDays(2)->format('Y-m-d');
            $query->whereDate('ts_kunjungan.tgl_masuk','>=', $yesterday); 
            $query->whereDate('ts_kunjungan.tgl_masuk','<=', $request->tanggal); 
        }
        if($request->unit && !empty($request->unit))
        {
            $query->whereIn('ts_kunjungan.kode_unit', [$request->unit]); 
            $query2->whereIn('kode_unit', [$request->unit]); 
        }

        $kunjungan = $query->get();
        $pasien_fr = $query2->get();
        $unit = Unit::all();
        return view('simrs.igd.kunjungan.kunjungan_now', compact('kunjungan','request','unit','pasien_fr'));
    }
}
