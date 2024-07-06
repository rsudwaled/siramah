<div class="modal fade" id="modal-sep-backdate" style="display: none;" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">PENGAJUAN BACKDATE</h4>
            </div>
            <div class="modal-body">
                <form id="pengajuanBackDate" action="" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputBorderWidth2">Kode Kunjungan</label>
                        <input type="text" name="bd_kunjungan" class="form-control" id="bd_kunjungan">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputBorderWidth2">Nomor Kartu</label>
                        <input type="text" name="bd_noKartu" class="form-control" id="bd_noKartu">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputBorderWidth2">Tanggal SEP</label>
                        <input type="date" name="tglSep" class="form-control" id="tglSep">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputBorderWidth2">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" id="keterangan">
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" form="pengajuanBackDate" class="btn btn-primary btn-pengajuan-backdate">Simpan
                    Pengajuan</button>
            </div>
        </div>
    </div>
</div>
