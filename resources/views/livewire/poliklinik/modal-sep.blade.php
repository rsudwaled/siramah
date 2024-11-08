<div>
    <x-adminlte-card theme="primary" title="SEP Pasien">
        <div class="row">
            <div class="col-md-4">
                <x-adminlte-input wire:model="nomorkartu" name="nomorkartu" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="No BPJS">
                    <x-slot name="appendSlot">
                        <x-adminlte-button wire:click='cariSEP' theme="primary" label="Cari" />
                    </x-slot>
                </x-adminlte-input>
            </div>
        </div>
        @if ($seps)
            <table class="table table-sm table-responsive table-bordered text-nowrap">
                <thead>
                    <tr>
                        <th>No SEP</th>
                        <th>Tgl Masuk</th>
                        <th>Tgl Pulang</th>
                        <th>Action</th>
                        <th>No Kartu</th>
                        <th>Nama</th>
                        <th>Pelayanan</th>
                        <th>Kelas</th>
                        <th>Poli</th>
                        <th>PPK Pelayanan</th>
                        <th>No Rujukan</th>
                        <th>Poli Tujuan SEP</th>
                        <th>Diagnosa</th>
                        <th>Flag</th>
                        <th>Asuransi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($seps as $item)
                        <tr>
                            <td>{{ $item->noSep }}</td>
                            <td>{{ $item->tglSep }}</td>
                            <td>{{ $item->tglPlgSep }}</td>
                            <th>
                                <a target="_blank" href="{{ route('vclaim.sep_print') }}?noSep={{ $item->noSep }}">
                                    <x-adminlte-button theme="success" class="btn-xs" icon="fas fa-print" />
                                </a>
                                {{-- <x-adminlte-button theme="warning" class="btn-xs"
                                        wire:click="editSurat('{{ $item->noSep }}')" icon="fas fa-edit" /> --}}
                                <x-adminlte-button theme="danger" class="btn-xs"
                                    wire:click="hapusSurat('{{ $item->noSep }}')"
                                    wire:confirm='Apakah anda yakin ingin menghapus surat teresebut ?'
                                    icon="fas fa-trash" />
                            </th>
                            <td>{{ $item->noKartu }}</td>
                            <td>{{ $item->namaPeserta }}</td>
                            <td>
                                @switch($item->jnsPelayanan)
                                    @case(1)
                                        Rawat Inap
                                    @break

                                    @case(2)
                                        Rawat Jalan
                                    @break

                                    @default
                                        -
                                @endswitch

                            </td>
                            <td>{{ $item->kelasRawat }}</td>
                            <td>{{ $item->poli }}</td>
                            <td>{{ $item->ppkPelayanan }}</td>
                            <td>{{ $item->noRujukan }}</td>
                            <td>{{ $item->poliTujSep }}</td>
                            <td>{{ $item->diagnosa }}</td>
                            <td>{{ $item->flag }}</td>
                            <td>{{ $item->asuransi }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
        @endif
        @if ($kunjungan->sep)
            <iframe src="{{ route('vclaim.sep_print') }}?noSep={{ $kunjungan->sep }}" width="100%" height="300"
                frameborder="0"></iframe>
        @endif
        <x-slot name="footerSlot">
            <x-adminlte-button theme="success" icon="fas fa-plus" class="btn-sm" label="Buat SEP"
                wire:click="openForm" />
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
    @if ($form)
        <x-adminlte-card theme="success" title="Pembuatan SEP Pasien">
            <input type="hidden" wire:model='kodebooking' name="kodebooking">
            <input type="hidden" wire:model='antrian_id' name="antrian_id">
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input wire:model='tglSep' name="tglSep" type='date' label="Tgl SEP"
                        fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
                    <x-adminlte-input wire:model='noKartu' name="noKartu" fgroup-class="row"
                        label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" label="Nomor Kartu" />
                    <x-adminlte-input wire:model='noMR' name="noMR" label="Nama Pasien" fgroup-class="row"
                        label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
                    <x-adminlte-input wire:model='nama' name="nama" label="Nama Pasien" fgroup-class="row"
                        label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
                    <x-adminlte-input wire:model='noTelp' name="noTelp" label="Nomor HP" fgroup-class="row"
                        label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
                    <x-adminlte-select fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                        igroup-size="sm" wire:model='klsRawatHak' name="klsRawatHak" label="Kelas Pelayanan">
                        <option value="">Pilih Kelas Pasien</option>
                        <option value="1">Kelas 1</option>
                        <option value="2">Kelas 2</option>
                        <option value="3">Kelas 3</option>
                    </x-adminlte-select>
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
                        <option value="">Pilih Surat Kontrol</option>
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
                </div>
                <div class="col-md-6">
                    <x-adminlte-select wire:model='jnsPelayanan' fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" name="jnsPelayanan" label="Jenis Pelayanan">
                        <option value=null disabled>Pilih Jenis Pelayanan</option>
                        <option value="2">Rawat Jalan</option>
                        <option value="1">Rawat Inap</option>
                    </x-adminlte-select>
                    <x-adminlte-select2 wire:model='tujuan' fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" name="tujuan" label="Poliklinik" required>
                        <option value="">Pilih Poliklinik</option>
                        @foreach ($polikliniks as $key => $item)
                            <option value="{{ $key }}">{{ $item }}
                            </option>
                        @endforeach
                    </x-adminlte-select2>
                    <x-adminlte-select2 wire:model='dpjpLayan' fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" name="dpjpLayan" label="Dokter DPJP" required>
                        <option value="">Pilih Dokter DPJP</option>
                        @foreach ($dokters as $key => $item)
                            <option value="{{ $key }}">{{ $item }}
                            </option>
                        @endforeach
                    </x-adminlte-select2>
                    <x-adminlte-input wire:model.live="diagAwal" list="diagawallist" name="diagAwal"
                        fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm"
                        label="Diag Awal">
                    </x-adminlte-input>
                    <datalist id="diagawallist">
                        @foreach ($diagnosas as $item)
                            <option value="{{ $item['kode'] }}">{{ $item['nama'] }}</option>
                        @endforeach
                    </datalist>
                    <x-adminlte-input wire:model='catatan' name="catatan" label="Catatan" fgroup-class="row"
                        label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
                    <x-adminlte-select wire:model='tujuanKunj' fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" name="tujuanKunj" label="Tujuan Kunjungan">
                        <option value="0">Normal</option>
                        <option value="1">Prosedur</option>
                        <option value="2">Konsul Dokter</option>
                    </x-adminlte-select>
                    <x-adminlte-select wire:model='flagProcedure' fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" name="flagProcedure" label="Flag Procedur">
                        <option value="">Normal</option>
                        <option value="0">Prosedur Tidak Berkelanjutan</option>
                        <option value="1">Prosedur dan Terapi Berkelanjutan</option>
                    </x-adminlte-select>
                    <x-adminlte-select wire:model='kdPenunjang' fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" name="kdPenunjang" label="Penunjang">
                        <option value="">Normal</option>
                        <option value="1">Radioterapi</option>
                        <option value="2">Kemoterapi</option>
                        <option value="3">Rehabilitasi Medik</option>
                        <option value="4">Rehabilitasi Psikososial</option>
                        <option value="5">Transfusi Darah</option>
                        <option value="6">Pelayanan Gigi</option>
                        <option value="7">Laboratorium</option>
                        <option value="8">USG</option>
                        <option value="9">Lain-Lain</option>
                        <option value="10">Farmasi</option>
                        <option value="11">MRI</option>
                        <option value="12">HEMODIALISA</option>
                    </x-adminlte-select>
                    <x-adminlte-select wire:model='assesmentPel' fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" name="assesmentPel" label="Assesment Pelayanan">
                        <option value="">Normal</option>
                        <option value="0">Poli tujuan beda dengan poli rujukan dan
                            hari beda
                        </option>
                        <option value="1">Poli spesialis tidak tersedia pada hari
                            sebelumnya
                        </option>
                        <option value="2">Jam Poli telah berakhir pada hari sebelumnya
                        </option>
                        <option value="3">Dokter Spesialis yang dimaksud tidak praktek
                            pada
                            hari
                            sebelumnya</option>
                        <option value="4">Atas Instruksi RS</option>
                        <option value="5">Tujuan Kontrol</option>
                    </x-adminlte-select>
                </div>
            </div>
            <x-slot name="footerSlot">
                <x-adminlte-button theme="success" icon="fas fa-save" class="btn-sm" label="Simpan"
                    wire:click="buatSEP"
                    wire:confirm='Apakah anda yakin sudah mengisi semua data untuk pembuatan SEP ?' />
                <x-adminlte-button theme="danger" icon="fas fa-times" class="btn-sm" label="Tutup"
                    wire:click="openForm" />
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
    @endif
</div>
