<div class="row">
    @if (flash()->message)
        <div class="col-md-12">
            <x-adminlte-alert theme="{{ flash()->class }}" title="{{ flash()->class }} !" dismissable>
                {{ flash()->message }}
            </x-adminlte-alert>
        </div>
    @endif
    <div class="col-md-12">
        <div class="row">
            <div class="col-lg-3 col-6">
                <x-adminlte-small-box title="{{ count($antrians) ? $antrians->count() : '-' }}" text="Total Antrian"
                    theme="success" icon="fas fa-user-injured" />
            </div>
            <div class="col-lg-3 col-6">
                <x-adminlte-small-box
                    title="{{ count($antrians) ? $antrians->where('taskid', '!=', 99)->count() : '-' }} Antrian"
                    text="{{ count($antrians) ? $antrians->where('taskid', 99)->count() : '-' }} Antrian Batal"
                    theme="primary" icon="fas fa-user-injured" />
            </div>
            <div class="col-lg-3 col-6">
                <x-adminlte-small-box
                    title="{{ count($antrians) ? $antrians->where('taskid', '!=', 99)->where('taskid', '>=', 5)->where('taskid', '<=', 7)->count() : '-' }}"
                    text="{{ count($antrians) ? $antrians->where('taskid', '<', 5)->count() : '-' }} Antrian Tidak Terhitung"
                    theme="primary" icon="fas fa-user-injured" />
            </div>
            <div class="col-lg-3 col-6">
                <x-adminlte-small-box
                    title="{{ count($antrians) ? $antrians->where('taskid', '!=', 99)->where('taskid', '>=', 5)->where('taskid', '<=', 7)->where('method','JKN Mobile')->count() : '-' }}"
                    text="Antrian MJKN"
                    theme="primary" icon="fas fa-user-injured" />
            </div>
            <div class="col-lg-3 col-6">
                <x-adminlte-small-box
                    title="{{ count($antrians) ? $antrians->where('kode_kunjungan', '!=', null)->count() : '-' }}"
                    text="{{ count($antrians) ? $antrians->where('kode_kunjungan', null)->count() : '-' }} Antrian Tidak Kunjungan"
                    theme="primary" icon="fas fa-user-injured" />
            </div>
            {{-- @if (count($antrians))
                <div class="col-lg-3 col-6">
                    @php
                        if ($antrians->where('taskid', 7)->count()) {
                            $pemanfaatan =
                                ($antrians->where('taskid', 7)->where('method', 'Mobile JKN')->count() /
                                    $antrians->where('taskid', 7)->count()) *
                                100;
                        } else {
                            $pemanfaatan = 0;
                        }
                        $pemanfaatan = number_format($pemanfaatan, 2);
                    @endphp
                    <x-adminlte-small-box
                        title="{{ $antrians->where('taskid', 7)->where('method', 'Mobile JKN')->count() }}"
                        text="{{ $pemanfaatan }}%  Pemanfaatan MJKN" theme="primary" icon="fas fa-user-injured" />
                </div>
            @endif --}}
        </div>
        <div class="row">
            <div class="col-lg-3 col-6">
                <x-adminlte-small-box title="{{ count($kunjungans) ? $kunjungans->count() : '-' }}"
                    text="Total Kunjungan" theme="success" icon="fas fa-user-injured" />
            </div>
            <div class="col-lg-3 col-6">
                <x-adminlte-small-box
                    title="{{ count($kunjungans) ? $kunjungans->where('antrian.kodebooking', '!=', null)->count() : '-' }}"
                    text="{{ count($kunjungans) ? $kunjungans->where('antrian.kodebooking', null)->count() : '-' }} Kunjungan Tidak Bridging"
                    theme="primary" icon="fas fa-user-injured" />
            </div>
            <div class="col-lg-3 col-6">
                <x-adminlte-small-box
                    title="{{ count($kunjungans) ? $kunjungans->where('no_sep', '!=', null)->count() : '-' }} SEP"
                    text="{{ count($kunjungans) ? $kunjungans->where('no_sep', null)->count() : '-' }} Non SEP"
                    theme="warning" icon="fas fa-user-injured" />
            </div>
        </div>
        <div class="row">
            @if (count($antrians) && count($kunjungans))
                <div class="col-lg-3 col-6">
                    {{-- @php
                        if ($antrians->where('taskid', 7)->count()) {
                            $pemanfaatan =
                                ($antrians->where('taskid', 7)->where('method', 'Mobile JKN')->count() /
                                    $antrians->where('taskid', 7)->count()) *
                                100;
                        } else {
                            $pemanfaatan = 0;
                        }
                        $pemanfaatan = number_format($pemanfaatan, 2);
                    @endphp --}}
                    <x-adminlte-small-box title="0" text="0%  Pemanfaatan MJKN" theme="primary"
                        icon="fas fa-user-injured" />
                </div>
            @endif
        </div>
    </div>
    <div class="col-md-12">
        <x-adminlte-card title="Table Antrian" theme="secondary">
            <div class="row">
                <div class="col-md-3">
                    <x-adminlte-input wire:model.change='tgl_awal' type="date" name="tgl_awal" igroup-size="sm" />
                </div>
                <div class="col-md-3">
                    <x-adminlte-input wire:model.change='tgl_akhir' type="date" name="tgl_akhir" igroup-size="sm" />
                </div>
                <div class="col-md-8">
                </div>
            </div>
            <div style="overflow-y: auto ;max-height: 300px;">
                <table class="table table-sm table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tgl Periksa</th>
                            <th>Kodebooking</th>
                            <th>Nama</th>
                            <th>No RM</th>
                            <th>No BPJS</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Kunjungan</th>
                            <th>Poliklinik</th>
                            <th>Dokter</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($antrians as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->tanggalperiksa }}</td>
                                <td>{{ $item->kodebooking }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->norm }}</td>
                                <td>{{ $item->nomorkartu }}</td>
                                <td>{{ $item->method }}</td>
                                <td>{{ $item->taskid }}</td>
                                <td>{{ $item->kode_kunjungan }}</td>
                                <td>{{ $item->namapoli }}</td>
                                <td>{{ $item->namadokter }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </x-adminlte-card>
    </div>
    <div class="col-md-12">
        <x-adminlte-card title="Table Kunjungan" theme="secondary">
            <div class="row">
                <div class="col-md-3">
                    <x-adminlte-input wire:model.change='tgl_awal' type="date" name="tgl_awal" igroup-size="sm" />
                </div>
                <div class="col-md-3">
                    <x-adminlte-input wire:model.change='tgl_akhir' type="date" name="tgl_akhir" igroup-size="sm" />
                </div>
                <div class="col-md-8">
                </div>
            </div>
            <div style="overflow-y: auto ;max-height: 300px;">
                <table class="table table-sm table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tgl Masuk</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>No RM</th>
                            <th>No BPJS</th>
                            <th>Antrian</th>
                            <th>No SEP</th>
                            <th>Poliklinik</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kunjungans as $kunjungan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kunjungan->tgl_masuk }}</td>
                                <td>{{ $kunjungan->kode_kunjungan }}</td>
                                <td>{{ $kunjungan->pasien->nama_px }}</td>
                                <td>{{ $kunjungan->pasien->no_rm }}</td>
                                <td>{{ $kunjungan->pasien->no_Bpjs }}</td>
                                <td>{{ $kunjungan->antrian?->kodebooking ?? '-' }}</td>
                                <td>{{ $kunjungan->no_sep }}</td>
                                <td>{{ $kunjungan->unit?->nama_unit }}</td>
                                <td>{{ $kunjungan->dokter?->nama_paramedis }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-adminlte-card>
    </div>
    <div class="col-md-12">
        <x-adminlte-card title="Table Kunjungan" theme="secondary">
            <table class="table table-sm table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>Poliklinik</th>
                        <th>Kunjungan</th>
                        <th>Antrian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kunjungans->groupBy('kode_unit') as $kode_unit => $kunjungan)
                        <tr>
                            <td>{{ $kode_unit }}</td>
                            <td>{{ $kunjungan->first()->unit?->nama_unit }}</td>
                            <td>{{ $kunjungan->count() }}</td>
                            <td>{{ $antrians->where('kodepoli', $kunjungan->first()->unit?->KDPOLI)->where('taskid', '!=', 99)->where('taskid', '>=', 5)->where('taskid', '<=', 7)->count() }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total</th>
                        <th>{{ $kunjungans->count() }}</th>
                    </tr>
                </tfoot>
            </table>
        </x-adminlte-card>
    </div>

</div>
