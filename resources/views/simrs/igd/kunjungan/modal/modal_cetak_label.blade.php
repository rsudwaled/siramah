<div class="modal fade" id="modal-cetak-label" style="display: none;" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">CETAK LABEL</h4>
            </div>
            <form id="formCetakLabel" action="{{ route('cetak-label-igd') }}" method="get" target="_blank">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputBorderWidth2">RM Pasien</label>
                        <input type="text" name="label_no_rm" class="form-control" id="label_no_rm">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" form="formCetakLabel"
                        class="btn btn-primary btn-cetak-label-igd">Cetak</button>
                </div>
            </form>
        </div>
    </div>
</div>
