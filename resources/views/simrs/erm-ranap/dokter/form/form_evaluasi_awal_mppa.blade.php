<form action="{{ route('dashboard.erm-ranap.catatan-mpp-a.store') }}" name="formEvaluasiMPPA" id="formEvaluasiMPPA"
    method="POST">
    @csrf
    <input type="hidden" name="kode" value="{{ $data['kunjungan']['kode_kunjungan'] }}">
    <div class="row">
        <div class="col-12 row">
            <div class="col-4">
                <div class="form-group">
                    <label for="RM Pasien">RM Pasien</label>
                    <input type="text" name="rm_pasien" class="form-control"
                        value="{{ $data['kunjungan']['no_rm'] }}" readonly>
                </div>
                <div class="form-group">
                    <label for="Tgl Lahir">Tgl Lahir</label>
                    <input type="text" name="tgl_lahir_pasien" class="form-control"
                        value="{{ \Carbon\Carbon::parse($data['pasien']['tgl_lahir'])->format('Y-m-d') }}" readonly>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="Nama Pasien">Nama Pasien</label>
                    <input type="text" name="nama_pasien" class="form-control"
                        value="{{ $data['pasien']['nama_px'] }}" readonly>
                </div>
                <div class="form-group">
                    <label for="Jenis Kelamin">Jenis Kelamin</label>
                    <input type="text" name="jk_pasien" class="form-control"
                        value="{{ $data['pasien']['jenis_kelamin'] == 'L' ? 'Laki-Laki' : 'Perempuan' }}" readonly>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="Waktu Evaluasi">Waktu Evaluasi</label>
                    <input type="time" name="waktu_evaluasi" class="form-control"
                        value="{{ \Carbon\Carbon::parse($mppa->waktu_evaluasi ?? \Carbon\Carbon::now())->format('H:i') }}">

                </div>
                <div class="form-group">
                    <label for="Tanggal Evaluasi">Tanggal Evaluasi</label>
                    <input type="date" name="tgl_evaluasi" class="form-control"
                        value="{{ \Carbon\Carbon::parse($mppa->tgl_evaluasi ?? \Carbon\Carbon::now())->format('Y-m-d') }}">
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Evaluasi Awal MPP A</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table style="width: 100%" style="border: 1px solid rgb(78, 77, 77)">
                        <tbody>
                            <tr>
                                <td style="2%; border: 1px solid black;">1.</td>
                                <td style="border: 1px solid rgb(78, 77, 77);">Identifikasi/skrining pasien terdapat
                                    jawaban</td>
                                <td style="border: 1px solid rgb(78, 77, 77);"><input type="text"
                                        value="{{ $mppa->skrining_pasien??'' }}" class="form-control"
                                        name="skrining_pasien"></td>
                            </tr>
                            <tr>
                                <td style="2%; border: 1px solid rgb(78, 77, 77);">2.</td>
                                <td style="border: 1px solid rgb(78, 77, 77);">Asesmen meliputi</td>
                                <td style="border: 1px solid rgb(78, 77, 77);">
                                    <ol type="a" style="font-size: 13px;">
                                        <li>
                                            Fisik-Fungsional, kekuatan / kemampuan / kemandirian :
                                            <div class="row">
                                                <div class="form-group mr-4">
                                                    <input type="checkbox" name="mandiri_penuh">
                                                    <label for="Mandiri Penuh">Mandiri Penuh</label>
                                                </div>
                                                <div class="form-group mr-4">
                                                    <input type="checkbox" name="mandiri_sebagian">
                                                    <label for="Mandiri Sebagian">Mandiri Sebagian</label>
                                                </div>
                                                <div class="form-group mr-4">
                                                    <input type="checkbox" name="total_bantuan_lainnya">
                                                    <label for="Total Bantuan">Total Bantuan</label>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" name="keterangan_bantuan_fisik" class="form-control col-12">
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            Riwayat Kesehatan <input type="text" name="riwayat_kesehatan_mppa" value="{{ $mppa->riwayat_kesehatan??'' }}"
                                                class="form-control">
                                        </li>
                                        <li>
                                            Perilaku Psiko - Spiritual - Sosio - Kultural <input type="text" value="{{ $mppa->perilaku_psiko_spiritual??'' }}"
                                                name="perilaku_psikososialkultur_mppa" class="form-control">
                                        </li>
                                        <li>
                                            Kesehatan Mental dan Kognitif <input type="text" value="{{ $mppa->kesehatan_mental??'' }}"
                                                name="kesehatan_mental_kognitif_mppa" class="form-control">
                                        </li>
                                        <li>
                                            Lingkungan Tempat Tinggal <input type="text" value="{{ $mppa->lingkungan_tt??'' }}"
                                                name="lingkungan_tempat_tinggal_mppa" class="form-control">
                                        </li>
                                        <li>
                                            Dukungan Keluarga, kemampuan merawat dari pemberi asuhan
                                            <div class="row ml-1">
                                                <div class="form-group mr-4">
                                                    <input type="checkbox" name="dukungan_merawat_ya">
                                                    <label for="Dukungan Ya">Ya</label>
                                                </div>
                                                <div class="form-group mr-4">
                                                    <input type="checkbox" name="dukungan_merawat_tidak">
                                                    <label for="Dukungan Tidak">Tidak</label>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row ml-1">
                                                <div class="col-12 row">
                                                    Finansial
                                                    <div class="form-group mr-4 ml-3">
                                                        <input type="checkbox" name="finansial_baik_mppa">
                                                        <label for="Finansial Baik">Baik</label>
                                                    </div>
                                                    <div class="form-group mr-4">
                                                        <input type="checkbox" name="finansial_sedang_mppa">
                                                        <label for="Finansial Sedang">Sedang</label>
                                                    </div>
                                                    <div class="form-group mr-4">
                                                        <input type="checkbox" name="finansial_kurang_mppa">
                                                        <label for="Finansial Kurang">Kurang</label>
                                                    </div>
                                                </div>
                                                <div class="col-12 row" style="margin-top: -20px;">
                                                    Jaminan
                                                    <div class="form-group mr-4 ml-3">
                                                        <input type="checkbox" name="jaminan_pribadi_mppa">
                                                        <label for="Jaminan Pribadi">Pribadi</label>
                                                    </div>
                                                    <div class="form-group mr-4">
                                                        <input type="checkbox" name="jaminan_asuransi_mppa">
                                                        <label for="Jaminan Asuransi">Asuransi</label>
                                                    </div>
                                                    <div class="form-group mr-4">
                                                        <input type="checkbox" name="jaminan_jknbpjs_mppa">
                                                        <label for="Jaminan JKN">JKN/BPJS</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            Riwayat penggunaan obat alternatif
                                            <div class="col-12 row">
                                                <div class="col-2">
                                                    <div class="form-group mr-2">
                                                        <input type="radio" name="obat_alternatif">
                                                        <label for="Tidak">Tidak</label>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group mr-4">
                                                        <input type="radio" name="obat_alternatif">
                                                        <label for="Ada">Ada</label>
                                                    </div>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" name="riwayat_obat_alternatif"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            Riwayat trauma / kekerasan
                                            <div class="col-12 row">
                                                <div class="col-2">
                                                    <div class="form-group mr-2">
                                                        <input type="radio" name="tidak_trauma_kekerasan">
                                                        <label for="Tidak">Tidak</label>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group mr-4">
                                                        <input type="radio" name="ada_trauma_kekerasan">
                                                        <label for="Ada">Ada</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            Pemahaman tentang kesehatan
                                            <div class="col-12 row">
                                                <div class="col-2">
                                                    <div class="form-group mr-2">
                                                        <input type="radio" name="tahu_pemahaman_kesehatan">
                                                        <label for="Tahu">Tahu</label>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group mr-4">
                                                        <input type="radio" name="tidak_tahu_pemahaman_kesehatan">
                                                        <label for="Tidak Tahu">Tidak Tahu</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            Harapan terhadap hasil asuhan, kemampuan menerima perubahan :
                                            <div class="col-12 row">
                                                <div class="col-2">
                                                    <div class="form-group mr-2">
                                                        <input type="radio" name="ada_harapan_terhadap_hasil">
                                                        <label for="Ada">Ada</label>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group mr-4">
                                                        <input type="radio" name="tidak_ada_harapan_terhadap_hasil">
                                                        <label for="Tidak Ada">Tidak Ada</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            Perkiraan lama dirawat
                                            <div class="col-4">
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control"
                                                        name="perkiraan_lama_dirawat_mppa">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">hari</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            Discharge plan :
                                            <div class="col-12 row">
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <input type="radio" name="tidak_discharge_plan">
                                                        <label for="Tidak">Tidak</label>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <input type="radio" name="ada_discharge_plan">
                                                        <label for="Iya">Iya</label>
                                                    </div>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" name="keterangan_discharge_plan"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            Perencanaan Lanjutan :
                                            <div class="col-12 row">
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <input type="checkbox" name="rencana_lanjutan_home_care">
                                                        <label for="Home Care">Home Care</label>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <input type="checkbox" name="rencana_lanjutan_pengobatan">
                                                        <label for="Pengobatan">Pengobatan /Perawatan</label>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <input type="checkbox" name="rencana_lanjutan_rujuk">
                                                        <label for="rujuk">Rujuk</label>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <input type="checkbox" name="rencana_lanjutan_komunitas">
                                                        <label for="komunitas">Komunitas</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            Aspek Legal:
                                            <div class="col-12 row">
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <input type="checkbox" name="aspek_legal_tidak_ada">
                                                        <label for="tidak_ada">Tidak Ada</label>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <input type="checkbox" name="aspek_legal_ada">
                                                        <label for="ada">Ada</label>
                                                    </div>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" name="keterangan_aspek_legal"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </li>
                                    </ol>
                                </td>
                            </tr>
                            <tr>
                                <td style="2%; border: 1px solid rgb(78, 77, 77);">3.</td>
                                <td style="border: 1px solid rgb(78, 77, 77);">Identifikasi Masalah - Resiko -
                                    Kesempatan</td>
                                <td style="border: 1px solid rgb(78, 77, 77);">
                                    <div class="col-12 row" style="margin-bottom: 0;">
                                        <div class="col-12 mt-2">
                                            <div class="form-group" style="margin-bottom: 0;">
                                                <input type="checkbox" name="tidak_sesuai_dg_cp_ppk">
                                                <label for="Tidak Sesuai dengan CP/PPK">Tidak Sesuai dengan
                                                    CP/PPK</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group" style="margin-bottom: 0;">
                                                <input type="checkbox" name="adanya_komplikasi">
                                                <label for="Adanya Komplikasi">Adanya Komplikasi</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group" style="margin-bottom: 0;">
                                                <input type="checkbox"
                                                    name="pemahaman_pasien_kurang_untuk_kondisi_terkini">
                                                <label for="Pemahaman Pasien kurang tentang penyakit">Pemahaman Pasien
                                                    kurang tentang penyakit, kondisi terkini, obat-obatan</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group" style="margin-bottom: 0;">
                                                <input type="checkbox"
                                                    name="ketidakpatuhan_pasien_pasien_kendala_keuangan">
                                                <label for="Ketidakpatuhan pasien kendala keuangan">Ketidakpatuhan
                                                    pasien kendala keuangan ketika keparahan/komplikasi
                                                    meningkat</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group" style="margin-bottom: 0;">
                                                <input type="checkbox" name="terjadi_konflik">
                                                <label for="terjadi konflik">Terjadi Konflik</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group" style="margin-bottom: 0;">
                                                <input type="checkbox" name="pemulangan_belum_memenuhi_kriteria">
                                                <label for="pemulangan belum memenuhi kriteria">Pemulangan/rujukan
                                                    belum memenuhi kriteria / sebaliknya, pemulangan/rujukan
                                                    ditunda</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group" style="margin-bottom: 0;">
                                                <input type="checkbox" name="tindakan_pengobatan_tertunda">
                                                <label for="tindakan pengobatan tertunda">Tindakan pengobatan
                                                    tertunda/dibatalkan</label>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="2%; border: 1px solid rgb(78, 77, 77);">4.</td>
                                <td style="border: 1px solid rgb(78, 77, 77);">
                                    Perencanaan MPP :
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <input type="checkbox" name="kebutuhan_asuhan">
                                        <label for="kebutuhan asuhan">Kebutuhan Asuhan</label>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <input type="checkbox" name="kebutuhan_edukasi">
                                        <label for="kebutuhan edukasi">Kebutuhan edukasi</label>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <input type="checkbox" name="solusi_konflik">
                                        <label for="Solusi konflik">Solusi konflik</label>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <input type="checkbox" name="diagnosis">
                                        <label for="diagnosis">Diagnosis</label>
                                    </div>
                                </td>
                                <td style="border: 1px solid rgb(78, 77, 77);">
                                    <ol type="a" style="font-size: 13px;">
                                        <li>
                                            Jangka Pendek <input type="text" name="perencanaan_mpp_jangka_pendek"
                                                class="form-control">
                                        </li>
                                        <li>
                                            Jangka Panjang <input type="text" name="perencanaan_mpp_jangka_panjang"
                                                class="form-control">
                                        </li>
                                        <li>
                                            Kebutuhan Berjalan <input type="text"
                                                name="perencanaan_mpp_kebutuhan_berjalan" class="form-control">
                                        </li>
                                        <li>
                                            Lain-lain <input type="text" name="perencanaan_mpp_lain_lain"
                                                class="form-control">
                                        </li>
                                    </ol>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row float-right">
        <button type="submit" class="btn btn-md btn-success" form="formEvaluasiMPPA">
            <i class="fas fa-save"></i> Simpan Data</button>
    </div>
</form>
