<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#colPerkembangan">
        <h3 class="card-title">
            SOAP  & Perkembangan Pasien
        </h3>
    </a>
    <div id="colPerkembangan" class="collapse">
        <div class="card-body">
            <x-adminlte-button label="Input SOAP" icon="fas fa-plus" theme="success" class="btn-xs"
                onclick="btnInputPerkembangan()" />
            <x-adminlte-button icon="fas fa-sync" theme="primary" class="btn-xs" onclick="getObservasiRanap()" />
            <a href="{{ route('print_perkembangan_ranap') }}?kunjungan={{ $kunjungan->kode_kunjungan }}" target="_blank"
                class="btn btn-xs btn-warning"><i class="fas fa-print"></i> Print</a>
            <table class="table table-sm table-bordered table-hover" id="tablePerkembanganPasien">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Tanggal Jam</th>
                        <th>SOAP, Hasil Pemeriksaan, Analisis & Catatan Lainnya</th>
                        <th>Instruksi Medis</th>
                        <th>Ttd Pengisi,</th>
                        <th>Verifikasi DPJP</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
