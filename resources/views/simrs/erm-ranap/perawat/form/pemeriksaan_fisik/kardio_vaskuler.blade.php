<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Sistem Kardiovaskuler</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <ol type="a" style="font-size: 13px;">
            <li> Nadi :
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="nadi"
                        value="{{ is_array($sistemKardioVaskuler['nadi'] ?? null) ? implode(', ', $sistemKardioVaskuler['nadi']) : $sistemKardioVaskuler['nadi'] ?? '' }}">
                    <div class="input-group-append">
                        <span class="input-group-text">x/menit (Requler/Irreguler)</span>
                    </div>
                </div>
            </li>
            <li>Konjungtiva:
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline  mr-3">
                        <input type="checkbox" id="konjungtiva_pucat" name="konjungtiva[]" value="Pucat"
                            {{ in_array('Pucat', $sistemKardioVaskuler['konjungtiva'] ?? []) ? 'checked' : '' }}>
                        <label for="konjungtiva_pucat">Pucat</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="konjungtiva_mm" name="konjungtiva[]" value="Merah_Muda"
                            {{ in_array('Merah_Muda', $sistemKardioVaskuler['konjungtiva'] ?? []) ? 'checked' : '' }}>
                        <label for="konjungtiva_mm">Merah Muda</label>
                    </div>
                </div>
            </li>
            <li>Riwayat Pemasangan Alat:
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="pasang_alat_ada" name="pasang_alat[]" value="Ada"
                            {{ in_array('Ada', $sistemKardioVaskuler['pasang_alat'] ?? []) ? 'checked' : '' }}>
                        <label for="pasang_alat_ada">Ada</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="pasang_alat_tidak" name="pasang_alat[]" value="Tidak"
                            {{ in_array('Tidak', $sistemKardioVaskuler['pasang_alat'] ?? []) ? 'checked' : '' }}>
                        <label for="pasang_alat_tidak">Tidak</label>
                    </div>
                </div>
            </li>
            <li>Kulit:
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="kulit_pucat" name="kulit[]" value="Pucat"
                            {{ in_array('Pucat', $sistemKardioVaskuler['kulit'] ?? []) ? 'checked' : '' }}>
                        <label for="kulit_pucat">Pucat</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="kulit_cyanosis" name="kulit[]" value="Cyanosis"
                            {{ in_array('Cyanosis', $sistemKardioVaskuler['kulit'] ?? []) ? 'checked' : '' }}>
                        <label for="kulit_cyanosis">Cyanosis</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="kulit_hipermis" name="kulit[]" value="Hipermis"
                            {{ in_array('Hipermis', $sistemKardioVaskuler['kulit'] ?? []) ? 'checked' : '' }}>
                        <label for="kulit_hipermis">Hipermis</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="kulit_ekimosis" name="kulit[]" value="Ekimosis"
                            {{ in_array('Ekimosis', $sistemKardioVaskuler['kulit'] ?? []) ? 'checked' : '' }}>
                        <label for="kulit_ekimosis">Ekimosis</label>
                    </div>
                </div>
            </li>
            <li>Temperatur:
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="temperatur_hangat" name="temperatur[]" value="Hangat"
                            {{ in_array('Hangat', $sistemKardioVaskuler['temperatur'] ?? []) ? 'checked' : '' }}>
                        <label for="temperatur_hangat">Hangat</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="temperatur_dingin" name="temperatur[]" value="Dingin"
                            {{ in_array('Dingin', $sistemKardioVaskuler['temperatur'] ?? []) ? 'checked' : '' }}>
                        <label for="temperatur_dingin">Cyanosis</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="temperatur_diaphoresis" name="temperatur[]"
                            value="Dhiaporesis"
                            {{ in_array('Dhiaporesis', $sistemKardioVaskuler['temperatur'] ?? []) ? 'checked' : '' }}>
                        <label for="temperatur_diaphoresis">Dhiaporesis</label>
                    </div>
                </div>
            </li>
            
            <li>Bunyi Jantung:
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="bunyi_jantung_normal" name="bunyi_jantung[]" value="Normal"
                            {{ in_array('Normal', $sistemKardioVaskuler['bunyi_jantung'] ?? []) ? 'checked' : '' }}>
                        <label for="bunyi_jantung_normal">Normal</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="bunyi_jantung_abnormal" name="bunyi_jantung[]"
                            value="Abnormal"
                            {{ in_array('Abnormal', $sistemKardioVaskuler['bunyi_jantung'] ?? []) ? 'checked' : '' }}>
                        <label for="bunyi_jantung_abnormal">Abnormal</label>
                    </div>
                </div>
            </li>
            <li>Ekstremis :
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">CRT</span>
                    </div>
                    <input type="text" class="form-control" name="ekstremis"
                        value="{{ is_array($sistemKardioVaskuler['ekstremis'] ?? null) ? implode(', ', $sistemKardioVaskuler['ekstremis']) : $sistemKardioVaskuler['ekstremis'] ?? '' }}">
                    <div class="input-group-append">
                        <div class="input-group-text">Detik</div>
                    </div>
                </div>
            </li>
            <li>Terpasang Nichiban / TR Band:
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="nichiban_tidak" name="nichiban[]" value="Tidak"
                            {{ in_array('Tidak', $sistemKardioVaskuler['nichiban'] ?? []) ? 'checked' : '' }}>
                        <label for="nichiban_tidak">Tidak</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="nichiban_ya" name="nichiban[]" value="Ya"
                            {{ in_array('Ya', $sistemKardioVaskuler['nichiban'] ?? []) ? 'checked' : '' }}>
                        <label for="nichiban_ya">Ya</label>
                    </div>
                </div>
            </li>
            <li>Edema:
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="edema_tidak" name="edema[]" value="Tidak"
                            {{ in_array('Tidak', $sistemKardioVaskuler['edema'] ?? []) ? 'checked' : '' }}>
                        <label for="edema_tidak">Tidak</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="edema_ada" name="nichiban[]" value="Ada"
                            {{ in_array('Ada', $sistemKardioVaskuler['nichiban'] ?? []) ? 'checked' : '' }}>
                        <label for="edema_ada">Ada</label>
                    </div>
                </div>
            </li>
        </ol>

    </div>
</div>