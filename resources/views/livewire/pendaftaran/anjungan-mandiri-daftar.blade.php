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
    @if ($pasienbaru == 0)
        <div class="col-md-7">
            <x-adminlte-card title="Pendafataran Pasien Lama BPJS" class="m-2" theme="primary">
                <div>
                    <h3>Silahkan lengkapi form berikut :</h3>
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
                        <x-adminlte-input wire:model='nik' name="nik" placeholder="Masukan NIK Pasien"
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
                    @else
                        <x-adminlte-input wire:model='nomorkartu' name="nomorkartu"
                            placeholder="Masukan Nomor BPJS Pasien" igroup-size="lg">
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
                    @if (count($rujukans) || count($suratkontrols) || count($rujukanrs))
                        @if (!$nomorreferensi)
                            <table class="table table-bordered table-sm">
                                <tr>
                                    <th>Surat</th>
                                    <th>Nomor</th>
                                    <th>Tanggal</th>
                                    <th>Poliklinik</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                @foreach ($rujukans as $item)
                                    <tr>
                                        <th>Rujukan FKTP</th>
                                        <th>{{ $item->noKunjungan }}</th>
                                        <th>{{ $item->tglKunjungan }}</th>
                                        <th>{{ $item->poliRujukan->nama }}</th>
                                        <th>Aktif</th>
                                        <th>
                                            <x-adminlte-button wire:click="pilihSurat('{{ $item->noKunjungan }}', '1')"
                                                label="Pilih" class="btn-sm" theme="success" />
                                        </th>
                                    </tr>
                                @endforeach
                                @foreach ($suratkontrols as $item)
                                    <tr>

                                        <th>Surat Kontrol</th>
                                        <th>{{ $item->noSuratKontrol }}</th>
                                        <th>{{ $item->tglRencanaKontrol }}</th>
                                        <th>{{ $item->namaPoliTujuan }}</th>
                                        <th>{{ $item->terbitSEP }}</th>
                                        <th>
                                            <x-adminlte-button
                                                wire:click="pilihSurat('{{ $item->noSuratKontrol }}', '3')"
                                                label="Pilih" class="btn-sm" theme="success" />
                                        </th>
                                    </tr>
                                @endforeach
                                @foreach ($rujukanrs as $item)
                                    <tr>
                                        <th>Rujukan RS</th>
                                        <th>{{ $item->noKunjungan }}</th>
                                        <th>{{ $item->tglKunjungan }}</th>
                                        <th>{{ $item->poliRujukan->nama }}</th>
                                        <th>Aktif</th>
                                        <th>
                                            <x-adminlte-button wire:click="pilihSurat('{{ $item->noKunjungan }}', '1')"
                                                label="Pilih" class="btn-sm" theme="success" />
                                        </th>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
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
                        <option selected value="">Pilih Poliklinik</option>
                        @foreach ($polikliniks as $item)
                            <option value="{{ $item->kodesubspesialis }}">{{ $item->namasubspesialis }}</option>
                        @endforeach
                    </x-adminlte-select>
                    <x-adminlte-select wire:model.live='jadwaldokter' name="jadwaldokter" igroup-size="lg">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-user-md"></i>
                            </div>
                        </x-slot>
                        <option selected value="">Pilih Jadwal Dokter</option>
                        @foreach ($jadwals as $item)
                            <option value="{{ $item->id }}">{{ $item->jadwal }} {{ $item->namadokter }}</option>
                        @endforeach
                    </x-adminlte-select>
                    <a href="{{ route('anjungan.mandiri') }}">
                        <x-adminlte-button class="btn-lg" label="Kembali" theme="danger" icon="fas fa-arrow-left" />
                    </a>
                    @if ($jadwaldokter)
                        <x-adminlte-button wire:click='daftar' class="btn-lg" label="Daftar" theme="primary"
                            icon="fas fa-user-plus" />
                    @endif
                    @if ($antriansebelumnya)
                        <x-adminlte-button wire:click="cetakUlang('{{ $antriansebelumnya->kodebooking }}')" class="btn-lg" label="Cetak Ulang"
                            theme="warning" icon="fas fa-print" />
                    @endif

                    <div wire:loading>
                        <h5>Loading...</h5>
                    </div>
                </div>
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
        <div class="col-md-6">
            <div class="m-2">
                <h1>PENDAFTARAN PASIEN</h1>
            </div>
            <a href="{{ route('anjungan.mandiri') }}">
                <x-adminlte-card class="m-2" body-class="bg-danger">
                    <h1>KEMBALI</h1>
                </x-adminlte-card>
            </a>
        </div>
        <div class="col-md-6">
            <x-adminlte-card title="Cara Pendafataran Melalui MJKN" class="m-2" theme="primary">
                <div class="text-center">
                    <img src="{{ asset('portalbpjs.jpg') }}" width="40%" alt="">
                    <br>
                </div>
            </x-adminlte-card>
        </div>
    @endif
</div>
