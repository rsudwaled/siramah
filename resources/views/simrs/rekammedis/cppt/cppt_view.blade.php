@extends('adminlte::page')
@section('title', 'CPPT')
@section('content_header')
    <h1>Catatan Perkembangan Pasien Terintegrasi </h1>
@endsection

@section('content')
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-6">
                <x-adminlte-card title="Assesmen awal Keperawatan" theme="info" collapsible>
                    LIHAT DATA CATATAN PERKEMBANGAN PASIEN ANETESI <br><br>
                    <form action="" method="get">
                        <x-adminlte-select2 name="rm" required id="kunjungan_pasien" label="No RM">
                            <option value=" "> -Kunjungan Pasien-</option>
                            <option value="22230586">22230586 (k)</option>
                            <option value="22231199">22231199</option>
                            <option value="22234502">22234502</option>
                            <option value="22222320">TATI SUNARTI 1</option>
                            <option value="22222963">TATI SUNARTI 2</option>
                            <option value="22228334">TATI SUNARTI 3</option>
                            <option value="22233632">TATI SUNARTI 4</option>
                        </x-adminlte-select2>
                        <button type="submit" target="_blank" id="formAnestesi" class="btn btn-success mr-auto">Lihat
                            Data</button>
                    </form>

                </x-adminlte-card>
            </div>
            <div class="col-lg-6">
                <x-adminlte-card title="Assesmen awal Medis" theme="purple" collapsible>
                    LIHAT DATA CATATAN PERKEMBANGAN PASIEN TERINTEGRASI RAJAL <br><br>
                    <form method="GET">
                        <div class="row mb-3">
                            <div class="col-3">
                                <label class="form-label">No RM</label>
                            </div>
                            <div class="col-9">
                                <select class="custom-select" name="rm" id="rm">
                                    <option selected>---Pilih RM---</option>
                                    <option value="23980204">23980204</option>
                                    <option value="18869192">18869192</option>
                                    <option value="18868414">18868414</option>
                                    <option value="19896168">19896168</option>
                                    <option value="23979917">23979917</option>
                                    <option value="23975243">23975243</option>
                                    <option value="18864423">18864423</option>
                                    <option value="17823083">17823083</option>
                                    <option value="19884952">19884952</option>
                                    <option value="23979132">TATI SUNARTI</option>
                                    <option value="23978253">SAPRIJAL </option>
                                    <option value="23980884">PASIEN RADIOLOGI 1 </option>
                                    <option value="22947447">PASIEN RADIOLOGI 2</option>
                                    <option value="23982005">PASIEN 1</option>
                                    <option value="23981926">PASIEN 2</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-3">
                                <label class="form-label">Kode Unit</label>
                            </div>
                            <div class="col-9">
                                <select class="custom-select" name="kode_unit" id="kode_unit"></select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-3">
                                <label class="form-label">Counter</label>
                            </div>
                            <div class="col-9">
                                <select class="custom-select" name="counter" id="counter"></select>
                            </div>
                        </div>
                        <button type="submit" target="_blank" id="getDataResume" class="btn btn-success mr-auto">Lihat
                            Data</button>
                    </form>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@endsection

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.TempusDominusBs4', true)
@section('js')
    <script>
        $(document).ready(function() {
            $('#formAnestesi').click(function() {
                var kode_kunjungan = $('#kunjungan_pasien').val();
                var url = "{{ route('cppt-anestesi-print.get') }}?kode_kunjungan=" + kode_kunjungan;
                window.open(url, '_blank');
                return false;
            });
        });

        $('#rm').change(function() {
            var rm = $(this).val();
            if (rm) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('resume-dokter-k.get') }}?rm=" + rm,
                    dataType: 'JSON',
                    success: function(res) {
                        if (res) {
                            $("#kode_unit").empty();
                            $("#kode_unit").append('<option>---Pilih Kode Unit---</option>');
                            $.each(res, function(key, value) {
                                $("#kode_unit").append('<option value="' + value.kode_unit +
                                    '">' + 'Kunjungan:' + value.id_kunjungan +
                                    ' | Kode Unit:' + value.kode_unit + '</option>');
                            });
                        } else {
                            $("#counter").empty();
                            $("#kode_unit").empty();
                        }
                    }
                });
            } else {
                $("#counter").empty();
                $("#kode_unit").empty();
            }
        });
        $('#kode_unit').change(function() {
            var id_kunjungan = $("#kode_unit").val();
            var rm = $("#rm").val();
            if (id_kunjungan) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('resume-dokter-c.get') }}?id_kunjungan=" + id_kunjungan + '&rm=' + rm,
                    dataType: 'JSON',
                    success: function(res) {
                        if (res) {
                            $("#counter").empty();
                            $("#counter").append('<option>---Pilih Counter---</option>');
                            $.each(res, function(key, value) {
                                $("#counter").append('<option value="' + value.counter + '">' +
                                    'counter: ' + value.counter + '</option>');
                            });
                        } else {
                            $("#counter").empty();
                        }
                    }
                });
            } else {
                $("#counter").empty();
            }
        });

        $('#getDataResume').click(function() {
            var rm = $('#rm').val();
            var counter = $('#counter').val();
            var kode_unit = $('#kode_unit').val();
            var url = "{{ route('cppt-rajal-print.get') }}?rm=" + rm + "&counter=" + counter + "&kode_unit=" +
                kode_unit;
            window.open(url, '_blank');
            return false;
        });
    </script>
@endsection
