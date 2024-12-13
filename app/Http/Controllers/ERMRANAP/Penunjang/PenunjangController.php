<?php

namespace App\Http\Controllers\ERMRANAP\Penunjang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\FileRekamMedis;
use App\Models\FileUpload;
use App\Models\RekonsiliasiObat;
use App\Models\ErmRanapRencanaAsuhan;
use App\Models\AsesmenDokterRajal;
use App\Models\Kunjungan;

class PenunjangController extends Controller
{
    public function getPenunjang(Request $request)
    {
        $no_rm = $request->no_rm;
        $kodeunit = '3003';
        $data = [];
        $labpatologi = [];
        if ($no_rm) {
            // radiologi
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
        
            foreach ($kunjungans as $kunjungan) {
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

            // lab patologi
            $kodeunitLabs = '3020';
            $kunjunganLabs = Kunjungan::where('no_rm', $no_rm)->orderBy('tgl_masuk', 'desc')
                ->whereHas('layanans', function ($query) use ($kodeunitLabs) {
                    $query->where('kode_unit', $kodeunitLabs);
                })
                ->with([
                    'unit',
                    'pasien',
                    'layanans', 'layanans.layanan_details',
                    'layanans.layanan_details.tarif_detail',
                    'layanans.layanan_details.tarif_detail.tarif',
                ])
                ->get();
            foreach ($kunjunganLabs as $key => $kunjungan) {
                foreach ($kunjungan->layanans->where('kode_unit', 3020) as $key => $value) {
                    foreach ($value->layanan_details as $key => $laydet) {
                        $labpatologi[] = [
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

            // berkas
            $files      = FileRekamMedis::where('norm', $no_rm)->get();
            $fileupload = FileUpload::where('no_rm', $no_rm)->get();
        }
        return view('simrs.erm-ranap.penunjang.data_penunjang', compact('data','labpatologi','files','fileupload'));
    }

    public function kpoElektronik(Request $request)
    {
        return view('simrs.erm-ranap.penunjang.kpo_elektronik');
    }
    public function grouping(Request $request)
    {
        return view('simrs.erm-ranap.penunjang.grouping');
    }
    public function rekonsiliasiObat(Request $request)
    {
        $kunjungan      = Kunjungan::where('kode_kunjungan', $request->kode)->first();
        $rekonsiliasi   = RekonsiliasiObat::with(['detailRekonsiliasiObat'])->where('kode_kunjungan', $request->kode)->first();
        return view('simrs.erm-ranap.penunjang.rekonsiliasi_obat', compact('kunjungan','rekonsiliasi'));
    }
    public function rencanaAsuhanTerpadu(Request $request)
    {
        $kunjungan = Kunjungan::where('kode_kunjungan', $request->kode)->first();
        $rencana   = ErmRanapRencanaAsuhan::where('kode_kunjungan', $request->kode)->get();
        return view('simrs.erm-ranap.penunjang.rencana_asuhan_terpadu', compact('kunjungan','rencana'));
    }

    public function riwayatPoliklinik(Request $request)
    {
        $kunjungan = Kunjungan::with(['unit'])->where('no_rm', $request->no_rm)->orderBy('counter','desc')->get();
        $kodeKunjungan = $kunjungan->pluck('kode_kunjungan');
        $asesmenRajal = AsesmenDokterRajal::whereIn('id_kunjungan',$kodeKunjungan)->get();
        $semuaObat = collect();
        $semuaTindakan = collect();
        foreach ($kunjungan as $riwayat) {
            $asesmen = \DB::connection('mysql2')->select('CALL RINCIAN_BIAYA_FINAL(?, ?, ?, ?)', [
                $riwayat->no_rm,
                $riwayat->counter,
                '',
                '',
            ]);
            $obat = collect($asesmen)->where('KELOMPOK_TARIF', 'Obat & Bhp');
            $tindakan = collect($asesmen)->where('KELOMPOK_TARIF', 'Tindakan Medis');
            
            // Gabungkan obat yang ditemukan ke dalam koleksi semuaObat
            if ($obat->isNotEmpty()) {
                $semuaObat = $semuaObat->merge($obat->map(function ($item) use ($riwayat) {
                    return [
                        'NAMA_TARIF' => $item->NAMA_TARIF,
                        'kode_kunjungan' => $riwayat->kode_kunjungan, // Tambahkan kode_kunjungan ke setiap obat
                    ];
                }));
            }
            if ($tindakan->isNotEmpty()) {
                $semuaTindakan = $semuaTindakan->merge($tindakan->map(function ($item) use ($riwayat) {
                    return [
                        'NAMA_TARIF' => $item->NAMA_TARIF,
                        'kode_kunjungan' => $riwayat->kode_kunjungan, // Tambahkan kode_kunjungan ke setiap obat
                    ];
                }));
            }
        }
        
        return view('simrs.erm-ranap.penunjang.riwayat_poliklinik_pasien', compact('kunjungan','asesmenRajal','semuaObat','semuaTindakan'));
    }
}
