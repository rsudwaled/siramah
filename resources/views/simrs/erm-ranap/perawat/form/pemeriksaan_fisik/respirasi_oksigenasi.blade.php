<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Respirasi & Oksigenasi</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <ol type="a" style="font-size: 13px;">
            <li>Obstruksi saluran napas atas:
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline  mr-3">
                        <input type="checkbox" id="obstruksi_ada" name="obstruksi[]" value="Ada"
                            {{ in_array('Ada', $sistemRespirasiOksigenasi['obstruksi'] ?? []) ? 'checked' : '' }}>
                        <label for="obstruksi_ada">Ada</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="obstruksi_tidak" name="obstruksi[]" value="Tidak"
                            {{ in_array('Tidak', $sistemRespirasiOksigenasi['obstruksi'] ?? []) ? 'checked' : '' }}>
                        <label for="obstruksi_tidak">Tidak</label>
                    </div>
                </div>
            </li>
            <li>Sesak Napas (dyspnea):
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="dyspnea_ada" name="dyspnea[]" value="Ada"
                            {{ in_array('Ada', $sistemRespirasiOksigenasi['dyspnea'] ?? []) ? 'checked' : '' }}>
                        <label for="dyspnea_ada">Ada</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="dyspnea_tidak" name="dyspnea[]" value="Tidak"
                            {{ in_array('Tidak', $sistemRespirasiOksigenasi['dyspnea'] ?? []) ? 'checked' : '' }}>
                        <label for="dyspnea_tidak">Tidak</label>
                    </div>
                </div>
            </li>
            <li>Pemakaian alat bantu napas: Binasal Canule/Simple Mask/Rebreathing Mask/Non Rebreathing Mask/
                Endotracheal Tube/Trachea Canule/Ventilator
                <input type="text" name="alat_bantu_napas" class="form-control col-3"
                    value="{{ is_array($sistemRespirasiOksigenasi['alat_bantu_napas'] ?? null) ? implode(', ', $sistemRespirasiOksigenasi['alat_bantu_napas']) : $sistemRespirasiOksigenasi['alat_bantu_napas'] ?? '' }}">
            </li>

            <li>
                <div class="row">
                    <div class="col-6">
                        Batuk:
                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline  mr-3">
                                <input type="checkbox" id="batuk_ada" name="batuk[]" value="Ada"
                                    {{ in_array('Ada', $sistemRespirasiOksigenasi['batuk'] ?? []) ? 'checked' : '' }}>
                                <label for="batuk_ada">Ada</label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="batuk_tidak" name="batuk[]" value="Tidak"
                                    {{ in_array('Tidak', $sistemRespirasiOksigenasi['batuk'] ?? []) ? 'checked' : '' }}>
                                <label for="batuk_tidak">Tidak</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        Sputum:
                        <div class="form-group clearfix">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icheck-primary d-inline  mr-3">
                                        <input type="checkbox" id="sputum_tidak" name="sputum[]" value="Tidak"
                                            {{ in_array('Tidak', $sistemRespirasiOksigenasi['sputum'] ?? []) ? 'checked' : '' }}>
                                        <label for="sputum_tidak">Tidak</label>
                                    </div>
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="sputum_ada" name="sputum[]" value="Ada"
                                            {{ in_array('Ada', $sistemRespirasiOksigenasi['sputum'] ?? []) ? 'checked' : '' }}>
                                        <label for="sputum_ada">Ada</label>
                                    </div>
                                </div>
                                <div class="col-7">
                                    <input type="text" name="warna_sputum" class="form-control"
                                        placeholder="masukan warna jika ada di ceklis"
                                        value="{{ is_array($sistemRespirasiOksigenasi['warna_sputum'] ?? null) ? implode(', ', $sistemRespirasiOksigenasi['warna_sputum']) : $sistemRespirasiOksigenasi['warna_sputum'] ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
            </li>
            <li>Bunyi Napas:
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline  mr-3">
                        <input type="checkbox" id="bunyi_napas_normal" name="bunyi_napas[]" value="Normal"
                            {{ in_array('Normal', $sistemRespirasiOksigenasi['bunyi_napas'] ?? []) ? 'checked' : '' }}>
                        <label for="bunyi_napas_normal">Normal</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="bunyi_napas_abnormal" name="bunyi_napas[]" value="Abnormal"
                            {{ in_array('Abnormal', $sistemRespirasiOksigenasi['bunyi_napas'] ?? []) ? 'checked' : '' }}>
                        <label for="bunyi_napas_abnormal">Abnormal</label>
                    </div>
                </div>
            </li>
            <li>
                <div class="row">
                    <div class="col-6">
                        Thorax:
                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline  mr-3">
                                <input type="checkbox" id="thorax_simetris" name="thorax[]" value="Simetris"
                                    {{ in_array('Simetris', $sistemRespirasiOksigenasi['thorax'] ?? []) ? 'checked' : '' }}>
                                <label for="thorax_simetris">Simetris</label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="thorax_tidak" name="thorax[]" value="Tidak"
                                    {{ in_array('Tidak', $sistemRespirasiOksigenasi['thorax'] ?? []) ? 'checked' : '' }}>
                                <label for="thorax_tidak">Tidak</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        Krepitasi:
                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline  mr-3">
                                <input type="checkbox" id="krepitasi_tidak" name="krepitasi[]" value="Tidak"
                                    {{ in_array('Tidak', $sistemRespirasiOksigenasi['krepitasi'] ?? []) ? 'checked' : '' }}>
                                <label for="krepitasi_tidak">Tidak</label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="krepitasi_ya" name="krepitasi[]" value="Ya"
                                    {{ in_array('Ya', $sistemRespirasiOksigenasi['krepitasi'] ?? []) ? 'checked' : '' }}>
                                <label for="krepitasi_ya">Ya</label>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li>CTT:
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="ctt_tidak" name="ctt[]" value="Tidak"
                            {{ in_array('Tidak', $sistemRespirasiOksigenasi['ctt'] ?? []) ? 'checked' : '' }}>
                        <label for="ctt_tidak">Tidak</label>
                    </div>
                    <div class="icheck-primary d-inline  mr-3">
                        <input type="checkbox" id="ctt_ya" name="ctt[]" value="Ya"
                            {{ in_array('Ya', $sistemRespirasiOksigenasi['ctt'] ?? []) ? 'checked' : '' }}>
                        <label for="ctt_ya">Ya</label>
                    </div>
                </div>
            </li>
        </ol>

    </div>
</div>