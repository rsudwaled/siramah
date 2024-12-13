<div class="card card-outline card-primary rekonsiliasi-obat" style="font-size: 12px;">
    <div class="card-header">
        <h3 class="card-title">REKONSILIASI OBAT</h3>
        <div class="card-tools">
            <button type="button" id="addRowObat" class="btn btn-primary btn-xs">Tambah Baris</button>
            <button class="btn btn-xs btn-danger text-right tutup-tab-rekonsiliasi-obat" ><i class="far fa-window-close"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="col-12 mb-2">
            <form method="POST" action="{{ route('dashboard.erm-ranap.rekonsiliasi-obat.store-obat') }}">
                @csrf
                <input type="hidden" name="kode" value="{{ $kunjungan->kode_kunjungan ?? '0' }}">
                <div id="dynamicFormRekonsiliasiObat">
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label>Nama Obat</label>
                                <input type="text" class="form-control" name="nama_obat[]" required>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label>Dosis</label>
                                <input type="text" class="form-control" name="dosis[]" required>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label>Aturan Pakai</label>
                                <input type="text" class="form-control" name="aturan_pakai[]" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="row">
                                <div class="col-5">
                                    <div class="form-group">
                                        <label>Terapi Lanjutan</label>
                                        <select name="terapi_lanjutan[]" id="terapi_lanjutan" class="form-control">
                                            <option value="1">Ya</option>
                                            <option value="0">Tidak</option>
                                        </select>
                                    </div>    
                                </div>
                                <div class="col-7 row">
                                    <div class="col-9">
                                        <div class="form-group">
                                            <label>Jumlah</label>
                                            <input type="text" class="form-control " name="jumlah[]" required>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                         <label>&nbsp;</label>
                                        <button type="button" class="btn btn-outline-primary btn-sm">Default</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success btn-xs">Simpan</button>
            </form>
        </div>
        <div class="col-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Obat</th>
                        <th>Dosis</th>
                        <th>Aturan Pakai</th>
                        <th>Jumlah</th>
                        <th>Terapi Lanjutan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                @if (!empty($rekonsiliasi))
                    <tbody>
                        @foreach ($rekonsiliasi->detailRekonsiliasiObat as $obat)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $obat->nama_obat ?? '-' }}</td>
                                <td>{{ $obat->dosis ?? '-' }}</td>
                                <td>{{ $obat->aturan_pakai ?? '-' }}</td>
                                <td>{{ $obat->jumlah ?? '-' }}</td>
                                <td>{{ $obat->terapi_lanjutan == 0 ? 'TIDAK' : 'IYA' }}</td>
                                <td>
                                    <button class="btn btn-primary btn-xs edit-obat" data-toggle="modal"
                                        data-target="#modal-editObat" data-id="{{ $obat->id }}"
                                        data-nama="{{ $obat->nama_obat }}" data-dosis="{{ $obat->dosis }}"
                                        data-aturan="{{ $obat->aturan_pakai }}" data-jumlah="{{ $obat->jumlah }}"
                                        data-lanjutan="{{ $obat->terapi_lanjutan }}">
                                        Edit
                                    </button>
                                    <button class="btn btn-danger btn-xs delete-obat"
                                        data-id="{{ $obat->id }}">Hapus</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-editObat" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Obat</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editObatForm">
                    @csrf
                    <input type="hidden" name="id" id="edit-obat-id">
                    <div class="form-group">
                        <label>Nama Obat</label>
                        <input type="text" class="form-control" name="nama_obat" id="edit-nama-obat" required>
                    </div>
                    <div class="form-group">
                        <label>Dosis</label>
                        <input type="text" class="form-control" name="dosis" id="edit-dosis" required>
                    </div>
                    <div class="form-group">
                        <label>Aturan Pakai</label>
                        <input type="text" class="form-control" name="aturan_pakai" id="edit-aturan-pakai" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="text" class="form-control" name="jumlah" id="edit-jumlah" required>
                    </div>
                    <div class="form-group">
                        <label>Terapi Lanjutan</label>
                        <select name="terapi_lanjutan" id="edit-terapi-lanjutan" class="form-control">
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveChanges">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Event listener untuk tombol "Add Row"
        $('#addRowObat').click(function() {
            var newRow = `
            <div class="row kolom-obat">
                <div class="col-3">
                    <div class="form-group">
                        <label>Nama Obat</label>
                        <input type="text" class="form-control" name="nama_obat[]" required>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label>Dosis</label>
                        <input type="text" class="form-control" name="dosis[]" required>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label>Aturan Pakai</label>
                        <input type="text" class="form-control" name="aturan_pakai[]" required>
                    </div>
                </div>
               <div class="col-4">
                    <div class="row">
                        <div class="col-5">
                            <div class="form-group">
                                <label>Terapi Lanjutan</label>
                                <select name="terapi_lanjutan[]" id="terapi_lanjutan" class="form-control">
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                            </div>    
                        </div>
                        <div class="col-7 row">
                            <div class="col-9">
                                <div class="form-group">
                                    <label>Jumlah</label>
                                    <input type="text" class="form-control " name="jumlah[]" required>
                                </div>
                            </div>
                            <div class="col-3">
                                 <label>&nbsp;</label>
                                <button type="button" class="btn btn-danger btn-sm removeRow ">Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
            $('#dynamicFormRekonsiliasiObat').append(newRow);
        });

        // Event listener untuk tombol "Delete Row"
        $('#dynamicFormRekonsiliasiObat').on('click', '.removeRow', function() {
            $(this).closest('.kolom-obat').remove();
        });

        // Event listener untuk tombol "Edit"
        $('.edit-obat').click(function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            const dosis = $(this).data('dosis');
            const aturan = $(this).data('aturan');
            const jumlah = $(this).data('jumlah');
            const lanjutan = $(this).data('lanjutan');

            // Mengisi form edit modal dengan data obat yang dipilih
            $('#edit-obat-id').val(id);
            $('#edit-nama-obat').val(nama);
            $('#edit-dosis').val(dosis);
            $('#edit-aturan-pakai').val(aturan);
            $('#edit-jumlah').val(jumlah);
            $('#edit-terapi-lanjutan').val(lanjutan);
        });

        // Save changes button functionality
        $('#saveChanges').click(function() {
            const id = $('#edit-obat-id').val();
            const nama = $('#edit-nama-obat').val();
            const dosis = $('#edit-dosis').val();
            const aturan = $('#edit-aturan-pakai').val();
            const jumlah = $('#edit-jumlah').val();
            const lanjutan = $('#edit-terapi-lanjutan').val();
            const url = "{{ route('dashboard.erm-ranap.rekonsiliasi-obat.update-obat', '') }}/" + id;
            $.ajax({
                url: url,
                method: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    nama_obat: nama,
                    dosis: dosis,
                    aturan_pakai: aturan,
                    jumlah: jumlah,
                    lanjutan: lanjutan,
                },
                success: function(response) {
                    $('#modal-editObat').modal('hide');
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
