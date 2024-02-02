<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cRiwayat" aria-expanded="true">
        <h3 class="card-title">
            Riwayat Kunjungan
        </h3>
    </a>
    <div id="cRiwayat" class="show collapse" role="tabpanel">
        <div class="card-body">
            @php
                $heads = ['Data Registrasi', 'Anamnesa', 'Penunjang', 'Pemeriksaan Dokter', 'Obat'];
                $config['searching'] = false;
                $config['ordering'] = false;
                $config['paging'] = false;
                $config['info'] = false;
                $config['scrollY'] = '500px';
            @endphp
            <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" bordered hoverable compressed>
                @foreach ($kunjungans->sortByDesc('tgl_masuk') as $item)
                    <tr>
                        <td width="10%">
                            {{ $item->counter }} / {{ $item->kode_kunjungan }} <br>
                            {{ \Carbon\Carbon::parse($item->tgl_masuk)->format('d/m/Y h:m:s') }}
                            @if ($item->tgl_keluar)
                                - {{ $item->tgl_keluar }}
                            @endif <br>
                            <b> {{ $item->unit->nama_unit }}</b><br>
                            {{ $item->dokter->nama_paramedis }}<br>
                            @if ($item->status_kunjungan == 1)
                                <span class="badge badge-success">Kunjungan Aktif</span>
                            @endif
                        </td>
                        <td width="30%">
                            @if ($item->assesmen_perawat)
                                <dl>
                                    <dt>Keluhan Utama :</dt>
                                    <dd>
                                        {{ $item->assesmen_perawat->keluhanutama }}
                                    </dd>
                                    <dt>Tanda Vital :</dt>
                                    <dd>
                                        Tekanan Darah : {{ $item->assesmen_perawat->tekanandarah }}
                                        <br>
                                        Frekuensi Nadi :
                                        {{ $item->assesmen_perawat->frekuensinadi }} <br>
                                        Frekuensi Nafas :
                                        {{ $item->assesmen_perawat->frekuensinapas }} <br>
                                        Tinggi / Berat Badan :
                                        {{ $item->assesmen_perawat->tinggibadan }} cm /
                                        {{ $item->assesmen_perawat->beratbadan }} kg<br>
                                        Suhu Tubuh :
                                        {{ $item->assesmen_perawat->suhutubuh }} <br>
                                    </dd>
                                    <dt>Rencana Keperawatan :</dt>
                                    <dd>
                                        {{ $item->assesmen_perawat->rencanakeperawatan }}
                                    </dd>
                                    <dt>Tindakan Keperawatan :</dt>
                                    <dd>
                                        {{ $item->assesmen_perawat->tindakankeperawatan }}
                                    </dd>
                                    <dt>Diagnosis Keperawatan :</dt>
                                    <dd>
                                        {{ $item->assesmen_perawat->diagnosis }}
                                    </dd>
                                </dl>
                            @endif
                        </td>
                        <td width="10%">
                            @foreach ($item->layanans->where('kode_unit', 3002) as $lab)
                                <div class="btn btn-xs btn-primary btnHasilLab"
                                    data-fileurl="http://192.168.2.74/smartlab_waled/his/his_report?hisno={{ $lab->kode_layanan_header }}">
                                    Hasil {{ $lab->kode_layanan_header }}</div>
                                <br>
                                @foreach ($lab->layanan_details as $laydet)
                                    - {{ $laydet->tarif_detail->tarif->NAMA_TARIF }} <br>
                                @endforeach
                            @endforeach
                        </td>
                        <td width="30%">
                            @if ($item->assesmen_dokter)
                                <dl>
                                    <dt>Diagnosa </dt>
                                    <dd>Diagnosa Kerja :
                                        {{ $item->assesmen_dokter->diagnosakerja }} <br>
                                        Diagnosa Banding :
                                        {{ $item->assesmen_dokter->diagnosabanding }}</dd>
                                    <dt>Rencana Kerja </dt>
                                    <dd>{{ $item->assesmen_dokter->rencanakerja }}</dd>
                                    <dt>Keluhan Pasien </dt>
                                    <dd>{{ $item->assesmen_dokter->keluhan_pasien }}</dd>
                                    <dt>Keluhan Pasien </dt>
                                    <dd>{{ $item->assesmen_dokter->pemeriksaan_fisik }}</dd>
                                    <dt>Tindak Lanjut </dt>
                                    <dd>{{ $item->assesmen_dokter->tindak_lanjut }} <br>
                                        {{ $item->assesmen_dokter->keterangan_tindak_lanjut }}
                                    </dd>
                                    <dt>Tindak Lanjut </dt>
                                    <dd>{{ $item->assesmen_dokter->tindakanmedis }}</dd>
                                </dl>
                            @endif
                            {{-- {{ $item->assesmen_dokter }} --}}
                        </td>
                        <td width="20%">
                            @foreach ($item->layanans->whereIn('kode_unit', ['4008', '4002', '4010']) as $obat)
                                @foreach ($obat->layanan_details as $laydet)
                                    @if ($laydet->barang)
                                        <b>{{ $laydet->barang->nama_barang }}</b><br>
                                    @endif
                                @endforeach
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>
</div>
<x-adminlte-modal id="modalHasilLab" name="modalHasilLab" title="Hasil Laboratorium" theme="success"
    icon="fas fa-file-medical" size="xl">
    <iframe id="dataHasilLab" src="" height="600px" width="100%" title="Iframe Example"></iframe>
    <x-slot name="footerSlot">
        <a href="" id="urlHasilLab" target="_blank" class="btn btn-primary mr-auto">
            <i class="fas fa-download "></i>Download</a>
        <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
@push('js')
    <x-adminlte-modal id="modalKunjungan" name="modalKunjungan" title="Kunjungan Pasien" theme="success"
        icon="fas fa-file-medical" size="xl">
        @php
            $heads = ['Tgl Masuk', 'Tgl Keluar', 'Kunjungan', 'Jenis Pelayanan', 'Unit', 'Diagnosa', 'SEP'];
            $config['paging'] = false;
            $config['order'] = ['0', 'desc'];
            $config['info'] = false;
        @endphp
        <x-adminlte-datatable id="tableKunjungan" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
            hoverable compressed>
        </x-adminlte-datatable>
    </x-adminlte-modal>
    <script>
        $(function() {
            $('.btnRiwayatKunjungan').click(function(e) {
                $.LoadingOverlay("show");
                getKunjunganPasien();
                $('#modalKunjungan').modal('show');
                $.LoadingOverlay("hide");
            });

            function getKunjunganPasien() {
                var url = "{{ route('get_kunjungan_pasien') }}?norm={{ $kunjungan->no_rm }}";
                var table = $('#tableKunjungan').DataTable();
                $.ajax({
                    type: "GET",
                    url: url,
                }).done(function(data) {
                    table.rows().remove().draw();
                    if (data.metadata.code == 200) {
                        $.each(data.response, function(key, value) {
                            table.row.add([
                                value.tgl_masuk,
                                value.tgl_keluar,
                                value.counter + " / " + value.kode_kunjungan,
                                value.tgl_keluar,
                                value.unit.nama_unit,
                                value.tgl_keluar,
                                value.tgl_keluar,
                            ]).draw(false);
                        });
                    } else {
                        Swal.fire(
                            'Mohon Maaf !',
                            data.metadata.message,
                            'error'
                        );
                    }
                });
            }
        });
    </script>
@endpush
