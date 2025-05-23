<x-adminlte-card theme="primary" theme-mode="outline">
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
                    <td>Tgl Pulang</td>
                    <td>:</td>
                    <th>{{ $kunjungan->tgl_keluar }}</th>
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
                    <th>{{ $kunjungan->pasien->no_rm }}</th>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <th>{{ $kunjungan->pasien->nama_px }}</th>
                </tr>
                <tr>
                    <td>Tgl Lahir</td>
                    <td>:</td>
                    <th>
                        {{ \Carbon\Carbon::parse($kunjungan->pasien->tgl_lahir)->format('d F Y') }}
                        ({{ \Carbon\Carbon::parse($kunjungan->tgl_masuk)->diffInYears($kunjungan->pasien->tgl_lahir) }}
                        tahun)
                    </th>
                </tr>
                <tr>
                    <td>No BPJS</td>
                    <td>:</td>
                    <th>{{ $kunjungan->pasien->no_Bpjs }}</th>
                </tr>
                <tr>
                    <td>NIK</td>
                    <td>:</td>
                    <th>{{ $kunjungan->pasien->nik_bpjs }}</th>
                </tr>
            </table>
        </div>
        {{-- <div class="col-md-3">
                    <table class="table table-xs table-borderless">
                        <tr>
                            <td>Kunjungan</td>
                            <td>:</td>
                            <th>
                                <span class="badge badge-{{ $antrian->kodekunjungan ? 'success' : 'danger' }}"
        title="{{ $antrian->kodekunjungan ? 'Sudah' : 'Belum' }} Integrasi">
        {{ $antrian->kodekunjungan ? $antrian->kunjungan->counter . ' / ' . $antrian->kodekunjungan : 'Belum Kunjungan' }}
        </span>
        </th>
        </tr>
        <tr>
            <td>Jenis</td>
            <td>:</td>
            <th>
                @switch($antrian->jeniskunjungan)
                @case(1)
                Rujukan FKTP
                @break

                @case(2)
                Umum
                @break

                @case(3)
                Surat Kontrol
                @break

                @case(4)
                Rujukan Antar RS
                @break

                @default
                Belum Kunjungan
                @endswitch
            </th>
        </tr>
        <tr>
            <td>Status</td>
            <td>:</td>
            <th>
                @switch($antrian->taskid)
                @case(0)
                Belum Checkin
                @break

                @case(1)
                Tunggu Pendaftaran
                @break

                @case(2)
                Proses Pendaftaran
                @break

                @case(3)
                Tunggu Poliklinik
                @break

                @case(4)
                Pemeriksaan Dokter
                @break

                @case(5)
                Tunggu Farmasi
                @break

                @case(6)
                Proses Farmasi
                @break

                @case(7)
                Selesai Pelayanan
                @break

                @case(99)
                <span class="badge badge-danger">Batal</span>
                @break

                @default
                @endswitch
            </th>
        </tr>
        <tr>
            <td>No Ref</td>
            <td>:</td>
            <th>
                {{ $antrian->nomorreferensi ?? '-' }}
            </th>
        </tr>
        <tr>
            <td>SEP</td>
            <td>:</td>
            <th>
                @if ($antrian->nomorsep)
                {{ $antrian->nomorsep }}
                @else
                -
                @endif
            </th>
        </tr>
        </table>
    </div>
    <div class="col-md-3">
        <table class="table table-xs table-borderless">
            <tr>
                <td>Pendaftaran</td>
                <td>:</td>
                <th>{{ $antrian->pic1 ? $antrian->pic1->name : 'Belum Didaftarkan' }}</th>
            </tr>
            <tr>
                <td>Unit</td>
                <td>:</td>
                <th>{{ $antrian->kunjungan ? $antrian->kunjungan->units->nama : 'Belum Kunjungan' }}</th>
            </tr>
            <tr>
                <td>Perawat</td>
                <td>:</td>
                <th>{{ $antrian->pic2 ? $antrian->pic2->name : 'Belum Asesmen' }}</th>
            </tr>
            <tr>
                <td>Dokter</td>
                <td>:</td>
                <th>{{ $antrian->pic3 ? $antrian->pic3->name : 'Belum Asesmen' }}</th>
            </tr>
            <tr>
                <td>Farmasi</td>
                <td>:</td>
                <th>{{ $antrian->pic4 ? $antrian->pic4->name : 'Belum Resep Obat' }}</th>
            </tr>
        </table>
    </div> --}}
    </div>
</x-adminlte-card>
