<div class="modal fade" id="modal-berkas" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">RIWAYAT BERKAS</h4>
            </div>
            <div class="modal-body" id="modal-body-berkas">
                <div class="card direct-chat direct-chat-primary">
                    <div class="card-body">
                        <div class="direct-chat-messages">
                            <div class="col-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Tanggal Masuk</th>
                                            <th>Kode Kunjungan</th>
                                            <th>Pasien</th>
                                            <th>Unit</th>
                                            <th>Pemeriksaan</th>
                                            <th>Berkas</th>
                                        </tr>
                                    </thead>
                                    <tbody id="patologi-file-table-body">
                                        <!-- Data patologi akan dimuat melalui AJAX -->
                                    </tbody>
                                    <tbody id="patologi-fileupload-table-body">
                                        <!-- Data patologi akan dimuat melalui AJAX -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer float-right">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
