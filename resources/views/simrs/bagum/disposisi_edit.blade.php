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
                            <dt class="col-sm-4">No Urut / Kode</dt>
                            <dd class="col-sm-8"> {{ $surat->no_urut }} / {{ $surat->kode ?? '-' }}</dd>
                            <dt class="col-sm-4">Nomor Surat</dt>
                            <dd class="col-sm-8">{{ $surat->no_surat ?? '-' }}</dd>
                            <dt class="col-sm-4">Tanggal Surat</dt>
                            <dd class="col-sm-8">{{ $surat->tgl_surat }}</dd>

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
                            <dt class="col-sm-4">Tanggal Terima Surat</dt>
                            <dd class="col-sm-8">{{ $surat->tgl_disposisi }}</dd>
                            @if ($surat->tanda_terima)
                                <dt class="col-sm-4">Penerima Disposisi</dt>
                                <dd class="col-sm-8">{{ $surat->tanda_terima ?? '-' }} </dd>
                                <dt class="col-sm-4">Tgl Terima</dt>
                                <dd class="col-sm-8">{{ $surat->tgl_terima_surat ?? '-' }}
                                    <br>
                                    {!! $surat->tanda_terima ? QrCode::size(100)->generate($pernyataan_penerima) : '-' !!}
                                </dd>
                            @endif
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-4">No Disposisi</dt>
                            <dd class="col-sm-8">{{ $nomor }}</dd>
                            <dt class="col-sm-4">Tgl Disposisi</dt>
                            <dd class="col-sm-8">{{ $surat->tgl_diteruskan ?? '-' }}</dd>
                            <dt class="col-sm-4">Pengolah</dt>
                            <dd class="col-sm-8 h6 text-dark"><i>{{ $surat->pengolah ?? 'Belum Diisi' }}</i></dd>
                            <dt class="col-sm-4">Disposisi</dt>
                            <dd class="col-sm-8 h6 text-dark"><i>
                                    @isset($surat->tindakan)
                                        @foreach ($surat->tindakan as $key => $item)
                                            - {{ $item }} <br>
                                        @endforeach
                                    @endisset
                                </i></dd>
                            <dt class="col-sm-4">Catatan Disposisi</dt>
                            <dd class="col-sm-8 h6 text-dark"><i>{{ $surat->disposisi ?? 'Belum Diisi' }}</i></dd>
                            <dt class="col-sm-4">Ttd Direktur</dt>
                            <dd class="col-sm-8">
                                {{ $surat->ttd_direktur ?? '-' }} <br>
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
                    <a class="btn btn-danger" href="{{ route('disposisi.index') }}">Kembali</a>
                </x-slot>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalDisposisi" title="Edit Disposisi" theme="warning">
        <form action="{{ route('suratmasuk.index') }}/{{ $surat->id_surat_masuk }}" id="formSurat" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-12">
                    @php
                        $config = ['format' => 'YYYY-MM-DD'];
                    @endphp
                    <x-adminlte-input-date name="tgl_diteruskan" value="" label="Tgl Diteruskan" igroup-size="sm"
                        :config="$config" enable-old-support />
                    <x-adminlte-textarea name="pengolah" rows=3 placeholder="Diteruskan Kpd" label="Diteruskan Kpd"
                        enable-old-support />
                    {{-- <div class="form-group">
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
                    </div> --}}
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
                            <input class="custom-control-input" type="checkbox" id="simpan_arsipkan"
                                name="simpan_arsipkan" value="Simpan / arsipkan">
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
                    console.log(data);
                    if (data.tgl_diteruskan) {
                        $('#tgl_diteruskan').val(data.tgl_diteruskan);
                    }
                    $('#pengolah').val(data.pengolah);
                    $('#disposisi').val(data.disposisi);
                    if (typeof(data.ttd_direktur) != "undefined" && data.ttd_direktur !== null)
                        $('#ttd_direktur').prop('checked', true);
                    else
                        $('#ttd_direktur').prop('checked', false);
                    $('#modalDisposisi').modal('show');
                    $.LoadingOverlay("hide", true);
                })
            });
        });
    </script>
@endsection
