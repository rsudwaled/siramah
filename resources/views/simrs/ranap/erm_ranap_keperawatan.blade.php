<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#colKeperawatan">
        <h3 class="card-title">
            Implementasi & Evaluasi Keperawatan
        </h3>
    </a>
    <div id="colKeperawatan" class="collapse">
        <div class="card-body">
            <x-adminlte-button label="Input Keperawatan" icon="fas fa-plus" theme="success" class="btn-xs"
                onclick="btnInputKeperawatan()" />
            <x-adminlte-button icon="fas fa-sync" theme="primary" class="btn-xs" onclick="getKeperawatanRanap()" />
            <a href="{{ route('print_implementasi_evaluasi_keperawatan') }}?kunjungan={{ $kunjungan->kode_kunjungan }}"
                target="_blank" class="btn btn-xs btn-warning"><i class="fas fa-print"></i> Print</a>
            <style>
                pre {
                    border: none;
                    outline: none;
                    padding: 0 !important;
                    font-size: 12px;
                }
            </style>
            <table class="table table-sm table-bordered table-hover" id="tableKeperawatan">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Tanggal Jam</th>
                        <th>Implementasi & Evaluasi Keperawatan</th>
                        <th>Ttd Pengisi,</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
