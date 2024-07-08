<div class="modal fade" id="modal-insert-sep" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">INSERT SEP VCLAIM</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="insertSep" action="{{ route('insert-sep.kunjungan') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode Kunjungan</label>
                        <input type="text" name="kode_insert_sep" class="form-control" id="kode_insert_sep"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label>PILIH DIAGNOSA ICD 10</label>
                        <select name="diagnosa_sepinsert" id="diagICD10" class="select2 form-control" required></select>
                    </div>
                    <div class="form-group">
                        <label>NO SEP</label>
                        <input type="text" name="insert_no_sep" class="form-control" id="insert_no_sep" required>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" form="insertSep" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>