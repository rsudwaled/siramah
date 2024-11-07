<x-adminlte-modal id="modalUpdateDiagnosa" title="Update Diagnosa ICD 10" theme="info" size='lg' disable-animations>
    <form id="formUpdateDiagnosa" method="post" action="{{ route('bridging-igd.update-diagnosa-kunjungan') }}">
        @csrf
        <input type="hidden" name="kode_update" id="kode_update">
        <div class="col-lg-12">
            <x-adminlte-select2 name="diagAwal" id="diagnosa" label="Pilih Diagnosa">
            </x-adminlte-select2>
        </div>
        <x-slot name="footerSlot">
            <x-adminlte-button type="submit" theme="success" form="formUpdateDiagnosa" label="Update Diagnosa" />
        </x-slot>
    </form>
</x-adminlte-modal>
