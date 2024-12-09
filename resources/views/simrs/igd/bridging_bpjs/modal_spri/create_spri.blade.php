<x-adminlte-modal id="modalSPRI" title="Form Create SPRI" theme="primary" size='lg'
disable-animations>
<form>
    <input type="hidden" name="kodeKunjungan" id="kodeKunjungan">
    <input type="hidden" name="user" id="user" value="{{ Auth::user()->name }}">
    <input type="hidden" name="jenispelayanan" id="jenispelayanan" value="1">
    <div class="row">
        <div class="col-md-6">
            <x-adminlte-input name="noKartu" id="noKartu" label="No Kartu" readonly />
        </div>
        <div class="col-md-6">
            @php
                $config = ['format' => 'YYYY-MM-DD'];
            @endphp
            <x-adminlte-input-date name="tanggal" label="Tanggal" :config="$config"
                value="{{ \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d') }}">
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-primary">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </x-slot>
            </x-adminlte-input-date>
        </div>
        <div class="col-md-6">
            <x-adminlte-select2 name="poliKontrol" label="Poliklinik" id="poliklinik">
                <option selected disabled>Cari Poliklinik</option>
            </x-adminlte-select2>
        </div>
        <div class="col-md-6">
            <x-adminlte-select2 name="dokter" id="dokter" label="Dokter">
                <option selected disabled>Cari Dokter DPJP <i>(spesialis)</i></option>
            </x-adminlte-select2>
        </div>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button type="submit" theme="success" form="formSPRI" class="btnCreateSPRI"
            label="Buat SPRI" />
        <x-adminlte-button theme="danger" label="batal" class="btnCreateSPRIBatal"
            data-dismiss="modal" />
    </x-slot>
</form>
</x-adminlte-modal>
