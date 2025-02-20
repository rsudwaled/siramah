@extends('adminlte::page')

@section('title', 'Cari SEP')

@section('content_header')
    <h1>Cari SEP</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Pencarian Data SEP" theme="primary" collapsible>
                <form id="searchForm" method="get">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="No SEP">No SEP</label>
                                <input type="text" class="form-control" name="noSep" id="noSep">
                            </div>
                        </div>

                        <div class="col-4">
                            <button type="submit" class="btn btn-md btn-primary mt-4">Tampilkan</button>
                            <a href="#" class="text-left btn btn-secondary btn-md mt-4 btn-print-sep">Print SEP</a>
                        </div>
                    </div>
                </form>

                <!-- Menampilkan Hasil Pencarian -->
                <div id="tampilaknHasil"></div>
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.TempusDominusBs4', true)

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Tangani pengiriman form (Tombol Tampilkan)
            $('#searchForm').on('submit', function(e) {
                e.preventDefault(); // Mencegah form melakukan refresh halaman

                const noSep = $('#noSep').val(); // Ambil nilai No SEP

                if (!noSep) {
                    showError('No SEP Kosong', 'Harap masukkan No SEP terlebih dahulu.');
                    return;
                }

                // Lakukan pencarian menggunakan AJAX
                $.ajax({
                    url: "{{ route('casemix-cari-sep.get-sep') }}", // Ganti dengan route pencarian Anda
                    method: 'GET',
                    data: {
                        noSep: noSep
                    },
                    beforeSend: function() {
                        $('#tampilaknHasil').html('<p>Loading...</p>');
                    },
                    success: function(response) {
                        // Menampilkan hasil pencarian ke dalam div#tampilaknHasil
                        if (response.html) {
                            // Tempelkan HTML di dalam div
                            $('#tampilaknHasil').html(response.html);

                            // Tampilkan dalam iframe jika Anda menginginkan
                            $('#pdfIframe').attr('src', 'data:text/html;charset=utf-8,' +
                                encodeURIComponent(response.html)).show();
                        } else {
                            $('#tampilaknHasil').html('<p>Data SEP tidak ditemukan.</p>');
                        }
                    },
                    error: function() {
                        $('#tampilaknHasil').html(
                            '<p>Terjadi kesalahan saat mengambil data.</p>');
                    }
                });
            });

            $('.btn-print-sep').click(function(e) {
                e.preventDefault(); // Mencegah aksi default link

                var sep = $('#noSep').val(); // Mengambil data sep dari atribut data-sep
                var url = "{{ route('casemix-cari-sep.get-sep-download') }}"; // URL API tujuan
                Swal.fire({
                    title: "Apakah Anda Yakin Ingin Print SEP?",
                    text: "Pastikan data SEP sudah benar!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Print SEP!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Menyusun URL dengan query string setelah konfirmasi
                        var urlWithParams = url + '?noSep=' + encodeURIComponent(sep);

                        // Membuka halaman di tab baru dengan data di query string
                        window.open(urlWithParams, '_blank');
                    }
                });
            });
        });

        // Fungsi untuk menampilkan pesan error dengan SweetAlert
        function showError(title, text) {
            Swal.fire({
                icon: 'error',
                title: title,
                text: text
            });
        }
    </script>


@endsection
