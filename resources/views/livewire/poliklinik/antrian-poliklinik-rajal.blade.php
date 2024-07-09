<div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-lg-3 col-6">
                <x-adminlte-small-box title="{{ count($antrians) ? $antrians->where('taskid', '!=', 99)->count() : 0 }}"
                    text="Total Pasien" theme="success" icon="fas fa-user-injured" />
            </div>
            <div class="col-lg-3 col-6">
                <x-adminlte-small-box
                    title="{{ count($antrians) ? $antrians->where('jenispasien', 'JKN')->count() : 0 }}" text="Pasien JKN"
                    theme="primary" icon="fas fa-user-injured" />
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
    </div>
    <div class="col-md-12">
        <x-adminlte-card title="Table Antrian Pendaftaran" theme="secondary">
            <div class="row">
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
                    <x-adminlte-select2 wire:model.change="jenispasien" name="jenispasien" igroup-size="sm">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-user"></i>
                            </div>
                        </x-slot>
                        <option value="">Semua Jenis Pasien</option>
                        <option value="JKN">JKN</option>
                        <option value="NON-JKN">NON-JKN</option>
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
                    {{-- @foreach ($antrians as $item)
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
                            <td>{{ $item->lantaipendaftaran }} </td>
                            <td>{{ $item->jenispasien }} </td>
                            <td>{{ $item->kunjungan->units->nama ?? $item->namapoli }} </td>
                            <td>{{ $item->kunjungan->dokters->namadokter ?? $item->namadokter }}</td>
                            <td>{{ $item->pic1->name ?? 'Belum Didaftarkan' }} </td>
                            <td>{{ $item->method }} </td>
                            <td>{{ $item->status }} </td>
                        </tr>
                    @endforeach --}}
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
