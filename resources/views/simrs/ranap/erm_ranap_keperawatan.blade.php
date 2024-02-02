<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#colKeperawatan">
        <h3 class="card-title">
            Implementasi & Evaluasi Keperawatan
        </h3>
    </a>
    <div id="colKeperawatan" class="collapse">
        <div class="card-body">
            <x-adminlte-button label="Input Keperawatan" icon="fas fa-plus" theme="success" class="btn-xs"
                onclick="btnInputKeperawatan()" />
            <x-adminlte-button icon="fas fa-sync" theme="primary" class="btn-xs" onclick="getKeperawatanRanap()" />
            <a href="{{ route('print_implementasi_evaluasi_keperawatan') }}?kunjungan={{ $kunjungan->kode_kunjungan }}"
                target="_blank" class="btn btn-xs btn-warning"><i class="fas fa-print"></i> Print</a>
            <style>
                pre {
                    border: none;
                    outline: none;
                    padding: 0 !important;
                    font-size: 12px;
                }
            </style>
            <table class="table table-sm table-bordered table-hover" id="tableKeperawatan">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Tanggal Jam</th>
                        <th>Implementasi & Evaluasi Keperawatan</th>
                        <th>Ttd Pengisi,</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@push('js')
    <x-adminlte-modal id="modalInputKeperawatan" title="Implementasi & Evaluasi Keperawatan" theme="warning"
        icon="fas fa-file-medical" size='lg'>
        <form id="formKeperawatan" name="formKeperawatan" method="POST">
            @csrf
            @php
                $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
            @endphp
            <input type="hidden" class="kode_kunjungan-keperawatan" name="kode_kunjungan"
                value="{{ $kunjungan->kode_kunjungan }}">
            <input type="hidden" class="counter-keperawatan" name="counter" value="{{ $kunjungan->counter }}">
            <input type="hidden" class="norm-keperawatan" name="norm" value="{{ $kunjungan->no_rm }}">
            <x-adminlte-input-date id="tanggal_input-keperawatan" name="tanggal_input" label="Tanggal & Waktu"
                :config="$config" />
            <x-adminlte-textarea igroup-size="sm" class="keperawatan-keperawatan" name="keperawatan"
                label="Implementasi & Evaluasi Keperawatan" placeholder="Implementasi & Evaluasi Keperawatan" rows=5>
            </x-adminlte-textarea>
        </form>
        <x-slot name="footerSlot">
            <button class="btn btn-success mr-auto" onclick="tambahKeperawatan()"><i class="fas fa-save"></i>
                Simpan</button>
            <x-adminlte-button theme="danger" label="Close" icon="fas fa-times" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <script>
        $(function() {
            $('#tableKeperawatan').DataTable({
                info: false,
                ordering: false,
                paging: false
            });
            getKeperawatanRanap();
        });

        function btnInputKeperawatan() {
            $.LoadingOverlay("show");
            let today = moment().format('yyyy-MM-DD HH:mm:ss');
            $('#tanggal_input-keperawatan').val(today);
            $('#modalInputKeperawatan').modal('show');
            $.LoadingOverlay("hide");
        }

        function tambahKeperawatan() {
            $.LoadingOverlay("show");
            $.ajax({
                type: "POST",
                url: "{{ route('simpan_keperawatan_ranap') }}",
                data: $("#formKeperawatan").serialize(),
                dataType: "json",
                encode: true,
            }).done(function(data) {
                if (data.metadata.code == 200) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Tarif layanan & tindakan telah ditambahkan',
                    });
                    $("#formKeperawatan").trigger('reset');
                    getKeperawatanRanap();
                    $('#modalInputKeperawatan').modal('hide');
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Tambah tarif layanan & tindakan error',
                    });
                }
                $.LoadingOverlay("hide");
            });

        }

        function getKeperawatanRanap() {
            var url = "{{ route('get_keperawatan_ranap') }}?kode={{ $kunjungan->kode_kunjungan }}";
            var table = $('#tableKeperawatan').DataTable();
            $.ajax({
                type: "GET",
                url: url,
            }).done(function(data) {
                table.rows().remove().draw();
                if (data.metadata.code == 200) {
                    $.each(data.response, function(key, value) {
                        var btn =
                            '<button class="btn btn-xs mb-1 btn-warning" onclick="editKeperawatan(this)" data-id="' +
                            value.id +
                            '" data-tglinput="' + value.tanggal_input +
                            '" data-keperawatan="' + value.keperawatan +
                            '"><i class="fas fa-edit"></i> Edit</button> <button class="btn btn-xs mb-1 btn-danger" onclick="hapusKeperawatan(this)" data-id="' +
                            value.id +
                            '"><i class="fas fa-trash"></i> Hapus</button>';
                        table.row.add([
                            btn,
                            value.tanggal_input,
                            '<pre>' + value.keperawatan + '</pre>',
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

        function editKeperawatan(button) {
            $.LoadingOverlay("show");
            $("#tanggal_input-keperawatan").val($(button).data('tglinput'));
            $(".keperawatan-keperawatan").val($(button).data('keperawatan'));
            $('#modalInputKeperawatan').modal('show');
            $.LoadingOverlay("hide");
        }

        function hapusKeperawatan(button) {
            $.LoadingOverlay("show");
            $.ajax({
                type: "POST",
                url: "{{ route('hapus_keperawatan_ranap') }}",
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
                        title: 'Keperawatan Ranap telah dihapuskan',
                    });
                    $("#formKeperawatan").trigger('reset');
                    getKeperawatanRanap();
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Keperawatan Ranap gagal dihapuskan',
                    });
                }
                $.LoadingOverlay("hide");
            });
            $.LoadingOverlay("hide");
        }
    </script>
@endpush
