@extends('simrs.ranap.pdf_print')
@section('title', 'Asesmen Awal Rawat Inap')

@section('content')
    @include('simrs.ranap.pdf_kop_surat')
    @include('simrs.ranap.form_asesmen_ranap_awal')
    {{-- @include('simrs.ranap.table_mppa') --}}
@endsection
