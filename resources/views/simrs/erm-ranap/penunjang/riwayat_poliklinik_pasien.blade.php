<div class="card card-outline card-primary card-riwayat-poliklinik" style="font-size: 12px;">
    <div class="card-header">
        <h3 class="card-title">RIWAYAT POLIKLINIK</h3>
        <div class="card-tools">
            <button class="btn btn-xs btn-danger text-right tutup-tab-riwayat-poliklinik"><i
                    class="far fa-window-close"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="col-12">
            <div id="accordion">
                @foreach ($kunjungan as $riwayat)
                    <div class="card card-info">
                        <div class="card-header">
                            <h4 class="card-title w-100">
                                <a class="d-block w-100 collapsed" data-toggle="collapse"
                                    href="#riwayatKunjunganPoli{{ Carbon\Carbon::parse($riwayat->tgl_masuk)->format('Ymd-his') }}"
                                    aria-expanded="false">
                                    {{ $riwayat->counter }} | {{ $riwayat->unit->nama_unit }}
                                </a>
                            </h4>
                        </div>
                        @php
                            $riwayatAsesmen = App\Models\AsesmenDokterRajal::where(
                                'id_kunjungan',
                                $riwayat->kode_kunjungan,
                            )->first();
                        @endphp
                        <div id="riwayatKunjunganPoli{{ Carbon\Carbon::parse($riwayat->tgl_masuk)->format('Ymd-his') }}"
                            class="collapse" data-parent="#accordion" style="">
                            <div class="card-body">
                                <table class="table table-bordered" id="tableRiwayatObat">
                                    <thead>
                                        <th>Obat</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($semuaObat as $obat)
                                            @if ($obat['NAMA_TARIF'] !== 'Jasa Baca')
                                                <tr>
                                                    <td>{{ $obat['NAMA_TARIF'] }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                                {{-- <table class="table table-bordered">
                                    <thead>
                                        <th>Diagnosa kerja</th>
                                        <th>Pemeriksaan Fisik</th>
                                        <th>Riwayat Alergi</th>
                                        <th>Obat</th>
                                        <th>Tindakan</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $riwayatAsesmen?->diagnosakerja ?? '-' }}</td>
                                            <td>{{ $riwayatAsesmen?->pemeriksaan_fisik ?? '-' }}</td>
                                            <td>{{ $riwayatAsesmen?->riwayat_alergi ?? '-' }}</td>
                                            <td>
                                                <ul>
                                                    @foreach ($semuaObat as $obat)
                                                        @if ($obat['NAMA_TARIF'] !== 'Jasa Baca')
                                                            <li>{{ $obat['NAMA_TARIF'] }}</li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                @foreach ($semuaTindakan as $tindakan)
                                                    <li>{{ $tindakan['NAMA_TARIF'] }}</li>
                                                @endforeach
                                            </td>
                                        </tr>
                                    </tbody>
                                </table> --}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
      $('#tableRiwayatObat').DataTable({
        "scrollY": "300px",   // Set scroll vertikal dengan tinggi 300px
        "scrollCollapse": true, // Memungkinkan scroll collapse saat data kurang
        "paging": false,       // Menonaktifkan paging
        "searching": false       // Menonaktifkan paging
      });
    });
  </script>
