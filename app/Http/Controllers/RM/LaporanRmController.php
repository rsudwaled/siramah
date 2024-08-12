<?php

namespace App\Http\Controllers\RM;

use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DiagnosaPenyakitExport;
use App\Exports\DiagnosaPenyakitRajalExport;
use App\Exports\LaporanDiagC00Export;

class LaporanRmController extends Controller
{
    public function laporanM80ToM82(Request $request)
    {
        $view = $request->view;
        if($view==='rawat_jalan' || $view === null)
        {
            $details = \DB::connection('mysql2')->table('ts_kunjungan')
            ->select('ts_kunjungan.*', 'mt_pasien.*', 'mt_unit.*')
            ->join('mt_pasien', 'ts_kunjungan.no_rm', '=', 'mt_pasien.no_rm')
            ->join('mt_unit', 'ts_kunjungan.kode_unit', '=', 'mt_unit.kode_unit')
            ->whereRaw("SUBSTRING_INDEX(ts_kunjungan.diagx, ' | ', 1) IN ('M80', 'M81', 'M82')")
            ->whereYear('ts_kunjungan.tgl_masuk', 2023)
            ->orderBy('ts_kunjungan.tgl_masuk','asc')
            ->get();

            $results = \DB::connection('mysql2')->table('ts_kunjungan')
            ->select(
                'ts_kunjungan.*', 'mt_pasien.*', 
                \DB::raw('COUNT(ts_kunjungan.no_rm) as total_kunjungan')
            )
            ->join('mt_pasien', 'ts_kunjungan.no_rm', '=', 'mt_pasien.no_rm')
            ->whereRaw("SUBSTRING_INDEX(ts_kunjungan.diagx, ' | ', 1) IN ('M80', 'M81', 'M82')")
            ->whereYear('ts_kunjungan.tgl_masuk', 2023)
            ->groupBy('ts_kunjungan.no_rm', 'mt_pasien.nama_px')
            ->orderBy('total_kunjungan', 'desc')
            ->get();

        }else{
            $results = \DB::connection('mysql2')->table('ts_kunjungan')
            ->select('ts_kunjungan.*', 'mt_pasien.*')
            ->join('mt_pasien', 'ts_kunjungan.no_rm', '=', 'mt_pasien.no_rm')
            ->whereRaw("SUBSTRING_INDEX(ts_kunjungan.diagx, ' | ', 1) IN ('M80', 'M81', 'M82')")
            ->whereYear('ts_kunjungan.tgl_keluar', 2023)
            ->orderBy('ts_kunjungan.tgl_keluar','asc')
            ->get();

            $details = \DB::connection('mysql2')->table('ts_kunjungan')
            ->select('ts_kunjungan.*', 'mt_pasien.*', 'mt_unit.*')
            ->join('mt_pasien', 'ts_kunjungan.no_rm', '=', 'mt_pasien.no_rm')
            ->join('mt_unit', 'ts_kunjungan.kode_unit', '=', 'mt_unit.kode_unit')
            ->whereRaw("SUBSTRING_INDEX(ts_kunjungan.diagx, ' | ', 1) IN ('M80', 'M81', 'M82')")
            ->whereYear('ts_kunjungan.tgl_keluar', 2023)
            ->orderBy('ts_kunjungan.tgl_keluar','asc')
            ->get();
        }
        
        return view('simrs.rekammedis.diagnosa-m80-m82.index',compact('results','details'));
    }

    public function exportExcel(Request $request)
    {
        if($request->first == null && $request->last == null )
        {
            Alert::error('EXPORT ERROR!', 'untuk export data, dimohon untuk memilih data umur terlebih dahulu.');
            return back();
        }
        $range_umur = $request->data_umur;
        $umur       = null; 
        if($range_umur =='k1') 
        {
            $umur = 'Kurang_Dari_1_Tahun';
        }
        elseif($range_umur =='umr1_4')
        {
            $umur = 'umur_1_sampai_4_Tahun';
        }
        elseif($range_umur =='umr5_14')
        {
            $umur = 'umur_5_sampai_14_Tahun';
        }
        elseif($range_umur =='umr15_44')
        {
            $umur = 'umur_15_sampai_44_Tahun';
        }
        elseif($range_umur =='umr45_75lb')
        {
            $umur = 'umur_45_sampai_lebih_dari_75_Tahun';
        }
        else
        {
            $umur = 'semua_umur';
        }
        $namaFile = 'Laporan_Diagnosa_Pola_Penyakit_Ranap'.$request->first.'_s.d_'.$request->last.'_'.$umur.'.xlsx';
        return Excel::download(new DiagnosaPenyakitExport($request), $namaFile);
    }
    public function exportExcelRajal(Request $request)
    {
        if($request->first == null && $request->last == null )
        {
            Alert::error('EXPORT ERROR!', 'untuk export data, dimohon untuk memilih data umur terlebih dahulu.');
            return back();
        }
        $range_umur = $request->data_umur;
        $umur       = null; 
        if($range_umur =='k1') 
        {
            $umur = 'Kurang_Dari_1_Tahun';
        }
        elseif($range_umur =='umr1_4')
        {
            $umur = 'umur_1_sampai_4_Tahun';
        }
        elseif($range_umur =='umr5_14')
        {
            $umur = 'umur_5_sampai_14_Tahun';
        }
        elseif($range_umur =='umr15_44')
        {
            $umur = 'umur_15_sampai_44_Tahun';
        }
        elseif($range_umur =='umr45_75lb')
        {
            $umur = 'umur_45_sampai_lebih_dari_75_Tahun';
        }
        else
        {
            $umur = 'semua_umur';
        }
        $namaFile = 'Laporan_Diagnosa_Pola_Penyakit_Rajal'.$request->first.'_s.d_'.$request->last.'_'.$umur.'.xlsx';
        return Excel::download(new DiagnosaPenyakitRajalExport($request), $namaFile);
    }


    public function laporanc00(Request $request)
    {
        // status kunjungan != 8 dan 11
        // rajal -> tgl_masuk
        // ranap -> tgl_keluar
        // Ambil data pasien dengan kode diagnosa C00 - C99 dan periode waktu 2018-2022
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
        if(!empty($request->tahun) && !empty($request->jenis))
        {
            if($request->jenis=='rajal')
            {
                $pasiens = $query->whereYear('ts_kunjungan.tgl_masuk', $request->tahun)->selectRaw("CONCAT_WS(' | ',
                    CONCAT(di_pasien_diagnosa.diag_sekunder_01, ' - ', di_pasien_diagnosa.diag_sekunder1_desc),
                    CONCAT(di_pasien_diagnosa.diag_sekunder_02, ' - ', di_pasien_diagnosa.diag_sekunder2_desc),
                    CONCAT(di_pasien_diagnosa.diag_sekunder_03, ' - ', di_pasien_diagnosa.diag_sekunder3_desc),
                    CONCAT(di_pasien_diagnosa.diag_sekunder_04, ' - ', di_pasien_diagnosa.diag_sekunder4_desc),
                    CONCAT(di_pasien_diagnosa.diag_sekunder_07, ' - ', di_pasien_diagnosa.diag_sekunder7_desc),
                    CONCAT(di_pasien_diagnosa.diag_sekunder_08, ' - ', di_pasien_diagnosa.diag_sekunder8_desc),
                    CONCAT(di_pasien_diagnosa.diag_sekunder_09, ' - ', di_pasien_diagnosa.diag_sekunder9_desc)
                    ) as diagnosa_sekunder")->get();
            }else{
                $pasiens = $query->whereYear('ts_kunjungan.tgl_keluar', $request->tahun)->selectRaw("CONCAT_WS(' | ',
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
    //    dd($pasiens);
        return view('simrs.rekammedis.diagnosa-c00.index', compact('pasiens','request'));
    }

    public function laporanc00Export(Request $request)
    {
        if($request->tahun == null && $request->jenis)
        {
            Alert::error('EXPORT ERROR!', 'untuk export data, dimohon untuk memilih data filter terlebih dahulu.');
            return back();
        }

        $nama = 'LaporanDiagnosa_C00_'.$request->tahun.'_jenis_'.$request->jenis.'.xlsx';
        return Excel::download(new LaporanDiagC00Export($request), $nama);

    }

}
