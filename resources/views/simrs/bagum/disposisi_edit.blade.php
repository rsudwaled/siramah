@extends('adminlte::page')
@section('title', 'Disposisi')
@section('content_header')
    <h1>Disposisi</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card theme="primary" icon="fas fa-envelope" collapsible title="Disposisi  {{ $surat->asal_surat }}">
                <div class="row">
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-4">No Disposisi</dt>
                            <dd class="col-sm-8">{{ $nomor }}</dd>
                            <dt class="col-sm-4">Nomor Surat</dt>
                            <dd class="col-sm-8">{{ $surat->no_surat ?? '-' }}</dd>
                            <dt class="col-sm-4">Tanggal Surat</dt>
                            <dd class="col-sm-8">{{ $surat->tgl_surat }}</dd>
                            <dt class="col-sm-4">Tanggal Terima Surat</dt>
                            <dd class="col-sm-8">{{ $surat->created_at }}</dd>
                            <dt class="col-sm-4">Asal </dt>
                            <dd class="col-sm-8 h6 text-dark"><i>{{ $surat->asal_surat }}</i></dd>
                            <dt class="col-sm-4">Perihal Surat</dt>
                            <dd class="col-sm-8 h6 text-dark"><i>{{ $surat->perihal }}</i></dd>
                            <dt class="col-sm-4">Lampiran</dt>
                            <dd class="col-sm-8">
                                @if ($surat->lampiran)
                                    <a class="btn btn-xs btn-primary"
                                        href="{{ str_replace('http://192.168.2.30/', 'http://sim.rsudwaled.id/', $surat->lampiran->fileurl) }}"
                                        target="_blank">Download Lampiran</a>
                                @else
                                    <i>tidak ada lampiran</i>
                                @endif
                            </dd>
                            @isset($surat->tanda_terima)
                                <dt class="col-sm-4">Penerima Disposisi</dt>
                                <dd class="col-sm-8">{{ $surat->tanda_terima ?? '-' }} </dd>
                                <dt class="col-sm-4">Tgl Terima</dt>
                                <dd class="col-sm-8">{{ $surat->tgl_terima_surat ?? '-' }}
                                    <br>
                                    {!! $surat->tanda_terima ? QrCode::size(100)->generate($pernyataan_penerima) : '-' !!}
                                </dd>
                            @endisset
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-4">Tgl Diteruskan</dt>
                            <dd class="col-sm-8">{{ $surat->tgl_diteruskan ?? 'Belum Diisi' }}</dd>
                            <dt class="col-sm-4">Pengolah</dt>
                            <dd class="col-sm-8 h6 text-dark"><i>{{ $surat->pengolah ?? 'Belum Diisi' }}</i></dd>
                            <dt class="col-sm-4">Disposisi</dt>
                            <dd class="col-sm-8 h6 text-dark"><i>
                                    @isset($surat->tindakan)
                                        @foreach ($surat->tindakan as $key => $item)
                                            - {{ $item }} <br>
                                        @endforeach
                                    @else
                                        Belum Diisi
                                    @endisset
                                </i></dd>
                            <dt class="col-sm-4">Catatan Disposisi</dt>
                            <dd class="col-sm-8 h6 text-dark"><i>{{ $surat->disposisi ?? 'Belum Diisi' }}</i></dd>
                            <dt class="col-sm-4">Ttd Direktur</dt>
                            <dd class="col-sm-8">
                                {{ $surat->ttd_direktur ?? 'Belum Diisi' }} <br>
                                {!! $surat->ttd_direktur ? QrCode::size(100)->generate($pernyataan_direktur) : '-' !!}
                            </dd>
                        </dl>
                    </div>
                </div>
                <x-slot name="footerSlot">
                    <x-adminlte-button class="mr-auto " id="editSuratMasuk" theme="warning" icon="fas fa-edit"
                        label="Edit Disposisi" data-id="{{ $surat->id_surat_masuk }}" />
                    <a class="btn btn-primary" target="_blank"
                        href="{{ route('disposisi.index') }}/{{ $surat->id_surat_masuk }}"><i class="fas fa-print"></i>
                        Print</a>
                    <a class="btn btn-danger withLoad" href="{{ route('disposisi.index') }}">Kembali</a>
                </x-slot>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalDisposisi" title="Edit Disposisi" theme="warning" size="xl">
        <form action="{{ route('suratmasuk.index') }}/{{ $surat->id_surat_masuk }}" id="formSurat" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-4">No Disposisi</dt>
                        <dd class="col-sm-8">{{ $nomor }}</dd>
                        <dt class="col-sm-4">Nomor Surat</dt>
                        <dd class="col-sm-8">{{ $surat->no_surat ?? '-' }}</dd>
                        <dt class="col-sm-4">Tanggal Surat</dt>
                        <dd class="col-sm-8">{{ $surat->tgl_surat }}</dd>
                        <dt class="col-sm-4">Tanggal Terima Surat</dt>
                        <dd class="col-sm-8">{{ $surat->created_at }}</dd>
                        <dt class="col-sm-4">Asal </dt>
                        <dd class="col-sm-8 h6 text-dark"><i>{{ $surat->asal_surat }}</i></dd>
                        <dt class="col-sm-4">Perihal Surat</dt>
                        <dd class="col-sm-8 h6 text-dark"><i>{{ $surat->perihal }}</i></dd>
                        <dt class="col-sm-4">Lampiran</dt>
                        <dd class="col-sm-8">
                            @if ($surat->lampiran)
                                <a class="btn btn-xs btn-primary" href="{{ $surat->lampiran->fileurl }}"
                                    target="_blank">Download Lampiran</a>
                            @else
                                <i>tidak ada lampiran</i>
                            @endif
                        </dd>
                        @isset($surat->tanda_terima)
                            <dt class="col-sm-4">Penerima Disposisi</dt>
                            <dd class="col-sm-8">{{ $surat->tanda_terima ?? '-' }} </dd>
                            <dt class="col-sm-4">Tgl Terima</dt>
                            <dd class="col-sm-8">{{ $surat->tgl_terima_surat ?? '-' }}
                                <br>
                                {!! $surat->tanda_terima ? QrCode::size(100)->generate($pernyataan_penerima) : '-' !!}
                            </dd>
                        @endisset
                    </dl>
                </div>
                <div class="col-md-6">
                    @php
                        $config = ['format' => 'YYYY-MM-DD'];
                    @endphp
                    <x-adminlte-input-date name="tgl_diteruskan" value="{{ now()->format('Y-m-d') }}"
                        label="Tgl Diteruskan" igroup-size="sm" :config="$config" enable-old-support />
                    <x-adminlte-textarea name="pengolah" rows=3 placeholder="Diteruskan Kpd" label="Diteruskan Kpd"
                        enable-old-support />
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="tindaklanjuti" name="tindakan[]"
                                value="Untuk ditindaklanjuti">
                            <label for="tindaklanjuti" class="custom-control-label">Untuk ditindaklanjuti</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="proses_sesuai_kemampuan"
                                name="tindakan[]" value="Proses sesuai kemampuan / peraturan yang berlaku">
                            <label for="proses_sesuai_kemampuan" class="custom-control-label">Proses sesuai kemampuan /
                                peraturan yang berlaku</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="koordinasikan" name="tindakan[]"
                                value="Koordinasikan / konfirmasi dengan ybs / instansi terkait">
                            <label for="koordinasikan" class="custom-control-label">Koordinasikan / konfirmasi
                                dengan ybs / instansi terkait</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="untuk_dibantu" name="tindakan[]"
                                value="Untuk dibantu / difasilitasi / dipenuhi sesuai kebutuhan">
                            <label for="untuk_dibantu" class="custom-control-label">Untuk dibantu / difasilitasi /
                                dipenuhi sesuai kebutuhan</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="pelajari" name="tindakan[]"
                                value="Pelajari / telaah / sarannya">
                            <label for="pelajari" class="custom-control-label">Pelajari / telaah /
                                sarannya</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="wakili_hadiri" name="tindakan[]"
                                value="Wakili / hadiri / terima / laporkan hasilnya">
                            <label for="wakili_hadiri" class="custom-control-label">Wakili / hadiri / terima /
                                laporkan hasilnya</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="agendakan" name="tindakan[]"
                                value="Agendakan / persiapkan / koordinasikan">
                            <label for="agendakan" class="custom-control-label">Agendakan / persiapkan /
                                koordinasikan </label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="ingatkan_waktunya" name="tindakan[]"
                                value="Jadwalkan ingatkan waktunya">
                            <label for="ingatkan_waktunya" class="custom-control-label">Jadwalkan ingatkan
                                waktunya</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="siapkan_bahan" name="tindakan[]"
                                value="Siapkan pointer / sambutan / bahan">
                            <label for="siapkan_bahan" class="custom-control-label">Siapkan pointer / sambutan /
                                bahan</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="simpan_arsipkan" name="tindakan[]"
                                value="Simpan / arsipkan">
                            <label for="simpan_arsipkan" class="custom-control-label">Simpan / arsipkan</label>
                        </div>
                    </div>
                    <x-adminlte-textarea name="disposisi" rows=5 placeholder="Catatan Disposisi"
                        label="Catatan Disposisi" />
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="ttd_direktur" name="ttd_direktur">
                            <label for="ttd_direktur" class="custom-control-label">Telah Ditandatangi Oleh
                                Direktur</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="ttd_wadir" name="ttd_wadir"
                                disabled>
                            <label for="ttd_wadir" class="custom-control-label">Telah Ditandatangi Oleh Wadir</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="ttd_kabag" name="ttd_kabag"
                                disabled>
                            <label for="ttd_kabag" class="custom-control-label">Telah Ditandatangi Oleh Kabag</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="ttd_kasubag" name="ttd_kasubag"
                                disabled>
                            <label for="ttd_kasubag" class="custom-control-label">Telah Ditandatangi Oleh Kasubag</label>
                        </div>
                    </div>
                </div>
            </div>
            <x-slot name="footerSlot">
                <button type="submit" form="formSurat" class="btn btn-success mr-auto"><i class="fas fa-save"></i>
                    Simpan</button>
                <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
            </x-slot>
        </form>
    </x-adminlte-modal>
@stop

@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)
@section('plugins.BsCustomFileInput', true)
@section('js')
    <script>
        $(document).ready(function() {
            $('#editSuratMasuk').click(function() {
                var id = $(this).data('id');
                $.LoadingOverlay("show");
                var url = "{{ route('suratmasuk.index') }}/" + id;
                $.get(url, function(data) {
                    // console.log(data.tindakan);
                    if (data.tindakan.indexOf('Untuk ditindaklanjuti') > -1) {
                        $("#tindaklanjuti").prop('checked', true);
                    }
                    if (data.tindakan.indexOf('Proses sesuai kemampuan / peraturan yang berlaku') >
                        -1) {
                        $("#proses_sesuai_kemampuan").prop('checked', true);
                    }
                    if (data.tindakan.indexOf(
                            'Koordinasikan / konfirmasi dengan ybs / instansi terkait') > -1) {
                        $("#koordinasikan").prop('checked', true);
                    }
                    if (data.tindakan.indexOf(
                            'Untuk dibantu / difasilitasi / dipenuhi sesuai kebutuhan') > -1) {
                        $("#untuk_dibantu").prop('checked', true);
                    }
                    if (data.tindakan.indexOf('Pelajari / telaah / sarannya') > -1) {
                        $("#pelajari").prop('checked', true);
                    }
                    if (data.tindakan.indexOf('Wakili / hadiri / terima / laporkan hasilnya') > -
                        1) {
                        $("#wakili_hadiri").prop('checked', true);
                    }
                    if (data.tindakan.indexOf('Agendakan / persiapkan / koordinasikan') > -1) {
                        $("#agendakan").prop('checked', true);
                    }
                    if (data.tindakan.indexOf('Jadwalkan ingatkan waktunya') > -1) {
                        $("#ingatkan_waktunya").prop('checked', true);
                    }
                    if (data.tindakan.indexOf('Siapkan pointer / sambutan / bahan') > -1) {
                        $("#siapkan_bahan").prop('checked', true);
                    }
                    if (data.tindakan.indexOf('Simpan / arsipkan') > -1) {
                        $("#simpan_arsipkan").prop('checked', true);
                    }
                    if (data.tgl_diteruskan) {
                        $('#tgl_diteruskan').val(data.tgl_diteruskan);
                    }

                    if (typeof(data.ttd_direktur) != "undefined" && data.ttd_direktur !== null)
                        $('#ttd_direktur').prop('checked', true);
                    else
                        $('#ttd_direktur').prop('checked', false);

                    $('#pengolah').val(data.pengolah);
                    $('#disposisi').val(data.disposisi);
                    $('#modalDisposisi').modal('show');
                    $.LoadingOverlay("hide", true);
                })
            });
        });
    </script>
@endsection
