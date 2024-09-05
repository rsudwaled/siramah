<div>
    @if ($antrians)
        <div class="col-md-12">
            @if (flash()->message)
                <x-adminlte-alert theme="{{ flash()->class }}" title="{{ flash()->class }} !" dismissable>
                    {{ flash()->message }}
                </x-adminlte-alert>
            @endif
            <div class="row">
                <div class="col-lg-3 col-6" wire:click='panggilpendaftaran'>
                    <x-adminlte-small-box
                        title="{{ $antrians->where('taskid', '!=', 99)->where('taskid', 0)->first() ? $antrians->where('taskid', '!=', 99)->where('taskid', 0)->first()->angkaantrean . ' ' . $antrians->where('taskid', 0)->first()->namapoli : '-' }}"
                        text="Klik Antrian Selanjutnya" theme="success" icon="fas fa-user-injured" />
                </div>
                <div class="col-lg-3 col-6" wire:click='prosespendaftaran'>
                    <x-adminlte-small-box
                        title="{{ $antrians->where('taskid', '!=', 99)->where('taskid', 2)->first() ? $antrians->where('taskid', '!=', 99)->where('taskid', 2)->first()->angkaantrean . ' ' . $antrians->where('taskid', 2)->first()->namapoli : '-' }}"
                        text="Antrian Masih Proses" theme="primary" icon="fas fa-user-injured" />
                </div>
                <div class="col-lg-3 col-6">
                    <x-adminlte-small-box
                        title="{{ $antrians->where('taskid', '!=', 99)->where('taskid', 0)->count() ?? 0 }}"
                        text="Sisa Antrian" theme="warning" icon="fas fa-user-injured" />
                </div>
                <div class="col-lg-3 col-6">
                    <x-adminlte-small-box
                        title="{{ $antrians->where('taskid', '!=', 99)->count() . ' / ' . $antrians->where('taskid', 99)->count() }}"
                        text="Total Pasien / Batal" theme="success" icon="fas fa-user-injured" />
                </div>
            </div>
        </div>
    @endif
    <div class="col-md-12">
        <x-adminlte-card title="Table Antrian Pendaftaran" theme="secondary">
            <div class="row">
                <div class="col-md-2">
                    <x-adminlte-select wire:model.change="lantai" name="lantai" igroup-size="sm">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-hospital"></i>
                            </div>
                        </x-slot>
                        <option value>Semua Lantai</option>
                        <option value="1">Lantai 1</option>
                        <option value="2">Lantai 2</option>
                        <option value="3">Lantai 3</option>
                    </x-adminlte-select>
                </div>
                <div class="col-md-2">
                    <x-adminlte-select wire:model.change="loket" name="loket" igroup-size="sm">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-hospital"></i>
                            </div>
                        </x-slot>
                        <option value>-- Pilih Loket --</option>
                        <option value="1">Loket 1</option>
                        <option value="2">Loket 2</option>
                        <option value="3">Loket 3</option>
                        <option value="4">Loket 4</option>
                        <option value="5">Loket 5</option>
                    </x-adminlte-select>
                </div>
                <div class="col-md-2">
                    <x-adminlte-input wire:model.change='tanggalperiksa' type="date" name="tanggalperiksa"
                        igroup-size="sm">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-md-2">
                    <x-adminlte-select wire:model.change="jenispasien" name="jenispasien" igroup-size="sm">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-user"></i>
                            </div>
                        </x-slot>
                        <option value="">Semua Jenis Pasien</option>
                        <option value="JKN">JKN</option>
                        <option value="NON-JKN">NON-JKN</option>
                    </x-adminlte-select>
                </div>
                <div class="col-md-4">
                    <x-adminlte-input wire:model.live="search" name="search"
                        placeholder="Pencarian Berdasarkan Nama / No RM" igroup-size="sm">
                        <x-slot name="appendSlot">
                            <x-adminlte-button wire:click='pencarian' theme="primary" label="Cari" />
                        </x-slot>
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-search"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>
            </div>
            <div wire:loading>
                <h1>Loading...</h1>
            </div>
            <div wire:loading.remove>
                <table class="table table-bordered table-responsive table-sm text-nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Antrian</th>
                            <th>Kodebooking</th>
                            <th>No RM</th>
                            <th>Nama Pasien</th>
                            <th>No BPJS</th>
                            <th>NIK</th>
                            <th>Action</th>
                            <th>Taskid</th>
                            <th>Lantai</th>
                            <th>Jenis Pasien</th>
                            <th>Unit</th>
                            <th>Dokter</th>
                            <th>PIC</th>
                            <th>Method</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($antrians as $item)
                            <tr>
                                <td>{{ $item->angkaantrean }}</td>
                                <td>{{ $item->nomorantrean }}</td>
                                <td>{{ $item->kodebooking }}</td>
                                <td>{{ $item->norm }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->nomorkartu }}</td>
                                <td>{{ $item->nik }} </td>
                                <td>
                                    @if ($loket && $lantai)
                                        @if ($item->taskid <= 2)
                                            <a
                                                href="{{ route('pendaftaran.rajal.proses') }}?kodebooking={{ $item->kodebooking }}&lantai={{ $lantai }}&loket={{ $loket }}">
                                                <x-adminlte-button class="btn-xs" label="Proses" theme="success"
                                                    icon="fas fa-user-plus" />
                                            </a>
                                        @else
                                            <a
                                                href="{{ route('pendaftaran.rajal.proses') }}?kodebooking={{ $item->kodebooking }}&lantai={{ $lantai }}&loket={{ $loket }}">
                                                <x-adminlte-button class="btn-xs" label="Lihat" theme="secondary"
                                                    icon="fas fa-user-plus" />
                                            </a>
                                        @endif
                                    @else
                                        <span class="text-danger">Pilih Loket & Lantai</span>
                                    @endif

                                </td>
                                <td>
                                    @switch($item->taskid)
                                        @case(0)
                                            <span class="badge badge-secondary">1. Menunggu Pendaftaran</span>
                                        @break

                                        @case(1)
                                            <span class="badge badge-warning">1. Menunggu Pendaftaran</span>
                                        @break

                                        @case(2)
                                            <span class="badge badge-primary">2. Proses Pendaftaran</span>
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
                                <td>{{ $item->lantaipendaftaran }} </td>
                                <td>{{ $item->jenispasien }} </td>
                                <td>{{ $item->kunjungan->units->nama ?? $item->namapoli }} </td>
                                <td>{{ $item->kunjungan->dokters->namadokter ?? $item->namadokter }}</td>
                                <td>{{ $item->pic1->name ?? 'Belum Didaftarkan' }} </td>
                                <td>{{ $item->method }} </td>
                                <td>{{ $item->status }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </x-adminlte-card>
    </div>
</div>
