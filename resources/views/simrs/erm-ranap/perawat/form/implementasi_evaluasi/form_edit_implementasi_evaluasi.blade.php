<form id="verifikasi-form" action="" method="get">
    <input type="hidden" name="kode" value="{{ $kunjungan->kode_kunjungan }}">
    <div class="col-lg-12 row">
        <div class="col-lg-4">
            <div class="form-group">
                <label for="Tanggal Verifikasi">Tanggal Verifikasi</label>
                <input type="date" name="tgl_verifikasi" id="tgl_verifikasi"
                    value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" class="form-control">
            </div>
        </div>
        <div class="col-lg-4">
            <label for="">&nbsp;&nbsp;&nbsp;</label>
            <button class="btn btn-md btn-primary mt-4 btn-lihat-data-evaluasi">Lihat Data</button>
            {{-- <button
                onclick="javascript: form.action='{{ route('dashboard.erm-ranap.perawat.implementasi-evaluasi.verifikasi-implementasi-evaluasi') }}';"
                class="btn btn-md btn-success mt-4">Verifikasi Data</button> --}}
        </div>
    </div>
</form>
<div class="col-lg-12">
    <table class="table table-bordered">
        <thead>
            <th>Tanggal</th>
            <th>Keterangan Implementasi</th>
            <th>User</th>
            <th>Status</th>
            <th>Aksi</th>
        </thead>
        <tbody id="implementasi-table-body">
            <!-- Data hasil verifikasi akan dimasukkan di sini -->
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.4/dist/sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function() {
        // URL untuk request
        const urlShowData =
            "{{ route('dashboard.erm-ranap.perawat.implementasi-evaluasi.showdata-implementasi-evaluasi') }}";
        const urlVerifikasiData =
            "{{ route('dashboard.erm-ranap.perawat.implementasi-evaluasi.verifikasi-implementasi-evaluasi') }}";
        const urlUpdate =
            "{{ route('dashboard.erm-ranap.perawat.implementasi-evaluasi.update-implementasi-evaluasi', '') }}";

        // Event click untuk tombol "Lihat Data"
        $('.btn-lihat-data-evaluasi').on('click', handleViewDataClick);

        // Event submit untuk form di dalam modal edit
        $(document).on('submit', '.edit-form', handleEditFormSubmit);

        // Event click untuk tombol Verifikasi
        $(document).on('click', '.btn-verifikasi', handleVerifikasiDataClick);

        // Event close modal
        $(document).on('click', '.btn-close-update-table', function() {
            const kode = $('input[name="kode"]').val();
            const tgl_verifikasi = $('#tgl_verifikasi').val();
            fetchDataImplementasi(kode, tgl_verifikasi);
        });

        function handleViewDataClick(e) {
            e.preventDefault(); // Mencegah form submit default

            const kode = $('input[name="kode"]').val();
            const tgl_verifikasi = $('#tgl_verifikasi').val();

            fetchDataImplementasi(kode, tgl_verifikasi);
        }

        function fetchDataImplementasi(kode, tgl_verifikasi) {
            $.ajax({
                url: urlShowData,
                method: 'GET',
                data: {
                    kode,
                    tgl_verifikasi
                },
                success: handleShowDataResponse,
                error: handleError
            });
        }

        function handleShowDataResponse(response) {
            $('#implementasi-table-body').empty(); // Kosongkan tabel

            if (response.data_found) {
                response.data.forEach(addRowToTable);
                showAlert('success', 'Data Ditemukan', 'Data Implementasi dan Evaluasi berhasil ditemukan.');
            } else {
                showAlert('error', 'Data Tidak Ditemukan',
                    'Tidak ada data Implementasi dan Evaluasi untuk tanggal tersebut.');
            }
        }

        function addRowToTable(item) {
            const tanggal = new Date(item.tanggal_implementasi_evaluasi)
                .toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                });
            const keteranganVerifikasi = item.verifikasi === 0 ? 'Belum Verifikasi' : 'Sudah Verifikasi';

            const row = `
                <tr data-id="${item.id}">
                    <td>${tanggal} ${item.waktu_implementasi_evaluasi} WIB</td>
                    <td>${item.keterangan_implementasi}</td>
                    <td>${item.user_perawat}</td>
                    <td>${keteranganVerifikasi}</td>
                    <td>
                        <button class="btn btn-xs btn-warning" data-toggle="modal" data-target="#editModal-${item.id}">
                            Edit
                        </button>
                        <button class="btn btn-xs btn-success btn-verifikasi" data-id="${item.id}">
                            Verifikasi
                        </button>
                        ${generateEditModal(item)}
                    </td>
                </tr>
            `;

            $('#implementasi-table-body').append(row);
        }

        function generateEditModal(item) {
            return `
                <div class="modal fade" id="editModal-${item.id}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel-${item.id}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel-${item.id}">Edit Implementasi</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form class="edit-form" data-id="${item.id}">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="tanggal">Tanggal</label>
                                        <input type="date" name="tanggal_implementasi_evaluasi" class="form-control" value="${item.tanggal_implementasi_evaluasi}" readonly required>
                                    </div>
                                    <div class="form-group">
                                        <label for="waktu">Waktu</label>
                                        <input type="time" name="waktu_implementasi_evaluasi" class="form-control" value="${item.waktu_implementasi_evaluasi}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="keterangan">Keterangan Implementasi</label>
                                        <textarea name="keterangan_implementasi" class="form-control" required>${item.keterangan_implementasi}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-close-update-table" data-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            `;
        }

        function handleEditFormSubmit(e) {
            e.preventDefault(); // Mencegah submit default

            const form = $(this);
            const id = form.data('id'); // Ambil ID dari data-id di form
            const url = `${urlUpdate}/${id}`;

            $.ajax({
                url: url,
                method: 'POST',
                data: form.serialize(), // Mengambil data dari form
                success: handleUpdateResponse,
                error: handleError
            });
        }

        function handleVerifikasiDataClick(e) {
            e.preventDefault();
            const id = $(this).data('id'); // Ambil ID dari button yang diklik

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak dapat mengembalikan aksi ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Verifikasi!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: urlVerifikasiData,
                        method: 'POST',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                showAlert('success', 'Berhasil!',
                                    'Data berhasil diverifikasi.');
                                updateTableRowVerifikasi(id);
                            } else {
                                showAlert('error', 'Gagal!', response.message ||
                                    'Terjadi kesalahan saat memverifikasi data.');
                            }
                        },
                        error: handleError
                    });
                }
            });
        }

        // Fungsi untuk meng-update baris di tabel
        function updateTableRowVerifikasi(id) {
            const row = $(`#implementasi-table-body tr[data-id="${id}"]`); // Cari baris berdasarkan id
            if (row.length) {
                // Update status verifikasi di kolom yang sesuai (misalnya kolom ke-3)
                row.find('td:eq(3)').text('Sudah Verifikasi');
                // Jika Anda ingin juga mengganti tampilan tombol, misalnya menghapus tombol verifikasi
                row.find('.btn-verifikasi').remove(); // Menghapus tombol verifikasi setelah sukses
            }
        }


        function handleUpdateResponse(response) {
            if (response.success) {
                showAlert('success', 'Sukses!', 'Data berhasil diperbarui.');

                // Mengupdate baris yang diedit
                updateTableRow(response.data);
            } else {
                showAlert('error', 'Gagal!', response.message || 'Terjadi kesalahan saat memperbarui data.');
            }
        }

        function updateTableRow(item) {
            const tanggal = new Date(item.tanggal_implementasi_evaluasi)
                .toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                });

            // Mencari baris berdasarkan ID dan memperbarui kontennya
            const row = $(`#implementasi-table-body tr[data-id="${item.id}"]`);
            if (row.length) {
                row.find('td:eq(0)').text(`${tanggal} ${item.waktu_implementasi_evaluasi} WIB`);
                row.find('td:eq(1)').text(item.keterangan_implementasi);
                row.find('td:eq(2)').text(item.user_perawat);
            }
        }

        function handleError() {
            showAlert('error', 'Error', 'Terjadi kesalahan saat mengambil data.');
        }

        function showAlert(icon, title, text) {
            Swal.fire({
                icon,
                title,
                text
            });
        }
    });
</script>
