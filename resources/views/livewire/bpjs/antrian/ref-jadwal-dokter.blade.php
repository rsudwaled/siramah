<div class="row">
    @if (flash()->message)
        <div class="col-md-12">
            <x-adminlte-alert theme="{{ flash()->class }}" title="{{ flash()->class }} !" dismissable>
                {{ flash()->message }}
            </x-adminlte-alert>
        </div>
    @endif
    <div class="col-md-12">
        <x-adminlte-card title="Table Referensi Dokter" theme="secondary">
            <div class="row">
                <div class="col-md-3">
                    <x-adminlte-input wire:model="kodepoli" list="search" name="kodepoli" placeholder="Pencarian Dokter"
                        igroup-size="sm">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-clinic-medical"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <datalist id="search">
                        @foreach ($polikliniks as $item)
                            <option value="{{ $item->kdpoli }}">{{ $item->nmsubspesialis }}</option>
                        @endforeach
                    </datalist>
                </div>
                <div class="col-md-3">
                    <x-adminlte-input wire:model="tanggal" type="date" name="tanggal" igroup-size="sm">
                        <x-slot name="appendSlot">
                            <x-adminlte-button wire:click='cari' theme="primary" label="Cari" />
                        </x-slot>
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-md-6">
                </div>
            </div>
            <div wire:loading class="col-md-12">
                <div class="row">
                    <p class="card-text placeholder-glow col-6"></p>
                    <p class="card-text placeholder-glow col-7"></p>
                    <p class="card-text placeholder-glow col-4"></p>
                    <p class="card-text placeholder-glow col-4"></p>
                    <p class="card-text placeholder-glow col-6"></p>
                    <p class="card-text placeholder-glow col-8"></p>
                    <br>
                </div>
                <style>
                    .placeholder {
                        display: inline-block;
                        width: 100%;
                        height: 1em;
                        background-color: #e9ecef;
                        border-radius: 0.2rem;
                    }

                    .placeholder-glow::before {
                        content: "\00a0";
                        display: inline-block;
                        width: 100%;
                        height: 100%;
                        background-color: #e9ecef;
                        border-radius: inherit;
                        animation: glow 1.5s infinite linear;
                    }

                    @keyframes glow {
                        0% {
                            opacity: 1;
                        }

                        50% {
                            opacity: 0.4;
                        }

                        100% {
                            opacity: 1;
                        }
                    }
                </style>
            </div>
            <div wire:loading.remove>
                <table class="table text-nowrap table-sm table-hover table-bordered table-responsive-xl mb-3">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Hari</th>
                            <th>Dokter</th>
                            <th>Poliklinik</th>
                            <th>Subspesialis</th>
                            <th>Jampraktek</th>
                            <th>Kapasitas</th>
                            <th>Libur</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jadwals as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->namahari }} ({{ $item->hari }})</td>
                                <td>{{ $item->namadokter }} ({{ $item->kodedokter }})</td>
                                <td>{{ $item->namapoli }} ({{ $item->kodepoli }})</td>
                                <td>{{ $item->namasubspesialis }} ({{ $item->kodesubspesialis }})</td>
                                <td>{{ $item->jadwal }}</td>
                                <td>{{ $item->kapasitaspasien }}</td>
                                <td>{{ $item->libur }}</td>
                                <td>
                                    <a
                                        href="{{ route('antrian.antreandokter') }}?kodepoli={{ $item->kodepoli }}&kodedokter={{ $item->kodedokter }}&hari={{ $item->hari }}&jampraktek={{ $item->jadwal }}">
                                        <x-adminlte-button class="btn-xs" theme="primary" label="Antrian" />
                                    </a>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-adminlte-card>
    </div>
</div>
