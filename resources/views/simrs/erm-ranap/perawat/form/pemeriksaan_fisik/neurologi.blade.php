<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Sistem Neurologi</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <ol type="a" style="font-size: 13px;">
            <li>
                Kesulitan Bicara :
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="kesulitan_bicara_tidak" name="kesulitan_bicara[]" value="Tidak"
                            {{ in_array('Tidak', $sistemNeurologi['kesulitan_bicara'] ?? []) ? 'checked' : '' }}>
                        <label for="kesulitan_bicara_tidak">Tidak</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="kesulitan_bicara_ada" name="kesulitan_bicara[]" value="Ada"
                            {{ in_array('Ada', $sistemNeurologi['kesulitan_bicara'] ?? []) ? 'checked' : '' }}>
                        <label for="kesulitan_bicara_ada">Ada</label>
                    </div>
                </div>
            </li>
            <li>
                Kelemahan alat gerak :
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="kelemahan_alat_gerak_tidak" name="kelemahan_alat_gerak[]" value="Tidak"
                            {{ in_array('Tidak', $sistemNeurologi['kelemahan_alat_gerak'] ?? []) ? 'checked' : '' }}>
                        <label for="kelemahan_alat_gerak_tidak">Tidak</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="kelemahan_alat_gerak_ada" name="kelemahan_alat_gerak[]" value="Ada"
                            {{ in_array('Ada', $sistemNeurologi['kelemahan_alat_gerak'] ?? []) ? 'checked' : '' }}>
                        <label for="kelemahan_alat_gerak_ada">Ada</label>
                    </div>
                </div>
            </li>
            <li>
                Terpasang EVD :
                <div class="form-group clearfix">
                    <div class="icheck-primary d-inline mr-3">
                        <input type="checkbox" id="evd_tidak" name="evd[]" value="Tidak"
                            {{ in_array('Tidak', $sistemNeurologi['evd'] ?? []) ? 'checked' : '' }}>
                        <label for="evd_tidak">Tidak</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="evd_ya" name="evd[]" value="Ya"
                            {{ in_array('Ya', $sistemNeurologi['evd'] ?? []) ? 'checked' : '' }}>
                        <label for="evd_ya">Ya</label>
                    </div>
                </div>
            </li>
        </ol>

    </div>
</div>