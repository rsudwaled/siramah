<div class="row">
    <div class="col-md-12">
        {{-- <div class="row">
            <div class="col-lg-3 col-6">
                <x-adminlte-small-box title="{{ $kunjungans ? count($kunjungans->where('status_kunjungan', '!=', 8)) : 0 }}"
                    text="Total Kunjungan" theme="success" icon="fas fa-user-injured" />
            </div>
        </div> --}}
    </div>
    <div class="col-md-12">
        <x-adminlte-card title="Kunjungan Pasien Poliklinik" theme="secondary">
            <div class="row">
                <div class="col-md-2">
                    <x-adminlte-input wire:model.change='tgl_masuk' type="date" name="tgl_masuk" igroup-size="sm">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-primary">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    <x-adminlte-input wire:model.live="search" name="search"
                        placeholder="Pencarian Berdasarkan Nama / No RM" igroup-size="sm">
                        <x-slot name="appendSlot">
                            <x-adminlte-button wire:click='pencarian' theme="primary" label="Cari" />
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
            <div wire:loading.remove>
                <table class="table table-bordered table-responsive table-sm text-nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tgl Masuk</th>
                            <th>No RM</th>
                            <th>Nama Pasien</th>
                            <th>No BPJS</th>
                            <th>Status</th>
                            <th>Action</th>
                            <th>Alasan Masuk</th>
                            <th>Unit</th>
                            <th>Dokter</th>
                            <th>Penjamin</th>
                            <th>Kodebooking</th>
                            <th>SEP</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </x-adminlte-card>
    </div>

</div>
