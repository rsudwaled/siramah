<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Exports\LaporanRLLimaSatuVersi6;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
class FormulirRL5Controller extends Controller
{
    public function FormulirRL5_1Versi6(Request $request)
    {
        $from = $request->dari;
        $to = $request->sampai;
        $totalKunjunganBaru = 0;
        $totalKasusBaru = 0;
        $kunjungans = [];
        $rekap = [];
        if ($from && $to) {
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
            ->where('tgl_masuk', '>=', $from)
            ->where('tgl_masuk','<=', $to)
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
        // dd( $rekap, $rekap['M19'], $rekap['B15.0'], $rekap['R47.0']);
        // dd( $rekap['O69.4']);
        return view('simrs.formulir.f_r_l_5.formulir_rl_5_1', compact('request','from','to','kelompokUmurList','rekap'));
    }

    public function FormulirRL5_1Export(Request $request)
    {
        if($request->dari == null && $request->sampai == null )
        {
            Alert::error('EXPORT ERROR!', 'untuk export data, dimohon untuk memilih data umur terlebih dahulu.');
            return back();
        }

        $namaFile = 'Laporan Rl 5.1 Versi 6.xlsx';
        return Excel::download(new LaporanRLLimaSatuVersi6($request), $namaFile);
    }

    public function FormulirRL5_2Versi6(Request $request)
    {
        $from = $request->dari;
        $to = $request->sampai;

        $rekap = [];

        if ($from && $to) {
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
            ->where('kode_unit', 'like', '%10%')
            ->whereBetween('tgl_masuk', [$from, $to])
            ->whereIn('status_kunjungan', [2, 3])
            ->get();

            foreach ($kunjungans as $kunjungan) {
                $pasien = $kunjungan->pasien;
                $laporan = $kunjungan->laporanDiagnosa->first();

                if (!$pasien || !$laporan) continue;

                $tglLahir = Carbon::parse($pasien->tgl_lahir);
                $tglMasuk = Carbon::parse($kunjungan->tgl_masuk);
                $umurHari = $tglLahir->diffInDays($tglMasuk);

                $tglKeluar = $laporan->tgl_keluar_kunjungan
                    ? Carbon::parse($laporan->tgl_keluar_kunjungan)
                    : Carbon::now();

                $selisih = $tglMasuk->diff($tglKeluar);

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

                $kode_diag = $laporan->diag_utama ?? 'Tidak Diketahui';
                $desc_diag = $laporan->diag_utama_desc ?? '-';
                $jenis_kelamin = strtoupper($pasien->jenis_kelamin ?? 'N/A');

                if (!isset($rekap[$kode_diag])) {
                    $rekap[$kode_diag] = [
                        'deskripsi' => [],
                    ];
                }

                if (!in_array($desc_diag, $rekap[$kode_diag]['deskripsi'])) {
                    $rekap[$kode_diag]['deskripsi'][] = $desc_diag;
                }

                if (!isset($rekap[$kode_diag][$jenis_kelamin][$kelompok_umur])) {
                    $rekap[$kode_diag][$jenis_kelamin][$kelompok_umur] = [
                        'total_kunjungan_baru' => 0,
                        'total_kasus_baru' => 0,
                    ];
                }

                if ((int) $laporan->kunjungan_baru === 1) {
                    $rekap[$kode_diag][$jenis_kelamin][$kelompok_umur]['total_kunjungan_baru']++;
                }

                if ((int) $laporan->kasus_baru === 1) {
                    $rekap[$kode_diag][$jenis_kelamin][$kelompok_umur]['total_kasus_baru']++;
                }
            }

            // 🔽 Ambil 10 besar berdasarkan total kasus baru
            $rekap_dengan_total = [];

            foreach ($rekap as $kode_diag => $data) {
                $total_kasus = 0;

                foreach (['L', 'P'] as $jk) {
                    if (!isset($data[$jk])) continue;

                    foreach ($data[$jk] as $umur => $nilai) {
                        $total_kasus += $nilai['total_kasus_baru'];
                    }
                }

                $rekap_dengan_total[] = [
                    'kode_diag' => $kode_diag,
                    'data' => $data,
                    'total_kasus' => $total_kasus
                ];
            }

            usort($rekap_dengan_total, function ($a, $b) {
                return $b['total_kasus'] <=> $a['total_kasus'];
            });

            $top10_rekap = array_slice($rekap_dengan_total, 0, 10);

            $rekap = [];
            foreach ($top10_rekap as $item) {
                $rekap[$item['kode_diag']] = $item['data'];
            }
        }

        return view('simrs.formulir.f_r_l_5.formulir_rl_5_2', compact('rekap', 'from', 'to','request'));
    }

    public function FormulirRL5_3Versi6(Request $request)
    {
        $from = $request->dari;
        $to = $request->sampai;
        $rekap = [];

        if ($from && $to) {
            $kunjungans = Kunjungan::select(
                'kode_kunjungan', 'counter', 'no_rm', 'tgl_masuk', 'tgl_keluar',
                'kode_unit', 'prefix_kunjungan', 'status_kunjungan', 'diagx', 'id_alasan_pulang'
            )
            ->with([
                'pasien:no_rm,nama_px,jenis_kelamin,tgl_lahir',
                'laporanDiagnosa:kode_kunjungan,no_rm,nama_unit,counter,diag_utama,diag_utama_desc,kunjungan_baru,kasus_baru,tgl_masuk_kunjungan,tgl_keluar_kunjungan'
            ])
            ->where('kode_unit', 'like', '%10%')
            ->whereBetween('tgl_masuk', [$from, $to])
            ->whereIn('status_kunjungan', [2, 3])
            ->get();

            foreach ($kunjungans as $kunjungan) {
                $pasien = $kunjungan->pasien;
                $laporan = $kunjungan->laporanDiagnosa->first();
                if (!$pasien || !$laporan) continue;

                $tglLahir = Carbon::parse($pasien->tgl_lahir);
                $tglMasuk = Carbon::parse($kunjungan->tgl_masuk);
                $umurHari = $tglLahir->diffInDays($tglMasuk);
                $tglKeluar = $laporan->tgl_keluar_kunjungan
                    ? Carbon::parse($laporan->tgl_keluar_kunjungan)
                    : Carbon::now();
                $selisih = $tglMasuk->diff($tglKeluar);

                // Penentuan kelompok umur
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

                $kode_diag = $laporan->diag_utama ?? 'Tidak Diketahui';
                $desc_diag = $laporan->diag_utama_desc ?? '-';
                $jenis_kelamin = strtoupper($pasien->jenis_kelamin ?? 'N/A');

                if (!isset($rekap[$kode_diag])) {
                    $rekap[$kode_diag] = ['deskripsi' => []];
                }

                if (!in_array($desc_diag, $rekap[$kode_diag]['deskripsi'])) {
                    $rekap[$kode_diag]['deskripsi'][] = $desc_diag;
                }

                if (!isset($rekap[$kode_diag][$jenis_kelamin][$kelompok_umur])) {
                    $rekap[$kode_diag][$jenis_kelamin][$kelompok_umur] = [
                        'total_kunjungan_baru' => 0,
                        'total_kasus_baru' => 0,
                    ];
                }

                if ((int) $laporan->kunjungan_baru === 1) {
                    $rekap[$kode_diag][$jenis_kelamin][$kelompok_umur]['total_kunjungan_baru']++;
                }

                if ((int) $laporan->kasus_baru === 1) {
                    $rekap[$kode_diag][$jenis_kelamin][$kelompok_umur]['total_kasus_baru']++;
                }
            }

            // Ambil 10 besar berdasarkan total kunjungan baru
            $rekap_dengan_total = [];

            foreach ($rekap as $kode_diag => $data) {
                $total_kunjungan = 0;

                foreach (['L', 'P'] as $jk) {
                    if (!isset($data[$jk])) continue;

                    foreach ($data[$jk] as $umur => $nilai) {
                        $total_kunjungan += $nilai['total_kunjungan_baru'];
                    }
                }

                $rekap_dengan_total[] = [
                    'kode_diag' => $kode_diag,
                    'data' => $data,
                    'total_kunjungan' => $total_kunjungan
                ];
            }

            // Urutkan dari terbesar ke terkecil berdasarkan total kunjungan
            usort($rekap_dengan_total, function ($a, $b) {
                return $b['total_kunjungan'] <=> $a['total_kunjungan'];
            });

            $top10_rekap = array_slice($rekap_dengan_total, 0, 10);

            $rekap = [];
            foreach ($top10_rekap as $item) {
                $rekap[$item['kode_diag']] = $item['data'];
            }
        }

        return view('simrs.formulir.f_r_l_5.formulir_rl_5_3', compact('rekap', 'from', 'to', 'request'));
    }

    public function FormulirRL5_3P(Request $request)
    {
        // dd($request->all());
        $from = $request->dari;
        $to = $request->sampai;
        $jml = $request->jumlah;
        $p1 = Carbon::parse($from);
        $p2 = Carbon::parse($to);
        $th1 = $p1->year;
        $th2 = $p2->year;
        if ($th1 == $th2) {
            $th = $th2;
        } else {
            $th = $th1 . '-' . $th2;
        }
        $unit = \DB::connection('mysql2')->select("CALL `sp_MASTER_UNIT`('','')");
        $kode_unit = $request->unit;

        if ($kode_unit) {
            $laporanFM = \DB::connection('mysql2')->select("CALL `SP_LAPORAN_DIAGNOSA_PENYAKIT_TERBANYAK_RANAP_PERUNIT`('$from','$to','$kode_unit','$jml')");
            $laporanFM = collect($laporanFM);
            return view('simrs.formulir.f_r_l_5.formulir_rl_5_3unit', compact('laporanFM', 'from', 'to', 'request', 'jml', 'kode_unit', 'unit', 'th'));
        } else {
            $laporanFM = \DB::connection('mysql2')->select("CALL `sp_LAPORAN_DIAGNOSA_PENYAKIT_TERBANYAK_RANAP`('$from','$to','$jml')");
            $laporanFM = collect($laporanFM);
        }
        return view('simrs.formulir.f_r_l_5.formulir_rl_5_3data', compact('laporanFM', 'from', 'to', 'request', 'jml','th'));
    }

    public function FormulirRL5_4(Request $request)
    {
        $from = $request->dari;
        $to = $request->sampai;
        $unit = \DB::connection('mysql2')->select("CALL `sp_MASTER_UNIT`('','')");
        return view('simrs.formulir.f_r_l_5.formulir_rl_5_4',compact('from','to','request','unit'));
    }

    public function FormulirRL5_4P(Request $request)
    {
        // dd($request->all());
        $from = $request->dari;
        $to = $request->sampai;
        $jml = $request->jumlah;
        $unit = \DB::connection('mysql2')->select("CALL `sp_MASTER_UNIT`('','')");
        $kode_unit = $request->unit;
        $p1 = Carbon::parse($from);
        $p2 = Carbon::parse($to);
        $th1 = $p1->year;
        $th2 = $p2->year;
        if ($th1 == $th2) {
            $th = $th2;
        } else {
            $th = $th1 . '-' . $th2;
        }

        $laporanFM = null;
        if ($kode_unit) {
            $laporanFM = \DB::connection('mysql2')->select("CALL `SP_LAPORAN_DIAGNOSA_PENYAKIT_TERBANYAK_RAJAL_PERUNIT`('$from','$to','$kode_unit','$jml')");
            $laporanFM = collect($laporanFM);
            return view('simrs.formulir.f_r_l_5.formulir_rl_5_4_data', compact('laporanFM', 'from', 'to', 'request', 'jml', 'unit', 'kode_unit',  'th'));
        } else {
            $laporanFM = \DB::connection('mysql2')->select("CALL `SP_LAPORAN_DIAGNOSA_PENYAKIT_TERBANYAK_RAJAL`('$from','$to','$jml')");
            $laporanFM = collect($laporanFM);
        }
        return view('simrs.formulir.f_r_l_5.formulir_rl_5_4unit_old', compact('laporanFM', 'from', 'to', 'request', 'jml','th'));
    }

    public function FormulirRL5_5(Request $request)
    {
        $from = $request->dari;
        $to = $request->sampai;

        $ksm = \DB::connection('mysql2')->select("CALL `sp_MASTER_KELOMPOK_STAF_MEDIS`('')");
        $dataKsm = $request->ksm;
        $laporanFM = null;

        if ($from && $to && $dataKsm) {
            $laporanFM = \DB::connection('mysql2')->select("CALL `sp_LAPORAN_DIAGNOSA_PENYAKIT_TERBANYAK_smf`('$from','$to','$dataKsm')");
            $laporanFM = collect($laporanFM);
        }
        return view('simrs.formulir.f_r_l_5.formulir_rl_5_5', compact('laporanFM', 'from', 'to', 'request', 'ksm', 'dataKsm'));
    }
}
