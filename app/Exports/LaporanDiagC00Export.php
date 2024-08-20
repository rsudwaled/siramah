<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanDiagC00Export implements FromView
{
    public function view():View
    {
        $tahun      = request()->input('tahun') ;
        $jenis      = request()->input('jenis');

        $query = \DB::connection('mysql2')->table('ts_kunjungan')
                ->join('mt_pasien', 'ts_kunjungan.no_rm', '=', 'mt_pasien.no_rm')
                ->join('mt_agama', 'mt_pasien.agama', '=', 'mt_agama.ID')
                ->join('mt_pekerjaan', 'mt_pasien.pekerjaan', '=', 'mt_pekerjaan.ID')
                ->join('di_pasien_diagnosa', 'ts_kunjungan.kode_kunjungan', '=', 'di_pasien_diagnosa.kode_kunjungan')
                ->join('mt_unit', 'ts_kunjungan.kode_unit', '=', 'mt_unit.kode_unit')
                ->leftJoin('mt_lokasi_villages as desa', 'mt_pasien.desa', '=', 'desa.id')
                ->leftJoin('mt_lokasi_districts as kecamatan', 'mt_pasien.kecamatan', '=', 'kecamatan.id')
                ->leftJoin('mt_lokasi_regencies as kabupaten', 'mt_pasien.kabupaten', '=', 'kabupaten.id')
                ->leftJoin('mt_lokasi_provinces as provinsi', 'mt_pasien.propinsi', '=', 'provinsi.id')
                ->leftJoin('mt_lokasi_villages as desa_second', 'mt_pasien.kode_desa', '=', 'desa_second.id')
                ->leftJoin('mt_lokasi_districts as kecamatan_second', 'mt_pasien.kode_kecamatan', '=', 'kecamatan_second.id')
                ->leftJoin('mt_lokasi_regencies as kabupaten_second', 'mt_pasien.kode_kabupaten', '=', 'kabupaten_second.id')
                ->leftJoin('mt_lokasi_provinces as provinsi_second', 'mt_pasien.kode_propinsi', '=', 'provinsi_second.id')
                ->select(
                    'ts_kunjungan.*',
                    'mt_pasien.*',
                    'mt_agama.*',
                    'mt_pekerjaan.*',
                    'di_pasien_diagnosa.*',
                    'mt_unit.*',
                    \DB::raw('COALESCE(desa.name, desa_second.name) as desa_name'),
                    \DB::raw('COALESCE(kecamatan.name, kecamatan_second.name) as kecamatan_name'),
                    \DB::raw('COALESCE(kabupaten.name, kabupaten_second.name) as kabupaten_name'),
                    \DB::raw('COALESCE(provinsi.name, provinsi_second.name) as provinsi_name')
                )
                ->whereBetween('di_pasien_diagnosa.diag_utama', ['C00', 'C99'])
                ->where('ts_kunjungan.status_kunjungan','!=', 8)
                ->where('ts_kunjungan.status_kunjungan','!=', 11)
                ->where('di_pasien_diagnosa.kasus_baru', 1);
        if(!empty($tahun) && !empty($jenis))
        {
            if($jenis=='rajal')
            {
                $pasiens = $query->whereYear('ts_kunjungan.tgl_masuk', $tahun)->selectRaw("CONCAT_WS(' | ',
                    CONCAT(di_pasien_diagnosa.diag_sekunder_01, ' - ', di_pasien_diagnosa.diag_sekunder1_desc),
                    CONCAT(di_pasien_diagnosa.diag_sekunder_02, ' - ', di_pasien_diagnosa.diag_sekunder2_desc),
                    CONCAT(di_pasien_diagnosa.diag_sekunder_03, ' - ', di_pasien_diagnosa.diag_sekunder3_desc),
                    CONCAT(di_pasien_diagnosa.diag_sekunder_04, ' - ', di_pasien_diagnosa.diag_sekunder4_desc),
                    CONCAT(di_pasien_diagnosa.diag_sekunder_07, ' - ', di_pasien_diagnosa.diag_sekunder7_desc),
                    CONCAT(di_pasien_diagnosa.diag_sekunder_08, ' - ', di_pasien_diagnosa.diag_sekunder8_desc),
                    CONCAT(di_pasien_diagnosa.diag_sekunder_09, ' - ', di_pasien_diagnosa.diag_sekunder9_desc)
                    ) as diagnosa_sekunder")->get();
            }else{
                $pasiens = $query->whereYear('ts_kunjungan.tgl_keluar', $tahun)->selectRaw("CONCAT_WS(' | ',
                    CONCAT(di_pasien_diagnosa.diag_sekunder_01, ' - ', di_pasien_diagnosa.diag_sekunder1_desc),
                    CONCAT(di_pasien_diagnosa.diag_sekunder_02, ' - ', di_pasien_diagnosa.diag_sekunder2_desc),
                    CONCAT(di_pasien_diagnosa.diag_sekunder_03, ' - ', di_pasien_diagnosa.diag_sekunder3_desc),
                    CONCAT(di_pasien_diagnosa.diag_sekunder_07, ' - ', di_pasien_diagnosa.diag_sekunder7_desc),
                    CONCAT(di_pasien_diagnosa.diag_sekunder_08, ' - ', di_pasien_diagnosa.diag_sekunder8_desc),
                    CONCAT(di_pasien_diagnosa.diag_sekunder_09, ' - ', di_pasien_diagnosa.diag_sekunder9_desc)
                    ) as diagnosa_sekunder")->get();
            }
        }else{
            $pasiens = [];
        }
        // $pasiens = collect($pasiens);
        // dd($pasiens);
        return view('export.laporan.lap_diagnosa_c00', compact('pasiens'));
    }
}
