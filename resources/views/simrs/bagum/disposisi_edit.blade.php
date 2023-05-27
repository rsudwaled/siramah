@extends('adminlte::page')
@section('title', 'Disposisi')
@section('content_header')
    <h1>Disposisi</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card theme="primary" icon="fas fa-envelope" collapsible title="Disposisi">
                <div class="row">
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-4">No Urut</dt>
                            <dd class="col-sm-8">{{ $surat->no_urut }}</dd>
                            <dt class="col-sm-4">Kode Surat</dt>
                            <dd class="col-sm-8">{{ $surat->kode ?? '-' }}</dd>
                            <dt class="col-sm-4">Nomor Surat</dt>
                            <dd class="col-sm-8">{{ $surat->no_surat ?? '-' }}</dd>
                            <dt class="col-sm-4">Tanggal Surat</dt>
                            <dd class="col-sm-8">{{ $surat->tgl_surat }}</dd>
                            <dt class="col-sm-4">Asal </dt>
                            <dd class="col-sm-8 h6 text-secondary" >{{ $surat->asal_surat }}</dd>
                            <dt class="col-sm-4">Perihal Surat</dt>
                            <dd class="col-sm-8 h6 text-secondary">{{ $surat->perihal }}</dd>
                            <dt class="col-sm-4">Tgl Disposisi</dt>
                            <dd class="col-sm-8">{{ $surat->tgl_disposisi }}</dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-4">Tgl Diteruskan</dt>
                            <dd class="col-sm-8">{{ $surat->tgl_diteruskan ?? '-' }}</dd>
                            <dt class="col-sm-4">Pengolah</dt>
                            <dd class="col-sm-8 h6 text-secondary">{{ $surat->pengolah ?? '-' }}</dd>
                            <dt class="col-sm-4">Disposisi</dt>
                            <dd class="col-sm-8 h6 text-secondary">{{ $surat->disposisi ?? '-' }}</dd>
                            <br>
                            <br>
                            <dt class="col-sm-4">Tgl Terima</dt>
                            <dd class="col-sm-8">{{ $surat->tgl_terima_surat ?? '-' }}</dd>
                            <dt class="col-sm-4">Disposisi</dt>
                            <dd class="col-sm-8">{{ $surat->tanda_terima }}</dd>

                        </dl>
                    </div>
                </div>
                <x-slot name="footerSlot">
                    {{-- <button type="submit" form="formSurat" class="btn btn-success mr-auto">Simpan</button> --}}
                    <x-adminlte-button class="mr-auto " id="btnStore" type="submit" theme="success"
                        icon="fas fa-save" label="Simpan" />
                    <x-adminlte-button class="mr-auto" id="btnUpdate" theme="warning" icon="fas fa-edit"
                        label="Update" />
                    <x-adminlte-button id="btnDelete" theme="danger" icon="fas fa-trash-alt" label="Delete" />
                </x-slot>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalLampiran" title="Lampiran Surat Masuk" size="xl" theme="success" v-centered>
        <form action="{{ route('suratlampiran.store') }}" id="formLampiran" method="POST"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_surat" id="id_surat_lampiran">
            <x-adminlte-input-file name="file" placeholder="Pilih file...">
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-lightblue">
                        <i class="fas fa-upload"></i>
                    </div>
                </x-slot>
            </x-adminlte-input-file>
        </form>
        <x-slot name="footerSlot">
            <button type="submit" form="formLampiran" class="btn btn-success mr-auto">Simpan</button>
            <x-adminlte-button theme="secondary" icon="fas fa-arrow-left" label="Kembali" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <x-adminlte-modal id="modalFile" size="xl" theme="warning" title="Lampiran Surat Masuk">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <dt class="col-sm-4">No Surat</dt>
                    <dd class="col-sm-8">: <span id="nama"></span></dd>
                    <dt class="col-sm-4">Tgl Surat</dt>
                    <dd class="col-sm-8">: <span id="nomorkartu"></span></dd>
                    <dt class="col-sm-4">Tgl Disposisi</dt>
                    <dd class="col-sm-8">: <span id="namafile"></span></dd>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <dt class="col-sm-4">Asal Surat</dt>
                    <dd class="col-sm-8">: <span id="nomorkartu"></span></dd>
                    <dt class="col-sm-4">Perihal</dt>
                    <dd class="col-sm-8">: <span id="nomorkartu"></span></dd>
                </div>
            </div>
        </div>
        <iframe id="fileurl" src="" width="100%" height="700px">
        </iframe>
        <x-slot name="footerSlot">
            {{-- <button type="submit" form="formLampiran" class="btn btn-success mr-auto">Simpan</button>
            <x-adminlte-button class="mr-auto " id="btnStore" type="submit" theme="success" icon="fas fa-save"
                label="Simpan" /> --}}
            {{-- <x-adminlte-button class="mr-auto" id="btnUpdate" theme="warning" icon="fas fa-edit" label="Update" /> --}}
            <x-adminlte-button id="btnDeleteLampiran" theme="danger" icon="fas fa-trash-alt" label="Delete" />
            <form name="formDeleteLampiran" id="formDeleteLampiran" action="" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id_surat" id="id_lampiran_delete">
            </form>
            <x-adminlte-button theme="secondary" icon="fas fa-arrow-left" label="Kembali" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)
@section('plugins.BsCustomFileInput', true)

@section('js')
    <script>
        $(document).ready(function() {
            $('#tambahSurat').click(function() {
                $.LoadingOverlay("show");
                $('#formSurat').trigger("reset");
                $('#btnStore').show();
                $('#btnUpdate').hide();
                $('#modal').modal('show');
                $.LoadingOverlay("hide", true);
            });
            $('#cetakBlanko').click(function() {
                var url = "{{ route('disposisi.create') }}";
                window.open(url, 'window name', 'window settings');
                return false;
            });
            $('.cetakDisposisi').click(function() {
                var id = $(this).data('id');
                var url = "{{ route('disposisi.index') }}/" + id;
                window.open(url, 'window name', 'window settings');
                return false;
            });
            $('#btnStore').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var url = "{{ route('disposisi.store') }}";
                $('#formSurat').attr('action', url);
                $("#method").prop('disabled', true);
                $('#formSurat').submit();
            });
            $('#btnUpdate').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var id = $('#id_surat').val();
                var url = "{{ route('disposisi.index') }}/" + id;
                $('#formSurat').attr('action', url);
                $('#method').val('PUT');
                $('#formSurat').submit();
            });
            $('#btnDelete').click(function(e) {
                e.preventDefault();
                swal.fire({
                    title: 'Apakah anda ingin menghapus disposisi surat ini ?',
                    showConfirmButton: false,
                    showDenyButton: true,
                    showCancelButton: true,
                    denyButtonText: `Ya, Hapus`,
                }).then((result) => {
                    if (result.isDenied) {
                        $.LoadingOverlay("show");
                        var id = $('#id_surat').val();
                        var url = "{{ route('disposisi.index') }}/" + id;
                        $('#formDelete').attr('action', url);
                        $('#formDelete').submit();
                    }
                })
            });
            $('.editSuratMasuk').click(function() {
                var id = $(this).data('id');
                $.LoadingOverlay("show");
                $('#formSurat').trigger("reset");
                $('#btnStore').hide();
                $('#btnUpdate').show();
                var url = "{{ route('suratmasuk.index') }}/" + id;
                $.get(url, function(data) {
                    console.log(data);
                    $('#id_surat').val(data.id_surat_masuk);
                    $('#no_urut').val(data.no_urut);
                    $('#kode').val(data.kode);
                    $('#no_surat').val(data.no_surat);
                    $('#tgl_surat').val(data.tgl_surat);
                    $('#asal_surat').val(data.asal_surat);
                    $('#perihal').val(data.perihal);
                    $('#disposisi').val(data.disposisi);
                    $('#tgl_disposisi').val(data.tgl_disposisi);
                    $('#tgl_diteruskan').val(data.tgl_diteruskan);
                    $('#pengolah').val(data.pengolah);
                    $('#tanda_terima').val(data.tanda_terima);
                    $('#tgl_terima_surat').val(data.tgl_terima_surat);
                    if (typeof(data.ttd_direktur) != "undefined" && data.ttd_direktur !== null)
                        $('#ttd_direktur').prop('checked', true);
                    else
                        $('#ttd_direktur').prop('checked', false);
                    $('#modal').modal('show');
                    $.LoadingOverlay("hide", true);
                })
            });
            $('.lihatLampiran').click(function() {
                var url = $(this).data('url');
                var id = $(this).data('id');
                $.LoadingOverlay("show");
                $('#modalFile').modal('show');
                $("#fileurl").attr("src", url);
                $('#id_lampiran_delete').val(id);
                $.LoadingOverlay("hide", true);
            });
            $('#btnDeleteLampiran').click(function(e) {
                e.preventDefault();
                swal.fire({
                    title: 'Apakah anda ingin menghapus disposisi surat ini ?',
                    showConfirmButton: false,
                    showDenyButton: true,
                    showCancelButton: true,
                    denyButtonText: `Ya, Hapus`,
                }).then((result) => {
                    if (result.isDenied) {
                        $.LoadingOverlay("show");
                        var id = $('#id_lampiran_delete').val();
                        var url = "{{ route('suratlampiran.index') }}/" + id;
                        $('#formDeleteLampiran').attr('action', url);
                        $('#formDeleteLampiran').submit();
                    }
                })
            });
        });
        $(document).on('click', '.uploadLampiran', function() {
            $.LoadingOverlay("show");
            var id = $(this).data('id');
            $('#id_surat_lampiran').val(id);
            $('#formSurat').trigger("reset");
            $('#btnStore').hide();
            $('#btnUpdate').show();
            $('#modalLampiran').modal('show');
            $.LoadingOverlay("hide");
        });
    </script>
@endsection
