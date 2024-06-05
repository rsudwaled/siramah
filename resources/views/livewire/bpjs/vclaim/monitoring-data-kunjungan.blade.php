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
                    <x-adminlte-input wire:model="tanggal" type="date" name="tanggal" igroup-size="sm">
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
                <div class="col-md-6">
                </div>
            </div>
            <div wire:loading class="col-md-12">
                @include('components.placeholder.placeholder-text')
            </div>
            <div wire:loading.remove>
                <table class="table text-nowrap table-sm table-hover table-bordered table-responsive-xl mb-3">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No SEP</th>
                            <th>Tanggal SEP</th>
                            <th>Tanggal Pulang</th>
                            <th>Pelayanan</th>
                            <th>Kelas Rawat</th>
                            <th>No Kartu</th>
                            <th>Nama</th>
                            <th>Poli</th>
                            <th>Diagnosa</th>
                            <th>No Rujukan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kunjungans as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->noSep }}</td>
                                <td>{{ $item->tglSep }}</td>
                                <td>{{ $item->tglPlgSep }}</td>
                                <td>{{ $item->jnsPelayanan }}</td>
                                <td>{{ $item->kelasRawat }}</td>
                                <td>{{ $item->noKartu }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->poli }}</td>
                                <td>{{ $item->diagnosa }}</td>
                                <td>{{ $item->noRujukan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-adminlte-card>
    </div>
</div>
