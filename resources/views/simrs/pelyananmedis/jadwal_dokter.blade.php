@extends('adminlte::page')
@section('title', 'Jadwal Dokter Poliklinik')
@section('content_header')
    <h1>Jadwal Dokter Poliklinik</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Referensi Jadwal Dokter HAFIS" icon="fas fa-calendar-alt" theme="secondary"
                collapsible="{{ $request->kodepoli ? '' : 'collapsed' }}">
                <div class="row">
                    <div class="col-md-4">
                        <form action="">
                            @php
                                $config = ['format' => 'YYYY-MM-DD'];
                            @endphp
                            <x-adminlte-input-date name="tanggal" value="{{ $request->tanggal }}"
                                placeholder="Silahkan Pilih Tanggal" label="Tanggal Periksa" :config="$config" />
                            <x-adminlte-select2 name="kodepoli" id="kodepoli" label="Poliklinik">
                                @foreach ($polikliniks->where('status', 1) as $poli)
                                    <option value="{{ $poli->kodesubspesialis }}"
                                        {{ $request->kodepoli == $poli->kodesubspesialis ? 'selected' : null }}>
                                        {{ $poli->namasubspesialis }} ({{ $poli->kodesubspesialis }})</option>
                                @endforeach
                            </x-adminlte-select2>
                            <x-adminlte-button label="Cari Jadwal HAFIS" class="mr-auto withLoad" type="submit"
                                theme="primary" icon="fas fa-search" />
                            <x-adminlte-button label="Tambah Jadwal" class="mr-auto" id="createJadwal" theme="success"
                                icon="fas fa-plus" />
                        </form>
                    </div>
                    <div class="col-md-8">
                        @php
                            $heads = ['No.', 'Hari', 'Jadwal', 'Poliklinik', 'Subspesialis', 'Dokter', 'Kuota', 'Action'];
                        @endphp
                        <x-adminlte-datatable id="table2" class="text-xs" :heads="$heads" hoverable bordered
                            compressed>
                            @isset($jadwals)
                                @foreach ($jadwals as $jadwal)
                                    <tr class="{{ $jadwal->libur ? 'table-danger' : null }}  ">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $jadwal->namahari }} {{ $jadwal->libur ? 'LIBUR' : null }} </td>
                                        <td>{{ $jadwal->jadwal }}</td>
                                        <td>{{ $jadwal->namapoli }} ({{ $jadwal->kodepoli }})</td>
                                        <td>{{ $jadwal->namasubspesialis }} ({{ $jadwal->kodesubspesialis }})</td>
                                        <td>{{ $jadwal->namadokter }} ({{ $jadwal->kodedokter }})</td>
                                        <td>{{ $jadwal->kapasitaspasien }}</td>
                                        <td>

                                            <form action="{{ route('jadwaldokter.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="kodepoli" value="{{ $jadwal->kodepoli }}">
                                                <input type="hidden" name="namapoli" value="{{ $jadwal->namapoli }}">
                                                <input type="hidden" name="kodesubspesialis"
                                                    value="{{ $jadwal->kodesubspesialis }}">
                                                <input type="hidden" name="namasubspesialis"
                                                    value="{{ $jadwal->namasubspesialis }}">
                                                <input type="hidden" name="kodedokter" value="{{ $jadwal->kodedokter }}">
                                                <input type="hidden" name="namadokter" value="{{ $jadwal->namadokter }}">
                                                <input type="hidden" name="hari" value="{{ $jadwal->hari }}">
                                                <input type="hidden" name="namahari" value="{{ $jadwal->namahari }}">
                                                <input type="hidden" name="jadwal" value="{{ $jadwal->jadwal }}">
                                                <input type="hidden" name="kapasitaspasien"
                                                    value="{{ $jadwal->kapasitaspasien }}">
                                                <input type="hidden" name="libur" value="{{ $jadwal->libur }}">

                                                @if ($jadwal_antrian->where('kodesubspesialis', $jadwal->kodesubspesialis)->where('kodedokter', $jadwal->kodedokter)->where('hari', $jadwal->hari)->first())
                                                    @if ($jadwal_antrian->where('kodesubspesialis', $jadwal->kodesubspesialis)->where('kodedokter', $jadwal->kodedokter)->where('hari', $jadwal->hari)->where('kapasitaspasien', $jadwal->kapasitaspasien)->first())
                                                        <button class="btn btn-secondary btn-xs">Sudah Ada</button>
                                                    @else
                                                        <button type="submit" class="btn btn-warning btn-xs">Update</button>
                                                    @endif
                                                @else
                                                    <button type="submit" class="btn btn-success btn-xs">Tambah</button>
                                                @endif

                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endisset
                        </x-adminlte-datatable>
                    </div>
                </div>
            </x-adminlte-card>
        </div>
        <div class="col-12">
            <x-adminlte-card title="Jadwal Dokter Polilinik" theme="success" icon="fas fa-calendar-alt" collapsible>
                @php
                    $heads = ['Nama Poliklinik Subspesialis', 'Dokter', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    $config['paging'] = false;
                @endphp
                <x-adminlte-datatable id="table1" class="nowrap text-xs" :heads="$heads" :config="$config" striped
                    bordered hoverable compressed>
                    @foreach ($polikliniks->where('subspesialis', 0)->where('status', 1) as $poli)
                        @foreach ($poli->jadwals->groupby('kodedokter') as $jadwals)
                            <tr>
                                <td>{{ $polikliniks->firstWhere('kodesubspesialis', $jadwals->first()->kodesubspesialis)->namasubspesialis }}
                                </td>
                                <td>{{ $jadwals->first()->namadokter }} </td>
                                @for ($i = 1; $i <= 6; $i++)
                                    <td>
                                        @foreach ($jadwals as $jadwal)
                                            @if ($jadwal->hari == $i)
                                                @if ($jadwal->libur == 1)
                                                    <x-adminlte-button
                                                        label="{{ $jadwal->jadwal }} / {{ $jadwal->kapasitaspasien }}"
                                                        class="btn-xs mb-1 btnJadwal" theme="danger" data-toggle="tooltip"
                                                        title="Jadwal Dokter" data-id="{{ $jadwal->id }}" />
                                                @else
                                                    <x-adminlte-button
                                                        label="{{ $jadwal->jadwal }} / {{ $jadwal->kapasitaspasien }}"
                                                        class="btn-xs mb-1 btnJadwal" theme="warning" data-toggle="tooltip"
                                                        title="Jadwal Dokter" data-id="{{ $jadwal->id }}" />
                                                @endif
                                            @endif
                                        @endforeach
                                    </td>
                                @endfor
                            </tr>
                        @endforeach
                    @endforeach
                    {{-- @foreach ($jadwal_antrian->groupby('kodedokter') as $item)
                        <tr>
                            <td>
                                {{ strtoupper($item->first()->namasubspesialis) }}
                                ({{ $item->first()->kodesubspesialis }})
                            </td>
                            <td>{{ $item->first()->namadokter }} ({{ $item->first()->kodedokter }})</td>
                            @for ($i = 1; $i <= 6; $i++)
                                <td>
                                    @foreach ($item as $jadwal)
                                        @if ($jadwal->hari == $i)
                                            @if ($jadwal->libur == 1)
                                                <x-adminlte-button
                                                    label="{{ $jadwal->jadwal }} / {{ $jadwal->kapasitaspasien }}"
                                                    class="btn-xs mb-1 btnJadwal" theme="danger" data-toggle="tooltip"
                                                    title="Jadwal Dokter" data-id="{{ $jadwal->id }}" />
                                            @else
                                                <x-adminlte-button
                                                    label="{{ $jadwal->jadwal }} / {{ $jadwal->kapasitaspasien }}"
                                                    class="btn-xs mb-1 btnJadwal" theme="warning" data-toggle="tooltip"
                                                    title="Jadwal Dokter" data-id="{{ $jadwal->id }}" />
                                            @endif
                                        @endif
                                    @endforeach
                                </td>
                            @endfor
                        </tr>
                    @endforeach --}}
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalJadwal" title="Jadwal Praktek" theme="warning" icon="fas fa-calendar-alt">
        @if ($errors->any())
            <x-adminlte-alert title="Ops Terjadi Masalah !" theme="danger" dismissable>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-adminlte-alert>
        @endif
        <form name="formUpdateJadwal" id="formUpdateJadwal" method="POST">
            @csrf
            <input type="hidden" name="_method" id="_method">
            <input type="hidden" class="idjadwal" name="idjadwal" id="idjadwal">
            <x-adminlte-select2 name="kodesubspesialis" label="Poliklinik">
                @foreach ($polikliniks as $poli)
                    <option value="{{ $poli->kodesubspesialis }}"
                        {{ $request->kodepoli == $poli->kodesubspesialis ? 'selected' : null }}>
                        {{ $poli->namasubspesialis }} ({{ $poli->kodesubspesialis }})</option>
                @endforeach
            </x-adminlte-select2>
            <x-adminlte-select2 name="kodedokter" label="Dokter">
                @foreach ($dokters as $item)
                    <option value="{{ $item->kodedokter }}">{{ $item->namadokter }}</option>
                @endforeach
            </x-adminlte-select2>
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-select name="hari" label="Poliklinik">
                        <option value="1">SENIN</option>
                        <option value="2">SELASA</option>
                        <option value="3">RABU</option>
                        <option value="4">KAMIS</option>
                        <option value="5">JUMAT</option>
                        <option value="6">SABTU</option>
                        <option value="7">MINGGU</option>
                    </x-adminlte-select>
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="jadwal" label="Jam Praktek" placeholder="Jam Praktek" enable-old-support />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="kapasitaspasien" label="Kapasitas Pasien" placeholder="Kapasitas Pasien"
                        enable-old-support />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input-switch name="libur" label="Libur" data-on-text="YES" data-off-text="NO"
                        data-on-color="primary" />
                </div>
            </div>
        </form>
        <form name="formDeleteJadwal" id="formDeleteJadwal" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" class="idjadwal" name="idjadwal" id="idjadwal">
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button label="Update" form="formUpdateJadwal" class="mr-auto withLoad" type="submit"
                theme="success" icon="fas fa-edit" />
            <x-adminlte-button label="Hapus" form="formDeleteJadwal" class="withLoad" type="submit" theme="danger"
                icon="fas fa-trash-alt" />
            <x-adminlte-button theme="danger" icon="fas fa-times" label="Close" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
@stop

@section('plugins.Select2', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Datatables', true)
@section('plugins.DateRangePicker', true)
@section('plugins.BootstrapSwitch', true)
@section('js')
    <script>
        $(function() {
            $('#createJadwal').click(function() {
                $.LoadingOverlay("show");
                $('#modalJadwal').modal('show');
                $.LoadingOverlay("hide");
            });

            $('.btnJadwal').click(function() {
                var jadwalid = $(this).data('id');
                $.LoadingOverlay("show");
                $.get("{{ route('jadwaldokter.index') }}" + '/' + jadwalid,
                    function(data) {
                        console.log(data);
                        // delete form
                        var urlDelete = "{{ route('jadwaldokter.index') }}/" + jadwalid;
                        $('#formDeleteJadwal').attr('action', urlDelete);

                        var urlUpdate = "{{ route('jadwaldokter.index') }}/" + jadwalid;
                        $('#formUpdateJadwal').attr('action', urlUpdate);
                        $('#_method').val('PUT');


                        $('#kodesubspesialis').val(data.kodesubspesialis).change();
                        $('#kodedokter').val(data.kodedokter).change();
                        $('#hari').val(data.hari).change();
                        $('#kapasitaspasien').val(data.kapasitaspasien);
                        $('#jadwal').val(data.jadwal);
                        $('#labeljadwal').html("Jadwal ID : " + data.id);
                        $('.idjadwal').val(data.id);
                        if (data.libur == 1) {
                            $('#libur').prop('checked', true).trigger('change');
                        } else {
                            $('#libur').prop('checked', false).trigger('change');
                        }
                        $.LoadingOverlay("hide", true);
                        $('#modalJadwal').modal('show');
                    })

            });
        });
    </script>
@endsection
