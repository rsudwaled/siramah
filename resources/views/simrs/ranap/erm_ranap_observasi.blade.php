<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#colObservasi">
        <h3 class="card-title">
            Observasi Pasien 24 Jam
        </h3>
    </a>
    <div id="colObservasi" class="collapse">
        <div class="card-body">
            <x-adminlte-button label="Input Observasi" icon="fas fa-plus" theme="success" class="btn-xs"
                onclick="btnInputObservasi()" />
            <x-adminlte-button icon="fas fa-sync" theme="primary" class="btn-xs"
                onclick="getObservasiRanap()" />
            <a href="{{ route('print_obaservasi_ranap') }}?kunjungan={{ $kunjungan->kode_kunjungan }}" target="_blank"
                class="btn btn-xs btn-warning"><i class="fas fa-print"></i> Print</a>
            <table class="table table-sm table-bordered table-hover" id="tableObservasi">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Tanggal Jam</th>
                        <th>Tensi</th>
                        <th>Nadi</th>
                        <th>RR</th>
                        <th>Suhu</th>
                        <th>GDS</th>
                        <th>ECG</th>
                        <th>Kesadaran</th>
                        <th>Pemeriksaan Fisik</th>
                        <th>Ket.</th>
                        <th>Ttd Pengisi,</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
