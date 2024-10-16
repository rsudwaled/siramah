<div class="row">
    <div class="col-md-12">
        <x-adminlte-card title="Kunjungan Pasien" theme="secondary">
            <div class="row">
                <div class="col-md-2">
                    <x-adminlte-input wire:model.change='tanggal_operasi' type="date" name="tanggal_operasi"
                        igroup-size="sm">
                        <x-slot name="prependSlot">
                            <x-adminlte-button theme="primary" icon="fas fa-calendar-alt" />
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-4">
                    <x-adminlte-input wire:model.live="search" name="search"
                        placeholder="Pencarian Berdasarkan Nama / No RM" igroup-size="sm">
                        <x-slot name="appendSlot">
                            <x-adminlte-button wire:click='pencarian' theme="primary" label="Cari" />
                        </x-slot>
                        <x-slot name="prependSlot">
                            <x-adminlte-button theme="primary" icon="fas fa-search" />
                        </x-slot>
                    </x-adminlte-input>
                </div>
            </div>
            <div wire:loading>
                <h1>Loading...</h1>
            </div>
            <div wire:loading.remove>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tgl Masuk</th>
                                <th>Tgl Pulang</th>
                                <th>No RM</th>
                                <th>Nama Pasien</th>
                                <th>No BPJS</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th>Alasan Masuk</th>
                                <th>Unit</th>
                                <th>Dokter</th>
                                <th>Penjamin</th>
                                <th>SEP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kunjungans as $kunjungan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $kunjungan->tgl_masuk }}</td>
                                    <td>{{ $kunjungan->tgl_keluar }}</td>
                                    <td>{{ $kunjungan->no_rm }}</td>
                                    <td>{{ $kunjungan->pasien->nama_px }}</td>
                                    <td>{{ $kunjungan->pasien->no_Bpjs }}</td>
                                    <td>{{ $kunjungan->status->status_kunjungan }}</td>
                                    <td>
                                        <a
                                            href="{{ route('erm.oprasi') }}?kode_kunjungan={{ $kunjungan->kode_kunjungan }}">
                                            <x-adminlte-button theme="success" label="Operasi" class="btn-xs" />
                                        </a>
                                    </td>
                                    <td>{{ $kunjungan->alasan_masuk->alasan_masuk }}</td>
                                    <td>{{ $kunjungan->unit->nama_unit }}</td>
                                    <td>{{ $kunjungan->dokter->nama_paramedis }}</td>
                                    <td>{{ $kunjungan->penjamin_simrs->nama_penjamin }}</td>
                                    <td>{{ $kunjungan->no_sep }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </x-adminlte-card>
    </div>
</div>
