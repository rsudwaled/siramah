<?php

namespace App\Http\Controllers\LaporanIndex;

use App\Exports\LaporanIndexDokterExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paramedis;
use App\Models\Pasien;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use DB;

class IndexDokterController extends Controller
{
    public function getAgeGroup($tanggalLahir, $jenisKelamin)
    {
        // Menggunakan tanggal hari ini untuk menghitung umur
        $dateOfBirth = Carbon::parse($tanggalLahir);
        $today = Carbon::today(); // Mengambil tanggal hari ini
        $umur = $today->diffInYears($dateOfBirth); // Menghitung umur dalam tahun

        // Menghitung umur dalam bulan dan hari jika umur kurang dari 1 tahun
        $umurBulan = $today->diffInMonths($dateOfBirth);
        $umurHari = $today->diffInDays($dateOfBirth);

        // Menentukan grup umur berdasarkan kategori yang ada
        if ($umurHari <= 28) {
            return $jenisKelamin == 'L' ? '0_28HL' : '0_28HP';
        } elseif ($umur < 1) {
            return $jenisKelamin == 'L' ? 'kurang_1TL' : 'kurang_1TP';
        } elseif ($umur >= 1 && $umur < 5) {  // Update untuk kategori 1-5 Tahun
            return $jenisKelamin == 'L' ? '1_5TL' : '1_5TP';
        } elseif ($umur >= 5 && $umur < 15) {  // Update untuk kategori 5-14 Tahun
            return $jenisKelamin == 'L' ? '5_14TL' : '5_14TP';
        } elseif ($umur >= 15 && $umur < 25) {  // Update untuk kategori 5-14 Tahun
            return $jenisKelamin == 'L' ? '15_24TL' : '15_24TP';
        } elseif ($umur >= 25 && $umur <= 44) {
            return $jenisKelamin == 'L' ? '25_44TL' : '25_44TP';
        } elseif ($umur >= 45 && $umur <= 64) {
            return $jenisKelamin == 'L' ? '45_64TL' : '45_64TP';
        } else {
            return $jenisKelamin == 'L' ? 'lebih_65TL' : 'lebih_65TP';
        }
    }


    public function index(Request $request)
    {
        // Mendapatkan tanggal mulai dan selesai
        $from           = $request->dari == null ? now()->format('Y-m-d') : $request->dari;
        $to             = $request->selesai == null ? now()->format('Y-m-d') : $request->selesai;
        $tahunMulai     = $request->dari == null ? now()->format('Y') : Carbon::parse($request->dari)->format('Y');
        $tahunSelesai   = $request->selesai == null ? now()->format('Y'): Carbon::parse($request->selesai)->format('Y');

        $bulanMulai     = $request->dari == null ? now()->format('F') : Carbon::parse($request->dari)->format('F');
        $bulanSelesai   = $request->selesai == null ? now()->format('F'): Carbon::parse($request->selesai)->format('F');

        // Mendapatkan data paramedis
        $paramedis = Paramedis::get();

        // Mencari dokter berdasarkan kode paramedis
        $dokterFind = Paramedis::where('kode_paramedis', $request->kode_paramedis)->first();

        // Jika kode paramedis tidak ditemukan
        if (empty($dokterFind)) {
            Alert::warning('INFORMASI!', 'Kode paramedis tidak terdaftar');
        }

        $findReport = null;

        // Jika parameter tanggal dan dokter valid, maka ambil laporan
        if (!empty($from) && !empty($to) && !empty($dokterFind)) {
            // Mengambil data laporan dari stored procedure
            $findReport = \DB::connection('mysql2')->select("CALL `sp_laporan_kartu_indeks_dokter`('$request->kode_paramedis','$from','$to')");

            // Mengambil hanya nilai no_rm dari $findReport
            $no_rm_list = array_column($findReport, 'no_rm');

            // Mencari pasien berdasarkan no_rm
            $pasien = Pasien::whereIn('no_rm', $no_rm_list)->get();

            // Menggabungkan data pasien dengan data report dan mengelompokkan pasien berdasarkan kategori umur
            $findReport = collect($findReport)->map(function ($report) use ($pasien) {
                // Mencari pasien berdasarkan no_rm di data report
                $patient = $pasien->firstWhere('no_rm', $report->no_rm);

                // Jika pasien ditemukan, tambahkan informasi pasien ke data report
                if ($patient) {
                    $report->nama_px = $patient->nama_px;
                    $report->jenis_kelamin = $patient->jenis_kelamin;
                    $report->tgl_lahir = $patient->tgl_lahir;

                    // Menambahkan grup umur ke data report
                    $report->age_group = $this->getAgeGroup($patient->tgl_lahir, $patient->jenis_kelamin);
                }

                return $report;
            });
        }
        // Mengembalikan view dengan data yang telah diproses
        return view('simrs.laporanindex.index_dokter.index', compact('paramedis', 'findReport', 'from', 'to','request','tahunMulai','tahunSelesai','bulanMulai','bulanSelesai','dokterFind'));
    }

    public function export(Request $request)
    {
         // Ambil input dari request
         $start          = $request->input('dari');
         $finish         = $request->input('selesai');
         $dokter         = $request->input('kode_paramedis');
         $from           = $start == null ? now()->format('Y-m-d') : $start;
         $to             = $finish == null ? now()->format('Y-m-d') : $finish;
         $tahunMulai     = $start == null ? now()->format('Y') : Carbon::parse($start)->format('Y');
         $tahunSelesai   = $finish == null ? now()->format('Y') : Carbon::parse($finish)->format('Y');
         $bulanMulai     = $start == null ? now()->format('F') : Carbon::parse($start)->format('F');
         $bulanSelesai   = $finish == null ? now()->format('F') : Carbon::parse($finish)->format('F');

         // Cari dokter berdasarkan kode_paramedis
         $dokterFind = Paramedis::where('kode_paramedis', $dokter)->first();

         $findReport = null;
         if (!empty($from) && !empty($to) && !empty($dokterFind)) {
             // Mengambil data laporan dari stored procedure
             $findReport = \DB::connection('mysql2')->select("CALL `sp_laporan_kartu_indeks_dokter`('$dokter','$from','$to')");
             $no_rm_list = array_column($findReport, 'no_rm');

             // Ambil data pasien berdasarkan no_rm yang ada
             $pasien = Pasien::whereIn('no_rm', $no_rm_list)->get();

             // Pemetaan report untuk menambahkan informasi pasien dan grup umur
             $findReport = collect($findReport)->map(function ($report) use ($pasien) {
                 $patient = $pasien->firstWhere('no_rm', $report->no_rm);

                 if ($patient) {
                     $report->nama_px = $patient->nama_px;
                     $report->jenis_kelamin = $patient->jenis_kelamin;
                     $report->tgl_lahir = $patient->tgl_lahir;

                     // Menambahkan grup umur ke data report
                     $report->age_group = $this->getAgeGroup($patient->tgl_lahir, $patient->jenis_kelamin);
                 }
                 return $report;
             });
         }

         // Mendownload file Excel dengan data laporan
         return Excel::download(new LaporanIndexDokterExport($findReport, $dokterFind, $bulanSelesai, $tahunSelesai), 'laporan_index_dokter.xlsx');
    }



}
