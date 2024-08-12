<div>
    {{-- @if (isset($kunjungans))
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
    @endif --}}
    <div class="col-md-12">
        <x-adminlte-card title="Tabel Pasien Rawat Jalan" theme="secondary">
            @if (flash()->message)
                <x-adminlte-alert theme="{{ flash()->class }}" title="{{ flash()->class }} !" dismissable>
                    {{ flash()->message }}
                </x-adminlte-alert>
            @endif
            <div class="row">
                <div class="col-md-2">
                    <x-adminlte-select wire:model.change="unit" name="unit" igroup-size="sm">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-hospital"></i>
                            </div>
                        </x-slot>
                        <option value="">Pilih Poliklinik</option>
                        @foreach ($units as $key => $nama)
                            <option value="{{ $key }}">{{ $nama }}</option>
                        @endforeach
                        <option value="0">SEMUA POLIKLINIK</option>
                    </x-adminlte-select>
                </div>
                <div class="col-md-2">
                    <x-adminlte-input wire:model.change='tgl_masuk' type="date" name="tgl_masuk" igroup-size="sm">
                        <x-slot name="appendSlot">
                            <x-adminlte-button wire:click='cariTanggal' theme="primary" label="Pilih" />
                        </x-slot>
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    <x-adminlte-input wire:model.live='search' name="search"
                        placeholder="Pencarian Berdasarkan Nama Pasien / No RM" igroup-size="sm">
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
            <div wire:loading>
                Loading...
            </div>
            <div wire:loading.remove>
                <table class="table table-sm table-bordered table-hover ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No Antrian</th>
                            <th>No RM</th>
                            <th>Nama</th>
                            <th>No BPJS</th>
                            <th>Action</th>
                            <th>SEP</th>
                            <th>Poliklinik</th>
                            <th>Dokter</th>
                            <th>Casemix</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kunjungans as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->kode_kunjungan }}</td>
                                <td>{{ $item->pasien->no_rm }}</td>
                                <td>{{ $item->pasien->nama_px }}</td>
                                <td>{{ $item->pasien->no_Bpjs }}</td>
                                <td>
                                    <a
                                        href="{{ route('rekam-medis-rajal-detail') }}?kode={{ $item->kode_kunjungan }}">
                                        <x-adminlte-button class="btn-xs" label="Lihat" theme="primary"
                                            icon="fas fa-file-medical" />
                                    </a>
                                </td>
                                <td>{{ $item->no_sep }}</td>
                                <td>{{ $item->unit->nama_unit }}</td>
                                <td>{{ $item->dokter->nama_paramedis }}</td>
                                <td>
                                    @if ($item->budget)
                                        <span class="badge badge-{{ $item->budget->final ? 'success' : 'warning' }}">
                                            {{ $item->budget->user }}
                                        </span>
                                    @else
                                        <span class="badge badge-danger">
                                            Belum Ada Data
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-adminlte-card>
    </div>
</div>
