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
                    <div class="col-md-8 mb-1">
                        <x-adminlte-button label="Refresh" class="btn-sm" theme="warning" title="Refresh User"
                            icon="fas fa-sync" onclick="window.location='{{ route('disposisi.index') }}'" />
                    </div>
                    <div class="col-md-4 mb-1">
                        <form action="" method="get">
                            <x-adminlte-input name="search" placeholder="Pencarian Berdasarkan Nama / Perihal"
                                igroup-size="sm" value="{{ $request->search }}">
                                <x-slot name="appendSlot">
                                    <x-adminlte-button type="submit" theme="primary" label="Cari!" />
                                </x-slot>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text text-primary">
                                        <i class="fas fa-search"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                        </form>
                    </div>
                </div>
            </x-adminlte-card>
            <x-adminlte-card>
                <ul class="products-list product-list-in-card pl-2 pr-2">
                    @foreach ($surats as $item)
                        <li class="item">
                            <a href="{{ route('disposisi.edit', $item->id_surat_masuk) }}">
                                @if ($item->disposisi)
                                    @if ($item->tanda_terima)
                                        <div class="product-img rounded-circle bg-success">
                                            <i class="fas fa-clipboard-check fa-xl m-2 d-flex p-2 "></i>
                                        </div>
                                    @else
                                        <div class="product-img rounded-circle bg-warning">
                                            <i class="fas fa-envelope-open-text fa-xl m-2 d-flex p-2 "></i>
                                        </div>
                                    @endif
                                @else
                                    <div class="product-img rounded-circle bg-danger">
                                        <i class="fas fa-envelope fa-xl m-2 d-flex p-2 "></i>
                                    </div>
                                @endif
                                <div class="product-info">
                                    <div class="product-title">
                                        {{ $item->asal_surat }}
                                        @if ($item->disposisi)
                                            @if ($item->tanda_terima)
                                                <span
                                                    class="badge badge-success float-right">{{ $item->tanda_terima }}</span>
                                            @else
                                                <span class="badge badge-warning float-right">Disposisi</span>
                                            @endif
                                        @else
                                            <span class="badge badge-danger float-right">Belum</span>
                                        @endif
                                    </div>
                                    <span class="product-description">
                                        Perihal : {{ $item->perihal }}
                                        @if ($item->disposisi)
                                            <br>
                                            Ditujukan : {{ $item->pengolah }}
                                        @endif
                                        <br>
                                        Tgl Input : {{ $item->tgl_surat }}
                                    </span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <br>
                <div class="text float-left ">
                    Data yang ditampilkan {{ $surats->count() }} dari total {{ $surat_total }}
                </div>
                <div class="float-right pagination-sm">
                    {{ $surats->appends(request()->input())->links() }}
                </div>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modal" title="Disposisi Surat" size="xl" theme="success" v-centered>
        <form action="" id="formSurat" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <input type="hidden" name="id_surat" id="id_surat">
                    <input type="hidden" name="_method" id="method">
                    <div class="row">
                        <div class="col-md-6">
                            <x-adminlte-input name="no_urut" label="No Urut" igroup-size="sm" enable-old-support readonly />
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-input name="kode" label="Kode Surat" igroup-size="sm" enable-old-support
                                readonly />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <x-adminlte-input name="no_surat" label="Nomor Surat" igroup-size="sm" enable-old-support
                                required readonly />

                        </div>
                        <div class="col-md-6">
                            @php
                                $config = ['format' => 'YYYY-MM-DD'];
                            @endphp
                            <x-adminlte-input-date name="tgl_surat" value="{{ now()->format('Y-m-d') }}" label="Tgl Surat"
                                igroup-size="sm" :config="$config" enable-old-support required disabled />
                        </div>
                    </div>
                    <x-adminlte-input name="asal_surat" label="Asal Surat" igroup-size="sm" enable-old-support required
                        readonly />
                    <x-adminlte-textarea name="perihal" rows=5 placeholder="Perihal" label="Perihal" required readonly />
                    <div class="row">
                        <div class="col-md-6">
                            <x-adminlte-input-date name="tgl_disposisi" value="{{ now()->format('Y-m-d') }}"
                                label="Tgl Disposisi" igroup-size="sm" :config="$config" enable-old-support required
                                disabled />
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-select name="sifat" label="Sifat Surat" readonly>
                                <option value="1">Biasa</option>
                                <option value="2">Segera</option>
                                <option value="3">Sangat Segera</option>
                                <option value="4">Rahasia</option>
                            </x-adminlte-select>
                        </div>
                    </div>
                    <x-adminlte-input name="tanda_terima" label="Tanda Terima" igroup-size="sm" enable-old-support
                        readonly />
                    <x-adminlte-input-date name="tgl_disposisi" value="{{ now()->format('Y-m-d') }}"
                        label="Tgl Terima Disposisi" igroup-size="sm" :config="$config" enable-old-support required
                        readonly />
                    {{-- <x-adminlte-input-date name="tgl_terima_surat" value="{{ now()->format('Y-m-d') }}" label="Tgl Terima Disposisi" igroup-size="sm"
                        :config="$config" enable-old-support /> --}}
                </div>
                <div class="col-md-6">

                    <x-adminlte-input-date name="tgl_diteruskan" label="Tgl Diteruskan" igroup-size="sm"
                        :config="$config" enable-old-support />
                    <x-adminlte-input name="pengolah" label="Diteruskan Kpd" igroup-size="sm" enable-old-support />
                    {{-- <x-adminlte-select name="pengolah" label="Diteruskan Kpd" igroup-size="sm" enable-old-support>
                        <option value="1">Wakil Direktur Umum Dan Keuangan</option>
                        <option value="2">Wakil Direktur Pelayanan Dan Pendidikan</option>
                    </x-adminlte-select> --}}
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="tindaklanjuti" name="tindaklanjuti">
                            <label for="tindaklanjuti" class="custom-control-label">Untuk ditindaklanjuti</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="proses_sesuai_kemampuan"
                                name="proses_sesuai_kemampuan">
                            <label for="proses_sesuai_kemampuan" class="custom-control-label">Proses sesuai kemampuan /
                                peraturan yang berlaku</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="koordinasikan" name="koordinasikan">
                            <label for="koordinasikan" class="custom-control-label">Koordinasikan / konfirmasi
                                dengan
                                ybs / instansi terkait</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="untuk_dibantu" name="untuk_dibantu">
                            <label for="untuk_dibantu" class="custom-control-label">Untuk dibantu / difasilitasi /
                                dipenuhi sesuai kebutuhan</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="pelajari" name="pelajari">
                            <label for="pelajari" class="custom-control-label">Pelajari / telaah /
                                sarannya</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="wakili_hadiri" name="wakili_hadiri">
                            <label for="wakili_hadiri" class="custom-control-label">Wakili / hadiri / terima /
                                laporkan hasilnya</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="agendakan" name="agendakan">
                            <label for="agendakan" class="custom-control-label">Agendakan / persiapkan /
                                koordinasikan </label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="ingatkan_waktunya"
                                name="ingatkan_waktunya">
                            <label for="ingatkan_waktunya" class="custom-control-label">Jadwalkan ingatkan
                                waktunya</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="siapkan_bahan" name="siapkan_bahan">
                            <label for="siapkan_bahan" class="custom-control-label">Siapkan pointer / sambutan /
                                bahan</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="simpan_arsipkan"
                                name="simpan_arsipkan">
                            <label for="simpan_arsipkan" class="custom-control-label">Simpan / arsipkan</label>
                        </div>
                    </div>
                    <x-adminlte-textarea name="disposisi" rows=5 placeholder="Catatan Disposisi"
                        label="Catatan Disposisi" />
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="ttd_direktur" name="ttd_direktur">
                        <label for="ttd_direktur" class="custom-control-label">Telah Ditandatangi Oleh Direktur</label>
                    </div>

                </div>
            </div>
        </form>
        <x-slot name="footerSlot">
            {{-- <button type="submit" form="formSurat" class="btn btn-success mr-auto">Simpan</button> --}}
            <x-adminlte-button class="mr-auto " id="btnStore" type="submit" theme="success" icon="fas fa-save"
                label="Simpan" />
            <x-adminlte-button class="mr-auto" id="btnUpdate" theme="warning" icon="fas fa-edit" label="Update" />
            <x-adminlte-button id="btnDelete" theme="danger" icon="fas fa-trash-alt" label="Delete" />
            <form name="formDelete" id="formDelete" action="" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id_surat" id="id_surat">
            </form>
            <x-adminlte-button theme="secondary" icon="fas fa-arrow-left" label="Kembali" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
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
