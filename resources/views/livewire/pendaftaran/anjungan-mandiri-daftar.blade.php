<div class="row">
    <div class="col-md-12">
        <div class="card">
            <header class="bg-green text-white p-2">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <img src="{{ asset('vendor/adminlte/dist/img/logo rsudwaled bulet.png') }}" height="90"
                                    alt="">
                                <div class="col">
                                    <h1>RSUD Waled</h1>
                                    <h4>Rumah Sakit Umum Daerah Waled</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h4>Anjungan Pelayanan Mandiri</h4>
                            <h6>{{ \Carbon\Carbon::now() }}</h6>
                        </div>
                    </div>
                </div>
            </header>
        </div>
    </div>
    @if ($jenispasien == 'JKN')
        <div class="col-md-7">
            <x-adminlte-card title="Pendafataran Mandiri Pasien BPJS" class="m-2" theme="primary">
                <h4>Silahkan lengkapi form berikut :</h4>
                @if (flash()->message)
                    <x-adminlte-alert theme="{{ flash()->class }}" title="{{ flash()->class }}">
                        {{ flash()->message }}
                    </x-adminlte-alert>
                @endif
                <div class="form-group">
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" wire:model.live='inputidentitas'
                            value="nik" id="customRadio1" name="customRadio">
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
                        <x-adminlte-button class="withLoad" label="Kembali" theme="danger"
                            icon="fas fa-arrow-left" />
                    </a>
                    @if ($jadwaldokter)
                        <x-adminlte-button wire:click='daftar' label="Daftar" theme="success"
                            icon="fas fa-user-plus" />
                    @endif
                    @if ($antriansebelumnya)
                        <a href="{{ route('karcis.antrian', $antriansebelumnya->kodebooking) }}">
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
            <x-adminlte-card title="Cara Pendafataran Melalui MJKN" class="m-2" theme="primary">
                <div class="text-center">
                    <img src="{{ asset('portalbpjs.jpg') }}" width="40%" alt="">
                    <br>
                </div>
            </x-adminlte-card>
        </div>
    @else
        <div class="col-md-12">
            <x-adminlte-card title="Pendafataran Pasien Umum" class="m-2" theme="primary">
                <div wire:loading.remove>
                    @if (flash()->message)
                        <x-adminlte-alert theme="{{ flash()->class }}" title="{{ flash()->class }}">
                            {{ flash()->message }}
                        </x-adminlte-alert>
                    @endif
                    <h4>Silahkan Pilih Poliklinik : </h4>
                    <div class="row">
                        @if (!$namasubspesialis)
                            @foreach ($jadwals->groupby('namasubspesialis') as $key => $jadwal)
                                <div class="col-md-3">
                                    <a href="#" wire:click="pilihPoliUmum('{{ $key }}')">
                                        <x-adminlte-card body-class="bg-warning">
                                            <b>{{ strtoupper($key) }}</b>
                                        </x-adminlte-card>
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <div class="col-md-3">
                                <a href="#" wire:click="pilihPoliUmum('{{ $namasubspesialis }}')">
                                    <x-adminlte-card body-class="bg-warning">
                                        <b>{{ strtoupper($namasubspesialis) }}</b>
                                    </x-adminlte-card>
                                </a>
                            </div>
                        @endif
                    </div>
                    @if ($namasubspesialis)
                        <h4>Silahkan pilih dokter : </h4>
                        <div class="row">
                            @foreach ($jadwaldokters as $jadwaldokter)
                                @if ($jadwaldokter->libur)
                                    <div class="col-md-3">
                                        <a href="#">
                                            <x-adminlte-card body-class="bg-danger">
                                                <b>{{ strtoupper($jadwaldokter->namadokter) }}</b><br>
                                                <b>{{ strtoupper($jadwaldokter->jadwal) }}
                                                    {{ $jadwaldokter->libur ? '(TUTUP)' : null }}</b><br>
                                                KUOTA {{ $jadwaldokter->kapasitaspasien }}
                                            </x-adminlte-card>
                                        </a>
                                    </div>
                                @else
                                    <div class="col-md-3">
                                        <a href="#" wire:click="pilihDokterUmum('{{ $jadwaldokter->id }}')">
                                            <x-adminlte-card body-class="bg-warning">
                                                <b>{{ strtoupper($jadwaldokter->namadokter) }}</b><br>
                                                <b>{{ strtoupper($jadwaldokter->jadwal) }}</b><br>
                                                KUOTA {{ $jadwaldokter->kapasitaspasien }}
                                            </x-adminlte-card>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
                <div wire:loading>
                    <h2>Loading...</h2>
                </div>
                <x-slot name="footerSlot">
                    <a href="{{ route('anjungan.mandiri') }}">
                        <x-adminlte-button class="withLoad" label="Kembali" theme="danger"
                            icon="fas fa-arrow-left" />
                    </a>
                </x-slot>
            </x-adminlte-card>
        </div>
    @endif
</div>
