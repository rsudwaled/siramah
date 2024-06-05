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
                    <x-adminlte-select wire:model="waktu" fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" name="waktu">
                        <option value=null disabled>Pilih Waktu</option>
                        <option value="rs">RS</option>
                        <option value="server">Server</option>
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-clock"></i>
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
                            <th>Tanggal</th>
                            <th>Poliklinik</th>
                            <th>Jumlah</th>
                            <th>Tunggu Admisi</th>
                            <th>Layan Admisi</th>
                            <th>Tunggu Dokter</th>
                            <th>Layan Dokter</th>
                            <th>Tunggu Farmasi</th>
                            <th>Layan Farmasi</th>
                            <th>Total Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($antrians as $item)
                            <tr>
                                <td>{{ $item->tanggal }}</td>
                                <td>{{ $item->namapoli }}</td>
                                <td>{{ $item->jumlah_antrean }}</td>
                                <td>{{ gmdate('H:i:s', $item->avg_waktu_task1) }}</td>
                                <td>{{ gmdate('H:i:s', $item->avg_waktu_task2) }}</td>
                                <td>{{ gmdate('H:i:s', $item->avg_waktu_task3) }}</td>
                                <td>{{ gmdate('H:i:s', $item->avg_waktu_task4) }}</td>
                                <td>{{ gmdate('H:i:s', $item->avg_waktu_task5) }}</td>
                                <td>{{ gmdate('H:i:s', $item->avg_waktu_task6) }}</td>
                                <td>{{ gmdate('H:i:s', $item->avg_waktu_task1 + $item->avg_waktu_task2 + $item->avg_waktu_task3 + $item->avg_waktu_task4 + $item->avg_waktu_task5 + $item->avg_waktu_task6) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-adminlte-card>
    </div>
</div>
