@push('js')
    <x-adminlte-modal id="Intervensi" title="Intervensi Gizi" theme="warning"
        icon="fas fa-file-medical" size='lg'>
        <form id="formIntervensi" name="formIntervensi" method="POST">
            @csrf
            @php
                $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
            @endphp
            <input type="hidden" class="kode-kunjungan-intervensi-gizi" name="kode_kunjungan"
            value="{{ $kunjungan->kode_kunjungan }}">
            <input type="hidden" class="counter-intervensi-gizi" name="counter" value="{{ $kunjungan->counter }}">
            <input type="hidden" class="norm-intervensi-gizi" name="no_rm" value="{{ $kunjungan->no_rm }}">
            <input type="hidden" class="nama-intervensi-gizi" name="nama_pasien_intervensi_gizi" value="{{ $kunjungan->pasien->nama_px }}">
            <x-adminlte-input-date id="tanggal_input_intervensi" name="tanggal_input" label="Tanggal & Waktu"
                :config="$config" />
            <x-adminlte-textarea igroup-size="sm" class="intervensi" name="intervensi"
                label="Intervensi gizi"
                placeholder="masukan data intervensi gizi" rows=7>
            </x-adminlte-textarea>
        </form>
        <x-slot name="footerSlot">
            <button class="btn btn-success mr-auto" onclick="tambahIntervensiGizi()"><i class="fas fa-save"></i>
                Simpan</button>
            <x-adminlte-button theme="danger" label="Close" icon="fas fa-times" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <script>
       function tambahIntervensiGizi() {
            $.LoadingOverlay("show");
            $.ajax({
                type: "POST",
                url: "{{ route('simrs.gizi.store.intervensi') }}",
                data: $("#formIntervensi").serialize(),
                dataType: "json",
                encode: true,
            }).done(function(data) {
                console.log(data);
                if (data.metadata.code == 200) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Intervensi Gizi Berhasil di Tambahkan',
                    });
                    $("#formIntervensi").trigger('reset');
                    // getDiagnosisGizi();
                    $('#Intervensi').modal('hide');
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Error Simpan Intervensi Gizi',
                    });
                }
                $.LoadingOverlay("hide");
            });
        }
    </script>
@endpush
