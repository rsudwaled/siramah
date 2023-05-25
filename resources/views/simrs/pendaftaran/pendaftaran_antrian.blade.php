@extends('adminlte::page')
@section('title', 'Antrian Pendaftaran')
@section('content_header')
    <h1>Antrian Pendaftaran {{ $request->loket ? 'Loket ' . $request->loket . ' Lantai ' . $request->lantai : '' }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Filter Antrian Offline Pasien" theme="secondary"
                collapsible="{{ $request->loket ? 'collapsed' : '' }}">
                <form action="" method="get">
                    <div class="row">
                        <div class="col-md-3">
                            @php
                                $config = ['format' => 'YYYY-MM-DD'];
                            @endphp
                            <x-adminlte-input-date name="tanggal" label="Tanggal Antrian Pasien" :config="$config"
                                value="{{ \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d') }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                        <div class="col-md-3">
                            <x-adminlte-select name="jenispasien" label="Jenis Pasien">
                                <option value="JKN" {{ $request->jenispasien == 'JKN' ? 'selected' : null }}>BPJS
                                </option>
                                <option value="NON-JKN" {{ $request->jenispasien == 'NON-JKN' ? 'selected' : null }}>UMUM
                                </option>
                            </x-adminlte-select>
                        </div>
                        <div class="col-md-3">
                            <x-adminlte-select name="loket" label="Loket">
                                <x-adminlte-options :options="[
                                    1 => 'Loket 1',
                                    2 => 'Loket 2',
                                    3 => 'Loket 3',
                                    4 => 'Loket 4',
                                    5 => 'Loket 5',
                                ]" :selected="$request->loket ?? 1" />
                            </x-adminlte-select>
                        </div>
                        <div class="col-md-3">
                            <x-adminlte-select name="lantai" label="Lantai">
                                <x-adminlte-options :options="[
                                    1 => 'Lantai 1',
                                    2 => 'Lantai 2',
                                    3 => 'Lantai 3',
                                    4 => 'Lantai 4',
                                    5 => 'Lantai 5',
                                ]" :selected="$request->lantai ?? 1" />
                            </x-adminlte-select>
                        </div>
                    </div>
                    <x-adminlte-button type="submit" class="withLoad" theme="primary" label="Submit Pencarian" />
                </form>
            </x-adminlte-card>
            @if (isset($antrians))
                <div class="row">
                    <div class="col-md-3">
                        <x-adminlte-small-box
                            title="{{ $antrians->where('taskid', 2)->where('lantaipendaftaran', $request->lantai)->first()->angkaantrean ?? '0' }}"
                            text="Antrian Saat Ini" theme="primary" icon="fas fa-user-injured" />
                    </div>
                    <div class="col-md-3">
                        <x-adminlte-small-box
                            title="{{ $antrians->where('method', 'Offline')->where('taskid', 0)->where('lantaipendaftaran', $request->lantai)->first()->angkaantrean ?? '0' }}"
                            text="Antrian Selanjutnya" theme="success" icon="fas fa-user-injured"
                            url="{{ route('selanjutnyaPendaftaran', [$request->loket, $request->lantai, $request->jenispasien, $request->tanggal]) }}"
                            url-text="Panggil Selanjutnya" />
                    </div>
                    <div class="col-md-3">
                        <x-adminlte-small-box
                            title="{{ $antrians->where('method', 'Offline')->where('taskid', '<', 1)->where('lantaipendaftaran', $request->lantai)->count() }}"
                            text="Sisa Antrian" theme="warning" icon="fas fa-user-injured" url="#"
                            url-text="Refresh Antrian" onclick="location.reload();" />
                    </div>
                    <div class="col-md-3">
                        <x-adminlte-small-box
                            title="{{ $antrians->where('method', 'Offline')->where('lantaipendaftaran', $request->lantai)->count() }}"
                            text="Total Antrian" theme="success" icon="fas fa-user-injured" />
                    </div>
                    <div class="col-md-12">
                        <x-adminlte-card theme="success" icon="fas fa-info-circle" collapsible
                            title="Proses Pendaftaran Antrian Offline ({{ $antrians->where('taskid', 2)->where('lantaipendaftaran', $request->lantai)->count() }} Orang)">
                            @php
                                $heads = ['No', ' Antrian', 'Pasien', 'Kunjungan', 'Poliklinik', 'Dokter', 'Status', 'Loket', 'Action'];
                                $config['order'] = ['0', 'asc'];
                                $config['paging'] = false;
                                $config['info'] = false;
                                $config['scrollY'] = '400px';
                                $config['scrollCollapse'] = true;
                                $config['scrollX'] = true;
                            @endphp
                            <x-adminlte-datatable id="table1" class="nowrap text-xs" :heads="$heads" :config="$config"
                                striped bordered hoverable compressed>
                                @foreach ($antrians->where('taskid', 2)->where('lantaipendaftaran', $request->lantai) as $item)
                                    <tr>
                                        <td>
                                            <b>{{ $item->angkaantrean }}</b>
                                        </td>
                                        <td>
                                            {{ $item->nomorantrean }} / {{ $item->kodebooking }}<br>
                                        </td>
                                        <td>
                                            {{ $item->jenispasien }}
                                        </td>
                                        <td>
                                            @if ($item->jeniskunjungan == 0)
                                                Offline
                                            @endif
                                            @if ($item->jeniskunjungan == 1)
                                                Rujukan FKTP
                                            @endif
                                            @if ($item->jeniskunjungan == 3)
                                                Kontrol
                                            @endif
                                            @if ($item->jeniskunjungan == 4)
                                                Rujukan RS
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item->namapoli }}
                                        </td>
                                        <td>
                                            {{ $item->kodedokter }} - {{ substr($item->namadokter, 0, 19) }}...
                                        </td>
                                        <td>
                                            @if ($item->taskid == 0)
                                                <span class="badge bg-secondary">0. Antri Pendaftaran</span>
                                            @endif
                                            @if ($item->taskid == 1)
                                                <span class="badge bg-secondary">{{ $item->taskid }}. Chekcin</span>
                                            @endif
                                            @if ($item->taskid == 2)
                                                <span class="badge bg-secondary">{{ $item->taskid }}. Pendaftaran</span>
                                            @endif
                                            @if ($item->taskid == 3)
                                                @if ($item->status_api == 0)
                                                    <span class="badge bg-warning">{{ $item->taskid }}. Belum
                                                        Pembayaran</span>
                                                @else
                                                    <span class="badge bg-warning">{{ $item->taskid }}. Tunggu
                                                        Poli</span>
                                                @endif
                                            @endif
                                            @if ($item->taskid == 4)
                                                <span class="badge bg-success">{{ $item->taskid }}. Periksa Poli</span>
                                            @endif
                                            @if ($item->taskid == 5)
                                                @if ($item->status_api == 0)
                                                    <span class="badge bg-success">{{ $item->taskid }}. Tunggu
                                                        Farmasi</span>
                                                @endif
                                                @if ($item->status_api == 1)
                                                    <span class="badge bg-success">{{ $item->taskid }}. Selesai</span>
                                                @endif
                                            @endif
                                            @if ($item->taskid == 6)
                                                <span class="badge bg-success">{{ $item->taskid }}. Racik Obat</span>
                                            @endif
                                            @if ($item->taskid == 7)
                                                <span class="badge bg-success">{{ $item->taskid }}. Selesai</span>
                                            @endif
                                            @if ($item->taskid == 99)
                                                <span class="badge bg-danger">{{ $item->taskid }}. Batal</span>
                                            @endif
                                        </td>
                                        <td>
                                            Loket {{ $item->loket }}
                                        </td>
                                        <td>
                                            <form action="" method="GET">
                                                <input type="hidden" name="kodebooking" value="{{ $item->kodebooking }}">
                                                <input type="hidden" name="lantai" value="{{ $request->lantai }}">
                                                <input type="hidden" name="loket" value="{{ $request->loket }}">
                                                <x-adminlte-button class="btn-xs" theme="success" label="Layani"
                                                    icon="fas fa-user-plus" type="submit" />

                                                <x-adminlte-button class="btn-xs mt-1 withLoad" label="Panggil"
                                                    theme="primary" icon="fas fa-volume-down" data-toggle="tooltip"
                                                    title="Panggil Antrian {{ $item->nomorantrean }}"
                                                    onclick="window.location='{{ route('panggilPendaftaran', [$item->kodebooking, $request->loket, $request->lantai]) }}'" />

                                                <x-adminlte-button class="btn-xs mt-1 withLoad" theme="danger"
                                                    icon="fas fa-times" data-toggle="tooltop"
                                                    title="Batal Antrian {{ $item->nomorantrean }}"
                                                    onclick="window.location='{{ route('batalAntrian', $item) }}'" />

                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </x-adminlte-datatable>
                        </x-adminlte-card>
                    </div>
                    <div class="col-md-12">
                        <x-adminlte-card title="Total Data Antrian Pasien ({{ $antrians->count() }} Orang)"
                            theme="warning" icon="fas fa-info-circle" collapsible=''>
                            @php
                                $heads = ['No', 'Antrian', 'Pasien', 'Kunjungan', 'Poliklinik', 'Dokter', 'Status', 'Loket', 'Lantai'];
                                $config['order'] = ['0', 'asc'];
                                $config['paging'] = false;
                                $config['info'] = false;
                                $config['scrollY'] = '250px';
                                $config['scrollCollapse'] = true;
                                $config['scrollX'] = true;
                            @endphp
                            <x-adminlte-datatable id="table2" class="nowrap text-xs" :heads="$heads"
                                :config="$config" striped bordered hoverable compressed>
                                @foreach ($antrians as $item)
                                    <tr>
                                        <td>
                                            <b>{{ $item->angkaantrean }} </b>
                                        </td>
                                        <td>
                                            {{ $item->nomorantrean }} / {{ $item->kodebooking }}<br>
                                        </td>
                                        <td>
                                            {{ $item->jenispasien }}
                                        </td>
                                        <td>
                                            @if ($item->jeniskunjungan == 0)
                                                Offline
                                            @endif
                                            @if ($item->jeniskunjungan == 1)
                                                Rujukan FKTP
                                            @endif
                                            @if ($item->jeniskunjungan == 3)
                                                Kontrol
                                            @endif
                                            @if ($item->jeniskunjungan == 4)
                                                Rujukan RS
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item->namapoli }}
                                        </td>
                                        <td>
                                            {{ $item->kodedokter }} - {{ substr($item->namadokter, 0, 19) }}...
                                        </td>
                                        <td>
                                            @if ($item->taskid == 0)
                                                <span class="badge bg-secondary">0. Antri Pendaftaran</span>
                                            @endif
                                            @if ($item->taskid == 1)
                                                <span class="badge bg-secondary">{{ $item->taskid }}. Chekcin</span>
                                            @endif
                                            @if ($item->taskid == 2)
                                                <span class="badge bg-secondary">{{ $item->taskid }}. Pendaftaran</span>
                                            @endif
                                            @if ($item->taskid == 3)
                                                @if ($item->status_api == 0)
                                                    <span class="badge bg-warning">{{ $item->taskid }}. Belum
                                                        Pembayaran</span>
                                                @else
                                                    <span class="badge bg-warning">{{ $item->taskid }}. Tunggu
                                                        Poli</span>
                                                @endif
                                            @endif
                                            @if ($item->taskid == 4)
                                                <span class="badge bg-success">{{ $item->taskid }}. Periksa Poli</span>
                                            @endif
                                            @if ($item->taskid == 5)
                                                @if ($item->status_api == 0)
                                                    <span class="badge bg-success">{{ $item->taskid }}. Tunggu
                                                        Farmasi</span>
                                                @endif
                                                @if ($item->status_api == 1)
                                                    <span class="badge bg-success">{{ $item->taskid }}. Selesai</span>
                                                @endif
                                            @endif
                                            @if ($item->taskid == 6)
                                                <span class="badge bg-success">{{ $item->taskid }}. Racik Obat</span>
                                            @endif
                                            @if ($item->taskid == 7)
                                                <span class="badge bg-success">{{ $item->taskid }}. Selesai</span>
                                            @endif
                                            @if ($item->taskid == 99)
                                                <span class="badge bg-danger">{{ $item->taskid }}. Batal</span>
                                            @endif
                                        </td>
                                        <td>
                                            Loket {{ $item->loket }}
                                        </td>
                                        <td>
                                            Lantai {{ $item->lantaipendaftaran }}
                                        </td>
                                    </tr>
                                @endforeach
                            </x-adminlte-datatable>
                        </x-adminlte-card>
                    </div>
                </div>
                <x-adminlte-modal id="modalPelayanan" title="Pendaftaran Pasien" size="xl" theme="success"
                    icon="fas fa-user-plus" v-centered static-backdrop scrollable>
                    <form name="formLayanan" id="formLayanan" action="" method="post">
                        @csrf
                        <x-adminlte-card theme="primary" title="Informasi Kunjungan Berobat">
                            <input type="hidden" name="antrianid" id="antrianid" value="">
                            <div class="row">
                                <div class="col-md-6">
                                    <dl class="row">
                                        <dt class="col-sm-5">Kode Booking</dt>
                                        <dd class="col-sm-7">: <span id="kodebooking"></span></dd>
                                        <dt class="col-sm-5">Antrian</dt>
                                        <dd class="col-sm-7">: <span id="angkaantrean"></span> / <span
                                                id="nomorantrean"></span>
                                        </dd>
                                        <dt class="col-sm-5 ">Tanggal Perikasa</dt>
                                        <dd class="col-sm-7">: <span id="tanggalperiksa"></span></dd>
                                        <dt class="col-sm-5">Metode Daftar</dt>
                                        <dd class="col-sm-7">: <span id="method"></span></dd>
                                        <dt class="col-sm-5">Poliklinik</dt>
                                        <dd class="col-sm-7">: <span id="namapoli"></span></dd>
                                        <dt class="col-sm-5">Dokter</dt>
                                        <dd class="col-sm-7">: <span id="namadokter"></span></dd>
                                        <dt class="col-sm-5">Jadwal</dt>
                                        <dd class="col-sm-7">: <span id="jampraktek"></span></dd>
                                    </dl>
                                </div>
                                <div class="col-md-6">
                                    <dl class="row">
                                        <dt class="col-sm-5">No RM</dt>
                                        <dd class="col-sm-7">: <span id="norm"></span></dd>
                                        <dt class="col-sm-5">NIK</dt>
                                        <dd class="col-sm-7">: <span id="nik"></span></dd>
                                        <dt class="col-sm-5">No BPJS</dt>
                                        <dd class="col-sm-7">: <span id="nomorkartu"></span></dd>
                                        <dt class="col-sm-5">Nama</dt>
                                        <dd class="col-sm-7">: <span id="nama"></span></dd>
                                        <dt class="col-sm-5">No HP</dt>
                                        <dd class="col-sm-7">: <span id="nohp"></span></dd>
                                        <dt class="col-sm-5">Jenis Pasien</dt>
                                        <dd class="col-sm-7">: <span id="jenispasien"></span></dd>
                                    </dl>
                                </div>
                            </div>
                        </x-adminlte-card>
                        <x-adminlte-card theme="primary" title="Pendaftaran Pasien Baru" collapsible="collapsed">
                            <div class="row">
                                Kosong
                            </div>
                        </x-adminlte-card>
                        <x-slot name="footerSlot">
                            <a href="#" id="lanjutFarmasi" class="btn btn-success mr-auto withLoad"> <i
                                    class="fas fa-prescription-bottle-alt"></i> Lanjut Poliklinik</a>
                            <x-adminlte-button theme="danger" label="Tutup" data-dismiss="modal" />
                        </x-slot>
                    </form>
                </x-adminlte-modal>
            @endif

            @if ($antrian)
                <div class="row">
                    <div class="col-md-12">
                        <x-adminlte-card title="Pencarian Pasien" theme="warning" icon="fas fa-user-injured"
                            collapsible="{{ $request->norm ? 'collapsed' : '' }}">
                            <form action="" method="get">
                                <input type="hidden" name="kodebooking" value="{{ $request->kodebooking }}">
                                <input type="hidden" name="lantai" value="{{ $request->lantai }}">
                                <input type="hidden" name="loket" value="{{ $request->loket }}">
                                <x-adminlte-input name="search" placeholder="Pencarian NIK / Nama" igroup-size="sm"
                                    value="{{ $request->search }}">
                                    <x-slot name="appendSlot">
                                        <x-adminlte-button type="submit" theme="outline-primary" label="Cari" />
                                    </x-slot>
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text text-primary">
                                            <i class="fas fa-search"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input>
                            </form>
                            @php
                                $heads = ['Tgl Entry', 'No RM', 'NIK', 'No BPJS', 'Nama', 'Alamat', 'No HP', 'Action'];
                                $config['order'] = ['0', 'desc'];
                                $config['paging'] = false;
                                $config['info'] = false;
                                $config['searching'] = false;
                                $config['scrollY'] = '400px';
                                $config['scrollCollapse'] = true;
                                $config['scrollX'] = true;
                            @endphp
                            <x-adminlte-datatable id="table1" class="nowrap text-xs" :heads="$heads"
                                :config="$config" bordered hoverable compressed>
                                @foreach ($pasiens as $pasienx)
                                    <tr>
                                        <td>{{ $pasienx->tgl_entry }}</td>
                                        <td>{{ $pasienx->no_rm }}</td>
                                        <td>{{ $pasienx->nik_bpjs }}</td>
                                        <td>{{ $pasienx->no_Bpjs }}</td>
                                        <td>{{ $pasienx->nama_px }}</td>
                                        <td>{{ $pasienx->kecamatans->nama_kecamatan }}</td>
                                        <td>{{ $pasienx->no_hp ?? $pasienx->no_tlp }}</td>
                                        <td>
                                            <form action="" method="GET">
                                                <input type="hidden" name="kodebooking"
                                                    value="{{ $request->kodebooking }}">
                                                <input type="hidden" name="lantai" value="{{ $request->lantai }}">
                                                <input type="hidden" name="loket" value="{{ $request->loket }}">
                                                <input type="hidden" name="norm" value="{{ $pasienx->no_rm }}">
                                                <x-adminlte-button class="btn-xs withLoad" theme="success" label="Daftar"
                                                    icon="fas fa-user-plus" type="submit" />
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </x-adminlte-datatable>
                        </x-adminlte-card>
                    </div>
                    @if ($pasien)
                        <div class="col-md-5">
                            <x-adminlte-profile-widget name="{{ $pasien->nama_px }}"
                                desc="{{ $pasien->no_rm }} | {{ $pasien->no_Bpjs }} " theme="primary"
                                img="https://picsum.photos/id/1/100" layout-type="classic">
                                <dl class="row">
                                    <dt class="col-sm-4">NIK</dt>
                                    <dd class="col-sm-8">: {{ $peserta->nik ?? $pasien->nik_bpjs }}</dd>
                                    <dt class="col-sm-4">No Kartu</dt>
                                    <dd class="col-sm-8">: {{ $peserta->noKartu ?? $pasien->no_Bpjs }}</dd>
                                    <dt class="col-sm-4">No RM</dt>
                                    <dd class="col-sm-8">: {{ $peserta->mr->noMR ?? $pasien->no_rm }}</dd>
                                    <dt class="col-sm-4">No HP</dt>
                                    <dd class="col-sm-8">: {{ $peserta->mr->noTelepon ?? $pasien->no_hp }}</dd>
                                    <dt class="col-sm-4">Nama</dt>
                                    <dd class="col-sm-8">: {{ $peserta->nama ?? $pasien->nama_px }}</dd>
                                    <dt class="col-sm-4">Jenis Kelamin</dt>
                                    <dd class="col-sm-8">: {{ $peserta->sex ?? $pasien->jenis_kelamin }}</dd>
                                    <dt class="col-sm-4">Tanggal Lahir</dt>
                                    <dd class="col-sm-8">: {{ $peserta->tglLahir ?? $pasien->tgl_lahir }}</dd>
                                    <dt class="col-sm-4">Umur</dt>
                                    <dd class="col-sm-8">: {{ $peserta->umur->umurSekarang ?? 'Belum Terdaftar BPJS' }}
                                    </dd>
                                    <dt class="col-sm-4">Pisa</dt>
                                    <dd class="col-sm-8">: {{ $peserta->pisa ?? 'Belum Terdaftar BPJS' }}</dd>

                                    <dt class="col-sm-4">Status Peserta</dt>
                                    <dd class="col-sm-8">:
                                        {{ $peserta->statusPeserta->keterangan ?? 'Belum Terdaftar BPJS' }}
                                    </dd>
                                    <dt class="col-sm-4">Hak Kelas</dt>
                                    <dd class="col-sm-8">: {{ $peserta->hakKelas->keterangan ?? 'Belum Terdaftar BPJS' }}
                                    </dd>
                                    <dt class="col-sm-4">Jenis Peserta</dt>
                                    <dd class="col-sm-8">:
                                        {{ $peserta->jenisPeserta->keterangan ?? 'Belum Terdaftar BPJS' }}
                                    </dd>
                                    <dt class="col-sm-4">Faskes 1</dt>
                                    <dd class="col-sm-8">: {{ $peserta->provUmum->nmProvider ?? '' }}
                                        {{ $peserta->provUmum->kdProvider ?? 'Belum Terdaftar BPJS' }}
                                    </dd>
                                </dl>
                                <x-adminlte-button icon="fas fa-file-medical" theme="primary" class="mr-auto mb-1"
                                    label="Riwayat Kunjungan ({{ $pasien->kunjungans->count() }})" data-toggle="modal"
                                    data-target="#riwayatKunjungan" />
                                <x-adminlte-modal id="riwayatKunjungan" title="Riwayat Kunjungan" theme="warning"
                                    icon="fas fa-file-medical" size='xl'>
                                    <table id="tableKunjungan" class="table table-sm table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Tgl Masuk</th>
                                                <th>Tgl Keluar</th>
                                                <th>Penjamin</th>
                                                <th>Unit</th>
                                                <th>Dokter</th>
                                                <th>Catatan</th>
                                                <th>SEP</th>
                                                <th>Rujukan</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pasien->kunjungans as $kunjungan)
                                                <tr>
                                                    <td>{{ $kunjungan->tgl_masuk }}</td>
                                                    <td>{{ $kunjungan->tgl_keluar }}</td>
                                                    <td>{{ $kunjungan->penjamin_simrs->nama_penjamin ?? $kunjungan->kode_penjamin }}
                                                    </td>
                                                    <td>{{ $kunjungan->unit->nama_unit }}</td>
                                                    <td>{{ $kunjungan->dokter->nama_paramedis ?? $kunjungan->dokter }}</td>
                                                    <td>{{ $kunjungan->no_sep }}</td>
                                                    <td>{{ $kunjungan->no_rujukan }}</td>
                                                    <td>{{ $kunjungan->status->status_kunjungan ?? '-' }}</td>
                                                    <td>-</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </x-adminlte-modal>
                                <x-adminlte-button id="btnRiwayatRujukan" icon="fas fa-file-medical" class="mr-auto mb-1"
                                    theme="primary" label="Riwayat Rujukan" />
                                <x-adminlte-modal id="riwayatRujukan" title="Riwayat Rujukan" theme="warning"
                                    icon="fas fa-file-medical" size='xl'>
                                    <table id="tableRujukan" class="table table-sm table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tgl</th>
                                                <th>No Rujukan</th>
                                                <th>Pelayanan</th>
                                                <th>Tujuan</th>
                                                <th>Diagnosa</th>
                                                <th>Pasien</th>
                                                <th>Provider</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </x-adminlte-modal>
                                <x-adminlte-button id="btnRiwayatSuratKontrol" icon="fas fa-file-medical" theme="primary"
                                    label="Riwayat Surat Kontrol" class="mr-auto mb-1" />
                                <x-adminlte-modal id="riwayatSuratKontrol" title="Riwayat Surat Kontrol" theme="warning"
                                    icon="fas fa-file-medical" size='xl'>
                                    <table id="tableSuratKontrol" class="table table-sm table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Tgl Kontrol</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </x-adminlte-modal>
                            </x-adminlte-profile-widget>
                        </div>
                        <div class="col-md-7">
                            <x-adminlte-card title="Pendaftaran Pasien" theme="success" icon="fas fa-user-plus"
                                collapsible>
                                <form action="{{ route('daftarBridgingAntrian') }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <x-adminlte-input name="kodebooking" label="Kodebooking"
                                        value="{{ $antrian->kodebooking }}" readonly />
                                    <x-adminlte-input name="nomorantrean" label="Nomor Antri"
                                        value="{{ $antrian->nomorantrean }}" readonly />
                                    <x-adminlte-input name="angkaantrean" label="Angka Antri"
                                        value="{{ $antrian->angkaantrean }}" readonly />
                                    <x-adminlte-input name="jampraktek" label="Jam Praktek"
                                        value="{{ $antrian->jampraktek }}" readonly />
                                    <x-adminlte-input name="tanggalperiksa" label="Tanggal Periksa"
                                        value="{{ $antrian->tanggalperiksa }}" readonly />
                                    <x-adminlte-select name="jenispasien" label="Jenis Pasien">
                                        <x-adminlte-options :options="[
                                            'JKN' => 'JKN',
                                            'NON-JKN' => 'NON-JKN',
                                        ]" :selected="$antrian->jenispasien" />
                                    </x-adminlte-select>
                                    <x-adminlte-select2 name="kodepoli" label="Poliklinik">
                                        @foreach ($polikliniks as $item)
                                            <option value="{{ $item->kodesubspesialis }}"
                                                {{ $item->kodesubspesialis == $antrian->kodepoli ? 'selected' : '' }}>
                                                {{ $item->namasubspesialis }}
                                            </option>
                                        @endforeach
                                    </x-adminlte-select2>
                                    <x-adminlte-select2 name="kodedokter" label="Dokter">
                                        @foreach ($dokters as $item)
                                            <option value="{{ $item->kodedokter }}"
                                                {{ $item->kodedokter == $antrian->kodedokter ? 'selected' : '' }}>
                                                {{ $item->namadokter }}
                                            </option>
                                        @endforeach
                                    </x-adminlte-select2>
                                    <x-adminlte-input name="norm" label="No RM" value="{{ $pasien->no_rm }}"
                                        readonly />
                                    <x-adminlte-input name="nama" label="Nama Pasien" value="{{ $pasien->nama_px }}"
                                        readonly />
                                    <x-adminlte-input name="nomorkartu" label="No BPJS"
                                        value="{{ $pasien->no_Bpjs }}" />
                                    <x-adminlte-input name="nik" label="NIK" value="{{ $pasien->nik_bpjs }}"
                                        required />
                                    <x-adminlte-input name="nohp" label="No HP" value="{{ $pasien->no_hp }}"
                                        required />
                                    <x-adminlte-select name="jeniskunjungan" label="Jenis Pasien">
                                        <x-adminlte-options :options="[
                                            1 => 'RUJUKAN FKTP',
                                            2 => 'RUJUKAN INTERNAL',
                                            3 => 'SURAT KONTROL',
                                            4 => 'RUJUKAN ANTAR-RS',
                                        ]" :selected="$antrian->jeniskunjungan" />
                                    </x-adminlte-select>
                                    <x-adminlte-input name="nomorreferensi"
                                        label="No Referensi (Rujukan / Surat Kontrol)" />
                                    <x-adminlte-button type="submit" icon="fas fa-user-add" theme="success"
                                        label="Daftar" class="mr-auto mb-1" />
                                </form>
                            </x-adminlte-card>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)

@section('js')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#tableKunjungan').DataTable();
            $('#btnRiwayatRujukan').click(function() {
                // $.LoadingOverlay("show");
                var url = "{{ route('vclaim.rujukan_peserta') }}";
                var nomorkartu = $('#nomorkartu').val();
                var data = {
                    nomorkartu: nomorkartu,
                }
                $.ajax({
                    data: data,
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        swal.fire(
                            'Success ' + data.metadata.code,
                            data.metadata.message,
                            'success'
                        );
                        var table = $('#tableRujukan').DataTable();
                        if (data.response) {
                            table.rows().remove().draw();
                            var rujukans = data.response.rujukan;
                            $.each(rujukans, function(key, value) {
                                table.row.add([
                                    key + 1,
                                    value.tglKunjungan,
                                    value.noKunjungan,
                                    value.pelayanan.nama,
                                    value.poliRujukan.nama,
                                    value.diagnosa.kode + ' ' + value.diagnosa
                                    .nama,
                                    value.peserta.nama,
                                    value.provPerujuk.nama,
                                    "<button class='btn btn-warning btn-xs btnPilihRujukan' data-id=" +
                                    value.noKunjungan +
                                    ">Pilih</button>",
                                ]).draw(false);
                                $('.btnPilihRujukan').click(function() {
                                    nomorrujukan = $(this).data("id");
                                    $('#nomorreferensi').val(nomorrujukan);
                                    $('#riwayatRujukan').modal('hide');
                                    // alert(nomorrujukan);

                                });
                            })
                        }
                    },
                    error: function(data) {
                        console.log(data.metadata);
                        // swal.fire(
                        //     'Error ' + data.metadata.code,
                        //     data.metadata.message,
                        //     'error'
                        // );
                        var table = $('#tableSuratKontrol').DataTable();
                        table.rows().remove().draw();
                    },
                    complete: function(data) {
                        $('#riwayatRujukan').modal('show');
                        $.LoadingOverlay("hide", true);
                    }
                });
            });
            $('#btnRiwayatSuratKontrol').click(function() {
                $.LoadingOverlay("show");
                var nomorkartu = $('#nomorkartu').val();
                var bulan = "{{ now()->month }}";
                var tahun = "{{ now()->year }}";
                var data = {
                    nomorkartu: nomorkartu,
                    bulan: bulan,
                    formatfilter: 2,
                    tahun: tahun,
                }
                var url = "{{ route('vclaim.suratkontrol_peserta') }}";
                $.ajax({
                    data: data,
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        swal.fire(
                            'Success ' + data.metadata.code,
                            data.metadata.message,
                            'success'
                        );
                        var table = $('#tableSuratKontrol').DataTable();
                        table.rows().remove().draw();
                        if (data.response) {
                            var suratkontrols = data.response.list;
                            $.each(suratkontrols, function(key, value) {
                                table.row.add([,
                                    value.tglRencanaKontrol,
                                    "<button class='btn btn-warning btn-xs pilihRujukan' data-id=" +
                                    value.noKunjungan +
                                    ">Pilih</button>",
                                ]).draw(false);
                            })
                        }
                    },
                    error: function(data) {
                        swal.fire(
                            data.statusText + ' ' + data.status,
                            data.responseJSON.data,
                            'error'
                        );
                        var table = $('#tableSuratKontrol').DataTable();
                        table.rows().remove().draw();
                    },
                    complete: function(data) {
                        $('#riwayatSuratKontrol').modal('show');
                        $.LoadingOverlay("hide");
                    }
                });
            });

        });
    </script>
@endsection
