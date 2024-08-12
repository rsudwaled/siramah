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
                <td>Antrian</td>
                <td>:</td>
                <th>
                    {{-- <span class="badge badge-{{ $antrian->sync_antrian ? 'success' : 'danger' }}"
                        title="{{ $antrian->sync_antrian ? 'Sudah' : 'Belum' }} Integrasi">
                        {{ $antrian->nomorantrean }} / {{ $antrian->kodebooking }}
                    </span> --}}
                </th>
            </tr>
            <tr>
                <td>Tgl Masuk</td>
                <td>:</td>
                <th>{{ $kunjungan->tgl_masuk }}</th>
            </tr>
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
                <th>{{ \Carbon\Carbon::parse($kunjungan->pasien->tgl_lahir)->isoFormat('D MMMM Y')}}
                    ({{ \Carbon\Carbon::parse($kunjungan->tgl_masuk)->diffInYears($kunjungan->pasien->tgl_lahir) }}
                    tahun)
                </th>
            </tr>
        </table>
    </div>
    <div class="col-md-3">
        <table class="table table-xs table-borderless">
            <tr>
                <td>Kunjungan</td>
                <td>:</td>
                <th>
                    {{ $kunjungan->counter }} / {{ $kunjungan->kode_kunjungan }}
                </th>
            </tr>
            <tr>
                <td>Dokter</td>
                <td>:</td>
                <th>
                    {{ $kunjungan->dokter->nama_paramedis }}
                </th>
            </tr>
            <tr>
                <td>Klinik</td>
                <td>:</td>
                <th>
                    {{ $kunjungan->unit->nama_unit }}
                </th>
            </tr>
            <tr>
                <td>Penjamin</td>
                <td>:</td>
                <th>
                    {{ $kunjungan->penjamin_simrs->nama_penjamin }}
                </th>
            </tr>
            <tr>
                <td>SEP</td>
                <td>:</td>
                <th>
                    {{ $kunjungan->no_sep }}
                </th>
            </tr>
        </table>
    </div>
    {{-- <div class="col-md-3">
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
