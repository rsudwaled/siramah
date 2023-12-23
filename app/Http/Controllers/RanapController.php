<?php

namespace App\Http\Controllers;

use App\Models\BudgetControl;
use App\Models\ErmRanap;
use App\Models\ErmRanapKeperawatan;
use App\Models\ErmRanapObservasi;
use App\Models\ErmRanapPerkembangan;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class RanapController extends APIController
{
    // daftar pasien ranap
    public function kunjunganranap(Request $request)
    {
        $units = Unit::whereIn('kelas_unit', ['2'])
            ->orderBy('nama_unit', 'asc')
            ->pluck('nama_unit', 'kode_unit');
        $kunjungans = null;
        // if ($request->tanggal) {
        //     $request['tgl_awal'] = Carbon::parse($request->tanggal)->endOfDay();
        //     $request['tgl_akhir'] = Carbon::parse($request->tanggal)->startOfDay();
        //     if ($request->kodeunit == '-') {
        //         $kunjungans = Kunjungan::whereRelation('unit', 'kelas_unit', '=', 2)
        //             ->where('tgl_masuk', '<=', $request->tgl_awal)
        //             ->where('tgl_keluar', '>=', $request->tgl_akhir)
        //             ->orWhere('status_kunjungan', 1)
        //             ->whereRelation('unit', 'kelas_unit', '=', 2)
        //             ->with(['pasien', 'budget', 'unit', 'status'])
        //             ->get();
        //     } else {
        //         $kunjungans = Kunjungan::where('kode_unit', $request->kodeunit)
        //             ->where('tgl_masuk', '<=', $request->tgl_awal)
        //             ->where('tgl_keluar', '>=', $request->tgl_akhir)
        //             ->orWhere('status_kunjungan', 1)
        //             ->where('kode_unit', $request->kodeunit)
        //             ->with(['pasien', 'budget', 'unit', 'status'])
        //             ->get();
        //     }
        // }
        return view('simrs.ranap.kunjungan_ranap', compact([
            'request',
            'units',
            'kunjungans',
        ]));
    }
    public function get_pasien_ranap(Request $request)
    {
        $kunjungans = null;
        if ($request->tanggal) {
            $request['tgl_awal'] = Carbon::parse($request->tanggal)->endOfDay();
            $request['tgl_akhir'] = Carbon::parse($request->tanggal)->startOfDay();
            if ($request->ruangan == '-') {
                $kunjungans = Kunjungan::whereRelation('unit', 'kelas_unit', '=', 2)
                    ->where('tgl_masuk', '<=', $request->tgl_awal)
                    ->where('tgl_keluar', '>=', $request->tgl_akhir)
                    ->orWhere('status_kunjungan', 1)
                    ->whereRelation('unit', 'kelas_unit', '=', 2)
                    ->with(['pasien', 'budget', 'tagihan', 'unit', 'status'])
                    ->get();
            } else {
                $kunjungans = Kunjungan::where('kode_unit', $request->ruangan)
                    ->where('tgl_masuk', '<=', $request->tgl_awal)
                    ->where('tgl_keluar', '>=', $request->tgl_akhir)
                    ->orWhere('status_kunjungan', 1)
                    ->where('kode_unit', $request->ruangan)
                    ->with(['pasien', 'budget', 'tagihan', 'unit', 'status'])
                    ->get();
            }
        }
        return $this->sendResponse($kunjungans);
    }
    // erm pasien ranap
    public function pasienranapprofile(Request $request)
    {
        $kunjungan = Kunjungan::with([
            'pasien',
            'dokter',
            'unit',
            'alasan_masuk',
            'penjamin_simrs',
            'status',
            'alasan_pulang',
            'surat_kontrol',
            'groupping',
        ])->firstWhere('kode_kunjungan', $request->kode);
        $pasien = $kunjungan->pasien;
        $groupping = $kunjungan->groupping;
        return view('simrs.ranap.erm_ranap', compact([
            'kunjungan',
            'pasien',
            'groupping',
        ]));
    }
    public function get_kunjungan_pasien(Request $request)
    {
        $kunjungans = Kunjungan::where('no_rm', $request->norm)
            ->with(['unit'])
            ->get();
        return $this->sendResponse($kunjungans);
    }
    public function get_rincian_biaya(Request $request)
    {
        $response = collect(DB::connection('mysql2')->select("CALL RINCIAN_BIAYA_FINAL('" . $request->norm . "','" . $request->counter . "','','')"));
        $budget = BudgetControl::find($request->norm . '|' . $request->counter);
        $data = [
            "rincian" => $response,
            "budget" => $budget,
            "pasien" => $budget->pasien ?? null,
            "rangkuman" => [
                "tarif_rs" => round($response->sum("GRANTOTAL_LAYANAN")),
                "prosedur_non_bedah" => round($response->where('nama_group_vclaim', "PROSEDURE NON BEDAH")->sum("GRANTOTAL_LAYANAN")),
                "prosedur_bedah" => round($response->where('nama_group_vclaim', "PROSEDURE BEDAH")->sum("GRANTOTAL_LAYANAN")),
                "tenaga_ahli" => round($response->where('nama_group_vclaim', "TENAGA AHLI")->sum("GRANTOTAL_LAYANAN")),
                "radiologi" => round($response->where('nama_group_vclaim', "RADIOLOGI")->sum("GRANTOTAL_LAYANAN")),
                "laboratorium" => round($response->where('nama_group_vclaim', "LABORATORIUM")->sum("GRANTOTAL_LAYANAN")),
                "rehabilitasi" => round($response->where('nama_group_vclaim', "REHABILITASI MEDIK")->sum("GRANTOTAL_LAYANAN")),
                "sewa_alat" => round($response->where('nama_group_vclaim', "SEWA ALAT")->sum("GRANTOTAL_LAYANAN")),
                "keperawatan" => round($response->where('nama_group_vclaim', "KEPERAWATAN")->sum("GRANTOTAL_LAYANAN")),
                "kamar_akomodasi" => round($response->where('nama_group_vclaim', "KAMAR/AKOMODASI")->sum("GRANTOTAL_LAYANAN")),
                "penunjang" => round($response->where('nama_group_vclaim', "PENUNJANG MEDIS")->sum("GRANTOTAL_LAYANAN")),
                "konsultasi" => round($response->where('nama_group_vclaim', "KONSULTASI")->sum("GRANTOTAL_LAYANAN")),
                "pelayanan_darah" => round($response->where('nama_group_vclaim', "PELAYANAN DARAH")->sum("GRANTOTAL_LAYANAN")),
                "rawat_intensif" => round($response->where('nama_group_vclaim', "RAWAT INTENSIF")->sum("GRANTOTAL_LAYANAN")),
                "obat" => round($response->where('nama_group_vclaim', "OBAT")->sum("GRANTOTAL_LAYANAN")),
                "alkes" => round($response->where('nama_group_vclaim', "ALKES")->sum("GRANTOTAL_LAYANAN")),
                "bmhp" => round($response->where('nama_group_vclaim', "BMHP")->sum("GRANTOTAL_LAYANAN")),
                "obat_kronis" => round($response->where('nama_group_vclaim', "OBAT KRONIS")->sum("GRANTOTAL_LAYANAN")),
                "obat_kemo" => round($response->where('nama_group_vclaim', "OBAT KEMOTERAPI")->sum("GRANTOTAL_LAYANAN")),
            ],
        ];
        return $this->sendResponse($data, 200);
    }
    public function get_hasil_laboratorium(Request $request)
    {
        $kodeunit = '3002';
        $data = [];
        if ($request->norm) {
            $kunjungans = Kunjungan::where('no_rm', $request->norm)->orderBy('tgl_masuk', 'desc')
                ->whereHas('layanans', function ($query) use ($kodeunit) {
                    $query->where('kode_unit', $kodeunit);
                })
                ->with([
                    'unit',
                    'pasien',
                    'layanans', 'layanans.layanan_details',
                    'layanans.layanan_details.tarif_detail',
                    'layanans.layanan_details.tarif_detail.tarif',
                ])
                ->get();

            foreach ($kunjungans as $key => $kunjungan) {
                $lab = [];
                $pemeriksaan = [];
                foreach ($kunjungan->layanans->where('kode_unit', 3002) as $key => $value) {
                    foreach ($value->layanan_details as $key => $laydet) {
                        $pemeriksaan[] = $laydet->tarif_detail->tarif->NAMA_TARIF;
                    }
                    $data[] = [
                        'kode_kunjungan' => $kunjungan->kode_kunjungan,
                        'tgl_masuk' => $kunjungan->tgl_masuk,
                        'counter' => $kunjungan->counter,
                        'no_rm' => $kunjungan->no_rm,
                        'nama_px' => $kunjungan->pasien->nama_px,
                        'nama_unit' => $kunjungan->unit->nama_unit,
                        'laboratorium' =>  $value->kode_layanan_header,
                        'pemeriksaan' =>  $pemeriksaan,
                    ];
                }
            }
        }
        return $this->sendResponse($data);
    }
    public function get_hasil_radiologi(Request $request)
    {
        $kodeunit = '3003';
        $data = [];
        $rad = [];
        $detail = [];
        if ($request->norm) {
            $kunjungans = Kunjungan::where('no_rm', $request->norm)->orderBy('tgl_masuk', 'desc')
                ->whereHas('layanans', function ($query) use ($kodeunit) {
                    $query->where('kode_unit', $kodeunit);
                })
                ->with([
                    'unit',
                    'pasien',
                    'layanans', 'layanans.layanan_details',
                    'layanans.layanan_details.tarif_detail',
                    'layanans.layanan_details.tarif_detail.tarif',
                ])
                ->get();
            foreach ($kunjungans as $key => $kunjungan) {
                $pemeriksaan = [];
                foreach ($kunjungan->layanans->where('kode_unit', 3003) as $key => $value) {
                    foreach ($value->layanan_details as $key => $laydet) {
                        $data[] = [
                            'kode_kunjungan' => $kunjungan->kode_kunjungan,
                            'tgl_masuk' => $kunjungan->tgl_masuk,
                            'counter' => $kunjungan->counter,
                            'no_rm' => $kunjungan->no_rm,
                            'nama_px' => $kunjungan->pasien->nama_px,
                            'nama_unit' => $kunjungan->unit->nama_unit,
                            'header_id' =>   $value->id,
                            'detail_id' =>   $laydet->id,
                            'pemeriksaan' => $laydet->tarif_detail->tarif->NAMA_TARIF,
                        ];
                    }
                }
            }
        }
        return $this->sendResponse($data);
    }
    public function get_hasil_patologi(Request $request)
    {
        $kodeunit = '3020';
        $data = [];
        $rad = [];
        $detail = [];
        if ($request->norm) {
            $kunjungans = Kunjungan::where('no_rm', $request->norm)->orderBy('tgl_masuk', 'desc')
                ->whereHas('layanans', function ($query) use ($kodeunit) {
                    $query->where('kode_unit', $kodeunit);
                })
                ->with([
                    'unit',
                    'pasien',
                    'layanans', 'layanans.layanan_details',
                    'layanans.layanan_details.tarif_detail',
                    'layanans.layanan_details.tarif_detail.tarif',
                ])
                ->get();
            foreach ($kunjungans as $key => $kunjungan) {
                $pemeriksaan = [];
                foreach ($kunjungan->layanans->where('kode_unit', 3020) as $key => $value) {
                    foreach ($value->layanan_details as $key => $laydet) {
                        $data[] = [
                            'kode_kunjungan' => $kunjungan->kode_kunjungan,
                            'tgl_masuk' => $kunjungan->tgl_masuk,
                            'counter' => $kunjungan->counter,
                            'no_rm' => $kunjungan->no_rm,
                            'nama_px' => $kunjungan->pasien->nama_px,
                            'nama_unit' => $kunjungan->unit->nama_unit,
                            'header_id' =>   $value->id,
                            'detail_id' =>   $laydet->id,
                            'pemeriksaan' => $laydet->tarif_detail->tarif->NAMA_TARIF,
                        ];
                    }
                }
            }
        }
        return $this->sendResponse($data);
    }
    public function kunjunganranapaktif(Request $request)
    {
        $units = Unit::whereIn('kelas_unit', ['2'])
            ->orderBy('nama_unit', 'asc')
            ->pluck('nama_unit', 'kode_unit');
        $kunjungans = null;
        if ($request->kodeunit) {
            if ($request->kodeunit == '-') {
                $kunjungans = Kunjungan::whereRelation('unit', 'kelas_unit', '=', 2)
                    ->where('status_kunjungan', 1)
                    ->has('pasien')
                    ->with(['pasien', 'penjamin_simrs', 'dokter', 'unit', 'status'])
                    ->get();
            } else {
                $kunjungans = Kunjungan::where('kode_unit', $request->kodeunit)
                    ->where('status_kunjungan', 1)
                    ->has('pasien')
                    ->with(['pasien', 'penjamin_simrs', 'dokter', 'unit', 'status'])
                    ->get();
            }
        }
        return view('simrs.ranap.kunjungan_ranap_aktif', compact([
            'request',
            'units',
            'kunjungans',
        ]));
    }
    public function simpan_resume_ranap(Request $request)
    {

        $erm = ErmRanap::updateOrCreate(
            [
                'kode_kunjungan' => $request->kode_kunjungan,
                'norm' => $request->norm,
                'counter' => $request->counter,
            ],
            $request->all()
        );
        Alert::success('Success', 'Data Resume Rawat Inap Berhasil Disimpan');
        return redirect()->back();
    }
    public function print_resume_ranap(Request $request)
    {
        $kunjungan = Kunjungan::firstWhere('kode_kunjungan', $request->kode);
        $erm = $kunjungan->erm_ranap;
        $pasien = $kunjungan->pasien;
        return view('simrs.ranap.print_resume_ranap', compact([
            'kunjungan',
            'erm',
            'pasien',
        ]));
    }
    // implementasi
    public function get_keperawatan_ranap(Request $request)
    {
        $observasi = ErmRanapKeperawatan::where('kode_kunjungan', $request->kode)->get();
        return $this->sendResponse($observasi);
    }
    public function simpan_keperawatan_ranap(Request $request)
    {
        $request['pic'] = Auth::user()->name;
        $request['user_id'] = Auth::user()->id;
        $keperawatan = ErmRanapKeperawatan::updateOrCreate(
            [
                'tanggal_input' => $request->tanggal_input,
                'kode_kunjungan' => $request->kode_kunjungan,
            ],
            $request->all()
        );
        return $this->sendResponse($keperawatan);
    }
    public function hapus_keperawatan_ranap(Request $request)
    {
        $keperawatan = ErmRanapKeperawatan::find($request->id);
        if ($keperawatan->user_id == Auth::user()->id) {
            $keperawatan->delete();
            return $this->sendResponse('Berhasil dihapus');
        } else {
            return $this->sendError('Tidak Bisa Dihapus oleh anda.', 405);
        }
    }
    public function print_implementasi_evaluasi_keperawatan(Request $request)
    {
        $kunjungan = Kunjungan::firstWhere('kode_kunjungan', $request->kunjungan);
        $keperawatan = $kunjungan->erm_ranap_keperawatan;
        $pasien = $kunjungan->pasien;
        return view('simrs.ranap.print_ranap_keperawatan', compact([
            'kunjungan',
            'pasien',
            'keperawatan',
        ]));
    }
    // observasi
    public function get_observasi_ranap(Request $request)
    {
        $observasi = ErmRanapObservasi::where('kode_kunjungan', $request->kode)->get();
        return $this->sendResponse($observasi);
    }
    public function simpan_observasi_ranap(Request $request)
    {
        $request['pic'] = Auth::user()->name;
        $request['user_id'] = Auth::user()->id;
        $observasi = ErmRanapObservasi::updateOrCreate(
            [
                'tanggal_input' => $request->tanggal_input,
                'kode_kunjungan' => $request->kode_kunjungan,
            ],
            $request->all()
        );
        return $this->sendResponse($observasi);
    }
    public function hapus_obaservasi_ranap(Request $request)
    {
        $observasi = ErmRanapObservasi::find($request->id);
        if ($observasi->user_id == Auth::user()->id) {
            $observasi->delete();
            return $this->sendResponse('Berhasil dihapus');
        } else {
            return $this->sendError('Tidak Bisa Dihapus oleh anda.', 405);
        }
    }
    public function print_obaservasi_ranap(Request $request)
    {
        $kunjungan = Kunjungan::firstWhere('kode_kunjungan', $request->kunjungan);
        $keperawatan = $kunjungan->erm_ranap_observasi;
        $pasien = $kunjungan->pasien;
        return view('simrs.ranap.print_ranap_observasi', compact([
            'kunjungan',
            'pasien',
            'keperawatan',
        ]));
    }
    // soap
    public function simpan_perkembangan_ranap(Request $request)
    {
        $request['pic'] = Auth::user()->name;
        $request['user_id'] = Auth::user()->id;
        $observasi = ErmRanapPerkembangan::updateOrCreate(
            [
                'tanggal_input' => $request->tanggal_input,
                'kode_kunjungan' => $request->kode_kunjungan,
            ],
            $request->all()
        );
        return $this->sendResponse($observasi);
    }
    public function get_perkembangan_ranap(Request $request)
    {
        $observasi = ErmRanapPerkembangan::where('kode_kunjungan', $request->kode)->get();
        return $this->sendResponse($observasi);
    }
    public function hapus_perkembangan_ranap(Request $request)
    {
        $observasi = ErmRanapPerkembangan::find($request->id);
        if ($observasi->user_id == Auth::user()->id) {
            $observasi->delete();
            return $this->sendResponse('Berhasil dihapus');
        } else {
            return $this->sendError('Tidak Bisa Dihapus oleh anda.', 405);
        }
    }
    public function verifikasi_soap_ranap(Request $request)
    {
        $observasi = ErmRanapPerkembangan::find($request->id);
        if ($observasi) {
            # code...
            $observasi->update([
                'verifikasi_at' => now(),
                'verifikasi_by' => Auth::user()->name,
            ]);
            return $this->sendResponse('Berhasil diverifikasi');
        } else {
            return $this->sendError('Catatan tidak ditemukan');
        }
    }
    public function print_perkembangan_ranap(Request $request)
    {
        $kunjungan = Kunjungan::firstWhere('kode_kunjungan', $request->kunjungan);
        $keperawatan = $kunjungan->erm_ranap_perkembangan;
        $pasien = $kunjungan->pasien;
        return view('simrs.ranap.print_ranap_perkembangan', compact([
            'kunjungan',
            'pasien',
            'keperawatan',
        ]));
    }
}
