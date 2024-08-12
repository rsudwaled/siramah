<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-4" id="formInputImplementasi_EvaluasiKeperawatan">
                <form id="formKeperawatan" name="formKeperawatan" method="POST">
                    @csrf
                    @php
                        $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
                    @endphp
                    <input type="hidden" class="kode_kunjungan-keperawatan" name="kode_kunjungan"
                        value="{{ $kunjungan->kode_kunjungan }}">
                    <input type="hidden" class="counter-keperawatan" name="counter"
                        value="{{ $kunjungan->counter }}">
                    <input type="hidden" class="norm-keperawatan" name="norm" value="{{ $kunjungan->no_rm }}">
                    <x-adminlte-input-date type="datetime-local" id="tanggal_input-keperawatan"  name="tanggal_input"
                        label="Tanggal & Waktu" :config="$config" />
                    <x-adminlte-textarea igroup-size="sm" class="keperawatan-keperawatan" name="keperawatan"
                        label="Implementasi & Evaluasi Keperawatan"
                        placeholder="Implementasi & Evaluasi Keperawatan" rows=5>
                    </x-adminlte-textarea>
                    <x-adminlte-button id="saveButtonKeperawatan" label="Simpan Data" icon="fas fa-save"
                        theme="success" class="btn-sm" onclick="tambahKeperawatan()" />
                </form>
            </div>
            <div class="col-lg-8">
                <div class="row mb-1">
                    <div class="col-lg-12 text-right">
                        <x-adminlte-button icon="fas fa-sync" id="btn-getperkembangan-ranap" theme="primary"
                            class="btn-sm" onclick="getKeperawatanRanap()" />
                        <a href="{{ route('print_implementasi_evaluasi_keperawatan') }}?kunjungan={{ $kunjungan->kode_kunjungan }}"
                            id="btn-print-perkembangan-keperawatan" target="_blank" class="btn btn-sm btn-warning"><i
                                class="fas fa-print"></i> Print</a>
                    </div>
                </div>
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
</div>
