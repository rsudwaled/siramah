<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Kunjungan;
use Carbon\Carbon;

class LaporanRLLimaSatuVersi6 implements FromView
{
    public function view(): View
    {
        $first = request()->input('dari');
        $last  = request()->input('sampai');

        $kunjungans = [];
        if ($first && $last) {
            $kunjungans = Kunjungan::select(
                'kode_kunjungan',
                'counter',
                'no_rm',
                'tgl_masuk',
                'tgl_keluar',
                'kode_unit',
                'prefix_kunjungan',
                'status_kunjungan',
                'diagx',
                'id_alasan_pulang'
            )
            ->with([
                'pasien:no_rm,nama_px,jenis_kelamin,tgl_lahir',
                'laporanDiagnosa:kode_kunjungan,no_rm,nama_unit,counter,diag_utama,diag_utama_desc,kunjungan_baru,kasus_baru,tgl_masuk_kunjungan,tgl_keluar_kunjungan'
            ])
            ->where('kode_unit','Like', '%10%')
            ->where('tgl_masuk', '>=', $first)
            ->where('tgl_masuk','<=', $last)
            ->whereIn('status_kunjungan', [2, 3])
            ->get();

            $rekap = [];

            foreach ($kunjungans as $kunjungan) {
                $pasien = $kunjungan->pasien;
                $laporan = $kunjungan->laporanDiagnosa->first();

                if (!$pasien || !$laporan) continue;

                // Ambil tanggal lahir & masuk
                $tglLahir = Carbon::parse($pasien->tgl_lahir);
                $tglMasuk = Carbon::parse($kunjungan->tgl_masuk);
                $umurHari = $tglLahir->diffInDays($tglMasuk);

                // Ambil tanggal keluar dari laporanDiagnosa atau fallback ke sekarang
                $tglKeluar = $laporan->tgl_keluar_kunjungan
                    ? Carbon::parse($laporan->tgl_keluar_kunjungan)
                    : Carbon::now();

                $selisih = $tglMasuk->diff($tglKeluar);

                // Kelompok umur
                $kelompok_umur = null;
                if ($umurHari < 180) {
                    if ($selisih->h < 1) $kelompok_umur = 'Kurang dari 1 jam';
                    elseif ($selisih->h <= 23) $kelompok_umur = '1 menit - 23 jam';
                    elseif ($selisih->d <= 7) $kelompok_umur = '1-7 hari';
                    elseif ($selisih->d <= 28) $kelompok_umur = '8-28 hari';
                    elseif ($selisih->d < 90) $kelompok_umur = '29 hari-3 bulan';
                    elseif ($selisih->m < 6) $kelompok_umur = '3-6 bulan';
                } elseif ($umurHari < 365) {
                    $kelompok_umur = '6-11 bulan';
                } elseif ($umurHari <= 1824) {
                    $kelompok_umur = '1-4 tahun';
                } elseif ($umurHari <= 3284) {
                    $kelompok_umur = '5-9 tahun';
                } elseif ($umurHari <= 5114) {
                    $kelompok_umur = '10-14 tahun';
                } elseif ($umurHari <= 6934) {
                    $kelompok_umur = '15-19 tahun';
                } elseif ($umurHari <= 8759) {
                    $kelompok_umur = '20-24 tahun';
                } elseif ($umurHari <= 10585) {
                    $kelompok_umur = '25-29 tahun';
                } elseif ($umurHari <= 12410) {
                    $kelompok_umur = '30-34 tahun';
                } elseif ($umurHari <= 14235) {
                    $kelompok_umur = '35-39 tahun';
                } elseif ($umurHari <= 16060) {
                    $kelompok_umur = '40-44 tahun';
                } elseif ($umurHari <= 17885) {
                    $kelompok_umur = '45-49 tahun';
                } elseif ($umurHari <= 19710) {
                    $kelompok_umur = '50-54 tahun';
                } elseif ($umurHari <= 21535) {
                    $kelompok_umur = '55-59 tahun';
                } elseif ($umurHari <= 23360) {
                    $kelompok_umur = '60-64 tahun';
                } elseif ($umurHari <= 25185) {
                    $kelompok_umur = '65-69 tahun';
                } elseif ($umurHari <= 27010) {
                    $kelompok_umur = '70-74 tahun';
                } elseif ($umurHari <= 28835) {
                    $kelompok_umur = '75-79 tahun';
                } elseif ($umurHari <= 30660) {
                    $kelompok_umur = '80-84 tahun';
                } else {
                    $kelompok_umur = '85+ tahun';
                }

                // Kode diagnosa dan deskripsi
                $kode_diag = $laporan->diag_utama ?? 'Tidak Diketahui';
                $desc_diag = $laporan->diag_utama_desc ?? '-';
                $jenis_kelamin = strtoupper($pasien->jenis_kelamin ?? 'N/A');

                // Inisialisasi diagnosa jika belum ada
                if (!isset($rekap[$kode_diag])) {
                    $rekap[$kode_diag] = [
                        'deskripsi' => [],
                    ];
                }

                // Simpan deskripsi jika belum ada
                if (!in_array($desc_diag, $rekap[$kode_diag]['deskripsi'])) {
                    $rekap[$kode_diag]['deskripsi'][] = $desc_diag;
                }

                // Inisialisasi data berdasarkan jenis kelamin dan kelompok umur
                if (!isset($rekap[$kode_diag][$jenis_kelamin][$kelompok_umur])) {
                    $rekap[$kode_diag][$jenis_kelamin][$kelompok_umur] = [
                        'total_kunjungan_baru' => 0,
                        'total_kasus_baru' => 0,
                    ];
                }

                // ✅ Hitung total jika bernilai 1 (dengan casting agar lebih aman)
                if ((int) $laporan->kunjungan_baru === 1) {
                    $rekap[$kode_diag][$jenis_kelamin][$kelompok_umur]['total_kunjungan_baru']++;
                }

                if ((int) $laporan->kasus_baru === 1) {
                    $rekap[$kode_diag][$jenis_kelamin][$kelompok_umur]['total_kasus_baru']++;
                }
            }

        }
        $kelompokUmurList = [
            'Kurang 1 jam', '1 menit - 23 jam', '1-7 hari', '8-28 hari',
            '29 hari-3 bulan', '3-6 bulan', '6-11 bulan', '1-4 tahun', '5-9 tahun',
            '10-14 tahun', '15-19 tahun', '20-24 tahun', '25-29 tahun', '30-34 tahun',
            '35-39 tahun', '40-44 tahun', '45-49 tahun', '50-54 tahun', '55-59 tahun',
            '60-64 tahun', '65-69 tahun', '70-74 tahun', '75-79 tahun', '80-84 tahun', '85+ tahun'
        ];

        $rekap = collect($rekap)->sortByDesc(function ($data) {
            $totalL = array_sum(array_column($data['L'] ?? [], 'total_kasus_baru'));
            $totalP = array_sum(array_column($data['P'] ?? [], 'total_kasus_baru'));

            return $totalL + $totalP;
        })->toArray();


        // Tampilkan atau kirim ke view
        return view('export.laporan.laporan_rl_5_1_versi_6', [
        'kelompokUmurList' => $kelompokUmurList,
        'rekap' => $rekap,
        'start'=>$first,
        'end'=>$last,
        ]);

    }
}
