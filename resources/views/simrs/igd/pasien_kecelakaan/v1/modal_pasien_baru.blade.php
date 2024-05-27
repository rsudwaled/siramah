<div class="modal fade" id="modal-pasien-kecelakaan" style="display: none;" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">BUAT PASIEN BARU</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formPasienBaru" action="" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="alert bg-purple alert-dismissible">
                                        <h5>
                                            <i class="icon fas fa-users"></i>Informasi
                                            Pasien :
                                        </h5>
                                        <p>
                                            <small>* inputan wajib diisi</small> <br>
                                            <small>** inputan boleh diisi dan juga boleh dikosongkan</small><br>
                                            <small>*** inputan boleh diisi salah satu saja</small>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputRounded0">NIK <code>*<i>( maksimal 16 angka
                                                        )</i></code></label>
                                            <input class="form-control rounded-0" name="modal_nik" id="modal_nik" type="number"
                                                placeholder="masukan nik">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputRounded0">BPJS <code>*<i>( maksimal 16 angka
                                                        )</i></code></label>
                                            <input class="form-control rounded-0" name="modal_no_bpjs" id="modal_no_bpjs" type="number"
                                                placeholder="masukan bpjs">
                                        </div>
                                        <x-adminlte-input name="modal_nama_pasien" id="modal_nama_pasien" label="Nama *"
                                            placeholder="masukan nama pasien" fgroup-class="col-md-12" required
                                            disable-feedback />
                                        <x-adminlte-input name="modal_tempat_lahir" id="modal_tempat_lahir" label="Tempat lahir *"
                                            placeholder="masukan tempat" fgroup-class="col-md-6" disable-feedback />
                                        <x-adminlte-select name="modal_jk" id="modal_jk" label="Jenis Kelamin *"
                                            fgroup-class="col-md-6">
                                            <option value="L">Laki-Laki</option>
                                            <option value="P">Perempuan</option>
                                        </x-adminlte-select>
                                        <div class="col-md-6">
                                            @php
                                                $config = ['format' => 'YYYY-MM-DD'];
                                            @endphp
                                            <x-adminlte-input-date name="modal_tgl_lahir" id="modal_tgl_lahir"
                                                value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                                label="Tanggal Lahir" :config="$config" />
                                        </div>
                                        <x-adminlte-select name="modal_agama" id="modal_agama" label="Agama *" fgroup-class="col-md-6">
                                            @foreach ($agama as $item)
                                                <option value="{{ $item->ID }}">
                                                    {{ $item->agama }}</option>
                                            @endforeach
                                        </x-adminlte-select>
                                        <x-adminlte-select name="modal_pekerjaan" id="modal_pekerjaan" label="Pekerjaan *" fgroup-class="col-md-6">
                                            @foreach ($pekerjaan as $item)
                                                <option value="{{ $item->ID }}">
                                                    {{ $item->pekerjaan }}</option>
                                            @endforeach
                                        </x-adminlte-select>
                                        <x-adminlte-select name="modal_pendidikan" id="modal_pendidikan" label="Pendidikan *"
                                            fgroup-class="col-md-6">
                                            @foreach ($pendidikan as $item)
                                                <option value="{{ $item->ID }}">
                                                    {{ $item->pendidikan }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputRounded0">No Telpon <code>*<i>( Maks 16 angka
                                                        )</i></code></label>
                                            <input class="form-control rounded-0" name="modal_no_telp" id="modal_no_telp" type="number"
                                                placeholder="masukan no tlp">
                                        </div>
                                        <x-adminlte-select name="modal_provinsi_pasien" label="Provinsi *"
                                            id="modal_provinsi_pasien" fgroup-class="col-md-6">
                                            @foreach ($provinsi as $item)
                                                <option value="{{ $item->kode_provinsi }}"
                                                    {{ $item->kode_provinsi == 32 ? 'selected' : '' }}>
                                                    {{ $item->nama_provinsi }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select>
                                        <x-adminlte-select name="modal_kabupaten_pasien" label="Kabupaten *" id="modal_kabupaten_pasien"
                                            fgroup-class="col-md-6">
                                            @foreach ($kabupaten as $item)
                                                <option value="{{ $item->kode_kabupaten_kota }}"
                                                    {{ $item->kode_kabupaten_kota == 3209 ? 'selected' : '' }}>
                                                    {{ $item->nama_kabupaten_kota }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select>
                                        <x-adminlte-select name="modal_kecamatan_pasien" label="Kecamatan *" id="modal_kecamatan_pasien"
                                            fgroup-class="col-md-6">
                                            @foreach ($kecamatan as $item)
                                                <option value="{{ $item->kode_kecamatan }}"
                                                    {{ $item->kode_kecamatan == 3209020 ? 'selected' : '' }}>
                                                    {{ $item->nama_kecamatan }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select>
                                        <x-adminlte-select name="modal_desa_pasien" label="Desa *" id="modal_desa_pasien"
                                            fgroup-class="col-md-6">
                                        </x-adminlte-select>
                                        <x-adminlte-textarea name="modal_alamat_lengkap_pasien" id="modal_alamat_lengkap_pasien"
                                            label="Alamat Lengkap (RT/RW) *" placeholder="Alamat Lengkap (RT/RW)"
                                            fgroup-class="col-md-6" />
                                        <div class="form-group col-md-12">
                                            <div class="col-md-12 row">
                                                <div class="col-md-6">
                                                    <x-adminlte-select name="modal_kewarganegaraan"
                                                        id="modal_kewarganegaraan" label="Kewarganegaraan *">
                                                        <option value="1">WNI</option>
                                                        <option value="0">WNA</option>
                                                    </x-adminlte-select>
                                                </div>
                                                <div class="col-md-6" style="display: none;" id="pilih_negara">
                                                    <label for="" class="col-md-12">Pilih Negara</label>
                                                    <select id="modal_negara" name="modal_negara"
                                                        class="form-control select2 ">
                                                        @foreach ($negara as $item)
                                                            <option value="{{ $item->nama_negara }}">
                                                                {{ $item->nama_negara }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="alert alert-success alert-dismissible">
                                <h5>
                                    <i class="icon fas fa-users"></i>Info Keluarga
                                    Pasien :
                                </h5>
                            </div>
                            <div class="row">
                                <x-adminlte-input name="modal_nama_keluarga" id="modal_nama_keluarga" label="Nama Keluarga *"
                                    placeholder="masukan nama keluarga" fgroup-class="col-md-12" disable-feedback />
                                <x-adminlte-input name="modal_kontak" id="modal_kontak" label="Kontak *" placeholder="no tlp"
                                    fgroup-class="col-md-6" disable-feedback />
                                <x-adminlte-select name="modal_hub_keluarga" id="modal_hub_keluarga" label="Hubungan Dengan Pasien *"
                                    fgroup-class="col-md-6">
                                    @foreach ($hb_keluarga as $item)
                                        <option value="{{ $item->kode }}">
                                            {{ $item->nama_hubungan }}</option>
                                    @endforeach
                                </x-adminlte-select>
                                <x-adminlte-textarea name="modal_alamat_lengkap_sodara" id="modal_alamat_lengkap_sodara" label="Alamat Lengkap (RT/RW) *"
                                    placeholder="Alamat Lengkap (RT/RW)" fgroup-class="col-md-12" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" form="formPasienBaru" class="btn btn-primary btn-save-pasien-baru">Simpan
                    Data</button>
            </div>
        </div>
    </div>
</div>
