    <x-adminlte-modal id="modalRadiologi" name="modalRadiologi" title="Hasil Radiologi Pasien" theme="success"
        icon="fas fa-file-medical" size="xl">
        @php
            $heads = ['Tgl Masuk', 'Kunjungan', 'Pasien', 'Unit', 'Pemeriksaan', 'Action'];
            $config['paging'] = false;
            $config['order'] = ['0', 'desc'];
            $config['info'] = false;
        @endphp
        <x-adminlte-datatable id="tableRadiologi" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
            hoverable compressed>
        </x-adminlte-datatable>
    </x-adminlte-modal>
    <x-adminlte-modal id="modalRongsen" name="modalRongsen" title="Hasil Rongsen Pasien" theme="success"
        icon="fas fa-file-medical" size="xl">
        <iframe id="dataUrlRongsen" src="" height="600px" width="100%" title="Iframe Example"></iframe>
        <x-slot name="footerSlot">
            <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    @push('js')
        <script>
            function lihatHasilRadiologi() {
                $.LoadingOverlay("show");
                getHasilRadiologi();
                $('#modalRadiologi').modal('show');
            }

            function getHasilRadiologi() {
                var url = "{{ route('get_hasil_radiologi') }}?norm={{ $kunjungan->no_rm }}";
                var table = $('#tableRadiologi').DataTable();
                $.ajax({
                    type: "GET",
                    url: url,
                }).done(function(data) {
                    table.rows().remove().draw();
                    if (data.metadata.code == 200) {
                        $.each(data.response, function(key, value) {
                            var btnrongsen =
                                '<button class="btn btn-xs btn-primary" onclick="lihatHasilRongsen(this)"  data-norm="' +
                                value.no_rm + '">Rongsen</button> ';
                            var btnexpertise =
                                '<button class="btn btn-xs btn-primary" onclick="lihatExpertiseRad(this)"  data-header="' +
                                value.header_id + '" data-detail="' + value.detail_id + '">Expertise</button> ';
                            table.row.add([
                                value.tgl_masuk,
                                value.counter + " / " + value.kode_kunjungan,
                                value.no_rm + " / " + value.nama_px,
                                value.nama_unit,
                                value.pemeriksaan,
                                btnrongsen + ' ' + btnexpertise,
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

            function lihatHasilRongsen(button) {
                var norm = $(button).data('norm');
                var url = "http://192.168.10.17/ZFP?mode=proxy&lights=on&titlebar=on#View&ris_pat_id=" + norm +
                    "&un=radiologi&pw=YnanEegSoQr0lxvKr59DTyTO44qTbzbn9koNCrajqCRwHCVhfQAddGf%2f4PNjqOaV";
                $('#dataUrlRongsen').attr('src', url);
                $('#modalRongsen').modal('show');
            }

            function lihatExpertiseRad(button) {
                var header = $(button).data('header');
                var detail = $(button).data('detail');
                var url = "http://192.168.2.233/expertise/cetak0.php?IDs=" + header + "&IDd=" + detail +
                    "&tgl_cetak={{ now()->format('Y-m-d') }}";
                $('#dataUrlRongsen').attr('src', url);
                $('#modalRongsen').modal('show');
            }
        </script>
    @endpush
