<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Spiritual dan nilai-nilai kepercayaan</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <ol type="a" style="font-size: 13px;">
            <li>
                Agama :
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="spiritual_agama_islam" name="spiritual_agama[]" value="islam"
                            {{ in_array('islam', $spiritualKepercayaan['agama'] ?? []) ? 'checked' : '' }}>
                        <label for="spiritual_agama_islam">Islam</label>
                    </div>
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="spiritual_agama_kristen" name="spiritual_agama[]" value="kristen"
                            {{ in_array('kristen', $spiritualKepercayaan['agama'] ?? []) ? 'checked' : '' }}>
                        <label for="spiritual_agama_kristen">Kristen</label>
                    </div>
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="spiritual_agama_hindu" name="spiritual_agama[]" value="hindu"
                            {{ in_array('hindu', $spiritualKepercayaan['agama'] ?? []) ? 'checked' : '' }}>
                        <label for="spiritual_agama_hindu">Hindu</label>
                    </div>
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="spiritual_agama_budha" name="spiritual_agama[]" value="budha"
                            {{ in_array('budha', $spiritualKepercayaan['agama'] ?? []) ? 'checked' : '' }}>
                        <label for="spiritual_agama_budha">Budha</label>
                    </div>
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="spiritual_agama_katolik" name="spiritual_agama[]" value="katolik"
                            {{ in_array('katolik', $spiritualKepercayaan['agama'] ?? []) ? 'checked' : '' }}>
                        <label for="spiritual_agama_katolik">Katolik</label>
                    </div>
                </div>
            </li>
            <li>
                Mengungkapkan keprihatinan yang berhubungan dengan rawat inap :
                <div class="form-group clearfix row">
                    <div class="col-2">
                        <div class="icheck-primary d-inline mr-3">
                            <input type="checkbox" id="keprihatinan_tidak" name="keprihatinan_jawaban" value="Tidak"
                                {{ ($spiritualKepercayaan['keprihatinan']['jawaban'] ?? '') == 'Tidak' ? 'checked' : '' }}>
                            <label for="keprihatinan_tidak">Tidak</label>
                        </div>
                    </div>
                    <div class="col-10">
                        <div class="row">
                            <div class="col-2">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="keprihatinan_Ya" name="keprihatinan_jawaban"
                                        {{ ($spiritualKepercayaan['keprihatinan']['jawaban'] ?? '') == 'Ya' ? 'checked' : '' }}
                                        value="Ya">
                                    <label for="keprihatinan_Ya">Ya :</label>
                                </div>
                            </div>
                            <div class="col-10">
                                <div class="form-group clearfix">
                                    <div class="row">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="keprihatinan_detail_1" name="keprihatinan_ya_detail[]"
                                                value="ketidak_mampuan_praktek_spiritual"
                                                {{ in_array('ketidak_mampuan_praktek_spiritual', $spiritualKepercayaan['keprihatinan']['detail'] ?? []) ? 'checked' : '' }}>
                                            <label for="keprihatinan_detail_1">Ketidak mampuan untuk mempertahankan praktek spiritual.</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="keprihatinan_detail_2" name="keprihatinan_ya_detail[]"
                                                value="perasaan_negatif_kepercayaan"
                                                {{ in_array('perasaan_negatif_kepercayaan', $spiritualKepercayaan['keprihatinan']['detail'] ?? []) ? 'checked' : '' }}>
                                            <label for="keprihatinan_detail_2">Perasaan negatif tentang sistem kepercayaan.</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="keprihatinan_detail_3" name="keprihatinan_ya_detail[]"
                                                value="konflik_spiritual_dengan_kesehatan"
                                                {{ in_array('konflik_spiritual_dengan_kesehatan', $spiritualKepercayaan['keprihatinan']['detail'] ?? []) ? 'checked' : '' }}>
                                            <label for="keprihatinan_detail_3">Konflik antara kepercayaan spiritual dengan sistem kesehatan.</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="keprihatinan_detail_4" name="keprihatinan_ya_detail[]"
                                                value="bimbingan_rohani"
                                                {{ in_array('bimbingan_rohani', $spiritualKepercayaan['keprihatinan']['detail'] ?? []) ? 'checked' : '' }}>
                                            <label for="keprihatinan_detail_4">Bimbingan rohani.</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="keprihatinan_detail_5" name="keprihatinan_ya_detail[]"
                                                value="lain_lain"
                                                {{ in_array('lain_lain', $spiritualKepercayaan['keprihatinan']['detail'] ?? []) ? 'checked' : '' }}>
                                            <label for="keprihatinan_detail_5">Lain-lain.</label>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
            </li>
            <li>
                Nilai-Nilai Kepercayaan :
                <input type="text" name="nilai_kepercayaan" class="form-control" value="{{ is_array($spiritualKepercayaan['nilai_kepercayaan'] ?? null) ? implode(', ', $spiritualKepercayaan['nilai_kepercayaan']) : $spiritualKepercayaan['nilai_kepercayaan'] ?? '' }}">
            </li>
        </ol>
    </div>
</div>
