<div>
    <div class="col-md-12">
        @if (flash()->message)
            <x-adminlte-alert theme="{{ flash()->class }}" title="{{ flash()->class }} !" dismissable>
                {{ flash()->message }}
            </x-adminlte-alert>
        @endif
        <x-adminlte-card title="Monitoring Waktu Antrian" theme="secondary">
            <div class="row">
                <div class="col-md-2">
                    <x-adminlte-input wire:model.change='tanggalperiksa' type="date" name="tanggalperiksa"
                        igroup-size="sm">
                        <x-slot name="appendSlot">
                            <x-adminlte-button wire:click='cari' theme="primary" label="Cari" />
                        </x-slot>
                        <x-slot name="prependSlot">
                            <x-adminlte-button theme="primary" icon="fas fa-calendar" />
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-md-6">
                    <x-adminlte-button wire:click="onsync" class="btn-sm" label="{{ $sync ? 'Sync On' : 'Sync Off' }}"
                        theme="{{ $sync ? 'success' : 'secondary' }}" icon="fas fa-sync" />
                </div>
                <div class="col-md-4">
                    <x-adminlte-input name="search" placeholder="Pencarian Berdasarkan Nama / No RM" igroup-size="sm">
                        <x-slot name="appendSlot">
                            <x-adminlte-button wire:click='cari' theme="primary" label="Cari" />
                        </x-slot>
                        <x-slot name="prependSlot">
                            <x-adminlte-button theme="primary" icon="fas fa-search" />
                        </x-slot>
                    </x-adminlte-input>
                </div>
            </div>
            <div wire:loading>
                <h4>Loading...</h4>
            </div>
            <table class="table table-bordered text-nowrap table-sm table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kodebooking</th>
                        <th>Pasien</th>
                        <th>No BPJS</th>
                        <th>Poliklinik</th>
                        <th>Status</th>
                        <th>Action</th>
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
                                <td>{{ $antrian->kodebooking }}</td>
                                <td>{{ $antrian->nama }}</td>
                                <td>{{ $antrian->nomorkartu }}</td>
                                <td>{{ $antrian->namapoli }}</td>
                                <td>
                                    @if ($antrian->sync_antrian)
                                        <span class="badge badge-success">Sudah</span>
                                    @else
                                        <span class="badge badge-danger">Belum</span>
                                    @endif
                                </td>
                                <td>
                                    <x-adminlte-button wire:click="resync('{{ $antrian->kodebooking }}')"
                                        class="btn-xs" label="Refresh" theme="warning" icon="fas fa-sync" />

                                </td>
                                <td>{{ $antrian?->kunjungan?->tgl_masuk }}</td>
                                <td>{{ $antrian?->kunjungan?->assesmen_perawat?->tanggalassemen }}</td>
                                <td>{{ $antrian->taskid4 }}</td>
                                <td>{{ $antrian->taskid5 }}</td>
                                <td>{{ $antrian->kunjungan?->order_obat_header?->tgl_entry }}</td>
                                <td>{{ $antrian->taskid7 }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </x-adminlte-card>
    </div>
</div>