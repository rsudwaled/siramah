<div class="row">
    <div class="col-md-12">
        @if (flash()->message)
            <x-adminlte-alert theme="{{ flash()->class }}" title="{{ flash()->class }} !" dismissable>
                {{ flash()->message }}
            </x-adminlte-alert>
        @endif
        <x-adminlte-card theme="primary" theme-mode="outline">
            @include('livewire.poliklinik.modal-profil-rajal')
        </x-adminlte-card>
    </div>
    @include('livewire.poliklinik.navigasi-poliklinik-rajal')
    <div class="col-md-9" style="overflow-y: auto ;max-height: 600px ;">
        <div id="icare">
            @livewire('poliklinik.modal-icare', ['kunjungan' => $kunjungan, 'lazy' => true])
        </div>
    </div>
</div>
