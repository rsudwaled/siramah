<div class="row">
    @if (flash()->message)
        <div class="col-md-12">
            <x-adminlte-alert theme="{{ flash()->class }}" title="{{ flash()->class }} !" dismissable>
                {{ flash()->message }}
            </x-adminlte-alert>
        </div>
    @endif
    <div class="col-md-12">
        <x-adminlte-card title="Table Peserta Fingerprint" theme="secondary">
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-select wire:model='identitas' igroup-size="sm" fgroup-class="row"
                        label-class="text-left col-4" igroup-class="col-8" name="identitas" label="Identitas">
                        <option value=null disabled>Pilih Identitas</option>
                        <option value="nik">NIK</option>
                        <option value="noka">Nomor Kartu</option>
                    </x-adminlte-select>
                    <x-adminlte-input wire:model='noidentitas' name="noidentitas" fgroup-class="row"
                        label-class="text-left col-4" igroup-class="col-8" label="No Identitas" igroup-size="sm">
                        <x-slot name="appendSlot">
                            <x-adminlte-button wire:click='cari' theme="primary" label="Cari" />
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-md-6">
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
                        <b>NIK :</b> {{ $nik }} <br>
                        <b>No Kartu :</b> {{ $nomorkartu }} <br>
                        <b>Tgl Lahir :</b> {{ $tgllahir }} <br>
                        <b>Fingerprint :</b> {{ $daftarfp }} <br>
                    </div>
                </div>
            </div>
        </x-adminlte-card>
    </div>
</div>
