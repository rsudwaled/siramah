<div class="modal fade" id="modalCekKunjunganPoli" style="display: none;" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cek Kunjungan Pasien</h4>
            </div>
            <form>
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="exampleInputBorderWidth2">No RM PASIEN</label>
                            <input type="text" name="no_rm" id="no_rm" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btnCreateSPRIBatal"
                        data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary btn-cekKunjungan" id="btn-cekKunjungan">CARI
                        KUNJUNGAN</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCekKunjungan" style="display: none;" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">RIWAYAT KUNJUNGAN</h4>
                <button type="button" class="btn btn-sm btn-default close" onclick="batalPilih()"
                    data-dismiss="modal"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div id="tableContainer" style="max-height: 400px; overflow-y: auto;">
                    <!-- Table will be inserted here by JavaScript -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" onclick="batalPilih()">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
