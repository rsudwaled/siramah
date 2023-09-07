@extends('adminlte::page')

@section('title', 'Pendaftaran Pasien')
@section('content_header')
    <h1>Pendaftaran Pasien : {{$pasien->nama_px}}</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-lg-12">
                <x-adminlte-card theme="success" icon="fas fa-info-circle" collapsible="collapsed"
                        title="Data Pasien: {{$pasien->nama_px}}">
                        <div class="row">
                            <div class="col-md-3">
                                <x-adminlte-profile-widget name="{{$pasien->no_rm}}" desc="{{$pasien->nama_px}}" theme="success">
                                    <input type="hidden" value="{{$pasien->no_rm}}" id="pasien_id">
                                    <x-adminlte-profile-row-item icon="fas fa-fw fa-user-friends" title="{{$pasien->jenis_kelamin=='L'? 'Laki-Laki':'Perempuan'}}"
                                        url="#" badge="teal"/>
                                    <x-adminlte-profile-row-item icon="fas fa-fw fa-user-friends fa-flip-horizontal" title="{{$pasien->alamat}}"
                                        text="alamat" url="#" badge="lightblue"/>
                                    <x-adminlte-profile-row-item icon="fas fa-fw fa-sticky-note" title="{{$pasien->nik_bpjs}}" text="NIK"
                                        url="#" badge="navy"/>
                                    <x-adminlte-profile-row-item icon="fas fa-fw fa-sticky-note" title="{{$pasien->no_Bpjs==null ? 'tidak punya bpjs' : $pasien->no_Bpjs}}" text="No BPJS"
                                        url="#" badge="navy"/>
                                </x-adminlte-profile-widget>
                            </div>
                            <div class="col-md-8">
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
                                        <td>Catatan : {{$item->CATATAN==null? 'tidak ada' : $item->CATATAN}}</td>
                                    </tr>
                                @endforeach
                            </x-adminlte-datatable>
                            </div>
                        </div>
                    </x-adminlte-card>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <x-adminlte-card theme="info" icon="fas fa-info-circle" collapsible title="Jenis Pendaftaran">
                    <x-adminlte-select name="pendaftaran_id" id="pilihPendaftaran" label="Pilih Pendaftaran" onchange="showDiv(this)">
                        <option value="0" >RAWAT JALAN</option>
                        <option value="1" >RAWAT INAP</option>
                    </x-adminlte-select>
                </x-adminlte-card>
                <x-adminlte-card theme="warning" icon="fas fa-info-circle" collapsible title="Pilih Ruangan :">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                               @foreach ($ruangan_ranap as $item)
                                <div class="col-md-4">
                                    <x-adminlte-info-box title="{{$item->kode_unit}}" text="{{$item->nama_unit}}" data-id="{{$item->kode_unit}}" theme="success" data-toggle="modal" data-target="#ruangan{{$item->id}}"/>
                                </div>
                                <x-adminlte-modal id="ruangan{{$item->id}}" class="modalruangan" title="Daftar Kamar di : {{$item->nama_unit}}" size="xl" theme="primary"
                                    icon="fas fa-bell" v-centered static-backdrop scrollable>
                                    <div class="modal-body" >
                                        @php
                                        $kamar = \DB::connection('mysql2')->select("CALL `SP_BED_MONITORING_RUANGAN`('$item->kode_unit')");
                                        @endphp
                                        <div class="col-lg-12">
                                            <div class="row">
                                                @foreach ($kamar as $bed)
                                                <div class="col-lg-3" >
                                                    <x-adminlte-alert theme="primary" title="{{$bed->NAMA_KAMAR}}" id="id_ruangan" data-id="{{$bed->ID_RUANGAN}}">
                                                        <p id="result"></p>
                                                        NO : {{$bed->NO_BED}} ( KLS-{{$bed->ID_KELAS}} )
                                                        <x-adminlte-button type="button" onclick="getID({{$bed->ID_RUANGAN}}, {{$pasien->no_rm}});" class="ruanganterpilih" label="Pilih Ruangan" theme="warning"/>
                                                    </x-adminlte-alert>
                                                    {{-- <x-adminlte-button class="btn-flat" type="submit" label="Submit" data-id="{{$bed->NAMA_KAMAR}}" theme="success" icon="fas fa-lg fa-save"/> --}}
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <x-slot name="footerSlot">
                                        <x-adminlte-button theme="danger" label="Tutup" data-dismiss="modal"/>
                                    </x-slot>
                                </x-adminlte-modal>
                               @endforeach
                            </div>
                        </div>
                    </div>
                </x-adminlte-card>
            </div>
            <div class="col-lg-8" >
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
                                        <x-adminlte-input name="no_sep" label="NO.SEP" placeholder="masukan No SEP" enable-old-support>
                                            <x-slot name="prependSlot"><div class="input-group-text text-olive">NO SEP</div></x-slot>
                                            <x-slot name="bottomSlot"><small style="color: rgb(236, 131, 152)"><b>*masukan sep manual yang didapatkan dari vclaim</b></small></x-slot>
                                        </x-adminlte-input>
                                    </div>
                                   </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <x-adminlte-select name="pilih_pendaftaran" id="pilihUnit" label="Pilih Pendaftaran" onchange="showUnit(this)">
                                                <option value="0" >UGD</option>
                                                <option value="1" >UGD KEBIDANAN</option>
                                                <option value="2" >UMUM</option>
                                            </x-adminlte-select>
                                        </div>
                                        <div class="col-md-6"  id="ugd">
                                            <x-adminlte-input name="unit_ugd_id" value="1002" disabled label="Daftar UGD" placeholder="UGD" enable-old-support>
                                                <x-slot name="prependSlot"><div class="input-group-text text-olive">UGD</div></x-slot>
                                                <x-slot name="bottomSlot"><a href="#">{{$lay_head1[0]->no_trx_layanan}}</a></x-slot>
                                            </x-adminlte-input>
                                        </div>
                                        <div class="col-md-6" id="ugd_keb" style="display:none;">
                                            <x-adminlte-input name="unit_ugd_keb_id"  value="1023" disabled label="Daftar UGD KEBIDANAN" placeholder="UGD" enable-old-support>
                                                <x-slot name="prependSlot"><div class="input-group-text text-olive">UGD KEBIDANAN</div></x-slot>
                                                <x-slot name="bottomSlot"><a href="#">{{$lay_head2[0]->no_trx_layanan}}</a></x-slot>
                                            </x-adminlte-input>
                                        </div>
        
                                        <div class="col-md-6" id="umum" style="display:none;" >
                                            <x-adminlte-select name="unit_id" label="Pilih Unit">
                                                @foreach ($unit as $item)
                                                    <option value="{{ $item->id }}">{{$item->nama_unit}}</option>
                                                @endforeach
                                            </x-adminlte-select>
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
                <x-adminlte-card theme="success" id="div_ranap" style="display:none;"  icon="fas fa-info-circle" collapsible title="Form Pendaftaran Pasien RAWAT INAP">
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
                                            <x-adminlte-input name="no_sep" label="NO.SEP" placeholder="masukan No SEP" enable-old-support>
                                                <x-slot name="prependSlot"><div class="input-group-text text-olive">NO SEP</div></x-slot>
                                                <x-slot name="bottomSlot"><small style="color: rgb(236, 131, 152)"><b>*masukan sep manual yang didapatkan dari vclaim</b></small></x-slot>
                                            </x-adminlte-input>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12" id="umum" style="display:none;" >
                                    <x-adminlte-select2 name="unit_id" label="Pilih Unit">
                                        <option value="" >--Pilih Unit--</option>
                                        @foreach ($unit as $item)
                                            <option value="{{ $item->id }}">{{$item->nama_unit}}</option>
                                        @endforeach
                                    </x-adminlte-select2>
                                </div>
            
                               <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        @php
                                        $config = ['format' => 'YYYY-MM-DD'];
                                        @endphp
                                        <x-adminlte-input-date name="tanggal_daftar" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                            label="Tanggal Masuk" :config="$config" />
                                    </div>
                                    <div class="col-md-6">
                                        <x-adminlte-select name="kelas_pasien" label="Kelas">
                                            <option value="1" >KELAS 1</option>
                                            <option value="2" >KELAS 2</option>
                                            <option value="3" >KELAS 3</option>
                                            <option value="4" >VIP</option>
                                            <option value="5" >VVIP</option>
                                        </x-adminlte-select>
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="col-md-12">
                                        <x-adminlte-select name="ruangan" label="Ruangan" id="DaftarRuangan">
                                            @foreach ($ruangan_ranap as $item)
                                                <option value="{{ $item->id }}" data-id="{{$item->kode_unit}}">{{$item->nama_unit}}</option>
                                            @endforeach
                                        </x-adminlte-select>
                                        <x-adminlte-button label="Lihat Ruangan" data-id="" id="ruanganselected" data-toggle="modal" data-target="#modalCustom" class="bg-primary lihat-ruangan"/>
                                    </div>
                                    <x-adminlte-modal id="modalCustom" title="Daftar Ruangan :" size="lg" theme="primary"
                                            icon="fas fa-bell" v-centered static-backdrop scrollable>
                                            <div class="modal-body">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-lg-4" >
                                                            <x-adminlte-info-box title="528" text="User Registrations" icon="fas fa-lg fa-user-plus text-primary" theme="gradient-primary" icon-theme="white"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12" id="ruanganLoop">
                                                    <div class="row" id="dataRuangan">

                                                    </div>
                                                </div>
                                            </div>
                                            <x-slot name="footerSlot">
                                                <x-adminlte-button theme="danger" label="Tutup" data-dismiss="modal"/>
                                                <x-adminlte-button class="mr-auto" theme="success" label="Simpan Ruangan"/>
                                            </x-slot>
                                        </x-adminlte-modal>
                                </div> --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-adminlte-select name="penjamin_id" label="Pilih Penjamin">
                                            <option value="" >--Pilih Penjamin--</option>
                                            @foreach ($penjamin as $item)
                                                <option value="{{ $item->kode_penjamin }}">{{$item->nama_penjamin}}</option>
                                            @endforeach
                                        </x-adminlte-select>
                                    </div>
                                    <div class="col-md-6">
                                        <x-adminlte-select name="alasan_masuk_id" label="Alasan Pendaftaran">
                                            <option value="" >--Pilih Alasan--</option>
                                            @foreach ($alasanmasuk as $item)
                                                <option value="{{ $item->id }}">{{$item->alasan_masuk}}</option>
                                            @endforeach
                                        </x-adminlte-select>
                                    </div>
                                </div>
                               </div>
                               <x-adminlte-card title="kamar pasien berada di :" theme="lightblue" theme-mode="outline"
                                    icon="fas fa-bed" header-class="text-uppercase rounded-bottom border-info">
                                    apabila terdapat kesalah dalam memilih kamar pasien, silahkan hapus data kamar pasien terpilih dengan klik tombol berikut : <x-adminlte-button label="hapus kamar" theme="danger" class="btn btn-xs" icon="fas fa-ban"/>
                                </x-adminlte-card>
                            </div>
                        </div>
                        <x-adminlte-button type="submit" class="withLoad btn btn-sm m-1 bg-green float-right" id="submitPasien" label="Simpan Data" />
                    </div>
                </x-adminlte-card>
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
        }else{
            document.getElementById('div_ranap').style.display = "block";
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
               
            } 
            else if (result.isDenied) {
                Swal.fire('Pilih Ruangan dibatalkan', '', 'info')
            }
        })
    }
</script>
@endsection