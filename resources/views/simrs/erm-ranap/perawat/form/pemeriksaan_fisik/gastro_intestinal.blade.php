<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Sistem Gastro Intestinal</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <ol type="a" style="font-size: 13px;">
            <li>
                Makan :
                <div class="row">
                    <div class="col-6">
                        Frekuensi :
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="makan_frekuensi"
                                value="{{ is_array($sistemGastroIntestinal['makan_frekuensi'] ?? null) ? implode(', ', $sistemGastroIntestinal['makan_frekuensi']) : $sistemGastroIntestinal['makan_frekuensi'] ?? '' }}">
                            <div class="input-group-append">
                                <span class="input-group-text">X/Hari</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        Jumlah :
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="makan_jumlah"
                                value="{{ is_array($sistemGastroIntestinal['makan_jumlah'] ?? null) ? implode(', ', $sistemGastroIntestinal['makan_jumlah']) : $sistemGastroIntestinal['makan_jumlah'] ?? '' }}">
                            <div class="input-group-append">
                                <span class="input-group-text">Porsi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="row">
                    <div class="col-6">
                        Mual:
                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline  mr-3">
                                <input type="checkbox" id="mual_tidak" name="mual[]" value="Tidak"
                                    {{ in_array('Tidak', $sistemGastroIntestinal['mual'] ?? []) ? 'checked' : '' }}>
                                <label for="mual_tidak">Tidak</label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="mual_ya" name="mual[]" value="Ya"
                                    {{ in_array('Ya', $sistemGastroIntestinal['mual'] ?? []) ? 'checked' : '' }}>
                                <label for="mual_ya">Ya</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-6">
                                Muntah:
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline  mr-3">
                                        <input type="checkbox" id="muntah_tidak" name="muntah[]" value="Tidak"
                                            {{ in_array('Tidak', $sistemGastroIntestinal['muntah'] ?? []) ? 'checked' : '' }}>
                                        <label for="muntah_tidak">Tidak</label>
                                    </div>
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="muntah_warna" name="muntah[]" value="Warna"
                                            {{ in_array('Warna', $sistemGastroIntestinal['muntah'] ?? []) ? 'checked' : '' }}>
                                        <label for="muntah_warna">Warna</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <input type="text" name="warna_muntah" class="form-control"
                                    placeholder="warna muntah ..."
                                    value="{{ is_array($sistemGastroIntestinal['warna_muntah'] ?? null) ? implode(', ', $sistemGastroIntestinal['warna_muntah']) : $sistemGastroIntestinal['warna_muntah'] ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="row">
                    <div class="col-4">
                        BAB :
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="bab"
                                value="{{ is_array($sistemGastroIntestinal['bab'] ?? null) ? implode(', ', $sistemGastroIntestinal['bab']) : $sistemGastroIntestinal['bab'] ?? '' }}">
                            <div class="input-group-append">
                                <span class="input-group-text">X/Hari</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        Warna :
                        <input type="text" class="form-control" name="warna_bab"
                            value="{{ is_array($sistemGastroIntestinal['warna_bab'] ?? null) ? implode(', ', $sistemGastroIntestinal['warna_bab']) : $sistemGastroIntestinal['warna_bab'] ?? '' }}">
                    </div>
                    <div class="col-4">
                        Konsistensi :
                        <input type="text" class="form-control" name="konsistensi_bab"
                            value="{{ is_array($sistemGastroIntestinal['konsistensi_bab'] ?? null) ? implode(', ', $sistemGastroIntestinal['konsistensi_bab']) : $sistemGastroIntestinal['konsistensi_bab'] ?? '' }}">

                    </div>
                </div>
            </li>
            <li>
                Sklera:
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="sklera_ikterik" name="sklera[]" value="Ikterik"
                            {{ in_array('Ikterik', $sistemGastroIntestinal['sklera'] ?? []) ? 'checked' : '' }}>
                        <label for="sklera_ikterik">Ikterik</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="sklera_tidak" name="sklera[]" value="Tidak"
                            {{ in_array('Tidak', $sistemGastroIntestinal['sklera'] ?? []) ? 'checked' : '' }}>
                        <label for="sklera_tidak">Tidak</label>
                    </div>
                </div>
            </li>
            <li>
                Mulut & Pharyng: <br>
                <div class="form-group clearfix">
                    Mukosa:
                    <div class="icheck-primary d-inline mr-3 ml-3">
                        <input type="checkbox" id="mukosa_lembab" name="mukosa[]" value="Lembab"
                            {{ in_array('Lembab', $sistemGastroIntestinal['mukosa'] ?? []) ? 'checked' : '' }}>
                        <label for="mukosa_lembab">Lembab</label>
                    </div>
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="mukosa_kering" name="mukosa[]" value="Kering"
                            {{ in_array('Kering', $sistemGastroIntestinal['mukosa'] ?? []) ? 'checked' : '' }}>
                        <label for="mukosa_kering">Kering</label>
                    </div>
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="mukosa_lesi" name="mukosa[]" value="Lesi"
                            {{ in_array('Lesi', $sistemGastroIntestinal['mukosa'] ?? []) ? 'checked' : '' }}>
                        <label for="mukosa_lesi">Lesi</label>
                    </div>
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="mukosa_nodul" name="mukosa[]" value="Nodul"
                            {{ in_array('Nodul', $sistemGastroIntestinal['mukosa'] ?? []) ? 'checked' : '' }}>
                        <label for="mukosa_nodul">Nodul</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Lidah Warna :
                        <input type="text" class="form-control" name="warna_lidah"
                            value="{{ is_array($sistemGastroIntestinal['warna_lidah'] ?? null) ? implode(', ', $sistemGastroIntestinal['warna_lidah']) : $sistemGastroIntestinal['warna_lidah'] ?? '' }}">
                    </div>
                    <div class="col-8 mt-4">
                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline mr-3">
                                <input type="checkbox" id="lidah_ulkus" name="lidah_warna[]" value="Ulkus"
                                    {{ in_array('Ulkus', $sistemGastroIntestinal['lidah_warna'] ?? []) ? 'checked' : '' }}>
                                <label for="lidah_ulkus">Ulkus</label>
                            </div>
                            <div class="icheck-primary d-inline mr-3">
                                <input type="checkbox" id="lidah_ada" name="lidah_warna[]" value="Ada"
                                    {{ in_array('Ada', $sistemGastroIntestinal['lidah_warna'] ?? []) ? 'checked' : '' }}>
                                <label for="lidah_ada">Ada</label>
                            </div>
                            <div class="icheck-primary d-inline mr-3">
                                <input type="checkbox" id="lidah_tidak" name="lidah_warna[]" value="Tidak"
                                    {{ in_array('Tidak', $sistemGastroIntestinal['lidah_warna'] ?? []) ? 'checked' : '' }}>
                                <label for="lidah_tidak">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li>Reflek Menelan:
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="reflek_menelan_dapat" name="reflek_menelan[]" value="Dapat"
                            {{ in_array('Dapat', $sistemGastroIntestinal['reflek_menelan'] ?? []) ? 'checked' : '' }}>
                        <label for="reflek_menelan_dapat">Dapat</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="reflek_menelan_tidak" name="reflek_menelan[]" value="Tidak"
                            {{ in_array('Tidak', $sistemGastroIntestinal['reflek_menelan'] ?? []) ? 'checked' : '' }}>
                        <label for="reflek_menelan_tidak">Tidak</label>
                    </div>
                </div>
            </li>
            <li>Reflek Mengunyah:
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="reflek_mengunyah_dapat" name="reflek_mengunyah[]"
                            value="Dapat"
                            {{ in_array('Dapat', $sistemGastroIntestinal['reflek_mengunyah'] ?? []) ? 'checked' : '' }}>
                        <label for="reflek_mengunyah_dapat">Dapat</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="reflek_mengunyah_tidak" name="reflek_mengunyah[]"
                            value="Tidak"
                            {{ in_array('Tidak', $sistemGastroIntestinal['reflek_mengunyah'] ?? []) ? 'checked' : '' }}>
                        <label for="reflek_mengunyah_tidak">Tidak</label>
                    </div>
                </div>
            </li>
            <li>Alat Bantu:
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="alat_bantu_tidak" name="alat_bantu[]" value="Tidak"
                            {{ in_array('Tidak', $sistemGastroIntestinal['alat_bantu'] ?? []) ? 'checked' : '' }}>
                        <label for="alat_bantu_tidak">Tidak</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="alat_bantu_ya" name="reflek_mengunyah[]" value="Ya"
                            {{ in_array('Ya', $sistemGastroIntestinal['reflek_mengunyah'] ?? []) ? 'checked' : '' }}>
                        <label for="alat_bantu_ya">Ya (NGT/OGT)*</label>
                    </div>
                </div>
            </li>
            <li>
                <div class="row">
                    <div class="col-6">
                        <div class="input-group">
                            Abdomen : bising usu :
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="bising_usu"
                                    value="{{ is_array($sistemGastroIntestinal['bising_usu'] ?? null) ? implode(', ', $sistemGastroIntestinal['bising_usu']) : $sistemGastroIntestinal['bising_usu'] ?? '' }}">
                                <div class="input-group-append">
                                    <span class="input-group-text">X/Menit</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mt-4">
                        <div class="form-group clearfix">
                            Bentuk :
                            <div class="icheck-primary d-inline mr-3">
                                <input type="checkbox" id="bentuk_abdomen_kembung" name="bentuk_abdomen[]" value="Kembung"
                                    {{ in_array('Kembung', $sistemGastroIntestinal['bentuk_abdomen'] ?? []) ? 'checked' : '' }}>
                                <label for="bentuk_abdomen_kembung">Kembung</label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="bentuk_abdomen_datar" name="bentuk_abdomen[]" value="Datar"
                                    {{ in_array('Datar', $sistemGastroIntestinal['bentuk_abdomen'] ?? []) ? 'checked' : '' }}>
                                <label for="bentuk_abdomen_datar">Datar</label>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li>Stomata:
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="stomata_ya" name="stomata[]" value="Ya"
                            {{ in_array('Ya', $sistemGastroIntestinal['stomata'] ?? []) ? 'checked' : '' }}>
                        <label for="stomata_ya">Ya</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="stomata_tidak" name="stomata[]" value="Tidak"
                            {{ in_array('Tidak', $sistemGastroIntestinal['stomata'] ?? []) ? 'checked' : '' }}>
                        <label for="stomata_tidak">Tidak (lanjutkan ke pengkajian stomata)</label>
                    </div>
                </div>
            </li>
            <li>Drain:
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="drain_tidak" name="drain[]" value="Tidak"
                            {{ in_array('Tidak', $sistemGastroIntestinal['drain'] ?? []) ? 'checked' : '' }}>
                        <label for="drain_tidak">Tidak</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="drain_ya" name="drain[]" value="Ya"
                            {{ in_array('Ya', $sistemGastroIntestinal['drain'] ?? []) ? 'checked' : '' }}>
                        <label for="drain_ya">Ya (silicon/T-Tube/penrose)*</label>
                    </div>
                </div>
            </li>
        </ol>

    </div>
</div>