<?php

use App\Http\Controllers\AntrianController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\BukuTamuController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\FarmasiController;
use App\Http\Controllers\FileRekamMedisController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JadwalDokterController;
use App\Http\Controllers\JadwalOperasiController;
use App\Http\Controllers\KPOController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\ParamedisController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PoliklinikController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RujukanController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\SuratKontrolController;
use App\Http\Controllers\SuratLampiranController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\ThermalPrintController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VclaimController;
use App\Http\Controllers\WhatsappController;
use App\Http\Controllers\LaporanPenyakitRawatJalanController;
use App\Http\Controllers\LaporanPenyakitRawatInapController;
use App\Http\Controllers\LaporanPenyakitRawatInapPenelitianController;
use App\Http\Controllers\LaporanPenyakitRawatJalanPenelitianController;
use App\Http\Controllers\LaporanDiagnosaSurvailansInapController;
use App\Http\Controllers\LaporanDiagnosaSurvailansRawatJalanController;
use App\Http\Controllers\FormulirRL1Controller;
use App\Http\Controllers\FormulirRL2Controller;
use App\Http\Controllers\FormulirRL3Controller;
use App\Http\Controllers\FormulirRL4Controller;
use App\Http\Controllers\FormulirRL5Controller;
use App\Http\Controllers\CPPTController;
use App\Http\Controllers\InacbgController;
use App\Http\Controllers\JabatanKerjaController;
use App\Http\Controllers\KepegawaianController;
use App\Http\Controllers\KebutuhanJurusanController;
use App\Http\Livewire\Users;
use App\Models\JadwalDokter;
use App\Models\Pasien;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// route default
Route::get('', [HomeController::class, 'landingpage'])->name('landingpage'); #ok
Auth::routes(['register' => false]); #ok
Route::get('verifikasi_akun', [VerificationController::class, 'verifikasi_akun'])->name('verifikasi_akun');
Route::post('verifikasi_kirim', [VerificationController::class, 'verifikasi_kirim'])->name('verifikasi_kirim');
Route::get('user_verifikasi/{user}', [UserController::class, 'user_verifikasi'])->name('user_verifikasi');
Route::get('delet_verifikasi', [UserController::class, 'delet_verifikasi'])->name('delet_verifikasi');
Route::get('login/google/redirect', [SocialiteController::class, 'redirect'])->middleware(['guest'])->name('login.google'); #redirect google login
Route::get('login/google/callback', [SocialiteController::class, 'callback'])->middleware(['guest'])->name('login.goole.callback'); #callback google login
// layanan umum
Route::get('bukutamu', [BukuTamuController::class, 'bukutamu'])->name('bukutamu');
Route::post('bukutamu', [BukuTamuController::class, 'store'])->name('bukutamu_store');
Route::post('printerlabel', [ThermalPrintController::class, 'printerlabel'])->name('printerlabel');
Route::get('suratkontrol_print', [SuratKontrolController::class, 'print'])->name('suratkontrol_print');
// mesin antrian
Route::get('antrianConsole', [AntrianController::class, 'antrianConsole'])->name('antrianConsole');
Route::get('checkinAntrian', [AntrianController::class, 'checkinAntrian'])->name('checkinAntrian');
Route::get('checkinCetakSEP', [AntrianController::class, 'checkinCetakSEP'])->name('checkinCetakSEP');
Route::get('checkinKarcisAntrian', [AntrianController::class, 'checkinKarcisAntrian'])->name('checkinKarcisAntrian');
Route::get('jadwaldokterPoli', [JadwalDokterController::class, 'jadwaldokterPoli'])->name('jadwaldokterPoli');
Route::get('daftarBpjsOffline', [AntrianController::class, 'daftarBpjsOffline'])->name('daftarBpjsOffline');
Route::get('daftarUmumOffline', [AntrianController::class, 'daftarUmumOffline'])->name('daftarUmumOffline');
Route::get('cekPrinter', [AntrianController::class, 'cekPrinter'])->name('cekPrinter');
Route::get('checkinUpdate', [AntrianController::class, 'checkinUpdate'])->name('checkinUpdate');
// cppt
Route::get('cppt', [CPPTController::class, 'getCPPT'])->name('cppt.get');
Route::get('cppt_print', [CPPTController::class, 'getCPPTPrint'])->name('cppt-rajal-print.get');
Route::get('cppt_print_anestesi', [CPPTController::class, 'getCPPTPrintAnestesi'])->name('cppt-anestesi-print.get');
Route::get('home', [HomeController::class, 'index'])->name('home'); #ok
Route::middleware('auth')->group(function () {
    Route::get('profile', [UserController::class, 'profile'])->name('profile'); #ok
    // settingan umum
    Route::get('get_city', [LaravotLocationController::class, 'get_city'])->name('get_city');
    Route::get('get_district', [LaravotLocationController::class, 'get_district'])->name('get_district');
    Route::get('get_village', [LaravotLocationController::class, 'get_village'])->name('get_village');
    Route::get('cekBarQRCode', [BarcodeController::class, 'cekBarQRCode'])->name('cekBarQRCode');
    Route::get('cekThermalPrinter', [ThermalPrintController::class, 'cekThermalPrinter'])->name('cekThermalPrinter');
    Route::get('testThermalPrinter', [ThermalPrintController::class, 'testThermalPrinter'])->name('testThermalPrinter');
    Route::get('whatsapp', [WhatsappController::class, 'whatsapp'])->name('whatsapp');
    // route resource
    Route::resource('user', UserController::class);
    Route::resource('role', RoleController::class);
    Route::resource('permission', PermissionController::class);
    Route::resource('poliklinik', PoliklinikController::class);
    Route::resource('unit', UnitController::class);
    Route::resource('dokter', DokterController::class);
    Route::resource('paramedis', ParamedisController::class);
    Route::resource('jadwaldokter', JadwalDokterController::class);
    Route::resource('jadwaloperasi', JadwalOperasiController::class);
    Route::resource('suratmasuk', SuratMasukController::class);
    Route::resource('suratlampiran', SuratLampiranController::class);
    Route::resource('disposisi', DisposisiController::class);
    Route::resource('pasien', PasienController::class);
    Route::resource('kunjungan', KunjunganController::class);
    Route::resource('efilerm', FileRekamMedisController::class);
    Route::resource('antrian', AntrianController::class);
    Route::resource('suratkontrol', SuratKontrolController::class);
    Route::resource('obat', ObatController::class);
    Route::resource('kpo', KPOController::class);
    Route::resource('suratkontrol', SuratKontrolController::class);
    Route::resource('vclaim', VclaimController::class);
    // pendaftaran
    Route::get('antrianPendaftaran', [AntrianController::class, 'antrianPendaftaran'])->name('antrianPendaftaran');
    Route::get('jadwalDokterAntrian', [JadwalDokterController::class, 'index'])->name('jadwalDokterAntrian');
    Route::post('daftarBridgingAntrian', [AntrianController::class, 'daftarBridgingAntrian'])->name('daftarBridgingAntrian');
    Route::get('selanjutnyaPendaftaran/{loket}/{lantai}/{jenispasien}/{tanggal}', [AntrianController::class, 'selanjutnyaPendaftaran'])->name('selanjutnyaPendaftaran');
    Route::get('panggilPendaftaran/{kodebooking}/{loket}/{lantai}', [AntrianController::class, 'panggilPendaftaran'])->name('panggilPendaftaran');
    Route::get('selesaiPendaftaran', [AntrianController::class, 'selesaiPendaftaran'])->name('selesaiPendaftaran');
    Route::get('antrianCapaian', [AntrianController::class, 'antrianCapaian'])->name('antrianCapaian');
    // poliklinik
    Route::get('antrianPoliklinik', [AntrianController::class, 'antrianPoliklinik'])->name('antrianPoliklinik');
    Route::get('batalAntrian', [AntrianController::class, 'batalAntrian'])->name('batalAntrian');
    Route::get('panggilPoliklinik', [AntrianController::class, 'panggilPoliklinik'])->name('panggilPoliklinik');
    Route::get('panggilUlangPoliklinik', [AntrianController::class, 'panggilUlangPoliklinik'])->name('panggilUlangPoliklinik');
    Route::get('lanjutFarmasi', [AntrianController::class, 'lanjutFarmasi'])->name('lanjutFarmasi');
    Route::get('lanjutFarmasiRacikan', [AntrianController::class, 'lanjutFarmasiRacikan'])->name('lanjutFarmasiRacikan');
    Route::get('selesaiPoliklinik', [AntrianController::class, 'selesaiPoliklinik'])->name('selesaiPoliklinik');
    Route::get('kunjunganPoliklinik', [AntrianController::class, 'kunjunganPoliklinik'])->name('kunjunganPoliklinik');
    Route::get('jadwalDokterPoliklinik', [JadwalDokterController::class, 'jadwalDokterPoliklinik'])->name('jadwalDokterPoliklinik');
    Route::get('pasienPoliklinik', [PasienController::class, 'index'])->name('pasienPoliklinik');
    Route::get('laporanAntrianPoliklinik', [AntrianController::class, 'laporanAntrianPoliklinik'])->name('laporanAntrianPoliklinik');
    Route::get('laporanKunjunganPoliklinik', [KunjunganController::class, 'laporanKunjunganPoliklinik'])->name('laporanKunjunganPoliklinik');
    Route::get('dashboardTanggalAntrianPoliklinik', [AntrianController::class, 'dashboardTanggalAntrian'])->name('dashboardTanggalAntrianPoliklinik');
    Route::get('dashboardBulanAntrianPoliklinik', [AntrianController::class, 'dashboardBulanAntrian'])->name('dashboardBulanAntrianPoliklinik');
    Route::get('suratKontrolPrint/{suratkontrol}', [SuratKontrolController::class, 'suratKontrolPrint'])->name('suratKontrolPrint');
    // ranap
    Route::get('pasienRanapAktif', [KunjunganController::class, 'pasienRanapAktif'])->name('pasienRanapAktif');
    Route::post('claim_ranap', [InacbgController::class, 'claim_ranap'])->name('claim_ranap');
    // farmasi
    Route::get('antrianFarmasi', [AntrianController::class, 'antrianFarmasi'])->name('antrianFarmasi');
    Route::get('getAntrianFarmasi', [AntrianController::class, 'getAntrianFarmasi'])->name('getAntrianFarmasi');
    Route::get('racikFarmasi/{kodebooking}', [AntrianController::class, 'racikFarmasi'])->name('racikFarmasi');
    Route::get('selesaiFarmasi/{kodebooking}', [AntrianController::class, 'selesaiFarmasi'])->name('selesaiFarmasi');
    Route::get('tracerOrderObat', [FarmasiController::class, 'tracerOrderObat'])->name('tracerOrderObat');
    Route::get('orderFarmasi', [FarmasiController::class, 'orderFarmasi'])->name('orderFarmasi');
    Route::get('cetakOrderFarmasi', [FarmasiController::class, 'cetakOrderFarmasi'])->name('cetakOrderFarmasi');
    Route::get('selesaiOrderFarmasi', [FarmasiController::class, 'selesaiOrderFarmasi'])->name('selesaiOrderFarmasi');
    Route::get('getOrderObat', [FarmasiController::class, 'getOrderObat'])->name('getOrderObat');
    Route::get('getOrderResep', [FarmasiController::class, 'getOrderResep'])->name('getOrderResep');
    Route::get('cetakUlangOrderObat', [FarmasiController::class, 'cetakUlangOrderObat'])->name('cetakUlangOrderObat');
    Route::get('kpo/tanggal/{tanggal}', [KPOController::class, 'kunjungan_tanggal'])->name('kpo.kunjungan_tanggal');
    Route::get('kpoRanap', [KPOController::class, 'kpoRanap'])->name('kpoRanap');
    Route::get('kunjunganRanap', [KunjunganController::class, 'kunjunganRanap'])->name('kunjunganRanap');
    // rekammedis
    Route::get('diagnosaRawatJalan', [PoliklinikController::class, 'diagnosaRawatJalan'])->name('diagnosaRawatJalan');
    // antrian bpjs
    Route::get('statusAntrianBpjs', [AntrianController::class, 'statusAntrianBpjs'])->name('statusAntrianBpjs');
    Route::get('poliklikAntrianBpjs', [PoliklinikController::class, 'poliklikAntrianBpjs'])->name('poliklikAntrianBpjs');
    Route::get('dokterAntrianBpjs', [DokterController::class, 'dokterAntrianBpjs'])->name('dokterAntrianBpjs');
    Route::get('resetDokter', [DokterController::class, 'resetDokter'])->name('resetDokter');
    Route::get('jadwalDokterAntrianBpjs', [JadwalDokterController::class, 'jadwalDokterAntrianBpjs'])->name('jadwalDokterAntrianBpjs');
    Route::get('fingerprintPeserta', [PasienController::class, 'fingerprintPeserta'])->name('fingerprintPeserta');
    Route::get('antrianBpjsConsole', [AntrianController::class, 'antrianConsole'])->name('antrianBpjsConsole');
    Route::get('antrianBpjs', [AntrianController::class, 'antrianBpjs'])->name('antrianBpjs');
    Route::get('listTaskID', [AntrianController::class, 'listTaskID'])->name('listTaskID');
    Route::get('dashboardTanggalAntrian', [AntrianController::class, 'dashboardTanggalAntrian'])->name('dashboardTanggalAntrian');
    Route::get('dashboardBulanAntrian', [AntrianController::class, 'dashboardBulanAntrian'])->name('dashboardBulanAntrian');
    Route::get('jadwalOperasi', [JadwalOperasiController::class, 'jadwalOperasi'])->name('jadwalOperasi');
    Route::get('antrianPerTanggal', [AntrianController::class, 'antrianPerTanggal'])->name('antrianPerTanggal');
    Route::get('antrianPerKodebooking', [AntrianController::class, 'antrianPerKodebooking'])->name('antrianPerKodebooking');
    Route::get('antrianBelumDilayani', [AntrianController::class, 'antrianBelumDilayani'])->name('antrianBelumDilayani');
    Route::get('antrianPerDokter', [AntrianController::class, 'antrianPerDokter'])->name('antrianPerDokter');
    // vclaim bpjs
    Route::get('monitoringDataKunjungan', [VclaimController::class, 'monitoringDataKunjungan'])->name('monitoringDataKunjungan');
    Route::get('monitoringDataKlaim', [VclaimController::class, 'monitoringDataKlaim'])->name('monitoringDataKlaim');
    Route::get('monitoringPelayananPeserta', [VclaimController::class, 'monitoringPelayananPeserta'])->name('monitoringPelayananPeserta');
    Route::get('monitoringKlaimJasaraharja', [VclaimController::class, 'monitoringKlaimJasaraharja'])->name('monitoringKlaimJasaraharja');
    Route::get('referensiVclaim', [VclaimController::class, 'referensiVclaim'])->name('referensiVclaim');
    Route::get('ref_diagnosa_api', [VclaimController::class, 'ref_diagnosa_api'])->name('ref_diagnosa_api');
    Route::get('ref_poliklinik_api', [VclaimController::class, 'ref_poliklinik_api'])->name('ref_poliklinik_api');
    Route::get('ref_faskes_api', [VclaimController::class, 'ref_faskes_api'])->name('ref_faskes_api');
    Route::get('ref_dpjp_api', [VclaimController::class, 'ref_dpjp_api'])->name('ref_dpjp_api');
    Route::get('ref_provinsi_api', [VclaimController::class, 'ref_provinsi_api'])->name('ref_provinsi_api');
    Route::get('ref_kabupaten_api', [VclaimController::class, 'ref_kabupaten_api'])->name('ref_kabupaten_api');
    Route::get('ref_kecamatan_api', [VclaimController::class, 'ref_kecamatan_api'])->name('ref_kecamatan_api');
    Route::get('suratKontrolBpjs', [SuratKontrolController::class, 'suratKontrolBpjs'])->name('suratKontrolBpjs');

    // suratkontrol
    Route::post('suratkontrol_simpan', [SuratKontrolController::class, 'suratkontrol_simpan'])->name('suratkontrol_simpan');
    Route::get('suratkontrol_edit', [SuratKontrolController::class, 'suratkontrol_edit'])->name('suratkontrol_edit');
    Route::post('suratkontrol_update', [SuratKontrolController::class, 'suratkontrol_update'])->name('suratkontrol_update');
    Route::get('suratkontrol_delete', [SuratKontrolController::class, 'suratkontrol_delete'])->name('suratkontrol_delete');
    // sep
    Route::post('pemulangan_sep_pasien', [KunjunganController::class, 'pemulangan_sep_pasien'])->name('pemulangan_sep_pasien');



    Route::get('rujukanBpjs', [RujukanController::class, 'rujukanBpjs'])->name('rujukanBpjs');
    Route::post('update_claim', [InacbgController::class, 'update_claim'])->name('update_claim');
    // laporan penyakit rawat jalan
    Route::get('LaporanPenyakitRawatJalan', [LaporanPenyakitRawatJalanController::class, 'LaporanPenyakitRawatJalan'])->name('laporan-rawa-jalan.get');
    Route::get('LaporanPenyakitRawatJalan/Export', [LaporanPenyakitRawatJalanController::class, 'exportExcel'])->name('laporan-rawa-jalan.export');
    Route::get('LaporanPenyakitRawatJalan/Data', [LaporanPenyakitRawatJalanController::class, 'dataAjax'])->name('laporan-rawa-jalan.dataAjax');
    // penyakit rawat jalan by yaers
    Route::get('LaporanPenyakitRawatJalanbyYears', [LaporanPenyakitRawatJalanPenelitianController::class, 'LaporanPenyakitRawatJalan'])->name('laporan-rawa-jalanbyYears.get');
    Route::get('LaporanPenyakitRawatJalanbyYears/Export', [LaporanPenyakitRawatJalanPenelitianController::class, 'exportExcel'])->name('laporan-rawa-jalanbyYears.export');
    // laporan penyakit rawat Inap
    Route::get('LaporanPenyakitRawatInap', [LaporanPenyakitRawatInapController::class, 'LaporanPenyakitRawatInap'])->name('laporan-rawa-inap.get');
    Route::get('LaporanPenyakitRawatInap/Export', [LaporanPenyakitRawatInapController::class, 'exportExcel'])->name('laporan-rawa-inap.export');
    Route::get('LaporanPenyakitRawatInap/Data', [LaporanPenyakitRawatInapController::class, 'dataAjax'])->name('laporan-rawa-inap.dataAjax');
    // penyakit rawat Inap by years
    Route::get('LaporanPenyakitRawatInapbyYears', [LaporanPenyakitRawatInapPenelitianController::class, 'LaporanPenyakitRawatInap'])->name('laporan-rawa-inapByYear.get');
    Route::get('LaporanPenyakitRawatInapbyYears/Export', [LaporanPenyakitRawatInapPenelitianController::class, 'exportExcel'])->name('laporan-rawa-inapByYear.export');
    // laporan survailans rawat inap
    Route::get('LaporanDiagnosaSurvailansInap', [LaporanDiagnosaSurvailansInapController::class, 'LaporanSurvailans'])->name('laporan-survailans.get');
    Route::get('LaporanDiagnosaSurvailansInap/Export', [LaporanDiagnosaSurvailansInapController::class, 'exportExcel'])->name('laporan-survailans.export');
    // laporan survailans rawat jalan
    Route::get('LaporanDiagnosaSurvailansRawatJalan', [LaporanDiagnosaSurvailansRawatJalanController::class, 'LaporanSurvailans'])->name('laporan-survailans-rajal.get');
    Route::get('LaporanDiagnosaSurvailansRawatJalan/Export', [LaporanDiagnosaSurvailansRawatJalanController::class, 'exportExcel'])->name('laporan-survailans-rajal.export');
    // formulir RL 1
    Route::get('FormulirRL1', [FormulirRL1Controller::class, 'FormulirRL1'])->name('frl-1.get');
    Route::get('FormulirRL1_2', [FormulirRL1Controller::class, 'FormulirRL1_2'])->name('frl-1-2.get');
    Route::get('FormulirRL1_3', [FormulirRL1Controller::class, 'FormulirRL1_3'])->name('frl-1-3.get');
    // formulir RL 2
    Route::get('FormulirRL2', [FormulirRL2Controller::class, 'FormulirRL2'])->name('frl-2.get');
    // formulir RL 3
    Route::get('FormulirRL3_1', [FormulirRL3Controller::class, 'FormulirRL3_1'])->name('frl-3-1.get');
    Route::get('FormulirRL3_2', [FormulirRL3Controller::class, 'FormulirRL3_2'])->name('frl-3-2.get');
    Route::get('FormulirRL3_3', [FormulirRL3Controller::class, 'FormulirRL3_3'])->name('frl-3-3.get');
    Route::get('FormulirRL3_4', [FormulirRL3Controller::class, 'FormulirRL3_4'])->name('frl-3-4.get');
    Route::get('FormulirRL3_5', [FormulirRL3Controller::class, 'FormulirRL3_5'])->name('frl-3-5.get');
    Route::get('FormulirRL3_6', [FormulirRL3Controller::class, 'FormulirRL3_6'])->name('frl-3-6.get');
    Route::get('FormulirRL3_7', [FormulirRL3Controller::class, 'FormulirRL3_7'])->name('frl-3-7.get');
    Route::get('FormulirRL3_8', [FormulirRL3Controller::class, 'FormulirRL3_8'])->name('frl-3-8.get');
    Route::get('FormulirRL3_9', [FormulirRL3Controller::class, 'FormulirRL3_9'])->name('frl-3-9.get');
    Route::get('FormulirRL3_10', [FormulirRL3Controller::class, 'FormulirRL3_10'])->name('frl-3-10.get');
    Route::get('FormulirRL3_11', [FormulirRL3Controller::class, 'FormulirRL3_11'])->name('frl-3-11.get');
    Route::get('FormulirRL3_12', [FormulirRL3Controller::class, 'FormulirRL3_12'])->name('frl-3-12.get');
    Route::get('FormulirRL3_13', [FormulirRL3Controller::class, 'FormulirRL3_13'])->name('frl-3-13.get');
    Route::get('FormulirRL3_14', [FormulirRL3Controller::class, 'FormulirRL3_14'])->name('frl-3-14.get');
    Route::get('FormulirRL3_15', [FormulirRL3Controller::class, 'FormulirRL3_15'])->name('frl-3-15.get');
    // formulir RL 4
    Route::get('FormulirRL4A', [FormulirRL4Controller::class, 'FormulirRL4A'])->name('frl-4-A.get');
    Route::get('FormulirRL4AK', [FormulirRL4Controller::class, 'FormulirRL4AK'])->name('frl-4-AK.get');
    Route::get('FormulirRL4B', [FormulirRL4Controller::class, 'FormulirRL4B'])->name('frl-4-B.get');
    Route::get('FormulirRL4BK', [FormulirRL4Controller::class, 'FormulirRL4BK'])->name('frl-4-BK.get');
    // formulir RL 5
    Route::get('FormulirRL5_1', [FormulirRL5Controller::class, 'FormulirRL5_1'])->name('frl-5-1.get');
    Route::get('FormulirRL5_2', [FormulirRL5Controller::class, 'FormulirRL5_2'])->name('frl-5-2.get');
    Route::get('FormulirRL5_3', [FormulirRL5Controller::class, 'FormulirRL5_3'])->name('frl-5-3.get');
    // Route::get('FormulirRL5_3_Perunit', [FormulirRL5Controller::class, 'FormulirRL5_3Perunit'])->name('frl-53perunit.get');
    Route::post('FormulirRL5_3/DaftarPenyakitRawatInap', [FormulirRL5Controller::class, 'FormulirRL5_3P'])->name('get-rl-5-3-d');
    Route::get('FormulirRL5_4', [FormulirRL5Controller::class, 'FormulirRL5_4'])->name('frl-5_4.get');
    Route::post('FormulirRL5_4/DaftarPenyakitRawatJalan', [FormulirRL5Controller::class, 'FormulirRL5_4P'])->name('get-rl-5-4-u');
    Route::get('FormulirRL5_5', [FormulirRL5Controller::class, 'FormulirRL5_5'])->name('frl-5_5.get');
    // custom frl 5.4
    Route::get('cetakresumedokter/{rm}/{counter}/{kode_unit}', [CPPTController::class, 'getResumeDokter'])->name('resume-dokter.get');
    Route::get('getK', [CPPTController::class, 'getK'])->name('resume-dokter-k.get');
    Route::get('getC', [CPPTController::class, 'getC'])->name('resume-dokter-c.get');
    // jabatan Kerja
    Route::get('data-jabatan', [JabatanKerjaController::class, 'dataJabatan'])->name('jabatan-kepeg.get');
    Route::post('tambah-jabatan', [JabatanKerjaController::class, 'addJabatan'])->name('jabatan.add');
    Route::get('data-jabatan/{id_jabatan}/edit', [JabatanKerjaController::class, 'editJabatan'])->name('jabatan-kepeg.edit');
    Route::put('data-jabatan/{id_jabatan}/update', [JabatanKerjaController::class, 'updateJabatan'])->name('jabatan-kepeg.update');
    Route::post('tambah-bidang', [JabatanKerjaController::class, 'addBidang'])->name('bidang.add');
    Route::post('bidang-pegawai', [JabatanKerjaController::class, 'dataBidang'])->name('import-data-bidang');
    Route::get('data-bidang/{id_bidang}/edit', [JabatanKerjaController::class, 'editBidang'])->name('bidang-kepeg.edit');
    Route::put('data-bidang/{id_bidang}/update', [JabatanKerjaController::class, 'updateBidang'])->name('bidang-kepeg.update');
    // kepegawaian
    Route::get('data-pegawai', [KepegawaianController::class, 'vData'])->name('data-kepeg.get');
    Route::get('data-pegawai-add', [KepegawaianController::class, 'pegawaiAdd'])->name('data-kepeg.add');
    Route::post('data-pegawai-store', [KepegawaianController::class, 'pegawaiStore'])->name('data-kepeg.store');
    Route::post('data-pegawai/import', [KepegawaianController::class, 'importData'])->name('import-data');
    Route::get('data-pegawai/{id}/edit', [KepegawaianController::class, 'editPegawai'])->name('data-kepeg.edit');
    Route::put('data-pegawai/update/{id}', [KepegawaianController::class, 'updatePegawai'])->name('data-kepeg.update');
    Route::post('data-pegawai/set-pegawai/{id}', [KepegawaianController::class, 'setStatusPegawai'])->name('data-kepeg.setstatus');
    Route::get('pegawai-nonaktif', [KepegawaianController::class, 'pegawaiNonaktif'])->name('pegawai-nonaktif.get');
    Route::post('data-pegawai/set-pegawai-aktif/{id}', [KepegawaianController::class, 'setStatusPegawaiAktif'])->name('data-kepeg.setstatusaktif');
    Route::get('pegawai-mutasi', [KepegawaianController::class, 'pegawaiMutasi'])->name('pegawai-mutasi.get');
    Route::get('pegawai-mutasi-add', [KepegawaianController::class, 'pegawaiMutasiAdd'])->name('pegawai-mutasi.add');
    Route::post('pegawai-mutasi-store', [KepegawaianController::class, 'pegawaiMutasiStore'])->name('pegawai-mutasi.store');
    Route::post('kebutuhan-jurusan/import', [KebutuhanJurusanController::class, 'importJurusan'])->name('data-jurusan.import');
    Route::get('kebutuhan-jurusan', [KebutuhanJurusanController::class, 'kebutuhanJurusan'])->name('data-jurusan.get');
    Route::post('kebutuhan-jurusan-add', [KebutuhanJurusanController::class, 'kebutuhanJurusanAdd'])->name('data-jurusan.add');
    Route::get('kebutuhan-jurusan/{id}/edit', [KebutuhanJurusanController::class, 'editKebutuhan'])->name('data-kebutuhan.edit');
    Route::put('kebutuhan-jurusan/update/{id}', [KebutuhanJurusanController::class, 'updateKebutuhan'])->name('data-kebutuhan.update');
    // mining pasien igd
    //HAPUS
    Route::get('/mining-pasien', [App\Http\Controllers\KarcisAntrianIGDController::class, 'getPasienIGD'])->name('mining-pasien-igd');
    Route::get('/karcis-igd', [App\Http\Controllers\KarcisAntrianIGDController::class, 'daftarKarcis'])->name('d-karcis-igd');
    Route::post('/karcis-igd-create', [App\Http\Controllers\KarcisAntrianIGDController::class, 'createKarcisAntrian'])->name('d-karcis-igd-create');

    //DASHBOARD IGD
    Route::get('/dashboard-igd', [App\Http\Controllers\DashboardIGDController::class, 'getDataAll'])->name('dashboard-igd');
    Route::get('/pendaftaran-pasien-igd', [App\Http\Controllers\PendaftaranPasienIGDController::class, 'pilihPasienPendaftaran'])->name('pendaftaran.pasien');
    Route::get('/pendaftaran-pasien-bayi', [App\Http\Controllers\IGDBAYIController::class, 'pendaftaranPasienBayi'])->name('pendaftaranpasien.bayi');
    Route::get('/cari-orangtua-bayi', [App\Http\Controllers\IGDBAYIController::class, 'cariOrangtua'])->name('cari-ortu.bayi');
    Route::post('/pasien-bayi-create', [App\Http\Controllers\IGDBAYIController::class, 'pasienBayiCreate'])->name('pasien_bayi.create');

    //ROUTE ANTRIAN IGD 
    Route::get('/pendaftaran-antrian-igd', [App\Http\Controllers\AntrianIGDController::class, 'antrianIGD'])->name('d-antrian-igd');
    Route::get('/cari-pasien', [App\Http\Controllers\AntrianIGDController::class, 'searchPasien'])->name('pasien-igd-search');
    Route::post('/cari-pasien-byname', [App\Http\Controllers\AntrianIGDController::class, 'searchPasienByName'])->name('pasien-igd-search-byname');
    Route::get('/get-no-antrian', [App\Http\Controllers\AntrianIGDController::class, 'getNoAntrian'])->name('get-no-antrian');
    Route::post('/daftarkan-pasien-baru', [App\Http\Controllers\AntrianIGDController::class, 'pasienBaruCreate'])->name('pasien-baru.create');
    
    Route::post('/pasien-antrian/terpilih', [App\Http\Controllers\AntrianIGDController::class, 'antrianPasienUMUMTerpilih'])->name('pasien-antrian-terpilih');
    Route::post('/pasien-bpjs-antrian/terpilih', [App\Http\Controllers\AntrianIGDController::class, 'antrianPasienBPJSTerpilih'])->name('pasienbpjs-antrian-terpilih');
    Route::get('daftar-umum/pasien-igd/{no}/{rm}/{jp}', [App\Http\Controllers\AntrianIGDController::class, 'formPasienIGD'])->name('form-pasien');
    Route::get('daftar-bpjs/pasien-igd/{nik}/{no}/{rm}/{jp}', [App\Http\Controllers\AntrianIGDController::class, 'formPasienBPJS'])->name('form-pasien-bpjs');
    
    // Route::get('daftar/pasien-igd-bpjs/{nik}/{no}/{rm}/{jp}', [App\Http\Controllers\AntrianIGDController::class, 'formPasienIGDFromBPJS'])->name('form-pasien-idgtobpjs');

    Route::get('/get-pasien-terpilih', [App\Http\Controllers\AntrianIGDController::class, 'getpasienTerpilih'])->name('pasien-terpilih.get');
    Route::get('/pendaftaran-antrian-pasien-igd', [App\Http\Controllers\AntrianIGDController::class, 'pasiendiDaftarkan'])->name('pasien-didaftarkan');
    Route::get('/pendaftaran-antrian-pasien-bpjs-igd', [App\Http\Controllers\AntrianIGDController::class, 'pasienBPJSDiDaftarkan'])->name('pasien-bpjs-didaftarkan');
    
    // GET ALAMAT PASIEN BARU
    Route::get('/get-kabupaten-pasien', [App\Http\Controllers\AntrianIGDController::class, 'getKabPasien'])->name('kab-pasien.get');
    Route::get('/get-kecamatan-pasien', [App\Http\Controllers\AntrianIGDController::class, 'getKecPasien'])->name('kec-pasien.get');
    Route::get('/get-desa-pasien', [App\Http\Controllers\AntrianIGDController::class, 'getDesaPasien'])->name('desa-pasien.get');
    Route::get('/get-kabupaten-keluarga-pasien', [App\Http\Controllers\AntrianIGDController::class, 'getKlgKabPasien'])->name('klg-kab-pasien.get');
    Route::get('/get-kecamatan-keluarga-pasien', [App\Http\Controllers\AntrianIGDController::class, 'getKlgKecPasien'])->name('klg-kec-pasien.get');
    Route::get('/get-desa-keluarga-pasien', [App\Http\Controllers\AntrianIGDController::class, 'getKlgDesaPasien'])->name('klg-desa-pasien.get');

    Route::post('/pendaftaran-igd-store', [App\Http\Controllers\IGDUMUMController::class, 'pendaftaranIGDStore'])->name('pendaftaran-igd.igdstore');
    Route::post('/pendaftaran-igd-kbd-store', [App\Http\Controllers\IGDUMUMController::class, 'pendaftaranIGDKBDStore'])->name('pendaftaran-igd-kbd.igdstore');
    Route::put('/update-nik-bpjs-pasien', [App\Http\Controllers\IGDUMUMController::class, 'updateNOBPJS'])->name('update-nobpjs.pasien');
    Route::put('/tutup-kunjungan-pasien-igd', [App\Http\Controllers\IGDUMUMController::class, 'tutupKunjunganPasien'])->name('tutup-kunjungan-pigd');
    Route::put('/buka-kunjungan-pasien-igd', [App\Http\Controllers\IGDUMUMController::class, 'bukaKunjunganPasien'])->name('buka-kunjungan-pigd');
    
    Route::post('/surat-pernyataan-bpjs-proses', [App\Http\Controllers\IGDUMUMController::class, 'suratPernyataanPasien'])->name('surat-pernyataan.bpjsproses');
    Route::get('/daftar-kunjungan-byuser', [App\Http\Controllers\IGDUMUMController::class, 'listPasienDaftar'])->name('kunjungan-pasien.byuser');
    Route::put('/pendaftaran-igd-batal', [App\Http\Controllers\IGDUMUMController::class, 'batalDaftarIGD'])->name('batalkan.pendaftaranigd');
    Route::get('/pendaftaran-antrian-pasien-igds', [App\Http\Controllers\IGDUMUMController::class, 'bpjsToUmum'])->name('bpjstoumum');
    
    // pilih ruangan
    Route::post('/pilih-ruangan', [App\Http\Controllers\IGDUMUMController::class, 'pilihRuangan'])->name('pilih-ruangan');

    // Menu Kunjungan
    Route::get('/daftar-kunjungan', [App\Http\Controllers\KunjunganIGDController::class, 'kunjunganPasienHariIni'])->name('kunjungan-pasien.today');
    Route::put('/tutup-kunjungan-bykode', [App\Http\Controllers\KunjunganIGDController::class, 'tutupKunjunganByKode'])->name('tutup-kunjungan-bykode');
    Route::put('/buka-kunjungan-bykode', [App\Http\Controllers\KunjunganIGDController::class, 'bukaKunjunganByKode'])->name('buka-kunjungan-bykode');
    Route::get('/edit-penjamin', [App\Http\Controllers\KunjunganIGDController::class, 'editKunjungan'])->name('kunjungan-pasien.edit');
    Route::get('/edit-kunjungan-terpilih', [App\Http\Controllers\KunjunganIGDController::class, 'editKunjunganTerpilih'])->name('kunjungan-terpilih.edit');
    Route::put('/edit-kunjungan-status-penjamin', [App\Http\Controllers\KunjunganIGDController::class, 'updateKunjunganTerpilih'])->name('statuskunjungan-terpilih.update');
    
    //ROUTE IGD BPJS
    Route::get('/pendaftaran-igd-bpjs', [App\Http\Controllers\IGDBPJSController::class, 'getDataAntrianPasienBPJS'])->name('pendaftaran-pasien-igdbpjs');
    Route::post('/pasien-igdbpjs-search', [App\Http\Controllers\IGDBPJSController::class, 'searchPasienIGDBPJS'])->name('pasien-igdbpjs-search');
    Route::post('/pendaftaran-pasien-bpjs-store', [App\Http\Controllers\IGDBPJSController::class, 'pasienBPJSSTORE'])->name('pasien-igdbpjs-store');
    Route::put('/pendaftaran-igd-bpjs-batal', [App\Http\Controllers\IGDBPJSController::class, 'batalDaftar'])->name('batalkan.pendaftaranbpjs');
    Route::get('/provinsi-bpjs', [App\Http\Controllers\IGDBPJSController::class, 'getProvinsiBPJS'])->name('provinsi-bpjs');
    Route::get('/kabupaten-bpjs', [App\Http\Controllers\IGDBPJSController::class, 'getKabBPJS'])->name('kab-bpjs');
    Route::get('/kecamatan-bpjs', [App\Http\Controllers\IGDBPJSController::class, 'getKecBPJS'])->name('kec-bpjs');
    Route::get('/pasien-bpjs/edit/', [App\Http\Controllers\IGDBPJSController::class, 'editPasienBPJS'])->name('edit-pasienbpjs');
    Route::put('/pasien-update', [App\Http\Controllers\IGDBPJSController::class, 'updatePasien'])->name('update-pasien.update');

    
    // RANAP IGD
    Route::get('/pendaftaran-rawat-inap', [App\Http\Controllers\RanapIGDController::class, 'getKunjunganNow'])->name('kunjungan.ranap');
    Route::get('/daftar-bpjs/ranap/', [App\Http\Controllers\RanapIGDController::class, 'ranapBPJS'])->name('ranapbpjs');
    Route::get('/daftar-umum/ranap/', [App\Http\Controllers\RanapIGDController::class, 'ranapUmum'])->name('ranapumum');
    Route::get('/get-unit', [App\Http\Controllers\RanapIGDController::class, 'getUnit'])->name('ruangan-unit.get');
    Route::get('/get-bed-byruangan', [App\Http\Controllers\RanapIGDController::class, 'getBedByRuangan'])->name('bed-ruangan.get');
    Route::post('/pasien-ranap-store', [App\Http\Controllers\RanapIGDController::class, 'pasienRanapStore'])->name('pasienranap.store');
    Route::post('/pasien-ranapbpjs-store', [App\Http\Controllers\RanapIGDController::class, 'pasienRanapBPJSStore'])->name('pasienranapbpjs.store');
    Route::post('/ranap/spri-create', [App\Http\Controllers\RanapIGDController::class, 'createSPRI'])->name('spri.create');
    Route::put('/ranap/spri-update/', [App\Http\Controllers\RanapIGDController::class, 'updateSPRI'])->name('spri.update');
    Route::get('/ranap/spri-get/', [App\Http\Controllers\RanapIGDController::class, 'getSPRI'])->name('spri.get');
    Route::get('/ranap/spri-check/', [App\Http\Controllers\RanapIGDController::class, 'cekProsesDaftarSPRI'])->name('cekprosesdaftar.spri');
    


});
