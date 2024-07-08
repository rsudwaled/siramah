<div class="modal fade" id="modalEditPenjamin" style="display: none;" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">FORM EDIT PENJAMIN</h4>
            </div>
            <div class="modal-body">
                <form id="form_ep" action="" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label >Kode Kunjungan</label>
                                <input type="text" name="ep_kunjungan" class="form-control" id="ep_kunjungan">
                            </div>
                            <div class="form-group">
                                <label >Tgl Masuk</label>
                                <input type="date" name="ep_tglMasuk" class="form-control" id="ep_tglMasuk">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label >No RM</label>
                                <input type="text" name="ep_rm" class="form-control" id="ep_rm">
                            </div>
                            <div class="form-group">
                                <label >Nama Pasien</label>
                                <input type="text" name="ep_nama" class="form-control" id="ep_nama">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" form="form_ep" class="btn btn-primary btn-kunjungan-ep">Cari Kunjungan</button>
            </div>
        </div>
    </div>
</div>

{{-- <div class="modal fade" id="epKunjungan" style="display: none;" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">RIWAYAT KUNJUNGAN</h4>
                <button type="button" class="btn btn-sm btn-default close" onclick="batalPilih()"
                    data-dismiss="modal"><span aria-hidden="true">×</span></button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="row">
                        <table id="table1" class="epKunjungan  table table-bordered">
                            <thead>
                                <tr>
                                    <th>KUNJUNGAN</th>
                                    <th>NO RM</th>
                                    <th>PASIEN</th>
                                    <th>POLI</th>
                                    <th>STATUS</th>
                                    <th>TGL MASUK</th>
                                    <th>TGL PULANG</th>
                                    <th>PENJAMIN</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" onclick="batalPilih()">Tutup</button>
                    </div>
            </form>
        </div>
    </div>
</div> --}}