{{-- <div class="col-md-12" style="font-size: 12px;">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">DATA PENUNJANG</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills" style="font-size: 14px;">
                        <li class="nav-item">
                            <a class="nav-link active" href="#table-penujang-radiologi" data-toggle="tab">Radiologi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tab-lab-patologi" data-toggle="tab">Lab Patologi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tab-berkas-penunjang" data-toggle="tab">Berkas</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="table-penujang-radiologi">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Data Radiologi</h3>
                                    <div class="card-tools">
                                        <div class="input-group input-group-sm" style="width: 150px;">
                                            <input type="text" name="table_search" class="form-control float-right"
                                                placeholder="Search">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="card-body table-responsive p-0" style="height: 150px;">
                                    <table class="table table-head-fixed text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Tanggal Masuk</th>
                                                <th>Kode Kunjungan</th>
                                                <th>Pasien</th>
                                                <th>Unit</th>
                                                <th>Pemeriksaan</th>
                                                <th>Berkas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $radiologi)
                                                <tr>
                                                    <td>{{ $radiologi['tgl_masuk'] }}</td>
                                                    <td>{{ $radiologi['kode_kunjungan'] }}</td>
                                                    <td>{{ $radiologi['nama_px'] }}</td>
                                                    <td>{{ $radiologi['nama_unit'] }}</td>
                                                    <td>{{ $radiologi['pemeriksaan'] }}</td>
                                                    <td>
                                                        <button class="btn btn-xs btn-primary" onclick="lihatHasilRongsen(this)"
                                                            data-norm="{{ $radiologi['no_rm'] }}">Rontgen</button>
                                                        <button class="btn btn-xs btn-success" onclick="lihatExpertiseRad(this)"
                                                            data-header="{{ $radiologi['header_id'] }}"
                                                            data-detail="{{ $radiologi['detail_id'] }}">Expertise</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
        
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-lab-patologi">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Data Lab Patologi</h3>
                                    <div class="card-tools">
                                        <div class="input-group input-group-sm" style="width: 150px;">
                                            <input type="text" name="table_search" class="form-control float-right"
                                                placeholder="Search">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body table-responsive p-0" style="height: 150px;">
                                    <table class="table table-head-fixed text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Tanggal Masuk</th>
                                                <th>Kode Kunjungan</th>
                                                <th>Pasien</th>
                                                <th>Unit</th>
                                                <th>Pemeriksaan</th>
                                                <th>Berkas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($labpatologi as $patologi)
                                                <tr>
                                                    <td>{{ $patologi['tgl_masuk'] }}</td>
                                                    <td>{{ $patologi['kode_kunjungan'] }}</td>
                                                    <td>{{ $patologi['nama_px'] }}</td>
                                                    <td>{{ $patologi['nama_unit'] }}</td>
                                                    <td>{{ $patologi['pemeriksaan'] }}</td>
                                                    <td>
                                                        <button class="btn btn-xs btn-primary" onclick="showHasilPa(this)"
                                                            data-kode="{{ $patologi['detail_id'] }}">Lihat</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-berkas-penunjang">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Data Berkas Penunjang</h3>
                                    <div class="card-tools">
                                        <div class="input-group input-group-sm" style="width: 150px;">
                                            <input type="text" name="table_search" class="form-control float-right"
                                                placeholder="Search">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body table-responsive p-0" style="height: 150px;">
                                    <table class="table table-head-fixed text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Tanggal Masuk</th>
                                                <th>Kode Kunjungan</th>
                                                <th>Pasien</th>
                                                <th>Unit</th>
                                                <th>Pemeriksaan</th>
                                                <th>Berkas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($files as $item)
                                                <tr>
                                                    <td>{{ $item->tanggalscan }}</td>
                                                    <td>{{ $item->norm }}</td>
                                                    <td>{{ $item->nama }}</td>
                                                    <td>{{ $item->namafile }}</td>
                                                    <td>{{ $item->jenisberkas }}</td>
                                                    <td>
                                                        <button class="btn btn-xs btn-primary" onclick="lihatFile(this)"
                                                            data-fileurl="{{ $item->fileurl }}">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @foreach ($fileupload as $file)
                                                <tr>
                                                    <td>{{ $file->tgl_upload }}</td>
                                                    <td>{{ $file->no_rm }}</td>
                                                    <td>{{ $file->pasien->nama_px }}</td>
                                                    <td>{{ $file->nama ?? $file->gambar }}</td>
                                                    <td>File</td>
                                                    <td>
                                                        <button class="btn btn-xs btn-primary" onclick="lihatFile(this)"
                                                            data-fileurl="http://192.168.2.45/files/{{ $file->gambar }}">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<div class="card card-penunjang" style="font-size: 12px;">
    <div class="card-header p-2">
        <div class="col-12 row">
            <div class="col-11">
                <ul class="nav nav-pills" style="font-size: 14px;">
                    <li class="nav-item">
                        <a class="nav-link active" href="#table-penujang-radiologi" data-toggle="tab">Radiologi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tab-lab-patologi" data-toggle="tab">Lab Patologi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tab-berkas-penunjang" data-toggle="tab">Berkas</a>
                    </li>
                </ul>
            </div>
            <div class="col-1 text-right">
                <button class="btn btn-xs btn-danger text-right tutup-tab-penunjang" ><i class="far fa-window-close"></i></button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane active" id="table-penujang-radiologi">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Radiologi</h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right"
                                    placeholder="Search">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0" style="height: 150px;">
                        <table class="table table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>Tanggal Masuk</th>
                                    <th>Kode Kunjungan</th>
                                    <th>Pasien</th>
                                    <th>Unit</th>
                                    <th>Pemeriksaan</th>
                                    <th>Berkas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $radiologi)
                                    <tr>
                                        <td>{{ $radiologi['tgl_masuk'] }}</td>
                                        <td>{{ $radiologi['kode_kunjungan'] }}</td>
                                        <td>{{ $radiologi['nama_px'] }}</td>
                                        <td>{{ $radiologi['nama_unit'] }}</td>
                                        <td>{{ $radiologi['pemeriksaan'] }}</td>
                                        <td>
                                            <button class="btn btn-xs btn-primary" onclick="lihatHasilRongsen(this)"
                                                data-norm="{{ $radiologi['no_rm'] }}">Rontgen</button>
                                            <button class="btn btn-xs btn-success" onclick="lihatExpertiseRad(this)"
                                                data-header="{{ $radiologi['header_id'] }}"
                                                data-detail="{{ $radiologi['detail_id'] }}">Expertise</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div class="tab-pane" id="tab-lab-patologi">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Lab Patologi</h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right"
                                    placeholder="Search">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0" style="height: 150px;">
                        <table class="table table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>Tanggal Masuk</th>
                                    <th>Kode Kunjungan</th>
                                    <th>Pasien</th>
                                    <th>Unit</th>
                                    <th>Pemeriksaan</th>
                                    <th>Berkas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($labpatologi as $patologi)
                                    <tr>
                                        <td>{{ $patologi['tgl_masuk'] }}</td>
                                        <td>{{ $patologi['kode_kunjungan'] }}</td>
                                        <td>{{ $patologi['nama_px'] }}</td>
                                        <td>{{ $patologi['nama_unit'] }}</td>
                                        <td>{{ $patologi['pemeriksaan'] }}</td>
                                        <td>
                                            <button class="btn btn-xs btn-primary" onclick="showHasilPa(this)"
                                                data-kode="{{ $patologi['detail_id'] }}">Lihat</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab-berkas-penunjang">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Berkas Penunjang</h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right"
                                    placeholder="Search">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0" style="height: 150px;">
                        <table class="table table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>Tanggal Masuk</th>
                                    <th>Kode Kunjungan</th>
                                    <th>Pasien</th>
                                    <th>Unit</th>
                                    <th>Pemeriksaan</th>
                                    <th>Berkas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($files as $item)
                                    <tr>
                                        <td>{{ $item->tanggalscan }}</td>
                                        <td>{{ $item->norm }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->namafile }}</td>
                                        <td>{{ $item->jenisberkas }}</td>
                                        <td>
                                            <button class="btn btn-xs btn-primary" onclick="lihatFile(this)"
                                                data-fileurl="{{ $item->fileurl }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                @foreach ($fileupload as $file)
                                    <tr>
                                        <td>{{ $file->tgl_upload }}</td>
                                        <td>{{ $file->no_rm }}</td>
                                        <td>{{ $file->pasien->nama_px }}</td>
                                        <td>{{ $file->nama ?? $file->gambar }}</td>
                                        <td>File</td>
                                        <td>
                                            <button class="btn btn-xs btn-primary" onclick="lihatFile(this)"
                                                data-fileurl="http://192.168.2.45/files/{{ $file->gambar }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-adminlte-modal id="modalRongsen" name="modalRongsen" title="Hasil Rontgen Pasien" theme="success"
    icon="fas fa-file-medical" size="lg">
    <iframe id="dataUrlRongsen" src="" height="600px" width="100%" title="Iframe Example"></iframe>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="danger" label="Tutup" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
<x-adminlte-modal id="midalFileLihat" name="midalFileLihat" title="Lihat File Upload Rekam Medis" theme="success"
    icon="fas fa-file-medical" size="lg">
    <iframe id="dataUrlFile" src="" height="600px" width="100%" title="Iframe Example"></iframe>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="danger" label="Tutup" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
<x-adminlte-modal id="modalLabPA" name="modalLabPA" title="Hasil Patologi Anatomi Pasien" theme="success"
    icon="fas fa-file-medical" size="lg">
    <iframe id="dataHasilLabPa" src="" height="600px" width="100%" title="Iframe Example"></iframe>
    <x-slot name="footerSlot">
        <a href="" id="urlHasilLabPa" target="_blank" class="btn btn-primary mr-auto">
            <i class="fas fa-download "></i>Download</a>
        <x-adminlte-button theme="danger" label="Tutup" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
@push('scripts')
    <script>
        function lihatExpertiseRad(button) {
            var header = $(button).data('header');
            var detail = $(button).data('detail');
            var url = "http://192.168.2.233/expertise/cetak0.php?IDs=" + header + "&IDd=" + detail +
                "&tgl_cetak={{ now()->format('Y-m-d') }}";
            $('#dataUrlRongsen').attr('src', url);
            $('#modalRongsen').modal('show');
        }

        function lihatFile(button) {
            var url = $(button).data('fileurl');
            $('#dataUrlFile').attr('src', url);
            $('#midalFileLihat').modal('show');
        }

        function showHasilPa(button) {
            var kode = $(button).data('kode');
            var url = "http://192.168.2.212:81/simrswaled/SimrsPrint/printEX/" +
                kode;
            $('#dataHasilLabPa').attr('src', url);
            $('#urlHasilLabPa').attr('href', url);
            $('#modalLabPA').modal('show');
        }
    </script>
@endpush
