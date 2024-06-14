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

<div class="modal fade" id="modalCekKunjunganPoli" style="display: none;" aria-hidden="true"
    data-backdrop="static">
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

<div class="modal fade" id="modalCekKunjungan" style="display: none;" aria-hidden="true"
    data-backdrop="static">
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
                        <table id="table1" class="semuaKunjungan  table table-bordered">
                            <thead>
                                <tr>
                                    <th>KUNJUNGAN</th>
                                    <th>NO RM</th>
                                    <th>PASIEN</th>
                                    <th>POLI</th>
                                    <th>STATUS</th>
                                    <th>TGL MASUK</th>
                                    <th>TGL PULANG</th>
                                    <th>PPRI</th>
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
</div>

<div class="modal fade" id="modal-cetak-label" style="display: none;" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">CETAK LABEL</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
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