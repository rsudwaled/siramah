<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cAsesemenAwal">
        <h3 class="card-title">
            Asesmen Awal Medis Rawat Inap
        </h3>
        <div class="card-tools">
            <i class="fas fa-file-medical"></i>
        </div>
    </a>
    <div id="cAsesemenAwal" class="collapse" role="tabpanel">
        <div class="card-body">
            Asesmen Awal Medis Rawat Inap
        </div>
    </div>
</div>
<x-adminlte-modal id="modalAsesmenAwal" name="modalAsesmenAwal" title="Asesmen Awal Medis Rawat Inap" theme="success"
    icon="fas fa-file-medical" size="xl">
    <form action="">
        <div class="row">
            <div class="col-md-6">
                @php
                    $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
                @endphp
                <x-adminlte-input-date name="tgl_masuk_ruangan" label="Tgl Masuk Ruangan" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" :config="$config" required />
                <x-adminlte-input name="nama_unit" fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                    igroup-size="sm" label="Nama Ruangan" placeholder="Nama Unit" readonly />
                <x-adminlte-select name="cara_masuk" label="Cara Masuk" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm">
                    <option>Jalan Kaki</option>
                    <option>Kursi Roda</option>
                    <option>Brankar</option>
                </x-adminlte-select>
                <x-adminlte-select name="asal_masuk" label="Asal Masuk" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm">
                    <option>IGD</option>
                    <option>Kamar Operasi</option>
                    <option>Rawat Jalan</option>
                    <option>Transfer Ruangan</option>
                </x-adminlte-select>
            </div>
            <div class="col-md-6">
                <x-adminlte-input-date name="tgl_asesmen_awal" label="Tgl Asesmen Awal" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" :config="$config" required />
                <x-adminlte-select name="sumber_data" label="Sumber Data" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm">
                    <option>Pasien / Autoanamnese</option>
                    <option>Keluarga / Allonamnese</option>
                </x-adminlte-select>
                <x-adminlte-input name="nama_keluarga" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Nama Keluarga" placeholder="Nama Keluarga" />
                <x-adminlte-input name="hubungan_keluarga" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Hubungan Keluarga" placeholder="Hubungan Keluarga" />
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <hr>
            </div>
            <div class="col-4 text-center">
                <h6>Anamnesa</h6>
            </div>
            <div class="col-4">
                <hr>
            </div>
            <div class="col-md-6">
                <x-adminlte-textarea name="keluhan_utama" label="Keluhan Utama" rows="3" igroup-size="sm"
                    placeholder="Keluhan Utama">
                </x-adminlte-textarea>
                <x-adminlte-textarea name="riwayat_penyakit_utama" label="Riwayat Penyakit Utama" rows="3"
                    igroup-size="sm" placeholder="Riwayat Penyakit Utama">
                </x-adminlte-textarea>
            </div>
            <div class="col-md-6">
                <x-adminlte-textarea name="riwayat_penyakit_dahulu" label="Riwayat Penyakit Dahulu" rows="3"
                    igroup-size="sm" placeholder="Riwayat Penyakit Dahulu">
                </x-adminlte-textarea>
                <x-adminlte-textarea name="riwayat_penyakit_keluarga" label="Riwayat Penyakit Keluarga" rows="3"
                    igroup-size="sm" placeholder="Riwayat Penyakit Keluarga">
                </x-adminlte-textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <hr>
            </div>
            <div class="col-4 text-center">
                <h6>Pemeriksaan</h6>
            </div>
            <div class="col-4">
                <hr>
            </div>
            <div class="col-md-6">
                <x-adminlte-input name="keadaan_umum" fgroup-class="row" label-class="text-left col-3"
                    igroup-class="col-9" igroup-size="sm" label="Keadaan Umum" placeholder="Keadaan Umum" />
                <x-adminlte-input name="diastole" fgroup-class="row" label-class="text-left col-3"
                    igroup-class="col-9" igroup-size="sm" label="Diastole" placeholder="Diastole" />
                <x-adminlte-input name="sistole" fgroup-class="row" label-class="text-left col-3"
                    igroup-class="col-9" igroup-size="sm" label="Sistole" placeholder="Sistole" />
                <x-adminlte-input name="pernapasan" fgroup-class="row" label-class="text-left col-3"
                    igroup-class="col-9" igroup-size="sm" label="Pernapasan" placeholder="Pernapasan" />
                <x-adminlte-input name="suhu" fgroup-class="row" label-class="text-left col-3"
                    igroup-class="col-9" igroup-size="sm" label="Suhu" placeholder="Suhu" />
            </div>
            <div class="col-md-6">
                <x-adminlte-textarea name="pemeriksaan_fisik" label="Pemeriksaan Fisik" rows="3"
                    igroup-size="sm" placeholder="Pemeriksaan Fisik">
                </x-adminlte-textarea>
                <x-adminlte-textarea name="pemeriksaan_penunjang" label="Pemeriksaan Penunjang" rows="3"
                    igroup-size="sm" placeholder="Pemeriksaan Penunjang">
                </x-adminlte-textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <hr>
            </div>
            <div class="col-4 text-center">
                <h6>Analisis</h6>
            </div>
            <div class="col-4">
                <hr>
            </div>
            <div class="col-md-6">
                <x-adminlte-textarea name="diagnosa_kerja" label="Diagnosa Kerja" rows="3" igroup-size="sm"
                    placeholder="Diagnosa Kerja">
                </x-adminlte-textarea>
            </div>
            <div class="col-md-6">
                <x-adminlte-textarea name="diagnosa_banding" label="Diagnosa Banding" rows="3"
                    igroup-size="sm" placeholder="Diagnosa Banding">
                </x-adminlte-textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <hr>
            </div>
            <div class="col-4 text-center">
                <h6>Planning</h6>
            </div>
            <div class="col-4">
                <hr>
            </div>
            <div class="col-md-6">
                <x-adminlte-textarea name="rencana_pemeriksaan_penunjang" label="Rencana Pemeriksaan Penunjang"
                    rows="3" igroup-size="sm" placeholder="Rencana Pemeriksaan Penunjang">
                </x-adminlte-textarea>
            </div>
            <div class="col-md-6">
                <x-adminlte-textarea name="rencana_tindakan" label="Rencana Tindakan" rows="3"
                    igroup-size="sm" placeholder="Rencana Tindakan">
                </x-adminlte-textarea>
            </div>
            <div class="col-md-6">
                <x-adminlte-input name="rencana_lama_ranap" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Rancana Lama Ranap"
                    placeholder="Rencana Lama Ranap" />
                <x-adminlte-input-date name="rencana_tgl_pulang" label="Rencana Tgl Pulang" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" :config="$config" required />
                <x-adminlte-textarea name="lanjutan_perawatan" label="Lanjutan Perawatan" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" rows="3" igroup-size="sm"
                    placeholder="Lanjutan Perawatan">
                </x-adminlte-textarea>
            </div>
            <div class="col-md-6">
                <x-adminlte-textarea name="alasan_lama_ranap" label="Alasan Lama Rawat Inap belum bisa ditentukan"
                    rows="3" igroup-size="sm" placeholder="Alasan Lama Rawat Inap belum bisa ditentukan">
                </x-adminlte-textarea>
            </div>
        </div>
        <x-adminlte-input name="dokter_asesmen_awal" igroup-size="sm" label="Dokter DPJP Asesmen Awal"
            placeholder="Dokter DPJP Asesmen Awal" />
    </form>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
@push('js')
    <script>
        function modalAsesmenAwal() {
            $.LoadingOverlay("show");
            $('#modalAsesmenAwal').modal('show');
            $.LoadingOverlay("hide");
        }
    </script>
@endpush
