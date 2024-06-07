<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class CekPasienPulangExport implements FromView
{
    public function view():View
    {
        $tanggal      = request()->input('tanggal') ;
        $unit         = request()->input('unit') ;

        $query = DB::connection('mysql2')->table('ts_kunjungan')
            ->join('mt_pasien','ts_kunjungan.no_rm','=', 'mt_pasien.no_rm' )
            ->join('mt_unit', 'ts_kunjungan.kode_unit', '=', 'mt_unit.kode_unit')
            ->join('mt_status_kunjungan', 'ts_kunjungan.status_kunjungan', '=', 'mt_status_kunjungan.ID')
            ->select(
                'mt_pasien.no_Bpjs as noKartu', 'mt_pasien.nik_bpjs as nik', 'mt_pasien.no_rm as rm','mt_pasien.nama_px as pasien','mt_pasien.alamat as alamat','mt_pasien.jenis_kelamin as jk',
                'ts_kunjungan.kode_kunjungan as kunjungan',
                'ts_kunjungan.status_kunjungan as stts_kunjungan',
                'ts_kunjungan.no_sep as sep',
                'ts_kunjungan.form_send_by as form_send_by',
                'ts_kunjungan.ref_kunjungan as ref_kunjungan',
                'ts_kunjungan.is_bpjs_proses as is_bpjs_proses',
                'ts_kunjungan.tgl_keluar as tgl_pulang',
                'ts_kunjungan.kode_unit as unit',
                'ts_kunjungan.diagx as diagx',
                'ts_kunjungan.lakalantas as lakaLantas',
                'ts_kunjungan.jp_daftar as jp_daftar',
                'ts_kunjungan.id_ruangan as ruangan',
                'ts_kunjungan.kamar as kamar',
                'ts_kunjungan.no_bed as bed',
                'mt_unit.nama_unit as nama_unit',
                'mt_status_kunjungan.status_kunjungan as status',
                'mt_status_kunjungan.ID as id_status',
            )
            ->orderBy('ts_kunjungan.tgl_keluar', 'desc');

        if($tanggal && !empty($tanggal))
        {
            $query->whereDate('ts_kunjungan.tgl_keluar', $tanggal);
        }

        if($unit && !empty($unit))
        {
            $query->where('ts_kunjungan.kode_unit', $unit);
        }

        if(empty($tanggal) && empty($tanggal)){
            $query->whereDate('ts_kunjungan.tgl_keluar', now());
        }

        $kunjungan = $query->get();

        return view('simrs.igd.pasienigd.export.pasien_pulang', compact('kunjungan'));
    }
}
