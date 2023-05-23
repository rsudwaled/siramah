@extends('adminlte::page')
@section('title', 'Order Farmasi')
@section('content_header')
    <h1>Order Farmasi</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Filter Order Farmasi" theme="secondary"
                collapsible="{{ $request->depo ? 'collapsed' : '' }}">
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
                                <option value="4002" {{ $request->depo == 4002 ? 'selected' : '' }}>DEPO FARMSI 1
                                </option>
                                <option value="4008" {{ $request->depo == 4008 ? 'selected' : '' }}>DEPO FARMSI 2
                                </option>
                                <option value="4010" {{ $request->depo == 4010 ? 'selected' : '' }}>DEPO FARMSI 3
                                </option>
                            </x-adminlte-select>
                        </div>
                    </div>
                    <x-adminlte-button type="submit" class="withLoad" theme="primary" label="Submit Pencarian" />
                </form>
            </x-adminlte-card>
            @if ($request->depo)
                <div class="row">
                    <div class="col-md-3">
                        <x-adminlte-small-box title="{{ $orders->count() }}" text="Total Order" icon="fas fa-star"
                            theme="primary" />

                    </div>
                    <div class="col-md-3">
                        <x-adminlte-small-box title="{{ $orders->where('status_order', 2)->count() }}" text="Proses Order"
                            icon="fas fa-star" theme="success" />
                    </div>
                </div>

                <x-adminlte-card
                    title="Data Order Farmasi {{ \Carbon\Carbon::parse($request->tanggal)->format('d M Y') ?? '' }}"
                    theme="primary" collapsible="">
                    {{-- <form action="" name="formOnTracer" id="formOnTracer">
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
                    </form> --}}
                    {{-- <x-adminlte-button type="submit" form="formOnTracer" class="withLoad"
                        theme="{{ $request->tracer == 'ON' ? 'success' : 'secondary' }}" label="ON" />
                    <x-adminlte-button type="submit" form="formOffTracer" class="withLoad mr-2"
                        theme="{{ $request->tracer == 'OFF' ? 'success' : 'secondary' }}" label="OFF" /> --}}
                    @php
                        $heads = ['Waktu Entry', 'No Order', 'No RM', 'Nama', 'Poliklinik', 'Penjamin', 'SEP', 'Tracer', 'Action'];
                        $config['order'] = ['0', 'desc'];
                        $config['paging'] = false;
                        $config['info'] = false;
                        $config['scrollY'] = '200px';
                        $config['scrollCollapse'] = true;
                        $config['scrollX'] = true;
                    @endphp
                    <x-adminlte-datatable id="table1" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
                        hoverable compressed>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($order->tgl_entry)->format('H:m:s') }}</td>
                                <td>{{ $order->kode_layanan_header }}</td>
                                <td>{{ $order->no_rm }}</td>
                                <td>{{ $order->pasien->nama_px }}</td>
                                <td>{{ $order->asal_unit->nama_unit }}</td>
                                <td>{{ $order->penjamin_simrs->nama_penjamin }}</td>
                                <td>{{ $order->kunjungan->no_sep ?? '-' }}</td>
                                <td>
                                    @switch($order->status_order)
                                        @case(1)
                                            <span class="badge badge-danger"> Belum Cetak</span>
                                        @break

                                        @case(2)
                                            <span class="badge badge-warning"> Proses</span>
                                        @break

                                        @case(3)
                                            <span class="badge badge-success"> Selesai</span>
                                        @break

                                        @default
                                    @endswitch
                                </td>
                                <td>
                                    <a href="{{ route('cetakOrderFarmasi') }}?kode={{ $order->kode_layanan_header }}"
                                        class="btn btn-xs btn-warning"><i class="fas fa-print"></i> Cetak
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>

                    <p id="demo"></p>

                </x-adminlte-card>
                <x-adminlte-card
                    title="Proses Order Farmasi {{ \Carbon\Carbon::parse($request->tanggal)->format('d M Y') ?? '' }}"
                    theme="success" collapsible="">
                    @php
                        $heads = ['Waktu Entry', 'No Order', 'No RM', 'Nama', 'Poliklinik', 'Penjamin', 'SEP', 'Tracer', 'Action'];
                        $config['order'] = ['0', 'desc'];
                        $config['paging'] = false;
                        $config['info'] = false;
                        $config['scrollY'] = '400px';
                        $config['scrollCollapse'] = true;
                        $config['scrollX'] = true;
                    @endphp
                    <x-adminlte-datatable id="table2" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
                        hoverable compressed>
                        @foreach ($orders->where('status_order', 2) as $order)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($order->tgl_entry)->format('H:m:s') }}</td>
                                <td>{{ $order->kode_layanan_header }}</td>
                                <td>{{ $order->no_rm }}</td>
                                <td>{{ $order->pasien->nama_px }}</td>
                                <td>{{ $order->asal_unit->nama_unit }}</td>
                                <td>{{ $order->penjamin_simrs->nama_penjamin }}</td>
                                <td>{{ $order->kunjungan->no_sep ?? '-' }}</td>
                                <td>
                                    @switch($order->status_order)
                                        @case(1)
                                            <span class="badge badge-danger"> Belum Cetak</span>
                                        @break

                                        @case(2)
                                            <span class="badge badge-warning"> Proses</span>
                                        @break

                                        @case(3)
                                            <span class="badge badge-success"> Selesai</span>
                                        @break

                                        @default
                                    @endswitch
                                </td>
                                <td>
                                    <a href="{{ route('selesaiOrderFarmasi') }}?kode={{ $order->kode_layanan_header }}"
                                        class="btn btn-xs btn-success"><i class="fas fa-print"></i> Selesai
                                    </a>
                                    <a href="{{ route('cetakOrderFarmasi') }}?kode={{ $order->kode_layanan_header }}"
                                        class="btn btn-xs btn-warning"><i class="fas fa-print"></i> Cetak
                                    </a>
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
                            // name: "John",
                            // time: "2pm"
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
