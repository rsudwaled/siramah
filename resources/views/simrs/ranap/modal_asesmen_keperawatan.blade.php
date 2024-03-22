    <x-adminlte-modal id="modalAsesmenKeperawatan" name="modalAsesmenKeperawatan" title="Asesmen Keperawatan Rawat Inap" theme="success"
        icon="fas fa-file-medical" size="xl">
    </x-adminlte-modal>
    @push('js')
        <script>
            function modalAsesmenKeperawatan() {
                $.LoadingOverlay("show");
                $('#modalAsesmenKeperawatan').modal('show');
                $.LoadingOverlay("hide");
            }
        </script>
    @endpush
