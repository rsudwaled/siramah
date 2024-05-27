@extends('adminlte::page')
@section('title', 'DATA KUNJUNGAN ')
@section('content_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3">
                <h5>DATA KUNJUNGAN PASIEN</h5>
            </div>
        </div>
    </div>
@stop
@section('content')
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card card-primary card-outline card-tabs">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-lg-6">
                            <form action="" method="get">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input id="new-event" type="date" name="tanggal" class="form-control"
                                            value="{{ $request->tanggal != null ? \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') }}"
                                            placeholder="Event Title">
                                        <div class="input-group-append">
                                            <button id="add-new-event" type="submit"
                                                class="btn btn-primary btn-sm withLoad">CARI DATA</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-6 text-right">
                            <button class="btn btn-sm bg-purple" data-toggle="modal" data-target="#modal-sep-backdate">SEP BACKDATE</button>
                            <a onClick="window.location.reload();" class="btn btn-sm btn-warning">
                                <i class="fas fa-sync"></i> Refresh</a>
                        </div>
                    </div>
                    @php
                        $heads = ['Pasien', 'Alamat', 'Kunjungan', 'Diagnosa', 'SEP', 'Status Pasien', 'Detail'];
                        $config['order'] = ['3', 'desc'];
                        $config['paging'] = false;
                        $config['info'] = false;
                        $config['scrollY'] = '600px';
                        $config['scrollCollapse'] = true;
                        $config['scrollX'] = true;
                    @endphp
                    <x-adminlte-datatable id="table" class="text-xs" :heads="$heads" head-theme="dark"
                        :config="$config" striped bordered hoverable compressed>
                        @foreach ($kunjungan as $item)
                            <tr>
                                <td>
                                    <a href="{{ route('edit-pasien', ['rm' => $item->rm]) }}" target="__blank">
                                        <b>{{ $item->pasien }}</b> <br>RM : {{ $item->rm }} <br>NIK :
                                        {{ $item->nik }} <br>No Kartu : {{ $item->noKartu }}
                                    </a>
                                </td>
                                <td>{!! wordwrap($item->alamat, 30, "<br>\n") !!}</td>
                                </td>
                                <td>
                                    @if ($item->lakaLantas > 0)
                                        <small>
                                            <b>PASIEN KECELAKAAN</b>
                                        </small> <br>
                                    @endif
                                    {{ $item->rm }} | (RM PASIEN) <br>
                                    {{ $item->kunjungan }} | ({{ $item->nama_unit }})
                                    <br>
                                    <b>
                                        {{ $item->status }}
                                    </b> <br>
                                    {{ $item->tgl_kunjungan }} | TANGGAL
                                </td>

                                <td>{{ $item->diagx }}</td>
                                <td>
                                    {{ $item->sep }} <br>
                                    @if ($item->sep)
                                        <x-adminlte-button type="button" data-sep="{{ $item->sep }}" theme="danger"
                                            class="btn-xs btn-deleteSEP" id="btn-deleteSEP" label="Hapus SEP" />
                                    @endif
                                </td>
                                <td>
                                    <b>
                                        @if (empty($item->jp_daftar) && !empty($item->sep))
                                            PASIEN BPJS
                                        @elseif ($item->jp_daftar == 1 && $item->is_bpjs_proses)
                                            BPJS PROSES
                                        @else
                                            {{ $item->jp_daftar == 1 ? 'BPJS' : ($item->jp_daftar == 0 ? 'UMUM' : 'BPJS PROSES') }}
                                        @endif
                                    </b> <br>
                                    <small>
                                        <a class="btn btn-warning btn-xs">
                                            @if (is_null($item->form_send_by))
                                                DEKSTOP
                                                <x-adminlte-button type="button" data-kunjungan="{{ $item->kunjungan }}"
                                                    theme="primary" class="btn-xs btn-sync-sistem" id="btn-sync-sistem"
                                                    label="Sync Sistem" />
                                            @else
                                                {{ $item->form_send_by == 0 ? 'FORM DAFTAR' : 'FORM RANAP' }}
                                            @endif
                                        </a>
                                    </small>


                                </td>
                                <td>
                                    @if (!empty($item->jp_daftar))
                                        <a href="{{ route('detail.kunjungan', ['jpdaftar' => $item->jp_daftar, 'kunjungan' => $item->kunjungan]) }}"
                                            class="btn btn-success btn-xs withLoad mt-1">Detail</a>
                                    @endif
                                    @if ($item->id_status == 1 || $item->id_status == 12)
                                        <x-adminlte-button type="button" data-nama="{{ $item->pasien }}"
                                            data-nik="{{ $item->nik }}" data-rm="{{ $item->rm }}"
                                            data-nokartu="{{ $item->noKartu }}" data-kunjungan="{{ $item->kunjungan }}"
                                            data-jpdaftar="{{ $item->jp_daftar }}" theme="primary"
                                            class="btn-xs btn-diagnosa show-formdiagnosa mt-1" id="btn-diagnosa"
                                            label="ICD-10" />
                                        @php
                                            if (empty($item->noKartu)) {
                                                $nomorKartu = null;
                                            } else {
                                                $nomorKartu = trim($item->noKartu);
                                            }
                                        @endphp
                                        <a href="{{ route('form-umum.pasien-ranap', ['rm' => $item->rm, 'kunjungan' => $item->kunjungan]) }}"
                                            class="btn btn-xs btn-warning withLoad mt-1">RANAP UMUM</a> <br>
                                        @if ($item->jp_daftar !== 0)
                                            @if (!empty($nomorKartu) && $item->jp_daftar == 1)
                                                <a href="{{ route('daftar.ranap-bpjs', ['nomorkartu' => $nomorKartu, 'kode' => $item->kunjungan]) }}"
                                                    class="btn btn-xs bg-purple withLoad mt-1">RANAP BPJS </a>
                                            @endif
                                        @endif
                                    @else
                                        @if (auth()->user()->hasRole('Admin Super'))
                                            <x-adminlte-button type="button" data-nama="{{ $item->pasien }}"
                                                data-nik="{{ $item->nik }}" data-rm="{{ $item->rm }}"
                                                data-nokartu="{{ $item->noKartu }}"
                                                data-kunjungan="{{ $item->kunjungan }}"
                                                data-jpdaftar="{{ $item->jp_daftar }}" theme="primary"
                                                class="btn-xs btn-diagnosa show-formdiagnosa mt-1" id="btn-diagnosa"
                                                label="Update Diagnosa" />
                                            @php
                                                if (empty($item->noKartu)) {
                                                    $nomorKartu = null;
                                                } else {
                                                    $nomorKartu = trim($item->noKartu);
                                                }
                                            @endphp
                                            <a href="{{ route('form-umum.pasien-ranap', ['rm' => $item->rm, 'kunjungan' => $item->kunjungan]) }}"
                                                class="btn btn-xs btn-warning withLoad mt-1">RANAP UMUM</a> <br>
                                            @if ($item->jp_daftar !== 0)
                                                @if (!empty($nomorKartu) && $item->jp_daftar == 1)
                                                    <a href="{{ route('daftar.ranap-bpjs', ['nomorkartu' => $nomorKartu, 'kode' => $item->kunjungan]) }}"
                                                        class="btn btn-xs bg-purple withLoad mt-1">RANAP BPJS </a>
                                                @endif
                                            @endif
                                        @else
                                            {{-- <button class="btn btn-xs btn-danger mt-1">SILAHKAN HUBUNGI IT</button> --}}
                                        @endif
                                    @endif
                                    <x-adminlte-button type="button" data-nama="{{ $item->pasien }}"
                                        data-nik="{{ $item->nik }}" data-rm="{{ $item->rm }}"
                                        data-nokartu="{{ $item->noKartu }}" data-kunjungan="{{ $item->kunjungan }}"
                                        data-jpdaftar="{{ $item->jp_daftar }}" theme="primary"
                                        class="btn-xs btn-diagnosa show-formdiagnosa mt-1" id="btn-diagnosa"
                                        label="Diagnosa" />
                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </div>
            </div>
        </div>
    </div>
    <x-adminlte-modal id="formDiagnosa" title="Diagnosa Pasien" theme="primary" size='lg' disable-animations>
        <div class="col-lg-12">
            <div class="alert alert-warning alert-dismissible">
                <h5>
                    <i class="icon fas fa-users"></i>Diagnosa dan Bridging SEP :
                </h5>
            </div>
            <form id="formUpdateDiagnosa" method="post" action="">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputBorderWidth2">KODE KUNJUNGAN</label>
                                    <input type="text" name="kode_kunjungan" id="kunjungan" readonly
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputBorderWidth2">RM PASIEN</label>
                                    <input type="text" name="noMR" id="noMR" readonly class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputBorderWidth2">NO KARTU</label>
                            <input type="text" name="no_Bpjs" id="no_Bpjs" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputBorderWidth2">NIK</label>
                            <input type="text" name="nik_bpjs" id="nik_bpjs" readonly class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleInputBorderWidth2">Nama PASIEN</label>
                            <input type="text" name="nama_pasien" id="nama_pasien" readonly class="form-control">
                        </div>

                        <div class="form-group" style="display: none">
                            <label for="exampleInputBorderWidth2">JENIS PASIEN DAFTAR</label>
                            <input type="text" name="jp_daftar" id="jp_daftar" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputBorderWidth2">DPJP</label>
                            <select name="dpjp" id="dpjp" class="select2 form-control">
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
                    <x-adminlte-button type="button" class="btn btn-sm bg-primary btn-synchronize-sep"
                        form="formUpdateDiagnosa" label="Update Diagnosa" />
                    <x-adminlte-button theme="danger" label="batal update" class="btn btn-sm" data-dismiss="modal" />
                </x-slot>
            </form>
        </div>
    </x-adminlte-modal>
    <div class="modal fade" id="modal-sep-backdate" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">PENGAJUAN BACKDATE</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="pengajuanBackDate" action="" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputBorderWidth2">Kode Kunjungan</label>
                            <input type="text" name="bd_kunjungan" class="form-control" id="bd_kunjungan">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputBorderWidth2">Nomor Kartu</label>
                            <input type="text" name="bd_noKartu" class="form-control" id="bd_noKartu">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputBorderWidth2">Tanggal SEP</label>
                            <input type="date" name="tglSep" class="form-control" id="tglSep">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputBorderWidth2">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" id="keterangan">
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="button" form="pengajuanBackDate" class="btn btn-primary btn-pengajuan-backdate">Simpan Pengajuan</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
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

            $('.show-formdiagnosa').click(function(e) {
                $("#noMR").val($(this).data('rm'));
                $("#nik_bpjs").val($(this).data('nik'));
                $("#no_Bpjs").val($(this).data('nokartu'));
                $("#kunjungan").val($(this).data('kunjungan'));
                $("#nama_pasien").val($(this).data('nama'));
                $("#jp_daftar").val($(this).data('jpdaftar'));
                $('#formDiagnosa').modal('show');
            });


            $('.btn-synchronize-sep').click(function(e) {
                // var urlBridging = "{{ route('synch.diagnosa') }}";
                var urlBridging = "{{ route('bridging-sep') }}";
                var urlUpdateOnly = "{{ route('synch-diagnosa.only') }}";
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success m-2",
                        cancelButton: "btn btn-danger m-2"
                    },
                    buttonsStyling: false
                });
                swalWithBootstrapButtons.fire({
                    title: "Apakah Anda Yakin?",
                    text: "Update Diagnosa dan Bridging Pembuatan SEP!",
                    icon: "warning",
                    padding: "3em",
                    showCancelButton: true,
                    confirmButtonText: "Bridging Pembuatan SEP!",
                    cancelButtonText: "Update Diagnosa!",
                    reverseButtons: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: urlBridging,
                            dataType: 'json',
                            data: {
                                noMR: $('#noMR').val(),
                                kunjungan: $('#kunjungan').val(),
                                diagAwal: $('#diagnosa').val(),
                                dpjp: $('#dpjp').val(),
                            },
                            success: function(data) {
                                console.info(data.code);
                                if (data.code == 400) {
                                    Swal.fire('Data yang dikirimkan tidak lengkap', '',
                                        'info');
                                    $.LoadingOverlay("hide");
                                }
                                if (data.code == 401) {
                                    Swal.fire(data.message, '',
                                        'info');
                                    $.LoadingOverlay("hide");
                                }
                                console.info(data.data);
                                if (data.data.metaData.code == 200) {
                                    swalWithBootstrapButtons.fire({
                                        title: "Bridging Success!",
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
                                    swalWithBootstrapButtons.fire({
                                        title: "Bridging Gagal!",
                                        text: data.data.metaData.message +
                                            '( ERROR : ' + data.data.metaData
                                            .code + ')',
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

                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel

                    ) {
                        $.ajax({
                            type: 'POST',
                            url: urlUpdateOnly,
                            dataType: 'json',
                            data: {
                                noMR: $('#noMR').val(),
                                kunjungan: $('#kunjungan').val(),
                                refDiagnosa: $('#refDiagnosa').val(),
                                diagAwal: $('#diagnosa').val(),
                            },
                            success: function(data) {
                                if (data.code == 200) {
                                    swalWithBootstrapButtons.fire({
                                        title: "Update Diagnosa Success!",
                                        text: data.message,
                                        icon: "success",
                                        confirmButtonText: "oke!",
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                    $.LoadingOverlay("hide");
                                } else {
                                    swalWithBootstrapButtons.fire({
                                        title: "Update Gagal!",
                                        text: data.message + '( ERROR : ' + data
                                            .code + ')',
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

            $('.btn-pengajuan-backdate').click(function(e) {
                var backdateUrl = "{{ route('backdate-sep') }}";
                Swal.fire({
                    title: "Apakah Data Sudah Benar?",
                    text: "jika sudah benar, silahkan klik ajukan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ajukan!",
                    cancelButtonText: "Batal!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: backdateUrl,
                            data: {
                                kunjungan: $('#bd_kunjungan').val(),
                                noKartu: $('#bd_noKartu').val(),
                                keterangan: $('#keterangan').val(),
                                tglSep: $('#tglSep').val(),
                            },
                            success: function(data) {
                                console.info(data);
                                if(data.code ==400){
                                    Swal.fire({
                                        title: "FORM INPUT TIDAK LENGKAP!",
                                        text: data.message,
                                        icon: "error",
                                        confirmButtonText: "oke!",
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                    $.LoadingOverlay("hide");
                                }
                                if (data.data.metaData.code == 200) {
                                    Swal.fire({
                                        title: "PENGAJUAN BACKDATE SEP BERHASIL!",
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
                                        title: "PENGAJUAN BACKDATE SEP GAGAL!",
                                        text: data.data.metaData.message +
                                            '( ERROR : ' + data.data
                                            .metaData.code + ')',
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

            $('.btn-sync-sistem').click(function(e) {
                var kunjungan = $(this).data('kunjungan');
                var url = "{{ route('sync-dekstop-towebapps') }}";
                Swal.fire({
                    title: "Apakah Anda Yakin?",
                    text: "untuk singkronisasi data dari desktop ke web apps!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Iya!",
                    cancelButtonText: "Batal!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'PUT',
                            url: url,
                            data: {
                                nokunjungan: kunjungan,
                            },
                            success: function(data) {
                                if (data.code == 200) {
                                    Swal.fire({
                                        title: "Singkronisasi Berhasil!",
                                        text: data.message,
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
                                        title: "Singkronisasi GAGAL!",
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
        });
    </script>
@endsection
