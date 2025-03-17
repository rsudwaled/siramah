<div class="row">
    @if (flash()->message)
        <div class="col-md-12">
            <x-adminlte-alert theme="{{ flash()->class }}" title="{{ flash()->class }} !" dismissable>
                {{ flash()->message }}
            </x-adminlte-alert>
        </div>
    @endif
    <div class="col-md-12">
        <x-adminlte-card title="Table Kunjungan Pasien" theme="secondary">
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
                    <x-adminlte-input wire:model="tanggalawal" type="date" name="tanggalawal" igroup-size="sm">
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
                <div class="col-md-3">
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
                            <th>No RM</th>
                            <th>Nama Pasien</th>
                            <th>Tgl Masuk</th>
                            <th>Tgl Keluar</th>
                            <th>No SEP</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kunjungans as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->rm_kunjungan }}</td>
                                <td>{{ $item->nama_px }}</td>
                                <td>{{ $item->tgl_masuk }}</td>
                                <td>{{ $item->tgl_keluar }}</td>
                                <td>{{ $item->no_sep }}</td>
                                <td>
                                    <x-adminlte-button wire:click="print" theme="success"
                                        icon="fas fa-print" class="btn-xs" />
                                </td>

                                {{-- <td>{{ $item->total_tarif }}</td> --}}
                                {{-- <td>{{ $item->tarif_rs }}</td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-adminlte-card>
    </div>
</div>
