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
                                <div class="row">
                                    <div class="col-lg-12 ml-2">
                                        <button class="btn btn-block bg-gradient-warning btn-flat"
                                                data-toggle="modal" 
                                                data-target="#modalBPJSPROSES">BPJS Lagi PROSES</button>
                                        <form action="" id="postPernyataan" method="post">
                                        <x-adminlte-modal id="modalBPJSPROSES" title="Buat Surat Pernyataan BPJS PROSES" size="md" theme="success"
                                            v-centered static-backdrop>
                                                <div class="modal-body">
                                                    <div class="col-lg-12">
                                                        <input type="hidden" name="no_rm_by_pasien" id="rm_sp" value="{{$pasien->no_rm}}">
                                                        <x-adminlte-input name="nama_pasien"  label="Pasien"  value="{{$pasien->nama_px}}" fgroup-class="col-md-12" disable-feedback/>
                                                        <x-adminlte-input name="nama_keluarga_sp" id="nama_keluarga_sp"  label="Nama Keluarga" fgroup-class="col-md-12" disable-feedback/>
                                                        <x-adminlte-input name="tlp_keluarga_sp" id="tlp_keluarga_sp"  label="Kontak Keluarga" fgroup-class="col-md-12" disable-feedback/>
                                                        <x-adminlte-select2 name="hub_keluarga_sp" required id="hub_keluarga_sp" label="Hubungan Keluarga">
                                                            @foreach ($hb_keluarga as $hbk)
                                                                <option value="{{$hbk->kode}}">{{$hbk->nama_hubungan}}</option>
                                                            @endforeach
                                                        </x-adminlte-select2>
                                                        @php $config = ['format' => 'DD-MM-YYYY']; @endphp 
                                                        <x-adminlte-input-date name="tgl_surat_pernyataan" id="tgl_surat_pernyataan" value="{{\Carbon\Carbon::parse(now())->format('Y-m-d')}}" fgroup-class="col-md-12" label="Batas Waktu Melengkapi" :config="$config"/>
                                                        <x-adminlte-textarea name="alamat_keluarga_sp" id="alamat_keluarga_sp" label="alamat keluarga" fgroup-class="col-md-12" />
                                                    </div>
                                                </div>
                                                <x-slot name="footerSlot">
                                                    <x-adminlte-button theme="danger" class="mr-auto" label="batal" data-dismiss="modal"/>
                                                    <x-adminlte-button class="withLoad" from="postPernyataan" id="submitPernyataan" theme="success" label="Simpan Data"/>
                                                </x-slot>
                                            </x-adminlte-modal>
                                        </form>
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
                                <form action="" method="post">
                                @csrf
                                <div class="modal-body">
                                    <div class="col-lg-12">
                                        <x-adminlte-callout theme="info" title="Information"><b>Status Pasien : {{$status_pendaftaran == 0 ? 'IGD' :'' }}</b></x-adminlte-callout>
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
                                                <x-adminlte-input name="sep_nama_pasien" type="hidden" value="{{$pasien->nama_px}}" disabled fgroup-class="col-md-12" disable-feedback/>
                                                <x-adminlte-input name="no_rm" value="{{$pasien->no_rm}}" type="hidden" disabled fgroup-class="col-md-12" disable-feedback/>    
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        @php $config = ['format' => 'DD-MM-YYYY']; @endphp 
                                                        <x-adminlte-input-date name="tgl_sep" value="{{\Carbon\Carbon::parse(now())->format('Y-m-d')}}" fgroup-class="col-md-12" label="Tanggal SEP" :config="$config"/>
                                                        <x-adminlte-input name="ppk_asal" value="RSUD WALED" label="PPK Asal Rujukan" disabled fgroup-class="col-md-12" disable-feedback/>    
                                                        <x-adminlte-input name="kontak" value="{{$pasien->no_telp== null ? $pasien->no_hp : $pasien->no_telp }}" label="Kontak" fgroup-class="col-md-12" disable-feedback/> 
                                                        <x-adminlte-input name="spesialis" value="UGD" label="Spesialis /Sub Spesialis" disabled fgroup-class="col-md-12" disable-feedback/>    
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <x-adminlte-select2 name="paramedis" required id="paramedis" label="DPJP">
                                                            <option value="">--pilih dpjp--</option>
                                                            @foreach ($paramedis as $u)
                                                                <option value="{{$u->kode_paramedis}}">{{$u->nama_paramedis}}</option>
                                                            @endforeach
                                                        </x-adminlte-select2>
                                                        <x-adminlte-select2 name="alasan_masuk" required id="alasan_masuk" label="Alasan Masuk">
                                                            <option value="">--pilih alasan masuk--</option>
                                                            @foreach ($alasanmasuk as $u)
                                                                <option value="{{$u->id}}">{{$u->alasan_masuk}}</option>
                                                            @endforeach
                                                        </x-adminlte-select2>
                                                        <x-adminlte-select2 name="status_kecelakaan" id="status_kecelakaan" label="Status Kecelakaan">
                                                            <option value="">--pilih status kecelakaan--</option>
                                                            <option value="0">Bukan Kecelakaan Lalu Lintas (BKLL)</option>
                                                            <option value="1">KLL & Bukan Kecelakaan Kerja (BKK)</option>
                                                            <option value="2">KLL & KK</option>
                                                            <option value="3">Kecelakaan Kerja</option>
                                                        </x-adminlte-select2>    
                                                        <x-adminlte-textarea name="diagnosa" label="Diagnosa" placeholder="Silahkan masukan diagnosa" fgroup-class="col-md-12" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <x-slot name="footerSlot">
                                    <x-adminlte-button theme="danger" class="mr-auto" label="batal" data-dismiss="modal"/>
                                    <x-adminlte-button theme="success" label="Simpan Data"/>
                                </x-slot>
                                </form>
                            </x-adminlte-modal>
                        </div>
                        <div class="card-body">
                        <p>Cari Data <code>Rujukan</code> atau <code>Riwayat SEP</code> pasien: </p>
                        <a class="btn btn-app bg-success" onclick="cariRujukan({{$pasien->no_rm}})" data-toggle="modal" data-target="#modalRujukan"><i class="fas fa-external-link-alt"></i> Rujukan </a>
                        <x-adminlte-modal id="modalRujukan" title="Rujukan dari RM:  {{$pasien->no_rm}}" size="xl" theme="success"
                            v-centered static-backdrop>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h5>Rawat Jalan</h5>
                                        @php $heads = ['No Rujukan', 'Tgl', 'Status','jenis Pelayanan','faskes','diagnosa','poli']; 
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
                                    <div class="col-lg-6">
                                        <h5>Rawat Inap</h5>
                                        @php $heads = ['No Rujukan', 'Tgl', 'Status','jenis Pelayanan','faskes','diagnosa','poli']; 
                                        $config['order'] = ['0', 'asc']; 
                                        $config['ordering'] = false; 
                                        $config['paging'] = true; 
                                        $config['info'] = false; 
                                        $config['searching'] = false; 
                                        $config['scrollY'] = '600px'; 
                                        $config['scrollCollapse'] = true; 
                                        $config['scrollX'] = true; 
                                        @endphp 
                                        <x-adminlte-datatable id="table2" class="nowrap text-xs" :heads="$heads" :config="$config" striped bordered hoverable compressed></x-adminlte-datatable>
                                    </div>
                                </div>
                            </div>
                            <x-slot name="footerSlot">
                                <x-adminlte-button theme="danger" label="batal" data-dismiss="modal"/>
                                {{-- <x-adminlte-button theme="success" label="Simpan Data"/> --}}
                            </x-slot>
                        </x-adminlte-modal>
                        <a class="btn btn-app bg-danger" data-toggle="modal" data-target="#modalRiwayaSEP"><i class="fas fa-clipboard-list"></i> Riwayat SEP </a>
                        <x-adminlte-modal id="modalRiwayaSEP" title="Riwayat SEP dari RM :  {{$pasien->no_rm}}" size="xl" theme="success"
                            v-centered static-backdrop>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h5>Rawat Jalan</h5>
                                        @php $heads = ['No Rujukan', 'Tgl', 'Status','jenis Pelayanan','faskes','diagnosa','poli']; 
                                        $config['order'] = ['0', 'asc']; 
                                        $config['ordering'] = false; 
                                        $config['paging'] = true; 
                                        $config['info'] = false; 
                                        $config['searching'] = false; 
                                        $config['scrollY'] = '600px'; 
                                        $config['scrollCollapse'] = true; 
                                        $config['scrollX'] = true; 
                                        @endphp 
                                        <x-adminlte-datatable id="table3" class="nowrap text-xs" :heads="$heads" :config="$config" striped bordered hoverable compressed></x-adminlte-datatable>
                                    </div>
                                    <div class="col-lg-6">
                                        <h5>Rawat Inap</h5>
                                        @php $heads = ['No Rujukan', 'Tgl', 'Status','jenis Pelayanan','faskes','diagnosa','poli']; 
                                        $config['order'] = ['0', 'asc']; 
                                        $config['ordering'] = false; 
                                        $config['paging'] = true; 
                                        $config['info'] = false; 
                                        $config['searching'] = false; 
                                        $config['scrollY'] = '600px'; 
                                        $config['scrollCollapse'] = true; 
                                        $config['scrollX'] = true; 
                                        @endphp 
                                        <x-adminlte-datatable id="table4" class="nowrap text-xs" :heads="$heads" :config="$config" striped bordered hoverable compressed></x-adminlte-datatable>
                                    </div>
                                </div>
                            </div>
                            <x-slot name="footerSlot">
                                <x-adminlte-button theme="danger" label="batal" data-dismiss="modal"/>
                                {{-- <x-adminlte-button theme="success" label="Simpan Data"/> --}}
                            </x-slot>
                        </x-adminlte-modal>
                        <p>Surat Kontrol <code>(SK)</code>  :</p>
                        <a class="btn btn-app bg-warning" data-toggle="modal" data-target="#modalBuatSK"><i class="fas fa-edit"></i>Buat <code>(SK)</code> </a>
                        <x-adminlte-modal id="modalBuatSK" title="Buat Surat Kontrol untuk RM : {{$pasien->no_rm}}" size="md" theme="success"
                            v-centered static-backdrop>
                            <form action="" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="col-lg-12">
                                    <x-adminlte-input name="no_bpjs" value="{{$pasien->no_Bpjs==null ? 'tidak punya bpjs' : $pasien->no_Bpjs}}" label="No Kartu" fgroup-class="col-md-12" disable-feedback/>  
                                    <x-adminlte-select2 name="jenis_surat" required id="jenis_surat" label="Poli">
                                        <option value="">--Jenis Surat--</option>
                                        <option value="surat_kontrol">Surat Kontrol</option>
                                        <option value="spri">SPRI</option>
                                    </x-adminlte-select2>
                                    <x-adminlte-select2 name="poli_kontrol" required id="poli_kontrol" label="Poli">
                                        <option value="">--pilih poli--</option>
                                        @foreach ($unit as $u)
                                            <option value="{{$u->kode_unit}}">{{$u->nama_unit}}</option>
                                        @endforeach
                                    </x-adminlte-select2>
                                    @php $config = ['format' => 'DD-MM-YYYY']; @endphp 
                                    <x-adminlte-input-date name="tgl_sk" value="{{\Carbon\Carbon::parse(now())->format('Y-m-d')}}" fgroup-class="col-md-12" label="Tanggal Kontrol" :config="$config"/>
                                    <x-adminlte-select2 name="dokter_kontrol" required id="dokter_kontrol" label="Dokter">
                                        <option value="">--pilih dokter--</option>
                                        @foreach ($paramedis as $u)
                                            <option value="{{$u->kode_paramedis}}">{{$u->nama_paramedis}}</option>
                                        @endforeach
                                    </x-adminlte-select2>
                                </div>
                            </div>
                            <x-slot name="footerSlot">
                                <x-adminlte-button theme="danger" class="mr-auto" label="batal" data-dismiss="modal"/>
                                <x-adminlte-button theme="success" label="Simpan Data"/>
                            </x-slot>
                            </form>
                        </x-adminlte-modal>
                        <a class="btn btn-app bg-info" data-toggle="modal" data-target="#modalSK"><i class="fas fa-search"></i>Cari <code>(SK)</code> </a>
                        <x-adminlte-modal id="modalSK" title="Cari Surat Kontrol/SPRI dari RM: {{$pasien->no_rm}}" size="xl" theme="success"
                            v-centered static-backdrop>
                            <div class="modal-body">
                                <div class="col-lg-12">
                                    @php
                                    $heads = ['No Surat', 'Tgl Kontrol','Tgl Terbit', 'Status','jenis','SEP Asal','poli asal','poli tujuan','dokter','terbit sep'];
                                    $config['order'] = ['0', 'asc']; 
                                    $config['ordering'] = false; 
                                    $config['paging'] = true; 
                                    $config['info'] = false; 
                                    $config['searching'] = false; 
                                    $config['scrollY'] = '600px'; 
                                    $config['scrollCollapse'] = true; 
                                    $config['scrollX'] = true; 
                                    @endphp 
                                    <x-adminlte-datatable id="table5" class="nowrap text-xs" :heads="$heads" :config="$config" striped bordered hoverable compressed></x-adminlte-datatable>
                                </div>
                            </div>
                            <x-slot name="footerSlot">
                                <x-adminlte-button theme="danger" class="mr-auto" label="batal" data-dismiss="modal"/>
                            </x-slot>
                        </x-adminlte-modal> 
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

    $("#submitPernyataan").click(function(e){
  
    e.preventDefault();

    var nama_keluarga_sp = $("#nama_keluarga_sp").val();
    var rm_sp = $("#rm_sp").val();
    var alamat_keluarga_sp = $("#alamat_keluarga_sp").val();
    var tlp_keluarga_sp = $("#tlp_keluarga_sp").val();
    var tgl_surat_pernyataan_sp = $("#tgl_surat_pernyataan").val();
    var hub_keluarga_sp = $("#hub_keluarga_sp").val();
    let token   = $("meta[name='csrf-token']").attr("content");
    $.ajax({
        type:'POST',
        url:"{{ route('surat-pernyataan.bpjsproses') }}",
        data:{
            rm_sp:rm_sp, 
            nama_keluarga_sp:nama_keluarga_sp, 
            tlp_keluarga_sp:tlp_keluarga_sp, 
            tgl_surat_pernyataan_sp:tgl_surat_pernyataan_sp,
            hub_keluarga_sp:hub_keluarga_sp,
            alamat_keluarga_sp:alamat_keluarga_sp,
            _token:token,
        },
        success:function(data){
            $('#modalBPJSPROSES').modal('hide');
            $.LoadingOverlay("hide");
            Swal.fire('pernyataan berhasil dibuat', '', 'success');
        }
    });

    });

    function cariRujukan(rm)
    {
        var rujukan_rm = rm;
        $('#modalRujukan').show();
    }
</script>
@endsection