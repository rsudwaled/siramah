@extends('layouts_erm.app')
@push('style')
@endpush
@section('content')
    <div class="col-12">
        <div class="card" style="font-size: 12px;">
            <div class="card-header p-2">
                <ul class="nav nav-pills" style="font-size: 14px;">
                    <li class="nav-item">
                        <a class="nav-link active" href="#hasil-resume-final" data-toggle="tab">REVIEW RESUME PEMULANGAN</a>
                    </li>

                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content ">
                    <div class="tab-pane active" id="hasil-resume-final">
                        <div class="col-12">
                            <div class="alert alert-warning alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-exclamation-triangle"></i> INFORMASI PENTING!</h5>
                                jika merasa masih terdapat kesalahan dalam pengisian resume, silahkan ajukan permohonan
                                untuk pembukaan kembali pengisian resume kepada rekam medis dengan cara klik tombol berikut:
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal"
                                    data-target="#modalPengajuanPembukaanFormResume">PENGAJUAN PEMBUKAAN FORM PENGISIAN
                                    RESUME PEMULANGAN</button>
                            </div>
                        </div>
                        <iframe
                            src="{{ route('resume-pemulangan.vbeta.print-resume') }}?kode={{ $kunjungan->kode_kunjungan }}"
                            width="100%" height="700px" frameborder="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal untuk menampilkan data -->
    <div class="modal" id="modalPengajuanPembukaanFormResume" tabindex="-1" role="dialog"
        aria-labelledby="modalPengajuanPembukaanFormResumeLabel" aria-hidden="true" data-backdrop="static"
        data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPengajuanPembukaanFormResumeLabel">PENGAJUAN PEMBUKAAN FORM RESUME</h5>
                    <button type="button" class="close" aria-label="Close" onclick="return false;">
                        {{-- <span aria-hidden="true">&times;</span> --}}
                    </button>
                </div>
                <!-- Modal Body -->
                <form action="{{route('resume-pemulangan.vbeta.post.pengajuan-pembukaan-resume')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="col-12 row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="Pasien">Pasien</label>
                                    <input type="text" name="pasien" value="{{ $kunjungan->pasien->nama_px }}" readonly
                                        class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Ruangan">Ruangan</label>
                                <input type="text" name="ruangan" value="{{ $resume->ruang_rawat_keluar }}" readonly
                                    class="form-control">
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="Dokter">Dokter</label>
                                    <input type="text" name="dokter" value="{{ $resume->dpjp }}" readonly
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id_resume" value="{{ $resume->id }}">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="Keterangan">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" class="form-control" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
