    <x-adminlte-modal id="modalAsesmenAwal" name="modalAsesmenAwal" title="Groupping E-Klaim" theme="success"
        icon="fas fa-file-medical" size="xl">
    </x-adminlte-modal>
    @push('js')
        <script>
            function modalAsesmenAwal() {
                $.LoadingOverlay("show");
                $('#modalAsesmenAwal').modal('show');
                $.LoadingOverlay("hide");
            }
        </script>
    @endpush
