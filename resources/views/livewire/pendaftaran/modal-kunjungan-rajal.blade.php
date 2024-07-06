<div id="kunjungan">
    <x-adminlte-card theme="primary" title="Kunjungan Pasien">
        <form>
            <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
            <input type="hidden" name="antrian_id" value="{{ $antrian->id }}">
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
                    <x-adminlte-input wire:model='nik' name="nik" fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" label="NIK">
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
                    <x-adminlte-input wire:model='tgl_lahir' name="tgl_lahir" type='date' label="Tanggal Lahir"
                        fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
                    <x-adminlte-input wire:model='gender' name="gender" label="Jenis Kelamin" fgroup-class="row"
                        label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
                    <x-adminlte-input wire:model='hakkelas' name="hakkelas" label="Kelas Pasien" fgroup-class="row"
                        label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
                    <x-adminlte-input wire:model='jenispeserta' name="jenispeserta" label="Jenis Peserta"
                        fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input wire:model='kode' name="kode" fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" label="Kode Kunjungan" igroup-size="sm" readonly />
                    <x-adminlte-input wire:model='counter' name="counter" fgroup-class="row"
                        label-class="text-left col-4" igroup-class="col-8" label="Counter" igroup-size="sm" readonly />
                    <x-adminlte-input wire:model='tgl_masuk' name="tgl_masuk" type='datetime-local'
                        label="Tanggal Masuk" fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                        igroup-size="sm" />
                    <x-adminlte-select wire:model='jaminan' igroup-size="sm" fgroup-class="row"
                        label-class="text-left col-4" igroup-class="col-8" name="jaminan" label="Jaminan Pasien">
                        <option value=null disabled>Pilih Jaminan</option>
                        @foreach ($jaminans as $key => $item)
                            <option value="{{ $key }}">{{ $item }}</option>
                        @endforeach
                    </x-adminlte-select>
                    <x-adminlte-select wire:model.live='unit' fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" name="unit" label="Unit">
                        <option value=null disabled>Pilih Unit</option>
                        @foreach ($polikliniks as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </x-adminlte-select>
                    <x-adminlte-select wire:model='dokter' fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" name="dokter" label="Dokter">
                        <option value=null disabled>Pilih Dokter</option>
                        @foreach ($dokters as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </x-adminlte-select>
                    <x-adminlte-select wire:model="caramasuk" fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" name="caramasuk" label="Cara Masuk">
                        <option value=null disabled>Pilih Cara masuk</option>
                        <option value="gp">Rujukan FKTP</option>
                        <option value="hosp-trans">Rujukan FKRTL</option>
                        <option value="mp">Rujukan Spesialis</option>
                        <option value="outp">Dari Rawat Jalan</option>
                        <option value="inp">
                            Dari
                            Rawat Inap</option>
                        <option value="emd">
                            Dari
                            Rawat Darurat</option>
                        <option value="born">
                            Lahir
                            di RS</option>
                        <option value="nursing">
                            Rujukan Panti Jompo</option>
                        <option value="psych">
                            Rujukan dari RS Jiwa</option>
                        <option value="rehab">
                            Rujukan Fasilitas Rehab</option>
                        <option value="other">
                            Lain-lain</option>
                    </x-adminlte-select>
                    <x-adminlte-input wire:model.live="diagnosa" list="diagnosalist" name="diagnosa"
                        fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm"
                        label="Diagnosa">
                    </x-adminlte-input>
                    <datalist id="diagnosalist">
                        @foreach ($diagnosas as $item)
                            <option value="{{ $item['kode'] }}">{{ $item['nama'] }}</option>
                        @endforeach
                    </datalist>
                    <x-adminlte-select wire:model="jeniskunjungan" fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" name="jeniskunjungan" label="Jenis Kunjungan">
                        <option value=null disabled>Pilih Jenis Rujukan</option>
                        <option value="1">
                            Rujukan FKTP</option>
                        <option value="2">
                            Umum</option>
                        <option value="3">
                            Kontrol</option>
                        <option value="4">
                            Rujukan Antar RS</option>
                    </x-adminlte-select>
                    @if ($antrian->jenispasien == 'JKN')
                        <x-adminlte-input wire:model="nomorreferensi" name="nomorreferensi" fgroup-class="row"
                            label-class="text-left col-4" igroup-class="col-8" igroup-size="sm"
                            label="Nomor Referensi" />
                        <x-adminlte-input wire:model="sep" name="sep" fgroup-class="row"
                            label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" label="Nomor SEP" />
                    @endif
                </div>
            </div>
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button theme="success" icon="fas fa-save" class="btn-sm" label="Simpan"
                wire:click="editKunjungan" wire:confirm='Apakah anda yakin akan menyimpan data kunjungan ?' />
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
