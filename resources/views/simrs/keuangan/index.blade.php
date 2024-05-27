@extends('adminlte::page')

@section('title', 'Dashboard Keuangan')
@section('content_header')
    <h1>Dashboard Keuangan</h1>
@stop

@section('content')
    <div class="col-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Filter Data</h3>
            </div>
            <div class="card-body">
                <form id="formFilter" action="" method="get">
                    @php
                        $config = ['format' => 'YYYY-MM-DD'];
                    @endphp
                    <div class="row">
                        <div class="col-md-4">
                            <x-adminlte-input-date name="from" id="from" label="Periode Awal" :config="$config"
                                value="{{ $from == null ? \Carbon\Carbon::parse($request->dari)->format('Y') : $from }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                        <div class="col-md-4">
                            <x-adminlte-input-date name="to" id="to" label="Periode Akhir" :config="$config"
                                value="{{ $to == null ? \Carbon\Carbon::parse($request->sampai)->format('Y') : $to }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                        <div class="col-md-4">
                            <x-adminlte-select2 name="kode_paramedis" required id="kode_paramedis" label="Pilih Dokter">
                                <option value=" "> -Semua Kode-</option>
                                @foreach ($paramedis as $kode)
                                    <option value="{{ $kode->kode_paramedis }}"
                                        {{ $kode->kode_paramedis == $dokterFind->kode_paramedis ? 'selected' : '' }}>
                                        {{ $kode->kode_paramedis }} |
                                        {{ $kode->nama_paramedis }}</option>
                                @endforeach
                            </x-adminlte-select2>
                        </div>
                    </div>
                    <x-adminlte-button type="submit" class="withLoad float-right btn btn-sm" theme="primary"
                        label="Lihat Laporan" />
                </form>
            </div>
        </div>
        @if (isset($findReport))
            <div class="invoice p-3 mb-3">

                <div class="row">
                    <div class="col-12">
                        <h4>
                            <i class="fas fa-user-md"></i> {{ $dokterFind->nama_paramedis }}.
                            <small class="float-right">Periode: {{ Carbon\Carbon::parse($from)->format('d-m') }} /
                                {{ Carbon\Carbon::parse($to)->format('d-m-Y') }}</small>
                        </h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 table-responsive">
                        @php
                            $heads = [
                                '#',
                                'Tanggal',
                                'Pasien',
                                'Pelayanan',
                                'Unit',
                                'Jumlah',
                                'Nominal',
                                'Cara Bayar',
                                'Nama Tarif',
                            ];
                            $config['order'] = [['1', 'asc']];
                            $config['fixedColumns'] = [
                                'leftColumns' => 3,
                            ];
                            $config['paging'] = false;
                            $config['scrollX'] = true;
                            $config['scrollY'] = '500px';
                        @endphp
                        <x-adminlte-datatable id="table1" class="nowrap text-xs" :heads="$heads" :config="$config"
                            bordered hoverable compressed>
                            @php
                                $totalLayanan = 0;
                                $totalGrantotal = 0;
                            @endphp
                            @foreach ($findReport as $report)
                                <tr style="background-color: rgb(216, 221, 216);">
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input checkbox datacheck"
                                                value="{{ $report->JS }}" id="datacheck" name="datacheck[]">
                                        </div>
                                    </td>
                                    <td>{{ $report->TGL }}</td>
                                    <td>
                                        RM : {{ $report->rm }} <br>
                                        <b>{{ $report->NAMA_PX }}</b>
                                    </td>
                                    <td><span
                                            class="badge {{ $report->ket == 'Rawat Jalan' ? 'badge-primary' : 'badge-success' }}">{{ $report->ket }}</span>
                                    </td>
                                    <td>{{ $report->NAMA_UNIT }}</td>
                                    <td>{{ $report->jumlah_layanan }}</td>
                                    <td>{{ $report->grantotal_layanan }}</td>
                                    <td>
                                        {{ $report->CARA_BAYAR }} <i class="fas fa-long-arrow-alt-right"></i>
                                        {{ $report->NAMA_PENJAMIN }}
                                    </td>
                                    <td>{!! wordwrap($report->NAMA_TARIF, 40, "<br>\n") !!}</td>
                                </tr>
                                @php
                                    $totalLayanan += $report->jumlah_layanan;
                                    $totalGrantotal += $report->grantotal_layanan;
                                @endphp
                            @endforeach
                        </x-adminlte-datatable>
                    </div>

                </div>
                <div class="row">

                    <div class="col-8">
                        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                            - jumlah visit dari dokter yang terpilih dan jumlah total nominal yang diterima oleh dokter
                            terpilih.
                        </p>
                    </div>

                    <div class="col-4">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th style="width:50%">Jumlah Visit:</th>
                                        <td id="totalLayanan">0</td>
                                    </tr>
                                    <tr>
                                        <th>Jumlah Honor</th>
                                        <td id="totalGrantotal">0</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <input type="hidden" name="totalVisit" id="totalVisit">
                    <input type="hidden" name="totalSalary" id="totalSalary">
                </div>
                <div class="row no-print">
                    <div class="col-12">
                        <button type="button" class="btn btn-success float-right" id="save-checked"><i
                                class="far fa-credit-card"></i> Simpan
                            Data Terpilih
                        </button>
                        {{-- <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                            <i class="fas fa-download"></i> Generate PDF
                        </button> --}}
                    </div>
                </div>
            </div>
        @endif

    </div>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.DatatablesFixedColumns', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)
@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mengambil semua checkbox
            var checkboxes = document.querySelectorAll('.checkbox');

            // Mendefinisikan fungsi untuk menghitung total layanan
            function calculateTotal() {
                var totalLayanan = 0;
                var totalGrantotal = 0;

                checkboxes.forEach(function(checkbox) {
                    if (checkbox.checked) {
                        // Ambil data layanan dan grantotal dari baris yang terceklis
                        var row = checkbox.closest('tr');
                        var layanan = parseInt(row.cells[5].textContent);
                        var grantotal = parseInt(row.cells[6].textContent);

                        // Tambahkan nilai ke total
                        totalLayanan += layanan;
                        totalGrantotal += grantotal;
                    }
                });

                // Tampilkan total layanan dan grantotal layanan
                document.getElementById('totalLayanan').textContent = totalLayanan;
                document.getElementById('totalGrantotal').textContent = totalGrantotal;
                // For form elements, set the value property
                document.getElementById('totalVisit').value = totalLayanan;
                document.getElementById('totalSalary').value = totalGrantotal;
            }

            // Panggil fungsi calculateTotal setiap kali checkbox berubah
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', calculateTotal);
            });

            // Hitung total awal ketika halaman dimuat
            calculateTotal();
        });
        $(document).ready(function() {
            // Event listener for submit button click
            $('#save-checked').click(function() {
                var url = "{{ route('simrs.keuangan.copy_totable') }}";
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var selectedRowIds = [];

                // Iterate through each checked checkbox
                $('.checkbox:checked').each(function() {
                    // Extract the ID from the checkbox's value attribute
                    var rowId = $(this).val();
                    selectedRowIds.push(rowId);
                });
                Swal.fire({
                    title: "Apakah Anda Yakin?",
                    text: "untuk untuk approve salary dan visit dokter terpilih!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Approve!",
                    cancelButtonText: "Batal!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.LoadingOverlay("show");
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': csrfToken // Include the CSRF token in the headers
                            },
                            url: url,
                            method: 'POST',
                            data: {
                                selectedRowIds: selectedRowIds,
                                totalVisit: $('#totalVisit').val(),
                                totalSalary: $('#totalSalary').val(),
                                from: $('#from').val(),
                                to: $('#to').val(),
                                kode_paramedis: $('#kode_paramedis').val(),
                            },
                            success: function(data) {
                                if (data.code == 400) {
                                    Swal.fire({
                                        title: "DATA GAGAL TERKIRIM!",
                                        text: '',
                                        icon: "error",
                                        confirmButtonText: "oke!",
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                    $.LoadingOverlay("hide");
                                }
                                if (data.code == 200) {
                                    Swal.fire({
                                        title: "DATA BERHASIL DI SIMPAN!",
                                        text: '',
                                        icon: "success",
                                        confirmButtonText: "oke!",
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                    $.LoadingOverlay("hide");
                                }
                            },
                            error: function(xhr, status, error) {
                                // Handle error
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
