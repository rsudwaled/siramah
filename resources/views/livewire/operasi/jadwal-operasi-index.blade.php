<div class="row">
    <div class="col-md-12">
        <x-adminlte-card title="Kunjungan Pasien" theme="secondary">
            <div class="row">
                <div class="col-md-2">
                    <x-adminlte-input wire:model.change='bulan' type="month" name="bulan" igroup-size="sm">
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
                            @if ($jadwals)
                                @foreach ($jadwals as $jadwal)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $jadwal->tanggal }}</td>
                                        <td>{{ $jadwal->end }}</td>
                                        <td>{{ $jadwal->nomor_rm }}</td>
                                        <td>{{ $jadwal->nomor_bpjs }}</td>
                                        <td>{{ $jadwal->ruangan_asal }}</td>
                                        <td>{{ $jadwal->diagnosa }}</td>
                                        <td>{{ $jadwal->status }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </x-adminlte-card>
    </div>
</div>
