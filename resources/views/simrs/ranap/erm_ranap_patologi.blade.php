    <x-adminlte-modal id="modalPatologi" name="modalPatologi" title="Hasil Patologi Anatomi Pasien" theme="success"
        icon="fas fa-file-medical" size="xl">
        @php
            $heads = ['Tgl Masuk', 'Kunjungan', 'Pasien', 'Unit', 'Pemeriksaan', 'Action'];
            $config['paging'] = false;
            $config['order'] = ['0', 'desc'];
            $config['info'] = false;
        @endphp
        <x-adminlte-datatable id="tablePatologi" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
            hoverable compressed>
        </x-adminlte-datatable>
    </x-adminlte-modal>
    <x-adminlte-modal id="modalLabPA" name="modalLabPA" title="Hasil Patologi Anatomi Pasien" theme="success"
        icon="fas fa-file-medical" size="xl">
        <iframe id="dataHasilLabPa" src="" height="600px" width="100%" title="Iframe Example"></iframe>
        <x-slot name="footerSlot">
            <a href="" id="urlHasilLabPa" target="_blank" class="btn btn-primary mr-auto">
                <i class="fas fa-download "></i>Download</a>
            <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <script>
        function lihatLabPa() {
            $.LoadingOverlay("show");
            getLabPatologi();
            $('#modalPatologi').modal('show');
        }

        function getLabPatologi() {
            var url = "{{ route('get_hasil_patologi') }}?norm={{ $kunjungan->no_rm }}";
            var table = $('#tablePatologi').DataTable();
            $.ajax({
                type: "GET",
                url: url,
            }).done(function(data) {
                table.rows().remove().draw();
                if (data.metadata.code == 200) {
                    $.each(data.response, function(key, value) {
                        var periksa = '';
                        var btn =
                            '<button class="btn btn-xs btn-primary" onclick="showHasilPa(this)"  data-kode="' +
                            value.detail_id + '">Lihat</button> ';
                        table.row.add([
                            value.tgl_masuk,
                            value.counter + " / " + value.kode_kunjungan,
                            value.no_rm + " / " + value.nama_px,
                            value.nama_unit,
                            value.pemeriksaan,
                            btn,
                        ]).draw(false);
                    });
                } else {
                    Swal.fire(
                        'Mohon Maaf !',
                        data.metadata.message,
                        'error'
                    );
                }
                $.LoadingOverlay("hide");
            });
        }

        function showHasilPa(button) {
            var kode = $(button).data('kode');
            var url = "http://192.168.2.212:81/simrswaled/SimrsPrint/printEX/" +
                kode;
            $('#dataHasilLabPa').attr('src', url);
            $('#urlHasilLabPa').attr('href', url);
            $('#modalLabPA').modal('show');
        }
    </script>
