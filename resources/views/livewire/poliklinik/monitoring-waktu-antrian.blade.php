<div>
    <div class="col-md-12">
        <x-adminlte-card title="Monitoring Waktu Antrian" theme="secondary">
            <div class="row">
                <div class="col-md-2">
                    <x-adminlte-input wire:model.change='tanggalperiksa' type="date" name="tanggalperiksa"
                        igroup-size="sm">
                        <x-slot name="prependSlot">
                            <x-adminlte-button theme="primary" icon="fas fa-calendar" />
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-md-6">
                </div>
                <div class="col-md-4">
                    <x-adminlte-input name="search" placeholder="Pencarian Berdasarkan Nama / No RM" igroup-size="sm">
                        <x-slot name="appendSlot">
                            <x-adminlte-button theme="primary" label="Cari" />
                        </x-slot>
                        <x-slot name="prependSlot">
                            <x-adminlte-button theme="primary" icon="fas fa-search" />
                        </x-slot>
                    </x-adminlte-input>
                </div>
            </div>
            <table class="table table-bordered table-sm table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Pasien</th>
                        <th>No BPJS</th>
                        <th>Poliklinik</th>
                        <th>Checkin</th>
                        <th>Anamnesis</th>
                        <th>Periksa Dokter</th>
                        <th>Selesai Dokter</th>
                        <th>Penyiapan Resep</th>
                        <th>Obat Diserahkan</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($antrians)
                        @foreach ($antrians as $antrian)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $antrian->tanggalperiksa }}</td>
                                <td>{{ $antrian->nama }}</td>
                                <td>{{ $antrian->nomorkartu }}</td>
                                <td>{{ $antrian->namapoli }}</td>
                                <td>{{ $antrian?->kunjungan?->tgl_masuk }}</td>
                                <td>{{ $antrian?->kunjungan?->assesmen_perawat?->tanggalassemen }}</td>
                            </tr>
                        @endforeach
                    @endif

                </tbody>
            </table>
        </x-adminlte-card>
    </div>
</div>
