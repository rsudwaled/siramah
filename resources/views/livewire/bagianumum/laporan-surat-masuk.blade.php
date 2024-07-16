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
                    <x-adminlte-input wire:model="tanggal" type="month" name="tanggal" igroup-size="sm">
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
                @include('components.placeholder.placeholder-text')
            </div>
            <div wire:loading.remove>
                @if ($suratmasuks)
                    <a href="{{ route('laporan.suratmasuk.print') }}?tanggal={{ $tanggal }}" target="_blank">
                        <x-adminlte-button theme="primary" class="btn-sm" label="Print Laporan" />
                    </a>
                    <br> <br>
                @endif
                <table class="table text-nowrap table-sm table-hover table-bordered table-responsive-xl mb-3">
                    <thead>
                        <tr>
                            <th>No Urut</th>
                            <th>Kode</th>
                            <th>No Surat</th>
                            <th>Asal Surat</th>
                            <th>Perihal Surat</th>
                            <th>Tgl Disposisi</th>
                            <th>Pengolah</th>
                            <th>Tanda Terima</th>
                            <th>Tgl Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($suratmasuks)
                            @foreach ($suratmasuks as $item)
                                <tr>
                                    <td>{{ $item->id_surat_masuk }}</td>
                                    <td>{{ $item->kode }}</td>
                                    <td>{{ $item->no_surat }}</td>
                                    <td>{{ $item->asal_surat }}</td>
                                    <td>
                                        <pre style="padding: 0px">{{ $item->perihal }}</pre>
                                    </td>
                                    <td>{{ $item->tgl_disposisi }}</td>
                                    <td>{{ $item->pengolah }}</td>
                                    <td>{{ $item->tanda_terima }}</td>
                                    <td>{{ $item->tgl_terima_surat }}</td>
                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>
            </div>
        </x-adminlte-card>
    </div>
</div>
