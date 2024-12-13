<div class="card" style="font-size: 12px;">
    <div class="card-header p-2">
        <ul class="nav nav-pills" style="font-size: 14px;">
            <li class="nav-item">
                <a class="nav-link active" href="#table-data-cppt" data-toggle="tab">Data Perkembangan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#cetak-cppt" data-toggle="tab">Lihat Cetakan</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane active" id="table-data-cppt">
                <div class="col-12">
                    <form action="{{ route('dashboard.erm-ranap.perkembangan-pasien.store-perkembangan') }}"
                        id="formCPPTKonsultasi" method="POST">
                        @csrf
                        <input type="hidden" name="kode_kunjungan" id="kode_kunjungan"
                            value="{{ $kunjungan->kode_kunjungan }}">
                        <div class="row">
                            <!-- Ruangan dan No RM -->
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Ruangan</label>
                                            <input type="text" class="form-control" name="ruangan"
                                                value="{{ $kunjungan->unit->nama_unit }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>No RM</label>
                                            <input type="text" class="form-control" name="no_rm"
                                                value="{{ $kunjungan->no_rm }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Nama Pasien</label>
                                            <input type="text" class="form-control" name="nama_pasien"
                                                value="{{ $kunjungan->pasien->nama_px }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Jenis Kelamin</label>
                                            <input type="text" class="form-control" name="jk_pasien"
                                                value="{{ $kunjungan->pasien->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Tanggal</label>
                                            <input type="date" class="form-control" name="tanggal_cppt"
                                                value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Waktu</label>
                                            <input type="time" class="form-control" name="waktu_cppt"
                                                value="{{ Carbon\Carbon::now()->format('H:i') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Catatan Perkembangan Pasien -->
                            <div class="col-lg-12">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Catatan Perkembangan Pasien</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        @foreach (['subjek', 'objek', 'assesmen', 'planning', 'instruksi_medis'] as $field)
                                            <div class="form-group">
                                                <label for="{{ $field }}">{{ ucfirst($field) }}</label>
                                                <textarea name="{{ $field }}" id="{{ $field }}" class="form-control" cols="30" rows="3"
                                                    placeholder="masukan {{ $field }}..." required></textarea>
                                            </div>
                                        @endforeach
                                        <div class="row float-right">
                                            <button type="submit" class="btn btn-md btn-success">
                                                <i class="fas fa-save"></i> Simpan Data
                                            </button>
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
                                    <h3 class="card-title">Data Perkembangan Pasien</h3>
                                </div>
                                <div class="col-6 text-right">
                                    <button class="btn btn-primary btn-sm text-right">Lihat Semua Cetakan</button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body table-responsive p-0" style="height: 400px;">
                            <div class="col-sm-12 mt-3">
                                <table id="table-cppt" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Tanggal/Waktu</th>
                                            <th>SOAP</th>
                                            <th>Instruksi Medis</th>
                                            <th>Profesi</th>
                                            <th>Verify</th>
                                            <th style="width:11%;">Aksi</th>
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
            <div class="tab-pane" id="cetak-cppt">

            </div>
        </div>
    </div>
</div>
@include('simrs.erm-ranap.dokter.cppt_konsultasi.component_konsultasi.card_konsultasi')

<div class="modal fade" id="modal-editCPPT" style="display: none;" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Catatan Perkembangan Pasien</h4>
            </div>
            <div class="modal-body" style="font-size: 12px;">
                <form id="editCPPTForm">
                    @csrf
                    <input type="hidden" name="id" id="edit-cppt-id">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Ruangan</label>
                                            <input type="text" class="form-control" name="ruangan"
                                                id="edit-ruangan-cppt" value="{{ $kunjungan->unit->nama_unit }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Nama Pasien</label>
                                            <input type="text" class="form-control" name="nama_pasien"
                                                id="edit-pasien-cppt" value="{{ $kunjungan->pasien->nama_px }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>No RM</label>
                                            <input type="text" class="form-control" name="no_rm"
                                                id="edit-rm-cppt" value="{{ $kunjungan->no_rm }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Jenis Kelamin</label>
                                            <input type="text" class="form-control" name="jk_pasien"
                                                id="edit-jk-cppt"
                                                value="{{ $kunjungan->pasien->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Tanggal</label>
                                            <input type="date" class="form-control" name="tanggal_cppt"
                                                id="edit-tanggal-cppt"
                                                value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Waktu</label>
                                            <input type="time" class="form-control" name="waktu_cppt"
                                                id="edit-waktu-cppt"
                                                value="{{ Carbon\Carbon::now()->format('H:i') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="Subjek">Subjek</label>
                                    <textarea name="subjek" id="edit-subjek-cppt" style="font-size: 13px;" class="form-control" cols="30"
                                        rows="5" placeholder="masukan subjek..." required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="Objeck">Objeck</label>
                                    <textarea name="objek" id="edit-objek-cppt" style="font-size: 13px;" class="form-control" cols="30"
                                        rows="5" placeholder="masukan objek..." required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="Assesmen">Assesmen</label>
                                    <textarea name="assesmen" id="edit-asesmen-cppt" style="font-size: 13px;" class="form-control" cols="30"
                                        rows="5" placeholder="masukan asesmen..." required></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="Planning">Planning</label>
                                    <textarea name="planning" id="edit-planning-cppt" style="font-size: 13px;" class="form-control" cols="30"
                                        rows="5" placeholder="masukan planning..." required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="Instruksi Medis">Instruksi Medis</label>
                                    <textarea name="instruksi_medis" id="edit-instruksi-cppt" style="font-size: 13px;" class="form-control"
                                        cols="30" rows="5" placeholder="masukan instruksi medis..." required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer text-right">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-sm btn-primary" id="updateCPPT">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/fixedheader/3.1.7/js/dataTables.fixedHeader.min.js"></script>
<script>
    $(document).ready(function() {
        // Submit form CPPT dengan konfirmasi menggunakan SweetAlert
        $('#formCPPTKonsultasi').on('submit', function(e) {
            e.preventDefault(); // Mencegah pengiriman form secara default

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan disimpan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika user konfirmasi, maka simpan data
                    handleFormSubmit($(this)); // Panggil fungsi simpan data
                }
            });
        });

        // Fungsi untuk submit form dengan AJAX
        function handleFormSubmit(form) {
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function() {
                    showSuccessMessage('Data berhasil disimpan!');
                    loadTableData(); // Reload tabel data
                    resetForm('#formCPPTKonsultasi');
                },
                error: function(xhr) {
                    showErrorMessage(xhr.responseJSON.errors);
                }
            });
        }

        function loadTableData() {
            const kodeKunjungan = $('#kode_kunjungan').val();

            if (!kodeKunjungan) {
                console.error('Kode kunjungan tidak ditemukan.');
                return; // Jangan lanjut jika kode_kunjungan tidak ada
            }

            $.ajax({
                url: "{{ route('dashboard.erm-ranap.perkembangan-pasien.get-perkembangan') }}",
                type: 'GET',
                data: {
                    kode: kodeKunjungan
                },
                success: function(data) {
                    console.log('Data yang diterima: ', data);
                    // Cek apakah data adalah array yang valid
                    if (Array.isArray(data) && data.length > 0) {
                        populateTable(data);
                    } else {
                        console.warn('Data kosong atau tidak valid.');
                        populateTable([]);
                    }
                },
                error: function(xhr) {
                    console.error('Error loading data:', xhr);
                    // Tampilkan error ke user jika diperlukan
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan',
                        text: 'Gagal memuat data dari server.'
                    });
                }
            });
        }

        // Fungsi untuk menampilkan data dalam tabel
        function populateTable(data) {
            const rows = data.length > 0 ?
                data.map(perkembanganPasien => `
                <tr>
                    <td>${perkembanganPasien.tanggal} / ${perkembanganPasien.waktu}</td>
                    <td>
                        <table>
                            <tr style="background-color: #f5f1d3;">
                                <td><strong>S:</strong></td>
                                <td>${perkembanganPasien.subjek ?? '-'}</td>
                            </tr>
                            <tr style="background-color: #e4f5d3;">
                                <td><strong>O:</strong></td>
                                <td>${perkembanganPasien.objek ?? '-'}</td>
                            </tr>
                            <tr style="background-color: #d3f5f1;">
                                <td><strong>A:</strong></td>
                                <td>${perkembanganPasien.asesmen ?? '-'}</td>
                            </tr>
                            <tr style="background-color: #d3d4f5;">
                                <td><strong>P:</strong></td>
                                <td>${perkembanganPasien.planning ?? '-'}</td>
                            </tr>
                        </table>
                    </td>
                    <td>${perkembanganPasien.instruksi_medis}</td>
                    <td>${perkembanganPasien.profesi}</td>
                    <td>${perkembanganPasien.verify === 0 ? 'Belum Verifikasi' : 'Verifikasi'}</td>
                    <td>
                        <button class="btn btn-xs btn-warning btn-block edit-cppt" data-id="${perkembanganPasien.id}">Edit</button>
                        <button class="btn btn-xs btn-danger btn-block delete-cppt" data-id="${perkembanganPasien.id}">Hapus</button>
                    </td>
                </tr>`).join('') :
                `<tr><td colspan="7" class="text-center">Tidak ada data yang tersedia</td></tr>`;

            console.log('Rows HTML: ', rows); // Debug untuk memastikan rows terbentuk dengan benar
            $('#table-cppt tbody').html(rows); // Masukkan ke tabel
        }

        // Panggil fungsi loadTableData ketika halaman dimuat atau saat diperlukan
        loadTableData();

        // Fungsi untuk reset form
        function resetForm(formSelector) {
            $(formSelector)[0].reset();
        }

        // Fungsi untuk menampilkan pesan sukses menggunakan SweetAlert
        function showSuccessMessage(message) {
            Swal.fire({
                icon: 'success',
                title: message,
                showConfirmButton: false,
                timer: 1500
            });
        }

        // Fungsi untuk menampilkan pesan error menggunakan SweetAlert
        function showErrorMessage(errors) {
            const errorMessage = Object.values(errors).map(error => error.join(', ')).join('\n');
            Swal.fire({
                icon: 'error',
                title: 'Terjadi kesalahan',
                text: errorMessage
            });
        }

        // Konfirmasi sebelum hapus CPPT
        $('#table-cppt').on('click', '.delete-cppt', function() {
            const cpptId = $(this).data('id');
            const deleteUrl =
                `{{ route('dashboard.erm-ranap.perkembangan-pasien.delete-perkembangan', '') }}/${cpptId}`;

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteData(deleteUrl);
                }
            });
        });

        // Fungsi untuk hapus data CPPT dengan AJAX
        function deleteData(url) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    showSuccessMessage('Data telah dihapus.');
                    loadTableData(); // Reload tabel data setelah penghapusan
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan',
                        text: 'Data gagal dihapus.'
                    });
                }
            });
        }
    });
</script>
<script>
    $(document).ready(function() {
        // Event listener untuk tombol "Edit"
        $('.edit-cppt').click(function() {
            const id = $(this).data('id');
            const tanggal = $(this).data('tanggal');
            const waktu = $(this).data('waktu');
            const subjek = $(this).data('subjek');
            const objek = $(this).data('objek');
            const asesmen = $(this).data('asesmen');
            const planning = $(this).data('planning');
            const instruksi = $(this).data('instruksi-medis');

            // Mengisi form edit modal dengan data obat yang dipilih
            $('#edit-cppt-id').val(id);
            $('#edit-tanggal-cppt').val(tanggal);
            $('#edit-waktu-cppt').val(waktu);
            $('#edit-subjek-cppt').val(subjek);
            $('#edit-objek-cppt').val(objek);
            $('#edit-asesmen-cppt').val(asesmen);
            $('#edit-planning-cppt').val(planning);
            $('#edit-instruksi-cppt').val(instruksi);
        });

        // Save changes button functionality
        $('#updateCPPT').click(function() {
            const id = $('#edit-cppt-id').val();
            const tanggal = $('#edit-tanggal-cppt').val();
            const waktu = $('#edit-waktu-cppt').val();
            const subjek = $('#edit-subjek-cppt').val();
            const objek = $('#edit-objek-cppt').val();
            const asesmen = $('#edit-asesmen-cppt').val();
            const planning = $('#edit-planning-cppt').val();
            const instruksi = $('#edit-instruksi-cppt').val();
            const url =
                "{{ route('dashboard.erm-ranap.perkembangan-pasien.update-perkembangan', '') }}/" + id;
            $.ajax({
                url: url,
                method: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    tanggal: tanggal,
                    waktu: waktu,
                    subjek: subjek,
                    objek: objek,
                    asesmen: asesmen,
                    planning: planning,
                    instruksi: instruksi,
                },
                success: function(response) {
                    $('#modal-editCPPT').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Error updating data: ' + xhr.responseJSON.message ||
                        'Please try again.');
                }
            });
        });
    });
    $(document).on('click', '.delete-obat', function() {
        const obatId = $(this).data('id');
        const url = "{{ route('dashboard.erm-ranap.rekonsiliasi-obat.delete-obat', '') }}/" + obatId;
        if (confirm('Apakah Anda yakin ingin menghapus obat ini?')) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        location.reload(); // Atau hapus baris secara langsung
                    }
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan saat menghapus obat.');
                }
            });
        }
    });
</script>
