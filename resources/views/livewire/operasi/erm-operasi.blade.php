<div class="row">
    <div class="col-md-12">
        @if (flash()->message)
            <x-adminlte-alert theme="{{ flash()->class }}" title="{{ flash()->class }} !" dismissable>
                {{ flash()->message }}
            </x-adminlte-alert>
        @endif
        @include('livewire.operasi.modal-profil-erm-operasi')
    </div>
    <div class="col-md-3">
        @include('livewire.operasi.modal-navigasi-erm-operasi')
    </div>
    <div class="col-md-9" style="overflow-y: auto ;max-height: 500px ;">
        <div id="laporanOperasi">
            @livewire('operasi.modal-laporan-operasi', ['kunjungan' => $kunjungan, 'lazy' => true])
        </div>

    </div>
</div>
