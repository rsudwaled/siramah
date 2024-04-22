@extends('simrs.ranap.pdf_print')
@section('title', 'Evaluasi Awal MPP Form A')

@section('content')
    @include('simrs.ranap.pdf_kop_surat')
    @include('simrs.ranap.table_mppa')
@endsection
