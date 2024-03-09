  {{-- MODAL --}}
  <x-adminlte-modal id="modalCekKunjungan" title="RIWAYAT KUNJUNGAN PASIEN" theme="success" size='xl'>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-5 col-sm-3">
                    <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist"
                        aria-orientation="vertical">
                        <a class="nav-link active btn btn-block btn-success btn-flat" id="rawat-jalan-tab"
                            data-toggle="pill" href="#rawat-jalan" role="tab" aria-controls="rawat-jalan"
                            aria-selected="false">Rawat Jalan</a>
                        <a class="nav-link  btn btn-block btn-primary btn-flat" id="rawat-inap-tab"
                            data-toggle="pill" href="#rawat-inap" role="tab" aria-controls="rawat-inap"
                            aria-selected="true">Rawat Inap</a>
                        <a class="nav-link  btn btn-block bg-purple btn-flat" id="kebidanan-tab"
                            data-toggle="pill" href="#kebidanan" role="tab" aria-controls="kebidanan"
                            aria-selected="true">Kunjungan Unit Kebidanan</a>
                    </div>
                </div>
                <div class="col-7 col-sm-9">
                    <div class="tab-content" id="vert-tabs-tabContent">
                        <div class="tab-pane fade active show" id="rawat-jalan" role="tabpanel"
                            aria-labelledby="rawat-jalan-tab">
                            <div class="info-box mb-3 bg-success ">
                                <span class="info-box-icon"><i class="fas fa-user-injured"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">RAWAT JALAN</span>
                                    <span class="info-box-number">Riwayat Pasien Rawat Jalan</span>
                                </div>

                            </div>

                            <table id="table1" class="riwayatKunjungan data-table table table-bordered">
                                <thead>
                                    <tr>
                                        <th>KUNJUNGAN</th>
                                        <th>NO RM</th>
                                        <th>PASIEN</th>
                                        <th>POLI</th>
                                        <th>STATUS</th>
                                        <th>TGL MASUK</th>
                                        <th>TGL PULANG</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane text-left " id="rawat-inap" role="tabpanel"
                            aria-labelledby="rawat-inap-tab">
                            <div class="info-box mb-3 bg-primary">
                                <span class="info-box-icon"><i class="fas fa-procedures"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">RAWAT INAP</span>
                                    <span class="info-box-number">Riwayat Pasien Rawat Inap</span>
                                </div>
                            </div>
                            <table id="table2" class="riwayatRanap data-table table table-bordered">
                                <thead>
                                    <tr>
                                        <th>KUNJUNGAN</th>
                                        <th>NO RM</th>
                                        <th>PASIEN</th>
                                        <th>POLI</th>
                                        <th>STATUS</th>
                                        <th>TGL MASUK</th>
                                        <th>TGL PULANG</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="tab-pane text-left " id="kebidanan" role="tabpanel"
                            aria-labelledby="kebidanan-tab">
                            <div class="info-box mb-3 bg-purple">
                                <span class="info-box-icon"><i class="fas fa-female"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">UGD KEBIDANAN</span>
                                    <span class="info-box-number">Riwayat Pasien UGD KEBIDANAN</span>
                                </div>
                            </div>
                            <table id="table3" class="UGDKebidanan data-table table table-bordered">
                                <thead>
                                    <tr>
                                        <th>KUNJUNGAN</th>
                                        <th>NO RM</th>
                                        <th>PASIEN</th>
                                        <th>POLI</th>
                                        <th>STATUS</th>
                                        <th>TGL MASUK</th>
                                        <th>TGL PULANG</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-slot name="footerSlot">
            <x-adminlte-button theme="danger" label="tutup" onclick="batalPilih()" data-dismiss="modal" />
        </x-slot>
    </div>
</x-adminlte-modal>