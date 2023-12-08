<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#colKeperawatan">
        <h3 class="card-title">
            Implementasi & Evaluasi Keperawatan
        </h3>
    </a>
    <div id="colKeperawatan" class="show collapse">
        <div class="card-body">
            <x-adminlte-button label="Input Keperawatan" icon="fas fa-plus" data-toggle="modal"
                data-target="#modalInputKeperawatan" theme="success" class="btn-xs" />
            <a href="{{ route('print_implementasi_evaluasi_keperawatan') }}?kunjungan={{ $kunjungan->kode_kunjungan }}" target="_blank" class="btn btn-xs btn-warning"><i class="fas fa-print"></i> Print</a>
            @php
                $heads = ['Tanggal Jam', 'Implementasi & Evaluasi Keperawatan', 'Ttd,', 'Action'];
                $config['searching'] = false;
                $config['ordering'] = false;
                $config['paging'] = false;
                $config['info'] = false;
                $config['scrollY'] = '400px';
            @endphp
            <x-adminlte-datatable id="table2" :heads="$heads" :config="$config" bordered hoverable compressed>
                @foreach ($kunjungan->erm_ranap_keperawatan as $keperawatan)
                    <tr>
                        <td>{{ $keperawatan->tanggal_input }}</td>
                        <td>
                            <style>
                                pre {
                                    border: none;
                                    outline: none;
                                    padding: 0 !important;
                                    font-size: 12px;
                                }
                            </style>
                            <pre>{{ $keperawatan->keperawatan }}</pre>
                        </td>
                        <td>{{ $keperawatan->pic }}</td>
                        <td>
                            <button class="btn btn-xs btn-warning btnEditKeperawatan"
                                data-tanggal_input="{{ $keperawatan->tanggal_input }}"
                                data-keperawatan="{{ $keperawatan->keperawatan }}"
                                data-kode_kunjungan="{{ $keperawatan->kode_kunjungan }}">
                                <i class="fas fa-edit"></i>Edit</button>
                            <button class="btn btn-xs btn-danger btnHapusKeperawatan" data-id="{{ $keperawatan->id }}"
                                data-user="{{ $keperawatan->user_id }}">
                                <i class="fas fa-trash-alt"></i> Hapus</button>
                        </td>
                    </tr>
                @endforeach

            </x-adminlte-datatable>
        </div>
    </div>
</div>
<x-adminlte-modal id="modalInputKeperawatan" title="Implementasi & Evaluasi Keperawatan" theme="warning"
    icon="fas fa-file-medical" size='lg'>
    <form action="{{ route('simpan_implementasi_evaluasi_keperawatan') }}" id="formKeperawatan" name="formKeperawatan"
        method="POST">
        @csrf
        @php
            $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
        @endphp
        <input type="hidden" class="kode_kunjungan-keperawatan" name="kode_kunjungan"
            value="{{ $kunjungan->kode_kunjungan }}">
        <input type="hidden" class="counter-keperawatan" name="counter" value="{{ $kunjungan->counter }}">
        <input type="hidden" class="norm-keperawatan" name="norm" value="{{ $kunjungan->no_rm }}">
        <x-adminlte-input-date class="tanggal_input-keperawatan" name="tanggal_input" label="Tanggal & Waktu"
            :config="$config" value="{{ now() }}" />
        <x-adminlte-textarea igroup-size="sm" class="keperawatan-keperawatan" name="keperawatan"
            label="Implementasi & Evaluasi Keperawatan" placeholder="Implementasi & Evaluasi Keperawatan" rows=5>
        </x-adminlte-textarea>
        <x-slot name="footerSlot">
            <button type="submit" form="formKeperawatan" class="btn btn-success mr-auto"><i class="fas fa-save"></i>
                Simpan</button>
            <x-adminlte-button theme="danger" label="Close" icon="fas fa-times" data-dismiss="modal" />
        </x-slot>
    </form>
</x-adminlte-modal>
