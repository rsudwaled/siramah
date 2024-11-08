<div>
    <x-adminlte-card theme="primary" title="Surat Kontrol Pasien">
        <div class="row">
            <div class="col-md-3">
                <x-adminlte-input wire:model="nomorkartu" name="nomorkartu" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="No BPJS">
                </x-adminlte-input>
            </div>
            <div class="col-md-3">
                <x-adminlte-select wire:model="formatfilter" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" name="formatfilter" label="Filter">
                    <option value=null disabled>Pilih Format Filter</option>
                    <option value="2">Tanggal Rencana Kontrol</option>
                    <option value="1">Tanggal Entri</option>
                </x-adminlte-select>
            </div>
            <div class="col-md-4">
                <x-adminlte-input wire:model="tanggal" type="month" name="tanggal" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" label="Bulan Tahun">
                    <x-slot name="appendSlot">
                        <x-adminlte-button wire:click='cariDataSuratKontrol' theme="primary" label="Cari" />
                    </x-slot>
                </x-adminlte-input>
            </div>
        </div>
        @if ($suratkontrols)
            <table class="table table-sm table-responsive table-bordered text-nowrap">
                <thead>
                    <tr>
                        <th>No Surat</th>
                        <th>Tgl Kontrol</th>
                        <th>Tgl Terbit</th>
                        <th>Action</th>
                        <th>Pelayanan</th>
                        <th>Jns Surat</th>
                        <th>Poli Asal</th>
                        <th>Poli Tujuan</th>
                        <th>Dokter</th>
                        <th>Terbit SEP</th>
                        <th>No SEP Asal</th>
                        <th>Tgl SEP Asal</th>
                        <th>No Kartu</th>
                        <th>Nama</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($suratkontrols as $item)
                        <tr>
                            <td>{{ $item->noSuratKontrol }}</td>
                            <td>{{ $item->tglRencanaKontrol }}</td>
                            <td>{{ $item->tglTerbitKontrol }}</td>
                            <td>

                                @if ($item->namaJnsKontrol == 'SPRI')
                                    <a target="_blank"
                                        href="{{ route('vclaim.spri_print') }}?noSuratKontrol={{ $item->noSuratKontrol }}&noKartu={{ $nomorkartu }}">
                                        <x-adminlte-button theme="success" class="btn-xs" icon="fas fa-print" />
                                    </a>
                                    <x-adminlte-button theme="warning" class="btn-xs"
                                        wire:click="editSPRI('{{ $item->noSuratKontrol }}')" icon="fas fa-edit" />
                                @else
                                    <a target="_blank"
                                        href="{{ route('vclaim.suratkontrol_print') }}?noSuratKontrol={{ $item->noSuratKontrol }}">
                                        <x-adminlte-button theme="success" class="btn-xs" icon="fas fa-print" />
                                    </a>
                                    <x-adminlte-button theme="warning" class="btn-xs"
                                        wire:click="editSurat('{{ $item->noSuratKontrol }}','{{ $item->noSepAsalKontrol }}')"
                                        icon="fas fa-edit" />
                                @endif
                                <x-adminlte-button theme="danger" class="btn-xs"
                                    wire:click="hapusSurat('{{ $item->noSuratKontrol }}')"
                                    wire:confirm='Apakah anda yakin ingin menghapus surat teresebut ?'
                                    icon="fas fa-trash" />
                            </td>
                            <td>{{ $item->jnsPelayanan }}</td>
                            <td>{{ $item->namaJnsKontrol }}</td>
                            <td>{{ $item->namaPoliAsal }}</td>
                            <td>{{ $item->namaPoliTujuan }}</td>
                            <td>{{ $item->namaDokter }} {{ $item->kodeDokter }}</td>
                            <td>{{ $item->terbitSEP }}</td>
                            <td>{{ $item->noSepAsalKontrol }}</td>
                            <td>{{ $item->tglSEP }}</td>
                            <td>{{ $item->noKartu }}</td>
                            <td>{{ $item->nama }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        <x-slot name="footerSlot">
            <x-adminlte-button theme="success" icon="fas fa-plus" class="btn-sm" label="Buat Surat Kontrol"
                wire:click="buatSuratKontrol" />
            <x-adminlte-button theme="success" icon="fas fa-plus" class="btn-sm" label="Buat SPRI"
                wire:click="buatSPRI" />
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
    @if ($formSuratKontrol)
        <x-adminlte-card theme="success" title="Pembuatan Surat Kontrol Pasien">
            <div class="row">
                <div class="col-md-6">
                    @if ($noSuratKontrol)
                        <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                            igroup-size="sm" wire:model='noSuratKontrol' name="noSuratKontrol" label="noSuratKontrol"
                            readonly />
                    @endif
                    <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                        igroup-size="sm" wire:model='nomorkartu' name="nomorkartu" label="Nomor Kartu" />
                    <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                        igroup-size="sm" wire:model='nohp' name="nohp" label="No HP" />
                    <x-adminlte-select fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                        igroup-size="sm" name="noSEP" wire:model='noSEP' wire:click='cariSEP' label="No SEP">
                        <option value=null>Pilih No SEP</option>
                        @foreach ($seps as $key => $item)
                            <option value="{{ $item['noSep'] }}">{{ $item['noSep'] }}
                                {{ $item['tglSep'] }} {{ $item['poli'] }} {{ $item['ppkPelayanan'] }}</option>
                        @endforeach
                        <x-slot name="appendSlot">
                            <div class="btn btn-primary" wire:click='cariSEP'>
                                <i class="fas fa-search"></i> Cari
                            </div>
                        </x-slot>
                    </x-adminlte-select>
                    <x-adminlte-input wire:model='tglRencanaKontrol' name="tglRencanaKontrol" type='date'
                        label="Tgl Rencana Kontrol" fgroup-class="row" label-class="text-left col-3"
                        igroup-class="col-9" igroup-size="sm" />
                    <x-adminlte-select fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                        igroup-size="sm" name="poliKontrol" wire:model='poliKontrol' wire:click='cariPoli'
                        label="Poli Kontrol">
                        <option value=null>Pilih Poli Kontrol</option>
                        {{-- @foreach ($polis as $key => $item)
                            <option value="{{ $item['kodePoli'] }}">{{ $item['namaPoli'] }}
                                ({{ $item['persentase'] }} %)
                            </option>
                        @endforeach --}}
                        <x-slot name="appendSlot">
                            <div class="btn btn-primary" wire:click='cariPoli'>
                                <i class="fas fa-search"></i> Cari
                            </div>
                        </x-slot>
                    </x-adminlte-select>
                    <x-adminlte-select fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                        igroup-size="sm" name="kodeDokter" wire:model='kodeDokter' wire:click='cariDokter'
                        label="Dokter">
                        <option value=null>Pilih Poli Kontrol</option>
                        {{-- @foreach ($dokters as $key => $item)
                            <option value="{{ $item['kodeDokter'] }}|{{ $item['jadwalPraktek'] }}">
                                {{ $item['namaDokter'] }}
                                ({{ $item['jadwalPraktek'] }})
                            </option>
                        @endforeach --}}
                        <x-slot name="appendSlot">
                            <div class="btn btn-primary" wire:click='cariDokter'>
                                <i class="fas fa-search"></i> Cari
                            </div>
                        </x-slot>
                    </x-adminlte-select>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" wire:model='daftarantrian'
                                id="daftarantrian" value="1">
                            <label for="daftarantrian" class="custom-control-label">Daftarkan Antrian MJKN</label>
                        </div>
                    </div>
                </div>
            </div>
            <x-slot name="footerSlot">
                <x-adminlte-button theme="success" icon="fas fa-save" class="btn-sm" label="Simpan"
                    wire:click="insertSuratKontrol" wire:confirm='Apakah anda yakin ingin membuat surat kontrol ?' />
                <x-adminlte-button theme="danger" icon="fas fa-times" class="btn-sm" label="Tutup"
                    wire:click="buatSuratKontrol" />
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
    @if ($formSpri)
        <x-adminlte-card theme="success" title="Pembuatan SPRI (Surat Perintah Rawat Inap)">
            <div class="row">
                <div class="col-md-6">
                    @if ($noSPRI)
                        <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                            igroup-size="sm" wire:model='noSPRI' name="noSPRI" label="noSPRI" readonly />
                    @endif
                    <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                        igroup-size="sm" wire:model='nomorkartu' name="nomorkartu" label="Nomor Kartu" />
                    <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                        igroup-size="sm" wire:model='nohp' name="nohp" label="No HP" />
                    <x-adminlte-select fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                        igroup-size="sm" name="kodeDokter" wire:model='kodeDokter' label="Dokter">
                        <option value=null>Pilih Dokter DPJP</option>
                        {{-- @foreach ($dokterss as $key => $nama)
                            <option value="{{ $key }}">{{ $nama }}</option>
                        @endforeach --}}
                    </x-adminlte-select>
                    <x-adminlte-select fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                        igroup-size="sm" name="poliKontrol" wire:model='poliKontrol' label="Poliklinik">
                        <option value=null>Pilih Poliklinik</option>
                        {{-- @foreach ($units as $key => $nama)
                            <option value="{{ $key }}">{{ $nama }}</option>
                        @endforeach --}}
                    </x-adminlte-select>
                    <x-adminlte-input wire:model='tglRencanaKontrol' name="tglRencanaKontrol" type='date'
                        label="Tgl Rawat Inap" fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                        igroup-size="sm" />
                </div>
            </div>
            <x-slot name="footerSlot">
                <x-adminlte-button theme="success" icon="fas fa-save" class="btn-sm" label="Simpan"
                    wire:click="insertSPRI" wire:confirm='Apakah anda yakin ingin membuat SPRI ?' />
                <x-adminlte-button theme="danger" icon="fas fa-times" class="btn-sm" label="Tutup"
                    wire:click="buatSuratKontrol" />
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
