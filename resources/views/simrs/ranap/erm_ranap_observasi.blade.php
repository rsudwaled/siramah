<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#colObservasi">
        <h3 class="card-title">
            Observasi 24 Jam
        </h3>
    </a>
    <div id="colObservasi" class="collapse">
        <div class="card-body">
            <x-adminlte-button label="Input Observasi" icon="fas fa-plus" theme="success" class="btn-xs"
                onclick="btnInputObservasi()" />
            <x-adminlte-button label="Get Observasi" icon="fas fa-sync" theme="primary" class="btn-xs"
                onclick="getObservasiRanap()" />
            <a href="{{ route('print_obaservasi_ranap') }}?kunjungan={{ $kunjungan->kode_kunjungan }}" target="_blank"
                class="btn btn-xs btn-warning"><i class="fas fa-print"></i> Print</a>
            <table class="table table-sm table-bordered table-hover" id="tableObservasi">
                <thead>
                    <tr>
                        <th>Tanggal Jam</th>
                        <th>Tensi</th>
                        <th>Nadi</th>
                        <th>RR</th>
                        <th>Suhu</th>
                        <th>GDS</th>
                        <th>Kesadaran</th>
                        <th>Pupil</th>
                        <th>ECG</th>
                        <th>Ket.</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
