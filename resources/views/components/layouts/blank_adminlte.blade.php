@extends('adminlte::master')
@section('title', 'Anjungan Mandiri')
@section('body')
    <div class="wrapper">
        {{ $slot }}
    </div>
@stop
@section('plugins.Datatables', true)

@section('adminlte_css')
    <style>
        body {
            background-color: yellow;
        }
    </style>
@endsection
@section('adminlte_js')
    <script src="{{ asset('vendor/moment/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/loading-overlay/loadingoverlay.min.js') }}"></script>
    <script src="{{ asset('vendor/onscan.js/onscan.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    {{-- scan --}}
    <script>
        $(function() {
            onScan.attachTo(document, {
                onScan: function(sCode, iQty) {
                    $.LoadingOverlay("show", {
                        text: "Mencari kodebooking " + sCode + "..."
                    });
                    var url = "{{ route('checkinAntrian') }}?kodebooking=" + sCode;
                    window.location.href = url;
                    // $.LoadingOverlay("show", {
                    //     text: "Printing..."
                    // });
                    // var url = "{{ route('checkinUpdate') }}";
                    // var formData = {
                    //     kodebooking: sCode,
                    //     waktu: "{{ \Carbon\Carbon::now()->timestamp * 1000 }}",
                    // };
                    // $('#kodebooking').val(sCode);
                    // $.get(url, formData, function(data) {
                    //     console.log(data);
                    //     $.LoadingOverlay("hide");
                    //     if (data.metadata.code == 200) {
                    //         $('#status').html(data.metadata.message);
                    //         swal.fire(
                    //             'Sukses...',
                    //             data.metadata.message,
                    //             'success'
                    //         ).then(okay => {
                    //             if (okay) {
                    //                 $.LoadingOverlay("show", {
                    //                     text: "Reload..."
                    //                 });
                    //                 $('#status').html('-');
                    //                 location.reload();
                    //             }
                    //         });
                    //     } else {
                    //         $('#status').html(data.metadata.message);
                    //         swal.fire(
                    //             'Opss Error...',
                    //             data.metadata.message,
                    //             'error'
                    //         ).then(okay => {
                    //             if (okay) {
                    //                 $.LoadingOverlay("show", {
                    //                     text: "Reload..."
                    //                 });
                    //                 $('#status').html('-');
                    //                 location.reload();
                    //             }
                    //         });
                    //     }
                    // });
                },
            });
        });
    </script>
    {{-- withLoad --}}
    <script>
        $(function() {
            $(".withLoad").click(function() {
                $.LoadingOverlay("show");
            });
        })
        $('.reload').click(function() {
            location.reload();
        });
    </script>
@section('plugins.Sweetalert2', true)
@include('sweetalert::alert')
@stop
