<div id="datapasien">
    @if ($form)
        <x-adminlte-card title="Tambah Identitas Pasien Baru" theme="success" icon="fas fa-user-plus">
            <div class="row">
                <input hidden wire:model="id" name="id">
                <div class="col-md-4">
                    <x-adminlte-input wire:model="norm" fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" name="norm" label="No RM" readonly />
                    <x-adminlte-input wire:model="nama" fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" name="nama" label="Nama" />
                    <x-adminlte-input wire:model="nik" fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" name="nik" label="NIK">
                        <x-slot name="appendSlot">
                            <div class="btn btn-primary" wire:click='cariNIK'>
                                <i class="fas fa-search"></i> Cari
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input wire:model="nomorkartu" fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" name="nomorkartu" label="No Kartu">
                        <x-slot name="appendSlot">
                            <div class="btn btn-primary" wire:click='cariNomorKartu'>
                                <i class="fas fa-search"></i> Cari
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input wire:model="idpatient" fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" name="idpatient" label="IdPatient">
                        <x-slot name="appendSlot">
                            <div class="btn btn-primary" wire:click='cariNomorKartu'>
                                <i class="fas fa-search"></i> Cari
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input wire:model="nohp" fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" name="nohp" label="No HP" />
                </div>
                <div class="col-md-4">
                    <x-adminlte-select wire:model="gender" fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" name="gender" label="Sex">
                        <option value=null disabled>Pilih Jenis Kelamin</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </x-adminlte-select>
                    <x-adminlte-input wire:model.live="tempat_lahir" list="tempat_lahir_list" fgroup-class="row"
                        label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" name="tempat_lahir"
                        label="Tempat Lahir" />
                    <datalist id="tempat_lahir_list">
                        @foreach ($kabupatens as $code => $name)
                            <option value="{{ $name }}"></option>
                        @endforeach
                    </datalist>
                    <x-adminlte-input wire:model="tgl_lahir" fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" name="tgl_lahir" label="Tgl Lahir" type="date" />
                    <x-adminlte-input wire:model="hakkelas" fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" name="hakkelas" label="Hak Kelas" />
                    <x-adminlte-input wire:model="jenispeserta" fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" name="jenispeserta" label="Jns Peserta" />
                    <x-adminlte-input wire:model="fktp" fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" name="fktp" label="FKTP" />
                </div>
                <div class="col-md-4">
                    <x-adminlte-input wire:model="alamat" fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" name="alamat" label="Alamat" />
                    <x-adminlte-input wire:model.live="provinsi_id" list="provinsi_id_list" fgroup-class="row"
                        label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" name="provinsi_id"
                        label="Provinsi" />
                    <datalist id="provinsi_id_list">
                        @foreach ($provinsis as $code => $name)
                            <option value="{{ $name }}"></option>
                        @endforeach
                    </datalist>
                    <x-adminlte-input wire:model.live="kabupaten_id" list="kabupaten_id_list" fgroup-class="row"
                        label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" name="kabupaten_id"
                        label="Kabupaten" />
                    <datalist id="kabupaten_id_list">
                        @foreach ($kabupatens as $code => $name)
                            <option value="{{ $name }}"></option>
                        @endforeach
                    </datalist>
                    <x-adminlte-input wire:model.live="kecamatan_id" list="kecamatan_id_list" fgroup-class="row"
                        label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" name="kecamatan_id"
                        label="Kecamatan" />
                    <datalist id="kecamatan_id_list">
                        @foreach ($kecamatans as $code => $name)
                            <option value="{{ $name }}"></option>
                        @endforeach
                    </datalist>
                    <x-adminlte-input wire:model.live="desa_id" list="desa_id_list" fgroup-class="row"
                        label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" name="Desa"
                        label="Desa" />
                    <datalist id="desa_id_list">
                        @foreach ($desas as $code => $name)
                            <option value="{{ $name }}"></option>
                        @endforeach
                    </datalist>
                    <x-adminlte-input wire:model="keterangan" fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" name="keterangan" label="Keterangan" />
                </div>
            </div>
            <x-slot name="footerSlot">
                <x-adminlte-button label="Simpan" class="btn-sm" onclick="store()" icon="fas fa-save"
                    wire:click="store" wire:confirm="Apakah anda yakin ingin menambahkan pasien ?" form="formUpdate"
                    theme="success" />
                <x-adminlte-button wire:click='tambahPasien' class="btn-sm" label="Tutup" theme="danger"
                    icon="fas fa-times" />
                <div wire:loading>
                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                    </div>
                    Loading ...
                </div>
                @if (flash()->message)
                    <div class="text-{{ flash()->class }}" wire:loading.remove>
                        Loading Result : {{ flash()->message }}
                    </div>
                @endif
            </x-slot>
        </x-adminlte-card>
    @endif
    <x-adminlte-card theme="primary" title="Data Pasien" icon="fas fa-user-injured">
        <div class="row">
            <div class="col-md-8">
                <x-adminlte-button wire:click='tambahPasien' class="btn-sm" label="Tambah Pasien Baru"
                    theme="success" icon="fas fa-user-plus" />
            </div>
            <div class="col-md-4">
                <x-adminlte-input wire:model.live="search" name="searchPasien" placeholder="Pencarian Pasien"
                    igroup-size="sm">
                    <x-slot name="appendSlot">
                        <x-adminlte-button theme="primary" label="Cari" />
                    </x-slot>
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-primary">
                            <i class="fas fa-search"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
        </div>
        <div wire:loading>
            <div class="spinner-border spinner-border-sm text-primary" role="status">
            </div>
            Loading ...
        </div>
        <table class="table text-nowrap table-sm table-hover table-bordered table-responsive mb-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>No RM</th>
                    <th>Nama Pasien</th>
                    <th>Sex</th>
                    <th>No BPJS</th>
                    <th>NIK</th>
                    <th>Action</th>
                    <th>Alamat</th>
                    <th>No HP</th>
                    <th>Tempat Lahir</th>
                    <th>Tgl Lahir</th>
                    <th>Umur</th>
                    <th>PIC</th>
                    <th>Updated</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pasiens as $item)
                    <tr>
                        <td>{{ $loop->index + $pasiens->firstItem() }}</td>
                        <td>{{ $item->no_rm }}</td>
                        <td>{{ $item->nama_px }}</td>
                        <td>{{ $item->jenis_kelamin }}</td>
                        <td>{{ $item->no_Bpjs }}</td>
                        <td>{{ $item->nik_bpjs }}</td>
                        <td>
                            <x-adminlte-button wire:click='editPasien({{ $item }})' theme="warning"
                                class="btn-xs" icon="fas fa-edit" />
                            <x-adminlte-button wire:click='nonaktifPasien({{ $item }})' theme="danger"
                                class="btn-xs" icon="fas fa-times"
                                wire:confirm='Apakah anda yakin akan menonaktifkan pasien tersebut ?' />
                        </td>
                        <td>{{ $item->alamat }}</td>
                        <td>{{ $item->no_hp }}</td>
                        <td>{{ $item->tempat_lahir }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tgl_lahir)->format('d F Y') }}</td>
                        <td>
                            {{ $item->tgl_lahir ? \Carbon\Carbon::parse($item->tgl_lahir)->age : '-' }}
                            tahun
                        </td>
                        <td>{{ $item->pic }}</td>
                        <td>{{ $item->update_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-adminlte-card>
</div>
