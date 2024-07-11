<div id="casemixmanager">
    <x-adminlte-card title="Casemix Manager" theme="primary" icon="fas fa-user-md">
        diagnosa
        <x-adminlte-input wire:model.live="icd1" list="icdlist" name="icd1" label="ICD-10 Primer" igroup-size="sm" />
        <label>ICD-10 Sekunder</label>
        @foreach ($icd2 as $index => $item)
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input wire:model.live="icd2.{{ $index }}" list="icdlist" name="icd2[]"
                        igroup-size="sm" placeholder="ICD-10 Sekunder" />
                </div>
                <div class="col-md-6">
                    <button wire:click.prevent="removeIcd2({{ $index }})"
                        class="btn btn-danger btn-sm">Hapus</button>
                </div>
            </div>
        @endforeach
        <div class="row" wire:key="icd2-field-{{ count($icd2) }}">
            <div class="col-md-6">
                <x-adminlte-input wire:model.live="icd2.{{ count($icd2) }}" list="icdlist" name="icd2[]"
                    igroup-size="sm" placeholder="ICD-10 Sekunder" />
            </div>
            <div class="col-md-6">
                <button wire:click.prevent="addIcd2" class="btn btn-success btn-sm">Tambah</button>
            </div>
        </div>
        <datalist id="icdlist">
            @foreach ($icd as $key => $item)
                <option value="{{ $item['nama'] }}"></option>
            @endforeach
        </datalist>
    </x-adminlte-card>
</div>
