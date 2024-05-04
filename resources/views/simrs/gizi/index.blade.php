@extends('adminlte::page')
@section('title', 'Pelayanan Gizi')
@section('content_header')
    <h1>Pelayanan Gizi </h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-3">
            <x-adminlte-card title="Filter Data Pasien Ranap Aktif" theme="purple" collapsible>
                <form action="{{ route('simrs.gizi.index') }}" method="get">
                    <div class="row">
                        <div class="col-lg-12 float-right">
                            <x-adminlte-select2 name="unit" required id="unit" label="Pilih Unit">
                                @foreach ($unit as $item)
                                    <option value="{{ $item->kode_unit }}">{{ $item->nama_unit }}</option>
                                @endforeach
                            </x-adminlte-select2>
                            <x-adminlte-button type="submit" class="withLoad  btn btn-sm m-1 bg-purple"
                                label="Lihat Data" />
                        </div>
                    </div>
                </form>
            </x-adminlte-card>
        </div>
        <div class="col-9">
            <x-adminlte-card title="Data Pasien Aktif" theme="purple" collapsible>
                @if (isset($pasien))
                    @php
                        $heads = ['PASIEN', 'ALAMAT', 'PENJAMIN', 'RUANGAN', 'AKSI'];
                        $config['order'] = false;
                        $config['paging'] = false;
                        $config['info'] = false;
                        $config['scrollY'] = '600px';
                        $config['scrollCollapse'] = true;
                        $config['scrollX'] = true;
                    @endphp
                    <x-adminlte-datatable id="table" class="text-xs" :heads="$heads" head-theme="dark"
                        :config="$config" striped bordered hoverable compressed>
                        @foreach ($pasien as $item)
                            <tr>
                                <td>
                                    <b>
                                        {{ $item->NO_RM }} <br>
                                        {{ $item->nama_px }}
                                    </b>
                                    <br>
                                    {{ $item->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}
                                </td>
                                <td><small>{!! wordwrap($item->alamat, 50, "<br>\n") !!}</small></td>
                                <td>{{ $item->nama_penjamin }}</td>
                                <td>
                                    <strong>{{ $item->kamar }} No. {{ $item->no_bed }}</strong> <br>
                                    Kelas : {{ $item->kelas }} <br>
                                </td>
                                <td>
                                    <x-adminlte-button type="submit" data-kunjungan="{{ $item->kode_kunjungan }}"
                                        data-counter="{{ $item->counter }}" theme="primary" type="button"
                                        class="btn-xs btn-assesment" label="Assesment" />
                                    {{-- <a href="{{route('simrs.gizi.add.assesment')}}" class="btn btn-xs btn-primary">Assesment</a> --}}
                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                @endif
            </x-adminlte-card>
        </div>
    </div>
@endsection

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
            $('.btn-assesment').click(function(e) {
                var counter = $(this).data('counter');
                var kunjungan = $(this).data('kunjungan');
                var route = "{{ route('simrs.gizi.add.assesment') }}";
                Swal.fire({
                    title: "Apakah Anda Yakin?",
                    text: "assesment data ini!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya!",
                    cancelButtonText: "Batal!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.LoadingOverlay("show");
                        $.ajax({
                            type: 'POST',
                            url: route,
                            data: {
                                counter: counter,
                                kunjungan: kunjungan,
                            },
                            dataType: 'json',
                            success: function(response) {
                                // Redirect ke view yang ditentukan dalam respons
                                window.location.href = response;
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                                // Handle error jika terjadi
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
@section('css')

@endsection
