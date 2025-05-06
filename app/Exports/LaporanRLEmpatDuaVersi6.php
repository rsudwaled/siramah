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
        $kunjungan = Kunjungan::select('kode_kunjungan', 'counter', 'no_rm', 'tgl_masuk', 'tgl_keluar', 'status_kunjungan', 'diagx', 'id_alasan_pulang')
            ->with([
                'laporanDiagnosa',
                'pasien:no_rm,jenis_kelamin,tgl_lahir'
            ])
            ->whereDate('tgl_masuk', '>=', $first)
            ->whereDate('tgl_keluar', '<=', $last)
            ->whereNotIn('status_kunjungan', ['1', '8', '9', '11'])
            ->get();

        $data = $kunjungan->map(function ($item) {
            $tglLahir = $item->pasien->tgl_lahir ?? null;
            $umurHari = $tglLahir ? Carbon::parse($tglLahir)->diffInDays(Carbon::now()) : null;

            $tglMasuk = Carbon::parse($item->tgl_masuk);
            $tglKeluar = Carbon::parse($item->tgl_keluar);
            $selisih = $tglMasuk->diff($tglKeluar);

            $kelompok_final = null;
            if ($umurHari !== null) {
                if ($umurHari < 180) {
                    if ($selisih->h < 1) {
                        $kelompok_final = 'Kurang dari 1 jam';
                    } elseif ($selisih->h <= 23) {
                        $kelompok_final = '1 menit - 23 jam';
                    } elseif ($selisih->d <= 7) {
                        $kelompok_final = '1-7 hari';
                    } elseif ($selisih->d <= 28) {
                        $kelompok_final = '8-28 hari';
                    } elseif ($selisih->d < 90) {
                        $kelompok_final = '29 hari-3 bulan';
                    } elseif ($selisih->m < 6) {
                        $kelompok_final = '3-6 bulan';
                    }
                } elseif ($umurHari >= 180 && $umurHari < 365) {
                    $kelompok_final = '6-11 bulan';
                } elseif ($umurHari >= 365 && $umurHari <= 1824) {
                    $kelompok_final = '1-4 tahun';
                } elseif ($umurHari <= 3284) {
                    $kelompok_final = '5-9 tahun';
                } elseif ($umurHari <= 5114) {
                    $kelompok_final = '10-14 tahun';
                } elseif ($umurHari <= 6934) {
                    $kelompok_final = '15-19 tahun';
                } elseif ($umurHari <= 8759) {
                    $kelompok_final = '20-24 tahun';
                } elseif ($umurHari <= 10585) {
                    $kelompok_final = '25-29 tahun';
                } elseif ($umurHari <= 12410) {
                    $kelompok_final = '30-34 tahun';
                } elseif ($umurHari <= 14235) {
                    $kelompok_final = '35-39 tahun';
                } elseif ($umurHari <= 16060) {
                    $kelompok_final = '40-44 tahun';
                } elseif ($umurHari <= 17885) {
                    $kelompok_final = '45-49 tahun';
                } elseif ($umurHari <= 19710) {
                    $kelompok_final = '50-54 tahun';
                } elseif ($umurHari <= 21535) {
                    $kelompok_final = '55-59 tahun';
                } elseif ($umurHari <= 23360) {
                    $kelompok_final = '60-64 tahun';
                } elseif ($umurHari <= 25185) {
                    $kelompok_final = '65-69 tahun';
                } elseif ($umurHari <= 27010) {
                    $kelompok_final = '70-74 tahun';
                } elseif ($umurHari <= 28835) {
                    $kelompok_final = '75-79 tahun';
                } elseif ($umurHari <= 30660) {
                    $kelompok_final = '80-84 tahun';
                } else {
                    $kelompok_final = '85+ tahun';
                }
            }

            $diagnosa = $item->laporanDiagnosa[0] ?? null;

            return [
                'kode_kunjungan' => $item->kode_kunjungan,
                'no_rm' => $item->no_rm,
                'kelompok_final' => $kelompok_final,
                'counter' => $item->counter,
                'status_kunjungan' => $item->status_kunjungan,
                'diagx' => $item->diagx,
                'diag_utama' => $diagnosa->diag_utama ?? null,
                'diag_utama_desc' => $diagnosa->diag_utama_desc ?? null,
                'id_alasan_pulang' => $item->id_alasan_pulang ?? null,
                'status_keluar' => in_array($item->id_alasan_pulang, [6, 7, 14]) ? 'Meninggal' : 'Hidup',
                'pasien' => [
                    'jenis_kelamin' => $item->pasien->jenis_kelamin ?? null,
                ],
            ];
        });

        $dataGabungan = [];

        foreach ($data as $item) {
            $diag = $item['diag_utama'] ?? 'Tidak Diketahui';
            $desc = $item['diag_utama_desc'] ?? '-';
            $jk = $item['pasien']['jenis_kelamin'] ?? null;
            $kel = $item['kelompok_final'] ?? null;
            $statusKeluar = $item['status_keluar'] ?? 'Hidup';

            if (!isset($dataGabungan[$diag])) {
                $dataGabungan[$diag] = [
                    'diag_utama_desc' => $desc,
                    'rekap' => [],
                    'rekap_status' => [
                        'Hidup' => ['L' => 0, 'P' => 0],
                        'Meninggal' => ['L' => 0, 'P' => 0],
                    ],
                ];
            }

            // Rekap berdasarkan kelompok umur
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


        $sortedData = collect($dataGabungan)->sortByDesc(function ($item) {
            return ($item['rekap_status']['Hidup']['L'] ?? 0) + ($item['rekap_status']['Hidup']['P'] ?? 0);
        })->toArray();

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
