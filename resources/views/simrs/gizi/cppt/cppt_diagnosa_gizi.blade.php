@push('js')
    <x-adminlte-modal id="DiagnosisGizi" title="Diagnosis Gizi" theme="warning"
        icon="fas fa-file-medical" size='lg'>
        <form id="formDiagnosisGizi" name="formDiagnosisGizi" method="POST">
            @csrf
            @php
                $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
            @endphp
            <input type="hidden" class="kode-kunjungan-diagnosis-gizi" name="kode_kunjungan"
                value="{{ $kunjungan->kode_kunjungan }}">
            <input type="hidden" class="counter-diagnosis-gizi" name="counter" value="{{ $kunjungan->counter }}">
            <input type="hidden" class="norm-diagnosis-gizi" name="no_rm" value="{{ $kunjungan->no_rm }}">
            <input type="hidden" class="nama-diagnosis-gizi" name="nama_pasien_diagnosis_gizi" value="{{ $kunjungan->pasien->nama_px }}">
            <x-adminlte-input-date id="tanggal_input_diagnosis_gizi" name="tanggal_input" label="Tanggal & Waktu"
                :config="$config" />
            <x-adminlte-textarea igroup-size="sm" class="diagnosis-gizi" name="diagnosis_gizi"
                label="Diagnosis Gizi"
                placeholder="masukan data diagnosis gizi" rows=7>
                {{-- {{$diagnosis->diagnosis_gizi??'-'}} --}}
            </x-adminlte-textarea>
        </form>
        <x-slot name="footerSlot">
            <button class="btn btn-success mr-auto" onclick="tambahDiagnosisGizi()"><i class="fas fa-save"></i>
                Simpan</button>
            <x-adminlte-button theme="danger" label="Close" icon="fas fa-times" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <script>
       function tambahDiagnosisGizi() {
            $.LoadingOverlay("show");
            $.ajax({
                type: "POST",
                url: "{{ route('simrs.gizi.store.diagnosis') }}",
                data: $("#formDiagnosisGizi").serialize(),
                dataType: "json",
                encode: true,
            }).done(function(data) {
                console.log(data);
                if (data.metadata.code == 200) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Diagnosis Gizi Berhasil di Tambahkan',
                    });
                    $("#formDiagnosisGizi").trigger('reset');
                    // getDiagnosisGizi();
                    $('#DiagnosisGizi').modal('hide');
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Error Simpan Diagnosis Gizi',
                    });
                }
                $.LoadingOverlay("hide");
            });
        }
        function getDiagnosisGizi() {
            var url = "{{ route('simrs.gizi.get-diagnosis') }}?kode={{ $kunjungan->kode_kunjungan }}";
            var table = $('#tableDiagnosisGizi').DataTable();
            $.ajax({
                type: "GET",
                url: url,
            }).done(function(data) {
                table.rows().remove().draw();
                if (data.metadata.code == 200) {
                    $.each(data.response, function(key, value) {
                        var btn =
                            '<button class="btn btn-xs mb-1 btn-warning" onclick="editPerkembangan(this)" data-id="' +
                            value.id +
                            '" data-tglinput="' + value.kode_kunjungan +
                            '" data-perkembangan="' + value.kode_kunjungan +
                            '" data-instruksimedis="' + value.kode_kunjungan +
                            '"><i class="fas fa-edit"></i> Edit</button> <button class="btn btn-success btn-xs mb-1" onclick="verifikasiSoap(this)" data-id="' +
                            value.id +
                            '"><i class="fas fa-check"></i> Verifikasi</button>  <button class="btn btn-xs mb-1 btn-danger" onclick="hapusPerkembangan(this)" data-id="' +
                            value.id +
                            '"><i class="fas fa-trash"></i> Hapus</button>';
                        table.row.add([
                            btn,
                            value.tanggal_input,
                            '<pre>' + value.kode_kunjungan + '</pre>',
                            '<pre>' + value.kode_kunjungan + '</pre>',
                            value.user,
                            value.kode_kunjungan,
                        ]).draw(false);
                    });
                } else {
                    Swal.fire(
                        'Mohon Maaf !',
                        data.metadata.message,
                        'error'
                    );
                }
            });
        }
    </script>
@endpush
