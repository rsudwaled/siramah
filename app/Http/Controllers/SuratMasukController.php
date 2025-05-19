<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class SuratMasukController extends Controller
{

    public function laporansuratmasukprint(Request $request)
    {
        $awalbulan = Carbon::parse($request->tanggal)->startOfMonth();
        $akhirbulan = Carbon::parse($request->tanggal)->endOfMonth();
        $suratmasuks = SuratMasuk::with(['lampiran'])
            ->whereBetween('created_at', [$awalbulan, $akhirbulan])
            ->get();
        // return view('livewire.print.pdf_laporan_suratmasuk', compact('suratmasuks'));
        $pdf = Pdf::loadView('livewire.print.pdf_laporan_suratmasuk', compact('suratmasuks', 'request'))
            ->setPaper('a4', 'landscape');
        return $pdf->stream('laporan_surat_masuk.pdf');

        dd($request->all(), $suratmasuks);
    }
    public function index(Request $request)
    {
        $surats = SuratMasuk::with(['lampiran'])
            ->orderBy('id_surat_masuk', 'desc')
            ->where(function ($query) use ($request) {
                if ($request->search) {
                    $query->where('asal_surat', "like", "%" . $request->search . "%")
                        ->orWhere('perihal', "like", "%" . $request->search . "%");
                }
            })->paginate(25);
        return view('simrs.bagum.suratmasuk_index', compact([
            'request',
            'surats',
        ]));
    }
    public function store(Request $request)
    {
        $request->validate([
            'no_surat' => 'required',
            'tgl_surat' => 'required|date',
            'asal_surat' => 'required',
            'perihal' => 'required',
            'sifat' => 'required',
            'tgl_disposisi' => 'required|date',
        ]);
        // setting no urut disposisi per bulan
        $tgl_disposisi = Carbon::parse($request->tgl_disposisi);
        $no_urut_bulan = SuratMasuk::whereYear('tgl_disposisi', $tgl_disposisi->year)
            ->whereMonth('tgl_disposisi', $tgl_disposisi->month)
            ->count();
        $request['no_urut'] = $no_urut_bulan + 1;
        // insert surat masuk
        $surat =  SuratMasuk::create([
            'no_urut' => $request->no_urut,
            'kode' => $request->kode,
            'sifat' => $request->sifat,
            'no_surat' => $request->no_surat,
            'tgl_surat' => $request->tgl_surat,
            'asal_surat' => $request->asal_surat,
            'perihal' => $request->perihal,
            'tgl_disposisi' => $request->tgl_disposisi,
            'user' => Auth::user()->name,
        ]);
        // notif wa
        $wa = new WhatsappController();
        // $request['message'] = "Telah diinput surat masuk oleh *" . Auth::user()->name .  "*\n\n*No Surat :* " . $request->no_surat . "\n*Asal Surat :* " . $request->asal_surat . "\n*Perihal :* " . $request->perihal . "\n\nSilahkan untuk mengeceknya dan men-disposisikan dapat diakses dengan link berikut. \nhttp://sim.rsudwaled.id:80/siramah/disposisi/" . $surat->id_surat_masuk . "/edit";
        // $request['number'] = "6287742641933@c.us"; #direktur
        // $wa->send_message($request);
        $request['number'] = "6289529909036@c.us"; #marwan
        $wa->send_message($request);
        $request['number'] = "6281214192200@c.us"; #lilis
        $wa->send_message($request);
        Alert::success('Success', 'Surat Masuk Berhasil Diinputkan');
        return redirect()->back();
    }
    public function show($id)
    {
        $surat = SuratMasuk::find($id);
        return response()->json($surat);
    }
    public function update(Request $request, $id)
    {
        if (isset($request->ttd_direktur)) {
            $request['ttd_direktur'] = now();
        }
        $surat = SuratMasuk::firstWhere('id_surat_masuk', $id);
        $nomor = str_pad($surat->no_urut, 3, '0', STR_PAD_LEFT) . '/' . $surat->kode . '/' . Carbon::parse($surat->tgl_disposisi)->translatedFormat('m/Y');
        if ($request->disposisi && $request->pengolah) {
            $wa = new WhatsappController();
            $request['message'] = "Telah diupdate Disposisi oleh *" . Auth::user()->name .  "*\n\n*No Surat :* " . $surat->no_surat . "\n*Asal Surat :* " . $surat->asal_surat . "\n*Perihal :* " . $surat->perihal . "\n\n*No Disposisi :* " . $nomor . "\n*Ditujukan Untuk :* " . $request->pengolah . "\n*Disposisi :* " . $request->disposisi . "\n\nSilahkan untuk mengeceknya dengan link berikut. \nhttp://sim.rsudwaled.id:80/siramah/disposisi/" . $surat->id_surat_masuk . "/edit";
            $request['number'] = "120363115261279867@g.us"; #group
            $wa->send_message_group($request);
            // $request['number'] = "089529909036@c.us";
            // $wa->send_message($request);
        }
        $surat->update($request->all());
        Alert::success('Success', 'Surat Berhasil Diupdate');
        return redirect()->back();
    }
    public function destroy($id, Request $request)
    {
        $surat = SuratMasuk::where('id_surat_masuk', $id)->first();
        $surat->delete();
        $wa = new WhatsappController();
        $request['message'] = "Telah dihapus surat masuk oleh *" . Auth::user()->name .  "*\n\n*No Surat :* " . $surat->no_surat . "\n*Asal Surat :* " . $surat->asal_surat . "\n*Perihal :* " . $surat->perihal . "\n\nSilahkan untuk mengeceknya dengan link berikut. \nhttp://sim.rsudwaled.id:80/siramah/disposisi";
        $request['number'] = "120363115261279867@g.us"; #group
        // $wa->send_message_group($request);
        // $wa->send_message($request);
        Alert::success('Success', 'Surat Berhasil Dihapus');
        return redirect()->back();
    }
}
