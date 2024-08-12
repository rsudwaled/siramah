@extends('adminlte::page')
@section('title', 'DIAGNOSA C00-C99')
@section('content_header')
    <div class="alert bg-primary alert-dismissible">
        <div class="row">
            <div class="col-sm-4">
                <h5>
                    <i class="fas fa-user-tag"></i> DIAGNOSA C00-C99 :
                </h5>
            </div>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-adminlte-card theme="primary" collapsible>
                <div class="row">
                    <div class="col-lg-12">
                        <form id="formFilter" action="" method="get">
                            <div class="row">
                                <div class="col-md-4">
                                    <x-adminlte-select2 name="tahun" required id="tahun" label="Pilih Tahun">
                                        <option value="2018" {{ $request->tahun == '2018' ? 'selected' : '' }}>2018
                                        </option>
                                        <option value="2019" {{ $request->tahun == '2019' ? 'selected' : '' }}>2019
                                        </option>
                                        <option value="2020" {{ $request->tahun == '2020' ? 'selected' : '' }}>2020
                                        </option>
                                        <option value="2021" {{ $request->tahun == '2021' ? 'selected' : '' }}>2021
                                        </option>
                                        <option value="2022" {{ $request->tahun == '2022' ? 'selected' : '' }}>2022
                                        </option>
                                        <option value="2023" {{ $request->tahun == '2023' ? 'selected' : '' }}>2023
                                        </option>
                                        <option value="2024" {{ $request->tahun == '2024' ? 'selected' : '' }}>2024
                                        </option>
                                    </x-adminlte-select2>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <x-adminlte-select2 name="jenis" required id="jenis" class="col-2"
                                                label="Jenis Pasien">
                                                <option value="rajal" {{ $request->jenis == 'rajal' ? 'selected' : '' }}>
                                                    Rajal
                                                </option>
                                                <option value="ranap" {{ $request->jenis == 'ranap' ? 'selected' : '' }}>
                                                    Ranap
                                                </option>
                                            </x-adminlte-select2>
                                        </div>
                                        <div class="col-lg-6"
                                            style="display: flex; align-items: center; justify-content: flex-start; ">
                                            <x-adminlte-button type="submit" class="withLoad btn btn-sm mt-2"
                                                theme="primary" label="Lihat Laporan" />
                                            <x-adminlte-button label="Export Exel" class="bg-purple btn btn-sm mt-2"
                                                id="export" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-12">
                        <table id="table" class="table table-bordered table-hover datatable">
                            <thead>
                                <tr>
                                    <th>Pasien</th>
                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Lama Rawat</th>
                                    <th>Ruangan</th>
                                    <th>No Lab</th>
                                    <th>Kasus Baru</th>
                                    <th>Diagnosa Utama</th>
                                    <th>Diagnosa Sekunder</th>
                                    <th>Diagnosa Operasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pasiens as $pasien)
                                    @php
                                        $masuk = Carbon\Carbon::parse($pasien->tgl_masuk);
                                        $keluar = $pasien->tgl_keluar
                                            ? Carbon\Carbon::parse($pasien->tgl_keluar)
                                            : null;
                                        $tanggalLahir = Carbon\Carbon::parse($pasien->tgl_lahir);
                                        $tsLayananHeader = DB::connection('mysql2')
                                            ->table('ts_layanan_header')
                                            ->where('kode_kunjungan', $pasien->kode_kunjungan)
                                            ->pluck('kode_layanan_header');

                                        // Lakukan join dengan listohisheader pada koneksi mysql10
                                        $labDetails = DB::connection('mysql10')
                                            ->table('listohisheader as histo')
                                            ->whereIn('histo.HisNoReg', $tsLayananHeader)
                                            ->select('histo.*')
                                            ->get();
                                    @endphp
                                    <tr>
                                        <td>
                                            RM: {{ $pasien->no_rm }} <br>
                                            NAMA: {{ $pasien->nama_px }} <br>
                                            JK: {{ $pasien->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }} <br>
                                            alamat : {{$pasien->desa_name}} - {{$pasien->kecamatan_name}} {{$pasien->kabupaten_name}} {{$pasien->provinsi_name}}
                                        </td>
                                        <td>
                                            Masuk: {{ $pasien->tgl_masuk }} <br>
                                            Keluar: {{ $pasien->tgl_keluar??'-' }} <br>
                                        </td>
                                        <td>
                                            <span
                                                class="badge {{ $pasien->id_ruangan == null ? 'badge-danger' : 'badge-success' }}">{{ $pasien->id_ruangan == null ? 'RAJAL' : 'RANAP' }}</span>
                                        </td>
                                        <td>{{ $keluar ? $keluar->diffInDays($masuk) : 0 }}</td>
                                        <td>{{ $pasien->kamar??'-' }} | {{ $pasien->no_bed??'-' }}</td>
                                        <td>
                                            @if ($labDetails->isNotEmpty())
                                                <p>No Lab:</p>
                                                <ul>
                                                    @foreach ($labDetails as $item)
                                                        <li>{{ $item->LisNoLab }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p>Data lab tidak ditemukan.</p>
                                            @endif
                                        </td>
                                        <td>{{ $pasien->kasus_baru }}</td>
                                        <td>{{ $pasien->diag_utama }} | {{ $pasien->diag_utama_desc }}</td>
                                        <td>{{ $pasien->diagnosa_sekunder }}</td>
                                        <td>{{ $pasien->diag_sekunder_04.' - '.$pasien->diag_sekunder4_desc }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </x-adminlte-card>
        </div>
    </div>

@endsection
@section('plugins.TempusDominusBs4', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('js')
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });
        $(document).on('click', '#export', function(e) {
            $.LoadingOverlay("show");
            var data = $('#formFilter').serialize();
            var url = "{{ route('simrs.laporan-rm.laporan-export.C00') }}?" + data;
            window.location = url;
            $.ajax({
                data: data,
                url: url,
                type: "GET",
                success: function(data) {
                    setInterval(() => {
                        $.LoadingOverlay("hide");
                    }, 2000);
                },
            }).then(function() {
                // setTimeout('#export', 30000);
                setInterval(() => {
                    $.LoadingOverlay("hide");
                }, 2000);
            });
        });
    </script>
@endsection
