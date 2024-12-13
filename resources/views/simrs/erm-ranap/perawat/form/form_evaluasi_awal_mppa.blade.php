<form action="#" name="formEvaluasiMPPA" id="formEvaluasiMPPA" method="POST">
    @csrf
    <div class="row">
        <div class="col-12 row">
            <div class="col-4">
                <div class="form-group">
                    <label for="Tanggal Evaluasi">Tanggal Evaluasi</label>
                    <input type="date" name="tgl_evaluasi" class="form-control"
                        value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                </div>

                <div class="form-group">
                    <label for="Jenis Kelamin">Jenis Kelamin</label>
                    <input type="text" name="jk_pasien" class="form-control"
                        value="{{ $kunjungan->pasien->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}" readonly>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="Waktu Evaluasi">Waktu Evaluasi</label>
                    <input type="time" name="waktu_evaluasi" class="form-control"
                        value="{{ \Carbon\Carbon::now()->format('H:i:s') }}">
                </div>
                <div class="form-group">
                    <label for="Nama Pasien">Nama Pasien</label>
                    <input type="text" name="nama_pasien" class="form-control"
                        value="{{ $kunjungan->pasien->nama_px }}" readonly>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="RM Pasien">RM Pasien</label>
                    <input type="text" name="rm_pasien" class="form-control" value="{{ $kunjungan->pasien->no_rm }}"
                        readonly>
                </div>
                <div class="form-group">
                    <label for="Tgl Lahir">Tgl Lahir</label>
                    <input type="text" name="tgl_lahir_pasien" class="form-control"
                        value="{{ \Carbon\Carbon::parse($kunjungan->pasien->tgl_lahir)->format('Y-m-d') }}" readonly>
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
                                <td style="border: 1px solid rgb(78, 77, 77);">Identifikasi/skrining pasien terdapat jawaban</td>
                                <td style="border: 1px solid rgb(78, 77, 77);"><input type="text" class="form-control"
                                        name=""></td>
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
                                            </div>
                                        </li>
                                        <li>
                                            Riwayat Kesehatan <input type="text" name="riwayat_kesehatan_mppa"
                                                class="form-control">
                                        </li>
                                        <li>
                                            Perilaku Psiko - Spiritual - Sosio - Kultural <input type="text"
                                                name="perilaku_psikososialkultur_mppa" class="form-control">
                                        </li>
                                        <li>
                                            Kesehatan Mental dan Kognitif <input type="text"
                                                name="kesehatan_mental_kognitif_mppa" class="form-control">
                                        </li>
                                        <li>
                                            Lingkungan Tempat Tinggal <input type="text"
                                                name="lingkungan_tempat_tinggal_mppa" class="form-control">
                                        </li>
                                        <li>
                                            Dukungan Keluarga, kemampuan merawat dari pemberi asuhan
                                            <div class="row">
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
                                    </ol>
                                </td>
                            </tr>
                            <tr>
                                <td style="2%; border: 1px solid rgb(78, 77, 77);">3.</td>
                                <td style="border: 1px solid rgb(78, 77, 77);">Identifikasi Masalah - Resiko - Kesempatan</td>
                                <td style="border: 1px solid rgb(78, 77, 77);"><input type="text" class="form-control"
                                        name=""></td>
                            </tr>
                            <tr>
                                <td style="2%; border: 1px solid rgb(78, 77, 77);">4.</td>
                                <td style="border: 1px solid rgb(78, 77, 77);">Perencanaan MPP</td>
                                <td style="border: 1px solid rgb(78, 77, 77);"><input type="text" class="form-control"
                                        name=""></td>
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
