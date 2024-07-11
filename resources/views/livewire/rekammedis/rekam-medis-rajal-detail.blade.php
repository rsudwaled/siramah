<div>
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
    @include('livewire.rekammedis.rekam-medis-navigasi')

</div>
