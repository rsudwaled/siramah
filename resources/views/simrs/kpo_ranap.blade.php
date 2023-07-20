@extends('adminlte::page')

@section('title', 'E-KPO Rawat Inap')

@section('content_header')
    <h1>E-KPO Rawat Inap</h1>

@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            {{-- pencarian pasien --}}
            <x-adminlte-card title="Pencarian Pasien" theme="warning" collapsible="">
                <form>
                    <div class="row">
                        <div class="col-md-5">
                            @php
                                $config = ['format' => 'YYYY-MM-DD'];
                            @endphp
                            <x-adminlte-input-date name="tanggal" id="tanggal" label="Tanggal Kunjungan" :config="$config"
                                value="{{ \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d') }}">
                            </x-adminlte-input-date>
                        </div>
                        <div class="col-md-7">
                            <x-adminlte-select name="unit" label="Ruangan">
                                @foreach ($units as $kode => $nama)
                                    <option value="{{ $kode }}" {{ $request->unit == $kode ? 'selected' : null }}>
                                        {{ $nama }}</option>
                                @endforeach
                                <x-slot name="appendSlot">
                                    <x-adminlte-button theme="success" id="btnCariPasien" label="Cari!" />
                                </x-slot>
                            </x-adminlte-select>
                        </div>
                    </div>
                </form>

            </x-adminlte-card>
        </div>

    </div>

    <x-adminlte-modal id="kunjunganPasien" size="xl" title="Daftar Kunjungnan Pasien" theme="success"
        icon="fas fa-user-md">
        <dl class="row">
            <dt class="col-sm-2">Tgl Kunjungan</dt>
            <dd class="col-sm-10">: <span id="tglKunjungan"></span> </dd>
            <dt class="col-sm-2">Unit</dt>
            <dd class="col-sm-10">: <span id="unitKunjungan"></span> </dd>
        </dl>

        <table id="tableKunjunganPasien" class="table table-sm table-hover table-bordered">
            <thead>
                <tr>
                    <th>Tgl Masuk</th>
                    <th>Pasien</th>
                    <th>Unit</th>
                    <th>Dokter</th>
                    <th>No SEP</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </x-adminlte-modal>

@stop

@section('plugins.TempusDominusBs4', true)
@section('plugins.Datatables', true)

@section('js')
    <script>
        $(function() {


            var table = new DataTable('#tableKunjunganPasien', {
                info: false,
                ordering: false,
                paging: false
            });

            $('#btnCariPasien').click(function(e) {
                $.LoadingOverlay("show");
                var unit = $('#unit option:selected').text();
                var tanggal = $('#tanggal').val();
                $('#unitKunjungan').html(unit);
                $('#tglKunjungan').html(tanggal);
                table.rows().remove().draw();
                e.preventDefault();
                var url = "{{ route('kunjunganRanap') }}?unit=" + $('#unit').val();

                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        if (data.metadata.code == 200) {
                            $.each(data.response, function(key, value) {
                                console.log(value);
                                table.row.add([
                                    value.tgl_masuk,
                                    value.no_rm + ' ' + value.pasien.nama_px,
                                    value.unit.nama_unit ?? '-',
                                    value.dokter.nama_paramedis ?? '-',
                                    value.no_sep,
                                    "<button class='btnPilihKunjungan btn btn-success btn-xs' data-id=" +
                                    value.kode_kunjungan +
                                    ">Pilih</button>",
                                ]).draw(false);

                            });

                            $('.btnPilihKunjungan').click(function() {
                                var kodekunjungan = $(this).data('id');
                                alert(kodekunjungan);
                                // $.LoadingOverlay("show");
                                // $('#nomorsep_suratkontrol').val(nomorsep);
                                // $('#modalSEP').modal('hide');
                                // $.LoadingOverlay("hide");
                            });
                        } else {
                            swal.fire(
                                'Error ' + data.metadata.code,
                                data.metadata.message,
                                'error'
                            );
                        }
                        $('#kunjunganPasien').modal('show');
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

        });
    </script>

@endsection
