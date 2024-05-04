@push('js')
    <x-adminlte-modal id="Monev" title="Monitoring Evaluasi Gizi" theme="warning"
        icon="fas fa-file-medical" size='lg'>
        <form id="formMonev" name="formMonev" method="POST">
            @csrf
            @php
                $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
            @endphp
            <input type="hidden" class="kode-kunjungan-monev-gizi" name="kode_kunjungan"
            value="{{ $kunjungan->kode_kunjungan }}">
            <input type="hidden" class="counter-monev-gizi" name="counter" value="{{ $kunjungan->counter }}">
            <input type="hidden" class="norm-monev-gizi" name="no_rm" value="{{ $kunjungan->no_rm }}">
            <input type="hidden" class="nama-monev-gizi" name="nama_pasien_monev_gizi" value="{{ $kunjungan->pasien->nama_px }}">
            <x-adminlte-input-date id="tanggal_input_perkembangan" name="tanggal_input" label="Tanggal & Waktu"
                :config="$config" />
            <x-adminlte-textarea igroup-size="sm" class="monitoring-evaluasi" name="monev"
                label="Monitoring Evaluasi Gizi"
                placeholder="masukan monitoring dan evaluasi gizi" rows=7>
            </x-adminlte-textarea>
        </form>
        <x-slot name="footerSlot">
            <button class="btn btn-success mr-auto" onclick="tambahMonevGizi()"><i class="fas fa-save"></i>
                Simpan</button>
            <x-adminlte-button theme="danger" label="Close" icon="fas fa-times" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <script>
       function tambahMonevGizi() {
            $.LoadingOverlay("show");
            $.ajax({
                type: "POST",
                url: "{{ route('simrs.gizi.store.monev') }}",
                data: $("#formMonev").serialize(),
                dataType: "json",
                encode: true,
            }).done(function(data) {
                console.log(data);
                if (data.metadata.code == 200) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Monitoring Evaluasi Gizi Berhasil di Tambahkan',
                    });
                    $("#formMonev").trigger('reset');
                    // getDiagnosisGizi();
                    $('#Monev').modal('hide');
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Error Simpan Monitoring Evaluasi Gizi',
                    });
                }
                $.LoadingOverlay("hide");
            });
        }
    </script>
@endpush
