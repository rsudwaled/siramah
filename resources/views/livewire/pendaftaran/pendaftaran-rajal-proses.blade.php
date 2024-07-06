<div class="row">
    {{-- profile --}}
    <div class="col-md-12">
        @if (flash()->message)
            <x-adminlte-alert theme="{{ flash()->class }}" title="{{ flash()->class }} !" dismissable>
                {{ flash()->message }}
            </x-adminlte-alert>
        @endif
        <x-adminlte-card theme="primary" theme-mode="outline">
            @include('livewire.pendaftaran.modal-profil-rajal')
        </x-adminlte-card>
    </div>
    {{-- navigasi --}}
    @include('livewire.pendaftaran.navigasi-pendaftaran-rajal')
    {{-- form --}}
    <div class="col-md-9" style="overflow-y: auto ;max-height: 600px ;">
        @livewire('pendaftaran.modal-pasien')
        @livewire('pendaftaran.modal-antrian', ['antrian' => $antrian])
        @livewire('pendaftaran.modal-kunjungan-rajal', ['antrian' => $antrian])
        @if ($antrian->pasien && $antrian->jenispasien == 'JKN')
            @livewire('pendaftaran.modal-sep', ['antrian' => $antrian])
            @livewire('pendaftaran.modal-suratkontrol', ['antrian' => $antrian])
        @endif
        {{-- @if ($antrian->kunjungan)
            @livewire('dokter.modal-cppt', ['antrian' => $antrian])
            @livewire('perawat.modal-layanan-tindakan', ['antrian' => $antrian])
            <div id="invoice">
                <x-adminlte-card theme="primary" title="Invoice Pelayanan Pasien">
                    <iframe src="http://simrs.test/bpjs/vclaim/sep_print?noSep=0125S0070624V000128" width="100%"
                        height="300" frameborder="0"></iframe>
                </x-adminlte-card>
            </div>
        @endif --}}
    </div>
</div>
