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
                            <td>tanggal</td>
                            <td>noantrean</td>
                            <td>kodebooking</td>
                            <td>norekammedis</td>
                            <td>nik</td>
                            <td>nokapst</td>
                            <td>nohp</td>
                            <td>kodepoli</td>
                            <td>kodedokter</td>
                            <td>jeniskunjungan</td>
                            <td>nomorreferensi</td>
                            <td>sumberdata</td>
                            <td>status</td>
                            <td>createdtime</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($antrians as $item)
                            <tr>
                                <td>{{ $item->tanggal }}</td>
                                <td>{{ $item->noantrean }}</td>
                                <td>{{ $item->kodebooking }}</td>
                                <td>
                                    <a href="{{ route('antrian.antreankodebooking', $item->kodebooking) }}">
                                        <x-adminlte-button class="btn-xs" theme="primary" label="Lihat" />
                                    </a>
                                </td>
                                <td>{{ $item->norekammedis }}</td>
                                <td>{{ $item->nik }}</td>
                                <td>{{ $item->nokapst }}</td>
                                <td>{{ $item->nohp }}</td>
                                <td>{{ $item->kodepoli }}</td>
                                <td>{{ $item->kodedokter }}</td>
                                <td>{{ $item->jeniskunjungan }}</td>
                                <td>{{ $item->nomorreferensi }}</td>
                                <td>{{ $item->sumberdata }}</td>
                                <td>{{ $item->status }}</td>
                                <td>{{ \Carbon\Carbon::createFromTimestampMs($item->createdtime)->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-adminlte-card>
    </div>
</div>
