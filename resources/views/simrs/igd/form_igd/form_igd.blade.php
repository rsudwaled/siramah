@extends('adminlte::page')

@section('title', 'Pasien IGD')
@section('content_header')
    <h1>Pasien IGD : {{$pasien->nama_px}}</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                      <h3 class="profile-username text-center">{{$pasien->nama_px}}</h3>
                      <p class="text-muted text-center">RM : {{$pasien->no_rm}}</p>
                      <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item"><b>Jrnis Kelamin : {{$pasien->jenis_kelamin=='L'? 'Laki-Laki':'Perempuan'}}</b></li>
                        <li class="list-group-item"><b>Alamat : {{$pasien->alamat}}</b></li>
                        <li class="list-group-item"><b>NIK : {{$pasien->nik_bpjs}}</b></li>
                        <li class="list-group-item"><b>BPJS : {{$pasien->no_Bpjs==null ? 'tidak punya bpjs' : $pasien->no_Bpjs}}</b></li>
                        <li class="list-group-item"><b>Telp : {{$pasien->no_telp== null ? $pasien->no_hp : $pasien->no_telp }}</b></li>
                      </ul>
                      <a class="btn btn-primary bg-gradient-primary btn-block"><b>No Antri : {{$antrian->no_antri}}</b></a>
                    </div>
                </div>
                
              </div>
              <div class="col-md-9">
                <x-adminlte-card theme="primary" collapsible title="Riwayat Kunjungan :">
                    @php
                        $heads = ['Kunjungan', 'Unit', 'Tanggal Masuk', 'Tanggal keluar', 'Penjamin', 'Petugas'];
                        $config['order'] = ['0', 'asc'];
                        $config['paging'] = false;
                        $config['info'] = false;
                        $config['scrollY'] = '300px';
                        $config['scrollCollapse'] = true;
                        $config['scrollX'] = true;
                    @endphp
                    <x-adminlte-datatable id="table" class="text-xs" :heads="$heads" :config="$config"
                        striped bordered hoverable compressed>
                        @foreach ($kunjungan as $item)
                            <tr>
                                <td>{{$item->Kun}}</td>
                                <td>{{$item->nama_unit}}</td>
                                <td>{{$item->tgl_masuk}}</td>
                                <td>{{$item->tgl_keluar == null ? 'pasien belum keluar' :$item->tgl_keluar}}</td>
                                <td>{{$item->nama_penjamin}}</td>
                                <td>{{$item->nama_user}}</td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </x-adminlte-card>
              </div>
        </div>
        <div class="row">
            @if ($pasien->no_Bpjs == null)
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h4>Status Pasien :</h4>
                        </div>
                        <div class="card-body">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <a class="btn btn-app btn-block bg-maroon"><i class="fas fa-user-tag"></i> PASIEN UMUM</a> 
                                    </div>
                                    <div class="col-lg-6">
                                        <a class="btn btn-app btn-block bg-success"><i class="fas fa-users"></i> {{$antrian->no_antri}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <button type="button" class="btn btn-block bg-gradient-success btn-sm mb-2" data-toggle="modal" data-target="#modalSEPCreate">BUAT SEP</button>
                            <x-adminlte-modal id="modalSEPCreate" title="Buat SEP RM {{$pasien->no_rm}}" size="lg" theme="success"
                                v-centered static-backdrop>
                                <div class="modal-body">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="card card-primary card-outline">
                                                    <div class="card-body box-profile">
                                                      <h3 class="profile-username text-center">{{$pasien->nama_px}}</h3>
                                                      <p class="text-muted text-center">RM : {{$pasien->no_rm}}</p>
                                                      <ul class="list-group list-group-unbordered mb-3">
                                                        <li class="list-group-item"><b>Je                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  nis Kelamin : {{$pasien->jenis_kelamin=='L'? 'Laki-Laki':'Perempuan'}}</b></li>
                                                        <li class="list-group-item"><b>Alamat : {{$pasien->alamat}}</b></li>
                                                        <li class="list-group-item"><b>NIK : {{$pasien->nik_bpjs}}</b></li>
                                                        <li class="list-group-item"><b>BPJS : {{$pasien->no_Bpjs==null ? 'tidak punya bpjs' : $pasien->no_Bpjs}}</b></li>
                                                        <li class="list-group-item"><b>Telp : {{$pasien->no_telp== null ? $pasien->no_hp : $pasien->no_telp }}</b></li>
                                                      </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <x-adminlte-input name="sep_nama_pasien" label="Nama Pasien" value="{{$pasien->nama_px}}" disabled fgroup-class="col-md-6" disable-feedback/>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <x-slot name="footerSlot">
                                    <x-adminlte-button class="mr-auto" theme="primary" label="Simpan Data"/>
                                    <x-adminlte-button theme="danger" label="batal" data-dismiss="modal"/>
                                </x-slot>
                            </x-adminlte-modal>
                        </div>
                        <div class="card-body">
                        <p>Cari Data <code>Rujukan</code> atau <code>Riwayat SEP</code> pasien: </p>
                        <a class="btn btn-app bg-success" ><i class="fas fa-external-link-alt"></i> Rujukan </a>
                        <a class="btn btn-app bg-danger"><i class="fas fa-clipboard-list"></i> Riwayat SEP </a>
                        <p>Surat Kontrol <code>(SK)</code>  :</p>
                        <a class="btn btn-app bg-warning"><i class="fas fa-edit"></i>Buat <code>(SK)</code> </a>
                        <a class="btn btn-app bg-info"><i class="fas fa-search"></i>Cari <code>(SK)</code> </a> 
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <p><code>NO SEP :</code></p>
                            <button type="button" class="btn btn-block bg-gradient-success btn-sm mb-2">{{$pasien->nik_bpjs}}</button>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-md-9">
                <div class="row">
                    <div class="col-lg-12" >
                        <x-adminlte-card theme="purple" id="div_rajal"  icon="fas fa-info-circle" collapsible title="Form Pendaftaran Pasien RAWAT JALAN">
                            <div class="col-lg-12" >
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="col-md-12">
                                           <div class="row">
                                            <div class="col-md-6">
                                                <x-adminlte-input name="nama_pasien" value="{{$pasien->nama_px}}" disabled label="Nama Pasien" enable-old-support>
                                                    <x-slot name="prependSlot"><div class="input-group-text text-olive">{{$pasien->no_rm}}</div></x-slot>
                                                </x-adminlte-input>
                                            </div>
                                            <div class="col-md-6">
                                                <x-adminlte-input name="unit_ugd_id" value="1002" disabled label="Daftar UGD" placeholder="UGD" enable-old-support>
                                                    <x-slot name="prependSlot"><div class="input-group-text text-olive">UGD</div></x-slot>
                                                    <x-slot name="bottomSlot"><a href="#">{{$lay_head1[0]->no_trx_layanan}}</a></x-slot>
                                                </x-adminlte-input>
                                            </div>
                                           </div>
                                        </div>        
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <x-adminlte-select2 name="dokter_id" label="Pilih Dokter">
                                                        <option value="" >--Pilih Dokter--</option>
                                                        @foreach ($paramedis as $item)
                                                            <option value="{{ $item->ID }}">{{$item->nama_paramedis}}</option>
                                                        @endforeach
                                                    </x-adminlte-select2>
                                                </div>
                                                <div class="col-md-6">
                                                    @php
                                                    $config = ['format' => 'YYYY-MM-DD'];
                                                    @endphp
                                                    <x-adminlte-input-date name="tanggal_daftar" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                                        label="Tanggal" :config="$config" />
                                                </div>
                                            </div>
                                        </div>
                    
                                       <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <x-adminlte-select2 name="penjamin_id" label="Pilih Penjamin">
                                                    <option value="" >--Pilih Penjamin--</option>
                                                    @foreach ($penjamin as $item)
                                                        <option value="{{ $item->kode_penjamin }}">{{$item->nama_penjamin}}</option>
                                                    @endforeach
                                                </x-adminlte-select2>
                                            </div>
                                            <div class="col-md-6">
                                                <x-adminlte-select2 name="alasan_masuk_id" label="Alasan Pendaftaran">
                                                    <option value="" >--Pilih Alasan--</option>
                                                    @foreach ($alasanmasuk as $item)
                                                        <option value="{{ $item->id }}">{{$item->alasan_masuk}}</option>
                                                    @endforeach
                                                </x-adminlte-select2>
                                            </div>
                                        </div>
                                       </div>
                                    </div>
                                </div>
                                <x-adminlte-button type="submit" class="withLoad btn btn-sm m-1 bg-green float-right" id="submitPasien" label="Simpan Data" />
                            </div>
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
    const select = document.getElementById('pilihPendaftaran');
    const pilihUnit = document.getElementById('pilihUnit');
    function showDiv(select){
        if(select.value==0){
            document.getElementById('div_rajal').style.display = "block";
            document.getElementById('div_ranap').style.display = "none";
            document.getElementById('div_ruangan').style.display = "none";
        }else{
            document.getElementById('div_ranap').style.display = "block";
            document.getElementById('div_ruangan').style.display = "block";
            document.getElementById('div_rajal').style.display = "none";
        }
    } 
    function showUnit(pilihUnit){
        if(pilihUnit.value==0){
            document.getElementById('ugd').style.display = "block";
            document.getElementById('ugd_keb').style.display = "none";
            document.getElementById('umum').style.display = "none";
        }else if(pilihUnit.value==1){
            document.getElementById('ugd').style.display = "none";
            document.getElementById('ugd_keb').style.display = "block";
            document.getElementById('umum').style.display = "none";
        }else if(pilihUnit.value==2){
            document.getElementById('ugd').style.display = "none";
            document.getElementById('ugd_keb').style.display = "none";
            document.getElementById('umum').style.display = "block";
        }else{
            document.getElementById('ugd').style.display = "none";
            document.getElementById('ugd_keb').style.display = "none";
            document.getElementById('umum').style.display = "none";
        }
    } 
    
    function getID(rID, pasien_id) 
    {
    var ruangan_terpilih = rID;
    var pasien_id = pasien_id;
        swal.fire({
            title: 'YAKIN PILIH RUANGAN INI?',
            showDenyButton: true,
            confirmButtonText: 'Pilih Sekarang',
            denyButtonText: `Batal`,
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) 
            {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type:'POST',
                    url:"{{ route('pilih-ruangan') }}",
                    data:{ruangan_id:ruangan_terpilih,pasien_id:pasien_id},
                    success:function(data){
                        // alert(data.success);
                    },
                });
                Swal.fire('Ruangan Sudah di Pilih!', '', 'success')
                $('.modalruangan').modal('hide')
               
            } 
            else if (result.isDenied) {
                Swal.fire('Pilih Ruangan dibatalkan', '', 'info')
            }
        })
    }
</script>
@endsection