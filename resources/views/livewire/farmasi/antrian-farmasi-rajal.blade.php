<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-lg-3 col-6">
                <x-adminlte-small-box title="{{ $orders ? count($orders) : '-' }}" text="Total Antrian Resep"
                    theme="success" icon="fas fa-user-injured" />
            </div>
            <div class="col-lg-3 col-6">
                <x-adminlte-small-box
                    title="{{ $pasienpanggil ? substr($pasienpanggil->kode_layanan_header, -3) : '-' }}"
                    text="{{ $pasienpanggil ? $pasienpanggil->pasien->nama_px : '-' }}" theme="warning"
                    icon="fas fa-user-injured" />
            </div>
            <div class="col-lg-3 col-6">
                <x-adminlte-small-box title="{{ $orders != null ? count($orders->where('status_order', 1)) : '-' }}"
                    text="Resep Belum Print" theme="danger" icon="fas fa-user-injured" />
            </div>
        </div>
    </div>
    @if (flash()->message)
        <div class="col-md-12">
            <x-adminlte-alert theme="{{ flash()->class }}" title="{{ flash()->class }} !" dismissable>
                {{ flash()->message }}
            </x-adminlte-alert>
        </div>
    @endif
    <div class="col-md-12">
        <x-adminlte-card title="Data Antrian Farmasi" theme="secondary">
            <div class="row">
                <div class="col-md-2">
                    <x-adminlte-input wire:model.change='tanggal' type="date" name="tanggal" igroup-size="sm">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-md-2">
                    <x-adminlte-select2 wire:model.change="unit" name="unit" igroup-size="sm">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-user"></i>
                            </div>
                        </x-slot>
                        <option value="">Pilih Unit</option>
                        <option value="4008">DEPO FARMASI 2</option>
                        <option value="4002">DEPO FARAMSI 1</option>
                    </x-adminlte-select2>
                </div>
                <div class="col-md-4">
                    <button wire:click="traceraktif"
                        class="btn btn-sm {{ $tracerstatus ? 'btn-success' : 'btn-danger' }}">
                        Tracer {{ $tracerstatus ? 'ON' : 'OFF' }}
                    </button>
                    <div wire:loading>
                        Loading...
                    </div>
                    {{-- <div class="form-group row">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" wire:model.live='tracerstatus'
                                value="on" id="customRadio1" name="customRadio">
                            <label for="customRadio1" class="custom-control-label">Tracer On</label>
                        </div>
                    </div> --}}
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
            <div style="overflow-y: auto ;max-height: 400px;">
                <div class="table-responsive"></div>
                <table class="table table-bordered table-sm table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tgl Entry</th>
                            <th>No RM</th>
                            <th>Nama Pasien</th>
                            <th>Unit</th>
                            <th>Status</th>
                            <th>Tracer</th>
                            <th>Poliklinik</th>
                            <th>Dokter</th>
                            <th>Penjamin</th>
                            <th>SEP</th>
                            <th>Antrian</th>
                            <th>Taskid</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($orders)
                            @foreach ($orders->sortBy('panggil') as $item)
                                <tr>
                                    <td>{{ substr($item->kode_layanan_header, 12) }}</td>
                                    <td>{{ $item->tgl_entry }}</td>
                                    <td>{{ $item->no_rm }}</td>
                                    <td>{{ $item->pasien->nama_px ?? '-' }}</td>
                                    <td>{{ $item->asal_unit->nama_unit ?? '-' }}</td>
                                    <td>
                                        @if ($item->panggil)
                                            <span class="badge badge-success"> Sudah Panggil</span>
                                        @else
                                            <span class="badge badge-danger"> Belum Panggil</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->status_order == 1)
                                            <span class="badge badge-danger"> Belum Cetak</span>
                                        @else
                                            <span class="badge badge-success"> Sudah Cetak</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->panggil == 0)
                                            <x-adminlte-button wire:click="selesai('{{ $item->id }}')"
                                                class="btn-xs" theme="success" label="Selesai" />
                                        @else
                                            <x-adminlte-button wire:click="panggil('{{ $item->id }}')"
                                                class="btn-xs" theme="primary" label="Panggil" />
                                        @endif
                                        <x-adminlte-button wire:click="cetak('{{ $item->id }}')" class="btn-xs"
                                            theme="warning" label="Cetak" />
                                        <x-adminlte-button wire:click='lihat' class="btn-xs" theme="secondary"
                                            label="Lihat" />
                                    </td>
                                    <td>{{ $item->dokter->nama_paramedis ?? '-' }}</td>
                                    <td>{{ $item->penjamin_simrs->nama_penjamin ?? '-' }}</td>
                                    <td>{{ $item->kunjungan->no_sep ?? '-' }}</td>
                                    <td>
                                        {{ $item->kunjungan->antrian->kodebooking ?? '-' }}
                                    </td>
                                    <td>
                                        {{ $item->kunjungan->antrian->taskid ?? '-' }}
                                    </td>

                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            @if ($tracerstatus)
                <div wire:poll.4s="refreshComponent">
                    Tracer Status On - reload setiap 4 detik
                </div>
            @endif
        </x-adminlte-card>
    </div>
    <audio id="myAudio" autoplay>
        <source src="{{ asset('rekaman/Airport_Bell.mp3') }}" type="audio/mp3">
        Your browser does not support the audio element.
    </audio>
    @push('js')
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('play-audio', (event) => {
                    $('#myAudio').trigger('play');
                    console.log('Playing audio addEventListener');
                });
            });
        </script>
        <script>
            document.addEventListener('livewire:load', () => {
                Livewire.onPageExpired((response, message) => {
                    alert(message);
                })
            })
        </script>
    @endpush
</div>
