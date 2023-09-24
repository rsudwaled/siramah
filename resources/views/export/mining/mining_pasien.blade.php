<table class="table table-sm" style="text-align: center;">
    <thead>
        <tr>
            <td>no_rm</td>
            <td>no_Bpjs</td>
            <td>nama_px</td>
            <td>jenis_kelamin</td>
            <td>tempat_lahir</td>
            <td>tgl_lahir</td>
            <td>gol_darah</td>
            <td>agama</td>
            <td>status_px</td>
            <td>pendidikan</td>
            <td>kewarganegaraan</td>
            <td>negara</td>
            <td>propinsi</td>
            <td>kabupaten</td>
            <td>kecamatan</td>
            <td>desa</td>
            <td>alamat</td>
            <td>no_telp</td>
            <td>no_hp</td>
            <td>tgl_entry</td>
            <td>pic</td>
            <td>nik_bpjs</td>
            <td>kriteria_bpjs</td>
            <td>update_date</td>
            <td>update_by</td>
            <td>berat_badan</td>
            <td>DoL</td>
            <td>kode_propinsi</td>
            <td>kode_kabupaten</td>
            <td>kode_kecamatan</td>
            <td>kode_desa</td>
            <td>no_ktp</td>
            <td>email</td>
            <td>no_urut</td>
            <td>Kirim_ris_pasien</td>
            <td>rm_lama</td>
            <td>RT</td>
            <td>RW</td>
            <td>surat_kematian</td>
            <td>Pat_ihs_kode</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($pasienIn as $item)
        <tr>
            <td>{{ $item->no_rm}}</td>
            <td>{{ $item->no_Bpjs}}</td>
            <td>{{ $item->nama_px}}</td>
            <td>{{ $item->jenis_kelamin}}</td>
            <td>{{ $item->tempat_lahir}}</td>
            <td>{{ $item->tgl_lahir}}</td>
            <td>{{ $item->gol_darah}}</td>
            <td>{{ $item->agama}}</td>
            <td>{{ $item->status_px}}</td>
            <td>{{ $item->pendidikan}}</td>
            <td>{{ $item->kewarganegaraan}}</td>
            <td>{{ $item->negara}}</td>
            <td>{{ $item->propinsi}}</td>
            <td>{{ $item->kabupaten}}</td>
            <td>{{ $item->kecamatan}}</td>
            <td>{{ $item->desa}}</td>
            <td>{{ $item->alamat}}</td>
            <td>{{ $item->no_telp}}</td>
            <td>{{ $item->no_hp}}</td>
            <td>{{ $item->tgl_entry}}</td>
            <td>{{ $item->pic}}</td>
            <td>{{ $item->nik_bpjs}}</td>
            <td>{{ $item->kriteria_bpjs}}</td>
            <td>{{ $item->update_date}}</td>
            <td>{{ $item->update_by}}</td>
            <td>{{ $item->berat_badan}}</td>
            <td>{{ $item->DoL}}</td>
            <td>{{ $item->kode_propinsi}}</td>
            <td>{{ $item->kode_kabupaten}}</td>
            <td>{{ $item->kode_kecamatan}}</td>
            <td>{{ $item->kode_desa}}</td>
            <td>{{ $item->no_ktp}}</td>
            <td>{{ $item->email}}</td>
            <td>{{ $item->no_urut}}</td>
            <td>{{ $item->Kirim_ris_pasien}}</td>
            <td>{{ $item->rm_lama}}</td>
            <td>{{ $item->RT}}</td>
            <td>{{ $item->RW}}</td>
            <td>{{ $item->surat_kematian}}</td>
            <td>{{ $item->Pat_ihs_kode}}</td>
        </tr>
        @endforeach

    </tbody>
</table>
