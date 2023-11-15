       <div class="card card-info mb-1">
           <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#cRincian">
               <h3 class="card-title">
                   Rincian Biaya
               </h3>
               <div class="card-tools">
                   {{ money($biaya_rs, 'IDR') }}
                   <i class="fas fa-file-invoice-dollar"></i>
               </div>
           </a>
           <div id="cRincian" class="collapse" role="tabpanel">
               <div class="card-body">
                   <table class="table table-bordered table-sm table-hover">
                       <thead>
                           <tr>
                               <th>Tanggal
                               <th>Nama Unit</th>
                               <th>Group Vclaim</th>
                               <th>Nama Tarif</th>
                               <th>Grand Total Tarif</th>
                               </th>
                           </tr>
                       </thead>
                       <tbody>
                           @foreach ($pasien->kunjungans->where('counter', $kunjungan->counter) as $kjg)
                               @foreach ($kjg->layanans->where('status_retur', 'OPN') as $item)
                                   <tr>
                                       <td>{{ $item->tgl_entry }}</td>
                                       <td>{{ $item->kode_layanan_header }}</td>
                                       <td>{{ money($item->total_layanan, 'IDR') }}</td>
                                       <td></td>
                                       <td></td>
                                   </tr>
                               @endforeach
                               @php
                                   $total = $total + $kjg->layanans->where('status_retur', 'OPN')->sum('total_layanan');
                               @endphp
                           @endforeach
                           <tr>
                               <td></td>
                               <td></td>
                               <td>{{ money($total, 'IDR') }} </td>
                               <td></td>
                               <td></td>
                           </tr>
                       </tbody>
                   </table>
               </div>
           </div>
       </div>
