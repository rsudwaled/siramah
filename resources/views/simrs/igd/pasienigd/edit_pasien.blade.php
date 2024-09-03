@extends('adminlte::page')

@section('title', 'EDIT PASIEN')
@section('content_header')
    <h1>EDIT PASIEN : {{$pasien->no_rm}} || {{ $pasien->nama_px }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="alert alert-success alert-dismissible">
                                    <h5>
                                        <i class="icon fas fa-users"></i>Informasi
                                        Pasien :
                                    </h5>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <input type="hidden" name="rm" id="rm" value="{{ $pasien->no_rm }}">
                                    <x-adminlte-input name="nik_pasien_baru" value="{{ $pasien->nik_bpjs }}" label="NIK"
                                        placeholder="masukan nik" fgroup-class="col-md-6" disable-feedback />
                                    <x-adminlte-input name="no_bpjs" label="BPJS" value="{{ $pasien->no_Bpjs }}"
                                        placeholder="masukan bpjs" fgroup-class="col-md-6" disable-feedback />
                                    <x-adminlte-input name="nama_pasien_baru" label="Nama" value="{{ $pasien->nama_px }}"
                                        placeholder="masukan nama pasien" fgroup-class="col-md-12" disable-feedback />
                                    <x-adminlte-input name="tempat_lahir" label="Tempat lahir" placeholder="masukan tempat"
                                        value="{{ $pasien->tempat_lahir }}" fgroup-class="col-md-6" disable-feedback />
                                    <x-adminlte-select name="jk" label="Jenis Kelamin" fgroup-class="col-md-6">
                                        <option value="L" {{ $pasien->jenis_kelamin == 'L' ? 'selected' : '' }}>
                                            Laki-Laki
                                        </option>
                                        <option value="P" {{ $pasien->jenis_kelamin == 'P' ? 'selected' : '' }}>
                                            Perempuan
                                        </option>
                                    </x-adminlte-select>
                                    @php
                                        $config = ['format' => 'YYYY-MM-DD'];
                                        $tgl_lahir = date('Y-m-d', strtotime($pasien->tgl_lahir));
                                    @endphp
                                    <div class="col-lg-6">
                                        <label for="">Tanggal Lahir (bulan/tanggal/tahun)</label>
                                        <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir"
                                            value="{{ $tgl_lahir }}" :config="$config">
                                    </div>
                                    <x-adminlte-select name="agama" label="Agama" fgroup-class="col-md-6">
                                        @foreach ($agama as $item)
                                            <option value="{{ $item->ID }}"
                                                {{ $pasien->agama == $item->ID ? 'selected' : '' }}>
                                                {{ $item->agama }}</option>
                                        @endforeach
                                    </x-adminlte-select>
                                    <x-adminlte-select name="pekerjaan" label="Pekerjaan" fgroup-class="col-md-6">
                                        @foreach ($pekerjaan as $item)
                                            <option value="{{ $item->ID }}"
                                                {{ $pasien->pekerjaan == $item->ID ? 'selected' : '' }}>
                                                {{ $item->pekerjaan }}</option>
                                        @endforeach
                                    </x-adminlte-select>
                                    <x-adminlte-select name="pendidikan" label="Pendidikan" fgroup-class="col-md-6">
                                        @foreach ($pendidikan as $item)
                                            <option value="{{ $item->ID }}"
                                                {{ $pasien->pendidikan == $item->ID ? 'selected' : '' }}>
                                                {{ $item->pendidikan }}
                                            </option>
                                        @endforeach
                                    </x-adminlte-select>
                                    <x-adminlte-input name="no_telp" id="no_telp" label="No Telpon"
                                        value="{{ $pasien->no_tlp == null ? $pasien->no_hp : $pasien->no_tlp }}"
                                        placeholder="masukan no tlp" fgroup-class="col-md-6" disable-feedback />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                        <x-adminlte-select2 name="desa_pasien" id="desa_pasien" label="Desa *"
                                        fgroup-class="col-md-12">
                                        <option value="">Cari Desa</option>
                                    </x-adminlte-select2>
                                    <div class="form-group col-md-12">
                                        <label for="selected_desa_info">Informasi Terpilih</label>
                                        <input type="text" id="selected_desa_info" placeholder="{{ $desa ? 'Desa ' . $desa->name . ' - ' . optional($desa->kecamatan)->name . ' - ' . optional(optional($desa->kecamatan)->kabupatenKota)->name : 'Pilih desa terlebih dahulu' }}"  class="form-control" readonly>
                                    </div>
                                    <x-adminlte-select2 name="negara" label="Negara" id="negara_pasien"
                                        fgroup-class="col-md-12">
                                        @foreach ($negara as $item)
                                            <option value="{{ $item->id }}"
                                                {{ ucfirst(strtolower($pasien->negara)) == $item->nama_negara ? 'selected' : ($pasien->negara == $item->id ? 'selected' : '') }}>
                                                {{ $item->nama_negara }}
                                            </option>
                                        @endforeach
                                    </x-adminlte-select2>
                                    <x-adminlte-select name="kewarganegaraan" id="kewarganegaraan_pasien"
                                        label="Kewarganegaraan" fgroup-class="col-md-12">
                                        <option value="1" {{ $pasien->kewarganegaraan == '1' ? 'selected' : '' }}>WNI
                                        </option>
                                        <option value="0" {{ $pasien->kewarganegaraan == '0' ? 'selected' : '' }}>WNA
                                        </option>
                                    </x-adminlte-select>
                                    <x-adminlte-textarea name="alamat_lengkap_pasien" label="Alamat Lengkap (RT/RW)"
                                        fgroup-class="col-md-12">{{ $pasien->alamat }}</x-adminlte-textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="alert alert-warning alert-dismissible">
                            <h5>
                                <i class="icon fas fa-users"></i>Info Keluarga
                                Pasien :
                            </h5>
                        </div>
                        <div class="row">
                            <x-adminlte-input name="nama_keluarga" id="nama_keluarga"
                                value="{{ $klp == null ? '' : $klp->nama_keluarga }}" label="Nama Keluarga"
                                placeholder="masukan nama keluarga" fgroup-class="col-md-12" disable-feedback />
                            <x-adminlte-input name="tlp_keluarga" id="tlp_keluarga" label="Kontak" placeholder="no tlp"
                                value="{{ $klp == null ? '' : $klp->tlp_keluarga }}" fgroup-class="col-md-6"
                                disable-feedback />
                            <x-adminlte-select name="hub_keluarga" id="hub_keluarga" label="Hubungan Dengan Pasien"
                                fgroup-class="col-md-6">
                                @foreach ($hb_keluarga as $item)
                                    <option value="{{ $item->kode }}"
                                        {{ ($klp == null ? '' : $klp->hubungan_keluarga == $item->kode) ? 'selected' : '' }}>
                                        {{ $item->nama_hubungan }}</option>
                                @endforeach
                            </x-adminlte-select>

                            <x-adminlte-textarea name="alamat_lengkap_sodara" id="alamat_lengkap_sodara"
                                label="Alamat Lengkap (RT/RW)" placeholder="Alamat Lengkap (RT/RW)"
                                fgroup-class="col-md-12">{{ $klp == null ? '' : $klp->alamat_keluarga }}</x-adminlte-textarea>
                        </div>
                    </div>
                </div>
                <x-adminlte-button id="updatePasien" class="float-right btn-sm ml-2" theme="primary"
                    label="Update Data" />
                <button type="button" id="selesaiEdit" class="btn btn-success btn-sm ml-2 float-right">Selesai
                    Edit</button>

                <x-adminlte-button label="Refresh" class="btn btn-flat btn-sm" theme="danger" icon="fas fa-retweet"
                    onClick="window.location.reload();" />
            </form>
        </div>
    </div>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)
@section('js')
    <script>
        $(document).ready(function() {
            $('#desa_pasien').select2({
                ajax: {
                    url: "{{ route('desa-pasien.get') }}",
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: data.map(function(item) {
                                return {
                                    id: item.id,
                                    text: item.name,
                                    kecamatanName: item.kecamatan_name,
                                    kabupatenName: item.kabupaten_name
                                };
                            })
                        };
                    },
                    cache: true
                },
                placeholder: 'Cari Desa',
                minimumInputLength: 1
            });

            $('#desa_pasien').on('select2:select', function(e) {
                var data = e.params.data;
                var info = 'Desa: ' + data.text;
                $('#selected_desa_info').val(info);
            });
        });

        $('#updatePasien').on('click', function() {
            swal.fire({
                icon: 'question',
                title: 'ANDA YAKIN UPDATE DATA INI ?',
                showDenyButton: true,
                confirmButtonText: 'Update',
                denyButtonText: `Batal`,
            }).then((result) => {
                if (result.isConfirmed) {
                    var urlUpdate = "{{ route('update-pasien.update') }}?rm=" + $('#rm').val();
                    $.ajax({
                        type: 'PUT',
                        url: urlUpdate,
                        data: {
                            _token: "{{ csrf_token() }}",
                            rm: $('#rm').val(),
                            nik: $('#nik_pasien_baru').val(),
                            no_bpjs: $('#no_bpjs').val(),
                            nama_pasien_baru: $('#nama_pasien_baru').val(),
                            jk: $('#jk').val(),
                            tempat_lahir: $('#tempat_lahir').val(),
                            tgl_lahir: $('#tgl_lahir').val(),
                            agama: $('#agama').val(),
                            pekerjaan: $('#pekerjaan').val(),
                            pendidikan: $('#pendidikan').val(),
                            no_tlp: $('#no_telp').val(),
                            no_hp: $('#no_telp').val(),
                            desa_pasien: $('#desa_pasien').val(),
                            negara: $('#negara_pasien').val(),
                            kewarganegaraan: $('#kewarganegaraan_pasien').val(),
                            alamat_lengkap_pasien: $('#alamat_lengkap_pasien').val(),

                            nama_keluarga: $('#nama_keluarga').val(),
                            tlp_keluarga: $('#tlp_keluarga').val(),
                            hub_keluarga: $('#hub_keluarga').val(),
                            alamat_lengkap_sodara: $('#alamat_lengkap_sodara').val(),
                        },
                        success: function(res) {
                            if (res.status == 200) {
                                Swal.fire('data pasien berhasil diupdate', '', 'success');
                                window.location.reload(history.back());
                            } else {
                                Swal.fire('data keluarga harus dilengkapi', '', 'error');
                            }
                        }
                    });

                }
            })

        });
        $('#selesaiEdit').on('click', function() {
            swal.fire({
                icon: 'question',
                title: 'SELESAI EDIT DATA INI ?',
                showDenyButton: true,
                confirmButtonText: 'IYA',
                denyButtonText: `Batal`,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.close()
                }
            })

        });
    </script>
@endsection
