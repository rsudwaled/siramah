{{-- <div class="card card-outline card-primary card-rencana-asuhan" style="font-size: 12px;"> --}}
<div class="card card-outline card-primary" style="font-size: 12px;">
    <div class="card-header">
        <h3 class="card-title">RENCANA ASUHAN TERPADU</h3>
        <div class="card-tools">
            <button type="button" id="addRowRencanaAsuhan" class="btn btn-primary btn-xs">Tambah Baris</button>
            <button class="btn btn-xs btn-danger text-right tutup-tab-rencana-asuhan" ><i class="far fa-window-close"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="col-12 mb-2">
            <form method="POST" action="{{ route('dashboard.erm-ranap.rencana-asuhan.store-rencana-asuhan') }}">
                @csrf
                <input type="hidden" name="kode" value="{{ $kunjungan->kode_kunjungan ?? '0' }}">
                <div id="dynamicFormRencanaAsuhan">
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" class="form-control" name="tanggal[]"
                                    value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label>Waktu</label>
                                <input type="time" class="form-control" name="waktu_asuhan[]"
                                    value="{{ Carbon\Carbon::now()->format('H:i') }}">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label>Rencana Asuhan</label>
                                <input type="text" class="form-control" name="rencana_asuhan[]">
                            </div>
                        </div>
                        <div class="col-5 row">
                            <div class="col-10">
                                <div class="form-group">
                                    <label>Capaian Yang Diharapkan</label>
                                    <input type="text" class="form-control" name="capaian_yang_diharapkan[]">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label>&nbsp;&nbsp;</label>
                                    <span class="btn btn-outline-primary btn-md" readonly>Default</span>
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
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Profesi</th>
                        <th>Rencana Asuhan</th>
                        <th>Capaian diharapkan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rencana as $asuhan)
                        <tr>
                            <td>{{ $asuhan->tanggal }}</td>
                            <td>{{ $asuhan->waktu_asuhan }}</td>
                            <td>{{ $asuhan->profesi }}</td>
                            <td>{{ $asuhan->rencana_asuhan }}</td>
                            <td>{{ $asuhan->capaian_diharapkan }}</td>
                            <td>
                                <button class="btn btn-primary btn-xs edit-rencana-asuhan" data-toggle="modal"
                                    data-target="#modal-editRencanaAsuhan" data-id="{{ $asuhan->id }}"
                                    data-waktu="{{ $asuhan->waktu_asuhan }}" data-profesi="{{ $asuhan->profesi }}"
                                    data-tanggal="{{ $asuhan->tanggal }}"
                                    data-rencana_asuhan="{{ $asuhan->rencana_asuhan }}"
                                    data-capaian_diharapkan="{{ $asuhan->capaian_diharapkan }}">
                                    Edit
                                </button>
                                <button class="btn btn-danger btn-xs delete-rencana"
                                    data-id="{{ $asuhan->id }}">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-editRencanaAsuhan" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Rencana Asuhan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editRencanaAsuhanForm">
                    @csrf
                    <input type="hidden" name="id" id="edit-rencana-id">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" id="edit-tanggal-rencana"
                                readonly>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Waktu</label>
                            <input type="time" class="form-control" name="waktu_asuhan" id="edit-waktu-rencana">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Profesi</label>
                            <input type="text" class="form-control" name="profesi" id="edit-profesi-rencana"
                                readonly>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Rencana Asuhan</label>
                            <input type="text" class="form-control" name="rencana_asuhan" id="edit-rencana-asuhan">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Capaian Yang Diharapkan</label>
                            <input type="text" class="form-control" name="capaian_yang_diharapkan"
                                id="edit-capaian-rencana">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updateRencana">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Event listener untuk tombol "Add Row"
        $('#addRowRencanaAsuhan').click(function() {
            // Baris baru yang akan ditambahkan
            var newRow = `
                <div class="row kolom-rencana-asuhan">
                    <div class="col-2">
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" class="form-control" name="tanggal[]" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label>Waktu</label>
                            <input type="time" class="form-control" name="waktu_asuhan[]" value="{{ Carbon\Carbon::now()->format('H:i') }}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label>Rencana Asuhan</label>
                            <input type="text" class="form-control" name="rencana_asuhan[]">
                        </div>
                    </div>
                    <div class="col-5 row">
                        <div class="col-10">
                            <div class="form-group">
                                <label>Capaian Yang Diharapkan</label>
                                <input type="text" class="form-control" name="capaian_yang_diharapkan[]">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label>&nbsp;&nbsp;</label>
                                <button type="button" class="btn btn-danger btn-md removeRow">Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            // Menambahkan baris baru ke dalam form
            $('#dynamicFormRencanaAsuhan').append(newRow);
        });

        // Event listener untuk tombol "Delete Row"
        $('#dynamicFormRencanaAsuhan').on('click', '.removeRow', function() {
            $(this).closest('.kolom-rencana-asuhan').remove();
        });

        // Event listener untuk tombol "Edit"
        $('.edit-rencana-asuhan').click(function() {
            const id = $(this).data('id');
            const waktu = $(this).data('waktu');
            const tanggal = $(this).data('tanggal');
            const profesi = $(this).data('profesi');
            const rencana_asuhan = $(this).data('rencana_asuhan');
            const capaian_diharapkan = $(this).data('capaian_diharapkan');
            // Mengisi form edit modal dengan data obat yang dipilih
            $('#edit-rencana-id').val(id);
            $('#edit-tanggal-rencana').val(tanggal);
            $('#edit-waktu-rencana').val(waktu);
            $('#edit-profesi-rencana').val(profesi);
            $('#edit-rencana-asuhan').val(rencana_asuhan);
            $('#edit-capaian-rencana').val(capaian_diharapkan);
        });

        // Save changes button functionality
        $('#updateRencana').click(function() {
            const id = $('#edit-rencana-id').val();
            const tanggal = $('#edit-tanggal-rencana').val();
            const waktu = $('#edit-waktu-rencana').val();
            const profesi = $('#edit-profesi-rencana').val();
            const rencana = $('#edit-rencana-asuhan').val();
            const capaian = $('#edit-capaian-rencana').val();
            const url = "{{ route('dashboard.erm-ranap.rencana-asuhan.update-rencana', '') }}/" + id;
            $.ajax({
                url: url,
                method: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    tanggal: tanggal,
                    waktu: waktu,
                    profesi: profesi,
                    rencana: rencana,
                    capaian: capaian,
                },
                success: function(response) {
                    $('#modal-editRencanaAsuhan').modal('hide');
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
    
    $(document).on('click', '.delete-rencana', function() {
        const obatId = $(this).data('id');
        const url = "{{ route('dashboard.erm-ranap.rencana-asuhan.delete-rencana', '') }}/" + obatId;
        if (confirm('Apakah Anda yakin ingin menghapus rencana ini?')) {
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
                    alert('Terjadi kesalahan saat menghapus rencana asuhan.');
                }
            });
        }
    });
</script>
