<div class="modal fade" id="modalCekBpjs" style="display: none;" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">CEK STATUS BPJS</h5>
            </div>
            <form id="cekbpjs-status-tanpa-daftar" method="get">
                @csrf
                <div class="modal-body">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputBorderWidth2">Nomor Kartu</label>
                            <input type="text" name="cek_nomorkartu" class="form-control" id="cek_nomorkartu">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputBorderWidth2">Nomor NIK</label>
                            <input type="text" name="cek_nik" class="form-control" id="cek_nik">
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary btn-cek-bpjs-tanpa-daftar"
                        form="cekbpjs-status-tanpa-daftar">Cek Status</button>
                </div>
            </form>
        </div>
    </div>
</div>
