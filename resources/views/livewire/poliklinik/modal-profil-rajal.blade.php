<div class="row">
    <style>
        .table-xs td,
        .table-xs th {
            padding: 0px;
        }
    </style>
    <div class="col-md-3">
        <table class="table table-xs table-borderless">
            <tr>
                <td>Tgl Masuk</td>
                <td>:</td>
                <th>{{ $kunjungan->tgl_masuk }}</th>
            </tr>
            <tr>
                <td>Unit</td>
                <td>:</td>
                <th>{{ $kunjungan->unit->nama_unit }}</th>
            </tr>
            <tr>
                <td>Dokter</td>
                <td>:</td>
                <th>{{ $kunjungan->dokter->nama_paramedis }}</th>
            </tr>
        </table>
    </div>
    <div class="col-md-3">
        <table class="table table-xs table-borderless">
            <tr>
                <td>RM</td>
                <td>:</td>
                <th>{{ $kunjungan->no_rm }}</th>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <th>
                    {{ $kunjungan->pasien?->nama_px }}
                    ({{ $kunjungan->pasien?->jenis_kelamin }})

                </th>
            </tr>
            <tr>
                <td>Tgl Lahir</td>
                <td>:</td>
                <th>
                    {{ $kunjungan->pasien?->tgl_lahir }}
                    ({{ \Carbon\Carbon::parse($kunjungan->tgl_masuk)->diffInYears($kunjungan->pasien?->tgl_lahir) }}
                    tahun)
                </th>
            </tr>
            <tr>
                <td>Np BPJS</td>
                <td>:</td>
                <th>{{ $kunjungan->pasien?->no_Bpjs }}</th>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <th>{{ $kunjungan->pasien?->nik_bpjs }}</th>
            </tr>
        </table>
    </div>
    <div class="col-md-3">
        <table class="table table-xs table-borderless">
            <tr>
                <td>SEP</td>
                <td>:</td>
                <th>{{ $kunjungan->no_sep }}</th>
            </tr>
            <tr>
                <td>Jenis Kunjungan</td>
                <td>:</td>
                <th>
                </th>
            </tr>
            <tr>
                <td>Referensi</td>
                <td>:</td>
                <th>
                </th>
            </tr>
            <tr>
                <td>Surat Kontrol</td>
                <td>:</td>
                <th>
                </th>
            </tr>

        </table>
    </div>
</div>
