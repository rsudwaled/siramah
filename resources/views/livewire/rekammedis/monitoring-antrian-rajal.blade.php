<div class="row">
    @if (isset($antrians))
        <div class="col-md-12">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <x-adminlte-small-box title="{{ $antrians_total }}" text="Total Antrian" theme="primary"
                        icon="fas fa-user-injured" />
                </div>
                <div class="col-lg-3 col-6">
                    <x-adminlte-small-box title="{{ $antrians_sync }}" text="Antrian Syncron" theme="success"
                        icon="fas fa-user-injured" />
                </div>
                <div class="col-lg-3 col-6">
                    <x-adminlte-small-box title="{{ $antrians_total - $antrians_sync }}" text="Antrian Belum Sync"
                        theme="danger" icon="fas fa-user-injured" />
                </div>
            </div>
        </div>
    @endif
    <div class="col-md-12">
        <x-adminlte-card title="Table Antrian Pendaftaran" theme="secondary">
            @if (flash()->message)
                <x-adminlte-alert theme="{{ flash()->class }}" title="{{ flash()->class }} !" dismissable>
                    {{ flash()->message }}
                </x-adminlte-alert>
            @endif
            <div class="row">
                <div class="col-md-4">
                    <x-adminlte-input wire:model.change='tanggalperiksa' type="date" name="tanggalperiksa"
                        igroup-size="sm">
                        <x-slot name="appendSlot">
                            <x-adminlte-button wire:click='caritanggal' theme="primary" label="Pilih" />
                        </x-slot>
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-md-4">
                    <x-adminlte-button class="btn-sm" wire:click='onsyncall'
                        theme="{{ $this->syncall ? 'success' : 'danger' }}"
                        label="Sync All {{ $this->syncall ? 'ON' : 'OFF' }}" />
                </div>
                <div class="col-md-4">
                    <x-adminlte-input name="search" placeholder="Pencarian Berdasarkan Nama / No RM" igroup-size="sm">
                        <x-slot name="appendSlot">
                            <x-adminlte-button wire:click='caritanggal' theme="primary" label="Cari" />
                        </x-slot>
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-search"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>
            </div>
            @php
                $heads = [
                    'No',
                    'Kodebooking',
                    'No RM',
                    'Nama Pasien',
                    'Action',
                    'Taskid',
                    'Sync Antrian',
                    'Jenis Pasien',
                    'SEP',
                    'Unit',
                    'PIC',
                    'Dokter',
                    'Kartu BPJS',
                    'NIK',
                    'Taskid3',
                    'Taskid4',
                    'Taskid5',
                    'Taskid6',
                    'Taskid7',
                    'Method',
                    'Status',
                ];
                $config['order'] = [5, 'asc'];
                $config['scrollX'] = true;
            @endphp
            <x-adminlte-datatable id="table1" class="text-nowrap" :heads="$heads" :config="$config" bordered
                hoverable compressed>
                @isset($antrians)
                    @foreach ($antrians as $item)
                        <tr>
                            <td>{{ $item->angkaantrean }}</td>
                            <td>{{ $item->kodebooking }}</td>
                            <td>{{ $item->norm }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>
                            </td>
                            <td>
                                @switch($item->taskid)
                                    @case(0)
                                        <span class="badge badge-secondary">98. Belum Checkin</span>
                                    @break

                                    @case(1)
                                        <span class="badge badge-warning">1. Menunggu Pendaftaran</span>
                                    @break

                                    @case(2)
                                        <span class="badge badge-primary">0. Proses Pendaftaran</span>
                                    @break

                                    @case(3)
                                        <span class="badge badge-warning">3. Menunggu Poliklinik</span>
                                    @break

                                    @case(4)
                                        <span class="badge badge-primary">4. Pelayanan Poliklinik</span>
                                    @break

                                    @case(5)
                                        <span class="badge badge-warning">5. Tunggu Farmasi</span>
                                    @break

                                    @case(6)
                                        <span class="badge badge-primary">6. Racik Obat</span>
                                    @break

                                    @case(7)
                                        <span class="badge badge-success">7. Selesai</span>
                                    @break

                                    @case(99)
                                        <span class="badge badge-danger">99. Batal</span>
                                    @break

                                    @default
                                        {{ $item->taskid }}
                                @endswitch
                            </td>
                            <td>
                                @switch($item->sync_antrian)
                                    @case(1)
                                        <x-adminlte-button class="btn-xs" wire:click="syncantrian('{{ $item->kodebooking }}')"
                                            label="Sudah Sync" theme="success" icon="fas fa-user-clock" />
                                    @break

                                    @case(2)
                                        <x-adminlte-button class="btn-xs" wire:click="syncantrian('{{ $item->kodebooking }}')"
                                            label="Error Sync" theme="danger" icon="fas fa-user-clock" />
                                    @break

                                    @default
                                        <x-adminlte-button class="btn-xs" wire:click="syncantrian('{{ $item->kodebooking }}')"
                                            label="Belum Sync" theme="warning" icon="fas fa-user-clock" />
                                @endswitch

                                <x-adminlte-button class="btn-xs" theme="warning" icon="fas fa-edit" />
                                <div wire:loading>Loading</div>
                            </td>
                            <td>{{ $item->jenispasien }} </td>
                            <td>{{ $item->kunjungan->sep ?? '-' }} </td>
                            <td>{{ $item->kunjungan->units->nama ?? $item->namapoli }} </td>
                            <td>{{ $item->pic1->name ?? 'Belum Didaftarkan' }} </td>
                            <td>{{ $item->kunjungan->dokters->namadokter ?? $item->namadokter }}</td>
                            <td>{{ $item->nomorkartu }}</td>
                            <td>{{ $item->nik }} </td>
                            <td>{{ $item->taskid3 }} </td>
                            <td>{{ $item->taskid4 }} </td>
                            <td>{{ $item->taskid5 }} </td>
                            <td>{{ $item->taskid6 }} </td>
                            <td>{{ $item->taskid7 }} </td>
                            <td>{{ $item->method }} </td>
                            <td>{{ $item->status }} </td>
                        </tr>
                    @endforeach
                @endisset
            </x-adminlte-datatable>
            @isset($antrians)
                {{ $antrians->links() }}
            @endisset
        </x-adminlte-card>
    </div>
</div>
