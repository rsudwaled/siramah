<div class="row">
    {{-- profile --}}
    <div class="col-md-12">
        @if (flash()->message)
            <x-adminlte-alert theme="{{ flash()->class }}" title="{{ flash()->class }} !" dismissable>
                {{ flash()->message }}
            </x-adminlte-alert>
        @endif
        <x-adminlte-card theme="primary" theme-mode="outline">
            @include('livewire.rekammedis.rekam-medis-profil-pasien')
        </x-adminlte-card>
    </div>
    {{-- navigasi --}}
    <div class="col-md-3">
        <x-adminlte-card theme="primary" title="Navigasi" body-class="p-0">
            @include('livewire.rekammedis.rekam-medis-navigasi')
            <x-slot name="footerSlot">
                <a
                    href="{{ route('rekam-medis-rajal') }}?unit={{ $kunjungan->kode_unit }}&tgl_masuk={{ \Carbon\Carbon::parse($kunjungan->tgl_masuk)->format('Y-m-d') }}">
                    <x-adminlte-button class="btn-xs" label="Kembali" theme="danger" icon="fas fa-arrow-left" />
                </a>
                <div wire:loading>
                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                    </div>
                    Loading ...
                </div>
            </x-slot>
        </x-adminlte-card>
    </div>
    {{-- form --}}
    <div class="col-md-9" style="overflow-y: auto ;max-height: 600px ;">
        @livewire('rekammedis.histori-kunjungan', ['kunjungan' => $kunjungan])
        @livewire('rekammedis.rincian-biaya', ['kunjungan' => $kunjungan])
        @livewire('rekammedis.asesmen-dokter', ['kunjungan' => $kunjungan])
        @livewire('rekammedis.casemix-manager', ['kunjungan' => $kunjungan])
    </div>
</div>