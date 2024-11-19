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
                <td>No Antrian</td>
                <td>:</td>
                <th>
                    {{ $kunjungan->antrian?->nomorantrean }}
                </th>
            </tr>
            <tr>
                <td>Tgl Masuk</td>
                <td>:</td>
                <th>{{ $kunjungan->tgl_masuk }}</th>
            </tr>
            <tr>
                <td>Unit</td>
                <td>:</td>
                <th>{{ $kunjungan->unit?->nama_unit }}</th>
            </tr>
            <tr>
                <td>Dokter</td>
                <td>:</td>
                <th>{{ $kunjungan->dokter?->nama_paramedis }}</th>
            </tr>
            <tr>
                <td>Taskid</td>
                <td>:</td>
                <th>{{ $kunjungan->antrian?->taskid }}</th>
            </tr>
        </table>
    </div>
    <div class="col-md-3">
        <table class="table table-xs table-borderless text-nowrap">
            <tr>
                <td>RM</td>
                <td>:</td>
                <th>{{ $kunjungan->pasien?->no_rm }}</th>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <th>{{ $kunjungan->pasien?->nama_px }}</th>
            </tr>
            <tr>
                <td>Tgl Lahir</td>
                <td>:</td>
                <th>
                    {{ \Carbon\Carbon::parse($kunjungan->pasien?->tgl_lahir)->format('d M Y') }}
                    ({{ \Carbon\Carbon::parse($kunjungan->tgl_masuk)->diffInYears($kunjungan->pasien?->tgl_lahir) }}
                    tahun)
                </th>
            </tr>
            <tr>
                <td>No BPJS</td>
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
                <td>Kunjungan</td>
                <td>:</td>
                <th>{{ $kunjungan->kode_kunjungan }}</th>
            </tr>
            <tr>
                <td>Jenis</td>
                <td>:</td>
                <th>{{ $kunjungan->kode_kunjungan }}</th>
            </tr>
            <tr>
                <td>Status</td>
                <td>:</td>
                <th>{{ $kunjungan->status->status_kunjungan }}</th>
            </tr>
            <tr>
                <td>SEP</td>
                <td>:</td>
                <th>{{ $kunjungan->no_sep }}</th>
            </tr>
        </table>
    </div>
    <div class="col-md-3">
        <table class="table table-xs table-borderless">
            <tr>
                <td>Pendaftaran</td>
                <td>:</td>
                <th>{{ $kunjungan->pic1 }}</th>
            </tr>
            <tr>
                <td>Perawat</td>
                <td>:</td>
                <td></td>
                {{-- <th>{{ $kunjungan->as }}</th> --}}
            </tr>
            <tr>
                <td>Dokter</td>
                <td>:</td>
                <td></td>
                {{-- <th>{{ $kunjungan->as }}</th> --}}
            </tr>
            <tr>
                <td>Farmasi</td>
                <td>:</td>
                <td></td>
                {{-- <th>{{ $kunjungan->as }}</th> --}}
            </tr>
        </table>
    </div>
</div>
