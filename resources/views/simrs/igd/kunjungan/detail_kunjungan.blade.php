@extends('adminlte::page')

@section('title', 'Detail Kunjungan')
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>DETAIL KUNJUNGAN</h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('daftar.kunjungan') }}"
                            class="btn btn-sm btn-secondary withLoad">Kembali</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('edit.kunjungan', ['kunjungan' => $kunjungan->kode_kunjungan]) }}"
                            class="btn btn-sm btn-warning withLoad">Edit Kunjungan</a></li>
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
                        <h5> KUNJUNGAN DARI {{ $kunjungan->pasien->nama_px }}.
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
                @if ($kunjungan->id_alasan_edit != null)
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
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Kunjungan</th>
                                    <th>Pasien</th>
                                    <th>Nomor</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Pasien Daftar</th>
                                    <th>BPJS</th>
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
                                            @if ( $kunjungan->jp_daftar == 0 && !empty($kunjungan->no_sep))
                                                PASIEN BPJS
                                            @else
                                                {{ $kunjungan->jp_daftar == 0 ? 'PASIEN UMUM' : 'PASIEN BPJS' }}
                                            @endif
                                        </b>
                                    </td>
                                    <td>
                                        <b>
                                            SEP : {{ $kunjungan->no_sep ?? '-' }}
                                            @if ($kunjungan->no_sep)
                                                <x-adminlte-button type="button" data-sep="{{ $kunjungan->no_sep }}"
                                                    theme="danger" class="btn-xs btn-deleteSEP" id="btn-deleteSEP"
                                                    label="Hapus SEP" />
                                            @endif
                                            <br><br>
                                            SPRI : {{ $kunjungan->no_spri ?? '-' }}
                                            @if ($kunjungan->no_spri)
                                                <x-adminlte-button type="button" data-spri="{{ $kunjungan->no_spri }}"
                                                    theme="danger" class="btn-xs btn-deleteSPRI" id="btn-deleteSPRI"
                                                    label="Hapus SPRI" />
                                            @endif
                                            <br>
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
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.btn-deleteSEP').click(function(e) {
                var sep = $(this).data('sep');
                var deleteSEP = "{{ route('sep_ranap.delete') }}";
                Swal.fire({
                    title: "Apakah Anda Yakin?",
                    text: "untuk menghapus data SEP!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Hapus!",
                    cancelButtonText: "Batal!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: deleteSEP,
                            data: {
                                noSep: sep,
                            },
                            success: function(data) {
                                if (data.metadata.code == 200) {
                                    Swal.fire({
                                        title: "HAPUS SEP BERHASIL!",
                                        text: data.metadata.message,
                                        icon: "success",
                                        confirmButtonText: "oke!",
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                    $.LoadingOverlay("hide");
                                } else {
                                    Swal.fire({
                                        title: "HAPUS SEP GAGAL!",
                                        text: data.metadata.message +
                                            '( ERROR : ' + data
                                            .metadata.code + ')',
                                        icon: "error",
                                        confirmButtonText: "oke!",
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                    $.LoadingOverlay("hide");
                                }
                            },
                        });
                    }
                });
            });
            $('.btn-deleteSPRI').click(function(e) {
                var spri = $(this).data('spri');
                var deleteSPRI = "{{ route('spri_ranap.delete') }}";
                Swal.fire({
                    title: "Apakah Anda Yakin?",
                    text: "untuk menghapus data SPRI!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Hapus!",
                    cancelButtonText: "Batal!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: deleteSPRI,
                            data: {
                                noSuratKontrol: spri,
                            },
                            success: function(data) {
                                if (data.metadata.code == 200) {
                                    Swal.fire({
                                        title: "HAPUS SPRI BERHASIL!",
                                        text: data.metadata.message,
                                        icon: "success",
                                        confirmButtonText: "oke!",
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                    $.LoadingOverlay("hide");
                                } else {
                                    Swal.fire({
                                        title: "HAPUS SPRI GAGAL!",
                                        text: data.metadata.message +
                                            '( ERROR : ' + data
                                            .metadata.code + ')',
                                        icon: "error",
                                        confirmButtonText: "oke!",
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                    $.LoadingOverlay("hide");
                                }
                            },
                        });
                    }
                });
            });

        });
    </script>
@endsection
