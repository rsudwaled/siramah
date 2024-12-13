<script>
    $(document).ready(function() {
        // Event listener untuk tombol "Add Row"
        $('#addRowRencanaAsuhan').click(function() {
            // Baris baru yang akan ditambahkan
            var newRow = `
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" class="form-control" name="tanggal[]">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label>Rencana Asuhan</label>
                        <input type="text" class="form-control" name="rencana_asuhan[]">
                    </div>
                </div>
                <div class="col-5">
                    <div class="form-group">
                        <label>Capaian Yang Diharapkan</label>
                        <input type="text" class="form-control" name="capaian_yang_diharapkan[]">
                    </div>
                </div>
            </div>
        `;

            // Menambahkan baris baru ke dalam form
            $('#dynamicFormRencanaAsuhan').append(newRow);
        });
    });
</script>
