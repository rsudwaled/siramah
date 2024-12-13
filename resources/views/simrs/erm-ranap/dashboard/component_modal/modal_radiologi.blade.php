<div class="modal fade" id="modal-radiologi" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">RIWAYAT RADIOLOGI</h4>
            </div>
            <div class="modal-body" id="modal-body-radiologi">
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
                                    <tbody id="radiologi-table-body">
                                        <!-- Data radiologi akan dimuat melalui AJAX -->
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
