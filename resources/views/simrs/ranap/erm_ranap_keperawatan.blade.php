<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#colKeperawatan">
        <h3 class="card-title">
            Implementasi & Evaluasi Keperawatan
        </h3>
    </a>
    <div id="colKeperawatan" class="show collapse">
        <div class="card-body">
            <x-adminlte-modal id="modalInputKeperawatan" title="Implementasi & Evaluasi Keperawatan" theme="warning"
                icon="fas fa-file-medical" size='lg'>
                @php
                    $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
                @endphp
                <x-adminlte-input-date name="tanggal" label="Tanggal & Waktu" :config="$config"
                    value="{{ now() }}" />
                <x-adminlte-textarea igroup-size="sm" name="keperawatan" label="Implementasi & Evaluasi Keperawatan"
                    placeholder="Implementasi & Evaluasi Keperawatan" rows=5>
                </x-adminlte-textarea>
            </x-adminlte-modal>
            <x-adminlte-button label="Input Keperawatan" icon="fas fa-plus" data-toggle="modal"
                data-target="#modalInputKeperawatan" theme="success" class="btn-xs" />
            @php
                $heads = ['Tanggal Jam', 'Implementasi & Evaluasi Keperawatan', 'PIC'];
                $config['searching'] = false;
                $config['ordering'] = false;
                $config['paging'] = false;
                $config['info'] = false;
                $config['scrollY'] = '500px';
            @endphp
            <x-adminlte-datatable id="table2" :heads="$heads" :config="$config" bordered hoverable compressed>
                @for ($i = 0; $i < 5; $i++)
                    <tr>
                        <td>{{ now() }}</td>
                        <td>
                            Masien mendapatkan perwatan
                            <br>
                            Catatan pasien dll

                        </td>
                        <td>Marwan</td>
                    </tr>
                @endfor
            </x-adminlte-datatable>
        </div>
    </div>
</div>
