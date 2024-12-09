@extends('adminlte::page')
@section('title', 'DATA KUNJUNGAN ')
@section('content_header')
    <div class="alert bg-primary alert-dismissible">
        <h5>
            <i class="fas fa-user-tag"></i> DAFTAR KUNJUNGAN PASIEN :
        </h5>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="{{ url('daftar-kunjungan') }}"
                                class="nav-link {{ Request::get('view') == 'kunjungan_sep_berhasil' ? '' : (Request::get('view') == 'kunjungan_ranap'?'':'active') }}">
                                SEMUA KUNJUNGAN&nbsp;
                                <span class="badge badge-primary">0</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?view=kunjungan_sep_berhasil"
                                class="nav-link {{ Request::get('view') == 'kunjungan_sep_berhasil' ? 'active' : '' }}">
                                KUNJUNGAN SEP BERHASIL&nbsp;
                                <span class="badge badge-danger active">{{ $showDataSepCount }}</span>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="?view=kunjungan_ranap"
                                class="nav-link {{ Request::get('view') == 'kunjungan_ranap' ? 'active' : '' }}">
                                PASIEN RAWAT INAP&nbsp;
                                <span class="badge badge-danger active"></span>
                            </a>
                        </li> --}}
                    </ul>
                    <div class="tab-content">
                        <div class="col-lg-12">
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <form action="" method="get">
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                @php
                                                    $config = ['format' => 'YYYY-MM-DD'];
                                                @endphp
                                                <input type="hidden" value="{{ $request->view }}" name="view">
                                                <x-adminlte-input-date fgroup-class="row" label-class="text-right"
                                                    igroup-size="md" igroup-class="col-10" igroup-size="md" name="tanggal"
                                                    :config="$config"
                                                    value="{{ $request->tanggal ?? now()->format('Y-m-d') }}">
                                                    <x-slot name="appendSlot">
                                                        <button class="btn btn-sm btn-primary withLoad" type="submit"><i
                                                                class="fas fa-search "></i>
                                                            Pencarian</button>
                                                    </x-slot>
                                                </x-adminlte-input-date>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <button class="btn btn-sm bg-primary" data-toggle="modal"
                                        data-target="#modal-cetak-label">CETAK
                                        LABEL</button>
                                    <a onClick="window.location.reload();" class="btn btn-sm btn-warning">
                                        <i class="fas fa-sync"></i> Refresh</a>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane show active">
                            @php
                                $heads = [
                                    'Pasien',
                                    'Alamat',
                                    'Kunjungan',
                                    'Tanggal Masuk',
                                    'Diagnosa / SEP',
                                    'Status Pasien',
                                    'Aksi',
                                ];
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
                                            {{ $item->rm }} | <b>(RM PASIEN)</b> <br>
                                            {{ $item->kunjungan }} | <b>({{ $item->nama_unit }})</b>
                                            <br>
                                            <b>
                                                {{ $item->status }}
                                            </b> <br>
                                            {{ $item->tgl_kunjungan }} | TANGGAL
                                        </td>

                                        <td >{{ $item->tgl_kunjungan }}</td>
                                        <td style="width: 20%;">
                                            <strong>
                                                - DIAGNOSA: {{ $item->diagx }}
                                            </strong> <br>
                                            <strong>
                                                - SEP: {{ $item->sep }}
                                            </strong>
                                            @if ($item->sep)
                                                <x-adminlte-button type="button" data-sep="{{ $item->sep }}"
                                                    theme="danger" class="btn-block btn btn-xs btn-deleteSEP"
                                                    id="btn-deleteSEP" label="Hapus SEP" />
                                                <a href="{{ route('cetak-sep-igd', ['sep' => $item->sep]) }}"
                                                    target="_blank" class="btn-block btn btn-primary btn-xs">Cetak SEP</a>
                                            @else
                                                <x-adminlte-button data-kode="{{ $item->kunjungan }}" type="button"
                                                    theme="success" data-toggle="modal" data-target="#modal-insert-sep"
                                                    class="btn-block btn btn-xs btn-insert-sep" id="btn-insert-sep"
                                                    label="Insert SEP Vclaim" />
                                            @endif
                                        </td>
                                        <td style="width: 10%;">
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
                                                        <x-adminlte-button type="button"
                                                            data-kunjungan="{{ $item->kunjungan }}" theme="primary"
                                                            class="btn-xs btn-sync-sistem" id="btn-sync-sistem"
                                                            label="Sync Sistem" />
                                                    @else
                                                        {{ $item->form_send_by == 0 ? 'FORM DAFTAR' : 'FORM RANAP' }}
                                                    @endif
                                                </a>
                                            </small>
                                        </td>
                                        <td style="width: 20%;">
                                            @if ($request->view == 'kunjungan_ranap')
                                                @if ($item->id_status === 1)
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
                                                @endif
                                            @else
                                                {{-- <x-adminlte-button type="button" data-nama="{{ $item->pasien }}"
                                                    data-nik="{{ $item->nik }}" data-rm="{{ $item->rm }}"
                                                    data-nokartu="{{ $item->noKartu }}"
                                                    data-kunjungan="{{ $item->kunjungan }}"
                                                    data-jpdaftar="{{ $item->jp_daftar }}" theme="primary"
                                                    class="btn-xs btn-diagnosa show-formdiagnosa mt-1" id="btn-diagnosa"
                                                    label="Diagnosa" /> --}}
                                                    <blockquote>
                                                        <p>
                                                            fitur update diagnosa dan bridging sep igd sedang dalam proses perbaikan. silahkan gunakan vclaim terlebih dahulu untuk pembuatan sep igd.
                                                        </p>
                                                    </blockquote>
                                            @endif
                                            <x-adminlte-button type="button" data-rm="{{ $item->rm }}"
                                                data-nama="{{ $item->pasien }}" data-kunjungan="{{ $item->kunjungan }}"
                                                theme="danger" class="btn-xs btn-cancelVisit mt-1" id="btn-cancelVisit"
                                                label="Batal Kunjungan" />
                                        </td>
                                    </tr>
                                @endforeach
                            </x-adminlte-datatable>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('simrs.igd.kunjungan.modal.modal_bridgin-diaganosa_sep')
    @include('simrs.igd.kunjungan.modal.modal_cetak_label')
    @include('simrs.igd.kunjungan.modal.insert_sep_vclaim')

@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)

@section('js')

    <script>
        $('.select2').select2();
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
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
            $("#diagICD10").select2({
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
            $('.btn-insert-sep').click(function(e) {
                $("#kode_insert_sep").val($(this).data('kode'));
            });
            $('.btn-synchronize-sep').click(function(e) {
                var urlBridging = "{{ route('synch.diagnosa') }}";
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
                                if (data.code == 400) {
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tangkap event klik pada tombol dengan ID 'btn-cancelVisit'
            document.querySelectorAll('#btn-cancelVisit').forEach(button => {
                button.addEventListener('click', function() {
                    // Ambil data dari atribut HTML
                    const rm = this.getAttribute('data-rm');
                    const kunjungan = this.getAttribute('data-kunjungan');
                    const nama = this.getAttribute('data-nama');
                    // Tampilkan SweetAlert
                    Swal.fire({
                        title: `BATALKAN KUNJUNGAN A.N ${nama}`,
                        input: 'textarea',
                        inputLabel: 'Masukkan keterangan',
                        inputPlaceholder: 'Masukkan alasan pembatalan',
                        inputAttributes: {
                            'aria-label': 'Masukkan alasan pembatalan',
                            'required': true
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Kirim',
                        cancelButtonText: 'Batal',
                        showLoaderOnConfirm: true,
                        preConfirm: (keterangan) => {
                            if (!keterangan) {
                                Swal.showValidationMessage('Keterangan wajib diisi!');
                                return false;
                            }

                            // Kirim data ke server menggunakan fetch atau metode lain
                            return fetch('{{ route('update-batal.kunjungan') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ganti dengan token CSRF Anda jika diperlukan
                                    },
                                    body: JSON.stringify({
                                        rm,
                                        kunjungan,
                                        keterangan
                                    })
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error(
                                            'Network response was not ok.');
                                    }
                                    return response.json();
                                })
                                .then(result => {
                                    if (result.success) {
                                        Swal.fire({
                                            title: 'Berhasil!',
                                            text: 'Kunjungan telah dibatalkan.',
                                            icon: 'success'
                                        }).then(() => {
                                            // Segarkan halaman setelah menutup SweetAlert
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire('Gagal!',
                                            'Terjadi kesalahan saat membatalkan kunjungan.',
                                            'error');
                                    }
                                })
                                .catch(error => {
                                    Swal.fire('Gagal!',
                                        'Terjadi kesalahan saat membatalkan kunjungan.',
                                        'error');
                                });
                        }
                    });
                });
            });
        });
    </script>
@endsection
