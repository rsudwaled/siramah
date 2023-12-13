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
use App\Http\Controllers\EklaimController;
use App\Http\Controllers\InacbgController;
use App\Http\Controllers\JabatanKerjaController;
use App\Http\Controllers\KepegawaianController;
use App\Http\Controllers\KebutuhanJurusanController;
use App\Http\Controllers\LaboratoriumController;
use App\Http\Controllers\PatologiAnatomiController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\RadiologiController;
use App\Http\Controllers\RanapController;
use App\Http\Livewire\Users;
use App\Models\JadwalDokter;
use App\Models\Pasien;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!asd
|
*/
// route default
Route::get('', [HomeController::class, 'landingpage'])->name('landingpage');
Auth::routes();
Route::get('login/google/redirect', [SocialiteController::class, 'redirect'])->middleware(['guest'])->name('login.google');
Route::get('login/google/callback', [SocialiteController::class, 'callback'])->middleware(['guest'])->name('login.goole.callback');
// layanan umum
Route::get('bukutamu', [BukuTamuController::class, 'bukutamu'])->name('bukutamu');
Route::post('bukutamu', [BukuTamuController::class, 'store'])->name('bukutamu_store');
// layanan umum
Route::get('jadwaloperasi_info', [JadwalOperasiController::class, 'jadwaloperasi_info'])->name('jadwaloperasi_info');
Route::get('jadwaloperasi_display', [JadwalOperasiController::class, 'jadwaloperasi_display'])->name('jadwaloperasi_display');
// mesin antrian
Route::get('antrianConsole', [PendaftaranController::class, 'antrianConsole'])->name('antrianConsole');
Route::get('checkinAntrian', [PendaftaranController::class, 'checkinAntrian'])->name('checkinAntrian');
Route::get('checkinCetakSEP', [PendaftaranController::class, 'checkinCetakSEP'])->name('checkinCetakSEP');
Route::get('checkinKarcisAntrian', [PendaftaranController::class, 'checkinKarcisAntrian'])->name('checkinKarcisAntrian');
Route::get('daftarBpjsOffline', [PendaftaranController::class, 'daftarBpjsOffline'])->name('daftarBpjsOffline');
Route::get('jadwaldokterPoli', [JadwalDokterController::class, 'jadwaldokterPoli'])->name('jadwaldokterPoli');
Route::get('daftarUmumOffline', [PendaftaranController::class, 'daftarUmumOffline'])->name('daftarUmumOffline');
Route::get('cekPrinter', [ThermalPrintController::class, 'cekPrinter'])->name('cekPrinter');
Route::get('checkinUpdate', [AntrianController::class, 'checkinUpdate'])->name('checkinUpdate');
// cppt
Route::get('cppt', [CPPTController::class, 'getCPPT'])->name('cppt.get');
Route::get('cppt_print', [CPPTController::class, 'getCPPTPrint'])->name('cppt-rajal-print.get');
Route::get('cppt_print_anestesi', [CPPTController::class, 'getCPPTPrintAnestesi'])->name('cppt-anestesi-print.get');
// auth
Route::middleware('auth')->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('home'); #ok
    Route::get('profile', [UserController::class, 'profile'])->name('profile'); #ok
    // settingan umum
    Route::get('get_city', [LaravotLocationController::class, 'get_city'])->name('get_city');
    Route::get('get_district', [LaravotLocationController::class, 'get_district'])->name('get_district');
    Route::get('get_village', [LaravotLocationController::class, 'get_village'])->name('get_village');
    // admin
    Route::middleware('permission:admin')->group(function () {
        Route::resource('user', UserController::class);
        Route::get('user_verifikasi/{user}', [UserController::class, 'user_verifikasi'])->name('user_verifikasi');
        Route::get('pasienexport', [UserController::class, 'pasienexport'])->name('pasienexport');
        Route::post('userimport', [UserController::class, 'userimport'])->name('userimport');
        Route::get('userexport', [UserController::class, 'userexport'])->name('userexport');

        Route::resource('role', RoleController::class);
        Route::resource('permission', PermissionController::class);
        Route::get('cekBarQRCode', [BarcodeController::class, 'cekBarQRCode'])->name('cekBarQRCode');
        Route::get('cekThermalPrinter', [ThermalPrintController::class, 'cekThermalPrinter'])->name('cekThermalPrinter');
        Route::get('testThermalPrinter', [ThermalPrintController::class, 'testThermalPrinter'])->name('testThermalPrinter');
        Route::get('whatsapp', [WhatsappController::class, 'whatsapp'])->name('whatsapp');
    });
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
    Route::resource('vclaim', VclaimController::class);
    // pendaftaran
    Route::get('antrianPendaftaran', [PendaftaranController::class, 'antrianPendaftaran'])->name('antrianPendaftaran');
    Route::get('jadwalDokterAntrian', [JadwalDokterController::class, 'index'])->name('jadwalDokterAntrian');
    Route::post('daftarBridgingAntrian', [AntrianController::class, 'daftarBridgingAntrian'])->name('daftarBridgingAntrian');
    Route::get('selanjutnyaPendaftaran/{loket}/{lantai}/{jenispasien}/{tanggal}', [AntrianController::class, 'selanjutnyaPendaftaran'])->name('selanjutnyaPendaftaran');
    Route::get('panggilPendaftaran/{kodebooking}/{loket}/{lantai}', [AntrianController::class, 'panggilPendaftaran'])->name('panggilPendaftaran');
    Route::get('batalpendaftaran', [PendaftaranController::class, 'batalpendaftaran'])->name('batalpendaftaran');
    Route::get('selesaiPendaftaran', [AntrianController::class, 'selesaiPendaftaran'])->name('selesaiPendaftaran');
    Route::get('antrianCapaian', [AntrianController::class, 'antrianCapaian'])->name('antrianCapaian');
    // kasir
    Route::get('antrianKasir', [AntrianController::class, 'antrianKasir'])->name('antrianKasir');
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
    Route::get('laporanAntrianPoliklinik', [AntrianController::class, 'laporanAntrianPoliklinik'])->name('laporanAntrianPoliklinik');
    Route::get('laporanKunjunganPoliklinik', [KunjunganController::class, 'laporanKunjunganPoliklinik'])->name('laporanKunjunganPoliklinik');
    Route::get('dashboardTanggalAntrianPoliklinik', [AntrianController::class, 'dashboardTanggalAntrian'])->name('dashboardTanggalAntrianPoliklinik');
    Route::get('dashboardBulanAntrianPoliklinik', [AntrianController::class, 'dashboardBulanAntrian'])->name('dashboardBulanAntrianPoliklinik');
    Route::get('suratKontrolPrint/{suratkontrol}', [SuratKontrolController::class, 'suratKontrolPrint'])->name('suratKontrolPrint');
    // ranap
    Route::get('pasienRanapAktif', [KunjunganController::class, 'pasienRanapAktif'])->name('pasienRanapAktif');
    Route::get('pasienRanap', [KunjunganController::class, 'pasienRanap'])->name('pasienRanap');
    Route::get('pasienRanapPasien', [KunjunganController::class, 'pasienRanapPasien'])->name('pasienRanapPasien');
    Route::post('claim_ranap_v2', [InacbgController::class, 'claim_ranap_v2'])->name('claim_ranap_v2');
    Route::post('claim_ranap', [InacbgController::class, 'claim_ranap'])->name('claim_ranap');
    Route::get('kunjunganranap', [RanapController::class, 'kunjunganranap'])->name('kunjunganranap');
    Route::get('get_pasien_ranap', [RanapController::class, 'get_pasien_ranap'])->name('get_pasien_ranap');

    Route::get('kunjunganranapaktif', [RanapController::class, 'kunjunganranapaktif'])->name('kunjunganranapaktif');
    Route::get('pasienranapprofile', [RanapController::class, 'pasienranapprofile'])->name('pasienranapprofile');
    Route::get('get_kunjungan_pasien', [RanapController::class, 'get_kunjungan_pasien'])->name('get_kunjungan_pasien');

    Route::post('simpan_resume_ranap', [RanapController::class, 'simpan_resume_ranap'])->name('simpan_resume_ranap');
    Route::get('print_resume_ranap', [RanapController::class, 'print_resume_ranap'])->name('print_resume_ranap');
    Route::post('simpan_implementasi_evaluasi_keperawatan', [RanapController::class, 'simpan_implementasi_evaluasi_keperawatan'])->name('simpan_implementasi_evaluasi_keperawatan');
    Route::post('simpan_keperawatan_ranap', [RanapController::class, 'simpan_keperawatan_ranap'])->name('simpan_keperawatan_ranap');
    Route::get('hapus_implementasi_evaluasi_keperawatan', [RanapController::class, 'hapus_implementasi_evaluasi_keperawatan'])->name('hapus_implementasi_evaluasi_keperawatan');
    Route::post('hapus_keperawatan_ranap', [RanapController::class, 'hapus_keperawatan_ranap'])->name('hapus_keperawatan_ranap');
    Route::get('get_keperawatan_ranap', [RanapController::class, 'get_keperawatan_ranap'])->name('get_keperawatan_ranap');
    Route::get('print_implementasi_evaluasi_keperawatan', [RanapController::class, 'print_implementasi_evaluasi_keperawatan'])->name('print_implementasi_evaluasi_keperawatan');
    Route::post('simpan_observasi_ranap', [RanapController::class, 'simpan_observasi_ranap'])->name('simpan_observasi_ranap');
    Route::post('hapus_obaservasi_ranap', [RanapController::class, 'hapus_obaservasi_ranap'])->name('hapus_obaservasi_ranap');
    Route::get('get_observasi_ranap', [RanapController::class, 'get_observasi_ranap'])->name('get_observasi_ranap');
    Route::get('print_obaservasi_ranap', [RanapController::class, 'print_obaservasi_ranap'])->name('print_obaservasi_ranap');



    // laboratorium
    Route::get('hasillaboratorium', [LaboratoriumController::class, 'hasillaboratorium'])->name('hasillaboratorium');
    // radiologi
    Route::get('hasilradiologi', [RadiologiController::class, 'hasilradiologi'])->name('hasilradiologi');
    // patologi
    Route::get('hasillabpa', [PatologiAnatomiController::class, 'hasillabpa'])->name('hasillabpa');
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
    // casemix
    Route::get('diagnosaRawatJalan', [PoliklinikController::class, 'diagnosaRawatJalan'])->name('diagnosaRawatJalan');
    Route::get('pasienranappulang', [KunjunganController::class, 'pasienRanapPulang'])->name('pasienranappulang');
    Route::get('kunjunganpasienranap', [KunjunganController::class, 'kunjunganpasienranap'])->name('kunjunganpasienranap');
    Route::get('bukakunjungan', [KunjunganController::class, 'bukakunjungan'])->name('bukakunjungan');
    Route::get('tutupkunjungan', [KunjunganController::class, 'tutupkunjungan'])->name('tutupkunjungan');
    Route::get('laporan_eklaim_ranap', [EklaimController::class, 'laporan_eklaim_ranap'])->name('laporan_eklaim_ranap');
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
    Route::post('suratkontrol_update_v2', [SuratKontrolController::class, 'suratkontrol_update_v2'])->name('suratkontrol_update_v2');
    Route::get('suratkontrol_delete', [SuratKontrolController::class, 'suratkontrol_delete'])->name('suratkontrol_delete');
    Route::get('suratkontrol_print', [SuratKontrolController::class, 'print'])->name('suratkontrol_print');
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
    //ROUTE ANTRIAN IGD
    Route::get('/dashboard-antrian-igd', [App\Http\Controllers\AntrianIGDController::class, 'antrianIGD'])->name('d-antrian-igd');
    Route::get('/get-no-antrian', [App\Http\Controllers\AntrianIGDController::class, 'getNoAntrian'])->name('get-no-antrian');
    Route::get('/antrian-igd', [App\Http\Controllers\AntrianIGDController::class, 'getAntrian'])->name('antrian-igd');
    Route::get('/daftar-antrian-igd', [App\Http\Controllers\AntrianIGDController::class, 'daftarkanPasien'])->name('antrian-igd.daftarkan');
    Route::post('/cari-pasien', [App\Http\Controllers\AntrianIGDController::class, 'searchPasien'])->name('pasien-igd-search');
    Route::get('/get-pasien-terpilih', [App\Http\Controllers\AntrianIGDController::class, 'getpasienTerpilih'])->name('pasien-terpilih.get');
    Route::post('/pendaftaran-pasien-igd', [App\Http\Controllers\AntrianIGDController::class, 'pasiendiDaftarkan'])->name('pasien-didaftarkan');
    Route::get('/get-kelas-ruangan', [App\Http\Controllers\AntrianIGDController::class, 'getKelasRuangan'])->name('ruangan-kelas.get');
    Route::post('/daftarkan-pasien-baru', [App\Http\Controllers\AntrianIGDController::class, 'pasienBaruCreate'])->name('pasien-baru.create');
    // GET ALAMAT PASIEN
    Route::get('/get-kabupaten-pasien', [App\Http\Controllers\AntrianIGDController::class, 'getKabPasien'])->name('kab-pasien.get');
    Route::get('/get-kecamatan-pasien', [App\Http\Controllers\AntrianIGDController::class, 'getKecPasien'])->name('kec-pasien.get');
    Route::get('/get-desa-pasien', [App\Http\Controllers\AntrianIGDController::class, 'getDesaPasien'])->name('desa-pasien.get');
    Route::get('/get-kabupaten-keluarga-pasien', [App\Http\Controllers\AntrianIGDController::class, 'getKlgKabPasien'])->name('klg-kab-pasien.get');
    Route::get('/get-kecamatan-keluarga-pasien', [App\Http\Controllers\AntrianIGDController::class, 'getKlgKecPasien'])->name('klg-kec-pasien.get');
    Route::get('/get-desa-keluarga-pasien', [App\Http\Controllers\AntrianIGDController::class, 'getKlgDesaPasien'])->name('klg-desa-pasien.get');

    Route::post('/surat-pernyataan-bpjs-proses', [App\Http\Controllers\PendaftaranPasienIGDController::class, 'suratPernyataanPasien'])->name('surat-pernyataan.bpjsproses');
    Route::get('/daftar-kunjungan', [App\Http\Controllers\PendaftaranPasienIGDController::class, 'kunjunganPasienHariIni'])->name('kunjungan-pasien.today');
    Route::get('/daftar-kunjungan-byuser', [App\Http\Controllers\PendaftaranPasienIGDController::class, 'listPasienDaftar'])->name('kunjungan-pasien.byuser');
    //ROUTE IGD
    Route::get('/pendaftaran-igd', [App\Http\Controllers\PendaftaranPasienIGDController::class, 'getPasien'])->name('pendaftaran-pasien');
    Route::post('/pendaftaran-pasien-lama', [App\Http\Controllers\PendaftaranPasienIGDController::class, 'searchPasien'])->name('pasien-search');
    Route::get('/pendaftaran-pasien', [App\Http\Controllers\PendaftaranPasienIGDController::class, 'daftarPasien'])->name('pasien-daftar.norm'); //datapasienview ajax route sebelum perubahan
    Route::get('/pilih-pendaftaran-pasien', [App\Http\Controllers\PendaftaranPasienIGDController::class, 'pilihPendaftaranPasien'])->name('pilih-pendaftaran-pasien');
    Route::get('/daftar-ruangan', [App\Http\Controllers\PendaftaranPasienIGDController::class, 'getRuangan'])->name('ruangan.get');
    Route::post('/pilih-ruangan', [App\Http\Controllers\PendaftaranPasienIGDController::class, 'pilihRuangan'])->name('pilih-ruangan');
});
