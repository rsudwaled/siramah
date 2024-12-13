<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Hygiene</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <ol type="a" style="font-size: 13px;">
            <li>
                Aktivitas sehari-hari :
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="aktivitas_hygiene_mandiri" name="aktivitas_hygiene[]" value="Mandiri"
                            {{ in_array('Mandiri', $sistemHygiene['aktivitas_hygiene'] ?? []) ? 'checked' : '' }}>
                        <label for="aktivitas_hygiene_mandiri">Mandiri</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="aktivitas_hygiene_dibantu" name="aktivitas_hygiene[]" value="dibantu"
                            {{ in_array('dibantu', $sistemHygiene['aktivitas_hygiene'] ?? []) ? 'checked' : '' }}>
                        <label for="aktivitas_hygiene_dibantu">dibantu</label>
                    </div>
                </div>
            </li>
            <li>
                Penampilan :
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="penampilan_hygiene_bersih" name="penampilan_hygiene[]" value="Bersih"
                            {{ in_array('Bersih', $sistemHygiene['penampilan_hygiene'] ?? []) ? 'checked' : '' }}>
                        <label for="penampilan_hygiene_bersih">Bersih</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="penampilan_hygiene_kotor" name="penampilan_hygiene[]" value="Kotor"
                            {{ in_array('Kotor', $sistemHygiene['penampilan_hygiene'] ?? []) ? 'checked' : '' }}>
                        <label for="penampilan_hygiene_kotor">Kotor</label>
                    </div>
                </div>
            </li>
        </ol>

    </div>
</div>