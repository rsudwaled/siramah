<div class="row">
    @if (flash()->message)
        <div class="col-md-12">
            <x-adminlte-alert theme="{{ flash()->class }}" title="{{ flash()->class }} !" dismissable>
                {{ flash()->message }}
            </x-adminlte-alert>
        </div>
    @endif
    @if ($openmodalSK)
        <div class="col-md-6">
            <x-adminlte-card title="Surat Kontrol" theme="secondary">
                @if ($noSuratKontrol)
                    <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                        igroup-size="sm" wire:model='noSuratKontrol' name="noSuratKontrol" label="No Surat Kontrol" />
                @endif
                <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                    wire:model='nomorkartu' name="nomorkartu" label="Nomor Kartu" />
                <x-adminlte-select fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                    igroup-size="sm" name="noSEP" wire:model='noSEP' label="No SEP">
                    <option value=null>Pilih No SEP</option>
                    @if ($noSEP)
                        <option value="{{ $noSEP }}">{{ $noSEP }}</option>
                    @endif
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
                    label="Tgl Rencana Kontrol" fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                    igroup-size="sm" />
                <x-adminlte-select fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                    igroup-size="sm" name="poliKontrol" wire:model='poliKontrol' label="Poli Kontrol">
                    <option value=null>Pilih Poli Kontrol</option>
                    @if ($poliKontrol)
                        <option value="{{ $poliKontrol }}">{{ $poliKontrol }}</option>
                    @endif
                    @foreach ($polis as $key => $item)
                        <option value="{{ $item['kodePoli'] }}">{{ $item['namaPoli'] }} ({{ $item['persentase'] }}
                            %)
                        </option>
                    @endforeach
                    <x-slot name="appendSlot">
                        <div class="btn btn-primary" wire:click='cariPoli'>
                            <i class="fas fa-search"></i> Cari
                        </div>
                    </x-slot>
                </x-adminlte-select>
                <x-adminlte-select fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                    igroup-size="sm" name="kodeDokter" wire:model='kodeDokter' label="Dokter">
                    <option value=null>Pilih Poli Kontrol</option>
                    @if ($kodeDokter)
                        <option value="{{ $kodeDokter }}">{{ $kodeDokter }}</option>
                    @endif
                    @foreach ($dokters as $key => $item)
                        <option value="{{ $item['kodeDokter'] }}">{{ $item['namaDokter'] }}
                            ({{ $item['jadwalPraktek'] }})
                        </option>
                    @endforeach
                    <x-slot name="appendSlot">
                        <div class="btn btn-primary" wire:click='cariDokter'>
                            <i class="fas fa-search"></i> Cari
                        </div>
                    </x-slot>
                </x-adminlte-select>
                <x-slot name="footerSlot">
                    <x-adminlte-button theme="success" icon="fas fa-save" class="btn-sm" label="Simpan"
                        wire:click="buatSuratKontrol" wire:confirm='Apakah anda yakin ingin membuat surat kontrol ?' />
                    <x-adminlte-button wire:click='modalSK' theme="danger" class="btn-sm" icon="fas fa-times"
                        label="Tutup" />
                    <div wire:loading>
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                        </div>
                        Loading ...
                    </div>
                </x-slot>
            </x-adminlte-card>
        </div>
    @endif
    @if ($openmodalSPRI)
        <div class="col-md-6">
            <x-adminlte-card title="SPRI Surat Perintah Rawat Inap" theme="secondary">
            </x-adminlte-card>
        </div>
    @endif
    <div class="col-md-12">
        <x-adminlte-card title="Table Rencana Kontrol / SPRI" theme="secondary">
            <div class="row">
                <div class="col-md-3">
                    <x-adminlte-select wire:model="formatfilter" fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" name="formatfilter" label="Format Filter">
                        <option value=null disabled>Pilih Format Filter</option>
                        <option value="1">Tanggal Entri</option>
                        <option value="2">Tanggal Rencana Kontrol</option>
                    </x-adminlte-select>
                </div>
                <div class="col-md-3">
                    <x-adminlte-input wire:model="tanggalAwal" type="date" name="tanggalAwal" fgroup-class="row"
                        label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" label="Tgl Awal">
                    </x-adminlte-input>
                </div>
                <div class="col-md-3">
                    <x-adminlte-input wire:model="tanggalAkhir" type="date" name="tanggalAkhir"
                        fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm"
                        label="Tgl Akhir">
                        <x-slot name="appendSlot">
                            <x-adminlte-button wire:click='cariDataSuratKontrol' theme="primary" label="Cari" />
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-md-3">
                    <x-adminlte-button theme="success" class="btn-sm" label="Buat S. Kontrol"
                        icon="fas fa-file-medical" wire:click='modalSK' />
                    <x-adminlte-button theme="success" class="btn-sm" label="Buat SPRI" wire:click='modalBuatSPRI'
                        icon="fas fa-file-medical" wire:click='modalSPRI' />
                </div>
            </div>
            <div wire:loading class="col-md-12">
                @include('components.placeholder.placeholder-text')
            </div>
            <div wire:loading.remove>
                <table class="table text-nowrap table-sm table-hover table-bordered table-responsive mb-3">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>noSuratKontrol</th>
                            <th>Action</th>
                            <th>jnsPelayanan</th>
                            <th>namaJnsKontrol</th>
                            <th>tglRencanaKontrol</th>
                            <th>tglTerbitKontrol</th>
                            <th>tglSEP</th>
                            <th>noSepAsalKontrol</th>
                            <th>namaPoliAsal</th>
                            <th>namaPoliTujuan</th>
                            <th>namaDokter</th>
                            <th>noKartu</th>
                            <th>nama</th>
                            <th>terbitSEP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suratkontrols as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->noSuratKontrol }}</td>
                                <td>
                                    <a target="_blank"
                                        href="{{ route('vclaim.suratkontrol_print') }}?noSuratKontrol={{ $item->noSuratKontrol }}">
                                        <x-adminlte-button theme="success" class="btn-xs" icon="fas fa-print" />
                                    </a>
                                    <x-adminlte-button theme="warning" class="btn-xs"
                                        wire:click="editSurat('{{ $item->noSuratKontrol }}')" icon="fas fa-edit" />
                                    <x-adminlte-button theme="danger" class="btn-xs"
                                        wire:click="hapusSurat('{{ $item->noSuratKontrol }}')"
                                        wire:confirm='Apakah anda yakin ingin menghapus surat teresebut ?'
                                        icon="fas fa-trash" />
                                </td>
                                <td>{{ $item->jnsPelayanan }}</td>
                                <td>{{ $item->namaJnsKontrol }}</td>
                                <td>{{ $item->tglRencanaKontrol }}</td>
                                <td>{{ $item->tglTerbitKontrol }}</td>
                                <td>{{ $item->tglSEP }}</td>
                                <td>{{ $item->noSepAsalKontrol }}</td>
                                <td>{{ $item->namaPoliAsal }}</td>
                                <td>{{ $item->namaPoliTujuan }}</td>
                                <td>{{ $item->namaDokter }}</td>
                                <td>{{ $item->noKartu }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->terbitSEP }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </x-adminlte-card>
    </div>
</div>
