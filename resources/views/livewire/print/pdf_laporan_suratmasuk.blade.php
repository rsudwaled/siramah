@extends('livewire.print.pdf_layout')
@section('title', 'Resume Rawat Jalan')

@section('content')
    <table class="table table-sm" style="font-size: 9px; border-bottom: 1px solid black">
        <tr>
            <td width="10%" class="text-center" style="vertical-align: top;">
                <img src="{{ public_path('rswaled.png') }}" style="height: 50px;">
                {{-- <img src="{{ asset('rswaled.png') }}" style="height: 30px;"> --}}
            </td>
            <td width="50%" style="vertical-align: top;">
                <b>RSUD WALED KABUPATEN CIREBON</b><br>
                Jl. Prabu Kiansantang No.4<br>
                Desa Waled Kota, Kec. Waled, Kabupaten Cirebon, Jawa Barat 45187<br>
                www.rsdudwaled.id
            </td>
        </tr>
    </table>
    <h2  style="font-size: 11px;">Laporan Surat Masuk Periode {{ Carbon\Carbon::parse($request->tanggal)->format('F Y')  }}</h2>
    <table class="table table-xs table-bordered"  style="font-size: 9px;">
        <thead>
            <tr>
                <th>No Urut</th>
                <th>Kode</th>
                <th>No Surat</th>
                <th>Asal Surat</th>
                <th>Perihal Surat</th>
                <th>Tgl Disposisi</th>
                <th>Pengolah</th>
                <th>Tanda Terima</th>
                <th>Tgl Selesai</th>
            </tr>
        </thead>
        <tbody>
            @if ($suratmasuks)
                @foreach ($suratmasuks as $item)
                    <tr>
                        <td>{{ $item->id_surat_masuk }}</td>
                        <td>{{ $item->kode }}</td>
                        <td>{{ $item->no_surat }}</td>
                        <td>{{ $item->asal_surat }}</td>
                        <td>
                            {{ $item->perihal }}
                            {{-- <pre style="padding: 0px">{{ $item->perihal }}</pre> --}}
                        </td>
                        <td>{{ $item->tgl_disposisi }}</td>
                        <td>{{ $item->pengolah }}</td>
                        <td>{{ $item->tanda_terima }}</td>
                        <td>{{ $item->tgl_terima_surat }}</td>
                    </tr>
                @endforeach
            @endif

        </tbody>
    </table>
    <style>
        @page {
            size: "A4 landscape";
            /* Misalnya ukuran A4 */
        }
    </style>
@endsection
