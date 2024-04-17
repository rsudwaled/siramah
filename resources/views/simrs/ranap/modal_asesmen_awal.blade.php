<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cAsesemenAwal">
        <h3 class="card-title">
            Asesmen Awal Medis Rawat Inap
        </h3>
        <div class="card-tools">
            @if ($kunjungan->asesmen_ranap)
                <button type="button" class="btn btn-tool bg-warning" onclick="printAsesmenAwal()" title="Print">
                    <i class="fas fa-print"></i> Print
                </button>
                <button type="button" onclick="modalAsesmenAwal()" class="btn btn-tool bg-warning"
                    title="Edit Asesmen Awal Medis">
                    <i class="fas fa-edit"></i> Edit Asesmen
                </button>
                <button type="button" class="btn btn-tool bg-success">
                    <i class="fas fa-check"></i> Sudah Asesmen
                </button>
            @else
                <button type="button" class="btn btn-tool bg-danger">
                    <i class="fas fa-check"></i> Belum Asesmen
                </button>
            @endif
        </div>
    </a>
    <div id="cAsesemenAwal" class="collapse" role="tabpanel">
        <div class="card-body">
            <iframe src="{{ route('print_asesmen_ranap_awal') }}?kode={{ $kunjungan->kode_kunjungan }}" width="100%"
                height="700px" frameborder="0"></iframe>
        </div>
    </div>
</div>
<x-adminlte-modal id="modalAsesmenAwal" name="modalAsesmenAwal" title="Asesmen Awal Medis Rawat Inap" theme="success"
    icon="fas fa-file-medical" size="xl">
    <form action="{{ route('simpan_asesmen_ranap_awal') }}" name="formAsesmenRanapAwal" id="formAsesmenRanapAwal"
        method="POST">
        @csrf
        <input type="hidden" name="kode_kunjungan" value="{{ $kunjungan->kode_kunjungan }}">
        <input type="hidden" name="counter" value="{{ $kunjungan->counter }}">
        <input type="hidden" name="no_rm" value="{{ $kunjungan->no_rm }}">
        <input type="hidden" name="nama" value="{{ $kunjungan->pasien->nama_px }}">
        <input type="hidden" name="rm_counter" value="{{ $kunjungan->no_rm }}|{{ $kunjungan->counter }}">
        <input type="hidden" name="kode_unit" value="{{ $kunjungan->unit->kode_unit }}">
        <div class="row">
            <div class="col-md-6">
                @php
                    $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
                @endphp
                <x-adminlte-input-date name="tgl_masuk_ruangan" id="tglmasukruangan" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm"
                    value="{{ $kunjungan->asesmen_ranap->tgl_masuk_ruangan ?? null }}" label="Tgl Masuk Ruangan"
                    :config="$config" required />
                <x-adminlte-input name="nama_unit" fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                    igroup-size="sm" label="Nama Ruangan" placeholder="Nama Ruangan"
                    value="{{ $kunjungan->unit->nama_unit }}" readonly required />
                <x-adminlte-select name="cara_masuk" label="Cara Masuk" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" required>
                    <option
                        {{ $kunjungan->asesmen_ranap ? ($kunjungan->asesmen_ranap->cara_masuk == 'Brankar' ? 'selected' : null) : null }}>
                        Brankar
                    </option>
                    <option
                        {{ $kunjungan->asesmen_ranap ? ($kunjungan->asesmen_ranap->cara_masuk == 'Kursi Roda' ? 'selected' : null) : null }}>
                        Kursi Roda</option>
                    <option
                        {{ $kunjungan->asesmen_ranap ? ($kunjungan->asesmen_ranap->cara_masuk == 'Jalan Kaki' ? 'selected' : null) : null }}>
                        Jalan Kaki</option>
                </x-adminlte-select>
                <x-adminlte-select name="asal_masuk" label="Asal Masuk" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" required>
                    <option
                        {{ $kunjungan->asesmen_ranap ? ($kunjungan->asesmen_ranap->asal_masuk == 'IGD' ? 'selected' : null) : null }}>
                        IGD</option>
                    <option
                        {{ $kunjungan->asesmen_ranap ? ($kunjungan->asesmen_ranap->asal_masuk == 'Kamar Operasi' ? 'selected' : null) : null }}>
                        Kamar Operasi</option>
                    <option
                        {{ $kunjungan->asesmen_ranap ? ($kunjungan->asesmen_ranap->asal_masuk == 'Rawat Jalan' ? 'selected' : null) : null }}>
                        Rawat Jalan</option>
                    <option
                        {{ $kunjungan->asesmen_ranap ? ($kunjungan->asesmen_ranap->asal_masuk == 'Transfer Ruangan' ? 'selected' : null) : null }}>
                        Transfer Ruangan</option>
                </x-adminlte-select>
            </div>
            <div class="col-md-6">
                <x-adminlte-input-date name="tgl_asesmen_awal" id="tglasesmenawal" label="Tgl Asesmen Awal"
                    fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm"
                    :config="$config" required value="{{ $kunjungan->asesmen_ranap->tgl_asesmen_awal ?? now() }}" />
                <x-adminlte-select name="sumber_data" label="Sumber Data" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" required>
                    <option
                        {{ $kunjungan->asesmen_ranap ? ($kunjungan->asesmen_ranap->sumber_data == 'Pasien / Autoanamnese' ? 'selected' : null) : null }}>
                        Pasien / Autoanamnese</option>
                    <option
                        {{ $kunjungan->asesmen_ranap ? ($kunjungan->asesmen_ranap->sumber_data == 'Keluarga / Allonamnese' ? 'selected' : null) : null }}>
                        Keluarga / Allonamnese</option>
                </x-adminlte-select>
                <x-adminlte-input name="nama_keluarga" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Nama Keluarga" placeholder="Nama Keluarga"
                    value="{{ $kunjungan->asesmen_ranap->nama_keluarga ?? null }}" required />
                <x-adminlte-input name="hubungan_keluarga" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Hubungan Keluarga" placeholder="Hubungan Keluarga"
                    value="{{ $kunjungan->asesmen_ranap->hubungan_keluarga ?? null }}" required />
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
                    placeholder="Keluhan Utama" required>
                    {{ $kunjungan->asesmen_ranap->keluhan_utama ?? null }}
                </x-adminlte-textarea>
                <x-adminlte-textarea name="riwayat_pengobatan" label="Riwayat Pengobatan" rows="3"
                    igroup-size="sm" placeholder="Riwayat Pengobatan" required>
                    {{ $kunjungan->asesmen_ranap->riwayat_pengobatan ?? null }}
                </x-adminlte-textarea>
            </div>
            <div class="col-md-6">
                <x-adminlte-textarea name="riwayat_penyakit_utama" label="Riwayat Penyakit Utama" rows="3"
                    igroup-size="sm" placeholder="Riwayat Penyakit Utama" required>
                    {{ $kunjungan->asesmen_ranap->riwayat_penyakit_utama ?? null }}
                </x-adminlte-textarea>
                <x-adminlte-textarea name="riwayat_penyakit_dahulu" label="Riwayat Penyakit Dahulu" rows="3"
                    igroup-size="sm" placeholder="Riwayat Penyakit Dahulu" required>
                    {{ $kunjungan->asesmen_ranap->riwayat_penyakit_dahulu ?? null }}
                </x-adminlte-textarea>
                <x-adminlte-textarea name="riwayat_penyakit_keluarga" label="Riwayat Penyakit Keluarga"
                    rows="3" igroup-size="sm" placeholder="Riwayat Penyakit Keluarga" required>
                    {{ $kunjungan->asesmen_ranap->riwayat_penyakit_keluarga ?? null }}
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
                <x-adminlte-input name="keadaan_umum" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Keadaan Umum"
                    value="{{ $kunjungan->asesmen_ranap->keadaan_umum ?? null }}" required />
                <x-adminlte-select name="kesadaran" label="Kesadaran" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" required>
                    <option
                        {{ $kunjungan->asesmen_ranap ? ($kunjungan->asesmen_ranap->kesadaran == 'Compos Mentis' ? 'selected' : null) : null }}>
                        Compos Mentis</option>
                    <option
                        {{ $kunjungan->asesmen_ranap ? ($kunjungan->asesmen_ranap->kesadaran == 'Apatis' ? 'selected' : null) : null }}>
                        Apatis</option>
                    <option
                        {{ $kunjungan->asesmen_ranap ? ($kunjungan->asesmen_ranap->kesadaran == 'Somnolent' ? 'selected' : null) : null }}>
                        Somnolent</option>
                    <option
                        {{ $kunjungan->asesmen_ranap ? ($kunjungan->asesmen_ranap->kesadaran == 'Sopor' ? 'selected' : null) : null }}>
                        Sopor</option>
                    <option
                        {{ $kunjungan->asesmen_ranap ? ($kunjungan->asesmen_ranap->kesadaran == 'Coma' ? 'selected' : null) : null }}>
                        Coma</option>
                </x-adminlte-select>
                <x-adminlte-input name="diastole" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" type="number" igroup-size="sm" label="Diastole"
                    value="{{ $kunjungan->asesmen_ranap->diastole ?? null }}" required />
                <x-adminlte-input name="sistole" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" type="number" igroup-size="sm" label="Sistole"
                    value="{{ $kunjungan->asesmen_ranap->sistole ?? null }}" required />
                <x-adminlte-input name="pernapasan" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" type="number" igroup-size="sm" label="Pernapasan"
                    value="{{ $kunjungan->asesmen_ranap->pernapasan ?? null }}" required />
                <x-adminlte-input name="suhu" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Suhu"
                    value="{{ $kunjungan->asesmen_ranap->suhu ?? null }}" required />
                <x-adminlte-input name="denyut_nadi" type="number" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Nadi"
                    value="{{ $kunjungan->asesmen_ranap->denyut_nadi ?? null }}" required />
            </div>
            <div class="col-md-6">
                <x-adminlte-textarea name="pemeriksaan_fisik" label="Pemeriksaan Fisik" rows="5"
                    igroup-size="sm" placeholder="Pemeriksaan Fisik" required>
                    {{ $kunjungan->asesmen_ranap->pemeriksaan_fisik ?? null }}
                </x-adminlte-textarea>
                <x-adminlte-textarea name="pemeriksaan_penunjang" label="Pemeriksaan Penunjang" rows="5"
                    igroup-size="sm" placeholder="Pemeriksaan Penunjang" required>
                    {{ $kunjungan->asesmen_ranap->pemeriksaan_penunjang ?? null }}
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
                    placeholder="Diagnosa Kerja" required>
                    {{ $kunjungan->asesmen_ranap->diagnosa_kerja ?? null }}
                </x-adminlte-textarea>
            </div>
            <div class="col-md-6">
                <x-adminlte-textarea name="diagnosa_banding" label="Diagnosa Banding" rows="3"
                    igroup-size="sm" placeholder="Diagnosa Banding" required>
                    {{ $kunjungan->asesmen_ranap->diagnosa_banding ?? null }}
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
                <x-adminlte-textarea name="rencana_penunjang" label="Rencana Pemeriksaan Penunjang" rows="3"
                    igroup-size="sm" placeholder="Rencana Pemeriksaan Penunjang" required>
                    {{ $kunjungan->asesmen_ranap->rencana_penunjang ?? null }}
                </x-adminlte-textarea>
            </div>
            <div class="col-md-6">
                <x-adminlte-textarea name="rencana_tindakan" label="Rencana Tindakan" rows="3"
                    igroup-size="sm" placeholder="Rencana Tindakan" required>
                    {{ $kunjungan->asesmen_ranap->rencana_tindakan ?? null }}
                </x-adminlte-textarea>
            </div>
            <div class="col-md-6">
                <x-adminlte-input name="rencana_lama_ranap" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Rancana Lama Ranap"
                    placeholder="Rencana Lama Ranap" type="number"
                    value="{{ $kunjungan->asesmen_ranap->rencana_lama_ranap ?? null }}" />
                <x-adminlte-input-date name="rencana_tgl_pulang" label="Rencana Tgl Pulang" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" :config="$config"
                    value="{{ $kunjungan->asesmen_ranap->rencana_tgl_pulang ?? null }}" />
                <x-adminlte-textarea name="lanjutan_perawatan" label="Lanjutan Perawatan" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" rows="3" igroup-size="sm"
                    placeholder="Lanjutan Perawatan">
                    {{ $kunjungan->asesmen_ranap->lanjutan_perawatan ?? null }}
                </x-adminlte-textarea>
            </div>
            <div class="col-md-6">
                <x-adminlte-textarea name="alasan_lama_ranap" label="Alasan Lama Rawat Inap belum bisa ditentukan"
                    rows="3" igroup-size="sm" placeholder="Alasan Lama Rawat Inap belum bisa ditentukan">
                    {{ $kunjungan->asesmen_ranap->alasan_lama_ranap ?? null }}
                </x-adminlte-textarea>
            </div>
        </div>
        <x-adminlte-input name="dokter_asesmen_awal" igroup-size="sm" label="Dokter DPJP Asesmen Awal"
            placeholder="Dokter DPJP Asesmen Awal" />
    </form>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="success" class="mr-auto" label="Simpan" type="submit" icon="fas fa-save"
            form="formAsesmenRanapAwal" />
        <a href="{{ route('print_asesmen_ranap_awal') }}?kode={{ $kunjungan->kode_kunjungan }}" target="_blank"
            class="btn btn-warning">Print</a>
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

        function printAsesmenAwal() {
            var url = "{{ route('print_asesmen_ranap_awal') }}?kode={{ $kunjungan->kode_kunjungan }}";
            window.open(url, '_blank');
        }
    </script>
@endpush
