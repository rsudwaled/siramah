<div class="row p-1">
    <x-header-anjungan-antrian />
    <div class="col-md-7">
        <x-adminlte-card title="Pendafataran Mandiri Pasien BPJS" theme="success">
            <h4>Silahkan lengkapi form berikut :</h4>
            @if (flash()->message)
                <x-adminlte-alert theme="{{ flash()->class }}" title="{{ flash()->class }}">
                    {{ flash()->message }}
                </x-adminlte-alert>
            @endif
            <div class="form-group">
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" wire:model.live='inputidentitas' value="nik"
                        id="customRadio1" name="customRadio">
                    <label for="customRadio1" class="custom-control-label">NIK Pasien</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" wire:model.live='inputidentitas'
                        value="nomorkartu" id="customRadio2" name="customRadio">
                    <label for="customRadio2" class="custom-control-label">Nomor Kartu BPJS</label>
                </div>
            </div>
            @if ($inputidentitas == 'nik')
                <x-adminlte-input wire:model='nik' name="nik" placeholder="Masukan NIK Pasien" igroup-size="lg">
                    <x-slot name="appendSlot">
                        <x-adminlte-button wire:click='cariPasien' theme="primary" label="Cari" />
                    </x-slot>
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-primary">
                            <i class="fas fa-user"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            @else
                <x-adminlte-input wire:model='nomorkartu' name="nomorkartu" placeholder="Masukan Nomor BPJS Pasien"
                    igroup-size="lg">
                    <x-slot name="appendSlot">
                        <x-adminlte-button wire:click='cariPasien' theme="primary" label="Cari" />
                    </x-slot>
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-primary">
                            <i class="fas fa-user"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            @endif
            @if ($keyInput)
                <div class="btn-group mb-3" role="group" aria-label="Basic example">
                    @for ($i = 0; $i <= 9; $i++)
                        <button type="button" class="btn btn-lg btn-secondary mr-1"
                            wire:click="addDigit('{{ $i }}')">{{ $i }}</button>
                    @endfor
                    <button type="button" class="btn btn-danger btn-lg" wire:click="deleteDigit()">Hapus</button>
                </div>
            @endif
            @if (count($rujukans) || count($suratkontrols) || count($rujukanrs))
                @if (!$nomorreferensi)
                    <h4>Silahkan pilih Rujukan atau Surat Kontrol :</h4>
                    @foreach ($rujukans as $item)
                        <a href="#"
                            wire:click="pilihSurat('{{ $item->noKunjungan }}', '1', '{{ $item->poliRujukan->kode }}')">
                            <x-adminlte-card class="mb-2 withLoad" body-class="bg-warning">
                                <h5>SURAT RUJUKAN POLIKLINIK {{ $item->poliRujukan->nama }} </h5>
                                Asal Rujukan {{ $item->provPerujuk->nama }}
                                Nomor Rujukan :{{ $item->noKunjungan }}
                                Tanggal Rujukan {{ $item->tglKunjungan }}
                            </x-adminlte-card>
                        </a>
                    @endforeach
                    @foreach ($rujukanrs as $item)
                        <a href="#"
                            wire:click="pilihSurat('{{ $item->noKunjungan }}', '4', '{{ $item->poliRujukan->kode }}')">
                            <x-adminlte-card class="mb-2 withLoad" body-class="bg-warning">
                                <h5>SURAT RUJUKAN POLIKLINIK {{ $item->poliRujukan->nama }} </h5>
                                Asal Rujukan {{ $item->provPerujuk->nama }}
                                Nomor Rujukan :{{ $item->noKunjungan }}
                                Tanggal Rujukan {{ $item->tglKunjungan }}
                            </x-adminlte-card>
                        </a>
                    @endforeach
                    @foreach ($suratkontrols as $item)
                        <a href="#"
                            wire:click="pilihSurat('{{ $item->noSuratKontrol }}', '3','{{ $item->poliTujuan }}')">
                            <x-adminlte-card class="mb-2 withLoad" body-class="bg-warning">
                                <h5>SURAT KONTROL POLIKLINIK {{ $item->namaPoliTujuan }} </h5>
                                Jenis Pelayanan {{ $item->jnsPelayanan }}
                                Tgl Kontrol {{ $item->tglRencanaKontrol }}
                                Nomor Surat Kontrol {{ $item->noSuratKontrol }}
                                {{ $item->terbitSEP }} Dipakai
                            </x-adminlte-card>
                        </a>
                    @endforeach
                    <br>
                @endif
                <x-adminlte-input wire:model='nomorreferensi' name="nomorreferensi"
                    placeholder="Nomor Rujukan / Surat Kontrol" igroup-size="lg">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-primary">
                            <i class="fas fa-file-medical"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-select wire:model.live='kodepoli' name="kodepoli" igroup-size="lg">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-primary">
                            <i class="fas fa-clinic-medical"></i>
                        </div>
                    </x-slot>
                    <option selected value="">--Pilih Poliklinik--</option>
                    @foreach ($polikliniks as $item)
                        <option value="{{ $item->KDPOLI }}">{{ $item->nama_unit }}</option>
                    @endforeach
                </x-adminlte-select>
                <x-adminlte-select wire:model.live='jadwaldokter' name="jadwaldokter" igroup-size="lg">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-primary">
                            <i class="fas fa-user-md"></i>
                        </div>
                    </x-slot>
                    <option selected value="">--Pilih Jadwal Dokter--</option>
                    @foreach ($jadwals as $item)
                        <option value="{{ $item->id }}">{{ $item->jadwal }} {{ $item->namadokter }}
                        </option>
                    @endforeach
                </x-adminlte-select>
            @endif
            <x-slot name="footerSlot">
                <a href="{{ route('anjungan.mandiri') }}">
                    <x-adminlte-button class="withLoad" label="Kembali" theme="danger" icon="fas fa-arrow-left" />
                </a>
                @if ($jadwaldokter)
                    <x-adminlte-button wire:loading.remove wire:click='daftar' label="Daftar" theme="success"
                        icon="fas fa-user-plus" />
                @endif
                @if ($antriansebelumnya)
                    <a href="{{ route('karcis.antrian', $antriansebelumnya->kodebooking) }}" wire:loading.remove>
                        <x-adminlte-button label="Cetak Ulang" theme="warning" icon="fas fa-print" />
                    </a>
                @endif
                <div wire:loading>
                    <h5>Loading...</h5>
                </div>
            </x-slot>
        </x-adminlte-card>
    </div>
    <div class="col-md-5">
        <x-adminlte-card title="Cara Pendafataran Melalui MJKN" theme="success">
            <div class="text-center">
                <img src="{{ asset('portalbpjs.jpg') }}" width="40%" alt="">
                <br>
            </div>
        </x-adminlte-card>
    </div>
</div>
