<div class="card" style="font-size: 12px;">
    <div class="card-header p-2">
        <ul class="nav nav-pills" style="font-size: 14px;">
            <li class="nav-item">
                <a class="nav-link active" href="#table-data-cppt" data-toggle="tab">Data Perkembangan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#table-data-cetakan-cppt" data-toggle="tab">Lihat Cetakan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#form-konsultasi" data-toggle="tab">Form Catatan Perkembangan</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane active" id="table-data-cppt">
                <div class="col-12">
                    <table id="table-cppt" class="table table-bordered table-hover dataTable dtr-inline collapsed"
                        aria-describedby="example2_info">
                        <thead>
                            <tr>
                                <th style="width: 11%;">Tanggal</th>
                                <th>SOAP</th>
                                <th>Instruksi Medis</th>
                                <th>Profesi</th>
                                <th>Verify</th>
                                <th style="width: 11%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($perkembangan))
                                @foreach ($perkembangan as $cppt)
                                    <tr>
                                        <td>{{ $cppt->tanggal }} <br>{{ $cppt->waktu }}</td>
                                        <td>
                                            <table>
                                                <tr style="background-color: #f5f1d3;">
                                                    <td><strong>S:</strong></td>
                                                    <td>{{ $cppt->subjek ?? '-' }}</td>
                                                </tr>
                                                <tr style="background-color: #e4f5d3;">
                                                    <td><strong>O:</strong></td>
                                                    <td>{{ $cppt->objek ?? '-' }}</td>
                                                </tr>
                                                <tr style="background-color: #d3f5f1;">
                                                    <td><strong>A:</strong></td>
                                                    <td>{{ $cppt->asesmen ?? '-' }}</td>
                                                </tr>
                                                <tr style="background-color: #d3d4f5;">
                                                    <td><strong>P:</strong></td>
                                                    <td>{{ $cppt->planning ?? '-' }}</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>{{ $cppt->instruksi_medis }}</td>
                                        <td>
                                            <button type="button" class="btn btn-block {{ $cppt->profesi=='perawat' ?'btn-outline-primary': 'btn-outline-secondary' }} btn-xs">{{ $cppt->profesi ?? '-' }}</button>
                                        </td>
                                        <td>

                                            <button
                                                class="btn {{ $cppt->verify == 0 ? 'btn-success' : 'btn-primary' }} btn-xs ">{{ $cppt->verify == 0 ? 'Belum Verifikasi' : 'Sudah Verifikasi' }}</button>
                                        </td>
                                        <td>
                                            <button class="btn btn-warning btn-xs edit-cppt" data-toggle="modal"
                                                data-target="#modal-editCPPT" data-id="{{ $cppt->id }}"
                                                data-tanggal="{{ $cppt->tanggal }}"
                                                data-waktu="{{ $cppt->waktu }}" data-subjek="{{ $cppt->subjek }}"
                                                data-objek="{{ $cppt->objek }}"
                                                data-asesmen="{{ $cppt->asesmen }}"
                                                data-planning="{{ $cppt->planning }}"
                                                data-instruksi-medis="{{ $cppt->instruksi_medis }}">
                                                Edit
                                            </button>
                                            <button class="btn btn-danger btn-xs">Hapus</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="table-data-cetakan-cppt">
                <div class="col-12">
                </div>
            </div>
            <div class="tab-pane" id="form-konsultasi">
                <form action="{{ route('dashboard.erm-ranap.perawat.cppt-perawat.store-perkembangan') }}"
                    name="formCPPTKonsultasi" id="formCPPTKonsultasi" method="POST">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="kode_kunjungan" value="{{ $kunjungan->kode_kunjungan }}">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Ruangan</label>
                                        <input type="text" class="form-control" name="ruangan"
                                            value="{{ $kunjungan->unit->nama_unit }}" readonly>
                                    </div>
                                </div>
                                <div class="col-4">
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
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Jenis Kelamin</label>
                                        <input type="text" class="form-control" name="jk_pasien"
                                            value="{{ $kunjungan->pasien->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Tanggal</label>
                                                    <input type="date" class="form-control"
                                                        name="tanggal_cppt"
                                                        value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Waktu</label>
                                                    <input type="time" class="form-control" name="waktu_cppt"
                                                        value="{{ Carbon\Carbon::now()->format('H:i') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="Subjek">Subjek</label>
                                            <textarea name="subjek" id="subjek" class="form-control" cols="30" rows="3"
                                                placeholder="masukan subjek..." required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="Objeck">Objeck</label>
                                            <textarea name="objek" id="objek" class="form-control" cols="30" rows="3"
                                                placeholder="masukan objek..." required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="Assesmen">Assesmen</label>
                                            <textarea name="assesmen" id="assesmen" class="form-control" cols="30" rows="3"
                                                placeholder="masukan asesmen..." required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="Planning">Planning</label>
                                            <textarea name="planning" id="planning" class="form-control" cols="30" rows="3"
                                                placeholder="masukan planning..." required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="Instruksi Medis">Instruksi Medis</label>
                                            <textarea name="instruksi_medis" id="instruksi_medis" class="form-control" cols="30" rows="3"
                                                placeholder="masukan instruksi medis..." required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row float-right">
                        <button type="submit" class="btn btn-md btn-success" form="formCPPTKonsultasi">
                            <i class="fas fa-save"></i> Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
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
