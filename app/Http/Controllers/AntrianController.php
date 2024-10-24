<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Dokter;
use App\Models\JadwalDokter;
use App\Models\JadwalOperasi;
use App\Models\Kunjungan;
use App\Models\Layanan;
use App\Models\LayananDetail;
use App\Models\OrderObatHeader;
use App\Models\Paramedis;
use App\Models\Pasien;
use App\Models\Penjamin;
use App\Models\Poliklinik;
use App\Models\SuratKontrol;
use App\Models\TarifLayananDetail;
use App\Models\Token;
use App\Models\Tracer;
use App\Models\Transaksi;
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use RealRashid\SweetAlert\Facades\Alert;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AntrianController extends APIController
{
    public $baseurl = "https://apijkn.bpjs-kesehatan.go.id/antreanrs/";
    public $consid =  "3431";
    public $secrekey = "7fI37884D3";
    public $userkey = "5986edae06e23458e9c3ccb8a23d9bb6";

    public function edit($id)
    {
        $antrian = Antrian::find($id);
        return response()->json($antrian);
    }
    public function selesaiPoliklinik(Request $request)
    {
        $now = now();
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        $request['kodebooking'] = $antrian->kodebooking;
        $request['taskid'] = 5;
        $request['waktu'] = $now;
        $res = $this->update_antrean($request);
        if ($res->metadata->code == 200) {
            $request['kodebooking'] = $antrian->kodebooking;
            $request['taskid'] = 5;
            $request['waktu'] = $now;
            $request['keterangan'] = "Selesai poliklinik";
            $antrian->update([
                'taskid' => $request->taskid,
                'status_api' => 1,
                'keterangan' => $request->keterangan,
                'user' => 'Sistem Siramah',
            ]);
            Alert::success('Success', $res->metadata->message);
        } else {
            Alert::error('Error', $res->metadata->message);
        }
        return redirect()->back();
    }
    public function displayantrianfarmasi($lantai)
    {
        return view('livewire.farmasi.display-antrian-farmasi', compact('lantai'));
    }
    public function displaynomorfarmasi($lantai)
    {
        if ($lantai == 2) {
            $unit = 4008;
        } else {
            $unit = 4002;
        }
        $orders = [];
        $tanggal = now()->format('Y-m-d');
        if ($tanggal && $unit) {
            $ordersx = OrderObatHeader::with(['pasien'])
                ->whereDate('tgl_entry', $tanggal)
                ->where('status_order', '!=', 0)
                ->where('status_order', '!=', 99)
                ->where('kode_unit', $unit)
                ->where('unit_pengirim', '!=', '1016')
                ->get();

            $orders = $ordersx;
        }
        if ($tanggal && $unit == 4002) {
            $orders_yasmin = OrderObatHeader::with(['pasien'])
                ->whereDate('tgl_entry',  $tanggal)
                ->where('status_order', '!=', 0)
                ->where('status_order', '!=', 99)
                ->where('unit_pengirim', '1016')
                ->get();
            $ordersx = $ordersx->merge($orders_yasmin);
            $orders = $ordersx;
        }
        $antrianpanggil = $orders->where('panggil', 1)->sortByDesc('updated_at')->first();
        $antriansudahpanggil = $orders->where('panggil', 2)->sortByDesc('updated_at')->first();
        // dd($antrianpanggil);
        // $farmasipanggil = Antrian::where('tanggalperiksa', now()->format('Y-m-d'))->where('taskid', 6)->first();
        // $antrianfarmasi = Antrian::where('tanggalperiksa', now()->format('Y-m-d'))->where('taskid', 6)->get(['nomorantrean', 'nama']);
        $data = [
            "nomorsudahpanggil" => $antriansudahpanggil ? substr($antriansudahpanggil->kode_layanan_header, -3) : '-',
            "namasudahpanggil" => $antriansudahpanggil ? $antriansudahpanggil->pasien?->nama_px : '-',
            "kodepanggil" => $antrianpanggil ? $antrianpanggil->id : '-',
            "nomorpanggil" => $antrianpanggil ? intval(substr($antrianpanggil->kode_layanan_header, -3))  : '-',
            "statuspanggil" => $antrianpanggil ?  $antrianpanggil->panggil : 0,
            "daftarantrian" => $orders->where('panggil', 0)->pluck('pasien.nama_px', 'kode_layanan_header'),
            "totalantrian" => $orders->count(),
        ];
        return $this->sendResponse($data, 200);
    }
    public function panggilnomorfarmasi(Request $request)
    {
        $antrian = OrderObatHeader::find($request->kodebooking);
        if ($antrian) {
            $antrian->update([
                'panggil' => 2,
            ]);
            return $this->sendResponse('Antrian telah dipanggil', 200);
        } else {
            return $this->sendError('Antrian tidak ditemukan', 400);
        }
    }
    public function antrianFarmasi(Request $request)
    {
        $antrians = null;
        if ($request->tanggal) {
            $request['tanggal'] = Carbon::now()->format('Y-m-d');
            $antrians = Antrian::whereDate('tanggalperiksa', $request->tanggal)
                ->where('taskid', '>=', 3)->get();
        }
        // $polis = PoliklinikDB::where('status', 1)->get();
        // $dokters = Dokter::get();
        return view('simrs.antrian_farmasi', [
            'antrians' => $antrians,
            'request' => $request,
            // 'polis' => $polis,
            // 'dokters' => $dokters,
        ]);
    }
    public function getAntrianFarmasi(Request $request)
    {
        if ($request->tanggal) {
            $antirans = Antrian::whereDate('tanggalperiksa', $request->tanggal)
                ->where('taskid', 5)
                ->where('status_api', 0)
                ->get()->count();

            if ($antirans == 0) {
                return $this->sendError('Tidak ada order',  404);
            }
            return $this->sendError($antirans, 200);
        } else {
            return $this->sendError('Tidak ada order',  404);
        }
    }
    public function racikFarmasi($kodebooking, Request $request)
    {
        $now = now();
        $antrian = Antrian::where('kodebooking', $kodebooking)->first();
        $request['kodebooking'] = $antrian->kodebooking;
        $request['taskid'] = 6;
        $request['waktu'] = $now;
        $res = $this->update_antrean($request);
        if ($res->metadata->code == 200) {
            $antrian->update([
                'taskid' => 6,
                'taskid6' => $now,
                'keterangan' => "Proses peracikan obat",
                'user' => 'Sistem Siramah',

            ]);
            Alert::success('Berhasil ',  $res->metadata->message);
        } else {
            Alert::error('Error ',  $res->metadata->message);
        }
        return redirect()->back();
    }
    public function selesaiFarmasi($kodebooking, Request $request)
    {
        $now = now();
        $antrian = Antrian::where('kodebooking', $kodebooking)->first();
        $request['kodebooking'] = $antrian->kodebooking;
        $request['taskid'] = 7;
        $request['waktu'] =  $now;
        $res = $this->update_antrean($request);
        if ($res->metadata->code == 200) {
            $antrian->update([
                'taskid' => 7,
                'taskid7' =>  $now,
                'keterangan' => "Selesai peracikan obat",
                'user' => 'Sistem Siramah',
            ]);
            Alert::success('Berhasil ',  $res->metadata->message);
        } else {
            Alert::error('Error ',  $res->metadata->message);
        }
        return redirect()->back();
    }
    public function daftarOnline(Request $request)
    {
        $rujukans = null;
        $suratkontrols = null;
        $polikliniks = Poliklinik::where('status', 1)->orderBy('namasubspesialis', 'asc')->get();
        $jadwals = null;
        $pasien = null;
        $vclaim = new VclaimController();
        $request['method'] = 'Whatsapp';
        if ($request->nik) {
            $pasien = Pasien::firstWhere('nik_bpjs', $request->nik);
            if ($pasien) {
                $pasien['no_hp'] = $request->nohp;
                // $pasien->update([]);
                Alert::success('Success', 'Data pasien ditemukan');
            } else {
                Alert::error('Maaf', 'Data pasien tidak ditemukan, silahkan daftar offline untuk pasien baru');
            }
        }
        if ($request->norm && $request->kodepoli && $request->tanggalperiksa && $request->jenispasien) {
            $hari = Carbon::parse($request->tanggalperiksa)->dayOfWeek;
            $jadwals = JadwalDokter::where('kodesubspesialis', $request->kodepoli)
                ->where('hari', $hari)->get();
            if ($jadwals->count() != 0) {
                Alert::success('Success', 'Tersedia jadwal dokter poliklinik dihari tsb.');
            } else {
                $jadwals = null;
                Alert::error('Maaf', 'Data jadwal poliklinik tidak tersedia dihari tsb.');
            }
            // pasien umum
            if ($request->jenispasien == "NON-JKN" && $request->kodedokter) {
                if ($jadwals) {
                    $jadwal = $jadwals->firstWhere('kodedokter', $request->kodedokter);
                    $request['jampraktek'] = $jadwal->jadwal;
                    $request['jeniskunjungan'] = 3;
                    $res = $this->ambil_antrian($request);
                    if ($res->metadata->code == 200) {
                        $kodebooking = $res->response->kodebooking;
                        Alert::success('Berhasil', 'Anda berhasil daftar rawat jalan dengan kodebooking ' . $kodebooking);
                        return redirect()->route('checkAntrian', [
                            'kodebooking' => $kodebooking
                        ]);
                    } else {
                        Alert::error('Maaf', $res->metadata->message);
                    }
                } else {
                    Alert::error('Maaf', 'Data jadwal poliklinik tidak tersedia dihari tsb.');
                }
            }
            // pasien bpjs
            if ($request->jenispasien == "JKN" && $request->jeniskunjungan) {
                switch ($request->jeniskunjungan) {
                    case '1':
                        $res = $vclaim->rujukan_peserta($request);
                        if ($res->metadata->code == 200) {
                            $rujukansx = $res->response->rujukan;
                            foreach ($rujukansx as  $rujukan) {
                                $hari = Carbon::parse($rujukan->tglKunjungan)->diffInDays(now());
                                if ($hari < 90) {
                                    $rujukans[] = $rujukan;
                                }
                            }
                            Alert::success('Success', 'Ditemukan surat rujukan');
                        }
                        break;

                    case '3':
                        $request['bulan'] = Carbon::parse($request->tanggalperiksa)->month;
                        $request['tahun'] = Carbon::parse($request->tanggalperiksa)->year;
                        $request['formatfilter'] = 2;
                        $res = $vclaim->suratkontrol_peserta($request);
                        if ($res->metadata->code == 200) {
                            $rujukansx = $res->response->list;
                            foreach ($rujukansx as  $rujukan) {
                                // $hari = Carbon::parse($rujukan->tglKunjungan)->diffInDays(now());
                                if ($rujukan->terbitSEP == 'Belum') {
                                    $suratkontrols[] = $rujukan;
                                }
                            }
                            Alert::success('Success', 'Ditemukan surat kontrol');
                        }
                        break;

                    case '4':
                        $res = $vclaim->rujukan_rs_peserta($request);
                        if ($res->metadata->code == 200) {
                            $rujukansx = $res->response->rujukan;
                            foreach ($rujukansx as  $rujukan) {
                                $hari = Carbon::parse($rujukan->tglKunjungan)->diffInDays(now());
                                if ($hari < 90) {
                                    $rujukans[] = $rujukan;
                                }
                            }
                            Alert::success('Success', 'Ditemukan surat rujukan');
                        }
                        break;

                    default:
                        Alert::error('Maaf', 'Silahkan pilih jenis kunjungan.');
                        break;
                }
                // rujukan
                if ($jadwals && $request->jeniskunjungan == 1  &&  $request->nomorreferensi && $request->kodedokter || $jadwals && $request->jeniskunjungan == 5  &&  $request->nomorreferensi && $request->kodedokter) {
                    $jadwal = $jadwals->firstWhere('kodedokter', $request->kodedokter);
                    $rujukan = collect($rujukans)->where('noKunjungan', $request->nomorreferensi)->first();
                    if ($jadwal->kodesubspesialis == $rujukan->poliRujukan->kode) {
                        $request['jampraktek'] = $jadwal->jadwal;
                        $res = $this->ambil_antrian($request);
                        if ($res->metadata->code == 200) {
                            $kodebooking = $res->response->kodebooking;
                            Alert::success('Berhasil', 'Anda berhasil daftar rawat jalan dengan kodebooking ' . $kodebooking);
                            return redirect()->route('checkAntrian', [
                                'kodebooking' => $kodebooking
                            ]);
                        } else {
                            Alert::error('Maaf', $res->metadata->message);
                        }
                    } else {
                        Alert::error('Maaf', 'Poliklinik rujukan anda berbeda dengan poliklinik pilihan anda.');
                    }
                }
                // surat kontrol
                else if ($jadwals && $request->jeniskunjungan == 3 &&  $request->nomorreferensi && $request->kodedokter) {
                    $jadwal = $jadwals->firstWhere('kodedokter', $request->kodedokter);
                    if ($jadwal) {
                        $suratkontrol = collect($suratkontrols)->where('noSuratKontrol', $request->nomorreferensi)->first();
                        if ($suratkontrol->tglRencanaKontrol == $request->tanggalperiksa) {
                            if ($jadwal->kodesubspesialis == $suratkontrol->poliTujuan) {
                                $request['jampraktek'] = $jadwal->jadwal;
                                $res = $this->ambil_antrian($request);
                                if ($res->metadata->code == 200) {
                                    $kodebooking = $res->response->kodebooking;
                                    Alert::success('Berhasil', 'Anda berhasil daftar rawat jalan dengan kodebooking ' . $kodebooking);
                                    return redirect()->route('checkAntrian', [
                                        'kodebooking' => $kodebooking
                                    ]);
                                } else {
                                    Alert::error('Maaf', $res->metadata->message);
                                }
                            } else {
                                Alert::error('Maaf', 'Poliklinik rujukan anda berbeda dengan poliklinik pilihan anda.');
                            }
                        } else {
                            Alert::error('Maaf', 'Tanggal kunjungan surat kontrol (' . $suratkontrol->tglRencanaKontrol . ') berbeda dengan tanggal periksa pilihan anda. Silahkan rubah tanggal kontrol anda jika telah terlewati waktunya.');
                        }
                    } else {
                        Alert::error('Maaf', 'Jadwal dokter tidak tersedia.');
                    }
                } else {
                    Alert::error('Maaf', 'Silahkan pilih nomor referensi dan jadwal dokter.');
                }
            }
        } else {
            if ($request->tanggalperiksa && $request->kodepoli == null ||  $request->tanggalperiksa && $request->jenispasien == null) {
                Alert::error('Maaf', 'Silahkan pilih jenis pasien dan poliklinik');
            }
        }

        return view('simrs.daftar_online', compact([
            'request',
            'rujukans',
            'polikliniks',
            'jadwals',
            'pasien',
            'suratkontrols'
        ]));
    }
    public function ambilAntrianWeb(Request $request)
    {
        $base = new BaseController();
        $validator = Validator::make($request->all(), [
            "nomorkartu" => "required|numeric|digits:13",
            "nik" => "required|numeric|digits:16",
            "nohp" => "required",
            "kodepoli" => "required",
            "norm" => "required",
            "tanggalperiksa" => "required",
            "kodedokter" => "required",
            // "nomorreferensi" => "numeric",
        ]);
        if ($validator->fails()) {
            return $base->sendError($validator->errors()->first(), 400);
        }
        if ($request->jenispasien == 'NON-JKN') {
            $request['jeniskunjungan'] = 3;
        }
        $request['method'] = 'Web';
        $hari = Carbon::parse($request->tanggalperiksa)->dayOfWeek;
        $jadwal = JadwalDokter::where('hari', $hari)
            ->where('kodesubspesialis', $request->kodepoli)
            ->where('kodedokter', $request->kodedokter)
            ->first();
        $request['jampraktek'] = $jadwal->jadwal;
        $res =  $this->ambil_antrian($request);

        if ($res->metadata->code == 200) {
            return $base->sendResponse($res->response, 200);
        } else {
            return $base->sendError($res->metadata->message);
        }
    }
    public function cekKodebooking(Request $request)
    {
        $antrian = Antrian::firstWhere('kodebooking', $request->kodebooking);
        $base = new BaseController();
        if ($antrian) {
            $taskid = [
                'Belum Checkin',
                'Menunggu Pendaftaran',
                'Proses Pendaftaran',
                'Menunggu Poliklinik',
                'Proses Poliklinik',
                'Menunggu Farmasi',
                'Proses Farmasi',
                'Selesai',
                99 => 'Batal'
            ];
            $response = [
                "nomorantrean" => $antrian->nomorantrean,
                "angkaantrean" => $antrian->angkaantrean,
                "kodebooking" => $antrian->kodebooking,
                "norm" =>  substr($antrian->norm, 2),
                "namapasien" => $antrian->nama,
                "jenispasien" => $antrian->jenispasien,
                "status" => $taskid[$antrian->taskid],
                "namapoli" => $antrian->namapoli,
                "namadokter" => $antrian->namadokter,
                "estimasidilayani" => $antrian->estimasidilayani,
                "keterangan" => $antrian->keterangan,
            ];
            return $base->sendResponse($response, 200);
        } else {
            return $base->sendError('Kodebooking tidak ditemukan', 404);
        }
    }
    public function checkAntrian(Request $request)
    {
        $antrian = null;
        if ($request->kodebooking) {
            $antrian = Antrian::firstWhere('kodebooking', $request->kodebooking);
        }
        return view('simrs.check_antrian', compact([
            'request',
            'antrian',
        ]));
    }
    public function statusAntrianBpjs()
    {
        $token = Token::latest()->first();
        return view('bpjs.antrian.status', compact([
            'token'
        ]));
    }
    public function laporanAntrianPoliklinik(Request $request)
    {
        if ($request->tanggal == null) {
            $tanggal_awal = now()->startOfDay()->format('Y-m-d');
            $tanggal_akhir = now()->endOfDay()->format('Y-m-d');
        } else {
            $tanggal = explode(' - ', $request->tanggal);
            $tanggal_awal = Carbon::parse($tanggal[0])->format('Y-m-d');
            $tanggal_akhir = Carbon::parse($tanggal[1])->format('Y-m-d');
        }
        $antrians = Antrian::whereBetween('tanggalperiksa', [$tanggal_awal, $tanggal_akhir])
            ->get();
        $kunjungans = Kunjungan::whereBetween('tgl_masuk', [Carbon::parse($tanggal_awal)->startOfDay(), Carbon::parse($tanggal_akhir)->endOfDay()])
            ->where('kode_unit', "!=", null)
            ->where('kode_unit', 'LIKE', '10%')
            ->where('kode_unit', '!=', 1002)
            ->where('kode_unit', "!=", 1023)
            ->where('kode_unit', "!=", 1015)
            ->get();
        $units = Unit::where('KDPOLI', '!=', null)->get();
        return view('simrs.laporan_kunjungan', [
            'antrians' => $antrians,
            'request' => $request,
            'kunjungans' => $kunjungans,
            'units' => $units,
        ]);
    }
    public function checkinUpdate(Request $request)
    {
        // checking request
        $validator = Validator::make($request->all(), [
            "kodebooking" => "required",
            "waktu" => "required|numeric",
        ]);
        if ($validator->fails()) {
            $response = [
                'metadata' => [
                    'code' => 400,
                    'message' => $validator->errors()->first(),
                ],
            ];
            return $response;
        }
        // cari antrian
        $antrian = Antrian::firstWhere('kodebooking', $request->kodebooking);
        if (isset($antrian)) {
            $api = new AntrianController();
            $response = $api->checkin_antrian($request);
            return $response;
        }
        // jika antrian tidak ditemukan
        else {
            return $response = [
                'metadata' => [
                    'code' => 400,
                    'message' => "Antrian tidak ditemukan",
                ],
            ];
        }
    }
    public function antrian(Request $request)
    {
        // get poli
        $response = $this->ref_poli();
        if ($response->metadata->code == 200) {
            $polikliniks = $response->response;
        } else {
            $polikliniks = null;
        }
        // get antrian
        $antrians = null;
        if (isset($request->kodepoli)) {
            $antrians = Antrian::whereDate('tanggalperiksa', $request->tanggal)->get();
            if ($request->kodepoli != '000') {
                $antrians = $antrians->where('kodepoli', $request->kodepoli);
            }
            Alert::success('OK', 'Antrian BPJS Total : ' . $antrians->count());
        }
        return view('bpjs.antrian.antrian', compact([
            'request',
            'polikliniks',
            'antrians',
        ]));
    }
    public function listTaskID(Request $request)
    {
        // get antrian
        $taskid = null;
        if (isset($request->kodebooking)) {
            $response =  $this->taskid_antrean($request);
            if ($response->metadata->code == 200) {
                $taskid = $response->response;
            }
            Alert::success($response->metadata->message . ' ' . $response->metadata->code);
        }
        return view('bpjs.antrian.list_task', compact([
            'request',
            'taskid',
        ]));
    }
    public function antrianCapaian(Request $request)
    {
        $antrians_total = Antrian::select(
            DB::raw("count(*) as total"),
            DB::raw("(DATE_FORMAT(created_at, '%Y-%m')) as bulan")
        )
            ->orderBy('created_at')
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->get();

        $tanggal_awal = Antrian::orderBy('tanggalperiksa', 'ASC')->first()->tanggalperiksa;
        $kunjungans = Kunjungan::whereBetween('tgl_masuk', [Carbon::parse($tanggal_awal)->startOfDay(), Carbon::now()->endOfDay()])
            ->where('kode_unit', "!=", null)
            ->where('kode_unit', 'LIKE', '10%')
            ->where('kode_unit', '!=', 1002)
            ->where('kode_unit', "!=", 1023)
            ->where('kode_unit', "!=", 1015)
            ->select(
                DB::raw("count(*) as total"),
                DB::raw("(DATE_FORMAT(tgl_masuk, '%Y-%m')) as bulan")
            )
            ->orderBy('tgl_masuk')
            ->groupBy(DB::raw("DATE_FORMAT(tgl_masuk, '%Y-%m')"))
            ->get();
        $antrian_nobatal = Antrian::where('taskid', '!=', 99)
            ->where('method', '!=', 'Offline')
            ->select(
                DB::raw("count(*) as total"),
                DB::raw("(DATE_FORMAT(created_at, '%Y-%m')) as bulan")
            )
            ->orderBy('created_at')
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->get();

        $antrian_selesai = Antrian::whereIn('taskid',  [5, 7])
            ->select(
                DB::raw("count(*) as total"),
                DB::raw("(DATE_FORMAT(created_at, '%Y-%m')) as bulan")
            )
            ->orderBy('created_at')
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->get();

        $antrian_whatsapp = Antrian::where('taskid', '!=', 99)
            ->whereIn('method', ['Whatsapp', 'ON'])
            ->select(
                DB::raw("count(*) as total"),
                DB::raw("(DATE_FORMAT(created_at, '%Y-%m')) as bulan")
            )
            ->orderBy('created_at')
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->get();


        $antrian_jkn = Antrian::where('taskid', '!=', 99)
            ->whereIn('method', ['JKN Mobile'])
            ->select(
                DB::raw("count(*) as total"),
                DB::raw("(DATE_FORMAT(created_at, '%Y-%m')) as bulan")
            )
            ->orderBy('created_at')
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->get();

        $antrian_lainnya = Antrian::where('taskid', '!=', 99)
            ->whereNotIn('method', ['JKN Mobile', 'Whatsapp', 'ON', 'OFF', 'Offline'])
            ->select(
                DB::raw("count(*) as total"),
                DB::raw("(DATE_FORMAT(created_at, '%Y-%m')) as bulan")
            )
            ->orderBy('created_at')
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->get();

        return view('simrs.pendaftaran.capaian_antrian', compact([
            // 'antrians_total',
            'antrian_nobatal',
            'antrian_selesai',
            'antrian_whatsapp',
            'antrian_jkn',
            'antrian_lainnya',
            'kunjungans',
            'request',
        ]));
    }
    public function dashboardTanggalAntrian(Request $request)
    {
        $antrians = null;
        $antrianx = null;
        if (isset($request->waktu)) {
            $antrianx = Antrian::whereDate('tanggalperiksa', '=', $request->tanggal)
                ->where('method', '!=', 'Offline')
                ->where('taskid', '!=', 99)
                ->where('taskid', '!=', 0)
                ->get();
            $response =  $this->dashboard_tanggal($request);
            if ($response->metadata->code == 200) {
                $antrians = collect($response->response->list);

                Alert::success($response->metadata->message . ' ' . $response->metadata->code);
            } else {
                Alert::error($response->metadata->message . ' ' . $response->metadata->code);
            }
        }
        return view('bpjs.antrian.dashboard_tanggal_index', compact([
            'request',
            'antrians',
            'antrianx',
        ]));
    }
    public function dashboardBulanAntrian(Request $request)
    {
        $antrians = null;
        $antrianx = null;
        if (isset($request->tanggal)) {
            $tanggal = explode('-', $request->tanggal);
            $request['tahun'] = $tanggal[0];
            $request['bulan'] = $tanggal[1];
            $response =  $this->dashboard_bulan($request);
            if ($response->metadata->code == 200) {
                $antrians = collect($response->response->list);
                $antrianx = Antrian::whereYear('tanggalperiksa', '=', $request->tahun)
                    ->whereMonth('tanggalperiksa', '=', $request->bulan)
                    ->where('method', '!=', 'Offline')
                    ->where('taskid', '!=', 99)
                    ->where('taskid', '!=', 0)
                    ->get();
                Alert::success($response->metadata->message . ' ' . $response->metadata->code);
            } else {
                Alert::error($response->metadata->message . ' ' . $response->metadata->code);
            }
        }
        return view('bpjs.antrian.dashboard_bulan_index', compact([
            'request',
            'antrians',
            'antrianx',
        ]));
    }
    public function antrianPerTanggal(Request $request)
    {
        $antrians = null;
        if (isset($request->tanggal)) {
            $response = $this->antrian_tanggal($request);
            if ($response->metadata->code == 200) {
                $antrians = $response->response;
            } else {
                Alert::error('Error ' . $response->metadata->code,  $response->metadata->message);
                return redirect()->route('bpjs.antrian.antrian_per_tanggal');
            }
        }
        return view('bpjs.antrian.antrian_per_tanggal', compact(['request', 'antrians']));
    }
    public function monitoringAntrian(Request $request)
    {
        $antrians = null;
        if (isset($request->tanggal)) {
            $response = $this->antrian_tanggal($request);
            if ($response->metadata->code == 200) {
                $antrians = $response->response;
                foreach ($antrians as $key => $value) {
                    $request['kodebooking'] = $value->kodebooking;
                    $taskid = $this->taskid_antrean($request);
                    if ($taskid->metadata->code == 200) {
                        $dataid = $taskid->response;
                        $value->taskid = $dataid;
                    } else {
                        $value->taskid = [];
                    }
                }
            } else {
                Alert::error('Error ' . $response->metadata->code,  $response->metadata->message);
            }
        }
        return view('bpjs.antrian.monitoring_antrian', compact(['request', 'antrians']));
    }
    public function antrianPerKodebooking(Request $request)
    {
        $antrian = null;
        if ($request->kodebooking) {
            $request['kodeBooking'] = $request->kodebooking;
            $response = $this->antrian_kodebooking($request);
            if ($response->metadata->code == 200) {
                $antrian = $response->response[0];
            } else {
                Alert::error('Error ' . $response->metadata->code,  $response->metadata->message);
                return redirect()->route('bpjs.antrian.antrian_per_tanggal');
            }
        }
        return view('bpjs.antrian.antrian_per_kodebooking', compact([
            'request',
            'antrian'
        ]));
    }
    public function antrianBelumDilayani(Request $request)
    {
        $request['tanggal'] = now()->format('Y-m-d');
        $response = $this->antrian_belum_dilayani($request);
        if ($response->metadata->code == 200) {
            $antrians = $response->response;
        } else {
            $antrians = null;
            Alert::error('Error ' . $response->metadata->code,  $response->metadata->message);
            return redirect()->route('antrian.laporan_tanggal');
        }
        return view('bpjs.antrian.antrian_belum_dilayani', compact(['request', 'antrians']));
    }
    public function antrianPerDokter(Request $request)
    {
        $antrians = null;
        $jadwaldokter = JadwalDokter::orderBy('hari', 'ASC')->get();
        if (isset($request->jadwaldokter)) {
            $jadwal = JadwalDokter::find($request->jadwaldokter);
            $request['kodePoli'] = $jadwal->kodesubspesialis;
            $request['kodeDokter'] = $jadwal->kodedokter;
            $request['hari'] = $jadwal->hari;
            $request['jamPraktek'] = $jadwal->jadwal;
            $response = $this->antrian_poliklinik($request);
            if ($response->metadata->code == 200) {
                $antrians = $response->response;
            } else {
                Alert::error('Error ' . $response->metadata->code,  $response->metadata->message);
            }
        }
        return view('bpjs.antrian.antrian_per_dokter', [
            'antrians' => $antrians,
            'jadwaldokter' => $jadwaldokter,
            'request' => $request,
        ]);
    }
    public function antrianPoliklinik(Request $request)
    {
        $antrians = null;
        if ($request->tanggal) {
            $antrians = Antrian::whereDate('tanggalperiksa', $request->tanggal);
            if ($request->kodepoli != null) {
                $antrians = Antrian::whereDate('tanggalperiksa', $request->tanggal)->where('method', '!=', 'Offline')->where('kodepoli', $request->kodepoli)->get();
            }
            if ($request->kodedokter != null) {
                $antrians = Antrian::whereDate('tanggalperiksa', $request->tanggal)->where('method', '!=', 'Offline')->where('kodepoli', $request->kodepoli)->where('kodedokter', $request->kodedokter)->get();
            }
            if ($request->kodepoli == null && $request->kodedokter == null) {
                $antrians = Antrian::whereDate('tanggalperiksa', $request->tanggal)->where('method', '!=', 'Offline')->get();
            }
        }
        $polis = Poliklinik::where('status', 1)->get();
        $dokters = Paramedis::where('kode_dokter_jkn', "!=", null)
            ->where('unit', "!=", null)
            ->get();
        if (isset($request->kodepoli)) {
            $poli = Unit::firstWhere('KDPOLI', $request->kodepoli);
            $dokters = Paramedis::where('unit', $poli->kode_unit)
                ->where('kode_dokter_jkn', "!=", null)
                ->get();
        }
        return view(
            'simrs.poliklinik.poliklinik_antrian',
            compact([
                'antrians',
                'request',
                'polis',
                'dokters'
            ])
        );
    }
    public function monitoringAntrianRajal(Request $request)
    {
        $antrians = null;
        if ($request->tanggal) {
            $antrians = Antrian::whereDate('tanggalperiksa', $request->tanggal);
            if ($request->kodepoli != null) {
                $antrians = Antrian::whereDate('tanggalperiksa', $request->tanggal)->where('method', '!=', 'Offline')->where('kodepoli', $request->kodepoli)->get();
            }
            if ($request->kodedokter != null) {
                $antrians = Antrian::whereDate('tanggalperiksa', $request->tanggal)->where('method', '!=', 'Offline')->where('kodepoli', $request->kodepoli)->where('kodedokter', $request->kodedokter)->get();
            }
            if ($request->kodepoli == null && $request->kodedokter == null) {
                $antrians = Antrian::whereDate('tanggalperiksa', $request->tanggal)->where('method', '!=', 'Offline')->get();
            }
        }
        $polis = Poliklinik::where('status', 1)->get();
        $dokters = Paramedis::where('kode_dokter_jkn', "!=", null)
            ->where('unit', "!=", null)
            ->get();
        if (isset($request->kodepoli)) {
            $poli = Unit::firstWhere('KDPOLI', $request->kodepoli);
            $dokters = Paramedis::where('unit', $poli->kode_unit)
                ->where('kode_dokter_jkn', "!=", null)
                ->get();
        }
        return view(
            'simrs.poliklinik.monitoring_antrian',
            compact([
                'antrians',
                'request',
                'polis',
                'dokters'
            ])
        );
    }

    public function batalAntrian(Request $request)
    {
        $request['taskid'] = 99;
        $request['keterangan'] = "Mohon maaf antrian anda dengan kodebooking " . $request->kodebooking . " dibatalkan karena akan ada perubahan jadwal dokter dihari tersebut.";
        $response = $this->batal_antrian($request);
        if ($response->metadata->code == 200) {
            Alert::success('Success ' . $response->metadata->code, $response->metadata->message);
        } else {
            Alert::error('Error ' . $response->metadata->code, $response->metadata->message);
        }
        return redirect()->back();
    }
    public function batalPendaftaran(Request $request)
    {
        $request['taskid'] = 99;
        $request['keterangan'] = "Antrian dibatalkan oleh pasien";
        $response = $this->batal_antrian($request);
        if ($response->metadata->code == 200) {
            Alert::success('Success ' . $response->metadata->code, $response->metadata->message);
        } else {
            Alert::error('Error ' . $response->metadata->code, $response->metadata->message);
        }
        return redirect()->back();
    }
    public function panggilPoliklinik(Request $request)
    {
        $now = now();
        $antrian = Antrian::firstWhere('kodebooking', $request->kodebooking);
        $request['kodebooking'] = $antrian->kodebooking;
        $request['taskid'] = 3;
        if ($antrian->taskid3) {
            $request['waktu'] = Carbon::createFromFormat('Y-m-d H:i:s', $antrian->taskid3, 'Asia/Jakarta');
        } else {
            $request['waktu'] = $now;
            $antrian->update([
                'taskid3' =>  $request->waktu,
                'user3' => auth()->user()->name,
            ]);
        }
        $res = $this->update_antrean($request);
        $request['kodebooking'] = $antrian->kodebooking;
        $request['taskid'] = 4;
        $request['waktu'] = $now;
        $res = $this->update_antrean($request);
        if ($res->metadata->code == 200 || $res->metadata->message == "TaskId=4 sudah ada") {
            $antrian->update([
                'taskid' => 4,
                'taskid4' =>  $now,
                'sync_panggil' => 0,
                'status_api' => 0,
                'user3' => auth()->user()->name,
                'keterangan' => "Panggilan ke poliklinik yang anda pilih",
            ]);
            Alert::success('Success', 'Panggil Pasien Berhasil');
        } else {
            Alert::error('Error', $res->metadata->message);
        }
        return redirect()->back();
    }

    public function panggilBridgingPoliklinik(Request $request)
    {
        dd('test');
        $request['taskid'] = 4;
        $request['keterangan'] = "Panggilan ke poliklinik yang anda pilih";
        $request['waktu'] = now()->timestamp * 1000;
        $antrian = Antrian::firstWhere('kodebooking', $request->kodebooking);
        $vclaim = new AntrianController();
        $response = $vclaim->update_antrean($request);
        $antrian->update([
            'taskid' => $request->taskid,
            'status_api' => 1,
            'keterangan' => $request->keterangan,
            'user' => 'Sistem Siramah',
        ]);
        if ($response->metadata->code == 200) {
            // try {
            //     // notif wa
            //     $wa = new WhatsappController();
            //     $request['message'] = "Panggilan antrian atas nama pasien " . $antrian->nama . " dengan nomor antrean " . $antrian->nomorantrean . " untuk segera dilayani di POLIKLINIK " . $antrian->namapoli;
            //     $request['number'] = $antrian->nohp;
            //     $wa->send_message($request);
            // } catch (\Throwable $th) {
            //     //throw $th;
            // }
            Alert::success('Success', 'Panggil Pasien Berhasil');
        } else {
            Alert::error('Error ' . $response->metadata->code, $response->metadata->message);
        }
        return redirect()->back();
    }
    public function panggilUlangPoliklinik(Request $request)
    {
        $request['taskid'] = 4;
        $request['keterangan'] = "Panggilan ke poliklinik yang anda pilih";
        $request['waktu'] = now()->timestamp * 1000;
        // try {
        //     // notif wa
        //     $wa = new WhatsappController();
        //     $request['message'] = "Panggilan ulang antrian atas nama pasien " . $antrian->nama . " dengan nomor antrean " . $antrian->nomorantrean . " untuk segera dilayani di POLIKLINIK " . $antrian->namapoli;
        //     $request['number'] = $antrian->nohp;
        //     $wa->send_message($request);
        // } catch (\Throwable $th) {
        //     //throw $th;
        // }
        Alert::success('Success', 'Panggil Pasien Berhasil');
        return redirect()->back();
    }
    public function lanjutFarmasi(Request $request)
    {
        $now = now();
        $antrian = Antrian::firstWhere('kodebooking', $request->kodebooking);
        $request['kodebooking'] = $antrian->kodebooking;
        $request['jenisresep'] = 'non racikan';
        $request['kodebooking'] = $antrian->kodebooking;
        $request['taskid'] = 5;
        $request['waktu'] = now();
        $res = $this->update_antrean($request);
        if ($res->metadata->code == 200 || $res->metadata->message == "TaskId=5 sudah ada") {
            $antrian->update([
                'taskid' => 5,
                'taskid5' => $now,
                'status_api' => 0,
                'keterangan' => "Silahkan tunggu di farmasi untuk pengambilan obat.",
                'user' => 'Sistem Siramah',
            ]);
            Alert::success('Success', 'Pasien Dilanjutkan Ke Farmasi');
        } else {
            Alert::error('Error', $res->metadata->message);
        }
        // $api = new AntrianController();
        // $response = $api->ambil_antrian_farmasi($request);
        return redirect()->back();
    }
    public function lanjutFarmasiRacikan(Request $request)
    {
        $now = now();
        $antrian = Antrian::firstWhere('kodebooking', $request->kodebooking);
        $request['kodebooking'] = $antrian->kodebooking;
        $request['jenisresep'] = 'racikan';
        $request['kodebooking'] = $antrian->kodebooking;
        $request['taskid'] = 5;
        $request['waktu'] = now();
        $res = $this->update_antrean($request);
        if ($res->metadata->code == 200 || $res->metadata->message == "TaskId=5 sudah ada") {
            $antrian->update([
                'taskid' => 5,
                'taskid5' => $now,
                'status_api' => 0,
                'keterangan' => "Silahkan tunggu di farmasi untuk pengambilan obat.",
                'user' => 'Sistem Siramah',
            ]);
            Alert::success('Success', 'Pasien Dilanjutkan Ke Farmasi');
        } else {
            Alert::error('Error', $res->metadata->message);
        }
        // $api = new AntrianController();
        // $response = $api->ambil_antrian_farmasi($request);
        return redirect()->back();
    }
    public function antrianBpjs(Request $request)
    {
        // get poli
        $response = $this->ref_poli();
        if ($response->metadata->code == 200) {
            $polikliniks = $response->response;
        } else {
            $polikliniks = null;
        }
        // get antrian
        $antrians = null;
        if (isset($request->kodepoli)) {
            $antrians = Antrian::whereDate('tanggalperiksa', $request->tanggal)->get();
            if ($request->kodepoli != '000') {
                $antrians = $antrians->where('kodepoli', $request->kodepoli);
            }
            Alert::success('OK', 'Antrian BPJS Total : ' . $antrians->count());
        }
        return view('bpjs.antrian.antrian', compact([
            'request',
            'polikliniks',
            'antrians',
        ]));
    }
    public function daftarBridgingAntrian(Request $request)
    {
        $request['method'] = 'Bridging';
        $res =  $this->ambil_antrian($request);
        if ($res->metadata->code == 200) {
            $request['taskid'] = 3;
            $request['waktu'] = now()->timestamp * 1000;
            $res = $this->update_antrean_pendaftaran($request);
            return redirect()->route('antrianPendaftaran', [
                'loket' => $request->loket,
                'lantai' => $request->lantai,
                'tanggal' => $request->tanggalperiksa,
                'jenispasien' => $request->jenispasien,
            ]);
        } else {
            Alert::error('Error', $res->metadata->message);
            return redirect()->back()->withErrors($res->metadata->message);
        }
    }
    public function selanjutnyaPendaftaran($loket, $lantai, $jenispasien, $tanggal, Request $request)
    {
        $antrian = Antrian::whereDate('tanggalperiksa', $tanggal)
            ->where('jenispasien', $jenispasien)
            ->where('method', 'Offline')
            ->where('taskid', 0)
            ->where('lantaipendaftaran', $request->lantai)
            ->first();
        if ($antrian) {
            $request['kodebooking'] = $antrian->kodebooking;
            $request['taskid'] = 2;
            $request['waktu'] = Carbon::now()->timestamp * 1000;
            $antrian->update([
                'taskid' => 2,
                'loket' => $request->loket,
                'status_api' => 0,
                'keterangan' => "Panggilan ke loket pendaftaran",
                'taskid2' => now(),
                'user' => 'Sistem Siramah',
            ]);
            //panggil urusan mesin antrian
            try {
                // notif wa
                // $wa = new WhatsappController();
                // $request['message'] = "Panggilan antrian atas nama pasien " . $antrian->nama . " dengan nomor antrian " . $antrian->angkaantrean . "/" . $antrian->nomorantrean . " untuk melakukan pendaftaran di Loket " . $loket . " Lantai " . $lantai;
                // $request['number'] = $antrian->nohp;
                // $wa->send_message($request);
                $tanggal = now()->format('Y-m-d');
                $urutan = $antrian->angkaantrean;
                if ($antrian->jenispasien == 'JKN') {
                    $tipeloket = 'BPJS';
                } else {
                    $tipeloket = 'UMUM';
                }
                $mesin_antrian = DB::connection('mysql3')->table('tb_counter')
                    ->where('tgl', $tanggal)
                    ->where('kategori', $tipeloket)
                    ->where('loket', $loket)
                    ->where('lantai', $lantai)
                    ->get();
                if ($mesin_antrian->count() < 1) {
                    $mesin_antrian = DB::connection('mysql3')->table('tb_counter')->insert([
                        'tgl' => $tanggal,
                        'kategori' => $tipeloket,
                        'loket' => $loket,
                        'counterloket' => $urutan,
                        'lantai' => $lantai,
                        'mastercount' => $urutan,
                        'sound' => 'PLAY',
                    ]);
                } else {
                    DB::connection('mysql3')->table('tb_counter')
                        ->where('tgl', $tanggal)
                        ->where('kategori', $tipeloket)
                        ->where('loket', $loket)
                        ->where('lantai', $lantai)
                        ->limit(1)
                        ->update([
                            // 'counterloket' => $antrian->first()->mastercount + 1,
                            'counterloket' => $urutan,
                            // 'mastercount' => $antrian->first()->mastercount + 1,
                            'mastercount' => $urutan,
                            'sound' => 'PLAY',
                        ]);
                }
            } catch (\Throwable $th) {
                Alert::error('Error', $th->getMessage());
                return redirect()->back();
            }
            Alert::toast('Panggilan Berhasil', 'success');
            return redirect()->back();
        } else {
            Alert::error('Error', 'Kode Booking tidak ditemukan');
            return redirect()->back();
        }
    }
    public function panggilPendaftaran($kodebooking, $loket, $lantai, Request $request)
    {
        $antrian = Antrian::where('kodebooking', $kodebooking)->first();
        if ($antrian) {
            $request['kodebooking'] = $antrian->kodebooking;
            $request['taskid'] = 2;
            $now = Carbon::now();
            $request['waktu'] = Carbon::now()->timestamp * 1000;
            $antrian->update([
                'taskid' => 2,
                'loket' => $request->loket,
                'status_api' => 1,
                'loket' => $request->loket,
                'keterangan' => "Panggilan ke loket pendaftaran",
                'taskid2' => $now,
                'user' => 'Sistem Siramah',
            ]);
            //panggil urusan mesin antrian
            try {
                // notif wa
                // $wa = new WhatsappController();
                // $request['message'] = "Panggilan antrian atas nama pasien " . $antrian->nama . " dengan nomor antrian " . $antrian->angkaantrean . "/" . $antrian->nomorantrean . " untuk melakukan pendaftaran di Loket " . $loket . " Lantai " . $lantai;
                // $request['number'] = $antrian->nohp;
                // $wa->send_message($request);
                $tanggal = now()->format('Y-m-d');
                $urutan = $antrian->angkaantrean;
                if ($antrian->jenispasien == 'JKN') {
                    $tipeloket = 'BPJS';
                } else {
                    $tipeloket = 'UMUM';
                }
                $mesin_antrian = DB::connection('mysql3')->table('tb_counter')
                    ->where('tgl', $tanggal)
                    ->where('kategori', $tipeloket)
                    ->where('loket', $loket)
                    ->where('lantai', $lantai)
                    ->get();
                if ($mesin_antrian->count() < 1) {
                    $mesin_antrian = DB::connection('mysql3')->table('tb_counter')->insert([
                        'tgl' => $tanggal,
                        'kategori' => $tipeloket,
                        'loket' => $loket,
                        'counterloket' => $urutan,
                        'lantai' => $lantai,
                        'mastercount' => $urutan,
                        'sound' => 'PLAY',
                    ]);
                } else {
                    DB::connection('mysql3')->table('tb_counter')
                        ->where('tgl', $tanggal)
                        ->where('kategori', $tipeloket)
                        ->where('loket', $loket)
                        ->where('lantai', $lantai)
                        ->limit(1)
                        ->update([
                            // 'counterloket' => $antrian->first()->mastercount + 1,
                            'counterloket' => $urutan,
                            // 'mastercount' => $antrian->first()->mastercount + 1,
                            'mastercount' => $urutan,
                            'sound' => 'PLAY',
                        ]);
                }
            } catch (\Throwable $th) {
                Alert::toast('Error', $th->getMessage());
                return redirect()->back();
            }
            Alert::toast('Panggilan Berhasil', 'success');
            return redirect()->back();
        } else {
            Alert::error('Error', 'Kode Booking tidak ditemukan');
            return redirect()->back();
        }
    }
    public function selesaiPendaftaran(Request $request)
    {
        $antrian = Antrian::where('kodebooking', $request->kodebooking)->first();
        $request['kodebooking'] = $antrian->kodebooking;
        $request['taskid'] = 3;
        $request['waktu'] = Carbon::now()->timestamp * 1000;

        if ($antrian->jenispasien == 'JKN') {
            $request['keterangan'] = "Silahkan menunggu dipoliklinik";
            $request['status_api'] = 1;
        } else {
            $request['keterangan'] = "Silahkan lakukan pembayaran di Loket Pembayaran, setelah itu dapat menunggu dipoliklinik";
            $request['status_api'] = 0;
        }
        // $response = $vclaim->update_antrean($request);
        // if ($response->metadata->code == 200) {
        // } else {
        //     Alert::error('Error ' . $response->metadata->code, $response->metadata->message);
        // }
        $antrian->update([
            'taskid' => $request->taskid,
            'status_api' => $request->status_api,
            'keterangan' => $request->keterangan,
            'user' => 'Sistem Siramah',
        ]);
        // try {
        //     // notif wa
        //     $wa = new WhatsappController();
        //     $request['message'] = "Anda berhasil di daftarkan atas nama pasien " . $antrian->nama . " dengan nomor antrean " . $antrian->nomorantrean . " telah selesai. " . $request->keterangan;
        //     $request['number'] = $antrian->nohp;
        //     $wa->send_message($request);
        // } catch (\Throwable $th) {
        //     //throw $th;
        // }
        Alert::toast('Pasien diteruskan ke poliklinik', 'success');
        return redirect()->back();
    }
    public function kunjunganPoliklinik(Request $request)
    {
        $kunjungans = null;
        $surat_kontrols = null;

        if ($request->kodepoli == null) {
            $unit = Unit::where('KDPOLI', "!=", null)
                ->where('KDPOLI', "!=", "")
                ->get();
            $dokters = Paramedis::where('kode_dokter_jkn', "!=", null)
                ->where('unit', "!=", null)
                ->get();
        } else {
            $unit = Unit::where('KDPOLI', "!=", null)
                ->where('KDPOLI', "!=", "")
                ->get();
            $poli =   Unit::firstWhere('KDPOLI', $request->kodepoli);
            $dokters = Paramedis::where('unit', $poli->kode_unit)
                ->where('kode_dokter_jkn', "!=", null)
                ->get();
        }
        if ($request->tanggal) {
            if ($request->kodepoli != null) {
                $kunjungans = Kunjungan::whereDate('tgl_masuk', $request->tanggal)
                    ->where('kode_unit', $poli->kode_unit)
                    ->where('status_kunjungan', "!=", 8)
                    ->with(['dokter', 'unit', 'pasien', 'order_obat_header', 'surat_kontrol', 'antrian'])
                    ->get();
            } else {
                $kunjungans = Kunjungan::whereDate('tgl_masuk', $request->tanggal)
                    ->where('status_kunjungan', "!=", 8)
                    ->where('kode_unit', "!=", null)
                    ->where('kode_unit', 'LIKE', '10%')
                    ->where('kode_unit', "!=", 1002)
                    ->where('kode_unit', "!=", 1023)
                    ->with(['dokter', 'unit', 'pasien', 'order_obat_header', 'surat_kontrol', 'antrian'])
                    ->get();
            }
        }

        return view('simrs.poliklinik.poliklinik_suratkontrol', compact([
            'kunjungans',
            'request',
            'unit',
            'dokters',
            'surat_kontrols',
        ]));
    }
    public function kunjunganrajal(Request $request)
    {
        $kunjungans = null;
        $unit = Unit::where('KDPOLI', "!=", null)
            ->where('KDPOLI', "!=", "")
            ->get();
        $dokters = Paramedis::where('kode_dokter_jkn', "!=", null)
            ->where('unit', "!=", null)
            ->get();
        if ($request->tgl_masuk) {
            if ($request->kode_unit == "-") {
                $kunjungans = Kunjungan::whereDate('tgl_masuk', $request->tgl_masuk)
                    ->where('status_kunjungan', "!=", 8)
                    ->where('kode_unit', "!=", null)
                    ->where('kode_unit', 'LIKE', '10%')
                    ->where('kode_unit', "!=", 1002)
                    ->where('kode_unit', "!=", 1023)
                    ->with(['dokter', 'penjamin_simrs', 'unit', 'order_obat_header', 'pasien', 'antrian', 'surat_kontrol',])
                    ->get();
            } else {
                $kunjungans = Kunjungan::whereDate('tgl_masuk', $request->tgl_masuk)->where('kode_unit', $request->kode_unit)
                    ->where('status_kunjungan', "!=", 8)
                    ->with(['dokter', 'penjamin_simrs', 'unit', 'order_obat_header', 'pasien', 'antrian', 'surat_kontrol',])
                    ->get();
                $dokters =  $dokters->where('unit',  $request->kode_unit);
            }
            if ($request->kode_paramedis != "-") {
                $kunjungans = $kunjungans->where('kode_paramedis', $request->kode_paramedis);
            }
        }
        return view('simrs.rajal.kunjungan_rajal', compact([
            'kunjungans',
            'request',
            'unit',
            'dokters',
        ]));
    }
    public function ermrajal(Request $request)
    {
        $kunjungan = Kunjungan::with(['pasien', 'antrian', 'alasan_masuk', 'unit', 'dokter', 'penjamin_simrs', 'status', 'surat_kontrol'])->firstWhere('kode_kunjungan', $request->kode);
        $pasien = $kunjungan->pasien;
        return view('simrs.rajal.erm_rajal', compact('kunjungan', 'pasien'));
    }
    public function get_kunjungan_rajal(Request $request)
    {
        $data = [];
        if ($request->tgl_masuk) {
            if ($request->kode_unit != null) {
                $kunjungans = Kunjungan::whereDate('tgl_masuk', $request->tgl_masuk)
                    ->where('kode_unit', $request->kode_unit)
                    ->where('status_kunjungan', "!=", 8)
                    ->with(['unit', 'pasien', 'surat_kontrol', 'penjamin_simrs', 'antrian'])
                    ->get();
            } else {
                $kunjungans = Kunjungan::whereDate('tgl_masuk', $request->tgl_masuk)
                    ->where('status_kunjungan', "!=", 8)
                    ->where('kode_unit', "!=", null)
                    ->where('kode_unit', 'LIKE', '10%')
                    ->where('kode_unit', "!=", 1002)
                    ->where('kode_unit', "!=", 1023)
                    ->with(['unit', 'pasien', 'surat_kontrol', 'penjamin_simrs', 'antrian'])
                    ->get();
            }
        }
        if ($kunjungans) {
            foreach ($kunjungans as $key => $kunjungan) {
                $data[] = [
                    'kode_kunjungan' => $kunjungan->kode_kunjungan,
                    'tgl_masuk' => $kunjungan->tgl_masuk,
                    'nama_px' => $kunjungan->pasien->nama_px,
                    'no_rm' => $kunjungan->pasien->no_rm,
                    'no_Bpjs' => $kunjungan->pasien->no_Bpjs,
                    'no_sep' => $kunjungan->no_sep,
                    'nama_unit' => $kunjungan->unit->nama_unit,
                    'penjamin' => $kunjungan->penjamin_simrs->nama_penjamin,
                    // 'antrian' => $kunjungan->antrian,
                    'kodebooking' => $kunjungan->antrian->kodebooking ?? null,
                    'surat_kontrol' => $kunjungan->surat_kontrol,
                ];
            }
        }
        return $this->sendResponse($data);
    }
    // API FUNCTION
    public function signature()
    {
        $cons_id =  $this->consid;
        $secretKey = $this->secrekey;
        $userkey = $this->userkey;
        date_default_timezone_set('UTC');
        $tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
        $signature = hash_hmac('sha256', $cons_id . "&" . $tStamp, $secretKey, true);
        $encodedSignature = base64_encode($signature);
        $data['user_key'] =  $userkey;
        $data['x-cons-id'] = $cons_id;
        $data['x-timestamp'] = $tStamp;
        $data['x-signature'] = $encodedSignature;
        $data['decrypt_key'] = $cons_id . $secretKey . $tStamp;
        return $data;
    }
    public function stringDecrypt($key, $string)
    {
        $encrypt_method = 'AES-256-CBC';
        $key_hash = hex2bin(hash('sha256', $key));
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
        $output = \LZCompressor\LZString::decompressFromEncodedURIComponent($output);
        return $output;
    }
    public function response_decrypt($response, $signature)
    {
        $code = json_decode($response->body())->metadata->code;
        $message = json_decode($response->body())->metadata->message;
        if ($code == 200 || $code == 1) {
            $response = json_decode($response->body())->response ?? null;
            $decrypt = $this->stringDecrypt($signature['decrypt_key'], $response);
            $data = json_decode($decrypt);
            if ($code == 1)
                $code = 200;
            return $this->sendResponse($data, $code);
        } else {
            $response = json_decode($response);
            return json_decode(json_encode($response));
        }
    }
    public function response_no_decrypt($response)
    {
        $response = json_decode($response);
        return json_decode(json_encode($response));
    }
    // API BPJS
    public function ref_poli()
    {
        $url = $this->baseurl . "ref/poli";
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function ref_dokter()
    {
        $url = $this->baseurl . "ref/dokter";
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function ref_jadwal_dokter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "kodepoli" => "required",
            "tanggal" =>  "required|date",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "jadwaldokter/kodepoli/" . $request->kodepoli . "/tanggal/" . $request->tanggal;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function ref_poli_fingerprint()
    {
        $url = $this->baseurl . "ref/poli/fp";
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function ref_pasien_fingerprint(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "identitas" => "required",
            "noidentitas" =>  "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),  400);
        }
        $url = $this->baseurl . "ref/pasien/fp/identitas/" . $request->identitas . "/noidentitas/" . $request->noidentitas;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function update_jadwal_dokter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "kodepoli" =>  "required",
            "kodesubspesialis" =>  "required",
            "kodedokter" =>  "required",
            "jadwal" =>  "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), $validator->errors(), 400);
        }
        $url = $this->baseurl . "jadwaldokter/updatejadwaldokter";
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->post(
            $url,
            [
                "kodepoli" => $request->kodepoli,
                "kodesubspesialis" => $request->kodesubspesialis,
                "kodedokter" => $request->kodedokter,
                "jadwal" => $request->jadwal,
            ]
        );
        return $this->response_decrypt($response, $signature);
    }
    public function tambah_antrean(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "kodebooking" => "required",
            "nomorkartu" =>  "required|digits:13|numeric",
            // "nomorreferensi" =>  "required",
            "nik" =>  "required|digits:16|numeric",
            "nohp" => "required|numeric",
            "kodepoli" =>  "required",
            "norm" =>  "required",
            "pasienbaru" =>  "required",
            "tanggalperiksa" =>  "required|date|date_format:Y-m-d",
            "kodedokter" =>  "required",
            "jampraktek" =>  "required",
            "jeniskunjungan" => "required",
            "jenispasien" =>  "required",
            "namapoli" =>  "required",
            "namadokter" =>  "required",
            "nomorantrean" =>  "required",
            "angkaantrean" =>  "required",
            "estimasidilayani" =>  "required",
            "sisakuotajkn" =>  "required",
            "kuotajkn" => "required",
            "sisakuotanonjkn" => "required",
            "kuotanonjkn" => "required",
            "keterangan" =>  "required",
            "nama" =>  "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),  400);
        }
        $url = $this->baseurl . "antrean/add";
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->post(
            $url,
            [
                "kodebooking" => $request->kodebooking,
                "jenispasien" => $request->jenispasien,
                "nomorkartu" => $request->nomorkartu,
                "nik" => $request->nik,
                "nohp" => $request->nohp,
                "kodepoli" => $request->kodepoli,
                "namapoli" => $request->namapoli,
                "pasienbaru" => $request->pasienbaru,
                "norm" => $request->norm,
                "tanggalperiksa" => $request->tanggalperiksa,
                "kodedokter" => $request->kodedokter,
                "namadokter" => $request->namadokter,
                "jampraktek" => $request->jampraktek,
                "jeniskunjungan" => $request->jeniskunjungan,
                "nomorreferensi" => $request->nomorreferensi,
                "nomorantrean" => $request->nomorantrean,
                "angkaantrean" => $request->angkaantrean,
                "estimasidilayani" => $request->estimasidilayani,
                "sisakuotajkn" => $request->sisakuotajkn,
                "kuotajkn" => $request->kuotajkn,
                "sisakuotanonjkn" => $request->sisakuotanonjkn,
                "kuotanonjkn" => $request->kuotanonjkn,
                "keterangan" => $request->keterangan,
            ]
        );
        return $this->response_decrypt($response, $signature);
    }
    public function tambah_antrean_farmasi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "kodebooking" => "required",
            "jenisresep" =>  "required",
            "nomorantrean" =>  "required",
            "keterangan" =>  "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "antrean/farmasi/add";
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->post(
            $url,
            [
                "kodebooking" => $request->kodebooking,
                "jenisresep" => $request->jenisresep,
                "nomorantrean" => $request->nomorantrean,
                "keterangan" => $request->keterangan,
            ]
        );
        return $this->response_decrypt($response, $signature);
    }
    public function update_antrean(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "kodebooking" => "required",
            "taskid" =>  "required",
            "waktu" =>  "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "antrean/updatewaktu";
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->post(
            $url,
            [
                "kodebooking" => $request->kodebooking,
                "taskid" => $request->taskid,
                "waktu" => $request->waktu,
                "jenisresep" => $request->jenisresep,
            ]
        );
        return $this->response_decrypt($response, $signature);
    }
    // bridging pendaftaran pa agil
    public function update_antrean_pendaftaran(Request $request)
    {
        // cek request
        $validator = Validator::make($request->all(), [
            "kodebooking" => "required",
            "taskid" => "required",
            "waktu" => "required|numeric",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $response = $this->update_antrean($request);
        if ($response->metadata->code == 200) {
            $antrian = Antrian::firstWhere('kodebooking', $request->kodebooking);
            $antrian->update([
                'taskid' => $request->taskid,
                'status_api' => 1,
                'method' => 'Bridging',
                'keterangan' => "Pendaftaran melalui bridging",
                'user' => 'Pendaftaran',
            ]);
        }
        // kirim notif
        // $wa = new WhatsappController();
        // $request['notif'] = 'Daftar antrian bridging ' . $request->kodebooking;
        // $wa->send_notif($request);
        return response()->json($response);
    }
    public function bridging_taskid_4(Request $request)
    {
        $kunjungan = Kunjungan::with(['pasien', 'dokter', 'unit', 'unit.poliklinik'])->firstWhere('kode_kunjungan', $request->kode);
        $request['nomorkartu'] = $kunjungan->pasien->no_Bpjs;
        $request['nik'] = $kunjungan->pasien->nik_bpjs;
        $request['nama'] = $kunjungan->pasien->nama_px;
        $request['norm'] = $kunjungan->pasien->no_rm;
        $request['kodepoli'] = $kunjungan->unit->poliklinik->kodepoli;
        $request['namapoli'] = $kunjungan->unit->poliklinik->namapoli;
        $request['pasienbaru'] = 0;
        $request['tanggalperiksa'] = Carbon::parse($kunjungan->tgl_masuk)->format('Y-m-d');
        $request['kodedokter'] = $kunjungan->dokter->kode_dokter_jkn;
        $request['namadokter'] = $kunjungan->dokter->nama_paramedis;
        $request['taskid4'] = now();
        if ($kunjungan->antrian) {
            $antrian = Antrian::updateOrCreate(
                [
                    'kode_kunjungan' => $kunjungan->kode_kunjungan
                ],
                $request->all()
            );
        } else {
            $request['kodebooking'] = strtoupper(uniqid());
            $antrian = Antrian::updateOrCreate(
                [
                    'kode_kunjungan' => $kunjungan->kode_kunjungan,
                    'kodebooking' => $kunjungan->kodebooking,
                ],
                $request->all()
            );
        }
        $request['kodebooking'] = $antrian->kodebooking;
        if (!$antrian->nomorantrean) {
            $request['nohp'] = $antrian->pasien->no_hp == null ?  '089529909036' : $antrian->pasien->no_hp;
            $jadwal = JadwalDokter::where('hari', now()->dayOfWeek)
                ->where('kodesubspesialis', $request->kodepoli)
                ->where('kodedokter', $request->kodedokter)
                ->first();
            $request['jampraktek'] = $jadwal->jadwal;
            if ($kunjungan->no_sep) {
                $request['noSep'] = $kunjungan->no_sep;
                $request['jenispasien'] = 'JKN';
                $api = new VclaimController();
                $res = $api->sep_nomor($request);
                if ($res->metadata->code == 200) {
                    if ($res->response->kontrol) {
                        $request['nomorreferensi'] = $res->response->kontrol->noSurat;
                        $request['jeniskunjungan'] = 3;
                    } else {
                        $request['nomorreferensi'] = $res->response->noRujukan;
                        $request['jeniskunjungan'] = 2;
                    }
                }
            } else {
                $request['jeniskunjungan'] = 2;
                $request['jenispasien'] = 'NON-JKN';
            }
            $res = $this->status_antrian($request);
            $request['nomorantrean'] = "A1";
            $request['angkaantrean'] = "1";
            $request['estimasidilayani'] = random_int(1200, 1800);
            $request['sisakuota'] = random_int(4, 15);
            $request['sisakuotajkn'] = 3;
            $request['kuotajkn'] = round($jadwal->kapasitaspasien * 80 / 100);
            $request['sisakuotanonjkn'] = 2;
            $request['kuotanonjkn'] = round($jadwal->kapasitaspasien * 20 / 100);
            $request['keterangan'] = "ambil antrian manual bridging";
            $res = $this->tambah_antrean($request);
        }
        // taskid3
        $request['taskid'] = 3;
        $request['waktu'] = Carbon::parse($antrian->taskid4, 'Asia/Jakarta')->subSeconds(random_int(1200, 1800));
        $res = $this->update_antrean($request);
        // taskid4
        $request['taskid'] = 4;
        $request['waktu'] = Carbon::parse($antrian->taskid4, 'Asia/Jakarta');
        $res = $this->update_antrean($request);
        // kirim notif
        $wa = new WhatsappController();
        // $request['notif'] = $res->metadata->message . '-' . $res->metadata->code . " \n Panggil Antrian Bridging " . $antrian->nama . " di Poliklinik " . $antrian->namapoli;
        // $wa->send_notif($request);
        if ($res->metadata->code == 200 || $res->metadata->code == 208) {
            $antrian->update([
                'taskid' => 4
            ]);
            return $this->sendResponse($res->metadata->message . '-' . $res->metadata->code, 200);
        } else {
            return $this->sendError($res->metadata->message . '-' . $res->metadata->code, 400);
        }
    }
    public function batal_antrean(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "kodebooking" => "required",
            "keterangan" =>  "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),  400);
        }
        $url = $this->baseurl . "antrean/batal";
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->post(
            $url,
            [
                "kodebooking" => $request->kodebooking,
                "keterangan" => $request->keterangan,
            ]
        );
        return $this->response_decrypt($response, $signature);
    }
    public function taskid_antrean(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "kodebooking" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "antrean/getlisttask";
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->post(
            $url,
            [
                "kodebooking" => $request->kodebooking,
            ]
        );
        return $this->response_decrypt($response, $signature);
    }
    public function dashboard_tanggal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "tanggal" =>  "required|date|date_format:Y-m-d",
            "waktu" => "required|in:rs,server",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "dashboard/waktutunggu/tanggal/" . $request->tanggal . "/waktu/" . $request->waktu;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_no_decrypt($response, $signature);
    }
    public function dashboard_bulan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "bulan" =>  "required|date_format:m",
            "tahun" =>  "required|date_format:Y",
            "waktu" => "required|in:rs,server",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $url = $this->baseurl . "dashboard/waktutunggu/bulan/" . $request->bulan . "/tahun/" . $request->tahun . "/waktu/" . $request->waktu;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_no_decrypt($response);
    }
    public function antrian_tanggal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "tanggal" =>  "required|date",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),  201);
        }
        $url = $this->baseurl . "antrean/pendaftaran/tanggal/" . $request->tanggal;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function antrian_kodebooking(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "kodebooking" =>  "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),  201);
        }
        $url = $this->baseurl . "antrean/pendaftaran/kodebooking/" . $request->kodebooking;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function antrian_belum_dilayani(Request $request)
    {
        $url = $this->baseurl . "antrean/pendaftaran/aktif";
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function antrian_pendaftaran(Request $request)
    {
        $url = $this->baseurl . "antrean/pendaftaran/aktif";
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    public function antrian_poliklinik(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "kodepoli" =>  "required",
            "kodedokter" =>  "required",
            "hari" =>  "required",
            "jampraktek" =>  "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),  201);
        }
        $url = $this->baseurl . "antrean/pendaftaran/kodepoli/" . $request->kodepoli . "/kodedokter/" . $request->kodedokter . "/hari/" . $request->hari . "/jampraktek/" . $request->jampraktek;
        $signature = $this->signature();
        $response = Http::withHeaders($signature)->get($url);
        return $this->response_decrypt($response, $signature);
    }
    // API SIMRS
    public function token(Request $request)
    {
        $credentials = [
            'username' => $request->header('x-username'),
            'password' => $request->header('x-password')
        ];
        if (Auth::attempt($credentials)) {
            $user = $request->user();
            $token = $user->createToken('YourAppName')->plainTextToken;
            $data['token'] =  $token;
            return $this->sendResponse($data, 200);
        } else {
            return $this->sendError("Unauthorized (Username dan Password Salah)", 401);
        }
    }
    public function authtoken(Request $request)
    {
        $username = $request->header('x-username');
        $token = $request->header('x-token');
        if ($username && $token) {
            $user = User::where('username', $username)->first();
            if ($user && empty($user->tokens()->where('token', hash('sha256', $token))->first())) {
                return true;
            } else {
                return false;
            }
        }
    }
    public function status_antrian(Request $request) #yang dipakai api
    {
        // if ($this->authtoken($request)) {
        //     return $this->sendError("Unauthorized (Token Invalid)", 401);
        // }
        // validator
        $validator = Validator::make($request->all(), [
            "kodepoli" => "required",
            "kodedokter" => "required",
            "tanggalperiksa" => "required|date",
            "jampraktek" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        // check tanggal backdate
        $request['tanggal'] = $request->tanggalperiksa;
        if (Carbon::parse($request->tanggalperiksa)->endOfDay()->isPast()) {
            return $this->sendError("Tanggal periksa sudah terlewat", 401);
        }
        // get jadwal poliklinik dari simrs
        $jadwals = JadwalDokter::where("hari",  Carbon::parse($request->tanggalperiksa)->dayOfWeek)
            ->where("kodesubspesialis", $request->kodepoli)
            ->get();
        // tidak ada jadwal
        if (!isset($jadwals)) {
            return $this->sendError("Tidak ada jadwal poliklinik dihari tersebut", 404);
        }
        // get jadwal dokter
        $jadwal = $jadwals->where('kodedokter', $request->kodedokter)->first();
        // tidak ada dokter
        if (!isset($jadwal)) {
            return $this->sendError("Tidak ada jadwal dokter dihari tersebut",  404);
        }
        if ($jadwal->libur == 1) {
            return $this->sendError("Jadwal Dokter dihari tersebut sedang diliburkan.",  403);
        }
        // get hitungan antrian
        $antrians = Antrian::where('tanggalperiksa', $request->tanggalperiksa)
            ->where('method', '!=', 'Bridging')
            ->where('kodepoli', $request->kodepoli)
            ->where('kodedokter', $request->kodedokter)
            ->where('taskid', '!=', 99)
            ->count();
        // cek kapasitas pasien
        if ($request->method != 'Bridging') {
            if ($antrians >= $jadwal->kapasitaspasien) {
                return $this->sendError("Kuota Dokter Telah Penuh",  201);
            }
        }
        //  get nomor antrian
        $nomorantean = 0;
        $antreanpanggil =  Antrian::where('kodepoli', $request->kodepoli)
            ->where('tanggalperiksa', $request->tanggalperiksa)
            ->where('taskid', 4)
            ->first();
        if (isset($antreanpanggil)) {
            $nomorantean = $antreanpanggil->nomorantrean;
        }
        // get jumlah antrian jkn dan non-jkn
        $antrianjkn = Antrian::where('kodepoli', $request->kodepoli)
            ->where('method', '!=', 'Bridging')
            ->where('tanggalperiksa', $request->tanggalperiksa)
            ->where('taskid', '!=', 99)
            ->where('kodedokter', $request->kodedokter)
            ->where('jenispasien', "JKN")->count();
        $antriannonjkn = Antrian::where('kodepoli', $request->kodepoli)
            ->where('method', '!=', 'Bridging')
            ->where('tanggalperiksa', $request->tanggalperiksa)
            ->where('tanggalperiksa', $request->tanggalperiksa)
            ->where('kodedokter', $request->kodedokter)
            ->where('taskid', '!=', 99)
            ->where('jenispasien', "NON-JKN")->count();
        $response = [
            "namapoli" => $jadwal->namasubspesialis,
            "namadokter" => $jadwal->namadokter,
            "totalantrean" => $antrians,
            "sisaantrean" => $jadwal->kapasitaspasien - $antrians,
            "antreanpanggil" => $nomorantean,
            "sisakuotajkn" => round($jadwal->kapasitaspasien * 80 / 100) -  $antrianjkn,
            "kuotajkn" => round($jadwal->kapasitaspasien * 80 / 100),
            "sisakuotanonjkn" => round($jadwal->kapasitaspasien * 20 / 100) - $antriannonjkn,
            "kuotanonjkn" =>  round($jadwal->kapasitaspasien * 20 / 100),
            "keterangan" => "Informasi antrian poliklinik",
        ];
        return $this->sendResponse($response, 200);
    }
    public function ambil_antrian(Request $request) #ambil antrian api
    {
        $validator = Validator::make($request->all(), [
            "nomorkartu" => "required|numeric|digits:13",
            "nik" => "required|numeric|digits:16",
            "nohp" => "required",
            "kodepoli" => "required",
            // "norm" => "required",
            "tanggalperiksa" => "required",
            "kodedokter" => "required",
            "jampraktek" => "required",
            "jeniskunjungan" => "required|numeric",
            // "nomorreferensi" => "numeric",
        ]);
        if ($request->jeniskunjungan != 2) {
            $validator = Validator::make($request->all(), [
                "nomorreferensi" => "required",
            ]);
        }
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 201);
        }
        try {
            // check tanggal backdate
            if (Carbon::parse($request->tanggalperiksa)->endOfDay()->isPast()) {
                return $this->sendError("Tanggal periksa sudah terlewat", 201);
            }
            // check tanggal hanya 7 hari
            if (Carbon::parse($request->tanggalperiksa) >  Carbon::now()->addDay(6)) {
                return $this->sendError("Antrian hanya dapat dibuat untuk 7 hari ke kedepan", 201);
            }
            // cek duplikasi nik antrian
            $antrian_nik = Antrian::where('tanggalperiksa', $request->tanggalperiksa)
                ->where('nik', $request->nik)
                ->where('taskid', '<=', 5)
                ->first();
            if ($antrian_nik) {
                return $this->sendError("Terdapat Antrian (" . $antrian_nik->kodebooking . ") dengan nomor NIK yang sama pada tanggal tersebut yang belum selesai. Silahkan batalkan terlebih dahulu jika ingin mendaftarkan lagi.",  201);
            }
            // cek pasien baru
            $request['pasienbaru'] = 0;
            $pasien = Pasien::where('no_Bpjs',  $request->nomorkartu)->first();
            if (empty($pasien)) {
                return $this->sendError("Nomor Kartu BPJS Pasien termasuk Pasien Baru di RSUD Waled. Silahkan daftar melalui pendaftaran offline",  201);
            }
            // cek no kartu sesuai tidak
            if ($pasien->nik_bpjs != $request->nik) {
                return $this->sendError("NIK anda yang terdaftar di BPJS dengan Di RSUD Waled berbeda. Silahkan perbaiki melalui pendaftaran offline",  201);
            }
            // Cek pasien kronis
            $kunjungan_kronis = Kunjungan::where("no_rm", $request->norm)
                ->where('catatan', 'KRONIS')
                ->orderBy('tgl_masuk', 'DESC')
                ->first();
            // cek pasien kronis 30 hari dan beda poli
            if (isset($kunjungan_kronis)) {
                $unit = Unit::firstWhere('kode_unit', $kunjungan_kronis->kode_unit);
                if ($unit->KDPOLI ==  $request->kodepoli) {
                    // return $this->sendError(Carbon::parse($kunjungan_kronis->tgl_masuk)->addMonth(1));
                    if (Carbon::parse($request->tanggalperiksa)->endOfDay() < Carbon::parse($kunjungan_kronis->tgl_masuk)->addMonth(1)) {
                        return $this->sendError("Pada kunjungan sebelumnya di tanggal " . Carbon::parse($kunjungan_kronis->tgl_masuk)->translatedFormat('d F Y') . " anda termasuk pasien KRONIS. Sehingga bisa daftar lagi setelah 30 hari.",  201);
                    }
                }
            }
            // cek jika jkn
            if (isset($request->nomorreferensi)) {
                $request['jenispasien'] = 'JKN';
                $vclaim = new VclaimController();
                // kunjungan kontrol
                if ($request->jeniskunjungan == 3) {
                    $request['noSuratKontrol'] = $request->nomorreferensi;
                    $response =  $vclaim->suratkontrol_nomor($request);
                    if ($response->metadata->code == 200) {
                        $suratkontrol = $response->response;
                        $request['nomorRujukan'] = $suratkontrol->sep->provPerujuk->noRujukan;
                        // cek surat kontrol orang lain
                        if ($request->nomorkartu != $suratkontrol->sep->peserta->noKartu) {
                            return $this->sendError("Nomor Kartu di Surat Kontrol dengan Kartu BPJS berberda", 201);
                        }
                        // cek surat tanggal kontrol
                        // if (Carbon::parse($suratkontrol->tglRencanaKontrol) != Carbon::parse($request->tanggalperiksa)) {
                        //     return $this->sendError("Tanggal periksa tidak sesuai dengan surat kontrol. Silahkan pengajuan perubahan tanggal surat kontrol terlebih dahulu.", 201);
                        // }
                    } else {
                        return $this->sendError($response->metadata->message,  $response->metadata->code);
                    }
                }
                // kunjungan rujukan
                else {
                    $request['nomorRujukan'] = $request->nomorreferensi;
                    // rujukan fktp
                    if ($request->jeniskunjungan == 1) {
                        $request['jenisRujukan'] = 1;
                    }
                    // rujukan antar rs
                    else if ($request->jeniskunjungan == 4) {
                        $request['jenisRujukan'] = 2;
                    }
                }
            }
            // jika non-jkn
            else {
                $request['jenispasien'] = 'NON-JKN';
            }
            // ambil data pasien
            $request['norm'] = $pasien->no_rm;
            $request['nama'] = $pasien->nama_px;
            // cek jadwal
            $poli = Poliklinik::where('kodesubspesialis', $request->kodepoli)->first();
            $request['lantaipendaftaran'] = $poli->lantaipendaftaran;
            $request['lokasi'] = $poli->lokasi;
            $jadwal = $this->status_antrian($request);
            if ($jadwal->metadata->code == 200) {
                $jadwal = $jadwal->response;
                $request['namapoli'] = $jadwal->namapoli;
                $request['namadokter'] = $jadwal->namadokter;
            } else {
                $message = $jadwal->metadata->message;
                return $this->sendError('Mohon maaf , ' . $message, 201);
            }
            // menghitung nomor antrian
            $antrian_all = Antrian::where('tanggalperiksa', $request->tanggalperiksa)
                ->where('method', '!=', 'Bridging')
                ->count();
            $antrian_poli = Antrian::where('tanggalperiksa', $request->tanggalperiksa)
                ->where('method', '!=', 'Bridging')
                ->where('kodepoli', $request->kodepoli)
                ->count();
            $request['nomorantrean'] = $request->kodepoli . "-" .  str_pad($antrian_poli + 1, 3, '0', STR_PAD_LEFT);
            $request['angkaantrean'] = $antrian_all + 1;
            //  menghitung estimasi dilayani
            $timestamp = $request->tanggalperiksa . ' ' . explode('-', $request->jampraktek)[0] . ':00';
            $jadwal_estimasi = Carbon::createFromFormat('Y-m-d H:i:s', $timestamp, 'Asia/Jakarta')->addMinutes(10 * ($antrian_poli + 1));
            $request['estimasidilayani'] = $jadwal_estimasi->timestamp * 1000;
            $request['sisakuotajkn'] =  $jadwal->sisakuotajkn - 1;
            $request['kuotajkn'] = $jadwal->kuotajkn;
            $request['sisakuotanonjkn'] = $jadwal->sisakuotanonjkn - 1;
            $request['kuotanonjkn'] = $jadwal->kuotanonjkn;
            // keterangan jika offline
            if ($request->method == 'Offline') {
                $request['keterangan'] = "Silahkan menunggu panggilan di loket pendaftaran.";
            }
            // keterangan jika bridging
            else if ($request->method == 'Web') {
                $request['keterangan'] = "Peserta harap 60 menit lebih awal dari jadwal untuk checkin dekat mesin antrian untuk mencetak tiket antrian.";
            }
            // keterangan jika bridging
            else if ($request->method == 'Bridging') {
                $request['keterangan'] = "Silahkan menunggu panggilan di poliklinik.";
            }
            // keterangan jika jkn
            else {
                $request['keterangan'] = "Peserta harap 60 menit lebih awal dari jadwal untuk checkin dekat mesin antrian untuk mencetak tiket antrian.";
                $request['method'] = "JKN Mobile";
            }
            $request['kodebooking'] = strtoupper(uniqid());
            //tambah antrian bpjs
            $response = $this->tambah_antrean($request);
            if ($response->metadata->code == 200) {
                // tambah antrian database
                $antrian = Antrian::create([
                    "kodebooking" => $request->kodebooking,
                    "nomorkartu" => $request->nomorkartu,
                    "nik" => $request->nik,
                    "nohp" => $request->nohp,
                    "kodepoli" => $request->kodepoli,
                    "norm" => $request->norm,
                    "pasienbaru" => $request->pasienbaru,
                    "tanggalperiksa" => $request->tanggalperiksa,
                    "kodedokter" => $request->kodedokter,
                    "jampraktek" => $request->jampraktek,
                    "jeniskunjungan" => $request->jeniskunjungan,
                    "nomorreferensi" => $request->nomorreferensi,
                    "method" => $request->method,
                    "nomorrujukan" => $request->nomorRujukan,
                    "nomorsuratkontrol" => $request->noSuratKontrol,
                    'nomorsep' => $request->nomorsep,
                    "kode_kunjungan" => $request->kode_kunjungan,
                    "jenispasien" => $request->jenispasien,
                    "namapoli" => $request->namapoli,
                    "namadokter" => $request->namadokter,
                    "nomorantrean" => $request->nomorantrean,
                    "angkaantrean" => $request->angkaantrean,
                    "estimasidilayani" => $request->estimasidilayani,
                    "sisakuotajkn" => $request->sisakuotajkn,
                    "kuotajkn" => $request->kuotajkn,
                    "sisakuotanonjkn" => $request->sisakuotanonjkn,
                    "kuotanonjkn" => $request->kuotanonjkn,
                    "keterangan" => $request->keterangan,
                    "lokasi" => $request->lokasi,
                    "lantaipendaftaran" => $request->lantaipendaftaran,
                    "status_api" => 1,
                    "taskid" => 0,
                    "user" => "System Antrian",
                    "nama" => $request->nama,
                ]);
                // kirim notif wa
                // $wa = new WhatsappController();
                // $request['message'] = "*Antrian Berhasil di Daftarkan*\nAntrian anda berhasil didaftarkan melalui Layanan " . $request->method . " RSUD Waled dengan data sebagai berikut : \n\n*Kode Antrian :* " . $request->kodebooking .  "\n*Angka Antrian :* " . $request->angkaantrean .  "\n*Nomor Antrian :* " . $request->nomorantrean . "\n*Jenis Pasien :* " . $request->jenispasien .  "\n*Jenis Kunjungan :* " . $request->jeniskunjungan .  "\n\n*Nama :* " . $request->nama . "\n*Poliklinik :* " . $request->namapoli  . "\n*Dokter :* " . $request->namadokter  .  "\n*Jam Praktek :* " . $request->jampraktek  .  "\n*Tanggal Periksa :* " . $request->tanggalperiksa . "\n\n*Keterangan :* " . $request->keterangan  .  "\nLink Kodebooking QR Code :\nhttps://siramah.rsudwaled.id/check_antrian?kodebooking=" . $request->kodebooking . "\n\nTerima kasih. Semoga sehat selalu.\nUntuk pertanyaan & pengaduan silahkan hubungi :\n*Humas RSUD Waled 08983311118*";
                // $request['number'] = $request->nohp;
                // $wa->send_message($request);
                // kirim notif
                // $wa = new WhatsappController();
                // $request['notif'] = 'Antrian berhasil didaftarkan melalui ' . $request->method . "\n*Kodebooking :* " . $request->kodebooking . "\n*Nama :* " . $request->nama . "\n*Poliklinik :* " . $request->namapoli .  "\n*Tanggal Periksa :* " . $request->tanggalperiksa . "\n*Jenis Kunjungan :* " . $request->jeniskunjungan;
                // $wa->send_notif($request);
                if ($request->method == 'Bridging') {
                    $antrian->update([
                        'taskid' => 3,
                        'taskid1' => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s'),
                        'taskid3' => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s'),
                        'user1' => $request->user,
                        'kode_kunjungan' => $request->kode_kunjungan,
                    ]);
                }
                $response = [
                    "nomorantrean" => $request->nomorantrean,
                    "angkaantrean" => $request->angkaantrean,
                    "kodebooking" => $request->kodebooking,
                    "norm" =>  $request->norm,
                    "namapoli" => $request->namapoli,
                    "namadokter" => $request->namadokter,
                    "estimasidilayani" => $request->estimasidilayani,
                    "sisakuotajkn" => $request->sisakuotajkn,
                    "kuotajkn" => $request->kuotajkn,
                    "sisakuotanonjkn" => $request->sisakuotanonjkn,
                    "kuotanonjkn" => $request->kuotanonjkn,
                    "keterangan" => $request->keterangan,
                ];
                return $this->sendResponse($response, 200);
            } else {
                return $this->sendError($response->metadata->message, 201);
            }
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), 201);
        }
    }
    public function sisa_antrian(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "kodebooking" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),  400);
        }
        $antrian = Antrian::firstWhere('kodebooking', $request->kodebooking);
        // antrian ditermukan
        if (isset($antrian)) {
            $sisaantrean = Antrian::where('taskid', "<=", 3)
                ->where('tanggalperiksa', $antrian->tanggalperiksa)
                ->where('kodepoli', $antrian->kodepoli)
                ->where('taskid', ">=", 0)
                ->count();
            $antreanpanggil =  Antrian::where('taskid', "<=", 3)
                ->where('taskid', ">=", 1)
                ->where('kodepoli', $antrian->kodepoli)
                ->where('tanggalperiksa', $antrian->tanggalperiksa)
                ->first();
            if (empty($antreanpanggil)) {
                $antreanpanggil['nomorantrean'] = '0';
            }
            $antrian['waktutunggu'] = 300 +  300 * ($sisaantrean - 1);
            $antrian['keterangan'] = "Info Sisa Antrian";
            $response = [
                "nomorantrean" => $antrian->nomorantrean,
                "namapoli" => $antrian->namapoli,
                "namadokter" => $antrian->namadokter,
                "sisaantrean" => $sisaantrean,
                "antreanpanggil" => $antreanpanggil['nomorantrean'],
                "waktutunggu" => $antrian->waktutunggu,
                "keterangan" => $antrian->keterangan,
            ];
            return $this->sendResponse($response, 200);
        }
        // antrian tidak ditermukan
        else {
            return $this->sendError('Antrian tidak ditemukan', 400);
        }
    }
    public function batal_antrian(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "kodebooking" => "required",
            "keterangan" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $antrian = Antrian::firstWhere('kodebooking', $request->kodebooking);
        if (isset($antrian)) {
            $response = $this->batal_antrean($request);
            $kunjungan = Kunjungan::firstWhere('kode_kunjungan', $antrian->kode_kunjungan);
            $kunjungan?->update(["status_kunjungan" => 8,]);
            $antrian->update([
                "taskid" => 99,
                "status_api" => 1,
                "keterangan" => $request->keterangan,
            ]);
            // $wa = new WhatsappController();
            // $request['message'] = "Antrian anda atas nama pasien " . $antrian->nama . " dengan kodeboking " . $antrian->kodebooking . " telah dibatalkan dengan alasan " . $request['keterangan'] . "\n\nTerimakasih. Semoga sehat selalu.";
            // $request['number'] = $antrian->nohp;
            // $wa->send_message($request);
            return $this->sendError($response->metadata->message, 200);
        }
        // antrian tidak ditemukan
        else {
            return $this->sendError('Antrian tidak ditemukan',  200);
        }
    }
    public function checkin_antrian(Request $request)
    {
        // cek printer
        try {
            Log::notice('Checkin Printer ip : ' . $request->ip());
            if ($request->ip() == "192.168.2.133") {
                $printer = env('PRINTER_CHECKIN');
            } else if ($request->ip() == "192.168.2.51") {
                $printer = env('PRINTER_CHECKIN2');
            } else if ($request->ip() == "192.168.2.218") {
                $printer = env('PRINTER_CHECKIN_MJKN');
            } else {
                $printer = env('PRINTER_CHECKIN3');
            }
            $connector = new WindowsPrintConnector($printer);
            $printer = new Printer($connector);
            $printer->close();
        } catch (\Throwable $th) {
            return $this->sendError("Printer mesin antrian mati", 500);
        }

        // checking request
        $validator = Validator::make($request->all(), [
            "kodebooking" => "required",
            "waktu" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $now = now();
        $antrian = Antrian::firstWhere('kodebooking', $request->kodebooking);
        if (isset($antrian)) {
            // check backdate
            if (!Carbon::parse($antrian->tanggalperiksa)->isToday()) {
                return $this->sendError("Tanggal periksa bukan hari ini.", 400);
            }
            if ($antrian->taskid == 99) {
                return $this->sendError("Antrian telah dibatalkan sebelumnya.", 400);
            }
            $unit = Unit::firstWhere('KDPOLI', $antrian->kodepoli);
            $tarifkarcis = TarifLayananDetail::firstWhere('KODE_TARIF_DETAIL', $unit->kode_tarif_karcis);
            $tarifadm = TarifLayananDetail::firstWhere('KODE_TARIF_DETAIL', $unit->kode_tarif_adm);
            if ($antrian->pasienbaru) {
                $request['pasienbaru_print'] = 'BARU';
            } else {
                $request['pasienbaru_print'] = 'LAMA';
            }
            // jika pasien jkn
            if ($antrian->jenispasien == "JKN") {
                $request['status_api'] = 1;
                $request['taskid'] = 3;
                $request['keterangan'] = "Untuk pasien peserta JKN silahkan dapat langsung menunggu ke POLIKINIK " . $antrian->namapoli;
                $request['noKartu'] = $antrian->nomorkartu;
                $request['tglSep'] = $antrian->tanggalperiksa;
                $request['noMR'] = $antrian->norm;
                $request['norm'] = $antrian->norm;
                $request['nik'] = $antrian->nik;
                $request['nohp'] = $antrian->nohp;
                $request['kodedokter'] = $antrian->kodedokter;
                $vclaim = new VclaimController();
                // daftar pake surat kontrol
                if ($antrian->jeniskunjungan == 3) {
                    $request['nomorreferensi'] = $antrian->nomorsuratkontrol;
                    $request['noSuratKontrol'] = $antrian->nomorsuratkontrol;
                    $request['noTelp'] = $antrian->nohp;
                    $request['user'] = "Mesin Antrian";
                    $suratkontrol = $vclaim->suratkontrol_nomor($request);
                    // berhasil get surat kontrol
                    if ($suratkontrol->metadata->code == 200) {
                        $suratkontrol = $suratkontrol;
                        $request['nomorsuratkontrol'] = $antrian->nomorsuratkontrol;
                        if ($suratkontrol->response->sep->jnsPelayanan == "Rawat Jalan") {
                            $request['nomorrujukan'] = $suratkontrol->response->sep->provPerujuk->noRujukan;
                            $request['jeniskunjungan_print'] = 'KONTROL';
                            $request['nomorreferensi'] = $antrian->nomorrujukan;
                            $data = $vclaim->rujukan_nomor($request);
                            if ($data->metadata->code != 200) {
                                $data = $vclaim->rujukan_rs_nomor($request);
                            }
                            // berhasil get rujukan
                            if ($data->metadata->code == 200) {
                                $data = $data;
                                $rujukan = $data->response->rujukan;
                                $peserta = $rujukan->peserta;
                                $diganosa = $rujukan->diagnosa;
                                $tujuan = $rujukan->poliRujukan;
                                $penjamin = Penjamin::where('nama_penjamin_bpjs', $peserta->jenisPeserta->keterangan)->first(); // get peserta
                                // $request['kodepenjamin'] = 'P13';
                                $request['kodepenjamin'] = $penjamin->kode_penjamin_simrs; // get peserta
                                // tujuan rujukan
                                // ppkPelayanan
                                $request['ppkPelayanan'] = "1018R001";
                                $request['jnsPelayanan'] = "2";
                                // peserta
                                $request['klsRawatHak'] = $peserta->hakKelas->kode; // get peserta
                                $request['klsRawatNaik'] = ""; // get peserta
                                // $request['pembiayaan'] = $peserta->jenisPeserta->kode;
                                // $request['penanggungJawab'] =  $peserta->jenisPeserta->keterangan;
                                // asal rujukan
                                $request['asalRujukan'] = $data->response->asalFaskes; // get surat kontrol
                                $request['tglRujukan'] = $rujukan->tglKunjungan; // get surat kontrol
                                $request['noRujukan'] =   $rujukan->noKunjungan; // get surat kontrol
                                $request['ppkRujukan'] = $rujukan->provPerujuk->kode; // get surat kontrol
                                // diagnosa
                                $request['catatan'] =  $diganosa->nama; // get surat kontrol
                                $request['diagAwal'] =  $diganosa->kode; // get surat kontrol
                                // poli tujuan
                                $request['tujuan'] =  $antrian->kodepoli; // get antrian
                                $request['eksekutif'] =  0;
                                // dpjp

                                $request['tujuanKunj'] = "2";
                                $request['flagProcedure'] = "";
                                $request['kdPenunjang'] = "";
                                $request['assesmentPel'] = "2";
                                $request['noSurat'] = $request->nomorsuratkontrol; // get antrian
                                $request['kodeDPJP'] = $suratkontrol->response->kodeDokter;
                                $request['dpjpLayan'] =  $suratkontrol->response->kodeDokter;
                            }
                            // gagal get rujukan
                            else {
                                return $this->sendError($data->metadata->message,  400);
                            }
                        } else {
                            $request['nomorkartu'] = $antrian->nomorkartu;
                            $request['tanggal'] = $antrian->tanggalperiksa;
                            $data = $vclaim->peserta_nomorkartu($request);
                            // berhasil get rujukan
                            if ($data->metadata->code == 200) {
                                $data = $data;
                                $peserta = $data->response->peserta;
                                $diagnosa = $suratkontrol->response->sep->diagnosa;
                                $asalRujukan = $suratkontrol->response->sep->provPerujuk->asalRujukan;
                                $tglRujukan = $suratkontrol->response->sep->provPerujuk->tglRujukan;
                                $noRujukan = $suratkontrol->response->sep->noSep;
                                $ppkRujukan = $suratkontrol->response->sep->provPerujuk->kdProviderPerujuk;
                                $penjamin = Penjamin::where('nama_penjamin_bpjs', $peserta->jenisPeserta->keterangan)->first(); // get peserta
                                $request['kodepenjamin'] = $penjamin->kode_penjamin_simrs; // get peserta
                                // $request['kodepenjamin'] = 'P13';
                                // tujuan rujukan
                                $request['ppkPelayanan'] = "1018R001";
                                $request['jnsPelayanan'] = "2";
                                // peserta
                                $request['klsRawatHak'] = $peserta->hakKelas->kode; // get peserta
                                $request['klsRawatNaik'] = ""; // get peserta
                                // $request['pembiayaan'] = $peserta->jenisPeserta->kode;
                                // $request['penanggungJawab'] =  $peserta->jenisPeserta->keterangan;
                                // asal rujukan
                                $request['asalRujukan'] = $asalRujukan; // get surat kontrol
                                $request['tglRujukan'] = $tglRujukan; // get surat kontrol
                                $request['noRujukan'] =   $noRujukan; // get surat kontrol
                                $request['ppkRujukan'] = $ppkRujukan; // get surat kontrol
                                // diagnosa
                                $request['catatan'] =  $diagnosa; // get surat kontrol
                                $request['diagAwal'] = str_replace(" ", "", explode('-', $diagnosa)[0]);
                                // poli tujuan
                                $request['tujuan'] =  $antrian->kodepoli; // get antrian
                                $request['eksekutif'] =  0;
                                // dpjp
                                $request['tujuanKunj'] = "0";
                                $request['flagProcedure'] = "";
                                $request['kdPenunjang'] = "";
                                $request['assesmentPel'] = "";
                                $request['noSurat'] = $request->nomorsuratkontrol; // get antrian
                                $request['kodeDPJP'] = $suratkontrol->response->kodeDokter;
                                $request['dpjpLayan'] =  $suratkontrol->response->kodeDokter;
                            }
                        }
                    }
                    // gagal get surat kontrol
                    else {
                        return $this->sendError($suratkontrol->metadata->message,  400);
                    }
                }
                // daftar pake rujukan
                else {
                    $request['nomorrujukan'] = $antrian->nomorreferensi;
                    $request['nomorreferensi'] = $antrian->nomorreferensi;
                    $request['jeniskunjungan_print'] = 'RUJUKAN';
                    $vclaim = new VclaimController();
                    if ($antrian->jeniskunjungan == 4) {
                        $data = $vclaim->rujukan_rs_nomor($request);
                    } else  if ($antrian->jeniskunjungan == 1) {
                        $data = $vclaim->rujukan_nomor($request);
                    }
                    // berhasil get rujukan
                    if ($data->metadata->code == 200) {
                        $data = $data;
                        $rujukan = $data->response->rujukan;
                        $peserta = $rujukan->peserta;
                        $diganosa = $rujukan->diagnosa;
                        $tujuan = $rujukan->poliRujukan;
                        $penjamin = Penjamin::where('nama_penjamin_bpjs', $peserta->jenisPeserta->keterangan)->first();
                        $request['kodepenjamin'] = $penjamin->kode_penjamin_simrs;
                        // $request['kodepenjamin'] = 'P13';
                        // tujuan rujukan
                        $request['ppkPelayanan'] = "1018R001";
                        $request['jnsPelayanan'] = "2";
                        // peserta
                        $request['klsRawatHak'] = $peserta->hakKelas->kode;
                        $request['klsRawatNaik'] = "";
                        // $request['pembiayaan'] = $peserta->jenisPeserta->kode;
                        // $request['penanggungJawab'] =  $peserta->jenisPeserta->keterangan;
                        // asal rujukan
                        $request['asalRujukan'] = $data->response->asalFaskes;
                        $request['tglRujukan'] = $rujukan->tglKunjungan;
                        $request['noRujukan'] =   $request->nomorreferensi;
                        $request['ppkRujukan'] = $rujukan->provPerujuk->kode;
                        // diagnosa
                        $request['catatan'] =  $diganosa->nama;
                        $request['diagAwal'] =  $diganosa->kode;
                        // poli tujuan
                        $request['tujuan'] =  $antrian->kodepoli;
                        $request['eksekutif'] =  0;
                        // dpjp
                        $request['tujuanKunj'] = "0";
                        $request['flagProcedure'] = "";
                        $request['kdPenunjang'] = "";
                        $request['assesmentPel'] = "";
                        // $request['noSurat'] = "";
                        $request['kodeDPJP'] = "";
                        $request['dpjpLayan'] = $antrian->kodedokter;
                        $request['noTelp'] = $antrian->nohp;
                        $request['nohp'] = $antrian->nohp;
                        $request['user'] = "Mesin Antrian";
                    }
                    // gagal get rujukan
                    else {
                        return $this->sendError($data->metadata->message,  400);
                    }
                }
                // create sep
                $sep = $vclaim->sep_insert($request);
                // berhasil buat sep
                if ($sep->metadata->code == 200) {
                    // update antrian sep
                    $sep = $sep->response->sep;
                    $request["nomorsep"] = $sep->noSep;
                    $antrian->update([
                        "nomorsep" => $request->nomorsep
                    ]);
                    // print sep
                    $this->print_sep($request, $sep);
                }
                // gagal buat sep
                else {
                    if (isset($antrian->nomorsep)) {
                    } else {
                        $requests["nomorsep"] = $antrian->nomorsep;
                        return $this->sendError("Gagal Buat SEP : " . $sep->metadata->message,  400);
                    }
                }
                // rj jkn tipe transaki 2 status layanan 2 status layanan detail opn
                $tipetransaksi = 2;
                $statuslayanan = 2;
                // rj jkn masuk ke tagihan penjamin
                $tagihanpenjamin_karcis = $tarifkarcis->tarif_rajal;
                $tagihanpenjamin_adm = $tarifadm->tarif_rajal;
                $totalpenjamin =  $tarifkarcis->tarif_rajal + $tarifadm->tarif_rajal;
                $tagihanpribadi_karcis = 0;
                $tagihanpribadi_adm = 0;
                $totalpribadi =  0;
            }
            // jika pasien non jkn
            else {
                $request['taskid'] = 3;
                $request['status_api'] = 0;
                $request['kodepenjamin'] = "P01";
                $request['jeniskunjungan_print'] = 'KUNJUNGAN UMUM';
                $request['keterangan'] = "Untuk pasien peserta NON-JKN silahkan lakukan pembayaran terlebih dahulu di Loket Pembayaran samping BJB";
                // rj umum tipe transaki 1 status layanan 1 status layanan detail opn
                $tipetransaksi = 1;
                $statuslayanan = 1;
                // rj umum masuk ke tagihan pribadi
                $tagihanpenjamin_karcis = 0;
                $tagihanpenjamin_adm = 0;
                $totalpenjamin =  0;

                $tagihanpribadi_karcis = $tarifkarcis->tarif_rajal;
                $tagihanpribadi_adm = $tarifadm->tarif_rajal;
                $totalpribadi = $tarifkarcis->tarif_rajal + $tarifadm->tarif_rajal;
            }
            // percobaan jika kunjungan kosong
            if ($antrian->kode_kunjungan == null) {
                try {
                    $paramedis = Paramedis::firstWhere('kode_dokter_jkn', $antrian->kodedokter);
                    // hitung counter kunjungan
                    $kunjungan = Kunjungan::where('no_rm', $antrian->norm)->orderBy('counter', 'DESC')->first();
                    if (empty($kunjungan)) {
                        $counter = 1;
                    } else {
                        $counter = $kunjungan->counter + 1;
                    }
                    // insert ts kunjungan status 8
                    $kunjungan  = Kunjungan::create(
                        [
                            'counter' => $counter,
                            'no_rm' => $antrian->norm,
                            'kode_unit' => $unit->kode_unit,
                            'tgl_masuk' => $now,
                            'kode_paramedis' => $paramedis->kode_paramedis,
                            'status_kunjungan' => 8,
                            'prefix_kunjungan' => $unit->prefix_unit,
                            'kode_penjamin' => $request->kodepenjamin,
                            'pic' => 1319,
                            'id_alasan_masuk' => 1,
                            'kelas' => 3,
                            'hak_kelas' => $request->klsRawatHak,
                            'no_sep' =>  $request->nomorsep,
                            'no_rujukan' => $antrian->nomorrujukan,
                            'diagx' =>   $request->catatan,
                            'created_at' => $now,
                            'keterangan2' => 'MESIN_2',
                        ]
                    );
                    $kunjungan = Kunjungan::where('no_rm', $antrian->norm)->where('counter', $counter)->first();
                    $kodelayanan = collect(DB::connection('mysql2')->select('CALL GET_NOMOR_LAYANAN_HEADER(' . $unit->kode_unit . ')'))->first()->no_trx_layanan;
                    if ($kodelayanan == null) {
                        //   get transaksi sebelumnya
                        $trx_lama = Transaksi::where('unit', $unit->kode_unit)
                            ->whereBetween('tgl', [Carbon::now()->startOfDay(), [Carbon::now()->endOfDay()]])
                            ->count();
                        // get kode layanan
                        $kodelayanan = $unit->prefix_unit . now()->format('y') . now()->format('m') . now()->format('d')  . str_pad($trx_lama + 1, 6, '0', STR_PAD_LEFT);
                        //  insert transaksi
                        $trx_baru = Transaksi::create([
                            'tgl' => now()->format('Y-m-d'),
                            'no_trx_layanan' => $kodelayanan,
                            'unit' => $unit->kode_unit,
                        ]);
                    }
                    //  insert layanan header
                    $layananbaru = Layanan::create(
                        [
                            'kode_layanan_header' => $kodelayanan,
                            'tgl_entry' => $now,
                            'kode_kunjungan' => $kunjungan->kode_kunjungan,
                            'kode_unit' => $unit->kode_unit,
                            'kode_tipe_transaksi' => $tipetransaksi,
                            'status_layanan' => $statuslayanan,
                            'pic' => '1319',
                            'keterangan' => 'Layanan header melalui antrian sistem',
                        ]
                    );
                    //  insert layanan header dan detail karcis admin konsul 25 + 5 = 30
                    //  DET tahun bulan `tanggal b`aru urutan 6 digit kanan
                    //  insert layanan detail karcis
                    $layanandet = LayananDetail::orderBy('tgl_layanan_detail', 'DESC')->first();
                    $nomorlayanandet = substr($layanandet->id_layanan_detail, 9) + 1;
                    $karcis = LayananDetail::create(
                        [
                            'id_layanan_detail' => "DET" . now()->format('ymd') . $nomorlayanandet,
                            'row_id_header' => $layananbaru->id,
                            'kode_layanan_header' => $layananbaru->kode_layanan_header,
                            'kode_tarif_detail' => $tarifkarcis->KODE_TARIF_DETAIL,
                            'total_tarif' => $tarifkarcis->tarif_rajal,
                            'jumlah_layanan' => 1,
                            'tagihan_pribadi' => $tagihanpribadi_karcis,
                            'tagihan_penjamin' => $tagihanpenjamin_karcis,
                            'total_layanan' => $tarifkarcis->tarif_rajal,
                            'grantotal_layanan' => $tarifkarcis->tarif_rajal,
                            'kode_dokter1' => $paramedis->kode_paramedis, // ambil dari mt paramdeis
                            'tgl_layanan_detail' =>   $now,
                            'status_layanan_detail' => "OPN",
                            'tgl_layanan_detail_2' =>   $now,
                        ]
                    );
                    //  insert layanan detail admin
                    $layanandet = LayananDetail::orderBy('tgl_layanan_detail', 'DESC')->first();
                    $nomorlayanandet = substr($layanandet->id_layanan_detail, 9) + 1;
                    $adm = LayananDetail::create(
                        [
                            'id_layanan_detail' => "DET" .  now()->format('ymd') . $nomorlayanandet,
                            'row_id_header' => $layananbaru->id,
                            'kode_layanan_header' => $layananbaru->kode_layanan_header,
                            'kode_tarif_detail' => $tarifadm->KODE_TARIF_DETAIL,
                            'total_tarif' => $tarifadm->tarif_rajal,
                            'jumlah_layanan' => 1,
                            'tagihan_pribadi' =>  $tagihanpribadi_adm,
                            'tagihan_penjamin' =>  $tagihanpenjamin_adm,
                            'total_layanan' => $tarifadm->tarif_rajal,
                            'grantotal_layanan' => $tarifadm->tarif_rajal,
                            'kode_dokter1' => 0,
                            'tgl_layanan_detail' =>  $now,
                            'status_layanan_detail' => "OPN",
                            'tgl_layanan_detail_2' =>  $now,
                        ]
                    );
                    //  update layanan header total tagihan
                    $layananbaru->update([
                        'total_layanan' => $tarifkarcis->tarif_rajal + $tarifadm->tarif_rajal,
                        'tagihan_pribadi' => $totalpribadi,
                        'tagihan_penjamin' => $totalpenjamin,
                    ]);
                } catch (\Throwable $th) {
                    return $this->sendError($th->getMessage(), 400);
                }
            } else {
                $kunjungan = Kunjungan::where('kode_kunjungan', $antrian->kode_kunjungan)->first();
            }
            // print ulang
            if ($antrian->taskid == 3) {
                $this->print_ulang($request);
                return $this->sendError("Silahkan Ambil Print Ulang Antrian di Anjungan Pelayanan Mandiri",  201);
            }
            // update antrian kunjungan
            try {
                $antrian->update([
                    "kode_kunjungan" => $kunjungan->kode_kunjungan,
                ]);
                $kunjungan->update([
                    'status_kunjungan' => 1,
                ]);
                // insert tracer tc_tracer_header
                $tracerbaru = Tracer::updateOrCreate([
                    'kode_kunjungan' => $kunjungan->kode_kunjungan,
                    'tgl_tracer' =>  now()->format('Y-m-d'),
                    'id_status_tracer' => 1,
                    'cek_tracer' => "N",
                ]);
            } catch (\Throwable $th) {
                //throw $th;
                return [
                    "metadata" => [
                        "message" => "Error Update Kunjungan Antrian : " . $th->getMessage(),
                        "code" => 400,
                    ],
                ];
            }
            // update antrian print tracer wa
            try {
                if (env('BRIDGING_ANTRIAN_BPJS')) {
                    $request['kodebooking'] = $antrian->kodebooking;
                    $request['taskid'] = 3;
                    $request['waktu'] = $now;
                    $res = $this->update_antrean($request);
                }
                $antrian->update([
                    "taskid" => $request->taskid,
                    "keterangan" => $request->keterangan,
                    "taskid1" => $now,
                    "taskid3" => $now,
                    "user1" => "Mesin Antrian",
                    "method" => "JKN Mobile",
                ]);
                // print antrian
                $print_karcis = new AntrianController();
                $request['tarifkarcis'] = $tarifkarcis->tarif_rajal;
                $request['tarifadm'] = $tarifadm->tarif_rajal;
                $request['norm'] = $antrian->norm;
                $request['nama'] = $antrian->nama;
                $request['nik'] = $antrian->nik;
                $request['nomorkartu'] = $antrian->nomorkartu;
                $request['nohp'] = $antrian->nohp;
                $request['nomorrujukan'] = $antrian->nomorrujukan;
                $request['nomorsuratkontrol'] = $antrian->nomorsuratkontrol;
                $request['namapoli'] = $antrian->namapoli;
                $request['namadokter'] = $antrian->namadokter;
                $request['jampraktek'] = $antrian->jampraktek;
                $request['tanggalperiksa'] = $antrian->tanggalperiksa;
                $request['jenispasien'] = $antrian->jenispasien;
                $request['nomorantrean'] = $antrian->nomorantrean;
                $request['lokasi'] = $antrian->lokasi;
                $request['angkaantrean'] = $antrian->angkaantrean;
                $request['lantaipendaftaran'] = $antrian->lantaipendaftaran;
                $print_karcis->print_karcis($request, $kunjungan);
                // notif wa
                // $wa = new WhatsappController();
                // $request['message'] = "Antrian atas nama pasien " . $antrian->nama . " dengan kode booking " . $antrian->kodebooking . " telah melakukan checkin.\n\n" . $request->keterangan;
                // $request['number'] = $antrian->nohp;
                // $wa->send_message($request);
            } catch (\Throwable $th) {
                return $this->sendError("Error Update Antrian : " . $th->getMessage(), 201);
            }
            return $this->sendResponse("Ok", 200);
        }
        // jika antrian tidak ditemukan
        else {
            return $this->sendError("Kode booking tidak ditemukan", 400);
        }
    }
    public function panggil_dokter(Request $request)
    {
        // checking request
        $validator = Validator::make($request->all(), [
            "kodebooking" => "required",
            "user" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        try {
            $antrian = Antrian::firstWhere('kodebooking', $request->kodebooking);
            $antrian->update([
                'taskid' => 4,
                'taskid4' =>  now(),
                'status_api' => 0,
                'user3' => $request->user,
                'keterangan' => "Panggilan ke poliklinik yang anda pilih",
            ]);
            return $this->sendResponse("Ok", 200);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), 201);
        }
    }
    public function info_pasien_baru(Request $request)
    {
        return $this->sendError("Anda belum memiliki No RM di RSUD Waled (Pasien Baru). Silahkan daftar secara offline.", 400);
        // // auth token
        // $auth = $this->auth_token($request);
        // if ($auth['metadata']['code'] != 200) {
        //     return $auth;
        // }
        // // checking request
        // $validator = Validator::make($request->all(), [
        //     "nik" => "required|digits:16",
        //     "nomorkartu" => "required|digits:13",
        //     "nomorkk" => "required",
        //     "nama" => "required",
        //     "jeniskelamin" => "required",
        //     "tanggallahir" => "required",
        //     "nohp" => "required",
        //     "alamat" => "required",
        //     "kodeprop" => "required",
        //     "namaprop" => "required",
        //     "kodedati2" => "required",
        //     "namadati2" => "required",
        //     "kodekec" => "required",
        //     "namakec" => "required",
        //     "kodekel" => "required",
        //     "namakel" => "required",
        //     "rw" => "required",
        //     "rt" => "required",
        // ]);
        // if ($validator->fails()) {
        //     return [
        //         'metadata' => [
        //             'code' => 201,
        //             'message' => $validator->errors()->first(),
        //         ],
        //     ];
        // }
        // $pasien = PasienDB::where('nik_bpjs', $request->nik)->first();
        // // cek jika pasien baru
        // if (empty($pasien)) {
        //     // proses pendaftaran baru
        //     // try {
        //     //     // checking norm terakhir
        //     //     $pasien_terakhir = PasienDB::latest()->first()->no_rm;
        //     //     $request['status'] = 1;
        //     //     $request['norm'] = $pasien_terakhir + 1;
        //     //     // insert pasien
        //     //     PasienDB::create(
        //     //         [
        //     //             "no_Bpjs" => $request->nomorkartu,
        //     //             "nik_bpjs" => $request->nik,
        //     //             "no_rm" => $request->norm,
        //     //             // "nomorkk" => $request->nomorkk,
        //     //             "nama_px" => $request->nama,
        //     //             "jenis_kelamin" => $request->jeniskelamin,
        //     //             "tgl_lahir" => $request->tanggallahir,
        //     //             "no_tlp" => $request->nohp,
        //     //             "alamat" => $request->alamat,
        //     //             "kode_propinsi" => $request->kodeprop,
        //     //             // "namaprop" => $request->namaprop,
        //     //             "kode_kabupaten" => $request->kodedati2,
        //     //             // "namadati2" => $request->namadati2,
        //     //             "kode_kecamatan" => $request->kodekec,
        //     //             // "namakec" => $request->namakec,
        //     //             "kode_desa" => $request->kodekel,
        //     //             // "namakel" => $request->namakel,
        //     //             // "rw" => $request->rw,
        //     //             // "rt" => $request->rt,
        //     //             // "status" => $request->status,
        //     //         ]
        //     //     );
        //     //     return  $response = [
        //     //         "response" => [
        //     //             "norm" => $request->norm,
        //     //         ],
        //     //         "metadata" => [
        //     //             "message" => "Ok",
        //     //             "code" => 200,
        //     //         ],
        //     //     ];
        //     // } catch (\Throwable $th) {
        //     //     $response = [
        //     //         "metadata" => [
        //     //             "message" => "Gagal Error Code " . $th->getMessage(),
        //     //             "code" => 201,
        //     //         ],
        //     //     ];
        //     //     return $response;
        //     // }
        //     return [
        //         'metadata' => [
        //             'code' => 201,
        //             'message' => 'Mohon maaf untuk pasien baru tidak bisa didaftarkan secara online. Silahkan daftar secara offline dengan datang ke Rumah Sakit',
        //         ],
        //     ];
        // }
        // // cek jika pasien lama
        // else {
        //     $pasien->update([
        //         "no_Bpjs" => $request->nomorkartu,
        //         // "nik_bpjs" => $request->nik,
        //         // "no_rm" => $request->norm,
        //         "nomorkk" => $request->nomorkk,
        //         "nama_px" => $request->nama,
        //         "jenis_kelamin" => $request->jeniskelamin,
        //         "tgl_lahir" => $request->tanggallahir,
        //         "no_tlp" => $request->nohp,
        //         "alamat" => $request->alamat,
        //         "kode_propinsi" => $request->kodeprop,
        //         "namaprop" => $request->namaprop,
        //         "kode_kabupaten" => $request->kodedati2,
        //         "namadati2" => $request->namadati2,
        //         "kode_kecamatan" => $request->kodekec,
        //         "namakec" => $request->namakec,
        //         "kode_desa" => $request->kodekel,
        //         "namakel" => $request->namakel,
        //         "rw" => $request->rw,
        //         "rt" => $request->rt,
        //         // "status" => $request->status,
        //     ]);
        //     return $response = [
        //         "response" => [
        //             "norm" => $pasien->no_rm,
        //         ],
        //         "metadata" => [
        //             "message" => "Ok",
        //             "code" => 200,
        //         ],
        //     ];
        // }
    }
    public function ambil_antrian_farmasi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "kodebooking" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $antrian = Antrian::firstWhere('kodebooking', $request->kodebooking);
        if (empty($antrian)) {
            return $this->sendError("Kode booking tidak ditemukan",  201);
        }
        $request['nomorantrean'] = $antrian->angkaantrean;
        $request['keterangan'] = "resep sistem antrian";
        $request['jenisresep'] = "Racikan/Non Racikan";
        $res = $this->tambah_antrean_farmasi($request);
        $responses = [
            "jenisresep" => $request->jenisresep,
            "nomorantrean" => $request->nomorantrean,
            "keterangan" => $request->keterangan,
        ];
        return $this->sendResponse($responses, 200);
    }
    public function status_antrian_farmasi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "kodebooking" => "required",
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 400);
        }
        $antrian = Antrian::firstWhere('kodebooking', $request->kodebooking);
        if (empty($antrian)) {
            return $this->sendError("Kode booking tidak ditemukan",  201);
        }
        $totalantrean = Antrian::whereDate('tanggalperiksa', $antrian->tanggalperiksa)
            ->where('method', '!=', 'Bridging')
            ->where('taskid', '!=', 99)
            ->count();
        $antreanpanggil = Antrian::whereDate('tanggalperiksa', $antrian->tanggalperiksa)
            ->where('method', '!=', 'Bridging')
            ->where('taskid', 3)
            ->where('status_api', 0)
            ->first();
        $antreansudah = Antrian::whereDate('tanggalperiksa', $antrian->tanggalperiksa)
            ->where('method', '!=', 'Bridging')
            ->where('taskid', 5)->where('status_api', 1)
            ->count();
        $request['totalantrean'] = $totalantrean ?? 0;
        $request['sisaantrean'] = $totalantrean - $antreansudah ?? 0;
        $request['antreanpanggil'] = $antreanpanggil->angkaantrean ?? 0;
        $request['keterangan'] = $antrian->keterangan;
        $request['jenisresep'] = "Racikan/Non Racikan";
        $responses = [
            "jenisresep" => $request->jenisresep,
            "totalantrean" => $request->totalantrean,
            "sisaantrean" => $request->sisaantrean,
            "antreanpanggil" => $request->antreanpanggil,
            "keterangan" => $request->keterangan,
        ];
        return $this->sendResponse($responses, 200);
    }
    function print_karcis(Request $request,  $kunjungan)
    {
        $antrian =  Antrian::firstWhere('kodebooking', $request->kodebooking);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
        $now = Carbon::now();
        if ($request->ip() == "192.168.2.133") {
            $printer = env('PRINTER_CHECKIN');
        } else if ($request->ip() == "192.168.2.51") {
            $printer = env('PRINTER_CHECKIN2');
        } else if ($request->ip() == "192.168.2.218") {
            $printer = env('PRINTER_CHECKIN_MJKN');
        } else {
            $printer = env('PRINTER_CHECKIN3');
        }
        $connector = new WindowsPrintConnector($printer);
        $printer = new Printer($connector);
        $printer->setEmphasis(true);
        $printer->text("ANTRIAN RAWAT JALAN\n");
        $printer->text("RSUD WALED KAB. CIREBON\n");
        $printer->setEmphasis(false);
        $printer->text("================================================\n");
        $printer->text("No. RM : " . $antrian->norm . "\n");
        $printer->text("Nama : " . $antrian->nama . "\n");
        // $printer->text("NIK : " . $request->nik . "\n");
        // $printer->text("No. Kartu JKN : " . $request->nomorkartu . "\n");
        $printer->text("No. Telp. : " . $antrian->nohp . "\n");
        if ($request->jenispasien == "JKN") {
            $printer->text("No. Rujukan : " . $antrian->nomorrujukan . "\n");
            $printer->text("No. Surat Kontrol : " . $antrian->nomorsuratkontrol . "\n");
            $printer->text("No. SEP : " . $antrian->nomorsep . "\n");
        }
        $printer->text("================================================\n");
        $printer->text("Jenis Kunj. : " . $request->jeniskunjungan_print . "\n");
        $printer->text("Poliklinik : " . $antrian->namapoli . "\n");
        $printer->text("Dokter : " . $antrian->namadokter . "\n");
        $printer->text("Jam Praktek : " . $antrian->jampraktek . "\n");
        $printer->text("Tanggal : " . Carbon::parse($antrian->tanggalperiksa)->format('d M Y') . "\n");
        $printer->text("================================================\n");
        $printer->text("Keterangan : \n" . $request->keterangan . "\n");
        if ($request->jenispasien != "JKN") {
            $printer->text("================================================\n");
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text("Biaya Karcis Poli : " . money($request->tarifkarcis, 'IDR') . "\n");
            $printer->text("Biaya Administrasi : " . money($request->tarifadm, 'IDR') . "\n");
        }
        $printer->text("================================================\n");
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("Jenis Pasien :\n");
        $printer->setTextSize(2, 2);
        $printer->text($antrian->jenispasien . "\n");
        $printer->setTextSize(1, 1);
        $printer->text("Kode Booking : " . $antrian->kodebooking . "\n");
        $printer->text("Kode Kunjungan : " . $kunjungan->kode_kunjungan . "\n");
        // $printer->qrCode($request->kodebooking, Printer::QR_ECLEVEL_L, 10, Printer::QR_MODEL_2);
        $printer->text("================================================\n");
        $printer->text("Nomor Antrian Poliklinik :\n");
        $printer->setTextSize(2, 2);
        $printer->text($antrian->nomorantrean . "\n");
        $printer->setTextSize(1, 1);
        $printer->text("Lokasi Poliklinik Lantai " . $antrian->lokasi . " \n");
        $printer->text("================================================\n");
        $printer->text("Angka Antrian :\n");
        $printer->setTextSize(2, 2);
        $printer->text($antrian->angkaantrean . "\n");
        $printer->setTextSize(1, 1);
        $printer->text("Lokasi Pendaftaran Lantai " . $antrian->lantaipendaftaran . " \n");
        $printer->text("================================================\n");
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("Waktu Cetak : " . $now . "\n");
        $printer->cut();
        $printer->close();
    }
    public function print_ulang(Request $request)
    {
        $antrian = Antrian::firstWhere('kodebooking', $request->kodebooking);
        $unit = Unit::firstWhere('KDPOLI', $antrian->kodepoli);
        $tarifkarcis = TarifLayananDetail::firstWhere('KODE_TARIF_DETAIL', $unit->kode_tarif_karcis);
        $tarifadm = TarifLayananDetail::firstWhere('KODE_TARIF_DETAIL', $unit->kode_tarif_adm);
        // print antrian
        if ($antrian->pasienbaru == 0) {
            $request['pasienbaru_print'] = 'LAMA';
        } else {
            $request['pasienbaru_print'] = 'BARU';
        }
        $request['keterangan'] = "Print Ulang Karcis Antrian, untuk pasien JKN dapat langsung menunggu panggilan dipoliklinik";
        switch ($antrian->jeniskunjungan) {
            case '1':
                $request['jeniskunjungan_print'] = 'RUJUKAN FKTP';
                break;
            case '2':
                $request['jeniskunjungan_print'] = 'UMUM';
                break;
            case '3':
                if (isset($antrian->nomorreferensi)) {
                    $request['jeniskunjungan_print'] = 'KONTROL';
                } else {
                    $request['keterangan'] = "Print Ulang Karcis Antrian, untuk pasien NON-JKN silahkan lakukan pembayaran di Loken Pembayaran";
                    $request['jeniskunjungan_print'] = 'KUNJUNGAN UMUM';
                }
                break;
            case '4':
                $request['jeniskunjungan_print'] = 'RUJUKAN RS';
                break;
            default:
                break;
        }
        $request['tarifkarcis'] = $tarifkarcis->tarif_rajal;
        $request['tarifadm'] = $tarifadm->tarif_rajal;
        $request['norm'] = $antrian->norm;
        $request['nama'] = $antrian->nama;
        $request['nik'] = $antrian->nik;
        $request['nomorkartu'] = $antrian->nomorkartu;
        $request['nohp'] = $antrian->nohp;
        $request['nomorrujukan'] = $antrian->nomorrujukan;
        $request['nomorsuratkontrol'] = $antrian->nomorsuratkontrol;
        $request['namapoli'] = $antrian->namapoli;
        $request['namadokter'] = $antrian->namadokter;
        $request['jampraktek'] = $antrian->jampraktek;
        $request['tanggalperiksa'] = $antrian->tanggalperiksa;
        $request['jenispasien'] = $antrian->jenispasien;
        $request['nomorantrean'] = $antrian->nomorantrean;
        $request['lokasi'] = $antrian->lokasi;
        $request['angkaantrean'] = $antrian->angkaantrean;
        $request['lantaipendaftaran'] = $antrian->lantaipendaftaran;
        $request['nomorsep'] = $antrian->nomorsep;
        $request['keterangan'] = $antrian->keterangan;
        $kunjungan = Kunjungan::firstWhere('kode_kunjungan', $antrian->kode_kunjungan);
        // print
        $this->print_karcis($request, $kunjungan);
        if ($antrian->jenispasien == "JKN") {
            $api = new VclaimController();
            $request['noSep'] = $antrian->nomorsep;
            $response = $api->sep_nomor($request);
            if ($response->metadata->code == 200) {
                $sep =  $response->response;
                $this->print_sep($request, $sep);
            } else {
                return  $this->sendError($response->metadata->message, 400);
            }
        }
        return  $this->sendResponse("Print Ulang Berhasil", 201);
    }
    function print_sep(Request $request, $sep)
    {
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
        $now = Carbon::now();
        $for_sep = ['POLIKLINIK', 'FARMASI', 'ARSIP'];
        // $for_sep = ['PERCOBAAN'];
        foreach ($for_sep as  $value) {
            if ($request->ip() == "192.168.2.133") {
                $printer = env('PRINTER_CHECKIN');
            } else if ($request->ip() == "192.168.2.51") {
                $printer = env('PRINTER_CHECKIN2');
            } else if ($request->ip() == "192.168.2.218") {
                $printer = env('PRINTER_CHECKIN_MJKN');
            } else {
                $printer = env('PRINTER_CHECKIN3');
            }
            $connector = new WindowsPrintConnector($printer);
            $printer = new Printer($connector);
            $printer->setEmphasis(true);
            $printer->text("SURAT ELEGTABILITAS PASIEN (SEP)\n");
            $printer->text("RSUD WALED KAB. CIREBON\n");
            $printer->setEmphasis(false);
            $printer->text("================================================\n");
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("SEP untuk " . $value . "\n");
            $printer->text("Nomor SEP :\n");
            $printer->setTextSize(2, 2);
            $printer->setEmphasis(true);
            $printer->text($sep->noSep . "\n");
            $printer->setEmphasis(false);
            $printer->setTextSize(1, 1);
            $printer->text("Tgl SEP : " . $sep->tglSep . " \n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("================================================\n");
            $printer->text("Nama Pasien : " . $sep->peserta->nama . " \n");
            $printer->text("Nomor Kartu : " . $sep->peserta->noKartu . " \n");
            $printer->text("No. RM : " . $request->norm . "\n");
            $printer->text("No. Telepon : " . $request->nohp . "\n");
            $printer->text("Hak Kelas : " . $sep->peserta->hakKelas . " \n");
            $printer->text("Jenis Peserta : " . $sep->peserta->jnsPeserta . " \n\n");
            $printer->text("Jenis Pelayanan : " . $sep->jnsPelayanan . " \n");
            $printer->text("Poli / Spesialis : " . $sep->poli . "\n");
            $printer->text("COB : -\n");
            $printer->text("Diagnosa Awal : " . $sep->diagnosa . "\n");
            // $printer->text("Faskes Perujuk : " . $request->faskesPerujuk . "\n");
            $printer->text("Catatan : " . $sep->catatan . "\n\n");
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text("Cirebon, " . $now->format('d-m-Y') . " \n\n\n\n");
            $printer->text("RSUD Waled \n\n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("Cetakan : " . $now . "\n");
            $printer->cut();
            $printer->close();
        }
    }
}
