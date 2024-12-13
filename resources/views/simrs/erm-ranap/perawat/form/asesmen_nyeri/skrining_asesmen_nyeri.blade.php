<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Skrining & Asesmen Nyeri</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <strong>Skrining Nyeri :</strong> Apakah Terdapat Keluhan Nyeri
                <div class="icheck-primary d-inline mr-3">
                    <input type="checkbox" id="keluhan_nyeri_tidak" name="keluhan_nyeri[]" value="Tidak"
                        {{ in_array('Tidak', $skriningNyeri['keluhan_nyeri'] ?? []) ? 'checked' : '' }}>
                    <label for="keluhan_nyeri_tidak">Tidak</label>
                </div>
                <div class="icheck-primary d-inline mr-3">
                    <input type="checkbox" id="keluhan_nyeri_ada" name="keluhan_nyeri[]" value="Ada"
                        {{ in_array('Ada', $skriningNyeri['keluhan_nyeri'] ?? []) ? 'checked' : '' }}>
                    <label for="keluhan_nyeri_ada">Ada, </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="Skala">Skala </label>
                    <input type="text" name="skala_nyeri" id="skala_nyeri" class="form-control col-4 mr-2 ml-2"
                        value="{{ is_array($skriningNyeri['skala_nyeri'] ?? null) ? implode(', ', $skriningNyeri['skala_nyeri']) : $skriningNyeri['skala_nyeri'] ?? '' }}">
                    lanjutkan dengan
                    asesmen nyeri.
                </div>
            </div>
            <div class="col-md-12 row">
                <div class="col-8">
                    <img src="{{ asset('nyeri_nrs.png') }}" alt="" width="80%">
                </div>
                <div class="col-4" style="border: 1 px solid black;">
                    <ul>
                        <li class="mb-1">
                            <div class="icheck-primary d-inline mr-3">
                                <input type="radio" id="klasifikasi_nyeri_0" name="klasifikasi_nyeri" value="0"
                                    disabled>
                                <label for="klasifikasi_nyeri_0">Skor 0 = Tidak Nyeri</label>
                            </div>
                        </li>
                        <li class="mb-1">
                            <div class="icheck-primary d-inline mr-3">
                                <input type="radio" id="klasifikasi_nyeri_1_3" name="klasifikasi_nyeri" disabled
                                    value="1-3">
                                <label for="klasifikasi_nyeri_1_3">Skor 1-3 = Nyeri Ringan</label>
                            </div>
                        </li>
                        <li class="mb-1">
                            <div class="icheck-primary d-inline mr-3">
                                <input type="radio" id="klasifikasi_nyeri_4_6" name="klasifikasi_nyeri" disabled
                                    value="4-6">
                                <label for="klasifikasi_nyeri_4_6">Skor 4-6 = Nyeri Sedang</label>
                            </div>
                        </li>
                        <li class="mb-1">
                            <div class="icheck-primary d-inline mr-3">
                                <input type="radio" id="klasifikasi_nyeri_7_10" name="klasifikasi_nyeri" disabled
                                    value="7-10">
                                <label for="klasifikasi_nyeri_7_10">Skor 7-10 = Nyeri Hebat</label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-12">
                <h6><strong>Asesmen Nyeri Lanjutan :</strong></h6>
                <div class="col-12 mb-1">
                    <div class="row mb-1">
                        <div class="col-3"><strong>P</strong>rovocation</div>
                        <div class="col-3">
                            <div class="icheck-primary d-inline mr-3">
                                <input type="checkbox" id="provocation_cahaya" name="provocation[]" value="cahaya"
                                    {{ in_array('cahaya', $NyeriLanjutan['provocation'] ?? []) ? 'checked' : '' }}>
                                <label for="provocation_cahaya">Cahaya</label>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icheck-primary d-inline mr-3">
                                <input type="checkbox" id="provocation_gelap" name="provocation[]" value="gelap"
                                    {{ in_array('gelap', $NyeriLanjutan['provocation'] ?? []) ? 'checked' : '' }}>
                                <label for="provocation_gelap">Gelap</label>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icheck-primary d-inline mr-3">
                                <input type="checkbox" id="provocation_gerakan" name="provocation[]" value="gerakan"
                                    {{ in_array('gerakan', $NyeriLanjutan['provocation'] ?? []) ? 'checked' : '' }}>
                                <label for="provocation_gerakan">Gerakan</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-3"><strong>Q</strong>uality</div>
                        <div class="col-9">
                            <div class="row">
                                <div class="col-2">
                                    <div class="icheck-primary d-inline mr-3">
                                        <input type="checkbox" id="quality_ditusuk" name="quality[]" value="ditusuk"
                                            {{ in_array('ditusuk', (array) ($NyeriLanjutan['quality'] ?? [])) ? 'checked' : '' }}>
                                        <label for="quality_ditusuk">Ditusuk</label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="icheck-primary d-inline mr-3">
                                        <input type="checkbox" id="quality_dibakar" name="quality[]"
                                            {{ in_array('dibakar', (array) ($NyeriLanjutan['quality'] ?? [])) ? 'checked' : '' }}
                                            value="dibakar">
                                        <label for="quality_dibakar">Dibakar</label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="icheck-primary d-inline mr-3">
                                        <input type="checkbox" id="quality_ditarik" name="quality[]"
                                            {{ in_array('ditarik', (array) ($NyeriLanjutan['quality'] ?? [])) ? 'checked' : '' }}
                                            value="ditarik">
                                        <label for="quality_ditarik">Ditarik</label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="icheck-primary d-inline mr-3">
                                        <input type="checkbox" id="quality_kram" name="quality[]" value="kram"
                                            {{ in_array('kram', (array) ($NyeriLanjutan['quality'] ?? [])) ? 'checked' : '' }}>
                                        <label for="quality_kram">Kram</label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="icheck-primary d-inline mr-3">
                                        <input type="checkbox" id="quality_berdenyut" name="quality[]"
                                            {{ in_array('berdenyut', (array) ($NyeriLanjutan['quality'] ?? [])) ? 'checked' : '' }}
                                            value="berdenyut">
                                        <label for="quality_berdenyut">Berdenyut</label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="icheck-primary d-inline mr-3">
                                        <input type="checkbox" id="quality_lainnya" name="quality[]"
                                            {{ in_array('lainnya', (array) ($NyeriLanjutan['quality'] ?? [])) ? 'checked' : '' }}
                                            value="lainnya">
                                        <label for="quality_lainnya">Lainnya</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-1">
                        <div class="col-3"><strong>R</strong>egion</div>
                        <div class="col-3">
                            <div class="icheck-primary d-inline mr-3">
                                <input type="checkbox" id="region_berpindah" name="region[]"
                                    {{ in_array('nyeri_berpindah', $NyeriLanjutan['region'] ?? []) ? 'checked' : '' }}
                                    value="nyeri_berpindah">
                                <label for="region_berpindah">Nyeri berpindah-pindah</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="icheck-primary d-inline mr-3">
                                <input type="checkbox" id="region_tetap" name="region[]" value="nyeri_tetap"
                                    {{ in_array('nyeri_tetap', $NyeriLanjutan['region'] ?? []) ? 'checked' : '' }}>
                                <label for="region_tetap">Nyeri tetap</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-1">
                        <div class="col-3"><strong>S</strong>everity</div>
                        <div class="col-3">
                            <div class="icheck-primary d-inline mr-3">
                                <input type="checkbox" id="severity_ringan" name="severity[]" value="ringan"
                                    {{ in_array('ringan', $NyeriLanjutan['severity'] ?? []) ? 'checked' : '' }}>
                                <label for="severity_ringan">Nyeri Ringan</label>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icheck-primary d-inline mr-3">
                                <input type="checkbox" id="severity_sedang" name="severity[]" value="sedang"
                                    {{ in_array('sedang', $NyeriLanjutan['severity'] ?? []) ? 'checked' : '' }}>
                                <label for="severity_sedang">Nyeri Sedang</label>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icheck-primary d-inline mr-3">
                                <input type="checkbox" id="severity_berat" name="severity[]" value="berat"
                                    {{ in_array('berat', $NyeriLanjutan['severity'] ?? []) ? 'checked' : '' }}>
                                <label for="severity_berat">Nyeri Berat</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3"><strong>T</strong>ime</div>
                        <div class="col-9">
                            <div class="row">
                                <div class="col-3">
                                    <div class="icheck-primary d-inline mr-3">
                                        <input type="checkbox" id="time_terus_menerus" name="time[]"
                                            {{ in_array('terus_menerus', $NyeriLanjutan['time'] ?? []) ? 'checked' : '' }}
                                            value="terus_menerus">
                                        <label for="time_terus_menerus">Terus menerus</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="icheck-primary d-inline mr-3">
                                        <input type="checkbox" id="time_hilang_timbul" name="time[]"
                                            {{ in_array('hilang_timbul', $NyeriLanjutan['time'] ?? []) ? 'checked' : '' }}
                                            value="hilang_timbul">
                                        <label for="time_hilang_timbul">Hilang timbul</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="icheck-primary d-inline mr-3">
                                        <input type="checkbox" id="time_kurang_30" name="time[]" value="kurang_30"
                                            {{ in_array('kurang_30', $NyeriLanjutan['time'] ?? []) ? 'checked' : '' }}>
                                        <label for="time_kurang_30">&lt; 30 menit</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="icheck-primary d-inline mr-3">
                                        <input type="checkbox" id="time_lebih_30" name="time[]" value="lebih_30"
                                            {{ in_array('lebih_30', $NyeriLanjutan['time'] ?? []) ? 'checked' : '' }}>
                                        <label for="time_lebih_30">&gt; 30 menit</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="Keluhan Utama">Keluhan Utama</label>
                                <textarea name="riwayat_kesehatan_keluahan_utama" class="form-control" id="" cols="30"
                                    rows="3">{{ $asesmenkeperawatan->keluhan_utama ?? '' }}</textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="Riwayat Penyakit Sekarang">Riwayat Penyakit Sekarang</label>
                                <textarea name="riwayat_kesehatan_riwayat_penyakit_sekarang" class="form-control" id="" cols="30"
                                    rows="3">{{ $asesmenkeperawatan->penyakit_sekarang ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <h6><strong>Riwayat Kesehatan :</strong></h6>
                <div class="col-12 mb-1">
                    <div class="row">
                        <div class="col-3">Pernah dirawat di RS</div>
                        <div class="col-4">
                            <div class="icheck-primary d-inline mr-3">
                                <input type="checkbox" id="riwayat_kesehatan_pernah_dirawat_tidak"
                                    {{ in_array('Tidak', $riwayatKesehatan['riwayat_kesehatan_pernah_dirawat'] ?? []) ? 'checked' : '' }}
                                    name="riwayat_kesehatan_pernah_dirawat[]" value="Tidak">
                                <label for="riwayat_kesehatan_pernah_dirawat_tidak">Tidak</label>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="row">
                                <div class="col-4">
                                    <div class="icheck-primary d-inline mr-3">
                                        <input type="checkbox" id="riwayat_kesehatan_pernah_dirawat_ya"
                                            {{ in_array('Ya', $riwayatKesehatan['riwayat_kesehatan_pernah_dirawat'] ?? []) ? 'checked' : '' }}
                                            name="riwayat_kesehatan_pernah_dirawat[]" value="Ya">
                                        <label for="riwayat_kesehatan_pernah_dirawat_ya">Ya, Penyakit</label>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="riwayat_kesehatan_nama_penyakit"
                                        value="{{ is_array($riwayatKesehatan['riwayat_kesehatan_nama_penyakit'] ?? null) ? implode(', ', $riwayatKesehatan['riwayat_kesehatan_nama_penyakit']) : $riwayatKesehatan['riwayat_kesehatan_nama_penyakit'] ?? '' }}"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1 mt-1">
                        <div class="col-3">Riwayat Pemakaian Obat</div>
                        <div class="col-4">
                            <div class="icheck-primary d-inline mr-3">
                                <input type="checkbox" id="riwayat_kesehatan_pemakaian_obat_tidak"
                                    {{ in_array('Tidak', $riwayatKesehatan['riwayat_kesehatan_pemakaian_obat'] ?? []) ? 'checked' : '' }}
                                    name="riwayat_kesehatan_pemakaian_obat[]" value="Tidak">
                                <label for="riwayat_kesehatan_pemakaian_obat_tidak">Tidak</label>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="row">
                                <div class="col-4">
                                    <div class="icheck-primary d-inline mr-3">
                                        <input type="checkbox" id="riwayat_kesehatan_pemakaian_obat_ya"
                                            {{ in_array('Ya', $riwayatKesehatan['riwayat_kesehatan_pemakaian_obat'] ?? []) ? 'checked' : '' }}
                                            name="riwayat_kesehatan_pemakaian_obat[]" value="Ya">
                                        <label for="riwayat_kesehatan_pemakaian_obat_ya">Ya, Sebutkan</label>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="riwayat_kesehatan_nama_obat" class="form-control"
                                        value="{{ is_array($riwayatKesehatan['riwayat_kesehatan_nama_obat'] ?? null) ? implode(', ', $riwayatKesehatan['riwayat_kesehatan_nama_obat']) : $riwayatKesehatan['riwayat_kesehatan_nama_obat'] ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-3">Riwayat Penyerta</div>
                        <div class="col-9">
                            <div class="row">
                                <div class="col-3 mb-1">
                                    <div class="icheck-primary d-inline mr-3">
                                        <input type="checkbox" id="riwayat_penyerta_dm" name="riwayat_penyerta[]"
                                            {{ in_array('DM', $riwayatKesehatan['riwayat_penyerta'] ?? []) ? 'checked' : '' }}
                                            value="DM">
                                        <label for="riwayat_penyerta_dm">DM</label>
                                    </div>
                                </div>
                                <div class="col-3 mb-1">
                                    <div class="icheck-primary d-inline mr-3">
                                        <input type="checkbox" id="riwayat_penyerta_hipertensi"
                                            {{ in_array('hipertensi', $riwayatKesehatan['riwayat_penyerta'] ?? []) ? 'checked' : '' }}
                                            name="riwayat_penyerta[]" value="hipertensi">
                                        <label for="riwayat_penyerta_hipertensi">Hipertensi</label>
                                    </div>
                                </div>
                                <div class="col-3 mb-1">
                                    <div class="icheck-primary d-inline mr-3">
                                        <input type="checkbox" id="riwayat_penyerta_kholesterol"
                                            {{ in_array('kholesterol', $riwayatKesehatan['riwayat_penyerta'] ?? []) ? 'checked' : '' }}
                                            name="riwayat_penyerta[]" value="kholesterol">
                                        <label for="riwayat_penyerta_kholesterol">Kholesterol</label>
                                    </div>
                                </div>
                                <div class="col-3 mb-1">
                                    <div class="icheck-primary d-inline mr-3">
                                        <input type="checkbox" id="riwayat_penyerta_gagal_ginjal"
                                            {{ in_array('gagal_ginjal', $riwayatKesehatan['riwayat_penyerta'] ?? []) ? 'checked' : '' }}
                                            name="riwayat_penyerta[]" value="gagal_ginjal">
                                        <label for="riwayat_penyerta_gagal_ginjal">Gagal Ginjal</label>
                                    </div>
                                </div>
                                <div class="col-3 mb-1">
                                    <div class="icheck-primary d-inline mr-3">
                                        <input type="checkbox" id="riwayat_penyerta_tbc" name="riwayat_penyerta[]"
                                            {{ in_array('tbc', $riwayatKesehatan['riwayat_penyerta'] ?? []) ? 'checked' : '' }}
                                            value="tbc">
                                        <label for="riwayat_penyerta_tbc">TBC</label>
                                    </div>
                                </div>
                                <div class="col-3 mb-1">
                                    <div class="icheck-primary d-inline mr-3">
                                        <input type="checkbox" id="riwayat_penyerta_kanker" name="riwayat_penyerta[]"
                                            {{ in_array('kanker', $riwayatKesehatan['riwayat_penyerta'] ?? []) ? 'checked' : '' }}
                                            value="kanker">
                                        <label for="riwayat_penyerta_kanker">Kanker</label>
                                    </div>
                                </div>
                                <div class="col-6 mb-1">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="icheck-primary d-inline mr-3">
                                                <input type="checkbox" id="riwayat_penyerta_lainya"
                                                    {{ in_array('lainya', $riwayatKesehatan['riwayat_penyerta'] ?? []) ? 'checked' : '' }}
                                                    name="riwayat_penyerta[]" value="lainya">
                                                <label for="riwayat_penyerta_lainya">Lain-lain</label>
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" name="riwayat_penyerta_keterangan_lainya"
                                                value="{{ is_array($riwayatKesehatan['riwayat_penyerta_keterangan_lainya'] ?? null) ? implode(', ', $riwayatKesehatan['riwayat_penyerta_keterangan_lainya']) : $riwayatKesehatan['riwayat_penyerta_keterangan_lainya'] ?? '' }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-3">Riwayat Alergi</div>
                        <div class="col-2">
                            <div class="icheck-primary d-inline mr-3">
                                <input type="checkbox" id="riwayat_alergi_tidak" name="riwayat_alergi[]"
                                    {{ in_array('Tidak', $riwayatKesehatan['riwayat_alergi'] ?? []) ? 'checked' : '' }}
                                    value="Tidak">
                                <label for="riwayat_alergi_tidak">Tidak</label>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="row">
                                <div class="col-4">
                                    <div class="icheck-primary d-inline mr-3">
                                        <input type="checkbox" id="riwayat_alergi_ya" name="riwayat_alergi[]"
                                            {{ in_array('Ya', $riwayatKesehatan['riwayat_alergi'] ?? []) ? 'checked' : '' }}
                                            value="Ya">
                                        <label for="riwayat_alergi_ya">Ya, Sebutkan</label>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="riwayat_alergi_keterangan" class="form-control"
                                        value="{{ is_array($riwayatKesehatan['riwayat_alergi_keterangan'] ?? null) ? implode(', ', $riwayatKesehatan['riwayat_alergi_keterangan']) : $riwayatKesehatan['riwayat_alergi_keterangan'] ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var skalaNyeri = parseInt(document.getElementById('skala_nyeri').value); // Convert to integer
        // Ambil referensi ke radio button
        var radio0 = document.getElementById('klasifikasi_nyeri_0');
        var radio1_3 = document.getElementById('klasifikasi_nyeri_1_3');
        var radio4_6 = document.getElementById('klasifikasi_nyeri_4_6');
        var radio7_10 = document.getElementById('klasifikasi_nyeri_7_10');

        // Cek nilai skala nyeri dan pilih radio button yang sesuai
        if (!isNaN(skalaNyeri)) { // Pastikan skalaNyeri adalah angka
            if (skalaNyeri === 0) {
                radio0.checked = true;
            } else if (skalaNyeri >= 1 && skalaNyeri <= 3) {
                radio1_3.checked = true;
            } else if (skalaNyeri >= 4 && skalaNyeri <= 6) {
                radio4_6.checked = true;
            } else if (skalaNyeri >= 7 && skalaNyeri <= 10) {
                radio7_10.checked = true;
            }
        }
    });
</script>
