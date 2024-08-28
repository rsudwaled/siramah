<div class="row">
    {{-- <div class="col-md-12">
        <div class="row">
            <div class="col-lg-3 col-6">
                <x-adminlte-small-box title="{{ count($antrians) ? $antrians->where('taskid', '!=', 99)->count() : 0 }}"
                    text="Total Pasien" theme="success" icon="fas fa-user-injured" />
            </div>
            <div class="col-lg-3 col-6">
                <x-adminlte-small-box
                    title="{{ count($antrians) ? $antrians->where('jenispasien', 'JKN')->count() : 0 }}"
                    text="Pasien JKN" theme="primary" icon="fas fa-user-injured" />
            </div>
            <div class="col-lg-3 col-6">
                <x-adminlte-small-box
                    title="{{ count($antrians) ? $antrians->where('jenispasien', 'NON-JKN')->count() : 0 }}"
                    text="Pasien NON-JKN" theme="primary" icon="fas fa-user-injured" />
            </div>
            <div class="col-lg-3 col-6">
                <x-adminlte-small-box title="{{ count($antrians) ? $antrians->where('taskid', 99)->count() : 0 }}"
                    text="Pasien Batal" theme="danger" icon="fas fa-user-injured" />
            </div>
        </div>
    </div> --}}
    <div class="col-md-12">
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
                    <x-adminlte-select2 wire:model.change="kode_unit" name="kode_unit" igroup-size="sm">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-clinic-medical"></i>
                            </div>
                        </x-slot>
                        <option value="">--Pilih Poliklinik--</option>
                        @foreach ($units->sortBy('nama_unit') as $unit)
                            <option value="{{ $unit->kode_unit }}">{{ $unit->nama_unit }}</option>
                        @endforeach
                    </x-adminlte-select2>
                </div>
                <div class="col-md-4">
                    <x-adminlte-input wire:model.live="search" name="search"
                        placeholder="Pencarian Berdasarkan Nama / No RM" igroup-size="sm">
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
                <h1>Loading...</h1>
            </div>
            <table class="table table-bordered table-responsive-lg table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kodebooking</th>
                        <th>No RM</th>
                        <th>Nama Pasien</th>
                        <th>No BPJS</th>
                        <th>Action</th>
                        <th>Alasan Masuk</th>
                        <th>Unit</th>
                        <th>Dokter</th>
                        <th>Penjamin</th>
                        <th>SEP</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kunjungans as $kunjungan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kunjungan->antrian?->kodebooking ?? '-' }}</td>
                            <td>{{ $kunjungan->no_rm }}</td>
                            <td>{{ $kunjungan->pasien->nama_px }}</td>
                            <td>{{ $kunjungan->pasien->no_Bpjs }}</td>
                            <td>{{ $kunjungan->status->status_kunjungan }}</td>
                            <td>
                                <x-adminlte-button wire:click='panggil' class="btn-xs" theme="primary"
                                    label="Panggil" />
                                <a
                                    href="{{ route('antrian.rajal.proses') }}?kode_kunjungan={{ $kunjungan->kode_kunjungan }}">
                                    <x-adminlte-button class="btn-xs" theme="warning" label="Proses" />
                                </a>
                            </td>
                            <td>{{ $kunjungan->alasan_masuk->alasan_masuk }}</td>
                            <td>{{ $kunjungan->unit->nama_unit }}</td>
                            <td>{{ $kunjungan->dokter->nama_paramedis }}</td>
                            <td>{{ $kunjungan->penjamin_simrs->nama_penjamin }}</td>
                            <td>{{ $kunjungan->no_sep }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
