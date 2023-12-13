<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#colPerkembangan">
        <h3 class="card-title">
            Perkembangan Pasien Terintegrasi
        </h3>
    </a>
    <div id="colPerkembangan" class="collapse">
        <div class="card-body">
            <x-adminlte-button label="Input Observasi" icon="fas fa-plus" theme="success" class="btn-xs"
                onclick="btnInputPerkembangan()" />
            <x-adminlte-button label="Get Observasi" icon="fas fa-sync" theme="primary" class="btn-xs"
                onclick="getObservasiRanap()" />
            <a href="{{ route('print_perkembangan_ranap') }}?kunjungan={{ $kunjungan->kode_kunjungan }}" target="_blank"
                class="btn btn-xs btn-warning"><i class="fas fa-print"></i> Print</a>
            <table class="table table-sm table-bordered table-hover" id="tablePerkembanganPasien">
                <thead>
                    <tr>
                        <th>Tanggal Jam</th>
                        <th>Hasil Pemeriksaan, Analisis, SOAP, & Catatan Lainnya </th>
                        <th>Instruksi Medis</th>
                        <th>Ttd,</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
