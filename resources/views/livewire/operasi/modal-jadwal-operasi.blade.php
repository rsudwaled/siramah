<div>
    <x-adminlte-card theme="primary" title="Jadwal Operasi" icon="fas fa-calendar-alt">
        <div class="row">
            <div class="col-md-6">
                <x-adminlte-input wire:model='no_book' name="no_book" label="No Booking" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" readonly />
                <x-adminlte-input wire:model='kode_kunjungan' name="kode_kunjungan" label="Kode Kunjungan"
                    fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" readonly />
                <x-adminlte-input wire:model='nomor_rm' name="nomor_rm" label="No RM" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" readonly />
                <x-adminlte-input wire:model='nomor_bpjs' name="nomor_bpjs" label="No BPJS" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" readonly />
                <x-adminlte-input wire:model='nama_pasien' name="nama_pasien" label="Nama Pasien" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" readonly />
                <x-adminlte-input wire:model='nama_dokter' name="nama_dokter" label="Dokter" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
                <input type="hidden" wire:model='kd_poli_bpjs' name='kd_poli_bpjs'>
                <x-adminlte-input wire:model='nama_poli_bpjs' name="nama_poli_bpjs" label="Asal Unit" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
            </div>
            <div class="col-md-6">
                <x-adminlte-input wire:model='tanggal' name="tanggal" label="Tanggal Operasi" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" type='datetime-local' />
                <x-adminlte-input wire:model='ruangan' name="ruangan" label="Ruangan Operasi" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
                <x-adminlte-input wire:model='diagnosa' name="diagnosa" label="Diagnosa" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
                <x-adminlte-input wire:model='jenis' name="jenis" label="Jenis Tindakan" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
                <label>Terlaksana Operasi</label>
                <div class="form-group row">
                    <div class="custom-control custom-radio ml-2">
                        <input class="custom-control-input" type="radio" id="belumTerlaksana" name="terlaksana"
                            value="0" wire:model='terlaksana'>
                        <label for="belumTerlaksana" class="custom-control-label">Belum</label>
                    </div>
                    <div class="custom-control custom-radio ml-2">
                        <input class="custom-control-input" type="radio" id="sudahTerlaksana" name="terlaksana"
                            value="1" wire:model='terlaksana'>
                        <label for="sudahTerlaksana" class="custom-control-label">Sudah</label>
                    </div>
                </div>
                <x-adminlte-input wire:model='end' name="end" label="Tgl Selesai Operasi" type='datetime-local'
                    fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
                <x-adminlte-input wire:model='keterangan' name="keterangan" label="Keterangan" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
            </div>
        </div>
        <x-slot name="footerSlot">
            <x-adminlte-button theme="success" icon="fas fa-save" class="btn-sm" label="Simpan" wire:click="simpan"
                wire:confirm='Apakah anda yakin akan jadwal operasi ?' />
            <div wire:loading>
                <div class="spinner-border spinner-border-sm text-primary" role="status">
                </div>
                Loading ...
            </div>
            @if (flash()->message)
                <div class="text-{{ flash()->class }}" wire:loading.remove>
                    Loading Result : {{ flash()->message }}
                </div>
            @endif
        </x-slot>
    </x-adminlte-card>
</div>
