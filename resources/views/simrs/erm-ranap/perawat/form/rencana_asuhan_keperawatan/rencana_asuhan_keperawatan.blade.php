<div class="card card-outline card-primary" style="font-size: 12px;">
    <div class="card-header">
        <h3 class="card-title">Diagnosa Keperawatan</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="Diagnosa Keperawatan">Diagnosa Keperawatan</label>
            <textarea name="diagnosa_keperawatan" class="form-control" id="diagnosa_keperawatan" cols="30" rows="5">{{$asesmenkeperawatan?->diagnosa_keperawatan??''}}</textarea>
        </div>
    </div>
</div>
<div class="card card-outline card-primary" style="font-size: 12px;">
    <div class="card-header">
        <h3 class="card-title">RENCANA ASUHAN KEPERAWATAN</h3>

        <div class="card-tools">
            <button type="button" id="addRowRencanaAsuhan" class="btn btn-primary btn-xs">
                Tambah Baris Rencana
            </button>
            <button type="button" class="btn btn-secondary btn-xs" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="col-12 mb-2">
            <div id="dynamicFormRencanaAsuhan">
                @if ($rencanaAsuhan && count($rencanaAsuhan) > 0)
                    @foreach ($rencanaAsuhan as $rencana)
                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="hidden" name="id_asuhan_keperawatan[]" value="{{ $rencana['id'] }}">
                                    <input type="date" class="form-control" name="tanggal_asuhan_keperawatan[]"
                                        value="{{ $rencana['tanggal_rencana'] }}">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label>Waktu</label>
                                    <input type="time" class="form-control" name="waktu_asuhan_keperawatan[]"
                                        value="{{ $rencana['waktu_rencana'] }}">
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="form-group">
                                    <label>Rencana Asuhan</label>
                                    <input type="text" class="form-control" name="rencana_asuhan_keperawatan[]"
                                        value="{{ $rencana['keterangan'] }}">
                                </div>
                            </div>
                            <div class="col-1">
                                <label>&nbsp;</label>
                                <button type="button" class="btn btn-danger btn-md  removeRow">Hapus</button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Jika tidak ada data rencanaAsuhan, tampilkan form kosong -->
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="hidden" name="id_asuhan_keperawatan[]" value="">
                                <input type="date" class="form-control" name="tanggal_asuhan_keperawatan[]"
                                    value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label>Waktu</label>
                                <input type="time" class="form-control" name="waktu_asuhan_keperawatan[]"
                                    value="{{ Carbon\Carbon::now()->format('H:i') }}">
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="form-group">
                                <label>Rencana Asuhan</label>
                                <input type="text" class="form-control" name="rencana_asuhan_keperawatan[]"
                                    value="">
                            </div>
                        </div>
                    </div>
                @endif
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
            <div class="row ">
                <div class="col-2">
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" class="form-control" name="tanggal_asuhan_keperawatan[]" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label>Waktu</label>
                        <input type="time" class="form-control" name="waktu_asuhan_keperawatan[]" value="{{ Carbon\Carbon::now()->format('H:i') }}">
                    </div>
                </div>
                <div class="col-7">
                    <div class="form-group">
                        <label>Rencana Asuhan</label>
                        <input type="text" class="form-control" name="rencana_asuhan_keperawatan[]">
                    </div>
                </div>
                <div class="col-1">
                    <div class="form-group">
                        <label>&nbsp;</label>
                    <button type="button" class="btn btn-danger btn-md removeRow">Hapus</button>
                    </div>
                </div>
            </div>
        `;

            // Menambahkan baris baru ke dalam form
            $('#dynamicFormRencanaAsuhan').append(newRow);
        });

        // Event listener untuk tombol "Delete Row"
        $('#dynamicFormRencanaAsuhan').on('click', '.removeRow', function() {
            $(this).closest('.row').remove();
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
