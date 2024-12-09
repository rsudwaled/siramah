<div class="row">
    @if (flash()->message)
        <div class="col-md-12">
            <x-adminlte-alert theme="{{ flash()->class }}" title="{{ flash()->class }} !" dismissable>
                {{ flash()->message }}
            </x-adminlte-alert>
        </div>
    @endif
    <div class="col-md-12">
        <x-adminlte-card title="Table SEP Kunjungan" theme="secondary">
            <div class="row">
                <div class="col-md-3">
                    <x-adminlte-input wire:model="tglMulai" type="date" name="tglMulai" fgroup-class="row"
                        label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" label="Tgl Pulang">
                        <x-slot name="appendSlot">
                            <x-adminlte-button wire:click='cari' theme="primary" label="Cari" />
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-md-3">
                    <x-adminlte-input wire:model="tglAkhir" type="date" name="tglAkhir" fgroup-class="row"
                        label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" label="Tgl Pulang">
                        <x-slot name="appendSlot">
                            <x-adminlte-button wire:click='cari' theme="primary" label="Cari" />
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-md-6">
                    <x-adminlte-button theme="success" class="btn-sm" label="Buat SEP" icon="fas fa-file-medical"
                        wire:click='modalSEP' />
                </div>
            </div>
            <div wire:loading class="col-md-12">
                @include('components.placeholder.placeholder-text')
            </div>
            <div wire:loading.remove>
                <table class="table text-nowrap table-sm table-hover table-bordered table-responsive-xl mb-3">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tgl Rujukan</th>
                            <th>Jns Pelayanan</th>
                            <th>No SEP</th>
                            <th>No Kartu</th>
                            <th>Nama</th>
                            <th>Kode</th>
                            <th>Rujukan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($rujukans)
                            @foreach ($rujukans as $item)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <th>{{ $item->tglRujukan }}</th>
                                    <th>{{ $item->jnsPelayanan }}</th>
                                    <th>{{ $item->noSep }}</th>
                                    <th>{{ $item->noKartu }}</th>
                                    <th>{{ $item->nama }}</th>
                                    <th>{{ $item->ppkDirujuk }}</th>
                                    <th>{{ $item->namaPpkDirujuk }}</th>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </x-adminlte-card>
    </div>
</div>
