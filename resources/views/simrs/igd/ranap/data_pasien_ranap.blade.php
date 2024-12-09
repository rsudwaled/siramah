@extends('adminlte::page')
@section('title', 'Pasien Rawat Inap')

@section('content_header')
    <div class="alert bg-success alert-dismissible">
        <div class="row">
            <div class="col-sm-4">
                <h5>
                    <i class="fas fa-user-tag"></i> DAFTAR PASIEN RANAP :
                </h5>
            </div>
            <div class="col-sm-8">
            </div>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary card-outline card-tabs">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="" method="get">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <x-adminlte-input name="rm" label="NO RM" value="{{ $request->rm }}"
                                            placeholder="Masukan Nomor RM ....">
                                            <x-slot name="appendSlot">
                                                <x-adminlte-button theme="primary" class="withLoad" type="submit"
                                                    label="Cari!" />
                                            </x-slot>
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text text-primary">
                                                    <i class="fas fa-search"></i>
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input>
                                        <x-adminlte-input name="nama" label="NAMA PASIEN" value="{{ $request->nama }}"
                                            placeholder="Masukan Nama Pasien ....">
                                            <x-slot name="appendSlot">
                                                <x-adminlte-button theme="primary" class="withLoad" type="submit"
                                                    label="Cari!" />
                                            </x-slot>
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text text-primary">
                                                    <i class="fas fa-search"></i>
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input>
                                    </div>
                                    <div class="col-lg-4">
                                        <x-adminlte-input name="cari_desa" label="CARI BERDASARKAN DESA"
                                            value="{{ $request->cari_desa }}"
                                            placeholder="Masukan nama desa dengan lengkap...">
                                            <x-slot name="appendSlot">
                                                <x-adminlte-button theme="primary" class="withLoad" type="submit"
                                                    label="Cari!" />
                                            </x-slot>
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text text-primary">
                                                    <i class="fas fa-search"></i>
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input>
                                        <x-adminlte-input name="cari_kecamatan" label="CARI BERDASARKAN KECAMATAN"
                                            value="{{ $request->cari_kecamatan }}"
                                            placeholder="Masukan nama kecamatan dengan lengkap...">
                                            <x-slot name="appendSlot">
                                                <x-adminlte-button theme="primary" class="withLoad" type="submit"
                                                    label="Cari!" />
                                            </x-slot>
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text text-primary">
                                                    <i class="fas fa-search"></i>
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input>
                                    </div>
                                    <div class="col-lg-4">
                                        <x-adminlte-input name="nomorkartu" label="NOMOR KARTU"
                                            value="{{ $request->nomorkartu }}" placeholder="Masukan Nomor Kartu BPJS ....">
                                            <x-slot name="appendSlot">
                                                <x-adminlte-button theme="success" class="withLoad" type="submit"
                                                    label="Cari!" />
                                            </x-slot>
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text text-success">
                                                    <i class="fas fa-search"></i>
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input>
                                        <x-adminlte-input name="nik" label="NIK (NOMOR INDUK KEPENDUDUKAN)"
                                            value="{{ $request->nik }}" placeholder="Masukan nomor NIK ....">
                                            <x-slot name="appendSlot">
                                                <x-adminlte-button theme="success" class="withLoad" type="submit"
                                                    label="Cari!" />
                                            </x-slot>
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text text-success">
                                                    <i class="fas fa-search"></i>
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary card-outline card-tabs">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-lg-8">
                            <div class="col-12 row">
                                <div class="col-lg-6">
                                    <form action="" method="get">
                                        <div class="input-group">
                                            <input id="new-event" type="date" name="start" class="form-control"
                                                value="{{ $request->start != null ? \Carbon\Carbon::parse($request->start)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                placeholder="Event Title">
                                            <input id="new-event" type="date" name="finish" class="form-control"
                                                value="{{ $request->finish != null ? \Carbon\Carbon::parse($request->finish)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                placeholder="Event Title">
                                            <div class="input-group-append">
                                                <button id="add-new-event" type="submit"
                                                    class="btn btn-primary btn-sm withLoad ml-3">CARI DATA</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-info btn-md">JUMLAH PASIEN MENUNGGU KAMAR : <b>{{$menunggu}} PASIEN</b></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 text-right">
                            <a href="{{ route('pasien.ranap') }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-sync"></i> Bersihkan Pencarian</a>
                        </div>
                    </div>
                    @php
                        $heads = [
                            'TGL MASUK ',
                            'PASIEN',
                            'KUNJUNGAN',
                            'RUANGAN',
                            'SPRI / SEP RANAP',
                            'AKSI',
                            'BRIDGING SEP',
                        ];
                        $config['order'] = false;
                        $config['paging'] = false;
                        $config['info'] = false;
                        $config['scrollY'] = '600px';
                        $config['scrollCollapse'] = true;
                        $config['scrollX'] = true;
                    @endphp
                    <x-adminlte-datatable id="table" class="text-xs" :heads="$heads" head-theme="dark"
                        :config="$config" striped bordered hoverable compressed>
                        @foreach ($kunjungan as $item)
                            <tr style="{{ $item->status_kunjungan == 14 ? 'background: rgb(255, 216, 216);' : '' }}">
                                <td>
                                    <b>{{ $item->tgl_masuk }}</b> <br>
                                    @php
                                        $user = App\Models\UserSimrs::where('id', $item->pic)->first();
                                    @endphp
                                    <small><span class="badge badge-success"> Admin: {{ $user->nama_user }}</span></small>
                                </td>

                                <td>
                                    <a href="{{ route('edit-pasien', ['rm' => $item->pasien->no_rm]) }}"
                                        target="__blank">
                                        <b>{{ $item->pasien->nama_px }}</b> <br>RM : {{ $item->pasien->no_rm }} <br>NIK :
                                        {{ $item->pasien->nik_bpjs }} <br>No Kartu : {{ $item->pasien->no_Bpjs }}
                                    </a>
                                </td>
                                {{-- <td style="background: rgb(255, 216, 216)"> --}}
                                <td>
                                    <b>
                                        {{ $item->pasien->no_rm }} | (RM PASIEN) <br>
                                        {{ $item->kode_kunjungan }} | ({{ $item->unit->nama_unit }}) <br>
                                        @if (!empty($item->tgl_keluar))
                                            <b>PASIEN SUDAH KELUAR</b>
                                        @else
                                            Status: <strong
                                                class="{{ $item->status_kunjungan == 1 ? 'text-success' : 'text-danger' }}">{{ strtoupper($item->status->status_kunjungan) }}</strong>
                                        @endif
                                    </b><br>
                                    <b>{{ $item->jp_daftar == 1 ? 'BPJS' : ($item->jp_daftar == 0 ? 'UMUM' : 'BPJS PROSES') }}</b>
                                    {{-- {{ $item->penjamin == null ? $item->penjamin_simrs->nama_penjamin : $item->penjamin->nama_penjamin_bpjs }} --}}
                                    {{ $item->penjamin == null ? ($item->penjamin_simrs?->nama_penjamin ?? 'Nama Penjamin Tidak Ada') : ($item->penjamin?->nama_penjamin_bpjs ?? 'Nama Penjamin BPJS Tidak Ada') }}

                                </td>
                                <td>
                                    <b>
                                        Kamar : {{ $item->kamar }} <br>
                                        BED : {{ $item->no_bed }} <br>
                                        Kelas : {{ $item->kelas }} <br>
                                    </b>
                                    @if ($item->is_ranap_daftar == 3)
                                        <small class="text-red"><b><i>( PASIEN TITIPAN )</i></b></small>
                                    @endif
                                    @if (!is_null($item->bpjsCheckHistories))
                                        @if (!is_null($item->bpjsCheckHistories->klsRawatNaik))
                                            @php
                                                if ($item->bpjsCheckHistories->klsRawatNaik == 3) {
                                                    $naikKelas = 1;
                                                }
                                                if ($item->bpjsCheckHistories->klsRawatNaik == 4) {
                                                    $naikKelas = 2;
                                                }
                                                if ($item->bpjsCheckHistories->klsRawatNaik == 5) {
                                                    $naikKelas = 3;
                                                }
                                                if ($item->bpjsCheckHistories->klsRawatNaik == 2) {
                                                    $naikKelas = 4;
                                                }
                                                if ($item->bpjsCheckHistories->klsRawatNaik == 1) {
                                                    $naikKelas = 5;
                                                }
                                            @endphp
                                            <small class="text-red"><b><i>(NAIK KELAS :
                                                        Dari-{{ $item->bpjsCheckHistories->klsRawatHak }}
                                                        Ke-{{ $naikKelas }} )</i></b></small>
                                        @endif
                                    @endif
                                </td>
                                <td style="width: 20%;">
                                    @if ($item->jp_daftar == 1)
                                        <b>
                                            SPRI : {{ $item->no_spri == null ? 'PASIEN BELUM BUAT SPRI' : $item->no_spri }}
                                            <br>
                                            SEP : {{ $item->no_sep == null ? 'PASIEN BELUM GENERATE SEP' : $item->no_sep }}
                                            <br> Diag: <strong>{{ $item->diagx ?? '-' }}</strong>
                                        </b>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('pasien-ranap.detail', ['kunjungan' => $item->kode_kunjungan]) }}"
                                        class="btn btn-success btn-xs btn-block btn-flat">Detail</a>
                                    <button class="btn btn-xs btn-cancelVisit btn-danger btn-block" id="btn-cancelVisit"
                                        data-nama="{{ $item->pasien->nama_px }}"
                                        data-kunjungan="{{ $item->kode_kunjungan }}" data-rm="{{ $item->no_rm }}">Batal
                                        Kunjungan</button>
                                    <a href="{{ route('simrs.pendaftaran-ranap-igd.edit-ruangan', ['kunjungan' => $item->kode_kunjungan]) }}"
                                        class="btn btn-warning btn-xs btn-block btn-flat mt-2">Edit Ruangan</a>
                                </td>
                                <td>
                                    <button type="button" class="text-left btn btn-primary btn-xs btn-block btnModalSPRI"
                                        data-id="{{ $item->kode_kunjungan }}"
                                        data-nomorkartu="{{ $item->pasien->no_Bpjs }}" data-toggle="modal"
                                        data-target="modalSPRI">
                                        <i class="fas fa-file-contract"></i> Buat SPRI
                                    </button>
                                    <button type="button"
                                        class="text-left btn bg-purple btn-xs btn-block btn-createSEPRanap"
                                        data-spri="{{ $item->no_spri }}" data-kunjungan="{{ $item->kode_kunjungan }}"
                                        data-rm="{{ $item->no_rm }}" data-pasien="{{ $item->pasien->nama_px }}"
                                        data-bpjs="{{ $item->pasien->no_Bpjs }}">
                                        <i class="fas fa-file-contract"></i> SEP RANAP
                                    </button>

                                    <a href="#" class="text-left btn btn-secondary btn-xs btn-block btn-print-sep"
                                        data-sep="{{ $item->no_sep }}"><i class="fas fa-file-contract"></i> Print SEP</a>
                                </td>
                            </tr>
                            @include('simrs.igd.bridging_bpjs.modal_spri.create_spri')
                            @include('simrs.igd.bridging_bpjs.modal_update_diagnosa.update_diagnosa')
                        @endforeach
                    </x-adminlte-datatable>
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
        function batalPilih() {
            $(".riwayat-kunjungan").remove();
            $('#no_rm').val('');
        }

        function pilihRiwayat(kode, rm) {
            Swal.fire({
                title: "Apakah Anda Yakin?",
                text: "Pilih Riwayat Kunjungan untuk daftar Rawat Inap!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Pilih!",
                cancelButtonText: "Batal!",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'GET',
                        url: "{{ route('riwayat-ranap.daftar') }}",
                        dataType: 'json',
                        data: {
                            kode: kode,
                            rm: rm,
                        },
                        success: function(response) {
                            window.location.href = response.url;
                        },
                    });
                }
            });
        }
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
    <script>
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

            $("#poliklinik").select2({
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('ref_poliklinik_api') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        console.log(params);
                        return {
                            poliklinik: params.term // search term
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

            $("#dokter").select2({
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('dokter-bypoli.get') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        console.log(params)
                        return {
                            kodePoli: $("#poliklinik option:selected").val() // search term
                        };
                    },
                    processResults: function(response) {
                        console.info(response)
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });

            $('.btn-createSEPRanap').click(function(e) {
                var spri = $(this).data('spri');
                var kunjungan = $(this).data('kunjungan');
                var nomorKartuBpjs = $(this).data('bpjs');
                var rm = $(this).data('rm');
                var pasien = $(this).data('pasien');

                // Menyisipkan nilai ke input modal berdasarkan class
                $('.no_spri').val(spri); // Menggunakan class .no_spri
                $('.kunjungan').val(kunjungan); // Menggunakan class .kunjungan
                $('.nomorBpjs').val(nomorKartuBpjs); // Menggunakan class .nomorBpjs
                $('.noMR').val(rm); // Menggunakan class .noMR
                $('.namaPasien').val(pasien); // Menggunakan class .namaPasien

                // Menampilkan modal
                $('#modalCreateSepRanap').modal('show');

                // Reset form ketika modal ditutup
                $('#modalCreateSepRanap').on('hidden.bs.modal', function() {
                    $('#formCreateSepRanap')[0].reset();
                });
            });

            $('.btnModalSPRI').click(function(e) {
                var kunjungan = $(this).data('id');
                var noKartu = $(this).data('nomorkartu');
                $('#noKartu').val(noKartu);
                $('#kodeKunjungan').val(kunjungan);
                $('.lanjutkanPROSESDAFTAR').hide();
                $('#modalSPRI').modal('toggle');
            });

            $('.btnCreateSPRI').click(function(e) {
                var kodeKunjungan = $("#kodeKunjungan").val();
                var noKartu = $("#noKartu").val();
                var kodeDokter = $("#dokter").val();
                var poliKontrol = $("#poliklinik option:selected").val();
                var tglRencanaKontrol = $("#tanggal").val();
                var user = $("#user").val();
                var url = "{{ route('bridging-igd.create-spri') }}";
                $.LoadingOverlay("show");
                $.ajax({
                    type: 'POST',
                    url: url,
                    dataType: 'json',
                    data: {
                        noKartu: noKartu,
                        kodeDokter: kodeDokter,
                        poliKontrol: poliKontrol,
                        tglRencanaKontrol: tglRencanaKontrol,
                        kodeKunjungan: kodeKunjungan,
                        user: user,
                    },
                    success: function(data) {

                        if (data.metadata.code == 200) {
                            Swal.fire('SPRI BERHASIL DIBUAT', '', 'success');
                            $("#createSPRI").modal('toggle');
                            window.location.reload();
                            $.LoadingOverlay("hide");
                        } else {
                            Swal.fire(data.metadata.message + '( ERROR : ' + data.metadata
                                .code + ')', '', 'error');
                            $.LoadingOverlay("hide");
                        }
                    },

                });
            });

            $('.btn-deleteSEP').click(function(e) {
                var sep = $(this).data('sep');
                var deleteSEP = "{{ route('bridging-igd.delete-sep-ranap') }}";
                Swal.fire({
                    title: "Apakah Anda Yakin Hapus SEP?",
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
                alert(spri);
                var deleteSPRI = "{{ route('bridging-igd.delete-spri') }}";
                Swal.fire({
                    title: "Apakah Anda Yakin Hapus SPRI?",
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

            $('.btn-print-sep').click(function(e) {
                e.preventDefault(); // Mencegah aksi default link

                var sep = $(this).data('sep'); // Mengambil data sep dari atribut data-sep
                var url = "{{ route('bridging-igd.sep-print') }}"; // URL API tujuan
                Swal.fire({
                    title: "Apakah Anda Yakin Ingin Print SEP?",
                    text: "Pastikan data SEP sudah benar!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Print SEP!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Menyusun URL dengan query string setelah konfirmasi
                        var urlWithParams = url + '?noSep=' + encodeURIComponent(sep);

                        // Membuka halaman di tab baru dengan data di query string
                        window.open(urlWithParams, '_blank');
                    }
                });
            });
        });

        $(document).ready(function() {
            $('#formCreateSepRanap').on('submit', function(e) {
                e.preventDefault();
                var diagnosa = $('#diagnosa').val();
                var errors = [];

                if (diagnosa === "") {
                    errors.push('Diagnosa harus dipilih.');
                }

                // Jika ada error, tampilkan pesan
                if (errors.length > 0) {
                    Swal.fire({
                        title: 'Error!',
                        text: errors.join("\n"),
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return; // Stop di sini, jangan lanjut submit
                }
                var formData = $(this).serialize(); // Serialize form data
                Swal.fire({
                    title: 'Apakah Data Sudah Benar?',
                    text: "jika anda sudah yakin klik tombol simpan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // AJAX POST request
                        $.LoadingOverlay("show");
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('bridging-igd.create-sep-ranap') }}", // Action URL
                            data: formData,
                            success: function(response) {
                                var metaData = response.metaData;
                                if (metaData.code == 200) {
                                    $.LoadingOverlay("hide");
                                    Swal.fire({
                                        title: 'Success!',
                                        text: 'SEP Rawat Inap Berhasil dibuat.',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        if (result.isConfirmed) {
                                            // Menyembunyikan loading overlay
                                            window.location
                                                .reload(); // Memuat ulang halaman
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error! ' + metaData.code,
                                        text: metaData.message,
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                    $.LoadingOverlay("hide");
                                }
                            },
                            error: function(xhr, status, error) {
                                console.info(status);
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Terjadi kesalahan saat mengirim data.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                                $.LoadingOverlay("hide");
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
