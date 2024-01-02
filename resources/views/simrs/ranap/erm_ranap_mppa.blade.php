<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" href="#mppforma">
        <h3 class="card-title">
            Evaluasi Awal MPP (Form A)
        </h3>
    </a>
    <div id="mppforma" class="collapse" role="tabpanel">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <x-adminlte-textarea name="identifikasi" label="1. Identifikasi / skrining pasien terdapat jawaban"
                        rows="3" igroup-size="sm" placeholder="Ya ,">
                    </x-adminlte-textarea>
                    <b>2. Assesmen Meliputi</b> <br>
                    <b>a. Fisik, fungsional, kekuatan / kemampuan / kemandirian</b>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="option1">
                            <label for="customCheckbox1" class="custom-control-label">Custom
                                Checkbox</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" value="Mandiri Penuh" id="mandiripenuh"
                                name="kemampuan">
                            <label for="mandiripenuh" class="custom-control-label">Mandiri
                                Penuh</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="mandirisebagian"
                                value="Mandiri Sebagian" name="kemampuan">
                            <label for="mandirisebagian" class="custom-control-label">Mandiri
                                Sebagian</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" value="Total Bantuan" type="radio" id="bantuan"
                                name="kemampuan">
                            <label for="bantuan" class="custom-control-label">Total
                                Bantuan</label>
                        </div>
                        <x-adminlte-textarea name="kemampuan" rows="2" igroup-size="sm"
                            placeholder="Keterangan Lainnya">
                        </x-adminlte-textarea>
                    </div>
                    <x-adminlte-textarea name="identifikasi" label="b. Riwayat Kesehatan" rows="3"
                        igroup-size="sm" placeholder="Riwayat kesehatan">
                    </x-adminlte-textarea>
                    <x-adminlte-textarea name="identifikasi" label="c. Perilaku psiko-spiritual-sosio-kultural"
                        rows="3" igroup-size="sm">
                    </x-adminlte-textarea>
                    <x-adminlte-textarea name="identifikasi" label="d. Kesehatan mental dan kognitif" rows="3"
                        igroup-size="sm">
                    </x-adminlte-textarea>
                    <x-adminlte-textarea name="identifikasi" label="e. Lingkungan tempat tinggal" rows="3"
                        igroup-size="sm">
                    </x-adminlte-textarea>
                </div>
                <div class="col-md-4">
                    <b>f. Dukungan keluarga, kemampuan merawat dari pemberi asuhan</b>
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" value="Ya" id="dukunganya"
                                name="dukungan">
                            <label for="dukunganya" class="custom-control-label">Ya</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="dukunganno" value="Tidak"
                                name="dukungan">
                            <label for="dukunganno" class="custom-control-label">Tidak</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <b>g. Finansial</b>
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" value="Baik" id="fbaik"
                                        name="finansial">
                                    <label for="fbaik" class="custom-control-label">Baik</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="fsedang" value="Sedang"
                                        name="finansial">
                                    <label for="fsedang" class="custom-control-label">Sedang</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="fburuk" value="Buruk"
                                        name="finansial">
                                    <label for="fburuk" class="custom-control-label">Buruk</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <b>Jaminan</b>
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" value="Pribadi"
                                        id="jpribadi" name="jaminan">
                                    <label for="jpribadi" class="custom-control-label">Pribadi</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="jasuransi"
                                        value="Asuransi" name="jaminan">
                                    <label for="jasuransi" class="custom-control-label">Asuransi</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="jbpjs"
                                        value="JKN / BPJS" name="jaminan">
                                    <label for="jbpjs" class="custom-control-label">JKN / BPJS</label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <b>h. Riwayat Pengobatan Alternatif</b>
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" value="Pribadi" id="jpribadi"
                                name="jaminan">
                            <label for="jpribadi" class="custom-control-label">Pribadi</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="jasuransi" value="Asuransi"
                                name="jaminan">
                            <label for="jasuransi" class="custom-control-label">Asuransi</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="jbpjs" value="JKN / BPJS"
                                name="jaminan">
                            <label for="jbpjs" class="custom-control-label">JKN / BPJS</label>
                        </div>
                    </div>
                    <b>i. Riwayat Trauma / Kekerasan</b>
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" value="Tidak" id="tidaktrauma"
                                name="trauma">
                            <label for="tidaktrauma" class="custom-control-label">Tidak</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="adatrauma" value="Ada"
                                name="trauma">
                            <label for="adatrauma" class="custom-control-label">Ada</label>
                        </div>
                    </div>
                    <b>j. Pemahaman Tentang Kesehatan</b>
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" value="Tidak Tahu" id="tidaktahu"
                                name="pahamkesehatan">
                            <label for="tidaktahu" class="custom-control-label">Tidak Tahu</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="tahu1" value="Tahu"
                                name="pahamkesehatan">
                            <label for="tahu1" class="custom-control-label">Tahu</label>
                        </div>
                    </div>
                    <b>k. Harapan terhadap hasil asuhan, kemampuan menerima perubahan</b>
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
                    <x-adminlte-input name="perkiraanranap" igroup-size="sm" label="l. Perkiraan Lama Ranap (Hari)"
                        placeholder="Perkiraan Lama Ranap" />
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
                    <x-adminlte-textarea name="identifikasi" label="Jangka Pendek" rows="3" igroup-size="sm"
                        placeholder="Ya , ...">
                    </x-adminlte-textarea>
                    <x-adminlte-textarea name="identifikasi" label="Jangka Panjang" rows="3" igroup-size="sm"
                        placeholder="Ya , ...">
                    </x-adminlte-textarea>
                    <x-adminlte-textarea name="identifikasi" label="Kebutuhan Berjalan" rows="3"
                        igroup-size="sm" placeholder="Ya , ...">
                    </x-adminlte-textarea>
                    <x-adminlte-textarea name="identifikasi" label="Lain-lain" rows="3" igroup-size="sm"
                        placeholder="Ya , ...">
                    </x-adminlte-textarea>
                </div>
            </div>
        </div>
    </div>
</div>
