@extends('adminlte::page')

@section('title', 'Data Resume')

@section('content_header')
    <h1>Data Resume</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Data Resume Rawat Inap" theme="primary" collapsible>
                <form method="get">
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="Tanggal Awal">Tanggal Awal</label>
                                <input type="date" class="form-control" name="tgl_awal" value="{{old('tgl_awal', $request->tgl_awal ?? now()->format('Y-m-d'))}}">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="Tanggal Akhir">Tanggal Akhir</label>
                                <input type="date" class="form-control" name="tgl_akhir" value="{{old('tgl_akhir', $request->tgl_akhir ?? now()->format('Y-m-d'))}}">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="Ruangan">Ruangan</label>
                                <select name="ruangan" id="ruangan" class="form-control">
                                    @foreach ($unit as $dataUnit)
                                        <option value="{{ $dataUnit->kode_unit }}"
                                            {{ old('ruangan', $request->ruangan) == $dataUnit->kode_unit ? 'selected' : '' }}>
                                            {{ $dataUnit->kode_unit }}| {{ $dataUnit->nama_unit }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <button class="btn btn-md btn-primary mt-4">Tampilkan</button>
                        </div>
                    </div>
                </form>

                <!-- Table Data -->
                <table class="table table-bordered table-hover table-sm nowrap" id="myTableLama">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>SEP</th>
                            <th>RM</th>
                            <th>Tgl Masuk</th>
                            <th>Tgl Keluar</th>
                            <th>Ruang Rawat</th>
                            <th>Status Pulang</th>
                            <th>Penjamin</th>
                            <th>Resume</th>
                            <th>Verify</th>
                            <th style="width: 17%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kunjungan as $kunjRanap)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kunjRanap->no_sep ?? '' }}</td>
                                <td>{{ $kunjRanap->no_rm ?? '' }} <br> {{ $kunjRanap->pasien->nama_px ?? '' }}</td>
                                <td>{{ $kunjRanap->tgl_masuk ?? '' }}</td>
                                <td>{{ $kunjRanap->tgl_keluar ?? '' }}</td>
                                <td>{{ optional($kunjRanap->unit)->nama_unit ?? '' }}</td>
                                <td>{{ optional($kunjRanap->alasan_pulang)->alasan_pulang ?? '' }}</td>
                                <td>{{ optional($kunjRanap->penjamin_simrs)->nama_penjamin ?? '' }}</td>
                                <td>{{ optional($kunjRanap->resume)->status_resume == 1 ? 'selesai' : 'belum' }}</td>
                                <td>{{ optional($kunjRanap->resume)->verify_resume == 1 ? 'selesai' : 'belum' }}</td>
                                <td>
                                    <button class="btn btn-xs btn-warning" data-toggle="modal"
                                        data-target="#lihatFileResume" data-kode="{{ $kunjRanap->kode_kunjungan }}">
                                        <i class="fas fa-file-pdf"></i> lihat
                                    </button>
                                    <button type="button" class="btn btn-xs btn-success"
                                        onclick="verifyResume('{{ $kunjRanap->kode_kunjungan }}')">
                                        <i class="fas fa-user-check"></i> verify
                                    </button>
                                    <a href="{{ route('casemix-resume.coder.diagnosa',['kode'=>$kunjRanap->kode_kunjungan]) }}" class="btn btn-xs btn-info"> Code Diag</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


                <x-adminlte-modal id="lihatFileResume" title="Data Resume" size="xl">
                    <iframe id="icd10-frame" src="" width="100%" height="700px" frameborder="0"></iframe>
                </x-adminlte-modal>
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.TempusDominusBs4', true)

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('#lihatFileResume').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var kodeKunjungan = button.data('kode'); // Extract the code from data-* attribute
            var iframe = $(this).find('#icd10-frame');
            iframe.attr('src', '{{ route('resume-pemulangan.vbeta.print-resume') }}?kode=' + kodeKunjungan);
        });

        function verifyResume(kodeKunjungan) {
            // Konfirmasi menggunakan SweetAlert2
            Swal.fire({
                title: 'Konfirmasi Verifikasi',
                text: 'Apakah Anda yakin ingin melakukan verifikasi untuk Kunjungan kode: ' + kodeKunjungan + '?',
                // text: 'Apakah Anda yakin ingin melakukan verifikasi ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, verifikasi!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('casemix-resume.verify.resume') }}',
                        type: 'GET',
                        data: {
                            kode_kunjungan: kodeKunjungan
                        },
                        success: function(response) {
                            Swal.fire(
                                'Berhasil!',
                                response.message,
                                'success'
                            );
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Terjadi Kesalahan!',
                                'Verifikasi gagal. Silakan coba lagi.',
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>
@endsection
