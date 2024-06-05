<div class="row">
    @if (flash()->message)
        <div class="col-md-12">
            <x-adminlte-alert theme="{{ flash()->class }}" title="{{ flash()->class }} !" dismissable>
                {{ flash()->message }}
            </x-adminlte-alert>
        </div>
    @endif
    <div class="col-md-12">
        <x-adminlte-card title="List Taskid" theme="secondary">
            <div class="row">
                <div class="col-md-5">
                    <x-adminlte-input wire:model="tanggal" type="date" name="tanggal" fgroup-class="row"
                        label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" label="Tanggal">
                    </x-adminlte-input>
                    <x-adminlte-input wire:model='nik' name="nik" fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" label="nik" igroup-size="sm">
                        <x-slot name="appendSlot">
                            <x-adminlte-button wire:click='cariNIK' theme="primary" label="Cari" />
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input wire:model='nomorkartu' name="nomorkartu" fgroup-class="row"
                        label-class="text-left col-4" igroup-class="col-8" label="nomorkartu" igroup-size="sm">
                        <x-slot name="appendSlot">
                            <x-adminlte-button wire:click='cariNomorKartu' theme="primary" label="Cari" />
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-md-7">
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
                        @if ($peserta)
                            <table class="table table-sm table-hover table-bordered">
                                <tr>
                                    <td>No Kartu</td>
                                    <td>:</td>
                                    <td>{{ $peserta->noKartu }}</td>
                                </tr>
                                <tr>
                                    <td>nik</td>
                                    <td>:</td>
                                    <td>{{ $peserta->nik }}</td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>{{ $peserta->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Pisa</td>
                                    <td>:</td>
                                    <td>{{ $peserta->pisa }}</td>
                                </tr>
                                <tr>
                                    <td>No MR</td>
                                    <td>:</td>
                                    <td>{{ $peserta->mr->noMR }}</td>
                                </tr>
                                <tr>
                                    <td>No Telepon</td>
                                    <td>:</td>
                                    <td>{{ $peserta->mr->noTelepon }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Lahir</td>
                                    <td>:</td>
                                    <td>{{ $peserta->tglLahir }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Cetak Kartu</td>
                                    <td>:</td>
                                    <td>{{ $peserta->tglCetakKartu }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal TAT</td>
                                    <td>:</td>
                                    <td>{{ $peserta->tglTAT }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal TMT</td>
                                    <td>:</td>
                                    <td>{{ $peserta->tglTMT }}</td>
                                </tr>
                                <tr>
                                    <td>Status Peserta</td>
                                    <td>:</td>
                                    <td>{{ $peserta->statusPeserta->keterangan }}</td>
                                </tr>
                                <tr>
                                    <td>Provinsi Umum</td>
                                    <td>:</td>
                                    <td>{{ $peserta->provUmum->nmProvider }}</td>
                                </tr>
                                <tr>
                                    <td>Jenis Peserta</td>
                                    <td>:</td>
                                    <td>{{ $peserta->jenisPeserta->keterangan }}</td>
                                </tr>
                                <tr>
                                    <td>Hak Kelas</td>
                                    <td>:</td>
                                    <td>{{ $peserta->hakKelas->keterangan }}</td>
                                </tr>
                                <tr>
                                    <td>Umur Sekarang</td>
                                    <td>:</td>
                                    <td>{{ $peserta->umur->umurSekarang }}</td>
                                </tr>
                                <tr>
                                    <td>Umur Saat Pelayanan</td>
                                    <td>:</td>
                                    <td>{{ $peserta->umur->umurSaatPelayanan }}</td>
                                </tr>
                                <tr>
                                    <td>Informasi Dinsos</td>
                                    <td>:</td>
                                    <td>{{ $peserta->informasi->dinsos }}</td>
                                </tr>
                                <tr>
                                    <td>Informasi Prolanis PRB</td>
                                    <td>:</td>
                                    <td>{{ $peserta->informasi->prolanisPRB }}</td>
                                </tr>
                                <tr>
                                    <td>Informasi No SKTM</td>
                                    <td>:</td>
                                    <td>{{ $peserta->informasi->noSKTM }}</td>
                                </tr>
                                <tr>
                                    <td>Informasi eSEP</td>
                                    <td>:</td>
                                    <td>{{ $peserta->informasi->eSEP }}</td>
                                </tr>
                                <tr>
                                    <td>COB No Asuransi</td>
                                    <td>:</td>
                                    <td>{{ $peserta->cob->noAsuransi }}</td>
                                </tr>
                                <tr>
                                    <td>COB Nama Asuransi</td>
                                    <td>:</td>
                                    <td>{{ $peserta->cob->nmAsuransi }}</td>
                                </tr>
                                <tr>
                                    <td>COB Tanggal TMT</td>
                                    <td>:</td>
                                    <td>{{ $peserta->cob->tglTMT }}</td>
                                </tr>
                                <tr>
                                    <td>COB Tanggal TAT</td>
                                    <td>:</td>
                                    <td>{{ $peserta->cob->tglTAT }}</td>
                                </tr>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </x-adminlte-card>
    </div>
</div>
