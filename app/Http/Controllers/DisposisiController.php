<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use RealRashid\SweetAlert\Facades\Alert;

class DisposisiController extends APIController
{
    public function index(Request $request)
    {
        if ($request->search) {
            $surats = SuratMasuk::orderBy('id_surat_masuk', 'desc')
                ->where(function ($query) use ($request) {
                    $query->where('asal_surat', "LIKE", "%" . $request->search . "%")
                        ->orWhere('perihal', "LIKE", "%" . $request->search . "%");
                })->paginate(25);
        } else {
            $surats = SuratMasuk::orderBy('id_surat_masuk', 'desc')
                ->paginate(25);
        }
        return view('simrs.bagum.disposisi_index', compact([
            'request',
            'surats',
        ]));
    }
    public function disposisi(Request $request)
    {
        try {
            $surats =  Cache::remember('surats' . $request->page, 60 * 60, function () {
                return SuratMasuk::orderBy('id_surat_masuk', 'desc')
                    ->paginate(1000);
            });
            return $this->sendResponse($surats);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), 400);
        }
    }
    public function create()
    {
        return view('simrs.bagum.disposisi_blanko_print');
    }
    public function show($id)
    {
        $surat = SuratMasuk::find($id);
        $pernyataan_direktur = null;
        $pernyataan_penerima = null;
        $nomor = str_pad($surat->no_urut, 3, '0', STR_PAD_LEFT) . '/' . $surat->kode . '/' . Carbon::parse($surat->tgl_disposisi)->translatedFormat('m/Y');
        if (isset($surat->ttd_direktur)) {
            $pernyataan_direktur = "E-Disposisi dengan nomor " . $nomor . " telah ditandatangani oleh Direktur RSUD Waled pada tanggal " . Carbon::parse($surat->ttd_direktur)->translatedFormat('l, d F Y  H:m:s');
        }
        if ($surat->tgl_terima_surat && $surat->tanda_terima) {
            $pernyataan_penerima = "E-Disposisi dengan nomor " . $nomor . " telah diterima dan ditandatangani oleh " . $surat->tanda_terima . " pada tanggal " . Carbon::parse($surat->tgl_terima_surat)->translatedFormat('l, d F Y H:m:s');
        }
        return view('simrs.bagum.disposisi_print', compact(['surat', 'pernyataan_direktur', 'pernyataan_penerima']));
    }
    public function edit($id)
    {
        $pernyataan_direktur = null;
        $pernyataan_penerima = null;
        $surat = SuratMasuk::find($id);
        if ($surat) {
            $nomor = str_pad($surat->no_urut, 3, '0', STR_PAD_LEFT) . '/' . $surat->kode . '/' . Carbon::parse($surat->tgl_disposisi)->translatedFormat('m/Y');
            if (isset($surat->ttd_direktur)) {
                $pernyataan_direktur = "E-Disposisi dengan nomor " . $nomor . " telah ditandatangani oleh Direktur RSUD Waled pada tanggal " . Carbon::parse($surat->ttd_direktur)->translatedFormat('l, d F Y  H:m:s');
            }
            if ($surat->tgl_terima_surat && $surat->tanda_terima) {
                $pernyataan_penerima = "E-Disposisi dengan nomor " . $nomor . " telah diterima dan ditandatangani oleh " . $surat->tanda_terima . " pada tanggal " . Carbon::parse($surat->tgl_terima_surat)->translatedFormat('l, d F Y H:m:s');
            }
            // dd($surat->tindakan);
            return view('simrs.bagum.disposisi_edit', compact([
                'surat',
                'nomor',
                'pernyataan_direktur',
                'pernyataan_penerima',
            ]));
        } else {
            Alert::error('Error', 'Kode Surat tidak ada');
            return redirect()->route('disposisi.index');
        }
    }
    // public function update(Request $request, $id)
    // {

    //     $tindakan = [];
    //     if (isset($request->tindaklanjuti)) {
    //         array_push($tindakan, "tindaklanjuti");
    //     }
    //     if (isset($request->proses_sesuai_kemampuan)) {
    //         array_push($tindakan, "proses_sesuai_kemampuan");
    //     }
    //     if (isset($request->untuk_dibantu)) {
    //         array_push($tindakan, "untuk_dibantu");
    //     }
    //     if (isset($request->pelajari)) {
    //         array_push($tindakan, "pelajari");
    //     }
    //     if (isset($request->wakili_hadiri)) {
    //         array_push($tindakan, "wakili_hadiri");
    //     }
    //     if (isset($request->agendakan)) {
    //         array_push($tindakan, "agendakan");
    //     }
    //     if (isset($request->ingatkan_waktunya)) {
    //         array_push($tindakan, "ingatkan_waktunya");
    //     }
    //     if (isset($request->siapkan_bahan)) {
    //         array_push($tindakan, "siapkan_bahan");
    //     }
    //     if (isset($request->simpan_arsipkan)) {
    //         array_push($tindakan, "simpan_arsipkan");
    //     }
    //     // ttd direktur
    //     if (isset($request->ttd_direktur)) {
    //         $request['ttd_direktur'] = now();
    //     }
    //     $surat = SuratMasuk::firstWhere('id_surat_masuk', $request->id_surat);

    //     $nomor = str_pad($surat->no_urut, 3, '0', STR_PAD_LEFT) . '/' . $surat->kode . '/' . Carbon::parse($surat->tgl_disposisi)->translatedFormat('m/Y');
    //     if ($request->disposisi && $request->pengolah) {
    //         $wa = new WhatsappController();
    //         $request['number'] = "120363115261279867@g.us";
    //         $request['message'] = "Telah diupdate Disposisi oleh *" . Auth::user()->name .  "*\n\n*No Surat :* " . $surat->no_surat . "\n*Asal Surat :* " . $surat->asal_surat . "\n*Perihal :* " . $surat->perihal . "\n\n*No Disposisi :* " . $nomor . "\n*Ditujukan Untuk :* " . $request->pengolah . "\n*Disposisi :* " . $request->disposisi . "\n\nSilahkan untuk mengeceknya dengan link berikut. \nhttp://sim.rsudwaled.id/simrs/bagianumum/suratmasuk";
    //         $wa->send_message_group($request);
    //     }

    //     $surat->update($request->all());
    //     Alert::success('Success', 'Disposisi Surat Berhasil Diupdate');
    //     return redirect()->back();
    // }
    // tambahan fitur hapus
    // public function destroy($id, Request $request)
    // {
    //     $surat = SuratMasuk::where('id_surat_masuk', $id)->first();
    //     $wa = new WhatsappController();
    //     $request['number'] = "120363115261279867@g.us";
    //     $request['message'] = "Telah dihapus disposisi surat oleh *" . Auth::user()->name .  "*\n\n*No Surat :* " . $surat->no_surat . "\n*Asal Surat :* " . $surat->asal_surat . "\n*Perihal :* " . $surat->perihal . "\n\nSilahkan untuk mengeceknya dengan link berikut. \nhttp://sim.rsudwaled.id/simrs/bagianumum/suratmasuk";
    //     $wa->send_message_group($request);
    //     $surat->delete();
    //     Alert::success('Success', 'Disposisi Surat Berhasil Dihapus');
    //     return redirect()->back();
    // }
}
