<div id="rincianbiaya">
    <x-adminlte-card title="Rincian Biaya" theme="primary" icon="fas fa-file-invoice-dollar">
        <div class="row">
            {{-- <div class="col-md-4">
                <table class="table table-responsive table-xs table-borderless text-nowrap">
                    <tr>
                        <td>Prosedur Non-Bedah</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'PROSEDURE NON BEDAH')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                    <tr>
                        <td>Prosedur Bedah</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'PROSEDURE BEDAH')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                    <tr>
                        <td>Konsultasi</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'KONSULTASI')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                    <tr>
                        <td>Tenaga Ahli</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'TENAGA AHLI')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                    <tr>
                        <td>Keperawatan</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'KEPERAWATAN')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                    <tr>
                        <td>Penunjang</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'PENUNJANG MEDIS')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                    <tr>
                        <td>Radiologi</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'RADIOLOGI')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                    <tr>
                        <td>Laboratorium</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'LABORATORIUM')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                    <tr>
                        <td>Pelayanan Darah</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'PELAYANAN DARAH')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                    <tr>
                        <td>Rehabilitasi</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'REHABILITASI MEDIK')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                    <tr>
                        <td>Rawat Intensif</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'RAWAT INTENSIF')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                    <tr>
                        <td>Kamar/Akomodasi</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'KAMAR/AKOMODASI')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                    <tr>
                        <td>Sewa Alat</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'SEWA ALAT')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>

                    <tr>
                        <td>Obat</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'OBAT')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                    <tr>
                        <td>Obat Kronis</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'OBAT KRONIS')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                    <tr>
                        <td>Alkes</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'ALKES')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                    <tr>
                        <td>BMHP</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'BMHP')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                    <tr>
                        <td>Obat Kemoterapi</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'OBAT KEMOTERAPI')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                </table>
            </div> --}}
            <div class="col-md-12">
                <table class="table table-hover table-xs table-bordered text-nowrap">
                    <tr  class="table-secondary">
                        <th>Kelompok</th>
                        <th>Layanan / Tindakan</th>
                        <th>Unit</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Sub-Total</th>
                    </tr>
                    @foreach ($rincians->groupBy('KELOMPOK_TARIF') as $key => $item)
                        <tr class="table-secondary">
                            <th colspan="5">{{ strtoupper($key) }}</th>
                            <th class="text-right">{{ money($item->sum('GRANTOTAL_LAYANAN'), 'IDR') }}</th>
                        </tr>
                        @foreach ($item as $layanan)
                            <tr>
                                <td></td>
                                <td>
                                    {{ $layanan->NAMA_TARIF }}<br>
                                    {{ $layanan->NAMA_PARAMEDIS }}
                                </td>
                                <td>{{ $layanan->NAMA_UNIT }}</td>
                                <td>{{ $layanan->JUMLAH_LAYANAN }}</td>
                                <td class="text-right">{{ money($layanan->GRANTOTAL_LAYANAN, 'IDR') }}</td>
                                <td></td>

                            </tr>
                        @endforeach
                    @endforeach
                    <tr class="table-secondary">
                        <th colspan="5">TOTAL BIAYA PASIEN</th>
                        <th class="text-right">{{ money($rincians->sum('GRANTOTAL_LAYANAN'), 'IDR') }}</th>
                    </tr>
                </table>
            </div>
            <div class="col-md-4">
                <table class="table table-responsive table-xs table-borderless text-nowrap">
                    <tr>
                        <td>Prosedur Non-Bedah</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'PROSEDURE NON BEDAH')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                    <tr>
                        <td>Tenaga Ahli</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'TENAGA AHLI')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                    <tr>
                        <td>Radiologi</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'RADIOLOGI')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                    <tr>
                        <td>Rehabilitasi</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'REHABILITASI MEDIK')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                    <tr>
                        <td>Obat</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'OBAT')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                    <tr>
                        <td>Alkes</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'ALKES')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                </table>
            </div>
            <div class="col-md-4">
                <table class="table table-responsive table-xs table-borderless text-nowrap">
                    <tr>
                        <td>Prosedur Bedah</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'PROSEDURE BEDAH')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                    <tr>
                        <td>Keperawatan</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'KEPERAWATAN')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                    <tr>
                        <td>Laboratorium</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'LABORATORIUM')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                    <tr>
                        <td>Kamar/Akomodasi</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'KAMAR/AKOMODASI')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                    <tr>
                        <td>Obat Kronis</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'OBAT KRONIS')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                    <tr>
                        <td>BMHP</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'BMHP')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                </table>
            </div>
            <div class="col-md-4">
                <table class="table table-responsive table-xs table-borderless text-nowrap">
                    <tr>
                        <td>Konsultasi</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'KONSULTASI')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                    <tr>
                        <td>Penunjang</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'PENUNJANG MEDIS')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                    <tr>
                        <td>Pelayanan Darah</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'PELAYANAN DARAH')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                    <tr>
                        <td>Rawat Intensif</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'RAWAT INTENSIF')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                    <tr>
                        <td>Obat Kemoterapi</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'OBAT KEMOTERAPI')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                    <tr>
                        <td>Sewa Alat</td>
                        <td>:</td>
                        <th class="text-right">
                            {{ money($rincians->where('nama_group_vclaim', 'SEWA ALAT')->sum('GRANTOTAL_LAYANAN'), 'IDR') }}
                        </th>
                    </tr>
                </table>
            </div>
            <div class="col-md-12 text-center">
                <h6>Tarif Rumah Sakit : <b>{{ money($rincians->sum('GRANTOTAL_LAYANAN'), 'IDR') }}</b></h6>
            </div>
        </div>
    </x-adminlte-card>
</div>
