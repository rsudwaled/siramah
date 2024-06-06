<div class="row">
    <div class="col-md-6">
        <x-adminlte-card title="Refefensi Vclaim BPJS" theme="secondary" collapsible>
            <x-adminlte-input wire:model.live="diagnosa" list="diagnosalist" name="diagnosa" igroup-size="sm"
                label="Diagnosa">
            </x-adminlte-input>
            <datalist id="diagnosalist">
                @foreach ($diagnosas as $item)
                    <option value="{{ $item['kode'] }}">{{ $item['nama'] }}</option>
                @endforeach
            </datalist>
            <x-adminlte-input wire:model.live="procedure" list="procedurelist" name="procedure" igroup-size="sm"
                label="Procedure">
            </x-adminlte-input>
            <datalist id="procedurelist">
                @foreach ($procedures as $item)
                    <option value="{{ $item['kode'] }}">{{ $item['nama'] }}</option>
                @endforeach
            </datalist>
            <x-adminlte-select wire:model="jenisfaskes" name="jenisfaskes" label="Jenis Faskes">
                <option value=null>Pilih Jenis Faskes</option>
                <option value="1">FKTP (Puskesmas / Klinik Pratama)</option>
                <option value="2">FKTL (RS / Klinik Utama)</option>
            </x-adminlte-select>
            <x-adminlte-input wire:model.live="faskes" list="faskeslist" name="faskes" igroup-size="sm" label="faskes">
            </x-adminlte-input>
            <datalist id="faskeslist">
                @foreach ($faskess as $item)
                    <option value="{{ $item['kode'] }}">{{ $item['nama'] }}</option>
                @endforeach
            </datalist>
            <x-adminlte-input wire:model="tanggal" type="date" name="tanggal" igroup-size="sm" label="tanggal" />
            <x-adminlte-select wire:model="jenispelayanan" name="jenispelayanan" label="Jenis Pelayanan">
                <option value=null>Pilih Jenis Pelayanan</option>
                <option value="1">Rawat Inap</option>
                <option value="2">Rawat Jalan</option>
            </x-adminlte-select>
            <x-adminlte-input wire:model.live="poliklinik" list="polikliniklist" name="poliklinik" igroup-size="sm"
                label="poliklinik">
            </x-adminlte-input>
            <datalist id="polikliniklist">
                @foreach ($polikliniks as $item)
                    <option value="{{ $item['kode'] }}">{{ $item['nama'] }}</option>
                @endforeach
            </datalist>
            <x-adminlte-input wire:model.live="dokter" list="dokterlist" name="dokter" igroup-size="sm" label="dokter">
            </x-adminlte-input>
            <datalist id="dokterlist">
                @foreach ($dokters as $item)
                    <option value="{{ $item['kode'] }}">{{ $item['nama'] }}</option>
                @endforeach
            </datalist>
            <x-adminlte-input wire:model.live="provinsi" wire:focus="updateProvinsi" list="provinsilist" name="provinsi"
                igroup-size="sm" label="provinsi">
            </x-adminlte-input>
            <datalist id="provinsilist">
                @foreach ($provinsis as $item)
                    <option value="{{ $item['kode'] }}">{{ $item['nama'] }}</option>
                @endforeach
            </datalist>
            <x-adminlte-input wire:model.live="kabupaten" wire:focus="updateKabupaten" list="kabupatenlist"
                name="kabupaten" igroup-size="sm" label="kabupaten">
            </x-adminlte-input>
            <datalist id="kabupatenlist">
                @foreach ($kabupatens as $item)
                    <option value="{{ $item['kode'] }}">{{ $item['nama'] }}</option>
                @endforeach
            </datalist>
            <x-adminlte-input wire:model.live="kecamatan" wire:focus="updateKecamatan" list="kecamatanlist"
                name="kecamatan" igroup-size="sm" label="kecamatan">
            </x-adminlte-input>
            <datalist id="kecamatanlist">
                @foreach ($kecamatans as $item)
                    <option value="{{ $item['kode'] }}">{{ $item['nama'] }}</option>
                @endforeach
            </datalist>
            <div wire:loading>Loading...</div>
        </x-adminlte-card>
    </div>
</div>
