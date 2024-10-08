<div id="asesmendokter">
    <x-adminlte-card title="Asesmen Dokter" theme="primary" icon="fas fa-user-md">
        <div class="row">
            <div class="col-md-3">
                <table class="table table-xs table-borderless text-nowrap">
                    <tr>
                        <td>Pasien</td>
                        <td>:</td>
                        <th>{{ $kunjungan->pasien->nama_px ?? '-' }}</th>
                    </tr>
                    <tr>
                        <td>Dokter</td>
                        <td>:</td>
                        <th>{{ $kunjungan->dokter->nama_paramedis ?? '-' }}</th>
                    </tr>
                    {{-- <tr>
                        <td>Pasien</td>
                        <td>:</td>
                        <th>{{ $asesmendokter }}</th>
                    </tr> --}}
                    <tr>
                        <td>Tanggal Input</td>
                        <td>:</td>
                        <th>{{ $asesmendokter->tgl_entry ?? '-' }}</th>
                    </tr>
                    <tr>
                        <td>Sumber Data</td>
                        <td>:</td>
                        <th>{{ $asesmendokter->sumber_data ?? '-'}}</th>
                    </tr>
                    <tr>
                        <td>Keluhan Pasien</td>
                        <td>:</td>
                        <th>
                            <pre style="padding: 0px;font-family: sans-serif;font-size: 13px">{{ $asesmendokter->keluhan_pasien?? '-' }}</pre>
                        </th>
                    </tr>
                    <tr>
                        <td>Pemeriksaan Fisik</td>
                        <td>:</td>
                        <th>
                            <pre style="padding: 0px;font-family: sans-serif;font-size: 13px">{{ $asesmendokter->pemeriksaan_fisik?? '-' }}</pre>
                        </th>
                    </tr>
                    <tr>
                        <td>Diagnosa Kerja</td>
                        <td>:</td>
                        <th>
                            <pre style="padding: 0px;font-family: sans-serif;font-size: 13px">{{ $asesmendokter->diagnosakerja?? '-' }}</pre>
                        </th>
                    </tr>
                    <tr>
                        <td>Diagnosa Banding</td>
                        <td>:</td>
                        <th>
                            <pre style="padding: 0px;font-family: sans-serif;font-size: 13px">{{ $asesmendokter->diagnosabanding?? '-' }}</pre>
                        </th>
                    </tr>
                    <tr>
                        <td>Tindakan Medis</td>
                        <td>:</td>
                        <th>
                            <pre style="padding: 0px;font-family: sans-serif;font-size: 13px">{{ $asesmendokter->tindakanmedis?? '-' }}</pre>
                        </th>
                    </tr>
                    <tr>
                        <td>Tindak Lanjut</td>
                        <td>:</td>
                        <th>{{ $asesmendokter->tindak_lanjut?? '-' }}</th>
                    </tr>

                </table>
            </div>
        </div>
    </x-adminlte-card>
</div>
