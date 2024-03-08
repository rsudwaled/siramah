@extends('adminlte::page')

@section('title', 'Encounter')

@section('content_header')
    <h1>Encounter</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card theme="secondary" icon="fas fa-procedures" title="Kunjungan Pasien Rawat Jalan">
                <form action="" method="GET">
                    <div class="row">
                        <div class="col-md-4">
                            <x-adminlte-select2 fgroup-class="row" label-class="text-right col-3" igroup-size="sm"
                                igroup-class="col-9" name="kodeunit" label="Poliklinik">
                                <option value="-">SEMUA POLIKLINIK</option>
                                @foreach ($units as $key => $item)
                                    <option value="{{ $key }}"
                                        {{ $key == $request->kodeunit ? 'selected' : null }}>
                                        {{ $item }}
                                    </option>
                                @endforeach
                            </x-adminlte-select2>
                        </div>
                        <div class="col-md-6">
                            @php
                                $config = ['format' => 'YYYY-MM-DD'];
                            @endphp
                            <x-adminlte-input-date fgroup-class="row" label-class="text-right col-3" igroup-size="sm"
                                igroup-class="col-9" igroup-size="sm" name="tanggalperiksa" label="Tanggal Periksa"
                                :config="$config" value="{{ $request->tanggalperiksa ?? now()->format('Y-m-d') }}">
                                <x-slot name="appendSlot">
                                    <x-adminlte-button class="btn-sm btnGetObservasi" type="submit" icon="fas fa-search"
                                        theme="primary" label="Submit Pencarian" />
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                    </div>
                </form>
                @if ($kunjungans)
                    <div class="row">
                        <div class="col-md-3">
                            <x-adminlte-small-box title="{{ $kunjungans->count() }}" text="Total Kunjungan" theme="success"
                                icon="fas fa-user-injured" />
                        </div>
                        <div class="col-md-3">
                            <x-adminlte-small-box
                                title="{{ $kunjungans->count() - $kunjungans->where('diagnosaicd.diag_utama', '!=', null)->count() }}"
                                text="Belum ICD-10" theme="danger" icon="fas fa-user-injured" />
                        </div>
                        <div class="col-md-3">
                            <x-adminlte-small-box title="{{ $kunjungans->where('id_satusehat', '!=', null)->count() }}"
                                text="Sync Satu Sehat" theme="warning" icon="fas fa-user-injured" />
                        </div>
                    </div>
                    @php
                        $heads = [
                            'No RM',
                            'Pasien',
                            'Status',
                            'Action',
                            'Tgl Masuk',
                            'Kunjungan',
                            'Poliklinik',
                            'Dokter',
                            'Diagnosa',
                            'ICD-10 01',
                            'ICD-10 S1',
                            'ICD-10 S2',
                            'ICD-10 S3',
                            'ICD-10 S4',
                            'ICD-10 S5',
                        ];
                        $config['order'] = [['3', 'asc']];
                        $config['fixedColumns'] = [
                            'leftColumns' => 4,
                        ];
                        $config['paging'] = false;
                        $config['scrollX'] = true;

                        $config['scrollY'] = '400px';
                    @endphp
                    <x-adminlte-datatable id="table1" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
                        hoverable compressed>
                        @if ($kunjungans)
                            @foreach ($kunjungans as $kunjungan)
                                @if ($kunjungan->diagnosaicd)
                                    @if ($kunjungan->diagnosaicd->diag_utama)
                                        <tr>
                                        @else
                                        <tr class="text-danger">
                                    @endif
                                @else
                                    <tr class="text-danger">
                                @endif
                                <td>{{ $kunjungan->no_rm }}</td>
                                <td>{{ $kunjungan->pasien->nama_px ?? '-' }}</td>
                                <td>
                                    @if ($kunjungan->id_satusehat)
                                        <span class="badge badge-success">Syncron</span>
                                    @else
                                        <span class="badge badge-danger">Belum</span>
                                    @endif
                                </td>
                                <td>
                                    <x-adminlte-button class="btn-xs" onclick="btnKunjungan(this)" icon="fas fa-edit"
                                        theme="warning" label="Edit" data-kodekunjungan="{{ $kunjungan->kode_kunjungan }}"
                                        data-norm="{{ $kunjungan->no_rm }}"
                                        data-nama="{{ $kunjungan->pasien->nama_px ?? null }}"
                                        data-unit="{{ $kunjungan->unit->nama_unit }}"
                                        data-dokter="{{ $kunjungan->dokter->nama_paramedis }}"
                                        data-beratbayi="{{ $kunjungan->diagnosaicd->bb_bayi ?? null }}"
                                        data-kasusbaru="{{ $kunjungan->diagnosaicd->kasus_baru ?? null }}"
                                        data-kunjunganbaru="{{ $kunjungan->diagnosaicd->kunjungan_baru ?? null }}"
                                        data-kurang48="{{ $kunjungan->diagnosaicd->meninggal_kr_48jam ?? null }}"
                                        data-lebih48="{{ $kunjungan->diagnosaicd->meninggal_lb_48jam ?? null }}"
                                        data-diagutama="{{ $kunjungan->diagnosaicd ? ($kunjungan->diagnosaicd->diag_utama ? $kunjungan->diagnosaicd->diag_utama . ' - ' . $kunjungan->diagnosaicd->diag_utama_desc : null) : null }}"
                                        data-diagsekunder1="{{ $kunjungan->diagnosaicd ? ($kunjungan->diagnosaicd->diag_sekunder_01 ? $kunjungan->diagnosaicd->diag_sekunder_01 . ' - ' . $kunjungan->diagnosaicd->diag_sekunder_01_desc : null) : null }}"
                                        data-diagsekunder1="{{ $kunjungan->diagnosaicd ? ($kunjungan->diagnosaicd->diag_sekunder_02 ? $kunjungan->diagnosaicd->diag_sekunder_02 . ' - ' . $kunjungan->diagnosaicd->diag_sekunder_02_desc : null) : null }}"
                                        data-diagsekunder1="{{ $kunjungan->diagnosaicd ? ($kunjungan->diagnosaicd->diag_sekunder_03 ? $kunjungan->diagnosaicd->diag_sekunder_03 . ' - ' . $kunjungan->diagnosaicd->diag_sekunder_03_desc : null) : null }}"
                                        data-diagsekunder1="{{ $kunjungan->diagnosaicd ? ($kunjungan->diagnosaicd->diag_sekunder_04 ? $kunjungan->diagnosaicd->diag_sekunder_04 . ' - ' . $kunjungan->diagnosaicd->diag_sekunder_04_desc : null) : null }}"
                                        data-diagsekunder1="{{ $kunjungan->diagnosaicd ? ($kunjungan->diagnosaicd->diag_sekunder_05 ? $kunjungan->diagnosaicd->diag_sekunder_05 . ' - ' . $kunjungan->diagnosaicd->diag_sekunder_05_desc : null) : null }}"
                                        data-diagpoli="{{ $kunjungan->diagnosapoli->diag_00 ?? null }}" />
                                </td>
                                <td>{{ $kunjungan->tgl_masuk }}</td>
                                <td>
                                    {{ $kunjungan->kode_kunjungan }}
                                </td>
                                <td>{{ $kunjungan->unit->nama_unit }}</td>
                                <td>{{ $kunjungan->dokter->nama_paramedis }}</td>
                                <td>{{ $kunjungan->diagnosapoli->diag_00 ?? '-' }}</td>
                                <td>{{ $kunjungan->diagnosaicd->diag_utama ?? '-' }}</td>
                                <td>{{ $kunjungan->diagnosaicd->diag_sekunder_01 ?? '-' }}</td>
                                <td>{{ $kunjungan->diagnosaicd->diag_sekunder_02 ?? '-' }}</td>
                                <td>{{ $kunjungan->diagnosaicd->diag_sekunder_03 ?? '-' }}</td>
                                <td>{{ $kunjungan->diagnosaicd->diag_sekunder_04 ?? '-' }}</td>
                                <td>{{ $kunjungan->diagnosaicd->diag_sekunder_05 ?? '-' }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </x-adminlte-datatable>
                    <br>
                    Catatan : <br>
                    - Baris Berwana Merah : Belum isi ICD-10 <br>
                @endif
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalKunjungan" title="Kunjungan Pasien" size="xl" icon="fas fa-hand-holding-medical"
        theme="success">
        <form action="{{ route('encounter_update') }}" name="formKunjungan" id="formKunjungan" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input name="kode_kunjungan" label="Kunjungan" fgroup-class="row"
                        label-class="text-left col-3" igroup-size="sm" igroup-class="col-9" igroup-size="sm" readonly />
                    <x-adminlte-input name="no_rm" label="No RM" fgroup-class="row" label-class="text-left col-3"
                        igroup-size="sm" igroup-class="col-9" igroup-size="sm" readonly />
                    <x-adminlte-input name="nama" label="Nama" fgroup-class="row" label-class="text-left col-3"
                        igroup-size="sm" igroup-class="col-9" igroup-size="sm" readonly />
                    <x-adminlte-input name="unit" label="Unit" fgroup-class="row" label-class="text-left col-3"
                        igroup-size="sm" igroup-class="col-9" igroup-size="sm" readonly />
                    <x-adminlte-input name="dokter" label="Dokter" fgroup-class="row" label-class="text-left col-3"
                        igroup-size="sm" igroup-class="col-9" igroup-size="sm" readonly />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="bb_bayi" label="Berat Bayi" fgroup-class="row" type="number"
                        placeholder="Berat Badan Bayi Baru (Gram)" label-class="text-left col-3" igroup-size="sm"
                        igroup-class="col-9" igroup-size="sm" />
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="kasusbaru" name="kasusbaru"
                                value="1">
                            <label for="kasusbaru" class="custom-control-label">Kasus Baru Baru</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="kunjunganbaru" name="kunjunganbaru"
                                value="1">
                            <label for="kunjunganbaru" class="custom-control-label">Kunjungan Baru</label>
                        </div>
                    </div>
                    <b>Status Pasien Meninggal</b> <br>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="kurang48" name="kurang48"
                                value="1">
                            <label for="kurang48" class="custom-control-label">
                                < 48 Jam</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="lebih48" name="lebih48"
                                value="1">
                            <label for="lebih48" class="custom-control-label">> 48 Jam</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <x-adminlte-textarea igroup-size="sm" rows=3 label="Diagnsoa Dari Unit" name="diagpoli">
                    </x-adminlte-textarea>
                    <x-adminlte-select2 multiple fgroup-class="row" label-class="text-left col-3" igroup-size="sm"
                        igroup-class="col-9" igroup-size="sm" name="diag_utama" label="Diag Utama">
                        <option value="">Diagnosa</option>
                    </x-adminlte-select2>
                    <x-adminlte-select2 multiple fgroup-class="row" label-class="text-left col-3" igroup-size="sm"
                        igroup-class="col-9" igroup-size="sm" name="diag_sekunder_01" label="Diag Sekunder 1">
                        <option value="">Diagnosa</option>
                    </x-adminlte-select2>
                    <x-adminlte-select2 multiple fgroup-class="row" label-class="text-left col-3" igroup-size="sm"
                        igroup-class="col-9" igroup-size="sm" name="diag_sekunder_02" label="Diag Sekunder 2">
                        <option value="">Diagnosa</option>
                    </x-adminlte-select2>
                    <x-adminlte-select2 multiple fgroup-class="row" label-class="text-left col-3" igroup-size="sm"
                        igroup-class="col-9" igroup-size="sm" name="diag_sekunder_03" label="Diag Sekunder 3">
                        <option value="">Diagnosa</option>
                    </x-adminlte-select2>
                    <x-adminlte-select2 multiple fgroup-class="row" label-class="text-left col-3" igroup-size="sm"
                        igroup-class="col-9" igroup-size="sm" name="diag_sekunder_04" label="Diag Sekunder 4">
                        <option value="">Diagnosa</option>
                    </x-adminlte-select2>
                    <x-adminlte-select2 multiple fgroup-class="row" label-class="text-left col-3" igroup-size="sm"
                        igroup-class="col-9" igroup-size="sm" name="diag_sekunder_05" label="Diag Sekunder 5">
                        <option value="">Diagnosa</option>
                    </x-adminlte-select2>
                </div>
            </div>
        </form>
        <x-slot name="footerSlot">
            <button type="submit" form="formKunjungan" class="btn btn-success">
                <i class="fas fa-save"></i> Simpan
            </button>
            <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
@stop

@section('plugins.Datatables', true)
@section('plugins.DatatablesFixedColumns', true)
@section('plugins.Select2', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)
@section('js')
    <script>
        $(function() {
            var dataseletc2 = {
                theme: "bootstrap4",
                placeholder: "Diagnosa ICD-10",
                multiple: true,
                maximumSelectionLength: 1,
                ajax: {
                    url: "{{ route('ref_diagnosa_api2') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 100,
                    data: function(params) {
                        return {
                            diagnosa: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            };
            $("#diag_utama").select2(dataseletc2);
            $("#diag_sekunder_01").select2(dataseletc2);
            $("#diag_sekunder_02").select2(dataseletc2);
            $("#diag_sekunder_03").select2(dataseletc2);
            $("#diag_sekunder_04").select2(dataseletc2);
            $("#diag_sekunder_05").select2(dataseletc2);
        });

        function btnKunjungan(button) {
            $.LoadingOverlay("show");
            $('#kode_kunjungan').val($(button).data('kodekunjungan'));
            $('#no_rm').val($(button).data('norm'));
            $('#nama').val($(button).data('nama'));
            $('#unit').val($(button).data('unit'));
            $('#dokter').val($(button).data('dokter'));
            $('#diagpoli').val($(button).data('diagpoli'));
            $('#bb_bayi').val($(button).data('beratbayi'));
            if ($(button).data('diagutama')) {
                $("#diag_utama").empty();
                $('#diag_utama').append(new Option($(button).data('diagutama'), $(button).data('diagutama')));
                $("#diag_utama").val($(button).data('diagutama')).change();
            }
            if ($(button).data('diagsekunder1')) {
                $("#diag_sekunder_01").empty();
                $('#diag_sekunder_01').append(new Option($(button).data('diagsekunder1'), $(button).data('diagsekunder1')));
                $("#diag_sekunder_01").val($(button).data('diagsekunder1')).change();
            }
            if ($(button).data('diagsekunder2')) {
                $("#diag_sekunder_02").empty();
                $('#diag_sekunder_02').append(new Option($(button).data('diagsekunder2'), $(button).data('diagsekunder2')));
                $("#diag_sekunder_02").val($(button).data('diagsekunder2')).change();
            }
            if ($(button).data('diagsekunder3')) {
                $("#diag_sekunder_03").empty();
                $('#diag_sekunder_03').append(new Option($(button).data('diagsekunder3'), $(button).data('diagsekunder3')));
                $("#diag_sekunder_03").val($(button).data('diagsekunder3')).change();
            }
            if ($(button).data('diagsekunder4')) {
                $("#diag_sekunder_04").empty();
                $('#diag_sekunder_04').append(new Option($(button).data('diagsekunder4'), $(button).data('diagsekunder4')));
                $("#diag_sekunder_04").val($(button).data('diagsekunder4')).change();
            }
            if ($(button).data('diagsekunder5')) {
                $("#diag_sekunder_05").empty();
                $('#diag_sekunder_05').append(new Option($(button).data('diagsekunder5'), $(button).data('diagsekunder5')));
                $("#diag_sekunder_05").val($(button).data('diagsekunder5')).change();
            }
            if ($(button).data('kasusbaru')) {
                $("#kasusbaru").attr('checked', true)
            }
            if ($(button).data('kunjunganbaru')) {
                $("#kunjunganbaru").attr('checked', true)
            }
            if ($(button).data('kurang48')) {
                $("#kurang48").attr('checked', true)
            }
            if ($(button).data('lebih48')) {
                $("#lebih48").attr('checked', true)
            }
            $('#modalKunjungan').modal('show');
            $.LoadingOverlay("hide");
        }
    </script>
@endsection
