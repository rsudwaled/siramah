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
            <dt class="col-sm-4 m-0">Tgl Keluar</dt>
            <dd class="col-sm-8 m-0">{{ $kunjungan->tgl_keluar ?? '-' }}</dd>
            <dt class="col-sm-4 m-0">Alasan Pulang</dt>
            <dd class="col-sm-8 m-0">{{ $kunjungan->alasan_pulang->alasan_pulang ?? '-' }}</dd>
            <dt class="col-sm-4 m-0">Surat Kontrol</dt>
            <dd class="col-sm-8 m-0">{{ $kunjungan->surat_kontrol->noSuratKontrol ?? '-' }}</dd>
        </dl>
    </div>
</div>
