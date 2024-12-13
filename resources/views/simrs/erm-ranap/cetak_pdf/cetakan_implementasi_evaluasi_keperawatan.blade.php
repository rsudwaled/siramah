@extends('simrs.erm-ranap.template_print.pdf_print')
@section('title', 'Asesmen Awal Rawat Inap')

@section('content')
    @include('simrs.erm-ranap.template_print.pdf_kop_surat')
    @if ($implementasi->isNotEmpty())
        <table class="table table-sm table-bordered" style="font-size: 11px">
            <tr style="background-color: #ffc107">
                <td width="100%" colspan="2" class="text-center">
                    <b>IMPLEMENTASI DAN EVALUASI KEPERAWATAN</b><br>
                </td>
            </tr>
            <tr>
                <td colspan="2" widht="100%">
                    <table class="table table-bordered">
                        <thead>
                            <th>Tanggal</th>
                            <th>Implementasi dan evaluasi</th>
                            <th>User</th>
                            <th>Verifikasi</th>
                        </thead>
                        <tbody>
                            @if (!empty($implementasi))
                                @foreach ($implementasi as $dataImplementasiEvaluasi)
                                    <tr>
                                        <td>{{ Carbon\Carbon::parse($dataImplementasiEvaluasi->tanggal_implementasi_evaluasi)->format('d-m-Y') }} <br>
                                            {{ $dataImplementasiEvaluasi->waktu_implementasi_evaluasi }} WIB
                                        </td>
                                        <td>{{ $dataImplementasiEvaluasi->keterangan_implementasi }}</td>
                                        <td>{{ $dataImplementasiEvaluasi->user_perawat }}</td>
                                        <td>
                                            {{$dataImplementasiEvaluasi->verifikasi==0?'Belum Verifikasi':'Terverifikasi'}} <br>
                                            @if ($dataImplementasiEvaluasi->verifikasi ==1)
                                                <small>{{$dataImplementasiEvaluasi->waktu_verifikasi??'-'}}</small>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
    @else
        <table class="table table-sm table-bordered" style="font-size: 11px">
            <table class="table table-sm table-bordered" style="font-size: 11px">
                <tr style="background-color: #ffc107">
                    <td width="100%" class="text-center">
                        <b>IMPLEMENTASI DAN EVALUASI KEPERAWATAN</b><br>
                    </td>
                </tr>
            </table>
            <tr>
                <td width="100%" class="text-center">
                    <b>Belum Diisi</b><br>
                </td>
            </tr>
        </table>
    @endif
@endsection
