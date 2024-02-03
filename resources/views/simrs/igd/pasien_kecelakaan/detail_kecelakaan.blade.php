@extends('adminlte::page')

@section('title', 'Detail Pasien Kecelakaan')
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>Detail Pasien Kecelakaan</h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('pasien-kecelakaan.list') }}"
                            class="btn btn-sm  btn-secondary withLoad">Kembali</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('edit.kunjungan', ['kunjungan' => $kunjungan->kode_kunjungan]) }}"
                            class="btn btn-sm  btn-warning withLoad">Edit Kunjungan</a></li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="invoice p-3 mb-3">

                <div class="row">
                    <div class="col-12">
                        <h5> Pasien a.n : {{ $kunjungan->pasien->nama_px }}.
                            <small class="float-right">
                                <b>
                                    Tgl Masuk : {{ date('d M Y', strtotime($kunjungan->tgl_masuk)) }}
                                </b>
                            </small>
                        </h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 table-responsive">
                        @if ($kunjungan->is_ranap_daftar == 1)
                            <div class="card">
                                <div class="card-body bg-success">
                                    <div class="row ">
                                        <div class="col-sm-3 col-6">
                                            <div class="description-block border-right">
                                                <h5 class="description-header ">{{ $kunjungan->diagx ?? 'Tidak Ada' }}</h5>
                                                <span class="description-text">- Diagnosa - </span>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 col-6">
                                            <div class="description-block border-right">
                                                <h5 class="description-header ">RUANGAN :
                                                    {{ $kunjungan->kamar ?? 'Tidak Ada' }}</h5>
                                                <span class="description-text">- RUANGAN -</span>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 col-6">
                                            <div class="description-block border-right">
                                                <h5 class="description-header ">NO : {{ $kunjungan->no_bed ?? 'Tidak Ada' }}
                                                </h5>
                                                <span class="description-text">- NO BED -</span>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 col-6">
                                            <div class="description-block">
                                                <h5 class="description-header ">KELAS :
                                                    {{ $kunjungan->kelas ?? 'Tidak Ada' }}</h5>
                                                <span class="description-text">- KELAS -</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="card">
                                <div class="card-body bg-primary">
                                    <div class="row ">
                                        <div class="col-sm-3 col-6">
                                            <div class="description-block border-right">
                                                <h5 class="description-header ">-
                                                    {{ $kunjungan->penjamin_simrs->nama_penjamin ?? 'Tidak Ada' }} -</h5>
                                                <span class="description-text">- Penjamin - </span>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 col-6">
                                            <div class="description-block border-right">
                                                <h5 class="description-header ">
                                                    {{ $kunjungan->alasan_masuk->alasan_masuk ?? 'Tidak Ada' }}</h5>
                                                <span class="description-text">- Alasan Masuk -</span>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 col-6">
                                            <div class="description-block border-right">
                                                <h5 class="description-header ">
                                                    {{ $kunjungan->jp_daftar == 0 ? 'UMUM' : 'BPJS' }}</h5>
                                                <span class="description-text">- Jenis Pasien Daftar -</span>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 col-6">
                                            <div class="description-block">
                                                <h5 class="description-header ">{{ $kunjungan->perujuk ?? 'Tidak Ada' }}
                                                </h5>
                                                <span class="description-text">- Perujuk -</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @if (!empty($kunjungan->id_alasan_edit) && $kunjungan->id_alasan_edit != null)
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-exclamation-triangle"></i> Kunjungan Sudah Di Perbaharui!</h5>
                                kunjungan sudah di perbaharui dengan alasan perubahan :
                                {{ $kunjungan->id_alasan_edit != null ? $kunjungan->alasanEdit->nama_alasan : '' }}
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-12 table-responsive">
                        <div class="card">
                            <div class="card-body bg-danger">
                                <div class="row ">
                                    <div class="col-sm-3 col-6">
                                        <div class="description-block border-right">
                                            <h5 class="description-header ">
                                                @if ($kunjungan->lakalantas > 0 && $kunjungan->lakalantas == 1)
                                                    <small>
                                                        <b>KLL & BUKAN KECELAKAAN KERJA (BKK)</b>
                                                    </small> <br>
                                                @elseif ($kunjungan->lakalantas > 0 && $kunjungan->lakalantas == 2)
                                                    <small>
                                                        <b>KLL & KK</b>
                                                    </small> <br>
                                                @elseif ($kunjungan->lakalantas > 0 && $kunjungan->lakalantas == 3)
                                                    <small>
                                                        <b>KECELAKAAN KERJA</b>
                                                    </small> <br>
                                                @endif
                                            </h5>
                                            <span class="description-text">- Status Kecelakaan - </span>
                                        </div>
                                    </div>

                                    <div class="col-sm-3 col-6">
                                        <div class="description-block border-right">
                                            <h5 class="description-header ">
                                                Provinsi :  {{ $kunjungan->pasienKecelakaan == null ? '-':$kunjungan->pasienKecelakaan->provinsi->nama_provinsi }} <br>
                                                Kabupaten : {{ $kunjungan->pasienKecelakaan == null ? '-':$kunjungan->pasienKecelakaan->kabupaten->nama_kabupaten_kota }} <br>
                                                Kecamatan : {{ $kunjungan->pasienKecelakaan == null ? '-':$kunjungan->pasienKecelakaan->kecamatan->nama_kecamatan }} <br>
                                            </h5>
                                            <span class="description-text">- Lokasi Kecelakaan -</span>
                                        </div>
                                    </div>

                                    <div class="col-sm-3 col-6">
                                        <div class="description-block border-right">
                                            <h5 class="description-header ">NO :
                                                {{ $kunjungan->pasienKecelakaan->noLP ?? 'Tidak Ada' }}
                                            </h5>
                                            <h6>{{ $kunjungan->pasienKecelakaan->keterangan ?? 'Tidak Ada' }}</h6><br>
                                            <span class="description-text">- No Laporan Polisi -</span>
                                        </div>
                                    </div>

                                    <div class="col-sm-3 col-6">
                                        <div class="description-block">
                                            <h5 class="description-header ">
                                                {{ $kunjungan->pasienKecelakaan == null ? '-':date('d M Y', strtotime($kunjungan->pasienKecelakaan->tglKejadian)) }}
                                            </h5>
                                            <span class="description-text">- Tanggal Kejadian -</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Kunjungan</th>
                                    <th>Pasien</th>
                                    <th>Nomor</th>
                                    <th>Tanggal Lahir</th>
                                    <th>BPJS</th>
                                    <th>Pasien Daftar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        Counter : {{ $kunjungan->counter }}<br>
                                        <b>
                                            Kode : {{ $kunjungan->kode_kunjungan }}<br>
                                        </b>
                                    </td>
                                    <td>
                                        <b> RM : {{ $kunjungan->pasien->no_rm }}<br>
                                            Pasien : {{ $kunjungan->pasien->nama_px }} <br>
                                        </b>
                                    </td>
                                    <td>
                                        <b>
                                            NIK : {{ $kunjungan->pasien->nik_bpjs }}<br>
                                            BPJS : {{ $kunjungan->pasien->no_Bpjs }}<br>
                                        </b>
                                    </td>
                                    <td>
                                        <b>
                                            {{ date('d M Y', strtotime($kunjungan->pasien->tgl_lahir)) }}
                                        </b>
                                    </td>
                                    <td>
                                        <b>
                                            SEP : {{ $kunjungan->no_sep ?? '-' }} <br>
                                            SPRI : {{ $kunjungan->no_spri ?? '-' }}
                                        </b>
                                    </td>
                                    <td>
                                        <b>
                                            {{ $kunjungan->jp_daftar == 0 ? 'PASIEN UMUM' : 'PASIEN BPJS' }}
                                        </b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)
@section('js')

@endsection
