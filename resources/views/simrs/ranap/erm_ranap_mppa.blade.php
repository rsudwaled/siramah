<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" href="#mppforma">
        <h3 class="card-title">
            Evaluasi Awal MPP (Form A)
        </h3>
    </a>
    <div id="mppforma" class="collapse" role="tabpanel">
        <div class="card-body">
            <form action="{{ route('simpan_mppa') }}" id="formMppa" name="formMppa" method="post">
                @csrf
                <input type="hidden" name="norm" value="{{ $kunjungan->no_rm }}">
                <input type="hidden" name="kode_kunjungan" value="{{ $kunjungan->kode_kunjungan }}">
                <div class="row">
                    <div class="col-md-4">
                        <x-adminlte-textarea name="skiring" label="1. Identifikasi / skrining pasien terdapat jawaban"
                            rows="3" igroup-size="sm">
                            {{ $kunjungan->erm_ranap_mppa->skiring ?? '' }}
                        </x-adminlte-textarea>
                        <b>2. Assesmen Meliputi</b> <br>
                        <b>a. Fisik, fungsional, kekuatan / kemampuan / kemandirian</b>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" value="Mandiri Penuh"
                                    id="mandiripenuh" name="kemampuan"
                                    {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->kemampuan == 'Mandiri Penuh' ? 'checked' : null) : null }}>
                                <label for="mandiripenuh" class="custom-control-label">Mandiri
                                    Penuh</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="mandirisebagian"
                                    value="Mandiri Sebagian" name="kemampuan"
                                    {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->kemampuan == 'Mandiri Sebagian' ? 'checked' : null) : null }}>
                                <label for="mandirisebagian" class="custom-control-label">Mandiri
                                    Sebagian</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" value="Total Bantuan" type="radio" id="bantuan"
                                    name="kemampuan"
                                    {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->kemampuan == 'Total Bantuan' ? 'checked' : null) : null }}>
                                <label for="bantuan" class="custom-control-label">Total
                                    Bantuan</label>
                            </div>
                            <x-adminlte-textarea name="kemampuan_text" rows="2" igroup-size="sm"
                                placeholder="Keterangan Lainnya">
                                {{ $kunjungan->erm_ranap_mppa->kemampuan_text ?? '' }}
                            </x-adminlte-textarea>
                        </div>
                        <x-adminlte-textarea name="riwayat_kesehatan" label="b. Riwayat Kesehatan" rows="3"
                            igroup-size="sm">
                            {{ $kunjungan->erm_ranap_mppa->riwayat_kesehatan ?? '' }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea name="psikologi" label="c. Perilaku psiko-spiritual-sosio-kultural"
                            rows="3" igroup-size="sm">
                            {{ $kunjungan->erm_ranap_mppa->psikologi ?? '' }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea name="mental" label="d. Kesehatan mental dan kognitif" rows="3"
                            igroup-size="sm">
                            {{ $kunjungan->erm_ranap_mppa->mental ?? '' }}
                        </x-adminlte-textarea>
                        <x-adminlte-textarea name="lingkungan" label="e. Lingkungan tempat tinggal" rows="3"
                            igroup-size="sm">
                            {{ $kunjungan->erm_ranap_mppa->lingkungan ?? '' }}
                        </x-adminlte-textarea>
                    </div>
                    <div class="col-md-4">
                        <b>f. Dukungan keluarga, kemampuan merawat dari pemberi asuhan</b>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" value="Ya" id="dukunganya"
                                    name="dukungan"
                                    {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->dukungan == 'Ya' ? 'checked' : null) : null }}>
                                <label for="dukunganya" class="custom-control-label">Ya</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="dukunganno" value="Tidak"
                                    name="dukungan"
                                    {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->dukungan == 'Tidak' ? 'checked' : null) : null }}>
                                <label for="dukunganno" class="custom-control-label">Tidak</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <b>g. Finansial</b>
                                <div class="form-group">
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" value="Baik" id="fbaik"
                                            name="finansial"
                                            {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->finansial == 'Baik' ? 'checked' : null) : null }}>
                                        <label for="fbaik" class="custom-control-label">Baik</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="fsedang"
                                            value="Sedang" name="finansial"
                                            {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->finansial == 'Sedang' ? 'checked' : null) : null }}>
                                        <label for="fsedang" class="custom-control-label">Sedang</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="fburuk"
                                            value="Buruk" name="finansial"
                                            {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->finansial == 'Buruk' ? 'checked' : null) : null }}>
                                        <label for="fburuk" class="custom-control-label">Buruk</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <b>Jaminan</b>
                                <div class="form-group">
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" value="Pribadi"
                                            id="jpribadi" name="jaminan"
                                            {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->jaminan == 'Pribadi' ? 'checked' : null) : null }}>
                                        <label for="jpribadi" class="custom-control-label">Pribadi</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="jasuransi"
                                            value="Asuransi" name="jaminan"
                                            {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->jaminan == 'Asuransi' ? 'checked' : null) : null }}>
                                        <label for="jasuransi" class="custom-control-label">Asuransi</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="jbpjs"
                                            value="JKN / BPJS" name="jaminan"
                                            {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->jaminan == 'JKN / BPJS' ? 'checked' : null) : null }}>
                                        <label for="jbpjs" class="custom-control-label">JKN / BPJS</label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <b>h. Riwayat Pengobatan Alternatif</b>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" value="Ya"
                                    id="obatalternatifya" name="pengobatan_alt"
                                    {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->pengobatan_alt == 'Ya' ? 'checked' : null) : null }}>
                                <label for="obatalternatifya" class="custom-control-label">Ya</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="obatalternatiftidak"
                                    value="Tidak" name="pengobatan_alt"
                                    {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->pengobatan_alt == 'Tidak' ? 'checked' : null) : null }}>
                                <label for="obatalternatiftidak" class="custom-control-label">Tidak</label>
                            </div>
                        </div>
                        <b>i. Riwayat Trauma / Kekerasan</b>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" value="Tidak" id="tidaktrauma"
                                    name="trauma"
                                    {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->trauma == 'Tidak' ? 'checked' : null) : null }}>
                                <label for="tidaktrauma" class="custom-control-label">Tidak</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="adatrauma" value="Ada"
                                    name="trauma"
                                    {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->trauma == 'Ada' ? 'checked' : null) : null }}>
                                <label for="adatrauma" class="custom-control-label">Ada</label>
                            </div>
                        </div>
                        <b>j. Pemahaman Tentang Kesehatan</b>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" value="Tidak Tahu" id="tidaktahu"
                                    name="paham"
                                    {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->paham == 'Tidak Tahu' ? 'checked' : null) : null }}>
                                <label for="tidaktahu" class="custom-control-label">Tidak Tahu</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="tahu1" value="Tahu"
                                    name="paham"
                                    {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->paham == 'Tahu' ? 'checked' : null) : null }}>
                                <label for="tahu1" class="custom-control-label">Tahu</label>
                            </div>
                        </div>
                        <b>k. Harapan terhadap hasil asuhan, kemampuan menerima perubahan</b>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" value="Tidak" id="tidakberubah"
                                    name="harapan"
                                    {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->harapan == 'Tidak' ? 'checked' : null) : null }}>
                                <label for="tidakberubah" class="custom-control-label">Tidak</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="adaberubah" value="Ada"
                                    name="harapan"
                                    {{ $kunjungan->erm_ranap_mppa ? ($kunjungan->erm_ranap_mppa->harapan == 'Ada' ? 'checked' : null) : null }}>
                                <label for="adaberubah" class="custom-control-label">Ada</label>
                            </div>
                        </div>
                        <x-adminlte-input name="perkiraan_inap" igroup-size="sm"
                            label="l. Perkiraan Lama Ranap (Hari)" type="number" placeholder="Perkiraan Lama Ranap"
                            value="{{ $kunjungan->erm_ranap_mppa ? $kunjungan->erm_ranap_mppa->perkiraan_inap : null }}" />
                        <b>m. Discharge Plan </b>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" value="Tidak" id="tidakberubah"
                                    name="harapan">
                                <label for="tidakberubah" class="custom-control-label">Tidak</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="adaberubah" value="Ada"
                                    name="harapan">
                                <label for="adaberubah" class="custom-control-label">Ada</label>
                            </div>
                        </div>
                        <b>n. Perencanaan Lanjutan </b>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" value="Tidak" id="tidakberubah"
                                    name="harapan">
                                <label for="tidakberubah" class="custom-control-label">Tidak</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="adaberubah" value="Ada"
                                    name="harapan">
                                <label for="adaberubah" class="custom-control-label">Ada</label>
                            </div>
                        </div>
                        <b>o. Aspek Legal </b>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" value="Tidak" id="tidakberubah"
                                    name="harapan">
                                <label for="tidakberubah" class="custom-control-label">Tidak</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="adaberubah" value="Ada"
                                    name="harapan">
                                <label for="adaberubah" class="custom-control-label">Ada</label>
                            </div>
                        </div>
                        <b>3. Identifikasi Masalah - Resiko - Kesempatan </b>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" value="Tidak" id="tidakberubah"
                                    name="harapan">
                                <label for="tidakberubah" class="custom-control-label">Tidak</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="adaberubah" value="Ada"
                                    name="harapan">
                                <label for="adaberubah" class="custom-control-label">Ada</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <b>4. Perencanaan MPP </b>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" value="Tidak" id="tidakberubah"
                                    name="harapan">
                                <label for="tidakberubah" class="custom-control-label">Tidak</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="adaberubah" value="Ada"
                                    name="harapan">
                                <label for="adaberubah" class="custom-control-label">Ada</label>
                            </div>
                        </div>
                        <x-adminlte-textarea name="identifikasi" label="Jangka Pendek" rows="3"
                            igroup-size="sm" placeholder="Ya , ...">
                        </x-adminlte-textarea>
                        <x-adminlte-textarea name="identifikasi" label="Jangka Panjang" rows="3"
                            igroup-size="sm" placeholder="Ya , ...">
                        </x-adminlte-textarea>
                        <x-adminlte-textarea name="identifikasi" label="Kebutuhan Berjalan" rows="3"
                            igroup-size="sm" placeholder="Ya , ...">
                        </x-adminlte-textarea>
                        <x-adminlte-textarea name="identifikasi" label="Lain-lain" rows="3" igroup-size="sm"
                            placeholder="Ya , ...">
                        </x-adminlte-textarea>
                    </div>
                </div>
                <button type="submit" form="formMppa" class="btn btn-success">
                    <i class="fas fa-edit"></i> Simpan
                </button>
                <a class="btn btn-warning" target="_blank"
                    href="{{ route('print_resume_ranap') }}?kode={{ $kunjungan->kode_kunjungan }}">Print</a>
            </form>
        </div>
    </div>
</div>
