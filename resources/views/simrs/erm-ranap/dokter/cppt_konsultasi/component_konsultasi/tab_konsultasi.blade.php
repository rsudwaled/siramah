<div class="tab-pane active" id="form-konsultasi">
    <div class="col-12">
        <form name="formKonsultasi" id="formKonsultasi" method="POST">
            @csrf
            <div class="row">
                <input type="hidden" name="kode_kunjungan" id="kode_konsultasi" value="{{ $kunjungan->kode_kunjungan }}">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-4 row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Nama Pasien</label>
                                    <input type="text" class="form-control" name="nama_pasien"
                                        value="{{ $kunjungan->pasien->nama_px }}" readonly>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Ruangan</label>
                                    <input type="text" class="form-control" name="ruangan"
                                        value="{{ $kunjungan->unit->nama_unit }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>No RM</label>
                                    <input type="text" class="form-control" name="no_rm"
                                        value="{{ $kunjungan->no_rm }}" readonly>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <input type="text" class="form-control" name="jk_pasien"
                                        value="{{ $kunjungan->pasien->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }} "
                                        readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-4 row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal_konsultasi"
                                        value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Waktu</label>
                                    <input type="time" class="form-control" name="waktu_konsultasi"
                                        value="{{ Carbon\Carbon::now()->format('H:i') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Konsultasi Pasien</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="Kpd Yth">Kpd Yth :</label>
                                            <input type="text" name="nama_dokter_konsul" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="Kontak Dokter">Kontak Dokter</label>
                                            <input type="text" name="kontak_dokter_konsul" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="Jenis Konsultasi">Jenis Konsultasi</label>
                                            <select name="jenis_konsultasi" id="jenis_konsultasi" class="form-control">
                                                <option value="konsul_untuk_kondisi_saat_ini">Konsul Untuk Kondisi Saat
                                                    Ini
                                                </option>
                                                <option value="alih_rawat">Alih Rawat</option>
                                                <option value="tim_medis">Tim Medis</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="Sebagai DP JP">Sebagai DP JP</label>
                                            <input type="text" name="tim_medis_dokter" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="Spesialis">Spesialis</label>
                                            <input type="text" name="spesialis" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="Keterangan Konsul">Keterangan Konsul</label>
                                    <textarea name="keterangan_konsul" id="keterangan_konsul" class="form-control" cols="30" rows="10"></textarea>
                                </div>
                                <div class="row float-right">
                                    <button type="submit" class="btn btn-md btn-success" id="btnSubmit">
                                        <i class="fas fa-save"></i> Simpan Data
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-12 mt-1">
        <div class="card">
            <div class="card-header">
               <div class="col-12 row">
                <div class="col-6">
                    <h3 class="card-title">Data Konsultasi</h3>
                </div>
                <div class="col-6 text-right">
                    <button class="btn btn-primary btn-sm text-right">Lihat Semua Cetakan</button>
                </div>
               </div>
            </div>

            <div class="card-body table-responsive p-0" style="height: 400px;">
                <div class="col-sm-12 mt-3">
                    <table id="table-konsultasi" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal/Waktu</th>
                                <th>Ditujukan</th>
                                <th>Jenis</th>
                                <th>Pembahasan</th>
                                <th>Respon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Setup CSRF token untuk semua request Ajax
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Fungsi untuk memuat ulang data di tabel konsultasi
        function loadTableData() {
            var kunjungan = $('#kode_konsultasi').val();
            $.ajax({
                url: "{{ route('dashboard.erm-ranap.perkembangan-pasien.get-konsultasi') }}", // URL endpoint
                type: 'GET',
                data: { kunjungan: kunjungan },
                success: function(data) {
                    console.log('Data yang diterima: ', data); // Debugging
                    var rows = '';
                    if (data.length > 0) {
                        data.forEach(function(konsultasiPasien) {
                            rows += `
                            <tr>
                                <td>${konsultasiPasien.tanggal_konsultasi} / ${konsultasiPasien.waktu_konsultasi}</td>
                                <td>Tujuan: ${konsultasiPasien.tujuan_konsul} <br> Pemohon: ${konsultasiPasien.pengirim_konsul}</td>
                                <td>${konsultasiPasien.jenis_konsul}</td>
                                <td>${konsultasiPasien.keterangan}</td>
                                <td>${konsultasiPasien.status_jawab === 0 ? 'Belum Dijawab' : 'Sudah Dijawab'}</td>
                                <td>
                                    <button class="btn btn-xs btn-warning btn-block">Edit</button>
                                    <button class="btn btn-xs btn-danger btn-block">Hapus</button>
                                    <button class="btn btn-xs btn-success btn-block">Kirim <i class="fab fa-whatsapp"></i></button>
                                </td>
                            </tr>`;
                        });
                    } else {
                        rows =
                            `<tr><td colspan="7" class="text-center">Tidak ada data yang tersedia</td></tr>`;
                    }
                    $('#table-konsultasi tbody').html(rows);
                },
                error: function(xhr) {
                    console.log('Error loading data: ', xhr);
                }
            });
        }

        // Memuat data tabel pertama kali saat halaman dimuat
        loadTableData();

        // Memuat ulang data tabel ketika tab 'form-konsultasi' aktif
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            if ($(e.target).attr('href') === '#form-konsultasi') {
                loadTableData(); // Muat ulang data saat tab diaktifkan
            }
        });

        // Submit form via AJAX
        $('#formKonsultasi').on('submit', function(e) {
            e.preventDefault(); // Mencegah form dari submit secara default
            var formData = $(this).serialize();

            $.ajax({
                url: "{{ route('dashboard.erm-ranap.perkembangan-pasien.store-konsultasi') }}", // URL dari form action
                type: "POST",
                data: formData,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Data konsultasi berhasil disimpan!',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(function() {
                        loadTableData
                            (); // Panggil fungsi untuk memuat ulang tabel setelah data disimpan

                        // Reset form setelah data disimpan
                        $('#formKonsultasi')[0].reset();
                    });
                },
                error: function(xhr) {
                    var errorMessage = xhr.status + ': ' + xhr.statusText;
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan: ' + errorMessage,
                    });
                }
            });
        });
    });
</script>
