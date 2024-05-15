    {{-- icare --}}
    <x-adminlte-modal id="modalICare" name="modalICare" title="I-Care JKN" theme="warning" icon="fas fa-file-medical"
        size="xl">
        <iframe src="" id="urlIcare" width="100%" height="700px" frameborder="0"></iframe>
    </x-adminlte-modal>
    @push('js')
        <script>
            function modalIcare() {
                $.LoadingOverlay("show");
                var url =
                    "{{ route('icare') }}?nomorkartu={{ $kunjungan->pasien->no_Bpjs }}&kodedokter={{ $kunjungan->dokter->kode_dokter_jkn }}";
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if (data.metadata.code == 200) {
                            $('#urlIcare').attr('src', data.response.url);
                            $('#modalICare').modal('show');
                        } else {
                            Swal.fire(
                                'Error ' + data.metadata.code,
                                data.metadata.message,
                                'error'
                            );
                        }
                        $.LoadingOverlay("hide");
                    },
                    error: function(data) {
                        console.log(data);
                        alert('Error');
                        $.LoadingOverlay("hide");
                    }
                });
            }
        </script>
    @endpush
