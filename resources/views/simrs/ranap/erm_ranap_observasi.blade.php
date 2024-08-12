<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#colObservasi">
        <h3 class="card-title">
            Observasi Pasien 24 Jam
        </h3>
    </a>
    <div id="colObservasi" class="collapse">
        <div class="card-body">
            <div class="col-lg-12" id="formInputOberservasiRanap" style="display: none">
                <form id="formObservasi" name="formObservasi" method="POST">
                    @csrf
                    @php
                        $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
                    @endphp
                    <input type="hidden" class="kode_kunjungan-keperawatan" name="kode_kunjungan"
                        value="{{ $kunjungan->kode_kunjungan }}">
                    <input type="hidden" class="counter-keperawatan" name="counter" value="{{ $kunjungan->counter }}">
                    <input type="hidden" class="norm-keperawatan" name="norm" value="{{ $kunjungan->no_rm }}">
                    <div class="row">
                        <div class="col-md-6">
                            <x-adminlte-input-date id="tanggal_input-observasi" name="tanggal_input"
                                label="Tanggal & Waktu" :config="$config" />
                            <x-adminlte-input name="tensi" class="tensi" igroup-size="sm" label="Tensi Darah"
                                placeholder="Tensi" />
                            <x-adminlte-input name="nadi" class="nadi-id" igroup-size="sm" label="Denyut Nadi"
                                placeholder="Denyut Nadi" />
                            <x-adminlte-input name="rr" class="rr-id" igroup-size="sm" label="RR"
                                placeholder="RR" />
                            <x-adminlte-input name="suhu" class="suhu-id" igroup-size="sm" label="Suhu"
                                placeholder="Suhu" />
                            <x-adminlte-input name="gds" class="gds-id" igroup-size="sm"
                                label="Gula Darah Sewaktu (GDS)" placeholder="Gula Darah Sewaktu (GDS)" />
                            <x-adminlte-input name="ecg" class="ecg-id" igroup-size="sm" label="ECG"
                                placeholder="ECG" />
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-input name="kesadaran" class="kesadaran-id" igroup-size="sm" label="Kesadaran"
                                placeholder="Kesadaran" />
                            <x-adminlte-textarea igroup-size="sm" class="pemeriksaanfisik-observasi"
                                name="pemeriksaanfisik" label="Pemeriksaan Fisik" placeholder="Pemeriksaan Fisik"
                                rows=3>
                            </x-adminlte-textarea>
                            <x-adminlte-textarea igroup-size="sm" class="keterangan-observasi" name="keterangan"
                                label="Keterangan" placeholder="Keterangan" rows=3>
                            </x-adminlte-textarea>
                        </div>
                    </div>
                </form>
            </div>
            <x-adminlte-button label="Input Observasi" id="btn-input-observasi" icon="fas fa-plus" theme="success"
                class="btn-xs" onclick="btnInputObservasi()" />
            <button onclick="tambahObservasi()" style="display: none;" class="btn-xs btn btn-success" id="btn-saveObservasi" class="btn btn-success mr-auto"><i
                    class="fas fa-save"></i>
                Simpan</button>
            <x-adminlte-button id="cancelInputObservasi" class="btn-xs" label="Batal Input" icon="fas fa-window-close"
                theme="danger" style="display: none;" onclick="batalInputOberservasi()" />
            <x-adminlte-button icon="fas fa-sync" id="btn-getObersvasi" theme="primary" class="btn-xs"
                onclick="getObservasiRanap()" />
            <a href="{{ route('print_obaservasi_ranap') }}?kunjungan={{ $kunjungan->kode_kunjungan }}" target="_blank"
                id="btn-print-observasiRanap" class="btn btn-xs btn-warning"><i class="fas fa-print"></i> Print</a>

            <table class="table table-sm table-bordered table-hover" id="tableObservasi">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Tanggal Jam</th>
                        <th>Tensi</th>
                        <th>Nadi</th>
                        <th>RR</th>
                        <th>Suhu</th>
                        <th>GDS</th>
                        <th>ECG</th>
                        <th>Kesadaran</th>
                        <th>Pemeriksaan Fisik</th>
                        <th>Ket.</th>
                        <th>Ttd Pengisi,</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@push('js')
    {{-- <x-adminlte-modal id="modalObservasi" title="Observasi 24 Jam" theme="warning" icon="fas fa-file-medical"
        size='lg'>
        <form id="formObservasi" name="formObservasi" method="POST">
            @csrf
            @php
                $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
            @endphp
            <input type="hidden" class="kode_kunjungan-keperawatan" name="kode_kunjungan"
                value="{{ $kunjungan->kode_kunjungan }}">
            <input type="hidden" class="counter-keperawatan" name="counter" value="{{ $kunjungan->counter }}">
            <input type="hidden" class="norm-keperawatan" name="norm" value="{{ $kunjungan->no_rm }}">
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input-date id="tanggal_input-observasi" name="tanggal_input" label="Tanggal & Waktu"
                        :config="$config" />
                    <x-adminlte-input name="tensi" class="tensi" igroup-size="sm" label="Tensi Darah"
                        placeholder="Tensi" />
                    <x-adminlte-input name="nadi" class="nadi-id" igroup-size="sm" label="Denyut Nadi"
                        placeholder="Denyut Nadi" />
                    <x-adminlte-input name="rr" class="rr-id" igroup-size="sm" label="RR" placeholder="RR" />
                    <x-adminlte-input name="suhu" class="suhu-id" igroup-size="sm" label="Suhu"
                        placeholder="Suhu" />
                    <x-adminlte-input name="gds" class="gds-id" igroup-size="sm" label="Gula Darah Sewaktu (GDS)"
                        placeholder="Gula Darah Sewaktu (GDS)" />
                    <x-adminlte-input name="ecg" class="ecg-id" igroup-size="sm" label="ECG"
                        placeholder="ECG" />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="kesadaran" class="kesadaran-id" igroup-size="sm" label="Kesadaran"
                        placeholder="Kesadaran" />
                    <x-adminlte-textarea igroup-size="sm" class="pemeriksaanfisik-observasi" name="pemeriksaanfisik"
                        label="Pemeriksaan Fisik" placeholder="Pemeriksaan Fisik" rows=3>
                    </x-adminlte-textarea>
                    <x-adminlte-textarea igroup-size="sm" class="keterangan-observasi" name="keterangan"
                        label="Keterangan" placeholder="Keterangan" rows=3>
                    </x-adminlte-textarea>
                </div>
            </div>
        </form>
        <x-slot name="footerSlot">
            <button onclick="tambahObservasi()" class="btn btn-success mr-auto"><i class="fas fa-save"></i>
                Simpan</button>
            <x-adminlte-button theme="danger" label="Close" icon="fas fa-times" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal> --}}
    <script>
        $(function() {
            $('#tableObservasi').DataTable({
                info: false,
                ordering: false,
                paging: false
            });
            getObservasiRanap();
        });

        function btnInputObservasi() {
            $.LoadingOverlay("show");
            $("#formPerkembangan").trigger('reset');
            $('#formInputOberservasiRanap').css('display', 'block');
            $('#btn-saveObservasi').css('display', 'inline-block');
            $('#cancelInputObservasi').css('display', 'inline-block');
            $('#btn-input-observasi').css('display', 'none');
            $('#btn-getObersvasi').css('display', 'none');
            $('#btn-print-observasiRanap').css('display', 'none');

            let today = moment().format('yyyy-MM-DD HH:mm:ss');
            $('#tanggal_input-observasi').val(today);
            $('#modalObservasi').modal('show');
            $.LoadingOverlay("hide");
        }
        function batalInputOberservasi() {
            $('#formInputOberservasiRanap').css('display', 'none');
            $('#btn-saveObservasi').css('display', 'none');
            $('#cancelInputObservasi').css('display', 'none');
            $('#btn-input-observasi').css('display', 'inline-block');
            $('#btn-getObersvasi').css('display', 'inline-block');
            $('#btn-print-observasiRanap').css('display', 'inline-block');
        }

        function tambahObservasi() {
            $.LoadingOverlay("show");
            $.ajax({
                type: "POST",
                url: "{{ route('simpan_observasi_ranap') }}",
                data: $("#formObservasi").serialize(),
                dataType: "json",
                encode: true,
            }).done(function(data) {
                if (data.metadata.code == 200) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Observasi telah ditambahkan',
                    });
                    $("#formObservasi").trigger('reset');
                    getObservasiRanap();
                    $('#formInputOberservasiRanap').css('display', 'none');
                    $('#btn-saveObservasi').css('display', 'none');
                    $('#cancelInputObservasi').css('display', 'none');
                    $('#btn-input-observasi').css('display', 'inline-block');
                    $('#btn-getObersvasi').css('display', 'inline-block');
                    $('#btn-print-observasiRanap').css('display', 'inline-block');
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Tambah Observasi error',
                    });
                }
                $.LoadingOverlay("hide");
            });
        }

        function getObservasiRanap() {
            var url = "{{ route('get_observasi_ranap') }}?kode={{ $kunjungan->kode_kunjungan }}";
            var table = $('#tableObservasi').DataTable();
            $.ajax({
                type: "GET",
                url: url,
            }).done(function(data) {
                table.rows().remove().draw();
                if (data.metadata.code == 200) {
                    $.each(data.response, function(key, value) {
                        var fisik = value.pemeriksaanfisik ? value.pemeriksaanfisik : '';
                        var ket = value.keterangan ? value.keterangan : '';
                        var btn =
                            '<button class="btn btn-xs btn-warning" onclick="editObservasiRanap(this)" data-tanggal_input="' +
                            value.tanggal_input + '" data-tensi="' + value.tensi +
                            '" data-nadi="' +
                            value.nadi +
                            '" data-rr="' +
                            value.rr +
                            '" data-suhu="' +
                            value.suhu +
                            '" data-gds="' +
                            value.gds +
                            '" data-ecg="' +
                            value.ecg +
                            '" data-kesadaran="' +
                            value.kesadaran +
                            '" data-pemeriksaanfisik="' +
                            value.pemeriksaanfisik +
                            '" data-keterangan="' +
                            value.keterangan +
                            '"><i class="fas fa-edit"></i> Edit</button> <button class="btn btn-xs btn-danger" onclick="hapusObservasiRanap(this)" data-id="' +
                            value.id +
                            '"><i class="fas fa-trash"></i> Hapus</button>';
                        table.row.add([
                            btn,
                            value.tanggal_input,
                            value.tensi,
                            value.nadi,
                            value.rr,
                            value.suhu,
                            value.gds,
                            value.ecg,
                            value.kesadaran,
                            '<pre>' + fisik + '</pre>',
                            '<pre>' + ket + '</pre>',
                            value.pic,
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

        function editObservasiRanap(button) {
            $.LoadingOverlay("show");
            $("#tanggal_input-observasi").val($(button).data('tanggal_input'));
            $("#tensi").val($(button).data('tensi'));
            $("#nadi").val($(button).data('nadi'));
            $("#rr").val($(button).data('rr'));
            $("#suhu").val($(button).data('suhu'));
            $("#gds").val($(button).data('gds'));
            $("#ecg").val($(button).data('ecg'));
            $("#pemeriksaanfisik").val($(button).data('pemeriksaanfisik'));
            $("#kesadaran").val($(button).data('kesadaran'));
            $(".keterangan-observasi").val($(button).data('keterangan'));
            $('#modalObservasi').modal('show');
            $.LoadingOverlay("hide");
        }

        function hapusObservasiRanap(button) {
            $.LoadingOverlay("show");
            $.ajax({
                type: "POST",
                url: "{{ route('hapus_obaservasi_ranap') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": tarif = $(button).data('id')
                },
                dataType: "json",
                encode: true,
            }).done(function(data) {
                if (data.metadata.code == 200) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Tarif layanan & tindakan telah dihapuskan',
                    });
                    $("#formObservasi").trigger('reset');
                    getObservasiRanap();
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Tarif layanan & tindakan gagal dihapuskan',
                    });
                }
                $.LoadingOverlay("hide");
            });
            $.LoadingOverlay("hide");
        }
    </script>
@endpush
