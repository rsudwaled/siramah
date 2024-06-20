<div id="antrian">
    <x-adminlte-card theme="primary" title="Antrian Pasien">
        <form wire:submit="editAntrian">
            <input type="hidden" wire:model='kodebooking' name="kodebooking">
            <input type="hidden" wire:model='antrianId' name="antrianId">
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input wire:model='nomorkartu' name="nomorkartu" fgroup-class="row"
                        label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" label="Nomor Kartu">
                        <x-slot name="appendSlot">
                            <div class="btn btn-primary" wire:click='cariNomorKartu'>
                                <i class="fas fa-search"></i> Cari
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input wire:model='nik' name="nik" class="nik-id" fgroup-class="row"
                        label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" label="NIK">
                        <x-slot name="appendSlot">
                            <div class="btn btn-primary" wire:click='cariNIK'>
                                <i class="fas fa-search"></i> Cari
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input wire:model='norm' name="norm" label="No RM" fgroup-class="row"
                        label-class="text-left col-4" igroup-class="col-8" igroup-size="sm">
                        <x-slot name="appendSlot">
                            <div class="btn btn-primary" wire:click='cariNoRM'>
                                <i class="fas fa-search"></i> Cari
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input wire:model='nama' name="nama" label="Nama Pasien" fgroup-class="row"
                        label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
                    <x-adminlte-input wire:model='nohp' name="nohp" class="nohp-id" label="Nomor HP"
                        fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input wire:model='tanggalperiksa' name="tanggalperiksa" type='date'
                        label="Tanggal Periksa" fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                        igroup-size="sm" />
                    <x-adminlte-select wire:model='jenispasien' fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" name="jenispasien" label="Jenis Pasien">
                        <option value=null disabled>Pilih Jenis Pasien</option>
                        <option value="JKN">JKN</option>
                        <option value="NON-JKN">NON-JKN</option>
                    </x-adminlte-select>
                    <x-adminlte-select wire:model='kodepoli' fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" name="kodepoli" label="Poliklinik">
                        <option value=null disabled>Pilih Poliklinik</option>
                        @foreach ($polikliniks as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </x-adminlte-select>
                    <x-adminlte-select wire:model='kodedokter' fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" name="kodedokter" label="Dokter">
                        <option value=null disabled>Pilih Dokter</option>
                        @foreach ($dokters as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </x-adminlte-select>
                    @if ($antrian->jenispasien == 'JKN')
                        <x-adminlte-select fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                            igroup-size="sm" name="asalRujukan" wire:model='asalRujukan' label="Jenis Rujukan">
                            <option value=null>Pilih Asal Rujukan</option>
                            <option value="1">Rujukan FKTP</option>
                            <option value="2">Rujukan Antar RS</option>
                        </x-adminlte-select>
                        <x-adminlte-select fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                            igroup-size="sm" name="noRujukan" wire:model='noRujukan' wire:click='cariRujukan'
                            label="No Rujukan">
                            <option value=null>Pilih Nomor Rujukan</option>
                            @foreach ($rujukans as $key => $item)
                                <option value="{{ $item['noKunjungan'] }}">{{ $item['noKunjungan'] }}
                                    {{ $item['tglKunjungan'] }} {{ $item['namaPoli'] }}</option>
                            @endforeach
                            <x-slot name="appendSlot">
                                <div class="btn btn-primary" wire:click='cariRujukan'>
                                    <i class="fas fa-search"></i> Cari
                                </div>
                            </x-slot>
                        </x-adminlte-select>
                        <x-adminlte-select fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                            igroup-size="sm" name="noSurat" wire:model='noSurat' wire:click='cariSuratKontrol'
                            label="No Surat Kontrol">
                            <option value=null>Pilih Surat Kontrol</option>
                            @foreach ($suratkontrols as $key => $item)
                                <option value="{{ $item['noSuratKontrol'] }}">{{ $item['noSuratKontrol'] }}
                                    {{ $item['tglRencanaKontrol'] }} {{ $item['namaPoliTujuan'] }}
                                    {{ $item['terbitSEP'] }}</option>
                            @endforeach
                            <x-slot name="appendSlot">
                                <div class="btn btn-primary" wire:click='cariSuratKontrol'>
                                    <i class="fas fa-search"></i> Cari
                                </div>
                            </x-slot>
                        </x-adminlte-select>
                    @endif
                </div>
            </div>
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button theme="success" icon="fas fa-save" class="btn-sm" label="Simpan"
                wire:click="editAntrian" wire:confirm='Apakah anda yakin akan menyimpan data antrian ?' />
            <div wire:loading>
                <div class="spinner-border spinner-border-sm text-primary" role="status">
                </div>
                Loading ...
            </div>
            @if (flash()->message)
                <div class="text-{{ flash()->class }}" wire:loading.remove>
                    Loading Result : {{ flash()->message }}
                </div>
            @endif
        </x-slot>
    </x-adminlte-card>
</div>
