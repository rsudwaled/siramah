<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Kunjungan;
use Carbon\Carbon;

class LaporanRLEmpatDuaVersi6 implements FromView
{
    public function view(): View
    {
        $first = request()->input('dari');
        $last  = request()->input('sampai');

        // Ambil data kunjungan
        // Ambil data kunjungan
       $kunjungan = Kunjungan::select('kode_kunjungan', 'counter', 'no_rm', 'tgl_masuk', 'tgl_keluar', 'status_kunjungan', 'diagx', 'id_alasan_pulang')
       ->with([
           'laporanDiagnosa',
           'pasien:no_rm,jenis_kelamin,tgl_lahir'
       ])
       ->where('kode_unit','Like', '%20%')
       ->whereDate('tgl_masuk', '>=', $first)
       ->whereDate('tgl_keluar', '<=', $last)
       ->whereNotIn('status_kunjungan', ['1', '8', '9', '11'])
       ->get();

       // Mapping data mentah
       $data = $kunjungan->map(function ($item) {
       $diagnosa = $item->laporanDiagnosa[0] ?? null;

       return [
           'kode_kunjungan'        => $item->kode_kunjungan,
           'no_rm'                 => $item->no_rm,
           'counter'               => $item->counter,
           'status_kunjungan'      => $item->status_kunjungan,
           'diagx'                 => $item->diagx,
           'diag_utama'            => $diagnosa->diag_utama ?? 'Tidak Diketahui',
           'diag_utama_desc'       => $diagnosa->diag_utama_desc ?? '-',
           'id_alasan_pulang'      => $item->id_alasan_pulang ?? null,
           'status_keluar'         => in_array($item->id_alasan_pulang, [6, 7, 14]) ? 'Meninggal' : 'Hidup',
           'pasien' => [
               'jenis_kelamin' => $item->pasien->jenis_kelamin ?? null,
           ],
       ];
       });

       // Filter agar hanya data dengan diagnosa kematian yang valid
       $data = $data->filter(function ($item) {
       return !empty($item['diag_utama']) && $item['diag_utama'] !== 'Tidak Diketahui';
       });

       // Proses rekap data gabungan berdasarkan 3 digit pertama kode diagnosa
       $dataGabungan = [];

       foreach ($data as $item) {
       $kodePenuh  = $item['diag_utama'];
       $diag       = substr($kodePenuh, 0, 3); // Ambil 3 karakter pertama
       $desc       = $item['diag_utama_desc'] ?? '-';
       $jk         = $item['pasien']['jenis_kelamin'] ?? null;
       $kel        = $item['kelompok_final'] ?? null; // <- Pastikan tersedia jika digunakan
       $statusKeluar = $item['status_keluar'] ?? 'Hidup';

       if (!isset($dataGabungan[$diag])) {
           $dataGabungan[$diag] = [
               'diag_utama_desc' => "Kelompok Diagnosa $diag", // Bisa juga ganti dengan deskripsi lain
               'rekap' => [],
               'rekap_status' => [
                   'Hidup' => ['L' => 0, 'P' => 0],
                   'Meninggal' => ['L' => 0, 'P' => 0],
               ],
           ];
       }

       // Rekap berdasarkan kelompok umur (jika tersedia)
       if ($jk && $kel) {
           if (!isset($dataGabungan[$diag]['rekap'][$kel])) {
               $dataGabungan[$diag]['rekap'][$kel] = ['L' => 0, 'P' => 0];
           }
           $dataGabungan[$diag]['rekap'][$kel][$jk]++;
       }

       // Rekap berdasarkan status keluar
       if ($jk && in_array($statusKeluar, ['Hidup', 'Meninggal'])) {
           $dataGabungan[$diag]['rekap_status'][$statusKeluar][$jk]++;
       }
       }

       // Urutkan berdasarkan jumlah pasien meninggal terbanyak
       $sortedData = collect($dataGabungan)
        ->sortByDesc(function ($item) {
            return ($item['rekap_status']['Hidup']['L'] ?? 0) + ($item['rekap_status']['Hidup']['P'] ?? 0);
        })
        ->take(30) // ⬅️ Ambil hanya 10 data teratas
        ->toArray();
        // dd( $dataGabungan, $sortedData);
        // Tampilkan atau kirim ke view
        return view('export.laporan.laporan_rl_4_2_versi_6', [
        'dataGabungan' => $dataGabungan,
        'sortedData' => $sortedData,
        'start' => $first,
        'end' => $last
        ]);

    }
}
