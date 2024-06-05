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
                    <x-adminlte-input wire:model="nomorkartu" name="nomorkartu" igroup-size="sm"
                        placholder="Nomor Kartu BPJS">
                        <x-slot name="appendSlot">
                            <x-adminlte-button wire:click='cari' theme="primary" label="Cari" />
                        </x-slot>
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-id-card"></i>
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
                <table class="table text-nowrap table-sm table-hover table-bordered table-responsive mb-3">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>noSep</th>
                            <th>tglSep</th>
                            <th>tglPlgSep</th>
                            <th>noKartu</th>
                            <th>namaPeserta</th>
                            <th>jnsPelayanan</th>
                            <th>kelasRawat</th>
                            <th>diagnosa</th>
                            <th>poli</th>
                            <th>ppkPelayanan</th>
                            <th>noRujukan</th>
                            <th>flag</th>
                            <th>asuransi</th>
                            <th>poliTujSep</th>
                        </tr>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kunjungans as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->noSep }}</td>
                                <td>{{ $item->tglSep }}</td>
                                <td>{{ $item->tglPlgSep }}</td>
                                <td>{{ $item->noKartu }}</td>
                                <td>{{ $item->namaPeserta }}</td>
                                <td>{{ $item->jnsPelayanan }}</td>
                                <td>{{ $item->kelasRawat }}</td>
                                <td>{{ $item->diagnosa }}</td>
                                <td>{{ $item->poli }}</td>
                                <td>{{ $item->ppkPelayanan }}</td>
                                <td>{{ $item->noRujukan }}</td>
                                <td>{{ $item->flag }}</td>
                                <td>{{ $item->asuransi }}</td>
                                <td>{{ $item->poliTujSep }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-adminlte-card>
    </div>
</div>
