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
                        $heads = ['Id', 'Tgl Entry', 'No Order', 'Pasien (RM)', 'Poliklinik', 'Dokter', 'Penjamin', 'SEP', 'Tracer', 'Action'];
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
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->tgl_entry }}</td>
                                <td>{{ $order->kode_layanan_header }}</td>
                                <td>{{ $order->pasien->nama_px }} ({{ $order->no_rm }})</td>
                                <td>{{ $order->asal_unit->nama_unit }}</td>
                                <td>{{ $order->dokter->nama_paramedis }}</td>
                                <td>{{ $order->penjamin_simrs->nama_penjamin }}</td>
                                <td>{{ $order->kunjungan->no_sep ?? '-' }}</td>
                                <td>
                                    @if ($order->status_order == 1)
                                        <span class="badge badge-danger"> Belum Cetak</span>
                                    @else
                                        <span class="badge badge-success"> Sudah Cetak</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('cetakUlangOrderObat') }}?kode={{ $order->kode_layanan_header }}"
                                        class="btn btn-xs btn-warning"><i class="fas fa-sync"></i>Cetak
                                        Ulang</a>
                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                    <p id="demo"></p>
                </x-adminlte-card>
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
                            element.innerHTML = time + " OK <br>";
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
    </script>

@endsection
