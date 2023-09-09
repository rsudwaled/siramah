@extends('adminlte::page') @section('title', 'Antrian Pendaftaran IGD') @section('content_header') <h1>Pendaftaran IGD</h1> @stop @section('content') <div class="row">
    <div class="col-12">
      <div class="invoice p-3 mb-3">
        <div class="row">
          <div class="col-12">
            <h4>
              <i class="fas fa-globe"></i> Antrian IGD : <small class="float-right">tanggal : {{\Carbon\Carbon::now()->format('Y-m-d');}}!</small>
            </h4>
          </div>
        </div>
        <div class="row">
          <div class="col-12 table-responsive">
            <div class="row">
              <div class="col-lg-7">
                <form action="" method="POST">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="input-group mb-3">
                        <input type="text" class="form-control mr-2" placeholder="cari NIK Pasien" id="nik">
                        <input type="text" class="form-control mr-2" placeholder="cari nama pasien" id="nama">
                        <div class="input-group-prepend withLoad">
                          <x-adminlte-button label="Cari Pasien" theme="primary" icon="fas fa-search" id="search" />
                          <x-adminlte-button label="Refresh" theme="danger" icon="fas fa-retweet" onClick="window.location.reload();" />
                        </div>
                      </div>
                    </div>
                  </div>
                </form> 
                @php $heads = ['NO RM', 'NIK', 'NO BPJS','NAMA']; 
                $config['order'] = ['0', 'asc']; 
                $config['ordering'] = false; 
                $config['paging'] = true; 
                $config['info'] = false; 
                $config['searching'] = false; 
                $config['scrollY'] = '600px'; 
                $config['scrollCollapse'] = true; 
                $config['scrollX'] = true; 
                @endphp 
                <x-adminlte-datatable id="table1" class="nowrap text-xs" :heads="$heads" :config="$config" striped bordered hoverable compressed></x-adminlte-datatable>
              </div>
              <div class="col-lg-5">
                <div class="col-lg-12">
                <div class="col-lg-12">
                  <x-adminlte-info-box title="klik untuk" data-toggle="modal" data-target="#modalAntrian" text="Lihat Antrian" icon="fas fa-lg fa-window-restore text-primary" class="bg-gradient-primary" icon-theme="white" />
                  <x-adminlte-modal id="modalAntrian" title="DAFTAR ANTRIAN" theme="info" icon="fas fa-bolt" size='xl' disable-animations>
                    <div class="row"> @foreach ($antrian_pasien as $item) <a class="btn btn-app bg-success" id="pilihAntrian" onclick="pilihAntrian({{$item->id}})">
                        <span class="badge bg-warning">Antrian</span>
                        <i class="fas fa-users"></i> {{$item->no_antri}}
                      </a> @endforeach </div> @if ($antrian_pasien->links()->paginator->hasPages()) <div class="col-lg-5">
                      {{$antrian_pasien->links()}}
                    </div> @endif
                  </x-adminlte-modal>
                </div>
                <div class="col-lg-12">
                  <form action="{{route('pasien-didaftarkan')}}" method="post"> @csrf <input type="hidden" id="no_antrian" name="antrian_id">
                    <input type="hidden" id="no_rm" name="pasien_id">
                    <div class="card" id="formdaftar">
                      <div class="card-header">
                        <h3 class="card-title" id="no_antri">Saat ini No Antrian Belum dipilih? </h3>
                        <div class="card-tools">
                          <button type="button" class="btn btn-tool">
                            <i class="fas fa-minus"></i>
                          </button>
                        </div>
                      </div>
                      <div class="card-body p-0" style="display: block;">
                        <div class="col-lg-12">
                          <ul class="nav nav-pills flex-column">
                            <li class="nav-item active">
                                <p id="rm_pasien_selected">RM : </p>
                            </li>
                            <li class="nav-item">
                                <p id="nama_pasien_selected">NAMA : </p>
                            </li>
                            <li class="nav-item">
                                <p id="desa_pasien_selected">DESA : </p>
                            </li>
                            <li class="nav-item">
                                <p id="kec_pasien_selected">KECAMATAN : </p>
                            </li>
                            <li class="nav-item">
                                <p id="kab_pasien_selected">KABUPATEN : </p>
                            </li>
                          </ul>
                        </div>
                        <div class="col-lg-12">
                          <x-adminlte-select name="pendaftaran_id" id="pilihPendaftaran" label="Pilih Pendaftaran">
                            <option value="0">IGD</option>
                            <option value="1">IGD KEBIDANAN</option>
                            <option value="2">RAWAT JALAN</option>
                            <option value="3">RAWAT INAP</option>
                          </x-adminlte-select>
                        </div>
                      </div>
                      <x-adminlte-button type="submit" theme="primary" label="verifikasi data" />
                    </div>
                  </form>
                </div>
                <div class="col-lg-12">
                  <div class="alert alert-warning alert-dismissible">
                    <h5>
                      <i class="icon fas fa-info-circle"></i> form untuk mendaftarkan pasien baru :
                    </h5> jika pasien tidak terdaftar dalam sistem, silahkan masukan data pasien baru dengan cara klik tombol berikut : <br>
                    {{-- <x-adminlte-button label="Tambah Pasien Baru" data-toggle="modal" data-target="#tambahPasien" class="btn btn-info bg-info btn-xs" /> --}}
                    <button type="button" class="btn btn-block bg-gradient-success btn-sm" data-toggle="modal" data-target="#tambahPasien">Tambah Pasien Baru</button>
                    <x-adminlte-modal id="tambahPasien" title="Tambah Pasien Baru" size="xl" theme="info" icon="fas fa-user-plus" v-centered static-backdrop scrollable>
                      <div class="modal-body">
                        <form action="" method="post"> @csrf <div class="col-lg-12">
                            <div class="row">
                              <div class="col-lg-8">
                                <div class="row">
                                  <div class="col-lg-12">
                                    <div class="alert alert-success alert-dismissible">
                                      <h5>
                                        <i class="icon fas fa-users"></i>Informasi Pasien :
                                      </h5>
                                    </div>
                                  </div>
                                  <div class="col-lg-6">
                                    <div class="row">
                                      <x-adminlte-input name="nik_pasien_baru" label="NIK" placeholder="masukan nik" fgroup-class="col-md-6" disable-feedback />
                                      <x-adminlte-input name="no_bpjs" label="BPJS" placeholder="masukan bpjs" fgroup-class="col-md-6" disable-feedback />
                                      <x-adminlte-input name="nama_pasien_baru" label="Nama" placeholder="masukan nama pasien" fgroup-class="col-md-12" disable-feedback />
                                      <x-adminlte-input name="tempat_lahir" label="Tempat lahir" placeholder="masukan tempat" fgroup-class="col-md-6" disable-feedback />
                                      <x-adminlte-select name="jk" label="Jenis Kelamin" fgroup-class="col-md-6">
                                        <option value="L">Laki-Laki</option>
                                        <option value="P">Perempuan</option>
                                      </x-adminlte-select> @php $config = ['format' => 'DD-MM-YYYY']; @endphp <x-adminlte-input-date name="tgl_lahir" fgroup-class="col-md-6" label="Tanggal Lahir" :config="$config">
                                        <x-slot name="prependSlot">
                                          <div class="input-group-text bg-primary">
                                            <i class="fas fa-calendar-alt"></i>
                                          </div>
                                        </x-slot>
                                      </x-adminlte-input-date>
                                      <x-adminlte-select name="agama" label="Agama" fgroup-class="col-md-6"> @foreach ($agama as $item) <option value="{{$item->ID}}">{{$item->agama}}</option> @endforeach </x-adminlte-select>
                                      <x-adminlte-select name="pekerjaan" label="Pekerjaan" fgroup-class="col-md-6"> @foreach ($pekerjaan as $item) <option value="{{$item->ID}}">{{$item->pekerjaan}}</option> @endforeach </x-adminlte-select>
                                      <x-adminlte-select name="pendidikan" label="Pendidikan" fgroup-class="col-md-6"> @foreach ($pendidikan as $item) <option value="{{$item->ID}}">{{$item->pendidikan}}</option> @endforeach </x-adminlte-select>
                                    </div>
                                  </div>
                                  <div class="col-lg-6">
                                    <div class="row">
                                      <x-adminlte-select name="provinsi" label="Provinsi" id="provinsi_pasien" fgroup-class="col-md-6">
                                        <option value="" selected>--PROVINSI--</option> @foreach ($provinsi as $item) <option value="{{$item->kode_provinsi}}">{{$item->nama_provinsi}}</option> @endforeach
                                      </x-adminlte-select>
                                      <x-adminlte-select name="kabupaten" label="Kabupaten" id="kab_pasien" fgroup-class="col-md-6"></x-adminlte-select>
                                      <x-adminlte-select name="kecamatan" label="Kecamatan" id="kec_pasien" fgroup-class="col-md-6"></x-adminlte-select>
                                      <x-adminlte-select name="desa" label="Desa" id="desa_pasien" fgroup-class="col-md-6"></x-adminlte-select>
                                      <x-adminlte-select2 name="negara" label="Negara" id="negara_pasien" fgroup-class="col-md-6"> @foreach ($negara as $item) <option value="{{$item->id}}">{{$item->nama_negara}}</option> @endforeach </x-adminlte-select2>
                                      <x-adminlte-select name="kewarganegaraan" id="kewarganegaraan_pasien" label="Kewarganegaraan" fgroup-class="col-md-6">
                                        <option value="0">WNA</option>
                                        <option value="1">WNI</option>
                                      </x-adminlte-select>
                                      <x-adminlte-textarea name="alamat_lengkap_pasien" label="Alamat Lengkap (RT/RW)" placeholder="Alamat Lengkap (RT/RW)" fgroup-class="col-md-12" />
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-lg-4">
                                <div class="alert alert-warning alert-dismissible">
                                  <h5>
                                    <i class="icon fas fa-users"></i>Info Keluarga Pasien :
                                  </h5>
                                </div>
                                <div class="row">
                                  <x-adminlte-input name="nama_keluarga" label="Nama Keluarga" placeholder="masukan nama keluarga" fgroup-class="col-md-12" disable-feedback />
                                  <x-adminlte-input name="kontak" label="Kontak" placeholder="no tlp" fgroup-class="col-md-6" disable-feedback />
                                  <x-adminlte-select name="hub_keluarga" label="Hubungan Dengan Pasien" fgroup-class="col-md-6"> @foreach ($hb_keluarga as $item) <option value="{{$item->kode}}">{{$item->nama_hubungan}}</option> @endforeach </x-adminlte-select>
                                  <x-adminlte-select name="provinsi" label="Provinsi" id="provinsi_klg_pasien" fgroup-class="col-md-6">
                                    <option value="" selected>--PROVINSI--</option> @foreach ($provinsi_klg as $item) <option value="{{$item->kode_provinsi}}">{{$item->nama_provinsi}}</option> @endforeach
                                  </x-adminlte-select>
                                  <x-adminlte-select name="kabupaten" label="Kabupaten" id="kab_klg_pasien" fgroup-class="col-md-6"></x-adminlte-select>
                                  <x-adminlte-select name="kecamatan" label="Kecamatan" id="kec_klg_pasien" fgroup-class="col-md-6"></x-adminlte-select>
                                  <x-adminlte-select name="desa" label="Desa" id="desa_klg_pasien" fgroup-class="col-md-6"></x-adminlte-select>
                                  <x-adminlte-textarea name="alamat_lengkap_sodara" label="Alamat Lengkap (RT/RW)" placeholder="Alamat Lengkap (RT/RW)" fgroup-class="col-md-12" />
                                </div>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                      <x-slot name="footerSlot">
                        <x-adminlte-button theme="danger" class="mr-auto" label="batal" data-dismiss="modal" />
                        <x-adminlte-button class="float-right" theme="success" label="simpan data" />
                      </x-slot>
                    </x-adminlte-modal>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div> @stop @section('plugins.Select2', true) @section('plugins.Datatables', true) @section('plugins.DatatablesPlugins', true) @section('plugins.TempusDominusBs4', true) @section('plugins.Sweetalert2', true) @section($config['sidebar_collapse'] = true) @section('js') <script>
    $(document).ready(function() {
      $('#search').click(function(e) {
        search();
        loading();
        hideLoading();
      });
    });
    search();
  
    function loading() {
      $.LoadingOverlay("show");
    }
  
    function hideLoading() {
      $.LoadingOverlay("hide");
    }
  
    function search() {
      var nik = $('#nik').val();
      var nama = $('#nama').val();
      $.post('{{ route("pasien-igd-search") }}', {
        _token: $('meta[name="csrf-token"]').attr('content'),
        nik: nik,
        nama: nama,
      }, function(data) {
        table_post_row(data);
        console.log(data);
      });
    }
    // table row with ajax
    function table_post_row(res) {
      let htmlView = '';
      if (res.pasien.length <= 0) {
        htmlView += `
              
                      <tr>
                          <td colspan="6">No data.</td>
                      </tr>`;
      }
      for (let i = 0; i < res.pasien.length; i++) {
        var rm = res.pasien[i].no_rm;
        htmlView += `
                  
                      <tr class="nowrap">
                          <td>
                              <button type="button" onclick="pilihPasien(` + rm + `)" class="btn btn-block bg-maroon btn-sm">` + rm + `</button>
                          </td>
                          <td>` + res.pasien[i].nik_bpjs + `</td>
                          <td>` + res.pasien[i].no_Bpjs + `</td>
                          <td>` + res.pasien[i].nama_px + `</td>
                      </tr>`;
      }
      $('tbody').html(htmlView);
    }
  
    function pilihPasien(norm) {
      var rm = norm;
      swal.fire({
        icon: 'question',
        title: 'ANDA YAKIN PILIH RM : ' + rm,
        showDenyButton: true,
        confirmButtonText: 'Pilih',
        denyButtonText: `Batal`,
      }).then((result) => {
        if (result.isConfirmed) {
          var getPasienUrl = "{{route('pasien-terpilih.get')}}?rm=" + rm;
          $.get(getPasienUrl, function(data) {
            console.log(data);
            $('#rm_pasien_selected').text('NO RM : ' + data.pasien['no_rm']);
            $('#nama_pasien_selected').text('NAMA : ' + data.pasien['nama_px']);
            $('#desa_pasien_selected').text('DESA : ' + data.pasien['desas']['nama_desa_kelurahan']);
            $('#kec_pasien_selected').text('KEC. : ' + data.pasien['kecamatans']['nama_kecamatan']);
            $('#kab_pasien_selected').text('KAB. : ' + data.pasien['kabupatens']['nama_kabupaten_kota']);
          })
          Swal.fire('pasien berhasil dipilih', '', 'success')
          $('#no_rm').val(rm);
        } else if (result.isDenied) {
          Swal.fire('Pilih Ruangan dibatalkan', '', 'info')
        }
      })
    }
  
    function pilihAntrian(antrianID) {
      var antrian_id = antrianID;
      swal.fire({
        icon: 'question',
        title: 'ANDA YAKIN PILIH NO ANTRIAN INI ?',
        showDenyButton: true,
        confirmButtonText: 'Pilih Sekarang',
        denyButtonText: `Batal`,
      }).then((result) => {
        if (result.isConfirmed) {
          var getNoAntrian = "{{route('get-no-antrian')}}?no=" + antrian_id;
          $.get(getNoAntrian, function(data) {
            console.log(data);
            $('#no_antri').text('Antrian No : ' + data['no_antri']);
          })
          Swal.fire('no antrian sudah dipilih', '', 'success')
          $('#no_antrian').val(antrian_id);
        }
      })
      // $('#modalAntrian').hide();
      $('#modalAntrian').modal('hide')
    }
    // alamat pasien
    $('#provinsi_pasien').change(function() {
          var prov_pasien = $(this).val();
          if (prov_pasien) {
            $.ajax({
                type: "GET",
                url: "{{route('kab-pasien.get')}}?kab_prov_id=" + prov_pasien,
                dataType: 'JSON',
                success: function(res) {
                  if (res) {
                    $("#desa_pasien").empty();
                    $("#kec_pasien").empty();
                    $("#kab_pasien").append(' < option > --Pilih Kabupaten-- < /option>');
                      $.each(res, function(key, value) {
                          $("#kab_pasien").append(' < option value = "'+value.kode_kabupaten_kota+'" > '+value.nama_kabupaten_kota+' < /option>');
                          });
                      }
                      else {
                        $("#desa_pasien").empty();
                        $("#kec_pasien").empty();
                        $("#kab_pasien").empty();
                      }
                    }
                  });
              }
              else {
                $("#desa_pasien").empty();
                $("#kec_pasien").empty();
                $("#kab_pasien").empty();
              }
            });
          $('#kab_pasien').change(function() {
                var kec_kab_id = $("#kab_pasien").val();
                if (kec_kab_id) {
                  $.ajax({
                      type: "GET",
                      url: "{{route('kec-pasien.get')}}?kec_kab_id=" + kec_kab_id,
                      dataType: 'JSON',
                      success: function(res) {
                        if (res) {
                          $("#kec_pasien").empty();
                          $("#kec_pasien").append(' < option > --Pilih Kecamatan-- < /option>');
                            $.each(res, function(key, value) {
                                $("#kec_pasien").append(' < option value = "'+value.kode_kecamatan+'" > '+value.nama_kecamatan+' < /option>');
                                });
                            }
                            else {
                              $("#kec_pasien").empty();
                            }
                          }
                        });
                    }
                    else {
                      $("#kec_pasien").empty();
                    }
                  });
                $('#kec_pasien').change(function() {
                      var desa_kec_id = $("#kec_pasien").val();
                      if (desa_kec_id) {
                        $.ajax({
                            type: "GET",
                            url: "{{route('desa-pasien.get')}}?desa_kec_id=" + desa_kec_id,
                            dataType: 'JSON',
                            success: function(res) {
                              if (res) {
                                $("#desa_pasien").empty();
                                $("#desa_pasien").append(' < option > --Pilih Desa-- < /option>');
                                  $.each(res, function(key, value) {
                                      $("#desa_pasien").append(' < option value = "'+value.kode_desa_kelurahan+'" > '+value.nama_desa_kelurahan+' < /option>');
                                      });
                                  }
                                  else {
                                    $("#desa_pasien").empty();
                                  }
                                }
                              });
                          }
                          else {
                            $("#desa_pasien").empty();
                          }
                        });
                      // alamat keluarga pasien
                      $('#provinsi_klg_pasien').change(function() {
                            var prov_klg_pasien = $(this).val();
                            if (prov_klg_pasien) {
                              $.ajax({
                                  type: "GET",
                                  url: "{{route('kab-klg-pasien.get')}}?kab_prov_id=" + prov_klg_pasien,
                                  dataType: 'JSON',
                                  success: function(res) {
                                    if (res) {
                                      $("#desa_klg_pasien").empty();
                                      $("#kec_klg_pasien").empty();
                                      $("#kab_klg_pasien").append(' < option > --Pilih Kabupaten-- < /option>');
                                        $.each(res, function(key, value) {
                                            $("#kab_klg_pasien").append(' < option value = "'+value.kode_kabupaten_kota+'" > '+value.nama_kabupaten_kota+' < /option>');
                                            });
                                        }
                                        else {
                                          $("#desa_klg_pasien").empty();
                                          $("#kec_klg_pasien").empty();
                                          $("#kab_klg_pasien").empty();
                                        }
                                      }
                                    });
                                }
                                else {
                                  $("#desa_klg_pasien").empty();
                                  $("#kec_klg_pasien").empty();
                                  $("#kab_klg_pasien").empty();
                                }
                              });
                            $('#kab_klg_pasien').change(function() {
                                  var kec_kab_id = $("#kab_klg_pasien").val();
                                  if (kec_kab_id) {
                                    $.ajax({
                                        type: "GET",
                                        url: "{{route('kec-klg-pasien.get')}}?kec_kab_id=" + kec_kab_id,
                                        dataType: 'JSON',
                                        success: function(res) {
                                          if (res) {
                                            $("#kec_klg_pasien").empty();
                                            $("#kec_klg_pasien").append(' < option > --Pilih Kecamatan-- < /option>');
                                              $.each(res, function(key, value) {
                                                  $("#kec_klg_pasien").append(' < option value = "'+value.kode_kecamatan+'" > '+value.nama_kecamatan+' < /option>');
                                                  });
                                              }
                                              else {
                                                $("#kec_klg_pasien").empty();
                                              }
                                            }
                                          });
                                      }
                                      else {
                                        $("#kec_klg_pasien").empty();
                                      }
                                    });
                                  $('#kec_klg_pasien').change(function() {
                                        var desa_kec_id = $("#kec_klg_pasien").val();
                                        if (desa_kec_id) {
                                          $.ajax({
                                              type: "GET",
                                              url: "{{route('desa-klg-pasien.get')}}?desa_kec_id=" + desa_kec_id,
                                              dataType: 'JSON',
                                              success: function(res) {
                                                if (res) {
                                                  $("#desa_klg_pasien").empty();
                                                  $("#desa_klg_pasien").append(' < option > --Pilih Desa-- < /option>');
                                                    $.each(res, function(key, value) {
                                                        $("#desa_klg_pasien").append(' < option value = "'+value.kode_desa_kelurahan+'" > '+value.nama_desa_kelurahan+' < /option>');
                                                        });
                                                    }
                                                    else {
                                                      $("#desa_klg_pasien").empty();
                                                    }
                                                  }
                                                });
                                            }
                                            else {
                                              $("#desa_klg_pasien").empty();
                                            }
                                          });
  </script> @endsection