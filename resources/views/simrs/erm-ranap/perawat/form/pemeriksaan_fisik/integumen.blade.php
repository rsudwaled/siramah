<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Sistem Integumen</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <ol type="a" style="font-size: 13px;">
            <li>
                Luka :
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="integumen_luka_tidak" name="integumen_luka[]" value="Tidak"
                            {{ in_array('Tidak', $sistemIntegumen['integumen_luka'] ?? []) ? 'checked' : '' }}>
                        <label for="integumen_luka_tidak">Tidak</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="integumen_luka_ya" name="integumen_luka[]" value="Ya"
                            {{ in_array('Ya', $sistemIntegumen['integumen_luka'] ?? []) ? 'checked' : '' }}>
                        <label for="integumen_luka_ya">Ya (lanjut ke pengkajian & perkembangan luka)</label>
                    </div>
                </div>
            </li>
            <li>
                Benjolan :
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="integumen_benjolan_tidak" name="integumen_benjolan[]" value="Tidak"
                            {{ in_array('Tidak', $sistemIntegumen['integumen_benjolan'] ?? []) ? 'checked' : '' }}>
                        <label for="integumen_benjolan_tidak">Tidak</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="integumen_benjolan_ya" name="integumen_benjolan[]" value="Ya"
                            {{ in_array('Ya', $sistemIntegumen['integumen_benjolan'] ?? []) ? 'checked' : '' }}>
                        <label for="integumen_benjolan_ya">Ya (gunakan gambar untuk menunjukkan lokasi benjolan)</label>
                    </div>
                </div>
            </li>
            <li>
                Suhu :
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="integumen_suhu_hangat" name="integumen_suhu[]" value="Hangat"
                            {{ in_array('Hangat', $sistemIntegumen['integumen_suhu'] ?? []) ? 'checked' : '' }}>
                        <label for="integumen_suhu_hangat">Hangat</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="integumen_suhu_dingin" name="integumen_suhu[]" value="Dingin"
                            {{ in_array('Dingin', $sistemIntegumen['integumen_suhu'] ?? []) ? 'checked' : '' }}>
                        <label for="integumen_suhu_dingin">Dingin</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="integumen_suhu_panas" name="integumen_suhu[]" value="Panas"
                            {{ in_array('Panas', $sistemIntegumen['integumen_suhu'] ?? []) ? 'checked' : '' }}>
                        <label for="integumen_suhu_panas">Panas</label>
                    </div>
                </div>
            </li>
        </ol>

    </div>
</div>