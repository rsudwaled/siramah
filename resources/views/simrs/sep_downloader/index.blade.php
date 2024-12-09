@extends('adminlte::page')
@section('title', 'SEP DOWNLOADER')
@section('content_header')<h1>SEP DOWNLOADER <h1>@endsection

        @section('content')
            <div class="row">
                <div class="col-md-12">
                    <x-adminlte-card title="Filter Data SEP" theme="secondary" collapsible>
                        <form action="" method="get" id="formSepDownloader">
                            <div class="row">
                                <div class="col-md-2">
                                    <select name="bulan" class="form-control">
                                        <option value="01" {{ $request->bulan == '01' ? 'selected' : '' }}>JANUARI
                                        </option>
                                        <option value="02" {{ $request->bulan == '02' ? 'selected' : '' }}>FEBRUARI
                                        </option>
                                        <option value="03" {{ $request->bulan == '03' ? 'selected' : '' }}>MARET
                                        </option>
                                        <option value="04" {{ $request->bulan == '04' ? 'selected' : '' }}>APRIL
                                        </option>
                                        <option value="05" {{ $request->bulan == '05' ? 'selected' : '' }}>MEI</option>
                                        <option value="06" {{ $request->bulan == '06' ? 'selected' : '' }}>JUNI</option>
                                        <option value="07" {{ $request->bulan == '07' ? 'selected' : '' }}>JULI</option>
                                        <option value="08" {{ $request->bulan == '08' ? 'selected' : '' }}>AGUSTUS
                                        </option>
                                        <option value="09" {{ $request->bulan == '09' ? 'selected' : '' }}>SEPTEMBER
                                        </option>
                                        <option value="10" {{ $request->bulan == '10' ? 'selected' : '' }}>OKTOBER
                                        </option>
                                        <option value="11" {{ $request->bulan == '11' ? 'selected' : '' }}>NOVEMBER
                                        </option>
                                        <option value="12" {{ $request->bulan == '12' ? 'selected' : '' }}>DESEMBER
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="tahun" class="form-control">
                                        <option value="2024" {{ $request->tahun == '2024' ? 'selected' : '' }}>2024
                                        </option>
                                        <option value="2025" {{ $request->tahun == '2025' ? 'selected' : '' }}>2025
                                        </option>
                                        <option value="2026" {{ $request->tahun == '2026' ? 'selected' : '' }}>2026
                                        </option>
                                    </select>
                                </div>
                                <x-adminlte-button type="submit" class="withLoad" class="col-2" theme="primary"
                                    label="Cari" />
                                {{-- <x-adminlte-button type="submit" class="withLoad" class="col-3" theme="success"
                                    onclick="javascript: form.action='{{ route('simrs.sep-downloader.downloadAll') }}';"
                                    form="formSepDownloader" label="download All" />
                                <x-adminlte-button type="submit" class="withLoad" class="col-2" theme="warning"
                                    onclick="javascript: form.action='{{ route('simrs.sep-downloader.downloadSingle') }}';"
                                    form="formSepDownloader" label="download" /> --}}
                            </div>
                        </form>
                    </x-adminlte-card>
                </div>
                <div class="col-md-12">
                    <x-adminlte-card title="Data SEP" theme="primary" icon="fas fa-info-circle" collapsible>
                        @php
                            $heads = [
                                'No',
                                'Tgl Masuk',
                                'Tgl Keluar',
                                'Nama',
                                'Jenis',
                                'SEP',
                                'Rujukan',
                                'Kelas',
                                'Penjamin',
                                'Aksi',
                            ];
                        @endphp
                        <x-adminlte-datatable id="table1" class="nowrap" :heads="$heads" bordered hoverable compressed>
                            @foreach ($sep as $datasep)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $datasep->tgl_masuk }}</td>
                                    <td>{{ $datasep->tgl_keluar }}</td>
                                    <td>{{ $datasep->nama_px }}</td>
                                    <td>{{ $datasep->jenis }}</td>
                                    <td>{{ $datasep->sepnoSep }}</td>
                                    <td>{{ $datasep->sepnoRujukan }}</td>
                                    <td>{{ $datasep->sephakkelas }}</td>
                                    <td>{{ $datasep->sepjnsPeserta }}</td>
                                    <td>
                                        <a href="{{ route('simrs.sep-downloader.download', ['id'=>$datasep->idx]) }}" class="btn btn-success btn-sm"> Download</a>
                                    </td>
                                </tr>
                            @endforeach
                        </x-adminlte-datatable>
                    </x-adminlte-card>
                </div>
            </div>
        @endsection
        @section('plugins.Datatables', true)
        @section('plugins.TempusDominusBs4', true)
        @section('plugins.DateRangePicker', true)
        @section('adminlte_js')
            <script>
                $(document).ready(function() {
                    $('#table1').DataTable({
                        "scrollY": "400px", // Set the max height of the table (change as necessary)
                        "scrollCollapse": true, // Allow the table to collapse when there are fewer rows than the max height
                        "paging": false // Disable pagination since scrolling is being used
                    });
                });
            </script>
        @endsection
