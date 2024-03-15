    <x-adminlte-modal id="modalFileRM" name="modalFileRM" title="File Upload Rekam Medis" theme="success"
        icon="fas fa-file-medical" size="xl">
        <div class="classFileUpload"></div>
    </x-adminlte-modal>
    <x-adminlte-modal id="midalFileLihat" name="midalFileLihat" title="Lihat File Upload Rekam Medis" theme="success"
        icon="fas fa-file-medical" size="xl">
        <iframe id="dataUrlFile" src="" height="600px" width="100%" title="Iframe Example"></iframe>
        <x-slot name="footerSlot">
            <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    @push('js')
        <script>
            function lihatFileUpload() {
                getFileUpload();
                $('#modalFileRM').modal('show');
            }

            function getFileUpload() {
                $.LoadingOverlay("show");
                var url = "{{ route('get_file_upload') }}?norm={{ $kunjungan->no_rm }}";
                $.ajax({
                    type: "GET",
                    url: url,
                }).done(function(data) {
                    $('.classFileUpload').html(data);
                    $.LoadingOverlay("hide");
                }).fail(function(data) {
                    alert('Error' + data);
                    $.LoadingOverlay("hide");
                });
            }
        </script>
    @endpush
