<div class="card card-info mb-1" id="card-laboratorium">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cLaboratorium">
        <h3 class="card-title">
            LABORATORIUM
        </h3>
    </a>
    <div id="cLaboratorium" class="collapse" role="tabpanel">
        <div class="card-body">
            <div class="col-lg-12">
                @php
                    $heads = ['Tgl Masuk', 'Kunjungan', 'Pasien', 'Unit', 'Pemeriksaan', 'Action'];
                    $config['paging'] = false;
                    $config['order'] = ['0', 'desc'];
                    $config['info'] = false;
                @endphp
                <x-adminlte-datatable id="tableLaboratorium1" class="nowrap text-xs" :heads="$heads" :config="$config"
                    bordered hoverable compressed>
                </x-adminlte-datatable>
            </div>
        </div>
    </div>
</div>
<x-adminlte-modal id="modalHasilLab" name="modalHasilLab" title="Hasil Laboratorium" theme="success"
icon="fas fa-file-medical" size="xl">
<iframe id="dataHasilLab" src="" height="600px" width="100%" title="Iframe Example"></iframe>
<x-slot name="footerSlot">
    {{-- <a href="" id="urlHasilLab" target="_blank" class="btn btn-primary mr-auto">
        <i class="fas fa-download "></i>Download</a> --}}
    <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal" />
</x-slot>
</x-adminlte-modal>
@push('js')
    <script>
        function getHasilLab() {
            var url = "{{ route('get_hasil_laboratorium') }}?norm={{ $kunjungan->no_rm }}";
            var table = $('#tableLaboratorium').DataTable();
            $.ajax({
                type: "GET",
                url: url,
            }).done(function(data) {
                table.rows().remove().draw();
                if (data.metadata.code == 200) {
                    $.each(data.response, function(key, value) {
                        var periksa = '';
                        var btn =
                            '<button class="btn btn-xs btn-primary" onclick="showHasilLab(this)"  data-kode="' +
                            value.laboratorium + '">Lihat</button> ';
                        $.each(value.pemeriksaan, function(key, value) {
                            periksa = periksa + value + '<br>';
                        });
                        table.row.add([
                            value.tgl_masuk,
                            value.counter + " / " + value.kode_kunjungan,
                            value.no_rm + " / " + value.nama_px,
                            value.nama_unit,
                            periksa,
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

        function showHasilLab(button) {
            var kode = $(button).data('kode');
            console.log(kode);
            var url = "http://192.168.2.74/smartlab_waled/his/his_report?hisno=" +
                kode;
            $('#dataHasilLab').attr('src', url);
            $('#urlHasilLab').attr('href', url);
            $('#modalHasilLab').modal('show');
        }
    </script>
@endpush
