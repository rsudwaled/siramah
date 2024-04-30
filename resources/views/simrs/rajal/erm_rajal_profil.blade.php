<a href="{{ route('kunjunganrajal') }}?kode_unit={{ $kunjungan->kode_unit }}&kode_paramedis=-&tgl_masuk={{ \Carbon\Carbon::parse($pasien->tgl_masuk)->format('Y-m-d') }}"
    class="btn btn-xs mb-2 btn-danger withLoad"><i class="fas fa-arrow-left"></i> Kembali</a>
@if ($kunjungan->antrian)
    @if ($kunjungan->antrian->taskid == 3)
        @if ($kunjungan->antrian->status_api == 1)
            <x-adminlte-button class="btn-xs mb-2 withLoad" label="Panggil" theme="warning" icon="fas fa-volume-down"
                data-toggle="tooltip" title="Panggil Antrian {{ $kunjungan->antrian->nomorantrean }}"
                onclick="window.location='{{ route('panggilPoliklinik') }}?kodebooking={{ $kunjungan->antrian->kodebooking }}'" />
        @endif
    @endif
    @if ($kunjungan->antrian->taskid == 4)
        @if ($kunjungan->antrian->status_api == 1)
            <x-adminlte-button class="btn-xs mb-2 withLoad" label="Panggil" theme="warning" icon="fas fa-volume-down"
                data-toggle="tooltip" title="Panggil Antrian {{ $kunjungan->antrian->nomorantrean }}"
                onclick="window.location='{{ route('panggilPoliklinik') }}?kodebooking={{ $kunjungan->antrian->kodebooking }}'" />
            <x-adminlte-button class="btn-xs mb-2 withLoad" label="Lanjut Farmasi" theme="warning" icon="fas fa-pills"
                data-toggle="tooltip" title="Panggil Antrian {{ $kunjungan->antrian->nomorantrean }}"
                onclick="window.location='{{ route('lanjutFarmasi') }}?kodebooking={{ $kunjungan->antrian->kodebooking }}'" />
            <x-adminlte-button class="btn-xs mb-2 withLoad" label="Lanjut Racikan" theme="warning" icon="fas fa-pills"
                data-toggle="tooltip" title="Panggil Antrian {{ $kunjungan->antrian->nomorantrean }}"
                onclick="window.location='{{ route('lanjutFarmasiRacikan') }}?kodebooking={{ $kunjungan->antrian->kodebooking }}'" />
            <x-adminlte-button class="btn-xs mb-2 withLoad" label="Selesai" theme="warning" icon="fas fa-clinic-medical"
                data-toggle="tooltip" title="Panggil Antrian {{ $kunjungan->antrian->nomorantrean }}"
                onclick="window.location='{{ route('panggilPoliklinik') }}?kodebooking={{ $kunjungan->antrian->kodebooking }}'" />
        @endif
    @endif
    @if ($kunjungan->antrian->taskid == 0)
        <button class="btn btn-xs mb-2 btn-secondary">Belum Checkin</button>
    @endif
    @if ($kunjungan->antrian->taskid == 1)
        <button class="btn btn-xs mb-2 btn-secondary">{{ $kunjungan->antrian->taskid }}. Chekcin</button>
    @endif
    @if ($kunjungan->antrian->taskid == 2)
        <button class="btn btn-xs mb-2 btn-secondary">{{ $kunjungan->antrian->taskid }}.
            Pendaftaran</button>
    @endif
    @if ($kunjungan->antrian->taskid == 3)
        @if ($kunjungan->antrian->status_api == 0)
            <button class="btn btn-xs mb-2 btn-warning">{{ $kunjungan->antrian->taskid }}. Belum
                Pembayaran</button>
        @else
            <button class="btn btn-xs mb-2 btn-warning">{{ $kunjungan->antrian->taskid }}. Tunggu
                Poli</button>
        @endif
    @endif
    @if ($kunjungan->antrian->taskid == 4)
        <button class="btn btn-xs mb-2 btn-success">{{ $kunjungan->antrian->taskid }}. Periksa
            Poli</button>
    @endif
    @if ($kunjungan->antrian->taskid == 5)
        @if ($kunjungan->antrian->status_api == 0)
            <button class="btn btn-xs mb-2 btn-success">{{ $kunjungan->antrian->taskid }}. Tunggu
                Farmasi</button>
        @endif
        @if ($kunjungan->antrian->status_api == 1)
            <button class="btn btn-xs mb-2 btn-success">{{ $kunjungan->antrian->taskid }}. Selesai</button>
        @endif
    @endif
    @if ($kunjungan->antrian->taskid == 6)
        <button class="btn btn-xs mb-2 btn-success">{{ $kunjungan->antrian->taskid }}. Racik Obat</button>
    @endif
    @if ($kunjungan->antrian->taskid == 7)
        <button class="btn btn-xs mb-2 btn-success">{{ $kunjungan->antrian->taskid }}. Selesai</button>
    @endif
    @if ($kunjungan->antrian->taskid == 99)
        <button class="btn btn-xs mb-2 btn-danger">{{ $kunjungan->antrian->taskid }}. Batal</button>
    @endif
@else
    <button class="btn btn-xs mb-2 btn-secondary">Belum Bridging</button>
@endif

<div class="row">
    <div class="col-md-3">
        <dl class="row">
            <dt class="col-sm-4 m-0">Nama</dt>
            <dd class="col-sm-8 m-0">{{ $pasien->nama_px }} ({{ $pasien->jenis_kelamin }})</dd>
            <dt class="col-sm-4 m-0">No RM</dt>
            <dd class="col-sm-8 m-0">{{ $pasien->no_rm }}</dd>
            <dt class="col-sm-4 m-0">NIK</dt>
            <dd class="col-sm-8 m-0">{{ $pasien->nik_bpjs }}</dd>
            <dt class="col-sm-4 m-0">No BPJS</dt>
            <dd class="col-sm-8 m-0">{{ $pasien->no_Bpjs }}</dd>
            <dt class="col-sm-4 m-0">Tgl Lahir</dt>
            <dd class="col-sm-8 m-0">{{ \Carbon\Carbon::parse($pasien->tgl_lahir)->format('Y-m-d') }} (
                @if (\Carbon\Carbon::parse($pasien->tgl_lahir)->age)
                    {{ \Carbon\Carbon::parse($pasien->tgl_lahir)->age }} tahun
                @else
                    {{ \Carbon\Carbon::parse($pasien->tgl_lahir)->diffInDays(now()) }} hari
                @endif
                )
            </dd>
        </dl>
    </div>
    <div class="col-md-3">
        <dl class="row">
            <dt class="col-sm-4 m-0">Tgl Masuk</dt>
            <dd class="col-sm-8 m-0">{{ $kunjungan->tgl_masuk }}</dd>
            <dt class="col-sm-4 m-0">Alasan Masuk</dt>
            <dd class="col-sm-8 m-0">{{ $kunjungan->alasan_masuk->alasan_masuk }}</dd>
            <dt class="col-sm-4 m-0">Ruangan / Kelas</dt>
            <dd class="col-sm-8 m-0">{{ $kunjungan->unit->nama_unit }} / {{ $kunjungan->kelas }}</dd>
            <dt class="col-sm-4 m-0">Dokter DPJP</dt>
            <dd class="col-sm-8 m-0">{{ $kunjungan->dokter->nama_paramedis }}</dd>
            <dt class="col-sm-4 m-0">Penjamin</dt>
            <dd class="col-sm-8 m-0">{{ $kunjungan->penjamin_simrs->nama_penjamin }}
            </dd>
        </dl>
    </div>
    <div class="col-md-3">
        <dl class="row">
            <dt class="col-sm-4 m-0">No SEP</dt>
            <dd class="col-sm-8 m-0">{{ $kunjungan->no_sep }}</dd>
            <dt class="col-sm-4 m-0">Tarif RS</dt>
            <dd class="col-sm-8 m-0"> Rp. <span class="biaya_rs_html">-</span></dd>
            <dt class="col-sm-4 m-0">Tarif E-Klaim</dt>
            <dd class="col-sm-8 m-0">Rp. <span class="tarif_eklaim_html">-</span></dd>
            <dt class="col-sm-4 m-0">Groupping</dt>
            <dd class="col-sm-8 m-0"><span class="code_cbg_html">-</span></dd>
        </dl>
    </div>
    <div class="col-md-3">
        <dl class="row">
            <dt class="col-sm-4 m-0">Status</dt>
            <dd class="col-sm-8 m-0">
                @if ($kunjungan->status_kunjungan == 1)
                    <span class="badge badge-success">{{ $kunjungan->status->status_kunjungan }}</span>
                @else
                    <span class="badge badge-danger">{{ $kunjungan->status->status_kunjungan }}</span>
                @endif
            </dd>
            <dt class="col-sm-4 m-0">Taskid</dt>
            <dd class="col-sm-8 m-0">
                @if ($kunjungan->antrian)
                    @if ($kunjungan->antrian->taskid == 0)
                        <span class="badge bg-secondary">Belum Checkin</span>
                    @endif
                    @if ($kunjungan->antrian->taskid == 1)
                        <span class="badge bg-secondary">{{ $kunjungan->antrian->taskid }}. Chekcin</span>
                    @endif
                    @if ($kunjungan->antrian->taskid == 2)
                        <span class="badge bg-secondary">{{ $kunjungan->antrian->taskid }}.
                            Pendaftaran</span>
                    @endif
                    @if ($kunjungan->antrian->taskid == 3)
                        @if ($kunjungan->antrian->status_api == 0)
                            <span class="badge bg-warning">{{ $kunjungan->antrian->taskid }}. Belum
                                Pembayaran</span>
                        @else
                            <span class="badge bg-warning">{{ $kunjungan->antrian->taskid }}. Tunggu
                                Poli</span>
                        @endif
                    @endif
                    @if ($kunjungan->antrian->taskid == 4)
                        <span class="badge bg-success">{{ $kunjungan->antrian->taskid }}. Periksa
                            Poli</span>
                    @endif
                    @if ($kunjungan->antrian->taskid == 5)
                        @if ($kunjungan->antrian->status_api == 0)
                            <span class="badge bg-success">{{ $kunjungan->antrian->taskid }}. Tunggu
                                Farmasi</span>
                        @endif
                        @if ($kunjungan->antrian->status_api == 1)
                            <span class="badge bg-success">{{ $kunjungan->antrian->taskid }}. Selesai</span>
                        @endif
                    @endif
                    @if ($kunjungan->antrian->taskid == 6)
                        <span class="badge bg-success">{{ $kunjungan->antrian->taskid }}. Racik Obat</span>
                    @endif
                    @if ($kunjungan->antrian->taskid == 7)
                        <span class="badge bg-success">{{ $kunjungan->antrian->taskid }}. Selesai</span>
                    @endif
                    @if ($kunjungan->antrian->taskid == 99)
                        <span class="badge bg-danger">{{ $kunjungan->antrian->taskid }}. Batal</span>
                    @endif
                @else
                    <span class="badge bg-secondary">Belum Bridging</span>
                @endif
            </dd>
            <dt class="col-sm-4 m-0">Alasan Pulang</dt>
            <dd class="col-sm-8 m-0">{{ $kunjungan->alasan_pulang->alasan_pulang ?? '-' }}</dd>
            <dt class="col-sm-4 m-0">Surat Kontrol</dt>
            <dd class="col-sm-8 m-0">{{ $kunjungan->surat_kontrol->noSuratKontrol ?? '-' }}</dd>
        </dl>
    </div>
</div>
