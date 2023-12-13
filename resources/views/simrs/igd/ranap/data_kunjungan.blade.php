@extends('adminlte::page')

@section('title', 'Data Kunjungan')
@section('content_header')
    <h1>Data Pasien Rawat Inap</h1>
@stop

@section('content')
    <div class="col-lg-12">
        <x-adminlte-card theme="primary" collapsible title="Daftar Kunjungan Rawat Inap :">
            @php
                $heads = ['Pasien', 'Kunjungan', 'Tgl Masuk', 'Diagnosa Assesment', 'No SEP', 'Status', 'Aksi'];
                $config['order'] = false;
                $config['paging'] = true;
                $config['info'] = false;
                $config['scrollY'] = '450px';
                $config['scrollCollapse'] = true;
                $config['scrollX'] = true;
            @endphp
            <x-adminlte-datatable id="table" class="text-xs" :heads="$heads" :config="$config" striped bordered
                hoverable compressed>
                @foreach ($kunjungan as $item)
                    <tr style="background-color:{{ $item->noKartu == null ? 'rgb(213, 171, 171)' : 'rgb(152, 200, 152)' }};">
                        <td><b>{{ $item->rm }} </b><br>{{ $item->pasien }} <br>BPJS : {{ $item->noKartu }}<br>NIK :
                            {{ $item->nik }}</td>
                        <td>{{ $item->kunjungan }} ({{ $item->nama_unit }})</td>
                        <td>{{ $item->tgl_kunjungan }}</td>
                        <td>{{ $item->diagnosa_assesment }}</td>
                        <td>{{ $item->sep }}</td>
                        <td>
                            <button type="button"
                                class="btn {{ $item->stts_kunjungan == 2 ? 'btn-block bg-gradient-danger disabled' : ($item->stts_kunjungan == 1 ? 'btn-success' : 'btn-block bg-gradient-danger disabled') }} btn-block btn-flat btn-xs">{{ $item->stts_kunjungan == 2 ? 'ditutup' : ($item->stts_kunjungan == 1 ? 'aktif' : 'kunjungan dibatalkan') }}</button>
                        </td>
                        <td>
                            @if ($item->stts_kunjungan == 1)
                                <a href="{{ route('ranapumum') }}/?no={{ $item->rm }}&kun={{ $item->kunjungan }}"
                                    class="btn btn-block btn-primary btn-xs btn-flat ">Umum</a>
                                @if ($item->noKartu)
                                    <button href="#" data-toggle="modal" data-target="modalSPRI"
                                        data-id="{{ $item->kunjungan }}" data-nomorkartu="{{ $item->noKartu }}"
                                        class="btn btn-block btn-success btn-xs btn-flat btnModalSPRI">BPJS</button>
                                @endif
                                <button href="#" data-toggle="modal" data-target="detailRanap"
                                    data-id="{{ $item->kunjungan }}" data-nomorkartu="{{ $item->noKartu }}"
                                    class="btn btn-block bg-purple btn-xs btn-flat btnDetailRanap">Detail</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </x-adminlte-card>
    </div>
    <x-adminlte-modal id="modalSPRI" title="Buat SPRI terlebih dahulu" theme="primary" size='lg' disable-animations>
        <form>
            <input type="hidden" name="user" id="user" value="{{ Auth::user()->name }}">
            <input type="hidden" name="kodeKunjungan" id="kodeKunjungan">
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input name="noKartu" id="noKartu" label="No Kartu" disabled />
                </div>
                <div class="col-md-6">
                    @php
                        $config = ['format' => 'YYYY-MM-DD'];
                    @endphp
                    <x-adminlte-input-date name="tglRencanaKontrol" id="tanggal"
                        value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" label="Tanggal Masuk" :config="$config" />
                </div>
                <div class="col-md-6">
                    <x-adminlte-select2 name="poliKontrol" label="poliKontrol" id="poliklinik">
                        <option selected disabled>Cari Poliklinik</option>
                    </x-adminlte-select2>
                </div>
                <div class="col-md-6">
                    <x-adminlte-select2 name="kodeDokter" label="Dokter DPJP" id="dokter">
                        <option value="">--Pilih Dpjp--</option>
                        @foreach ($paramedis as $item)
                            <option value="{{ $item->kode_dokter_jkn }}">
                                {{ $item->nama_paramedis }}</option>
                        @endforeach
                    </x-adminlte-select2>
                </div>
            </div>
            <x-slot name="footerSlot">
                <x-adminlte-button type="submit" theme="success" form="formSPRI" class="btnCreateSPRI" label="Buat SPRI" />
                <x-adminlte-button theme="danger" label="batal" class="btnCreateSPRIBatal" data-dismiss="modal" />
                <x-adminlte-button class="btn bg-gradient-maroon btn-md lanjutkanPROSESDAFTAR"
                    label="ADA PROSES YANG BELUM SELESAI, LANJUTKAN PROSES SEKARANG !!" />
            </x-slot>
        </form>
    </x-adminlte-modal>
    <x-adminlte-modal id="detailRanap" title="Detail Kunjungan" theme="success" size='xl' disable-animations>
        <form>
            <div class="row">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                Reprehenderit porro alias nisi error natus et culpa dolorum maxime, quae, harum repudiandae sequi voluptatum
                reiciendis laborum libero?
                Vitae sit neque optio!
            </div>
        </form>
    </x-adminlte-modal>
@stop
@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)
@section('js')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#poliklinik").select2({
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('ref_poliklinik_api') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        console.log(params);
                        return {
                            poliklinik: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
            $('.btnModalSPRI').click(function(e) {
                var kunjungan = $(this).data('id');
                var noKartu = $(this).data('nomorkartu');
                $('#noKartu').val(noKartu);
                $('#kodeKunjungan').val(kunjungan);
                $('.lanjutkanPROSESDAFTAR').hide();
                if ($('#modalSPRI').show()) {
                    var url = "{{ route('cekprosesdaftar.spri') }}?noKartu=" + noKartu;
                    $.ajax({
                        type: "GET",
                        url: url,
                        dataType: 'JSON',
                        success: function(data) {
                            console.log(data.cekSPRI);
                            if (data.cekSPRI == null) {
                                Swal.fire('PASIEN BELUM PUNYA SPRI. SILAHKAN BUAT SPRI', '',
                                    'info');
                            } else {
                                $('.lanjutkanPROSESDAFTAR').show();
                                $('.btnCreateSPRI').hide();
                                $('.btnCreateSPRIBatal').hide();
                                $('.lanjutkanPROSESDAFTAR').click(function(e) {
                                    location.href =
                                        "{{ route('ranapbpjs') }}/?no_kartu=" + data
                                        .cekSPRI.noKartu;
                                });
                            }
                        }
                    });
                }
                $('#modalSPRI').modal('toggle');
            });
            $('.btnDetailRanap').click(function(e) {
                $('#detailRanap').modal('toggle');
            });
            $('.btnCreateSPRI').click(function(e) {
                var kodeKunjungan = $("#kodeKunjungan").val();
                var noKartu = $("#noKartu").val();
                var kodeDokter = $("#dokter").val();
                var poliKontrol = $("#poliklinik option:selected").val();
                var tglRencanaKontrol = $("#tanggal").val();
                var user = $("#user").val();
                var url = "{{ route('spri.create') }}";
                $.LoadingOverlay("show");
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        noKartu: noKartu,
                        kodeDokter: kodeDokter,
                        poliKontrol: poliKontrol,
                        tglRencanaKontrol: tglRencanaKontrol,
                        kodeKunjungan: kodeKunjungan,
                        user: user,
                    },
                    success: function(data) {

                        if (data.metadata.code == 200) {
                            Swal.fire('SPRI BERHASIL DIBUAT', '', 'success');
                            $("#createSPRI").modal('toggle');
                            location.href = "{{ route('ranapbpjs') }}/?no_kartu=" + noKartu;
                            $.LoadingOverlay("hide");
                        } else {
                            Swal.fire(data.metadata.message + '( ERROR : ' + data.metadata
                                .code + ')', '', 'error');
                            $.LoadingOverlay("hide");
                        }
                    },

                });
            });
        });
    </script>
@endsection
