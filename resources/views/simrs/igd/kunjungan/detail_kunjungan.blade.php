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
                        <h5> KUNJUNGAN DARI {{ $kunjungan->nama }}.
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
                                                <h5 class="description-header ">{{ $kunjungan->diagnosa ?? 'Tidak Ada' }}</h5>
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
                                                    {{ $kunjungan->nama_penjamin ?? 'Tidak Ada' }} -</h5>
                                                <span class="description-text">- Penjamin - </span>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 col-6">
                                            <div class="description-block border-right">
                                                <h5 class="description-header ">
                                                    {{ $kunjungan->alasan_masuk ?? 'Tidak Ada' }}</h5>
                                                <span class="description-text">- Alasan Masuk -</span>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 col-6">
                                            <div class="description-block border-right">
                                                @if ($kunjungan->is_bpjs_proses == 1)
                                                    <h5 class="description-header ">
                                                        BPJS PROSES
                                                    </h5>
                                                @else
                                                    <h5 class="description-header ">
                                                        {{ $kunjungan->jp_daftar == 0 ? 'UMUM' : ($kunjungan->jp_daftar == 1 ? 'BPJS' : 'BPJS PROSES') }}
                                                    </h5>
                                                @endif
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
                {{-- @if ($kunjungan->id_alasan_edit != null)
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
                @endif --}}
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Kunjungan</th>
                                    <th>Pasien</th>
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
                                        <b> RM : {{ $kunjungan->no_rm }}<br>
                                            Pasien : {{ $kunjungan->nama }} <br>
                                        </b>
                                        <b>
                                            NIK : {{ $kunjungan->nik }}<br>
                                            BPJS : {{ $kunjungan->bpjs }}<br>
                                        </b>
                                    </td>
                                    <td>
                                        <b>
                                            {{ date('d M Y', strtotime($kunjungan->tgl_lahir)) }}
                                        </b>
                                    </td>
                                    <td>
                                        <b>
                                            @if ($kunjungan->jp_daftar == 0 && !empty($kunjungan->no_sep))
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
                                                <x-adminlte-button type="button" 
                                                    data-sep="{{ $kunjungan->no_sep }}"
                                                    data-nama="{{ $kunjungan->nama }}"
                                                    data-nik="{{ $kunjungan->nik }}" 
                                                    data-rm="{{ $kunjungan->no_rm }}"
                                                    data-nokartu="{{ $kunjungan->bpjs }}"
                                                    data-kunjungan="{{ $kunjungan->kode_kunjungan }}"
                                                    data-jpdaftar="{{ $kunjungan->jp_daftar }}"
                                                    data-refDiagnosa="{{ $kunjungan->diagnosa }}"
                                                    data-refdpjp="{{ $histories->dokterJkn->nama_paramedis }}" theme="primary"
                                                    class="btn-xs btn-diagnosa show-formupdatesep" id="btn-diagnosa"
                                                    label="Update SEP" />
                                            @endif
                                            <br><br>
                                            SPRI : {{ $kunjungan->no_spri ?? '-' }}
                                            {{ $kunjungan->diagnosa }}
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

    <x-adminlte-modal id="modalUpdateSEP" title="Update SEP" theme="primary" size='lg' disable-animations>
        <div class="col-lg-12">
            <form id="updateSEP" method="post" action="">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputBorderWidth2">KODE KUNJUNGAN</label>
                                    <input type="text" name="kode_kunjungan_update" id="kunjungan_update" readonly
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputBorderWidth2">RM PASIEN</label>
                                    <input type="text" name="noMR" id="noMR_update" readonly class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputBorderWidth2">NO KARTU</label>
                                    <input type="text" name="no_Bpjs" id="no_Bpjs_update" readonly class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputBorderWidth2">NIK</label>
                                    <input type="text" name="nik_bpjs" id="nik_bpjs_update" readonly class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputBorderWidth2">NO SEP</label>
                            <input type="text" name="no_sep" id="no_sep_update" readonly class="form-control">
                        </div>
                       
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleInputBorderWidth2">Nama PASIEN</label>
                            <input type="text" name="nama_pasien" id="nama_pasien_update" readonly class="form-control">
                        </div>
                       
                        <div class="form-group" >
                            <label for="exampleInputBorderWidth2">REFF DPJP</label>
                            <input type="text" name="ref_dpjp" id="ref_dpjp" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputBorderWidth2">DPJP</label>
                            <select name="dpjp" id="dpjp_update" class="select2 form-control">
                                @foreach ($paramedis as $dpjp)
                                    <option value="{{ $dpjp->kode_dokter_jkn }}">{{ $dpjp->nama_paramedis }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputBorderWidth2">PILIH DIAGNOSA ICD 10</label>
                            <select name="diagAwal" id="diagnosa" class="select2 form-control">

                            </select>
                        </div>
                    </div>
                </div>
                <x-slot name="footerSlot">
                    <x-adminlte-button type="button" class="btn btn-sm bg-primary btn-update-sep"
                        form="updateSEP" label="Update Diagnosa" />
                    <x-adminlte-button theme="danger" label="batal update" class="btn btn-sm" data-dismiss="modal" />
                </x-slot>
            </form>
        </div>
    </x-adminlte-modal>
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
            $('.select2').select2();
            $("#diagnosa").select2({
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('ref_diagnosa_api') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            diagnosa: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });

            $('.show-formupdatesep').click(function(e) {
                $("#noMR_update").val($(this).data('rm'));
                $("#nik_bpjs_update").val($(this).data('nik'));
                $("#no_Bpjs_update").val($(this).data('nokartu'));
                $("#kunjungan_update").val($(this).data('kunjungan'));
                $("#nama_pasien_update").val($(this).data('nama'));
                $("#jp_daftar_update").val($(this).data('jpdaftar'));
                $("#no_sep_update").val($(this).data('sep'));
                $("#ref_dpjp").val($(this).data('refdpjp'));
                
                $('#modalUpdateSEP').modal('show');
            });

            $('.btn-update-sep').click(function(e) {
                var nokartu = $(this).data('nokartu');
                var url       = "{{ route('update-sep.igd') }}";
                Swal.fire({
                    title: "Apakah Anda Yakin?",
                    text: "untuk update data SEP!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Update SEP!",
                    cancelButtonText: "Batal!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'PUT',
                            url: url,
                            data: {
                                noMR: $('#noMR_update').val(),
                                kunjungan: $('#kunjungan_update').val(),
                                diagAwal: $('#diagnosa').val(),
                                dpjp: $('#dpjp_update').val(),
                            },
                            success: function(data) {
                                if (data.code == 200) {
                                    Swal.fire({
                                        title: "Update SEP BERHASIL!",
                                        text: data.data.metaData.message,
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
                                        title: "Update SEP GAGAL!",
                                        text: message +
                                            '( ERROR : ' + data.code + ')',
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
