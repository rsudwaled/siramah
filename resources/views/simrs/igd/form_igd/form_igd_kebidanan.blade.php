@extends('adminlte::page')

@section('title', 'Pasien IGD Kebidanan')
@section('content_header')
    <h1>Pasien IGD Kebidanan : {{$pasien->nama_px}}</h1>
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
                        $config['scrollY'] = '450px';
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
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                      <button type="button" class="btn btn-block bg-gradient-success btn-sm mb-2">BUAT SEP</button>
                    </div>
                    <div class="card-body">
                      <p>Cari Data <code>Rujukan</code> atau <code>Riwayat SEP</code> pasien: </p>
                      <a class="btn btn-app bg-success"><i class="fas fa-external-link-alt"></i> Rujukan </a>
                      <a class="btn btn-app bg-danger"><i class="fas fa-clipboard-list"></i> Riwayat SEP </a>
                      <p>Surat Kontrol <code>(SK)</code>  :</p>
                      <a class="btn btn-app bg-warning"><i class="fas fa-edit"></i>Buat <code>(SK)</code> </a>
                      <a class="btn btn-app bg-info"><i class="fas fa-search"></i>Cari <code>(SK)</code> </a> 
                    </div>
                  </div>
            </div>
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
                                                <x-adminlte-input name="unit_ugd_keb_id"  value="1023" disabled label="Daftar UGD KEBIDANAN" placeholder="UGD" enable-old-support>
                                                    <x-slot name="prependSlot"><div class="input-group-text text-olive">UGD KEBIDANAN</div></x-slot>
                                                    <x-slot name="bottomSlot"><a href="#">{{$lay_head2[0]->no_trx_layanan}}</a></x-slot>
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