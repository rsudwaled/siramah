<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cRencanaPemulangan">
        <h3 class="card-title">
            Rencana Pemulangan Pasien
        </h3>
        <div class="card-tools">
            <button type="button" onclick="modalRencanaPemulangan()" class="btn btn-tool bg-warning"
                title="Edit Asesmen Awal Medis">
                <i class="fas fa-edit"></i> Edit Rencana Pemulangan
            </button>
            @if ($kunjungan->crpulang)
                <button type="button" class="btn btn-tool bg-warning" onclick="printAsesmenAwal()" title="Print">
                    <i class="fas fa-print"></i> Print
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
    <div id="cRencanaPemulangan" class="collapse" role="tabpanel">
        <div class="card-body">
            Rencana Pemulangan
            {{-- <iframe src="{{ route('print_asesmen_ranap_awal') }}?kode={{ $kunjungan->kode_kunjungan }}" width="100%"
                height="700px" frameborder="0"></iframe> --}}
        </div>
    </div>
</div>
<x-adminlte-modal id="modalRencanaPemulangan" name="modalRencanaPemulangan" title="Rencana Pemulangan Pasien"
    theme="success" icon="fas fa-user-injured" size="xl">
    <form action="" name="formRencanaPulang" id="formRencanaPulang" method="POST">
        @csrf
        <input type="hidden" name="kode_kunjungan" value="{{ $kunjungan->kode_kunjungan }}">
        <input type="hidden" name="counter" value="{{ $kunjungan->counter }}">
        <input type="hidden" name="no_rm" value="{{ $kunjungan->no_rm }}">
        <input type="hidden" name="nama" value="{{ $kunjungan->pasien->nama_px }}">
        <input type="hidden" name="rm_counter" value="{{ $kunjungan->no_rm }}|{{ $kunjungan->counter }}">
        <input type="hidden" name="kode_unit" value="{{ $kunjungan->unit->kode_unit }}">
        <div class="row">
            <div class="col-md-8">
                @php
                    $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
                @endphp
                <x-adminlte-input-date name="tgl_rencana_pulang" id="tglmasukruangan" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm"
                    value="{{ $kunjungan->asesmen_ranap->tgl_rencana_pulang ?? null }}" label="Tgl Masuk Ruangan"
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
                <x-adminlte-input name="nama_keluarga" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="Nama Keluarga" placeholder="Nama Keluarga"
                    value="{{ $kunjungan->asesmen_ranap->nama_keluarga ?? null }}" required />
                <x-adminlte-textarea name="keluhan_utama" label="Keluhan Utama" rows="3" igroup-size="sm"
                    placeholder="Keluhan Utama" required>
                    {{ $kunjungan->asesmen_ranap->keluhan_utama ?? null }}
                </x-adminlte-textarea>
            </div>
            <div class="col-md-4">
            </div>
        </div>
    </form>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="success" class="mr-auto" label="Simpan" type="submit" icon="fas fa-save"
            form="formRencanaPulang" />
        <a href="{{ route('print_asesmen_ranap_awal') }}?kode={{ $kunjungan->kode_kunjungan }}" target="_blank"
            class="btn btn-warning">Print</a>
        <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
@push('js')
    <script>
        function modalRencanaPemulangan() {
            $.LoadingOverlay("show");
            $('#modalRencanaPemulangan').modal('show');
            $.LoadingOverlay("hide");
        }
    </script>
@endpush
