<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Sistem Muskulo Skeletal</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <ol type="a" style="font-size: 13px;">
            <li>
                Faktur :
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="fraktur_tidak" name="fraktur[]" value="Tidak"
                            {{ in_array('Tidak', $sistemMuskuloSkeletal['fraktur'] ?? []) ? 'checked' : '' }}>
                        <label for="fraktur_tidak">Tidak</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="fraktur_ada" name="fraktur[]" value="Ada"
                            {{ in_array('Ada', $sistemMuskuloSkeletal['fraktur'] ?? []) ? 'checked' : '' }}>
                        <label for="fraktur_ada">Ada (lanjut ke char muskulosketal)*</label>
                    </div>
                </div>
            </li>
            <li>
                Mobilitas :
                <div class="form-group clearfix">
                    <div class="row">
                        <div class="col-3">
                            <div class="icheck-primary d-inline mr-3">
                                <input type="checkbox" id="mobilitas_mandiri" name="mobilitas[]" value="Mandiri"
                                    {{ in_array('Mandiri', $sistemMuskuloSkeletal['mobilitas'] ?? []) ? 'checked' : '' }}>
                                <label for="mobilitas_mandiri">Mandiri</label>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="row">
                                <div class="col-4">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="mobilitas_dibantu" name="mobilitas[]"
                                            value="Dibantu"
                                            {{ in_array('Dibantu', $sistemMuskuloSkeletal['mobilitas'] ?? []) ? 'checked' : '' }}>
                                        <label for="mobilitas_dibantu">Dibantu, alat bantu..</label>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="mobilitas_alat_bantu" class="form-control"
                                        value="{{ is_array($sistemMuskuloSkeletal['mobilitas_alat_bantu'] ?? null) ? implode(', ', $sistemMuskuloSkeletal['mobilitas_alat_bantu']) : $sistemMuskuloSkeletal['mobilitas_alat_bantu'] ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ol>

    </div>
</div>