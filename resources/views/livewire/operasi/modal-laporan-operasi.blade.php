<div>
    <x-adminlte-card theme="primary" title="Laporan Operasi" icon="fas fa-user-injured">
        <div class="row">
            <div class="col-md-6">
                <x-adminlte-input wire:model='kode' name="kode" label="Kode Laporan" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" readonly />
                <x-adminlte-input wire:model='nomor' name="nomor" label="Nomor Laporan" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" readonly />
                <x-adminlte-input wire:model='ruang_operasi' name="ruang_operasi" label="Ruang Operasi"
                    fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
                <x-adminlte-input wire:model='kamar_operasi' name="kamar_operasi" label="Kamar Operasi"
                    fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
                <div class="form-group row">
                    <div class="custom-control custom-radio ml-2">
                        <input class="custom-control-input" type="radio" id="cyto" wire:model='cytoterencana'
                            name="cytoterencana" value="1">
                        <label for="cyto" class="custom-control-label">Cyto</label>
                    </div>
                    <div class="custom-control custom-radio ml-2">
                        <input class="custom-control-input" type="radio" id="terencana" wire:model='cytoterencana'
                            name="cytoterencana" value="0">
                        <label for="terencana" class="custom-control-label">Terencana</label>
                    </div>
                </div>
                <x-adminlte-input wire:model='tanggal_operasi' name="tanggal_operasi" label="Jadwal Operasi"
                    fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm"
                    type='datetime-local' />
                <x-adminlte-input wire:model='jam_operasi_mulai' name="jam_operasi_mulai" label="Jam Operasi Mulai"
                    fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm"
                    type='datetime-local' />
                <x-adminlte-input wire:model='jam_operasi_selesai' name="jam_operasi_selesai" type='datetime-local'
                    label="Jam Operasi Selesai" fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                    igroup-size="sm" />
                <x-adminlte-input wire:model='lama_operasi' name="lama_operasi" label="Lama Operasi" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" readonly />
            </div>
            <div class="col-md-6">
                <x-adminlte-input wire:model='pembedah' name="pembedah" label="Dokter Pembedah" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />

                <x-adminlte-input wire:model='asisten1' name="asisten1" label="Asisten I" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
                <x-adminlte-input wire:model='asisten2' name="asisten2" label="Asisten II" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
                <x-adminlte-input wire:model='perawat_instrumen' name="perawat_instrumen" label="Perawat Instrumen"
                    fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
                <x-adminlte-input wire:model='ahli_anastesi' name="ahli_anastesi" label="Ahli Anastesi"
                    fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
                <x-adminlte-input wire:model='jenis_anastesi' name="jenis_anastesi" label="Jenis Anastesi"
                    fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
            </div>
            <div class="col-md-6">
                <x-adminlte-textarea wire:model='diagnosa_pra_bedah' name="diagnosa_pra_bedah"
                    label="Diagnosa Pra-Bedah" fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                    igroup-size="sm" />
            </div>
            <div class="col-md-6">
                <x-adminlte-textarea wire:model='indikasi_operasi' name="indikasi_operasi" label="Indikasi Operasi"
                    fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
            </div>
            <div class="col-md-6">
                <x-adminlte-textarea wire:model='diagnosa_pasca_bedah' name="diagnosa_pasca_bedah"
                    label="Diagnosa Pasca-Bedah" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" />
            </div>
            <div class="col-md-6">
                <x-adminlte-textarea wire:model='jenis_operasi' name="jenis_operasi" label="Jenis Operasi"
                    fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
            </div>
            <div class="col-md-6">
                <x-adminlte-textarea wire:model='desinfekasi_kulit' name="desinfekasi_kulit"
                    label="Desinfeksi Kulit dengan" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" rows=5 />
            </div>
            <div class="col-md-6">
                <x-adminlte-textarea wire:model='jaringan_dieksisi' name="jaringan_dieksisi"
                    label="Jaringan Dieksisi" fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                    igroup-size="sm" />
                <label>Dikirim ke bagian Patologi Anatomi</label>
                <div class="form-group row">
                    <div class="custom-control custom-radio ml-2">
                        <input class="custom-control-input" type="radio" id="yadikirim" wire:model='dikirim_lab'
                            value="1" name="dikirim_lab">
                        <label for="yadikirim" class="custom-control-label">Ya</label>
                    </div>
                    <div class="custom-control custom-radio ml-2">
                        <input class="custom-control-input" type="radio" id="tidakdikirim"
                            wire:model='dikirim_lab' value="0" name="dikirim_lab">
                        <label for="tidakdikirim" class="custom-control-label">Tidak</label>
                    </div>
                </div>
                <x-adminlte-input wire:model='jenis_bahan' name="jenis_bahan" label="Jenis Bahan" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
                <x-adminlte-input wire:model='pemeriksaan_laboratorium' name="pemeriksaan_laboratorium"
                    label="Untuk Pemeriksaan Lab" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" />
            </div>
            <div class="col-md-6">
                <x-adminlte-textarea wire:model='macam_sayatan' name="macam_sayatan" label="Macam Sayatan"
                    fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
            </div>
            <div class="col-md-6">
                <x-adminlte-textarea wire:model='posisi_penderita' name="posisi_penderita" label="Posisi Penderita"
                    fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
            </div>
            <div class="col-md-12">
                <x-adminlte-textarea wire:model='teknik_temuan_operasi' name="teknik_temuan_operasi"
                    label="Teknik Operasi & Temuan Intra-Operasi" igroup-size="sm" rows="15" />
            </div>
            <div class="col-md-6">
                <label>Pengunaan BHP Khusus</label>
                <div class="form-group row">
                    <div class="custom-control custom-radio ml-2">
                        <input class="custom-control-input" type="radio" id="yabhpkhusus" name="bhp_khusus" wire:model="bhp_khusus" value="1">
                        <label for="yabhpkhusus" class="custom-control-label">Ya</label>
                    </div>
                    <div class="custom-control custom-radio ml-2">
                        <input class="custom-control-input" type="radio" id="tidakbhpkhusus" name="bhp_khusus" wire:model="bhp_khusus" value="0">
                        <label for="tidakbhpkhusus" class="custom-control-label">Tidak</label>
                    </div>
                </div>
                <x-adminlte-textarea wire:model='penggunaan_bhp_khusus' name="penggunaan_bhp_khusus" label="Penggunaan BHP"
                    placeholder="Jenis & Jumlah BHP Khusus" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" rows="5" />
            </div>
            <div class="col-md-6">
                <label>Komplikasi Intra-Operasi</label>
                <div class="form-group row">
                    <div class="custom-control custom-radio ml-2">
                        <input class="custom-control-input" type="radio" id="yakomplikasi"
                            name="komplikasi_operasi" value="1" wire:model='komplikasi_operasi'>
                        <label for="yakomplikasi" class="custom-control-label">Ya</label>
                    </div>
                    <div class="custom-control custom-radio ml-2">
                        <input class="custom-control-input" type="radio" id="tidakkomplikasi"
                            name="komplikasi_operasi" value="0" wire:model='komplikasi_operasi'>
                        <label for="tidakkomplikasi" class="custom-control-label">Tidak</label>
                    </div>
                </div>
                <x-adminlte-textarea wire:model='penjabaran_komplikasi' name="penjabaran_komplikasi"
                    label="Penjabaran Komplikasi Intra-Operasi" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" rows="5" />
                <x-adminlte-input wire:model='pendarahan' name="pendarahan" label="Pendarahan (cc)"
                    fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
            </div>
            <div class="col-md-12">
                <hr>
                <h6>Intrusi Pasca Bedah</h6>
            </div>
            <div class="col-md-6">
                <x-adminlte-input wire:model='kontrol' name="kontrol" label="Kontrol" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
                <x-adminlte-input wire:model='puasa' name="puasa" label="Puasa" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
                <x-adminlte-input wire:model='drain' name="drain" label="Drain" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
                <x-adminlte-input wire:model='infus' name="infus" label="Infus" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
            </div>
            <div class="col-md-6">
                <x-adminlte-textarea wire:model='obat' name="obat" label="Obat-obat" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" rows="4" />
                <x-adminlte-input wire:model='ganti_balut' name="ganti_balut" label="Ganti Balut" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
                <x-adminlte-input wire:model='lainnya' name="lainnya" label="Lain-lain" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
            </div>
            <div class="col-md-12">
                <hr>
            </div>
            <div class="col-md-6">
                <x-adminlte-input wire:model='tgl_laporan' name="tgl_laporan" label="Tgl Laporan" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" type='datetime-local' />
                <x-adminlte-input wire:model='pembuat_laporan' name="pembuat_laporan" label="Pembuat Laporan"
                    fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
            </div>
            <div class="col-md-6">
                <x-adminlte-input wire:model='pembedah' name="pembedah" label="Pembedah" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" />
            </div>
        </div>
        <x-slot name="footerSlot">
            <x-adminlte-button theme="success" icon="fas fa-save" class="btn-sm" label="Simpan" wire:click="simpan"
                wire:confirm='Apakah anda yakin akan menyimpan data laporan operasi ?' />
            @if ($laporan)
                <a href="{{ route('print.laporan.operasi') }}?kode_kunjungan={{ $laporan->kode_kunjungan }}" target="_blank">
                    <x-adminlte-button theme="warning" icon="fas fa-print" class="btn-sm" label="Print Laporan" />
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
