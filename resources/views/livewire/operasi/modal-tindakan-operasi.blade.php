<div>
    <x-adminlte-card theme="primary" title="Tindakan Operasi" icon="fas fa-file-medical">
        <div class="row">
            <div class="col-md-6">
                <x-adminlte-input wire:model='dokter_pelaksana' name="dokter_pelaksana" label="Dokter Pelaksana"
                    fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
                <x-adminlte-input wire:model='pemberi_informasi' name="pemberi_informasi" label="Pemberi Informasi"
                    fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
                <x-adminlte-input wire:model='jabatan' name="jabatan" label="Jabatan" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
            </div>
            <div class="col-md-6">
                <x-adminlte-input wire:model='penerima_informasi' name="penerima_informasi" label="Penerima Informasi"
                    fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
                <x-adminlte-input wire:model='hubungan_pasien' name="hubungan_pasien" label="Hubungan dgn Pasien"
                    fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
            </div>
            <div class="col-md-12">
                <x-adminlte-textarea wire:model='diagnosa' name="diagnosa" label="Diagnosa (WD & DD)"
                    igroup-size="sm" />
                <x-adminlte-textarea wire:model='dasar_diagnosa' name="dasar_diagnosa" label="Dasar Diagnosa"
                    igroup-size="sm" />
                <x-adminlte-textarea wire:model='tindakan_kedokteran' name="tindakan_kedokteran"
                    label="Tindakan Kedokteran" igroup-size="sm" />
                <x-adminlte-textarea wire:model='indikasi_tindakan' name="indikasi_tindakan" label="Indikasi Tindakan"
                    igroup-size="sm" />
                <x-adminlte-textarea wire:model='tata_cara' name="tata_cara" label="Tata Cara" igroup-size="sm" />
                <x-adminlte-textarea wire:model='tujuan' name="tujuan" label="Tujuan" igroup-size="sm" />
                <x-adminlte-textarea wire:model='resiko' name="resiko" label="Resiko" igroup-size="sm" />
                <x-adminlte-textarea wire:model='komplikasi' name="komplikasi" label="Komplikasi" igroup-size="sm" />
                <x-adminlte-textarea wire:model='prognosis' name="prognosis" label="Prognosis" igroup-size="sm" />
                <x-adminlte-textarea wire:model='alternatif_resiko' name="alternatif_resiko" label="Alternatif & Resiko"
                    igroup-size="sm" />
                <x-adminlte-textarea wire:model='lainnya' name="lainnya" label="Lain-lain" igroup-size="sm" />
            </div>
            <div class="col-md-6">
                <x-adminlte-input wire:model='ttd_dokter' name="ttd_dokter" label="Tandatangan Dokter"
                    fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
                <x-adminlte-input wire:model='ttd_pasien' name="ttd_pasien" label="Tandatangan Pasien"
                    fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
            </div>
        </div>
        <x-slot name="footerSlot">
            <x-adminlte-button theme="success" icon="fas fa-save" class="btn-sm" label="Simpan" wire:click="simpan"
                wire:confirm='Apakah anda yakin akan menyimpan tindakan operasi ?' />
            @if ($tindakan)
                <a href="{{ route('print.tindakan.operasi') }}?kode_kunjungan={{ $tindakan->kode_kunjungan }}"
                    target="_blank">
                    <x-adminlte-button theme="warning" icon="fas fa-print" class="btn-sm" label="Print Tindakan" />
                </a>
            @endif
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
