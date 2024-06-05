<div class="row">
    @if (flash()->message)
        <div class="col-md-12">
            <x-adminlte-alert theme="{{ flash()->class }}" title="{{ flash()->class }} !" dismissable>
                {{ flash()->message }}
            </x-adminlte-alert>
        </div>
    @endif
    <div class="col-md-12">
        <x-adminlte-card title="Table Referensi Dokter" theme="secondary">
            <div class="row">
                <div class="col-md-3">
                    <x-adminlte-select wire:model="jenispelayanan" fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" name="jenispelayanan">
                        <option value=null disabled>Pilih Jenis Pelayanan</option>
                        <option value="1">Rawat Inap</option>
                        <option value="2">Rawat Jalan</option>
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-hospital"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-select>
                </div>
                <div class="col-md-3">
                    <x-adminlte-input wire:model="tanggalmulai" type="date" name="tanggalmulai" igroup-size="sm">
                        <x-slot name="appendSlot">
                            <x-adminlte-button wire:click='cari' theme="primary" label="Cari" />
                        </x-slot>
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-md-3">
                    <x-adminlte-input wire:model="tanggalakhir" type="date" name="tanggalakhir" igroup-size="sm">
                        <x-slot name="appendSlot">
                            <x-adminlte-button wire:click='cari' theme="primary" label="Cari" />
                        </x-slot>
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
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
                            <th>noFPK</th>
                            <th>tglSep</th>
                            <th>tglPulang</th>
                            <th>noSEP</th>
                            <th>kelasRawat</th>
                            <th>poli</th>
                            <th>status</th>
                            <th>byPengajuan</th>
                            <th>byTarifGruper</th>
                            <th>byTarifRS</th>
                            <th>byTopup</th>
                            <th>bySetujui</th>
                            <th>noKartu</th>
                            <th>nama</th>
                            <th>noMR</th>
                            <th>kodeInacbg</th>
                            <th>Inacbg</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kunjungans as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->noFPK }}</td>
                                <td>{{ $item->tglSep }}</td>
                                <td>{{ $item->tglPulang }}</td>
                                <td>{{ $item->noSEP }}</td>
                                <td>{{ $item->kelasRawat }}</td>
                                <td>{{ $item->poli }}</td>
                                <td>{{ $item->status }}</td>
                                <td>{{ money($item->biaya->byPengajuan, 'IDR') }}</td>
                                <td>{{ money($item->biaya->byTarifGruper, 'IDR') }}</td>
                                <td>{{ money($item->biaya->byTarifRS, 'IDR') }}</td>
                                <td>{{ money($item->biaya->byTopup, 'IDR') }}</td>
                                <td>{{ money($item->biaya->bySetujui, 'IDR') }}</td>
                                <td>{{ $item->peserta->noKartu }}</td>
                                <td>{{ $item->peserta->nama }}</td>
                                <td>{{ $item->peserta->noMR }}</td>
                                <td>{{ $item->Inacbg->kode }}</td>
                                <td>{{ $item->Inacbg->nama }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-adminlte-card>
    </div>
</div>
