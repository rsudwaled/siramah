<x-adminlte-modal id="modalCariSuratKontrol" name="modalCariSuratKontrol" title="Surat Kontrol Pasien" theme="success"
    icon="fas fa-file-medical" size="xl">
    <form name="formCariSuratKontrol" id="formCariSuratKontrol">
        <div class="row">
            <div class="col-4">
                @php
                    $config = ['format' => 'YYYY-MM'];
                @endphp
                <x-adminlte-input-date igroup-size="sm" name="bulan" label="Tanggal Antrian" :config="$config"
                    value="{{ now()->format('Y-m') }}" placeholder="Pilih Bulan">
                </x-adminlte-input-date>
            </div>
            <div class="col-4">
                <x-adminlte-input igroup-size="sm" name="nomorkartu" label="Nomor Kartu" value="{{ $pasien->no_Bpjs }}"
                    placeholder="Pencarian Berdasarkan Nomor Kartu BPJS">
                </x-adminlte-input>
            </div>
            <div class="col-4">
                <x-adminlte-select2 igroup-size="sm" name="formatfilter" label="Format Filter">
                    <option value="1">Tanggal Entri</option>
                    <option value="2" selected>Tanggal Kontrol </option>
                </x-adminlte-select2>
            </div>
        </div>
        <x-adminlte-button theme="primary" class="btn btn-sm mb-2" icon="fas fa-search" label="Submit Pencarian"
            onclick="getSuratKontrol()" />
        <x-adminlte-button theme="success" onclick="buatSuratKontrol()" class="btn btn-sm mb-2" icon="fas fa-plus"
            label="Buat Surat Kontrol" />
    </form>
    @php
        $heads = [
            'Tgl Kontrol',
            'No S.Kontrol',
            'Jenis Surat',
            'Poliklinik',
            'Dokter',
            'No SEP Asal',
            'Terbit SEP',
            'Action',
        ];
        $config['paging'] = false;
        $config['order'] = ['0', 'desc'];
        $config['info'] = false;
        $config['searching'] = false;
    @endphp
    <x-adminlte-datatable id="tableSuratKontrol" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
        hoverable compressed>
    </x-adminlte-datatable>
</x-adminlte-modal>
<x-adminlte-modal id="modalSuratKontrol" name="modalSuratKontrol" size="lg" title="Surat Kontrol Pasien"
    theme="success" icon="fas fa-file-medical">
    <form id="formSuratKontrol" name="formSuratKontrol">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <x-adminlte-input name="noSep" class="nomorsep-id nomorsepkontrol" igroup-size="sm" label="Nomor SEP"
                    value="{{ $kunjungan->no_sep }}" placeholder="Nomor SEP" readonly>
                    <x-slot name="appendSlot">
                        <div class="btn btn-primary" onclick="cariSEP()">
                            <i class="fas fa-search"></i> Cari SEP
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <input type="hidden" name="noSEP" class="nomorsepkontrol">
                <x-adminlte-input name="noSuratKontrol" igroup-size="sm" label="Nomor Surat Kontrol"
                    placeholder="Nomor Kartu" readonly />
                <x-adminlte-input name="nomorkartu" class="nomorkartu-id" value="{{ $pasien->no_Bpjs }}"
                    igroup-size="sm" label="Nomor Kartu" placeholder="Nomor Kartu" readonly />
                <x-adminlte-input name="norm" class="norm-id" label="No RM" igroup-size="sm" placeholder="No RM "
                    value="{{ $pasien->no_rm }}" readonly />
                <x-adminlte-input name="nama" class="nama-id" value="{{ $pasien->nama_px }}" label="Nama Pasien"
                    igroup-size="sm" placeholder="Nama Pasien" readonly />
                <x-adminlte-input name="nohp" class="nohp-id" label="Nomor HP" igroup-size="sm"
                    placeholder="Nomor HP" />
            </div>
            <div class="col-md-6">
                @php
                    $config = ['format' => 'YYYY-MM-DD'];
                @endphp
                <x-adminlte-input-date name="tglRencanaKontrol" igroup-size="sm" label="Tanggal Rencana Kontrol"
                    placeholder="Pilih Tanggal Rencana Kontrol" :config="$config">
                    <x-slot name="appendSlot">
                        <div class="btn btn-primary btnCariPoli">
                            <i class="fas fa-search"></i> Cari Poli
                        </div>
                    </x-slot>
                </x-adminlte-input-date>
                <x-adminlte-select igroup-size="sm" name="poliKontrol" label="Poliklinik">
                    <option selected disabled>Silahkan Klik Cari Poliklinik</option>
                    <x-slot name="appendSlot">
                        <div class="btn btn-primary btnCariDokter">
                            <i class="fas fa-search"></i> Cari Dokter
                        </div>
                    </x-slot>
                </x-adminlte-select>
                <x-adminlte-select igroup-size="sm" name="kodeDokter" label="Dokter">
                    <option selected disabled>Silahkan Klik Cari Dokter</option>
                </x-adminlte-select>
                <x-adminlte-textarea igroup-size="sm" label="Catatan" name="catatan" placeholder="Catatan Pasien" />
                <input type="hidden" name="user" value="{{ Auth::user()->name }}">
            </div>
        </div>
        <x-slot name="footerSlot">
            <x-adminlte-button id="btnStoreSuratKontrol" class="mr-auto" icon="fas fa-file-plus" theme="success"
                label="Buat Surat Kontrol" onclick="simpanSuratKontrol()" />
            <x-adminlte-button id="btnUpdateSuratKontrol" onclick="updateSuratKontrol()" class="mr-auto" icon="fas fa-edit" theme="warning"
                label="Update Surat Kontrol" />
            <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
        </x-slot>
    </form>
</x-adminlte-modal>
<x-adminlte-modal id="modalSEP" name="modalSEP" title="SEP Peserta" theme="success" icon="fas fa-file-medical"
    size="xl">
    @php
        $heads = ['tglSep', 'tglPlgSep', 'noSep', 'jnsPelayanan', 'poli', 'diagnosa', 'Action'];
        $config['paging'] = false;
        $config['order'] = ['0', 'desc'];
        $config['info'] = false;
    @endphp
    <x-adminlte-datatable id="tableSEP" class="nowrap text-xs" :heads="$heads" :config="$config" bordered hoverable
        compressed>
    </x-adminlte-datatable>
</x-adminlte-modal>
@push('js')
    <script>
        $(function() {
            $('.btnCariPoli').click(function(e) {
                e.preventDefault();
                $.LoadingOverlay("show");
                var sep = $('.nomorsep-id').val();
                var tanggal = $('#tglRencanaKontrol').val();
                var url = "{{ route('suratkontrol_poli') }}?nomor=" + sep + "&tglRencanaKontrol=" +
                    tanggal + "&jenisKontrol=2";
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if (data.metadata.code == 200) {
                            $('#poliKontrol').empty()
                            $.each(data.response.list, function(key, value) {
                                optText = value.namaPoli + " (" + value.persentase +
                                    "%)";
                                optValue = value.kodePoli;
                                $('#poliKontrol').append(new Option(optText, optValue));
                            });
                            Toast.fire({
                                icon: 'success',
                                title: 'Pasien Ditemukan'
                            });
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
                        $.LoadingOverlay("hide");
                    }
                });
            });
            $('.btnCariDokter').click(function(e) {
                e.preventDefault();
                $.LoadingOverlay("show");
                var poli = $('#poliKontrol').find(":selected").val();
                var tanggal = $('#tglRencanaKontrol').val();
                var url = "{{ route('suratkontrol_dokter') }}?kodePoli=" + poli + "&tglRencanaKontrol=" +
                    tanggal + "&jenisKontrol=2";
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if (data.metadata.code == 200) {
                            $('#kodeDokter').empty();
                            $.each(data.response.list, function(key, value) {
                                optText = value.namaDokter + " (" + value
                                    .jadwalPraktek +
                                    ")";
                                optValue = value.kodeDokter;
                                $('#kodeDokter').append(new Option(optText, optValue));
                            });
                            Toast.fire({
                                icon: 'success',
                                title: 'Pasien Ditemukan'
                            });
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
                        $.LoadingOverlay("hide");
                    }
                });
            });
            $('.btnPrintSuratKontrol').click(function(e) {
                $.LoadingOverlay("show");
                var nomorsuratkontrol = $(".nomorsuratkontrol-id").val();
                var url = "{{ route('suratkontrol_print') }}?nomorsuratkontrol=" + nomorsuratkontrol;
                window.open(url, '_blank');
                $.LoadingOverlay("hide");
            });
            $('.btnEditSuratKontrol').click(function(e) {
                $.LoadingOverlay("show");
                var nomorsuratkontrol = $(".nomorsuratkontrol-id").val();
                var url = "{{ route('suratkontrol_edit') }}?nomorsuratkontrol=" + nomorsuratkontrol;
                window.open(url, '_blank');
                $.LoadingOverlay("hide");
            });
        });

        function cariSEP() {
            var nomorkartu = $('.nomorkartu-id').val();
            $('#modalSEP').modal('show');
            var table = $('#tableSEP').DataTable();
            table.rows().remove().draw();
            $.LoadingOverlay("show");
            var url = "{{ route('suratkontrol_sep') }}?nomorkartu=" + nomorkartu;
            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    if (data.metadata.code == 200) {
                        $.each(data.response, function(key, value) {
                            if (value.jnsPelayanan == 1) {
                                var jenispelayanan = "Rawat Inap";
                            }
                            if (value.jnsPelayanan == 2) {
                                var jenispelayanan = "Rawat Jalan";
                            }
                            table.row.add([
                                value.tglSep,
                                value.tglPlgSep,
                                value.noSep,
                                jenispelayanan,
                                value.poli,
                                value.diagnosa,
                                "<button class='btnPilihSEP btn btn-success btn-xs' data-id=" +
                                value.noSep +
                                ">Pilih</button>",
                            ]).draw(false);

                        });
                        $('.btnPilihSEP').click(function() {
                            var nomorsep = $(this).data('id');
                            $.LoadingOverlay("show");
                            $('.nomorsep-id').val(nomorsep);
                            $('#modalSEP').modal('hide');
                            $.LoadingOverlay("hide");
                        });
                    } else {
                        swal.fire(
                            'Error ' + data.metadata.code,
                            data.metadata.message,
                            'error'
                        );
                    }
                    $.LoadingOverlay("hide");
                },
                error: function(data) {
                    // swal.fire(
                    //     'Error ' + data.metadata.code,
                    //     data.metadata.message,
                    //     'error'
                    // );
                    $.LoadingOverlay("hide");
                }
            });
        }

        function cariSuratKontrol() {
            $('#modalCariSuratKontrol').modal('show');
        }

        function getSuratKontrol() {
            $.LoadingOverlay("show");
            var data = $('#formCariSuratKontrol').serialize();
            var url = "{{ route('get_surat_kontrol') }}?" + data;
            var table = $('#tableSuratKontrol').DataTable();
            $.ajax({
                type: "GET",
                url: url,
            }).done(function(data) {
                table.rows().remove().draw();
                if (data.metadata.code == 200) {
                    $.each(data.response, function(key, value) {
                        btnprint =
                            '<button class="btn btn-xs btn-success" onclick="printSuratKontrol(this)" data-nomorsuratkontrol="' +
                            value.noSuratKontrol + '"><i class="fas fa-print"></i></button> ';
                        btnedit =
                            '<button class="btn btn-xs btn-warning" onclick="editSuratKontrol(this)" data-tglRencanaKontrol="' +
                            value.tglRencanaKontrol + '" data-noSuratKontrol="' +
                            value.noSuratKontrol + '" data-poliTujuan="' +
                            value.poliTujuan + '" data-namaPoliTujuan="' +
                            value.namaPoliTujuan + '" data-noSepAsalKontrol="' +
                            value.noSepAsalKontrol + '" data-namaDokter="' +
                            value.namaDokter + '" data-kodeDokter="' +
                            value.kodeDokter + '"><i class="fas fa-edit"></i></button> ';
                        btndelete =
                            '<button class="btn btn-xs btn-danger" onclick="deleteSuratKontrol(this)" data-nomorsurat="' +
                            value.noSuratKontrol + '"><i class="fas fa-trash"></i></button> ';
                        if (value.terbitSEP == "Belum") {
                            var btn = btnprint + btnedit + btndelete;
                        } else {
                            var btn = btnprint;
                        }
                        table.row.add([
                            value.tglRencanaKontrol,
                            value.noSuratKontrol,
                            value.namaJnsKontrol,
                            value.namaPoliTujuan,
                            value.namaDokter,
                            value.noSepAsalKontrol,
                            value.terbitSEP,
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
            }).fail(function() {
                $.LoadingOverlay("hide");
                alert("error, silahkan coba lagi");
            });
        }

        function printSuratKontrol(button) {
            var nomorsuratkontrol = $(button).data('nomorsuratkontrol');
            var url = "{{ route('suratkontrol_print') }}?nomorsuratkontrol=" + nomorsuratkontrol;
            window.open(url, '_blank');
        }

        function buatSuratKontrol(button) {
            $('#btnStoreSuratKontrol').show();
            $('#btnUpdateSuratKontrol').hide();
            $('#formSuratKontrol').trigger("reset");
            $('#kodeDokter').empty();
            $('#poliKontrol').empty();
            $('#modalSuratKontrol').modal('show');
        }

        function simpanSuratKontrol() {
            $.LoadingOverlay("show");
            var data = $('#formSuratKontrol').serialize();
            var url = "{{ route('api.suratkontrol_insert') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: data,
            }).done(function(data) {
                $('#modalSuratKontrol').modal('hide');
                if (data.metadata.code == 200) {
                    Swal.fire(
                        'Berhasil Buat Surat Kontrol',
                        data.metadata.message,
                        'success'
                    );
                    getSuratKontrol();
                } else {
                    Swal.fire(
                        'Mohon Maaf !',
                        data.metadata.message,
                        'error'
                    );
                }
                $.LoadingOverlay("hide");
            }).fail(function() {
                $.LoadingOverlay("hide");
                alert("error, silahkan coba lagi");
            });
        }

        function editSuratKontrol(button) {
            $('#btnStoreSuratKontrol').hide();
            $('#btnUpdateSuratKontrol').show();
            $('#formSuratKontrol').trigger("reset");
            $('#kodeDokter').empty();
            $('#poliKontrol').empty();
            $('#noSuratKontrol').val($(button).data("nosuratkontrol"));
            $('.nomorsepkontrol').val($(button).data("nosepasalkontrol"));
            $('#tglRencanaKontrol').val($(button).data("tglrencanakontrol"));
            $('#kodeDokter').append(new Option($(button).data("namadokter"), $(button).data("kodedokter")));
            $('#poliKontrol').append(new Option($(button).data("namapolitujuan"), $(button).data("politujuan")));
            console.log(button);
            $('#modalSuratKontrol').modal('show');
        }

        function updateSuratKontrol() {
            $.LoadingOverlay("show");
            var data = $('#formSuratKontrol').serialize();
            var url = "{{ route('surat_kontrol_update') }}";
            $.ajax({
                type: "PUT",
                url: url,
                data: data,
            }).done(function(data) {
                $('#modalSuratKontrol').modal('hide');
                if (data.metadata.code == 200) {
                    Swal.fire(
                        'Berhasil Update Surat Kontrol',
                        data.metadata.message,
                        'success'
                    );
                    getSuratKontrol();
                } else {
                    Swal.fire(
                        'Mohon Maaf !',
                        data.metadata.message,
                        'error'
                    );
                }
                $.LoadingOverlay("hide");
            }).fail(function() {
                $.LoadingOverlay("hide");
                alert("error, silahkan coba lagi");
            });
        }

        function deleteSuratKontrol(button) {
            $.LoadingOverlay("show");
            var nomorsurat = $(button).data('nomorsurat');
            var url = "{{ route('api.suratkontrol_delete') }}";
            var datax = {
                noSuratKontrol: nomorsurat,
                user: "sistem"
            };
            $.ajax({
                type: "DELETE",
                url: url,
                data: datax,
            }).done(function(data) {
                if (data.metadata.code == 200) {
                    Swal.fire(
                        'Berhasil Buat Surat Kontrol',
                        data.metadata.message,
                        'success'
                    );
                    getSuratKontrol();
                } else {
                    Swal.fire(
                        'Mohon Maaf !',
                        data.metadata.message,
                        'error'
                    );
                }
                $.LoadingOverlay("hide");
            }).fail(function() {
                $.LoadingOverlay("hide");
                alert("error, silahkan coba lagi");
            });

        }
    </script>
@endpush
