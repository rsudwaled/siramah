<?php

namespace App\Http\Controllers;

use App\Models\AsesmenRanap;
use App\Models\AsesmenRanapPerawat;
use App\Models\AsuhanTerpadu;
use App\Models\BudgetControl;
use App\Models\ErmRanap;
use App\Models\ErmRanapKeperawatan;
use App\Models\ErmRanapMppa;
use App\Models\ErmRanapMppb;
use App\Models\ErmRanapObservasi;
use App\Models\ErmRanapPerkembangan;
use App\Models\FileRekamMedis;
use App\Models\FileUpload;
use App\Models\Kunjungan;
use App\Models\TtdDokter;
use App\Models\Unit;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class RanapController extends APIController
{
    public function kunjunganranap(Request $request)
    {
        $units = Unit::whereIn('kelas_unit', ['2'])
            ->orderBy('nama_unit', 'asc')
            ->pluck('nama_unit', 'kode_unit');
        $kunjungans = null;
        $request['tanggal'] = $request->tanggal ?? now()->format('Y-m-d');
        if ($request->tanggal) {
            $request['tgl_awal'] = Carbon::parse($request->tanggal)->endOfDay();
            $request['tgl_akhir'] = Carbon::parse($request->tanggal)->startOfDay();
            if ($request->kodeunit == '-') {
                $kunjungans = Kunjungan::whereRelation('unit', 'kelas_unit', '=', 2)
                    ->where('tgl_masuk', '<=', $request->tgl_awal)
                    ->where('tgl_keluar', '>=', $request->tgl_akhir)
                    ->orWhere('status_kunjungan', 1)
                    ->whereRelation('unit', 'kelas_unit', '=', 2)
                    ->with(['pasien', 'budget', 'tagihan', 'unit', 'status', 'erm_ranap', 'penjamin_simrs', 'alasan_masuk', 'dokter'])
                    ->get();
            } else {
                $kunjungans = Kunjungan::where('kode_unit', $request->kodeunit)
                    ->where('tgl_masuk', '<=', $request->tgl_awal)
                    ->where('tgl_keluar', '>=', $request->tgl_akhir)
                    ->orWhere('status_kunjungan', 1)
                    ->where('kode_unit', $request->kodeunit)
                    ->with(['pasien', 'budget', 'tagihan', 'unit', 'status', 'erm_ranap', 'penjamin_simrs', 'alasan_masuk', 'dokter'])
                    ->get();
            }
        }
        $belum = $kunjungans->where('budget.kode_cbg', null)->count();
        if ($belum) {
            Alert::warning('Peringatan', 'Ada ' . $belum . ' pasien yang belum di groupping. Mohon lakukan pengecekan dan silahkan groupping sebelum 3 hari saat rawat inap');
        }
        return view('simrs.ranap.kunjungan_ranap', compact(
            'request',
            'units',
            'kunjungans',
        ));
    }
    public function pasienranapprofile(Request $request, $kode)
    {
        $activeButton   = $request->query('active_button', '');
        $kode           = $kode;
        $kunjungan = Kunjungan::with([
            'dokter',
            'unit',
            'alasan_masuk',
            'penjamin_simrs',
            'status',
            'alasan_pulang',
            'surat_kontrol',
            'groupping',
            'erm_ranap',
            'asesmen_ranap',
            'asuhan_terpadu',
            'asesmen_ranap_keperawatan',
        ])->firstWhere('kode_kunjungan', $kode);
        
        $pasien         = $kunjungan->pasien;
        $groupping      = $kunjungan->groupping;
        $cardContent    = $this->getCardContent($activeButton, $kunjungan, $pasien);

        return view('simrs.ranap.erm_ranap', compact([
            'kunjungan',
            'pasien',
            'groupping',
            'kode',
            'activeButton', 'cardContent'
        ]));
    }
    private function getCardContent($activeButton, $kunjungan, $pasien)
    {
        switch ($activeButton) {
            case 'triase':
                return [
                    'title' => 'Triase IGD',
                    'content' => view('simrs.ranap.partials.triase')->render()
                ];
            case 'radiologi':
                $data = $this->get_hasil_radiologi($pasien->no_rm);
                return [
                    'title' => 'Radiologi',
                    'content' => view('simrs.ranap.partials.radiologi', compact('data','kunjungan'))->render()
                ];
            case 'laboratorium':
                $data = $this->getHasilLaboratoriumData($pasien->no_rm);
                return [
                    'title' => 'Laboratorium',
                    'content' => view('simrs.ranap.partials.laboratorium', compact('data','kunjungan'))->render()
                ];
            case 'lab_patologianatomi':
                $data = $this->getHasilPatologi($pasien->no_rm);
                return [
                    'title' => 'Lab Patologi Anatomi',
                    'content' => view('simrs.ranap.partials.lab_patologi_anatomi', compact('data','kunjungan'))->render()
                ];
            case 'berkas':
                $files = FileRekamMedis::where('norm', $pasien->no_rm)->get();
                $fileupload = FileUpload::where('no_rm', $pasien->no_rm)->get();
                return [
                    'title' => 'Berkas',
                    'content' => view('simrs.ranap.partials.berkas', compact('files','fileupload'))->render()
                ];
            case 'rencana_asuhan':
                return [
                    'title' => 'Rencana Asuhan',
                    'content' => view('simrs.ranap.partials.rencana_asuhan', compact('kunjungan'))->render()
                ];
            case 'assesmen_awal_medis':
                return [
                    'title' => 'Assesmen Awal Medis',
                    'content' => view('simrs.ranap.partials.assesmen_awal_medis', compact('kunjungan'))->render()
                ];
            case 'assesmen_keperawatan':
                return [
                    'title' => 'Assesmen Keperawatan',
                    'content' => view('simrs.ranap.partials.assesmen_keperawatan', compact('kunjungan'))->render()
                ];
            case 'soap':
                return [
                    'title' => 'SOAP & Perkembangan',
                    'content' => view('simrs.ranap.partials.soap', compact('kunjungan'))->render()
                ];
            case 'implementasi_evaluasi':
                return [
                    'title' => 'Implementasi & Evaluasi',
                    'content' => view('simrs.ranap.partials.implementasi_evaluasi', compact('kunjungan'))->render()
                ];
            case 'observasi_24jam':
                return [
                    'title' => 'Observasi 24 Jam',
                    'content' => view('simrs.ranap.partials.observasi_24jam', compact('kunjungan'))->render()
                ];
            case 'kpo_elektronik':
                return [
                    'title' => 'KPO Elektronik',
                    'content' => view('simrs.ranap.partials.kpo_elektronik', compact('kunjungan'))->render()
                ];

            default:
                return [
                    'title' => '',
                    'content' => ''
                ];
        }
    }

    private function getHasilLaboratoriumData($no_rm)
    {
        $kodeUnit = '3002';
        $data = [];

        $kunjungans = Kunjungan::where('no_rm', $no_rm)
            ->whereHas('layanans', function ($query) use ($kodeUnit) {
                $query->where('kode_unit', $kodeUnit);
            })
            ->with([
                'unit',
                'pasien',
                'layanans', 'layanans.layanan_details',
                'layanans.layanan_details.tarif_detail',
                'layanans.layanan_details.tarif_detail.tarif',
            ])
            ->orderBy('tgl_masuk', 'desc')
            ->get();

        foreach ($kunjungans as $kunjungan) {
            foreach ($kunjungan->layanans->where('kode_unit', $kodeUnit) as $layanan) {
                $pemeriksaan = $layanan->layanan_details->map(function ($detail) {
                    return $detail->tarif_detail->tarif->NAMA_TARIF;
                })->toArray();

                $data[] = [
                    'kode_kunjungan' => $kunjungan->kode_kunjungan,
                    'tgl_masuk' => $kunjungan->tgl_masuk,
                    'counter' => $kunjungan->counter,
                    'no_rm' => $kunjungan->no_rm,
                    'nama_px' => $kunjungan->pasien->nama_px,
                    'nama_unit' => $kunjungan->unit->nama_unit,
                    'laboratorium' => $layanan->kode_layanan_header,
                    'pemeriksaan' => $pemeriksaan,
                ];
            }
        }

        return $data;
    }

    public function get_hasil_radiologi($no_rm)
    {
        $kodeunit = '3003';
        $data = [];
        
        if ($no_rm) {
            // Ambil kunjungan pasien berdasarkan no_rm dan kode_unit
            $kunjungans = Kunjungan::where('no_rm', $no_rm)
                ->orderBy('tgl_masuk', 'desc')
                ->whereHas('layanans', function ($query) use ($kodeunit) {
                    $query->where('kode_unit', $kodeunit);
                })
                ->with([
                    'unit',
                    'pasien',
                    'layanans.layanan_details.tarif_detail.tarif',
                ])
                ->get();
        
            // Iterasi melalui kunjungan
            foreach ($kunjungans as $kunjungan) {
                // Iterasi melalui layanan yang memiliki kode_unit = 3003
                foreach ($kunjungan->layanans->where('kode_unit', $kodeunit) as $value) {
                    // Iterasi melalui layanan_details
                    foreach ($value->layanan_details as $laydet) {
                        $data[] = [
                            'kode_kunjungan' => $kunjungan->kode_kunjungan,
                            'tgl_masuk' => $kunjungan->tgl_masuk,
                            'counter' => $kunjungan->counter,
                            'no_rm' => $kunjungan->no_rm,
                            'nama_px' => $kunjungan->pasien->nama_px,
                            'nama_unit' => $kunjungan->unit->nama_unit,
                            'header_id' => $value->id,
                            'detail_id' => $laydet->id,
                            'pemeriksaan' => $laydet->tarif_detail->tarif->NAMA_TARIF,
                        ];
                    }
                }
            }
        }
        
        return $data;        
    }

    public function getHasilPatologi($no_rm)
    {
        $kodeunit = '3020';
        $data = [];
        if ($no_rm) {
            $kunjungans = Kunjungan::where('no_rm', $no_rm)->orderBy('tgl_masuk', 'desc')
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
        return $data;
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
            "groupping" =>  $budget ? 'true' : 'false',
            "budget" => $budget ?? null,
            "rincian" => $response,
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
        $data = json_decode(json_encode($data));
        return view('simrs.ranap.modal_rincian_biaya', compact('data'));
    }
    // asesmen ranap
    public function simpan_asesmen_ranap_awal(Request $request)
    {
        $request['pic_awal'] = Auth::user()->name;
        $request['user_awal'] = Auth::user()->id;
        AsesmenRanap::updateOrCreate(
            [
                'rm_counter' => $request->rm_counter
            ],
            $request->all()
        );
        Alert::success('Success', 'Asesmen Awal Rawat Inap Disimpan');
        return redirect()->back();
    }
    // rencana asuhan
    public function simpan_rencana_asuhan_terpadu(Request $request)
    {
        AsuhanTerpadu::updateOrCreate(
            [
                'kode'              => $request->kode,
                'kode_kunjungan'    => $request->kode_kunjungan,
                'no_rm'             => $request->no_rm,
                'id'                => $request->id_asuhan, 
                'tgl_waktu'         => $request->tgl_waktu, 
            ],
            [
                'kode'                  => $request->kode,
                'kode_kunjungan'        => $request->kode_kunjungan,
                'no_rm'                 => $request->no_rm,
                'rm_counter'            => $request->rm_counter,
                'nama'                  => $request->nama,
                'rencana_asuhan'        => $request->rencana_asuhan,
                'capaian_diharapkan'    => $request->capaian_diharapkan,
                'profesi'               => $request->profesi,
                'pic'                   => $request->pic,
                'kode_unit'             => $request->kode_unit,
                'user'                  => $request->user,
            ]
        );
        Alert::success('Success', 'Rencana Asuhan Terpadu Rawat Inap Disimpan');
        return redirect()->back();
    }
    public function getRencanaAsuhData(Request $request)
    {
        $data = AsuhanTerpadu::findOrFail($request->id);
        if (!$data) {
            return response()->json(['error' => 'Data not found'], 404);
        }
        return response()->json($data);
    }
    // assesmen awal
    public function print_asesmen_ranap_awal(Request $request)
    {
        $kunjungan = Kunjungan::firstWhere('kode_kunjungan', $request->kode);
        $pasien = $kunjungan->pasien;
        $pdf = Pdf::loadView('simrs.ranap.pdf_asesmen_ranap_awal', compact('kunjungan', 'pasien'));
        return $pdf->stream('pdf_asesmen_ranap_awal.pdf');
    }
    public function simpan_asesmen_ranap_keperawatan(Request $request)
    {
        $request['pic_keperawatan'] = Auth::user()->name;
        $request['user_keperawatan'] = Auth::user()->id;
        AsesmenRanapPerawat::updateOrCreate(
            [
                'rm_counter' => $request->rm_counter
            ],
            $request->all()
        );
        Alert::success('Success', 'Asesmen Awal Rawat Inap Disimpan');
        return redirect()->back();
    }
    public function print_asesmen_ranap_keperawatan(Request $request)
    {
        $kunjungan = Kunjungan::firstWhere('kode_kunjungan', $request->kode);
        $pasien = $kunjungan->pasien;
        $pdf = Pdf::loadView('simrs.ranap.pdf_asesmen_keperawatan', compact('kunjungan', 'pasien'));
        return $pdf->stream('pdf_asesmen_ranap_awal.pdf');
    }
    // kunjungan ranap aktif
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
    public function print_resume_ranap(Request $request)
    {
        $kunjungan = Kunjungan::firstWhere('kode_kunjungan', $request->kode);
        $erm = $kunjungan->erm_ranap;
        $pasien = $kunjungan->pasien;
        $kunjungans = Kunjungan::where('no_rm', $kunjungan->no_rm)
            ->where('counter', $kunjungan->counter)
            ->get();
        $obat = [];
        $tglmasuk = Carbon::parse($kunjungans->first()->tgl_masuk)->startOfDay();
        $tglpulang = Carbon::parse($kunjungan->tgl_keluar)->endOfDay() ?? now();
        $lama_rawat = $tglmasuk->diffInDays($tglpulang);
        foreach ($kunjungans as $kjg) {
            foreach ($kjg->layanans as  $lynan) {
                // dd($kjg->layanans);
                if ($lynan->unit->kelas_unit == 4) {
                    foreach ($lynan->layanan_details as  $laydet) {
                        if ($laydet->kode_barang) {
                            $obat[] = [
                                'jumlah_layanan' => $laydet->jumlah_layanan,
                                'grantotal_layanan' => $laydet->grantotal_layanan,
                                'kode_dokter1' => $laydet->kode_dokter1,
                                'kode_barang' => $laydet->kode_barang,
                                'nama_barang' => $laydet->barang->nama_barang ?? '-',
                                'aturan_pakai' => $laydet->aturan_pakai,
                                'kategori_resep' => $laydet->kategori_resep,
                                'satuan_barang' => $laydet->satuan_barang,
                                'tgl_layanan_detail' => $laydet->tgl_layanan_detail,
                                'row_id_header' => $laydet->row_id_header,
                                'keterangan' => $lynan->keterangan,
                            ];
                        }
                    }
                }
            }
        }
        $obat2 = array_chunk($obat, count($obat) / 2);

        $pdf = Pdf::loadView('simrs.ranap.pdf_resume_ranap', compact(
            'kunjungan',
            'kunjungans',
            'erm',
            'lama_rawat',
            'obat',
            'obat2',
            'pasien',
        ));
        return $pdf->stream('RESUME RANAP ' . $pasien->nama_px . ' ' . $kunjungans->first()->tgl_masuk . '.pdf');

        return view('simrs.ranap.print_resume_ranap', compact([
            'kunjungan',
            'kunjungans',
            'erm',
            'lama_rawat',
            'obat',
            'obat2',
            'pasien',
        ]));
    }
    public function lihat_resume_ranap(Request $request)
    {
        $kunjungan = Kunjungan::firstWhere('kode_kunjungan', $request->kode);
        $kunjungans = Kunjungan::where('no_rm', $kunjungan->no_rm)
            ->where('counter', $kunjungan->counter)
            ->get();
        $erm = $kunjungan->erm_ranap;
        $pasien = $kunjungan->pasien;
        $obat = [];
        foreach ($kunjungans as $kjg) {
            foreach ($kjg->layanans as  $lynan) {
                if ($lynan->unit->kelas_unit == 4) {
                    foreach ($lynan->layanan_details as  $laydet) {
                        if ($laydet->kode_barang) {
                            $obat[] = [
                                'jumlah_layanan' => $laydet->jumlah_layanan,
                                'grantotal_layanan' => $laydet->grantotal_layanan,
                                'kode_dokter1' => $laydet->kode_dokter1,
                                'kode_barang' => $laydet->kode_barang,
                                'nama_barang' => $laydet->barang->nama_barang,
                                'aturan_pakai' => $laydet->aturan_pakai,
                                'kategori_resep' => $laydet->kategori_resep,
                                'satuan_barang' => $laydet->satuan_barang,
                            ];
                        }
                    }
                }
            }
        }
        return view('simrs.ranap.lihat_resume_ranap', compact([
            'kunjungan',
            'kunjungans',
            'erm',
            'obat',
            'pasien',
        ]));
    }
    public function monitoring_resume_ranap(Request $request)
    {
        $units = Unit::whereIn('kelas_unit', ['2'])
            ->orderBy('nama_unit', 'asc')
            ->pluck('nama_unit', 'kode_unit');
        $resumes = ErmRanap::simplePaginate();
        return view('simrs.ranap.monitoring_resume_ranap', compact([
            'request',
            'units',
            'resumes',
        ]));
    }
    public function table_resume_ranap(Request $request)
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
                    ->with(['pasien', 'budget', 'tagihan', 'erm_ranap', 'unit', 'status'])
                    ->get();
            } else {
                $kunjungans = Kunjungan::where('kode_unit', $request->ruangan)
                    ->where('tgl_masuk', '<=', $request->tgl_awal)
                    ->where('tgl_keluar', '>=', $request->tgl_akhir)
                    ->orWhere('status_kunjungan', 1)
                    ->where('kode_unit', $request->ruangan)
                    ->with(['pasien', 'budget', 'tagihan', 'erm_ranap', 'unit', 'status'])
                    ->get();
            }
        }
        return view('simrs.ranap.table_resume_ranap', compact('kunjungans'));
    }
    public function form_resume_ranap(Request $request)
    {
        $kunjungan = Kunjungan::with([
            'pasien',
            'erm_ranap',
        ])->firstWhere('kode_kunjungan', $request->kode);
        $pasien = $kunjungan->pasien;
        $groupping = $kunjungan->groupping;
        return view('simrs.ranap.form_resume_ranap', compact([
            'kunjungan',
            'pasien',
            'groupping',

        ]));
    }
    public function simpan_resume_ranap(Request $request)
    {
        $request['pic1'] = Auth::user()->name;
        $request['user1'] = Auth::user()->id;
        $icd10_sekunder = [];
        $diagsekunder = array_filter($request->diagnosa_sekunder);
        foreach ($diagsekunder as $key => $value) {
            $icd10_sekunder[] = $request->icd10_sekunder[$key];
        }
        $request['diagnosa_sekunder'] = $request->diagnosa_sekunder ?  json_encode($diagsekunder) : null;
        $request['icd10_sekunder'] = $request->icd10_sekunder ?  json_encode($icd10_sekunder) : null;

        $icd9_operasi = [];
        $tidakanoperasi = array_filter($request->tindakan_operasi);
        foreach ($tidakanoperasi as $key => $value) {
            $icd9_operasi[] = $request->icd9_operasi[$key];
        }
        $request['tindakan_operasi'] = $request->tindakan_operasi ?  json_encode($tidakanoperasi) : null;
        $request['icd9_operasi'] = $request->icd9_operasi ?  json_encode($icd9_operasi) : null;

        $icd9_prosedur = [];
        $tidakanoprosedur = array_filter($request->tindakan_prosedur);

        foreach ($tidakanoprosedur as $key => $value) {
            $icd9_prosedur[] = $request->icd9_prosedur[$key];
        }
        $request['tindakan_prosedur'] = $request->tindakan_prosedur ?  json_encode($tidakanoprosedur) : null;
        $request['icd9_prosedur'] = $request->icd9_prosedur ?  json_encode($icd9_prosedur) : null;
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
    public function ttd_dokter_resume_ranap(Request $request)
    {
        $now = now();
        $request['time'] = $now->timestamp;
        $resume  = ErmRanap::where('kode_kunjungan', $request->kode_kunjungan)->first();
        if ($resume) {
            if ($resume->ttd_dokter) {
                $ttd = TtdDokter::find($resume->ttd_dokter);
                $ttd->update($request->all());
            } else {
                $ttd = TtdDokter::create($request->all());
            }
            $resume->update([
                'ttd_dokter' => $ttd->id,
                'waktu_ttd_dokter' =>  $now,
            ]);
        }
        Alert::success('Success', 'Data Resume Rawat Inap Berhasil Di Tanda Tangani');
        return redirect()->back();
    }
    public function ttd_pasien_resume_ranap(Request $request)
    {
        $now = now();
        $request['time'] = $now->timestamp;
        $resume  = ErmRanap::where('kode_kunjungan', $request->kode_kunjungan)->first();
        if ($resume) {
            if ($resume->ttd_keluarga) {
                $ttd = TtdDokter::find($resume->ttd_keluarga);
                $ttd->update($request->all());
            } else {
                $ttd = TtdDokter::create($request->all());
            }
            $resume->update([
                'ttd_keluarga' => $ttd->id,
                'waktu_ttd_keluarga' =>  $now,
            ]);
        }
        Alert::success('Success', 'Data Resume Rawat Inap Berhasil Di Tanda Tangani');
        return redirect()->back();
    }
    public function verif_resume_ranap(Request $request)
    {
        $request['pic2'] = Auth::user()->name;
        $request[''] = Auth::user()->id;
        $resume = ErmRanap::where('kode_kunjungan', $request->kode)->first();
        $resume->update([
            'pic2' => Auth::user()->name,
            'user2' => Auth::user()->id,
            'status' => 2,
        ]);
        Alert::success('Success', 'Data Resume Rawat Inap Berhasil Diverifikasi');
        return redirect()->back();
    }
    public function revisi_resume_ranap(Request $request)
    {
        $request['pic2'] = Auth::user()->name;
        $request[''] = Auth::user()->id;
        $resume = ErmRanap::where('kode_kunjungan', $request->kode)->first();
        $resume->update([
            'pic2' => Auth::user()->name,
            'user2' => Auth::user()->id,
            'status' => 1,
        ]);
        Alert::success('Success', 'Data Resume Rawat Inap Berhasil Diverifikasi');
        return redirect()->back();
    }
    public function simpan_mppa(Request $request)
    {
        $request['pic'] = Auth::user()->name;
        $request['user_id'] = Auth::user()->id;
        $request['identifisikasimasalah'] = json_encode($request->identifisikasimasalah);
        $request['rencana_mpp'] = json_encode($request->rencana_mpp);
        $erm = ErmRanapMppa::updateOrCreate(
            [
                'kode_kunjungan' => $request->kode_kunjungan,
                'norm' => $request->norm,
            ],
            $request->all()
        );
        Alert::success('Success', 'Data MPP Form A Berhasil Disimpan');
        return redirect()->back();
    }

    public function print_mppa(Request $request)
    {
        $kunjungan = Kunjungan::firstWhere('kode_kunjungan', $request->kode);
        $mppa = $kunjungan->erm_ranap_mppa;
        $pasien = $kunjungan->pasien;
        $pdf = Pdf::loadView('simrs.ranap.pdf_mppa', compact('kunjungan', 'mppa', 'pasien'));
        return $pdf->stream('invoice.pdf');
    }
    public function simpan_mppb(Request $request)
    {
        $request['pic'] = Auth::user()->name;
        $request['user_id'] = Auth::user()->id;
        $request['advokasi'] = json_encode($request->advokasi);
        $erm = ErmRanapMppb::updateOrCreate(
            [
                'kode_kunjungan' => $request->kode_kunjungan,
                'norm' => $request->norm,
            ],
            $request->all()
        );
        Alert::success('Success', 'Data MPP Form B Berhasil Disimpan');
        return redirect()->back();
    }
    public function print_mppb(Request $request)
    {
        $kunjungan = Kunjungan::firstWhere('kode_kunjungan', $request->kode);
        $mppb = $kunjungan->erm_ranap_mppb;
        $pasien = $kunjungan->pasien;
        return view('simrs.ranap.print_mppb', compact([
            'kunjungan',
            'mppb',
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
        $validator = \Validator::make($request->all(), [
            'tanggal_input'     => 'required|date',
            'perkembangan'      => 'required',
            'instruksi_medis'   => 'required',
        ], [
            'tanggal_input.required'     => 'Kolom inputan tanggal wajib diisi.',
            'tanggal_input.date'         => 'Kolom inputan tanggal harus berupa tanggal yang valid.',
            'perkembangan.required'      => 'Kolom inputan SOAP hasil pemeriksaan wajib diisi.',
            'instruksi_medis.required'   => 'Kolom inputan instruksi medis wajib diisi.',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'metadata' => [
                    'code' => 422,
                    'message' => 'Upps... ada inputan yang belum diisi!',
                ],
                'errors' => $validator->errors(), // Kirimkan detail kesalahan
            ], 422);
        }
    
        try {
            $data = ErmRanapPerkembangan::updateOrCreate(
                [
                    'tanggal_input'     => $request->tanggal_input,
                    'kode_kunjungan'    => $request->kode_kunjungan,
                    'counter'           => $request->counter,
                    'norm'              => $request->norm,
                ],
                [
                    'norm'              => $request->norm,
                    'perkembangan'      => $request->perkembangan,
                    'instruksi_medis'   => $request->instruksi_medis,
                    'instruksi_medis'   => $request->instruksi_medis,
                    'user_id'           => Auth::user()->id,
                    'pic'               => Auth::user()->name,
                ],
                $request->all()
            );
            return response()->json([
                'metadata' => [
                    'code' => 200,
                    'message' => 'Data berhasil disimpan',
                ],
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in simpan_perkembangan_ranap: ' . $e->getMessage());
            return response()->json([
                'metadata' => [
                    'code' => 500,
                    'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage(),
                ],
            ], 500);
        }
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
    public function cancle_verifikasi_soap_ranap(Request $request)
    {
        $observasi = ErmRanapPerkembangan::find($request->id);
        if ($observasi) {
            # code...
            $observasi->update([
                'verifikasi_at' => Null,
                'verifikasi_by' => Null,
            ]);
            return $this->sendResponse('Verifikasi berhasil dibatalkan');
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
