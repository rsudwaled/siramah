<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#colPerkembangan">
        <h3 class="card-title">
            SOAP & Perkembangan Pasien
        </h3>
    </a>
    <div id="colPerkembangan" class="collapse">
        <div class="card-body">
            <x-adminlte-button label="Input SOAP" icon="fas fa-plus" theme="success" class="btn-xs"
                onclick="btnInputPerkembangan()" />
            <x-adminlte-button icon="fas fa-sync" theme="primary" class="btn-xs" onclick="getObservasiRanap()" />
            <a href="{{ route('print_perkembangan_ranap') }}?kunjungan={{ $kunjungan->kode_kunjungan }}" target="_blank"
                class="btn btn-xs btn-warning"><i class="fas fa-print"></i> Print</a>
            <table class="table table-sm table-bordered table-hover" id="tablePerkembanganPasien">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Tanggal Jam</th>
                        <th>SOAP, Hasil Pemeriksaan, Analisis & Catatan Lainnya</th>
                        <th>Instruksi Medis</th>
                        <th>Ttd Pengisi,</th>
                        <th>Verifikasi DPJP</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@push('js')
    <x-adminlte-modal id="modalPerkembanganPasien" title="Catatan Perkembangan Pasien Rawat Inap" theme="warning"
        icon="fas fa-file-medical" size='lg'>
        <form id="formPerkembangan" name="formPerkembangan" method="POST">
            @csrf
            @php
                $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
            @endphp
            <input type="hidden" class="kode_kunjungan-perkembangan" name="kode_kunjungan"
                value="{{ $kunjungan->kode_kunjungan }}">
            <input type="hidden" class="counter-keperawatan" name="counter" value="{{ $kunjungan->counter }}">
            <input type="hidden" class="norm-keperawatan" name="norm" value="{{ $kunjungan->no_rm }}">
            <x-adminlte-input-date id="tanggal_input-perkembangan" name="tanggal_input" label="Tanggal & Waktu"
                :config="$config" />
            <x-adminlte-textarea igroup-size="sm" class="perkembangan-perkembangan" name="perkembangan"
                label="SOAP, Hasil Pemeriksaan, Analisis & Catatan Lainnya "
                placeholder="SOAP, Hasil Pemeriksaan, Analisis & Catatan Lainnya " rows=7>
            </x-adminlte-textarea>
            <x-adminlte-textarea igroup-size="sm" class="instruksi_medis-perkembangan" name="instruksi_medis"
                label="Instruksi Medis" placeholder="Instruksi Medis termasuk Procedur / Pasca Bedah" rows=5>
            </x-adminlte-textarea>
        </form>
        <x-slot name="footerSlot">
            <button class="btn btn-success mr-auto" onclick="tambahPerkembangan()"><i class="fas fa-save"></i>
                Simpan</button>
            <x-adminlte-button theme="danger" label="Close" icon="fas fa-times" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <script>
        $(function() {
            $('#tablePerkembanganPasien').DataTable({
                info: false,
                ordering: false,
                paging: false
            });
            getPerkembanganPasien();
        });

        function btnInputPerkembangan() {
            $.LoadingOverlay("show");
            $("#formPerkembangan").trigger('reset');
            let today = moment().format('yyyy-MM-DD HH:mm:ss');
            $('#tanggal_input-perkembangan').val(today);
            $('#modalPerkembanganPasien').modal('show');
            $.LoadingOverlay("hide");
        }

        function tambahPerkembangan() {
            $.LoadingOverlay("show");
            $.ajax({
                type: "POST",
                url: "{{ route('simpan_perkembangan_ranap') }}",
                data: $("#formPerkembangan").serialize(),
                dataType: "json",
                encode: true,
            }).done(function(data) {
                if (data.metadata.code == 200) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Tarif layanan & tindakan telah ditambahkan',
                    });
                    $("#formPerkembangan").trigger('reset');
                    getPerkembanganPasien();
                    $('#modalPerkembanganPasien').modal('hide');
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Tambah tarif layanan & tindakan error',
                    });
                }
                $.LoadingOverlay("hide");
            });

        }

        function getPerkembanganPasien() {
            var url = "{{ route('get_perkembangan_ranap') }}?kode={{ $kunjungan->kode_kunjungan }}";
            var table = $('#tablePerkembanganPasien').DataTable();
            $.ajax({
                type: "GET",
                url: url,
            }).done(function(data) {
                table.rows().remove().draw();
                if (data.metadata.code == 200) {
                    $.each(data.response, function(key, value) {
                        var btn =
                            '<button class="btn btn-xs mb-1 btn-warning" onclick="editPerkembangan(this)" data-id="' +
                            value.id +
                            '" data-tglinput="' + value.tanggal_input +
                            '" data-perkembangan="' + value.perkembangan +
                            '" data-instruksimedis="' + value.instruksi_medis +
                            '"><i class="fas fa-edit"></i> Edit</button> <button class="btn btn-success btn-xs mb-1" onclick="verifikasiSoap(this)" data-id="' +
                            value.id +
                            '"><i class="fas fa-check"></i> Verifikasi</button>  <button class="btn btn-xs mb-1 btn-danger" onclick="hapusPerkembangan(this)" data-id="' +
                            value.id +
                            '"><i class="fas fa-trash"></i> Hapus</button>';
                        table.row.add([
                            btn,
                            value.tanggal_input,
                            '<pre>' + value.perkembangan + '</pre>',
                            '<pre>' + value.instruksi_medis + '</pre>',
                            value.pic,
                            value.verifikasi_by,
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

        function editPerkembangan(button) {
            $.LoadingOverlay("show");
            $("#tanggal_input-perkembangan").val($(button).data('tglinput'));
            $(".instruksi_medis-perkembangan").val($(button).data('instruksimedis'));
            $(".perkembangan-perkembangan").val($(button).data('perkembangan'));
            $('#modalPerkembanganPasien').modal('show');
            $.LoadingOverlay("hide");
        }

        function hapusPerkembangan(button) {
            $.LoadingOverlay("show");
            $.ajax({
                type: "POST",
                url: "{{ route('hapus_perkembangan_ranap') }}",
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
                        title: 'Perkembangan Ranap telah dihapuskan',
                    });
                    $("#formPerkembangan").trigger('reset');
                    getPerkembanganPasien();
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Keperawatan Ranap gagal dihapuskan',
                    });
                }
                $.LoadingOverlay("hide");
            });
        }

        function verifikasiSoap(button) {
            $.LoadingOverlay("show");
            $.ajax({
                type: "POST",
                url: "{{ route('verifikasi_soap_ranap') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": $(button).data('id')
                },
                dataType: "json",
                encode: true,
                success: function(data) {
                    console.log(data);
                    if (data.metadata.code == 200) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Perkembangan Ranap telah diverifikasi',
                        });
                        $("#formPerkembangan").trigger('reset');
                        getPerkembanganPasien();
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Keperawatan Ranap gagal diverifikasi',
                        });
                    }
                    $.LoadingOverlay("hide");
                },
                error: function(data) {
                    console.log(data);
                    $.LoadingOverlay("hide");
                }
            });
        }
    </script>
@endpush
