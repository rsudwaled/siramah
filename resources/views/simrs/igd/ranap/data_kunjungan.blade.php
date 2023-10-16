@extends('adminlte::page')

@section('title', 'Data Kunjungan')
@section('content_header')
    <h1>Data Kunjungan : {{ \Carbon\Carbon::now()->format('Y-m-d') }}</h1>
@stop

@section('content')
    <div class="col-lg-12">
        <x-adminlte-card theme="primary" collapsible title="Daftar Kunjungan :">
            @php
                $heads = ['Pasien', 'Kartu', 'Kunjungan', 'Unit', 'Tgl Masuk', 'Tgl keluar', 'Diagnosa', 'No SEP', 'stts kunj', 'daftar'];
                $config['order'] = ['0', 'asc'];
                $config['paging'] = true;
                $config['info'] = false;
                $config['scrollY'] = '450px';
                $config['scrollCollapse'] = true;
                $config['scrollX'] = true;
            @endphp
            <x-adminlte-datatable id="table" class="text-xs" :heads="$heads" :config="$config" striped bordered
                hoverable compressed>
                @foreach ($kunjungan as $item)
                    <tr
                        style="background-color:{{ $item->pasien->no_Bpjs == null ? 'rgb(213, 171, 171)' : 'rgb(152, 200, 152)' }};">
                        <td>{{ $item->no_rm }} <br>{{ $item->pasien->nama_px }}</td>
                        <td>BPJS : {{ $item->pasien->no_Bpjs }}<br>NIK : {{ $item->pasien->nik_bpjs }}</td>
                        <td>{{ $item->kode_kunjungan }}</td>
                        <td>{{ $item->kode_unit }} ({{ $item->unit->nama_unit }})</td>
                        <td>{{ $item->tgl_masuk }}</td>
                        <td>{{ $item->tgl_keluar == null ? 'pasien belum keluar' : $item->tgl_keluar }}</td>
                        <td>{{ $item->diagx }}</td>
                        <td>{{ $item->no_sep }}</td>
                        <td><button type="button"
                                class="btn {{ $item->status_kunjungan == 2 ? 'btn-block bg-gradient-danger disabled' : ($item->status_kunjungan == 1 ? 'btn-success' : 'btn-success') }} btn-block btn-flat btn-xs">{{ $item->status_kunjungan == 2 ? 'ditutup' : ($item->status_kunjungan == 1 ? 'aktif' : 'kunjungan dibatalkan') }}</button>
                        </td>
                        <td>
                            <a href="{{ route('ranapumum') }}/?no={{ $item->no_rm }}&kun={{ $item->kode_kunjungan }}"
                                class="btn btn-block btn-primary btn-xs btn-flat ">Umum</a>
                            {{-- <a href="{{ route('ranapbpjs') }}/?no={{ $item->no_rm }}&kun={{ $item->kode_kunjungan }}&nobp={{ $item->pasien->no_Bpjs }}"
                                    class="btn btn-block btn-success btn-xs btn-flat ">BPJS</a> --}}
                            @if ($item->pasien->no_Bpjs)
                                <button href="#" data-toggle="modal" data-target="modalSPRI"
                                    data-id="{{ $item->kode_kunjungan }}" data-nomorkartu="{{ $item->pasien->no_Bpjs }}"
                                    class="btn btn-block btn-success btn-xs btn-flat btnModalSPRI">BPJS</button>
                            @endif
                            @if (!$item->no_sep)
                                <a href="#" class="btn btn-block btn-warning btn-xs btn-flat "><b>SEP</b></a>
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
                            if(data.cekSPRI==null)
                            {
                                Swal.fire('PASIEN BELUM PUNYA SPRI. SILAHKAN BUAT SPRI', '', 'info');
                            }else{
                                $('.lanjutkanPROSESDAFTAR').show();
                                $('.btnCreateSPRI').hide();
                                $('.btnCreateSPRIBatal').hide();
                                $('.lanjutkanPROSESDAFTAR').click(function(e) {
                                    location.href = "{{ route('ranapbpjs') }}/?no_kartu=" + data.cekSPRI.noKartu;
                                });
                            }
                        }
                    });
                }
                $('#modalSPRI').modal('toggle');


            });
            $('.btnCreateSPRI').click(function(e) {
                var kodeKunjungan = $("#kodeKunjungan").val();
                var noKartu = $("#noKartu").val();
                var kodeDokter = $("#dokter").val();
                var poliKontrol = $("#poliklinik option:selected").val();
                var tglRencanaKontrol = $("#tanggal").val();
                var user = $("#user").val();
                var url = "{{ route('spri.create') }}";
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

                        } else {
                            Swal.fire(data.metadata.message + '( ERROR : ' + data.metadata
                                .code + ')', '', 'error');
                        }
                    },

                });
            });
        });
    </script>
@endsection
