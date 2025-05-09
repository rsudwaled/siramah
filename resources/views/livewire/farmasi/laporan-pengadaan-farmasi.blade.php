<div>
    @if (flash()->message)
        <x-adminlte-alert theme="{{ flash()->class }}" title="{{ flash()->class }} !" dismissable>
            {{ flash()->message }}
        </x-adminlte-alert>
    @endif
    <div class="col-md-12">
        <x-adminlte-card title="Laporan Pengadaan Farmasi" theme="primary">
            <div class="row">
                <div class="col-md-3">
                    <x-adminlte-select wire:model="tipe" igroup-size="sm" name="tipe">
                        <x-slot name="prependSlot">
                            <x-adminlte-button label="Tipe Barang" class="text-bold" />
                        </x-slot>
                        <option value="">SEMUA TIPE BARANG</option>
                        @foreach ($tipeBarang as $x)
                            <option value="{{ $x->kode_tipe }}">{{ $x->nama_tipe }}</option>
                        @endforeach
                    </x-adminlte-select>
                </div>
                <div class="col-md-3">
                    <x-adminlte-input wire:model="tanggalAwal" type="date" name="tanggalAwal" igroup-size="sm">
                        <x-slot name="prependSlot">
                            <x-adminlte-button label="Tgl Awal" class="text-bold" />
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-md-3">
                    <x-adminlte-input wire:model="tanggalAkhir" type="date" name="tanggalAkhir" igroup-size="sm">
                        <x-slot name="prependSlot">
                            <x-adminlte-button label="Tgl Awal" class="text-bold" />
                        </x-slot>
                        <x-slot name="appendSlot">
                            <x-adminlte-button wire:click='cari' theme="primary" label="Cari" />
                        </x-slot>
                    </x-adminlte-input>
                </div>

                <div class="col-md-3">
                    <x-adminlte-button wire:click='export'
                        wire:confirm='Apakah anda yakin akan mendownload file user saat ini ? ' class="btn-sm mb-2"
                        title="Export" theme="primary" icon="fas fa-file-export" />
                </div>
            </div>
            <div wire:loading class="w-100">
                @include('components.placeholder.placeholder-text')
            </div>
            <div wire:loading.remove>
                <table class="table text-nowrap table-sm table-hover table-bordered table-responsive-xl mb-3">
                    <thead class="text-center">
                        <tr>
                            <th rowspan="2">#</th>
                            <th rowspan="2">Kode</th>
                            <th rowspan="2">Nama</th>
                            <th rowspan="2">Tipe</th>
                            <th colspan="3">Depo 1 Ranap</th>
                            <th colspan="3">Depo 2 Rajal</th>
                            <th colspan="3">Depo 3 IGD</th>
                            <th colspan="3">Depo 4 Operasi</th>
                        </tr>
                        <tr>
                            <th>Awal </th>
                            <th>Keluar</th>
                            <th>Akhir</th>
                            <th>Awal </th>
                            <th>Keluar</th>
                            <th>Akhir</th>
                            <th>Awal </th>
                            <th>Keluar</th>
                            <th>Akhir</th>
                            <th>Awal </th>
                            <th>Keluar</th>
                            <th>Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($obats as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->kd_barang }}</td>
                                <td>{{ $item->nm_barang }}</td>
                                <td>{{ $item->nm_tipe }}</td>
                                <td class="text-center">{{ $item->stok_awal_depo_ranap }}</td>
                                <td class="text-center">{{ $item->jml_keluar_depo_ranap }}</td>
                                <td class="text-center">{{ $item->stok_akhir_depo_ranap }}</td>
                                <td class="text-center">{{ $item->stok_awal_depo_rajal }}</td>
                                <td class="text-center">{{ $item->jml_keluar_depo_rajal }}</td>
                                <td class="text-center">{{ $item->stok_akhir_depo_rajal }}</td>
                                <td class="text-center">{{ $item->stok_awal_depo_igd }}</td>
                                <td class="text-center">{{ $item->jml_keluar_depo_igd }}</td>
                                <td class="text-center">{{ $item->stok_akhir_depo_igd }}</td>
                                <td class="text-center">{{ $item->stok_awal_depo_kamar_bedah }}</td>
                                <td class="text-center">{{ $item->jml_keluar_depo_kamar_bedah }}</td>
                                <td class="text-center">{{ $item->stok_akhir_depo_kamar_bedah }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- {{ $users->links() }} --}}
        </x-adminlte-card>
    </div>
</div>
