<div class="row">
    <div class="col-md-4">
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
            <dd class="col-sm-8 m-0">{{ \Carbon\Carbon::parse( $pasien->tgl_lahir)->format('Y-m-d') }}</dd>
            <br><br>
            <dt class="col-sm-4 m-0">Tgl Masuk</dt>
            <dd class="col-sm-8 m-0">{{ $kunjungan->tgl_masuk }}</dd>
            <dt class="col-sm-4 m-0">Alasan Masuk</dt>
            <dd class="col-sm-8 m-0">{{ $kunjungan->alasan_masuk->alasan_masuk }}</dd>
            <dt class="col-sm-4 m-0">Ruangan / Kelas</dt>
            <dd class="col-sm-8 m-0">{{ $kunjungan->unit->nama_unit }} / {{ $kunjungan->kelas }}</dd>
            <dt class="col-sm-4 m-0">Dokter DPJP</dt>
            <dd class="col-sm-8 m-0">{{ $kunjungan->dokter->nama_paramedis }}</dd>
        </dl>
    </div>
    <div class="col-md-4">
        <dl class="row">
            <dt class="col-sm-4 m-0">Penjamin</dt>
            <dd class="col-sm-8 m-0">{{ $kunjungan->penjamin_simrs->nama_penjamin }}
            </dd>
            <dt class="col-sm-4 m-0">No SEP</dt>
            <dd class="col-sm-8 m-0">{{ $kunjungan->no_sep }}</dd>
            <dt class="col-sm-4 m-0">Tarif RS</dt>
            <dd class="col-sm-8 m-0">{{ money($biaya_rs, 'IDR') }}
                @if ($kunjungan->budget)
                    @if ($biaya_rs > $kunjungan->budget->tarif_inacbg)
                        <span class="badge badge-danger">Over Budget</span>
                    @else
                        <span class="badge badge-success">Safe Budget</span>
                    @endif
                @else
                    <span class="badge badge-danger">Belum Groupping</span>
                @endif
            </dd>
            <dt class="col-sm-4 m-0">Tarif E-Klaim</dt>
            <dd class="col-sm-8 m-0">{{ money($kunjungan->budget->tarif_inacbg ?? 0, 'IDR') }}</dd>
            <dt class="col-sm-4 m-0">Groupping</dt>
            <dd class="col-sm-8 m-0">{{ $kunjungan->budget->kode_cbg ?? 'Belum Groupping' }}</dd>
        </dl>
    </div>
    <div class="col-md-4">
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
