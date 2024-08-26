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
                {{-- <div class="alert alert-success">
                    {{ session('success') }}
                </div> --}}
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-check"></i> SIMPAN PASIEN RANAP BERHASIL!</h5>
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary card-outline card-tabs">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-lg-6">
                            <form action="" method="get">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input id="new-event" type="date" name="start" class="form-control"
                                            value="{{ $request->start != null ? \Carbon\Carbon::parse($request->start)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') }}"
                                            placeholder="Event Title">
                                        <input id="new-event" type="date" name="finish" class="form-control"
                                            value="{{ $request->finish != null ? \Carbon\Carbon::parse($request->finish)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') }}"
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
                            <a onClick="window.location.reload();" class="btn btn-sm btn-warning">
                                <i class="fas fa-sync"></i> Refresh</a>
                        </div>
                    </div>
                    @php
                        $heads = [
                            'TGL MASUK ',
                            'PASIEN',
                            'JENIS PASIEN',
                            'KUNJUNGAN',
                            'RUANGAN',
                            'SPRI / SEP RANAP',
                            'DETAIL',
                            'AKSI',
                        ];
                        $config['order'] = ['0', 'desc'];
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
                                    <b>
                                        {{ $item->tgl_masuk }}
                                    </b>
                                </td>

                                <td>
                                    <a href="{{ route('edit-pasien', ['rm' => $item->pasien->no_rm]) }}" target="__blank">
                                        <b>{{ $item->pasien->nama_px }}</b> <br>RM : {{ $item->pasien->no_rm }} <br>NIK :
                                        {{ $item->pasien->nik_bpjs }} <br>No Kartu : {{ $item->pasien->no_Bpjs }}
                                    </a>
                                </td>

                                <td style="width: 15%;">
                                    <b>{{ $item->jp_daftar == 1 ? 'BPJS' : ($item->jp_daftar == 0 ? 'UMUM' : 'BPJS PROSES') }}</b>
                                    <br>
                                    {{ $item->penjamin == null ? $item->penjamin_simrs->nama_penjamin : $item->penjamin->nama_penjamin_bpjs }}
                                </td>
                                <td>
                                    <b>
                                        {{ $item->pasien->no_rm }} | (RM PASIEN) <br>
                                        {{ $item->kode_kunjungan }} | ({{ $item->unit->nama_unit }}) <br>
                                        {{ strtoupper($item->dokter->nama_paramedis) }}<br>
                                        @if (!empty($item->tgl_keluar))
                                            <b>PASIEN SUDAH KELUAR</b>
                                        @else
                                            <strong
                                                class="{{ $item->status_kunjungan == 1 ? 'text-success' : 'text-danger' }}">{{ strtoupper($item->status->status_kunjungan) }}</strong>
                                        @endif
                                    </b>
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
                                            {{-- @else
                                            <small class="text-red"><b><i>( PASIEN TITIPAN )</i></b></small> --}}
                                        @endif
                                    @endif
                                </td>
                                <td style="width: 20%;">
                                    @if ($item->jp_daftar == 1)
                                        <b>
                                            SPRI : {{ $item->no_spri == null ? 'PASIEN BELUM BUAT SPRI' : $item->no_spri }}
                                            <br>
                                            SEP :
                                            {{ $item->no_sep == null ? 'PASIEN BELUM GENERATE SEP' : $item->no_sep }}
                                            <br>
                                            {{-- <strong>Silahkan Klik Tombol Bridging untuk Tahap Pembuatan</strong> --}}
                                        </b>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('pasien-ranap.detail', ['kunjungan' => $item->kode_kunjungan]) }}"
                                        class="btn btn-success btn-xs btn-block btn-flat">Detail</a>
                                    {{-- @if ($item->jp_daftar == 1)
                                        @if ($item->no_spri == null && $item->no_sep == null)
                                            <a href="{{ route('create-sepigd.ranap-bpjs', ['kunjungan' => $item->kode_kunjungan]) }}"
                                                class="btn btn-primary btn-xs btn-block btn-flat">Bridging</a>
                                        @endif
                                    @endif --}}
                                </td>
                                <td>

                                    <x-adminlte-button type="button" data-rm="{{ $item->no_rm }}"
                                        data-nama="{{ $item->pasien->nama_px }}" data-kunjungan="{{ $item->kode_kunjungan }}"
                                        theme="danger" class="btn-xs btn-cancelVisit" id="btn-cancelVisit"
                                        label="Batal Kunjungan" />
                                    <a href="{{ route('simrs.pendaftaran-ranap-igd.edit-ruangan', ['kunjungan' => $item->kode_kunjungan]) }}"
                                        class="btn btn-warning btn-xs btn-block btn-flat mt-2">Edit Ruangan</a>

                                </td>
                            </tr>
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
@endsection
