@extends('adminlte::page')

@section('title', 'Pendaftaran Pasien')
@section('content_header')
    <h1>Pendaftaran Pasien</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
            <div class="row">
                <div class="col-md-12">
                    <x-adminlte-card theme="success" icon="fas fa-info-circle" collapsible
                        title="Daftar Pasien">
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="hidden" value="{{$antrian->id}}" id="antrian">
                                <x-adminlte-small-box title="{{$antrian->no_antri}}" text="No Antrian" icon="fas fa-users text-white" theme="primary" url="#" url-text=""/>
                            </div>
                            <div class="col-lg-12">
                                <form action="" method="POST">
                                    <div class="row">
                                      <div class="col-lg-12">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control mr-2"   placeholder="cari NIK Pasien" id="nik">
                                                <input type="text" class="form-control mr-2"   placeholder="cari nama pasien" id="nama" >
                                                <input type="text" class="form-control mr-2"   placeholder="cari RM pasien" id="norm">
                                                <input type="text" class="form-control mr-2"   placeholder="cari BPJS" id="nobpjs">
                                                <input type="text" class="form-control mr-2"   placeholder="cari Alamat" id="alamat">
                                                <div class="input-group-prepend withLoad" >
                                                    <x-adminlte-button label="Cari Pasien" theme="primary" icon="fas fa-search" id="search"/>
                                                    <x-adminlte-button label="Refresh" theme="danger" icon="fas fa-retweet" onClick="window.location.reload();"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @php
                            $heads = ['Tgl Entri', 'No RM', 'NIK', 'No BPJS', 'Nama', 'Alamat'];
                            $config['order'] = ['0', 'asc'];
                            $config['paging'] = false;
                            $config['info'] = false;
                            $config['scrollY'] = '450px';
                            $config['scrollCollapse'] = true;
                            $config['scrollX'] = true;
                        @endphp
                        <x-adminlte-datatable id="table1" class="text-xs" :heads="$heads" :config="$config"
                            striped bordered hoverable compressed>
                        </x-adminlte-datatable>
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
         var nama = $('#nama').val();
         var norm = $('#norm').val();
         var nik = $('#nik').val();
         var nobpjs = $('#nobpjs').val();
         var alamat = $('#alamat').val();
         
         $.post('{{ route("pasien-search") }}',
          {
             _token: $('meta[name="csrf-token"]').attr('content'),
             nama:nama,
             norm:norm,
             nik:nik,
             nobpjs:nobpjs,
             alamat:alamat,
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
    var no = document.getElementById("antrian").value;
    // alert(no);
    for(let i = 0; i < res.pasien.length; i++){
        var rm = res.pasien[i].no_rm;
        var pasien_antri = res.pasien[i].no_rm+'-'+no;
        htmlView += `
            <tr class="nowrap">
                <td>`+res.pasien[i].tgl_entry+`</td>
                <td> <a href="{{route('pasien-daftar.norm')}}?rm_antrian=`+pasien_antri+`">`+rm+`</a></td>
                <td>`+res.pasien[i].nik_bpjs+`</td>
                <td>`+res.pasien[i].no_Bpjs+`</td>
                <td>`+res.pasien[i].nama_px+`</td>
                <td>`+res.pasien[i].alamat+`</td>
            </tr>`;
    }
        $('tbody').html(htmlView);
        
    }

    </script>
@endsection