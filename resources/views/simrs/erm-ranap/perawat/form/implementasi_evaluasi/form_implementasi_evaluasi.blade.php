<div class="col-12">
    <form action="{{ route('dashboard.erm-ranap.perawat.implementasi-evaluasi.store-implementasi-evaluasi') }}" name="formImplementasiEvaluasiPerawat" id="formImplementasiEvaluasiPerawat" method="POST">
        @csrf
        @php
            // Menghitung usia dari tanggal lahir
            $tanggal_lahir = $kunjungan->pasien->tgl_lahir;
            $tanggal_lahir_obj = new DateTime($tanggal_lahir);
            $tanggal_sekarang = new DateTime();
            $usia = $tanggal_sekarang->diff($tanggal_lahir_obj)->y;
        @endphp
        <input type="hidden" name="kode" value="{{$kunjungan->kode_kunjungan}}">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="Nama Pasien">Nama Pasien</label>
                            <input type="text" name="nama_pasien" class="form-control"
                                value="{{ $kunjungan->pasien->nama_px }} {{ '| Usia ' . $usia . ' (Tahun)' }}" readonly>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="RM PASIEN">RM PASIEN</label>
                            <input type="text" name="rm_pasien" class="form-control"
                                value="{{ $kunjungan->pasien->no_rm }}" readonly>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="Jenis Kelamin">Jenis Kelamin</label>
                            <input type="text" name="jk_pasien" class="form-control"
                                value="{{ $kunjungan->pasien->jenis_kelamin == 'P' ? 'Perempuan' : 'Laki-Laki' }}"
                                readonly>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="Tanggal Lahir">Tanggal Lahir</label>
                            <input type="text" name="tgl_lahir_pasien" class="form-control"
                                value="{{ Carbon\Carbon::parse($kunjungan->pasien->tgl_lahir)->format('Y-m-d') }}"
                                readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Implementasi Evaluasi</h3>
                        <div class="card-tools">
                            <button type="button" id="addRowImplementasi" class="btn btn-primary btn-xs">
                                Tambah Baris
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div id="dynamicFormImplementasi">
                            <div class="row">
                                <div class="col-2">
                                    <div class="form-group">
                                        <label>Tanggal</label>
                                        <input type="date" class="form-control"
                                            name="tanggal_implementasi_evaluasi[]"
                                            value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Waktu</label>
                                        <input type="time" class="form-control" name="waktu_implementasi_evaluasi[]"
                                            value="{{ Carbon\Carbon::now()->format('H:i') }}">
                                    </div>
                                </div>
                                <div class="col-10">
                                    <div class="form-group">
                                        <label>Implementasi & evaluasi</label>
                                        <textarea name="keterangan_implementasi[]" id="keterangan_implementasi" class="form-control" cols="30"
                                            rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row float-right">
            <button type="submit" class="btn btn-md btn-success" form="formImplementasiEvaluasiPerawat">
                <i class="fas fa-save"></i> Simpan Data</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        // Event listener untuk tombol "Add Row"
        $('#addRowImplementasi').click(function() {
            // Baris baru yang akan ditambahkan
            var newRow = `
            <div class="row ">
                <div class="col-2">
                    <div class="form-group">
                        <label>Tanggal & Waktu</label>
                        <input type="date" class="form-control" name="tanggal_implementasi_evaluasi[]" readonly
                            value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                    </div>
                    <div class="form-group">
                        <input type="time" class="form-control" name="waktu_implementasi_evaluasi[]"
                            value="{{ Carbon\Carbon::now()->format('H:i') }}">
                    </div>
                    <button type="button" class="btn btn-danger btn-md btn-block removeRow">Hapus</button>
                </div>
                <div class="col-10">
                    <div class="form-group">
                        <label>Implementasi & evaluasi</label>
                        <textarea name="keterangan_implementasi[]" id="keterangan_implementasi" class="form-control" cols="30" rows="5"></textarea>
                    </div>
                </div>
            </div>
        `;

            // Menambahkan baris baru ke dalam form
            $('#dynamicFormImplementasi').append(newRow);
        });

        // Event listener untuk tombol "Delete Row"
        $('#dynamicFormImplementasi').on('click', '.removeRow', function() {
            $(this).closest('.row').remove();
        });

    });
</script>
