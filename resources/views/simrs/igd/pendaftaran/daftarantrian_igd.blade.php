@extends('adminlte::page')

@section('title', 'Antrian Pendaftaran IGD')
@section('content_header')
    <h1>Antrian Pendaftaran IGD</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="alert alert-success alert-dismissible">
                                <h5><i class="icon fas fa-users"></i> Antrian Hari ini TGL: {{\Carbon\Carbon::now()->format('Y-m-d');}}!</h5>
                                jika ingin melihat semua antrian masuk hari ini, <a href="#">KLIK LINK BERIKUT</a>
                            </div>
                            <div class="row">
                                @foreach ($antrian_pasien as $item)
                                <div class="col-12 col-sm-4 col-md-3">
                                    <a class="btn btn-app bg-success" id="pilihAntrian" onclick="pilihAntrian({{$item->id}})">
                                        <span class="badge bg-warning">Antrian</span>
                                        <i class="fas fa-users"></i> {{$item->no_antri}}
                                    </a>
                                </div>
                                @endforeach
                            </div>
                            @if ($antrian_pasien->links()->paginator->hasPages())
                            <div class="col-lg-5">
                                {{$antrian_pasien->links()}}
                            </div>
                            @endif
                        </div>
                        <div class="col-lg-7">
                            <div class="col-lg-12">
                                <div class="alert alert-warning alert-dismissible">
                                    <h5><i class="icon fas fa-info-circle"></i> form untuk mendaftarkan pasien baru :</h5>
                                    jika pasien tidak terdaftar dalam sistem, silahkan masukan data pasien baru dengan cara klik tombol berikut : 
                                    <x-adminlte-button label="Tambah Pasien Baru" data-toggle="modal" data-target="#tambahPasien" class="bg-purple btn-xs"/>
                                    <x-adminlte-modal id="tambahPasien" title="Tambah Pasien Baru" size="xl" theme="purple"
                                        icon="fas fa-user-plus" v-centered static-backdrop scrollable>
                                        <div class="modal-body">
                                            <form action="" method="post">
                                                @csrf
                                                <div class="col-lg-12">
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
                                                              <x-adminlte-input name="nik" label="NIK" placeholder="masukan nik" fgroup-class="col-md-6" disable-feedback />
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
                                                              <x-adminlte-select name="agama" label="Agama" fgroup-class="col-md-6">
                                                                <option value="L">ISLAM</option>
                                                              </x-adminlte-select>
                                                              <x-adminlte-select name="pekerjaan" label="Pekerjaan" fgroup-class="col-md-6">
                                                                <option value="L">PNS</option>
                                                              </x-adminlte-select>
                                                              <x-adminlte-select name="pendidikan" label="Pendidikan" fgroup-class="col-md-6">
                                                                <option value="L">S1</option>
                                                              </x-adminlte-select>
                                                            </div>
                                                          </div>
                                                          <div class="col-lg-6">
                                                            <div class="row">
                                                              <x-adminlte-select name="desa" label="Desa" fgroup-class="col-md-6">
                                                                <option value="L">CILENGKRANG</option>
                                                              </x-adminlte-select>
                                                              <x-adminlte-select name="kecamatan" label="Kecamatan" fgroup-class="col-md-6">
                                                                <option value="L">CILENGKRANG</option>
                                                              </x-adminlte-select>
                                                              <x-adminlte-select name="kabupaten" label="Kabupaten" fgroup-class="col-md-6">
                                                                <option value="L">KABUPATEN CIREBON</option>
                                                              </x-adminlte-select>
                                                              <x-adminlte-select name="provinsi" label="Provinsi" fgroup-class="col-md-6">
                                                                <option value="L">JAWA BARAT</option>
                                                              </x-adminlte-select>
                                                              <x-adminlte-select name="negara" label="Negara" fgroup-class="col-md-6">
                                                                <option value="L">INDONESIA</option>
                                                              </x-adminlte-select>
                                                              <x-adminlte-select name="kewarganegaraan" label="Kewarganegaraan" fgroup-class="col-md-6">
                                                                <option value="L">WNI</option>
                                                              </x-adminlte-select>
                                                              <x-adminlte-textarea name="alamat_lengkap_pasien" placeholder="Alamat Lengkap (RT/RW)" fgroup-class="col-md-12" />
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
                                                          <x-adminlte-select name="hub_keluarga" label="Hubungan Dengan Pasien" fgroup-class="col-md-6">
                                                            <option value="L">SUAMI</option>
                                                          </x-adminlte-select>
                                                          <x-adminlte-select name="desa" label="Desa" fgroup-class="col-md-6">
                                                            <option value="L">CILENGKRANG</option>
                                                          </x-adminlte-select>
                                                          <x-adminlte-select name="kecamatan" label="Kecamatan" fgroup-class="col-md-6">
                                                            <option value="L">CILENGKRANG</option>
                                                          </x-adminlte-select>
                                                          <x-adminlte-select name="kabupaten" label="Kabupaten" fgroup-class="col-md-6">
                                                            <option value="L">KABUPATEN CIREBON</option>
                                                          </x-adminlte-select>
                                                          <x-adminlte-select name="provinsi" label="Provinsi" fgroup-class="col-md-6">
                                                            <option value="L">JAWA BARAT</option>
                                                          </x-adminlte-select>
                                                          <x-adminlte-textarea name="alamat_lengkap_sodara" placeholder="Alamat Lengkap (RT/RW)" fgroup-class="col-md-12" />
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                            </form>
                                        </div>
                                        <x-slot name="footerSlot">
                                            <x-adminlte-button theme="danger" class="mr-auto" label="batal" data-dismiss="modal"/>
                                            <x-adminlte-button class="float-right" theme="success" label="simpan data"/>
                                        </x-slot>
                                    </x-adminlte-modal>
                                </div>
                            </div>
                            <form action="" method="POST">
                                <div class="row">
                                  <div class="col-lg-12">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control mr-2"   placeholder="cari NIK Pasien" id="nik">
                                            <input type="text" class="form-control mr-2"   placeholder="cari nama pasien" id="nama" >
                                            <div class="input-group-prepend withLoad" >
                                                <x-adminlte-button label="Cari Pasien" theme="primary" icon="fas fa-search" id="search"/>
                                                <x-adminlte-button label="Refresh" theme="danger" icon="fas fa-retweet" onClick="window.location.reload();"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            @php
                            $heads = ['NO RM', 'NIK', 'NO BPJS','NAMA'];
                            $config['order'] = ['0', 'asc'];
                            $config['paging'] = true;
                            $config['info'] = false;
                            $config['searching'] = false;
                            $config['scrollY'] = '400px';
                            $config['scrollCollapse'] = true;
                            $config['scrollX'] = true;
                            @endphp
                            <x-adminlte-datatable id="table1" class="nowrap text-xs" :heads="$heads" :config="$config" striped bordered hoverable compressed>
                            </x-adminlte-datatable>
                        </div>
                       
                    </div>
                </div>
               
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-5">
                            <x-adminlte-card title="Mohon Verifikasi Data Berikut" theme="danger" collapsible>
                                <form action="{{route('pasien-didaftarkan')}}" method="post">
                                    @csrf
                                    <input type="hidden" id="no_antrian" name="antrian_id">
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
                                            <ul class="nav nav-pills flex-column">
                                                <li class="nav-item active">
                                                <a href="#" class="nav-link"><p id="rm_pasien">RM : </p></a>
                                                </li>
                                                <li class="nav-item">
                                                <a href="#" class="nav-link"><p id="nama_pasien">NAMA : </p> </a>
                                                </li>
                                                <li class="nav-item">
                                                <a href="#" class="nav-link"><p id="desa_pasien">DESA : </p> </a>
                                                </li>
                                                <li class="nav-item">
                                                <a href="#" class="nav-link"><p id="kec_pasien">KECAMATAN : </p> </a>
                                                </li>
                                                <li class="nav-item">
                                                <a href="#" class="nav-link"><p id="kab_pasien">KABUPATEN : </p> </a>
                                                </li>
                                            </ul>
                                            <x-adminlte-select name="pendaftaran_id" id="pilihPendaftaran" label="Pilih Pendaftaran" onchange="showDiv(this)">
                                                <option value="0" >IGD</option>
                                                <option value="1" >IGD KEBIDANAN</option>
                                                <option value="2" >RAWAT JALAN</option>
                                                <option value="3" >RAWAT INAP</option>
                                            </x-adminlte-select>
                                        </div>
                                        <x-adminlte-button type="submit" theme="danger" label="verifikasi data"/>
                                    </div>
                                </form>
                            </x-adminlte-card>
                        </div>
                        
                    </div>
                </div>
            </div>
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
        $('#search').click(function(e) {  
            search();
            loading();
            hideLoading();
            
        });
    });
    
    search();
    function loading(){$.LoadingOverlay("show");}
    function hideLoading(){$.LoadingOverlay("hide");}

    function search(){
        var nik = $('#nik').val();
         var nama = $('#nama').val();
         
         $.post('{{ route("pasien-igd-search") }}',
          {
             _token: $('meta[name="csrf-token"]').attr('content'),
             nik:nik,
             nama:nama,
           },
           function(data){
            table_post_row(data);
              console.log(data);
           });
    }
    // table row with ajax
    function table_post_row(res){
        let htmlView = '';
        if(res.pasien.length <= 0){
            htmlView+= `
            <tr>
                <td colspan="6">No data.</td>
            </tr>`;
        }
        for(let i = 0; i < res.pasien.length; i++){
            var rm = res.pasien[i].no_rm;
            htmlView += `
                <tr class="nowrap">
                    <td><button type="button" onclick="pilihPasien(`+rm+`)" class="btn btn-block bg-maroon btn-sm">`+rm+`</button></td>
                    <td>`+res.pasien[i].nik_bpjs+`</td>
                    <td>`+res.pasien[i].no_Bpjs+`</td>
                    <td>`+res.pasien[i].nama_px+`</td>
                </tr>`;
        }
            $('tbody').html(htmlView);
            
    }

    function pilihPasien(norm)
    {
        var rm = norm;
        swal.fire({
            icon: 'question',
            title: 'ANDA YAKIN PILIH RM : ' +rm,
            showDenyButton: true,
            confirmButtonText: 'Pilih',
            denyButtonText: `Batal`,
            }).then((result) => {
            if (result.isConfirmed) 
            {
                var getPasienUrl = "{{route('pasien-terpilih.get')}}?rm="+rm;
                $.get(getPasienUrl, function (data) {
                    console.log(data);
                    $('#rm_pasien').text('NO RM : '+data.pasien['no_rm']);
                    $('#nama_pasien').text('NAMA : '+data.pasien['nama_px']);
                    $('#desa_pasien').text('DESA : '+data.pasien['desas']['nama_desa_kelurahan']);
                    $('#kec_pasien').text('KEC. : '+data.pasien['kecamatans']['nama_kecamatan']);
                    $('#kab_pasien').text('KAB. : '+data.pasien['kabupatens']['nama_kabupaten_kota']);
                })
                Swal.fire('pasien berhasil dipilih', '', 'success')
                $('#no_rm').val(rm);
                
            } 
            else if (result.isDenied) {
                Swal.fire('Pilih Ruangan dibatalkan', '', 'info')
            }
        })
    }
    
    function pilihAntrian(antrianID)
    {
        var antrian_id = antrianID;
        swal.fire({
            icon: 'question',
            title: 'ANDA YAKIN PILIH NO ANTRIAN INI ?',
            showDenyButton: true,
            confirmButtonText: 'Pilih Sekarang',
            denyButtonText: `Batal`,
        }).then((result) => {
            if (result.isConfirmed) 
            {
                $('#no_antri').text('VERIFIKASI PASIEN NO : '+antrian_id);
                Swal.fire('no antrian sudah dipilih', '', 'success')
                $('#no_antrian').val(antrian_id);
               
            } 
            // else if (result.isDenied) {
            //     Swal.fire('Pilih Ruangan dibatalkan', '', 'info')
            // }
        })
    }
    </script>
@endsection