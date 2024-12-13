<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Sistem Urogenital</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <ol type="a" style="font-size: 13px;">
            <li>
                Perubahan pada pola bak :
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="pola_bak_tidak" name="pola_bak[]" value="Tidak"
                            {{ in_array('Tidak', $sistemUrogenital['pola_bak'] ?? []) ? 'checked' : '' }}>
                        <label for="pola_bak_tidak">Tidak</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="pola_bak_ya" name="pola_bak[]" value="Ya"
                            {{ in_array('Ya', $sistemUrogenital['pola_bak'] ?? []) ? 'checked' : '' }}>
                        <label for="pola_bak_ya">Ya (tidak lampias, sensasi terbakar saat miksi, penurunan pencaran urine)*</label>
                    </div>
                </div>
            </li>
            <li>
                <div class="row">
                    <div class="col-4">
                        Frekuensi BAK :
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="frekuensi_bak"
                                value="{{ is_array($sistemUrogenital['frekuensi_bak'] ?? null) ? implode(', ', $sistemUrogenital['frekuensi_bak']) : $sistemUrogenital['frekuensi_bak'] ?? '' }}">
                            <div class="input-group-append">
                                <span class="input-group-text">X/Hari</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-8">
                        Warna Urina: 
                        <input type="text" class="form-control" name="warna_urina"
                            value="{{ is_array($sistemUrogenital['warna_urina'] ?? null) ? implode(', ', $sistemUrogenital['warna_urina']) : $sistemUrogenital['warna_urina'] ?? '' }}">
                    </div>
                </div>
            </li>
            <li>
                Alat Bantu :
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="uro_alat_bantu_tidak" name="uro_alat_bantu[]" value="Tidak"
                            {{ in_array('Tidak', $sistemUrogenital['uro_alat_bantu'] ?? []) ? 'checked' : '' }}>
                        <label for="uro_alat_bantu_tidak">Tidak</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="uro_alat_bantu_ya" name="uro_alat_bantu[]" value="Ya"
                            {{ in_array('Ya', $sistemUrogenital['uro_alat_bantu'] ?? []) ? 'checked' : '' }}>
                        <label for="uro_alat_bantu_ya">Ya (dower kateter/kondom kateter)</label>
                    </div>
                </div>
            </li>
            <li>
                Stomata :
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="uro_stomata_tidak" name="uro_stomata[]" value="Tidak"
                            {{ in_array('Tidak', $sistemUrogenital['uro_stomata'] ?? []) ? 'checked' : '' }}>
                        <label for="uro_stomata_tidak">Tidak</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="uro_stomata_ya" name="uro_stomata[]" value="Ya"
                            {{ in_array('Ya', $sistemUrogenital['uro_stomata'] ?? []) ? 'checked' : '' }}>
                        <label for="uro_stomata_ya">Ya (urustomy/nefrostomy/cystotomy)* lanjutkan ke pengkajian stomata</label>
                    </div>
                </div>
            </li>
        </ol>

    </div>
</div>