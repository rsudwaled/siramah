<div class="row">
    <div class="col-md-12">
        @if ($kunjungans)
            <div class="row">
                <div class="col-lg-3 col-6">
                    <x-adminlte-small-box
                        title="{{ $kunjungans ? count($kunjungans->where('status_kunjungan', '!=', 8)) : 0 }}"
                        text="Total Kunjungan" theme="success" icon="fas fa-user-injured" />
                </div>
            </div>
        @endif
        <x-adminlte-card title="Kunjungan Pasien Poliklinik" theme="secondary">
            <div class="row">
                <div class="col-md-2">
                    <x-adminlte-input wire:model.change='tgl_masuk' type="date" name="tgl_masuk" igroup-size="sm">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-md-2">
                    <x-adminlte-select wire:model.change="kode_unit" name="kode_unit" igroup-size="sm">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-clinic-medical"></i>
                            </div>
                        </x-slot>
                        <option value="">--Pilih Poliklinik--</option>
                        <option value="0000">SEMUA POLIKLINIK</option>
                        @foreach ($units->sortBy('nama_unit') as $unit)
                            <option value="{{ $unit->kode_unit }}">{{ $unit->nama_unit }}</option>
                        @endforeach
                    </x-adminlte-select>
                </div>
                <div class="col-md-4">
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
                            <th>Tgl Masuk</th>
                            <th>No RM</th>
                            <th>Nama Pasien</th>
                            <th>No BPJS</th>
                            <th>Status</th>
                            <th>Action</th>
                            <th>Alasan Masuk</th>
                            <th>Unit</th>
                            <th>Dokter</th>
                            <th>Penjamin</th>
                            <th>Kodebooking</th>
                            <th>SEP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($kunjungans)
                            @foreach ($kunjungans as $kunjungan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $kunjungan->tgl_masuk }}</td>
                                    <td>{{ $kunjungan->no_rm }}</td>
                                    <td>{{ $kunjungan->pasien->nama_px }}</td>
                                    <td>{{ $kunjungan->pasien->no_Bpjs }}</td>
                                    <td>
                                        @switch($kunjungan->status_kunjungan)
                                            @case(1)
                                                <span class="badge badge-warning">Open</span>
                                            @break

                                            @case(2)
                                                <span class="badge badge-success">Selesai</span>
                                            @break

                                            @case(3)
                                                <span class="badge badge-success">Sembuh</span>
                                            @break

                                            @case(8)
                                                <span class="badge badge-danger">Batal</span>
                                            @break

                                            @default
                                                <span class="badge badge-secondary">{{ $kunjungan->status_kunjungan }}</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <a class="withLoad"
                                            href="{{ route('kunjungan.poliklinik.pasien') }}?kode_kunjungan={{ $kunjungan->kode_kunjungan }}">
                                            <x-adminlte-button class="btn-xs" theme="success" icon="fas fa-file-medical"
                                                label="Lihat" />
                                        </a>
                                    </td>
                                    <td>{{ $kunjungan->alasan_masuk->alasan_masuk }}</td>
                                    <td>{{ $kunjungan->unit->nama_unit }}</td>
                                    <td>{{ $kunjungan->dokter->nama_paramedis }}</td>
                                    <td>{{ $kunjungan->penjamin_simrs->nama_penjamin }}</td>
                                    <td>{{ $kunjungan->antrian?->kodebooking ?? '-' }}</td>
                                    <td>{{ $kunjungan->no_sep }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </x-adminlte-card>
    </div>
</div>
<script>
    document.addEventListener('livewire:load', function() {
        alert('test');
        // $('.select2').select2();
        // Livewire.hook('message.processed', (message, component) => {
        //     $('.select2').select2();
        // });
    });
</script>
