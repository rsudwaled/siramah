<div class="card" style="font-size: 12px;">
    <div class="card-header p-2">
        <ul class="nav nav-pills" style="font-size: 14px;">
            <li class="nav-item">
                <a class="nav-link active" href="#form-mpp-a" data-toggle="tab">RINGKASAN PASIEN PULANG</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#table-mpp-a" data-toggle="tab">Data</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane active" id="form-mpp-a">
                <form action="{{ route('dashboard.erm-ranap.resume-pemulangan.store-resume') }}" name="formEvaluasiMPPA"
                    id="formEvaluasiMPPA" method="POST">
                    @csrf
                    <input type="hidden" name="kode_kunjungan" value="{{ $kunjungan->kode_kunjungan }}">
                    <div class="row">
                        <div class="col-12 row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="RM Pasien">RM Pasien</label>
                                    <input type="text" name="rm_pasien" value="{{ $pasien->no_rm }}"
                                        class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="Tgl Lahir">Tgl Lahir</label>
                                    <input type="text" name="tgl_lahir_pasien" value="{{ $pasien->tgl_lahir }}"
                                        class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="Nama Pasien">Nama Pasien</label>
                                    <input type="text" name="nama_pasien" value="{{ $pasien->nama_px }}"
                                        class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="Jenis Kelamin">Jenis Kelamin</label>
                                    <input type="text" name="jk_pasien" value="{{ $pasien->jenis_kelamin }}"
                                        class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="Waktu Evaluasi">Waktu Evaluasi</label>
                                    <input type="time" name="waktu_evaluasi" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="Tanggal Evaluasi">Tanggal Evaluasi</label>
                                    <input type="date" name="tgl_evaluasi" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">FORM RINGKASAN PASIEN PULANG</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered" style="width: 100%;">
                                        <tbody>
                                            <tr>
                                                <td style="width: 38%;">
                                                    <div class="form-group">
                                                        <label for="tgl_masuk">Tgl Masuk:</label>
                                                        <input type="date" name="tgl_masuk" id="tgl_masuk"
                                                            class="form-control">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <label for="waktu_masuk">Jam Masuk:</label>
                                                        <input type="time" name="waktu_masuk" id="waktu_masuk"
                                                            class="form-control">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <label for="ruang_rawat_masuk">Ruang Rawat:</label>
                                                        <input type="text" name="ruang_rawat_masuk"
                                                            id="ruang_rawat_masuk" class="form-control">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        <label for="tgl_keluar">Tgl Keluar:</label>
                                                        <input type="date" name="tgl_keluar" id="tgl_keluar"
                                                            class="form-control">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <label for="waktu_keluar">Jam Keluar:</label>
                                                        <input type="time" name="waktu_keluar" id="waktu_keluar"
                                                            class="form-control">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <label for="ruang_rawat_keluar">Ruang Rawat:</label>
                                                        <input type="text" name="ruang_rawat_keluar"
                                                            id="ruang_rawat_keluar" class="form-control">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        <label for="lama_rawat">Lama Rawat:</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control"
                                                                name="lama_rawat" id="lama_rawat">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">Hari</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan="2">
                                                    <div class="form-group">
                                                        <label for="bb_bayi_lahir">
                                                            Berat Badan Bayi Lahir < 1 Bulan:</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        name="bb_bayi_lahir" id="bb_bayi_lahir">
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">Kg</span>
                                                                    </div>
                                                                </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Ringkasan Perawatan</strong></td>
                                                <td colspan="2">
                                                    <textarea name="ringkasan_perawatan" id="ringkasan_perawatan" rows="5" class="form-control"></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Riwayat Penyakit</strong></td>
                                                <td colspan="2">
                                                    <textarea name="riwayat_penyakit" id="riwayat_penyakit" rows="5" class="form-control"></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Indikasi Rawat Inap</strong></td>
                                                <td colspan="2">
                                                    <textarea name="indikasi_rawat_inap" id="indikasi_rawat_inap" rows="5" class="form-control"></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Pemeriksaan Fisik</strong></td>
                                                <td colspan="2">
                                                    <textarea name="pemeriksaan_fisik" id="pemeriksaan_fisik" rows="5" class="form-control"></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="margin:0px;">
                                                    <table>
                                                        <tr>
                                                            <td style="position: relative; height: 100%;">
                                                                <div
                                                                    style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(270deg); white-space: nowrap;">
                                                                    <strong>PEMERIKSAAN PENUNJANG</strong>
                                                                </div>
                                                            </td>

                                                            <td style="width: 100%;">
                                                                <table style="width: 100%; height: 100%; border:none;">
                                                                    <tr>
                                                                        <td style="width: 36%; padding: 10px;">
                                                                            Laboratorium</td>
                                                                        <td style=" padding: 10px;">
                                                                            <textarea name="penunjang_laboratorium" id="penunjang_laboratorium" rows="5" class="form-control"
                                                                                style="width: 100%; resize: vertical;"></textarea>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style=" padding: 10px;">
                                                                            Radiologi</td>
                                                                        <td style=" padding: 10px;">
                                                                            <textarea name="penunjang_radiologi" id="penunjang_radiologi" rows="5" class="form-control"
                                                                                style="width: 100%; resize: vertical;"></textarea>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style=" padding: 10px;">
                                                                            Penunjang Lainnya</td>
                                                                        <td style=" padding: 10px;">
                                                                            <textarea name="penunjang_lainya" id="penunjang_lainya" rows="5" class="form-control"
                                                                                style="width: 100%; resize: vertical;"></textarea>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong style="margin: 0.5rem 0;">Hasil Konsultasi</strong>
                                                </td>
                                                <td colspan="2">
                                                    <textarea name="hasil_konsultasi" id="hasil_konsultasi" rows="5" class="form-control"
                                                        style="width: 100%; resize: vertical;"></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong style="margin: 0.5rem 0;">Diagnosa Masuk</strong>
                                                </td>
                                                <td colspan="2">
                                                    <textarea name="diagnosa_masuk" id="diagnosa_masuk" rows="5" class="form-control"
                                                        style="width: 100%; resize: vertical;"></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="margin:0px;">
                                                    <table>
                                                        <tr>
                                                            <td style="position: relative; height: 100%;">
                                                                <div
                                                                    style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(270deg); white-space: nowrap;">
                                                                    <strong>DIAGNOSA KELUAR</strong>
                                                                </div>
                                                            </td>

                                                            <td style="width: 100%;">
                                                                <table style="width: 100%; height: 100%; border:none;">
                                                                    <tr>
                                                                        <td style="width: 36%; padding: 10px;">
                                                                            Diagnosa Utama</td>
                                                                        <td style=" padding: 10px;">
                                                                            <div class="col-12">
                                                                                <input type="text"
                                                                                    name="diagnosa_utama"
                                                                                    id="diagnosa_utama"
                                                                                    class="form-control">
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <x-adminlte-select2 name="poliKontrol" label="Poliklinik" id="poliklinik">
                                                                                    <option selected disabled>Cari Poliklinik</option>
                                                                                </x-adminlte-select2>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <label>Multiple</label>
                                                                                    <select class="select2" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                                                                                      <option>Alabama</option>
                                                                                      <option>Alaska</option>
                                                                                      <option>California</option>
                                                                                      <option>Delaware</option>
                                                                                      <option>Tennessee</option>
                                                                                      <option>Texas</option>
                                                                                      <option>Washington</option>
                                                                                    </select>
                                                                                  </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style=" padding: 10px;">
                                                                            Diagnosa Sekunder</td>
                                                                        <td style=" padding: 10px;">
                                                                            <div class="col-12">
                                                                                <input type="text"
                                                                                    name="diagnosa_sekunder"
                                                                                    id="diagnosa_sekunder"
                                                                                    class="form-control">
                                                                            </div>
                                                                            <div class="col-12 row mt-1">
                                                                                <div class="col-10">
                                                                                    <div class="form-group">
                                                                                        <label for="ICD10">Pilih
                                                                                            KODE ICD10</label>
                                                                                        <select name="icd10_sekunder"
                                                                                            id="icd10_sekunder"
                                                                                            class="form-control">
                                                                                            <option value="">
                                                                                                -pilih icd10-</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-2">
                                                                                    <button
                                                                                        class="btn btn-md btn-primary mt-4">+</button>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style=" padding: 10px;">
                                                                            Komplikasi</td>
                                                                        <td style=" padding: 10px;">
                                                                            <input type="text" name="komplikasi"
                                                                                id="komplikasi" class="form-control">
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong style="margin: 0.5rem 0;">Tindakan Operasi</strong>
                                                </td>
                                                <td colspan="2">
                                                    <textarea name="tindakan_operasi" id="tindakan_operasi" rows="5" class="form-control"
                                                        style="width: 100%; resize: vertical;"></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 38%;">
                                                    <div class="form-group">
                                                        <label for="tgl_operasi">Tgl Operasi:</label>
                                                        <input type="date" name="tgl_operasi" id="tgl_operasi"
                                                            class="form-control">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <label for="waktu_mulai_operasi">Waktu Mulai:</label>
                                                        <input type="time" name="waktu_mulai_operasi"
                                                            id="waktu_mulai_operasi" class="form-control">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <label for="waktu_selesai_operasi">Waktu Selesai:</label>
                                                        <input type="time" name="waktu_selesai_operasi"
                                                            id="waktu_selesai_operasi" class="form-control">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong style="margin: 0.5rem 0;">Sebab Kematian</strong>
                                                </td>
                                                <td colspan="2">
                                                    <textarea name="sebab_kematian" id="sebab_kematian" rows="5" class="form-control"
                                                        style="width: 100%; resize: vertical;"></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong style="margin: 0.5rem 0;">Tindakan / Prosedure</strong>
                                                </td>
                                                <td colspan="2">
                                                    <textarea name="tindakan_prosedure" id="tindakan_prosedure" rows="5" class="form-control"
                                                        style="width: 100%; resize: vertical;"></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="text-align: center;">
                                                    <strong style="margin: 0.5rem 0;">Pengobatan Selama
                                                        Dirawat</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <table style="width: 100%;">
                                                        <th>Nama Obat</th>
                                                        <th>Jumlah</th>
                                                        <th>Dosis</th>
                                                        <th>Frekuensi</th>
                                                        <th>Cara Pemberian</th>
                                                        <tr>
                                                            <td>-</td>
                                                            <td>-</td>
                                                            <td>-</td>
                                                            <td>-</td>
                                                            <td>-</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="text-align: center;">
                                                    <strong style="margin: 0.5rem 0;">Obat Untuk Pulang</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <table style="width: 100%;">
                                                        <th>Nama Obat</th>
                                                        <th>Jumlah</th>
                                                        <th>Dosis</th>
                                                        <th>Frekuensi</th>
                                                        <th>Cara Pemberian</th>
                                                        <tr>
                                                            <td>-</td>
                                                            <td>-</td>
                                                            <td>-</td>
                                                            <td>-</td>
                                                            <td>-</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <div class="col-12 row">
                                                        <div class="col-1"><strong style="margin: 0.5rem 0;">Cara
                                                                Keluar: </strong> </div>
                                                        <div class="col-2">
                                                            <div class="form-group">
                                                                <input type="checkbox" name="sembuh_perbaikan">
                                                                <label for="sembuh_perbaikan">Sembuh/Perbaikan</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-2">
                                                            <div class="form-group">
                                                                <input type="checkbox" name="pindah_rs">
                                                                <label for="pindah_rs">Pindah RS</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-2">
                                                            <div class="form-group">
                                                                <input type="checkbox" name="pulang_paksa">
                                                                <label for="pulang_paksa">Pulang Paksa</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-2">
                                                            <div class="form-group">
                                                                <input type="checkbox" name="meninggal">
                                                                <label for="meninggal">Meninggal</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <input type="text" name="cara_keluar_lainnya"
                                                                class="form-control col-12">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <div class="col-12 row">
                                                        <div class="col-3"
                                                            style="border-right: 1px solid rgb(198, 198, 198)">
                                                            Konsisi Pulang : <br>
                                                            <textarea name="kondisi_pulang" id="kondisi_pulang" cols="30" rows="4" class="form-control"></textarea>
                                                        </div>
                                                        <div class="col-3"
                                                            style="border-right: 1px solid rgb(198, 198, 198)">
                                                            Keadaan Umum : <br>
                                                            <textarea name="keadaan_umum" id="keadaan_umum" cols="30" rows="4" class="form-control"></textarea>
                                                        </div>
                                                        <div class="col-2"
                                                            style="border-right: 1px solid rgb(198, 198, 198)">
                                                            Kesadaran : <br>
                                                            <textarea name="kesadaran" id="kesadaran" cols="30" rows="4" class="form-control"></textarea>
                                                        </div>
                                                        <div class="col-2"
                                                            style="border-right: 1px solid rgb(198, 198, 198)">
                                                            Tekanan Darah : <br>
                                                            <textarea name="tekanan_darah" id="tekanan_darah" cols="30" rows="4" class="form-control"></textarea>
                                                        </div>
                                                        <div class="col-2">
                                                            Nadi : <br>
                                                            <textarea name="nadi" id="nadi" cols="30" rows="4" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <div class="col-12 row">
                                                        <div class="col-1"><strong
                                                                style="margin: 0.5rem 0;">Pengobatan
                                                                Dilanjutkan:</strong> </div>
                                                        <div class="col-2">
                                                            <div class="form-group">
                                                                <input type="checkbox" name="poliklinik_rswaled">
                                                                <label for="poliklinik_rswaled">Poliklinik RS
                                                                    Waled</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-2">
                                                            <div class="form-group">
                                                                <input type="checkbox" name="rs_lain">
                                                                <label for="rs_lain">RS Lain</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-2">
                                                            <div class="form-group">
                                                                <input type="checkbox" name="puskesmas">
                                                                <label for="puskesmas">Puskesmas</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-2">
                                                            <div class="form-group">
                                                                <input type="checkbox" name="dokter_praktek">
                                                                <label for="dokter_praktek">Dokter Praktek</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <input type="text" name="pengobatan_lanjutan_lainnya"
                                                                class="form-control col-12">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <div class="col-12 row">
                                                        <div class="col-2">
                                                            <strong style="margin: 0.5rem 0;">Instruksi Pulang</strong>
                                                        </div>
                                                        <div class="col-10">
                                                            <table style="width: 100%">
                                                                <tr>
                                                                    <td> Kontrol</td>
                                                                    <td> Tgl: <input type="date"
                                                                            class="form-control" name="tgl_kontrol">
                                                                    </td>
                                                                    <td> Di: <input type="text"
                                                                            class="form-control"
                                                                            name="lokasi_kontrol"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td> Diet</td>
                                                                    <td colspan="2">
                                                                        <textarea name="diet" id="diet" cols="30" rows="4" class="form-control"></textarea>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td> Latihan</td>
                                                                    <td colspan="2">
                                                                        <textarea name="latihan" id="latihan" cols="30" rows="4" class="form-control"></textarea>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="3">
                                                                        Segera kembali ke Rumah Sakit, langsung ke Gawat
                                                                        Darurat, bila terjadi: <br>
                                                                        <textarea name="keterangan_kembali" id="keterangan_kembali" cols="30" rows="4" class="form-control"></textarea>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

