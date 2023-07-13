@extends('adminlte::page')
@section('title', 'Tracer Order Obat')
@section('content_header')
    <h1>Tracer Order Obat {{ $request->depo ? 'Depo ' . $request->depo . ' Lantai ' . $request->lantai : '' }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Filter Antrian Offline Pasien" theme="secondary" collapsible="">
                <form action="" method="get">
                    <div class="row">
                        <div class="col-md-6">
                            @php
                                $config = ['format' => 'YYYY-MM-DD'];
                            @endphp
                            <x-adminlte-input-date name="tanggal" label="Tanggal Antrian Pasien" :config="$config"
                                value="{{ \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d') }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-select name="depo" label="Depo Farmasi">
                                <x-adminlte-options :options="[
                                    4008 => 'FARMASI DEPO 2',
                                    4002 => 'FARMASI DEPO 1',
                                ]" :selected="$request->depo ?? 1" />
                            </x-adminlte-select>
                        </div>
                    </div>
                    <x-adminlte-button type="submit" class="withLoad" theme="primary" label="Submit Pencarian" />
                </form>
            </x-adminlte-card>
            @if ($request->depo)
                <x-adminlte-card title="Filter Antrian Offline Pasien" theme="secondary" collapsible="">
                    <form action="" name="formOnTracer" id="formOnTracer">
                        <input type="hidden" name="tanggal" value="{{ $request->tanggal }}">
                        <input type="hidden" name="depo" value="{{ $request->depo }}">
                        <input type="hidden" name="lantai" value="{{ $request->lantai }}">
                        <input type="hidden" name="tracer" value="ON">
                    </form>
                    <form action="" name="formOffTracer" id="formOffTracer">
                        <input type="hidden" name="tanggal" value="{{ $request->tanggal }}">
                        <input type="hidden" name="depo" value="{{ $request->depo }}">
                        <input type="hidden" name="lantai" value="{{ $request->lantai }}">
                        <input type="hidden" name="tracer" value="OFF">
                    </form>
                    <x-adminlte-button type="submit" form="formOnTracer" class="withLoad"
                        theme="{{ $request->tracer == 'ON' ? 'success' : 'secondary' }}" label="ON" />
                    <x-adminlte-button type="submit" form="formOffTracer" class="withLoad mr-2"
                        theme="{{ $request->tracer == 'OFF' ? 'success' : 'secondary' }}" label="OFF" />
                    <a href="" class="btn btn-warning"> <i class="fas fa-sync"></i> Refresh</a>
                    @php
                        $heads = ['Id', 'Tgl Entry', 'Pasien (RM)', 'Poliklinik', 'Dokter', 'Penjamin', 'SEP', 'Antrian', 'Tracer', 'Action'];
                        $config['order'] = ['0', 'desc'];
                        $config['paging'] = false;
                        $config['info'] = false;
                        $config['scrollY'] = '400px';
                        $config['scrollCollapse'] = true;
                        $config['scrollX'] = true;
                    @endphp
                    <x-adminlte-datatable id="table1" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
                        hoverable compressed>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ substr($order->kode_layanan_header, 12) }}</td>
                                <td>{{ $order->tgl_entry }}</td>
                                <td>{{ $order->pasien->nama_px }} ({{ $order->no_rm }})</td>
                                <td>{{ $order->asal_unit->nama_unit }}</td>
                                <td>{{ $order->dokter->nama_paramedis }}</td>
                                <td>{{ $order->penjamin_simrs->nama_penjamin }}</td>
                                <td>{{ $order->kunjungan->no_sep ?? '-' }}</td>
                                <td>
                                    {{ $order->kunjungan->antrian->kodebooking ?? '-' }}
                                </td>
                                <td>
                                    @if ($order->status_order == 1)
                                        <span class="badge badge-danger"> Belum Cetak</span>
                                    @else
                                        <span class="badge badge-success"> Sudah Cetak</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btnObat btn btn-xs btn-primary"
                                        data-id="{{ $order->id }}"><i class="fas fa-info-circle"></i> Lihat</button>

                                    <a href="{{ route('cetakUlangOrderObat') }}?kode={{ $order->kode_layanan_header }}"
                                        class="btn btn-xs btn-warning"><i class="fas fa-sync"></i>Cetak
                                        Ulang</a>
                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                    <p id="demo"></p>
                </x-adminlte-card>
                <x-adminlte-modal id="modalObat" title="Order Obat Pasien" size="lg" theme="success"
                    icon="fas fa-user-plus">
                    <dl class="row">
                        <dt class="col-sm-3">Kode Order</dt>
                        <dd class="col-sm-8">: <span id="kodelayananheader"></span></dd>

                    </dl>
                    <table id="tableResep" class="table table-sm table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>kode_barang</th>
                                <th>jumlah_layanan</th>
                                <th>aturan_pakai</th>
                                <th>satuan_barang</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <x-slot name="footerSlot">
                        {{-- <x-adminlte-button class="mr-auto btnSuratKontrol" label="Buat Surat Kontrol" theme="primary"
                            icon="fas fa-prescription-bottle-alt" />
                        <a href="#" id="lanjutFarmasi" class="btn btn-success withLoad"> <i
                                class="fas fa-prescription-bottle-alt"></i>Farmasi Non-Racikan</a>
                        <a href="#" id="lanjutFarmasiRacikan" class="btn btn-success withLoad"> <i
                                class="fas fa-prescription-bottle-alt"></i>Farmasi Racikan</a>
                        <a href="#" id="selesaiPoliklinik" class="btn btn-warning withLoad"> <i
                                class="fas fa-check"></i> Selesai</a> --}}
                        <x-adminlte-button theme="danger" label="Tutup" data-dismiss="modal" />
                    </x-slot>
                    </form>
                </x-adminlte-modal>
            @endif
        </div>
    </div>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)

@section('js')
    <script>
        $(document).ready(function() {
            url = "{{ route('getOrderObat') }}";
            const element = document.getElementById("demo");
            var tracer = "{{ $request->tracer }}";
            if (tracer === "ON") {
                setInterval(function() {
                    var dt = new Date($.now());
                    var time = "{{ $request->tanggal }}" + ' ' + dt.getHours() + ":" + dt.getMinutes() +
                        ":" + dt
                        .getSeconds();
                    $.get(url, {
                            tanggal: "{{ $request->tanggal }}",
                            depo: "{{ $request->depo }}"
                        })
                        .done(function(data) {
                            console.log(data);
                            element.innerHTML = time + " " + data.metadata.message + " <br>";
                        })
                        .fail(function(data) {
                            console.log(data);
                            element.innerHTML = time + " ERROR <br>";
                        });
                }, 3 * 1000);
            } else if (tracer === "OFF") {
                setInterval(function() {
                    var dt = new Date($.now());
                    var time = "{{ $request->tanggal }}" + ' ' + dt.getHours() + ":" + dt.getMinutes() +
                        ":" + dt
                        .getSeconds();
                    element.innerHTML = time + " OFF <br>";
                }, 3 * 1000);
            } else {

            }
        });
        $('.btnObat').click(function() {
            var orderid = $(this).data('id');
            $.LoadingOverlay("show");
            var table = $('#tableResep').DataTable();
            table.rows().remove().draw();
            var url = "{{ route('getOrderResep') }}?id=" + orderid;
            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    if (data.metadata.code == 200) {
                        console.log(data);
                        $.each(data.response.reseps, function(key, value) {
                            console.log(value);
                            table.row.add([
                                value.kode_barang,
                                value.jumlah_layanan,
                                value.aturan_pakai,
                                value.satuan_barang,
                            ]).draw(false);
                        });
                        // $('.btnPilihSEP').click(function() {
                        //     var nomorsep = $(this).data('id');
                        //     $.LoadingOverlay("show");
                        //     $('#nomorsep_suratkontrol').val(nomorsep);
                        //     $('#modalSEP').modal('hide');
                        //     $.LoadingOverlay("hide");
                        // });
                    } else {
                        swal.fire(
                            'Error ' + data.metadata.code,
                            data.metadata.message,
                            'error'
                        );
                    }
                    $('#modalObat').modal('show');
                    $.LoadingOverlay("hide");
                },
                error: function(data) {
                    console.log(data);
                    // swal.fire(
                    //     'Error ' + data.metadata.code,
                    //     data.metadata.message,
                    //     'error'
                    // );
                    $.LoadingOverlay("hide");
                }
            });

        });
    </script>
@endsection
