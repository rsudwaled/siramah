<div class="card card-outline card-primary" style="font-size: 12px;">
    <div class="card-header">
        <h3 class="card-title">Cari Surat Kontrol</h3>
    </div>
    <div class="card-body">
        <div class="col-12 row">
            <div class="col-12">
                <form id="searchSuratKontrol" action="#" method="GET">
                    <div class="row">
                        <div class="col-12 row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="Tgl antrian">Tgl Antrian</label>
                                    <input type="date" name="tgl_antrian_pasien" class="form-control">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="No Kartu">No Kartu</label>
                                    <input type="text" name="no_kartu" value="{{$kunjungan->pasien->no_Bpjs??''}}" class="form-control">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="Filter">Filter</label>
                                    <select name="filter" id="filter" class="form-control">
                                        <option value="1">Tanggal Entri</option>
                                        <option value="2" selected>Tanggal Kontrol </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">&nbsp;</label>
                                    <button type="submit" class="btn btn-md btn-primary mt-4">Cari Data</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                
                <!-- Tabel untuk menampilkan data -->
                <table id="tableSuratKontrol" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tgl Kontrol</th>
                            <th>No Surat Kontrol</th>
                            <th>Jenis Surat</th>
                            <th>Poliklinik</th>
                            <th>Dokter</th>
                            <th>No SEP Asal</th>
                            <th>Terbit SEP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data akan dimuat di sini -->
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
<div class="card card-outline card-primary" style="font-size: 12px;">
    <div class="card-header">
        <h3 class="card-title">Pembuatan Surat Kontrol</h3>
    </div>
    <div class="card-body">
        <div class="col-12 row">
            <div class="col-12">
                <form action="#" method="POST">
                    @csrf
                    <input type="hidden" name="kode">
                    <div class="row">
                        <div class="col-12 row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="No RM">No RM</label>
                                    <input type="text" name="no_rm" value="{{ $kunjungan->no_rm ?? '' }}"
                                        class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="No Kartu">No Kartu</label>
                                    <input type="text" name="no_kartu" value="{{ $kunjungan->pasien->no_Bpjs ?? '' }}"
                                        class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Tgl Kontrol:</label>
                                    <div class="input-group input-group-md">
                                        <input type="date" class="form-control" name="tgl_kontrol">
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-info btn-flat">Cari</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="Nama Pasien">Nama Pasien</label>
                                    <input type="text" name="nama_pasien"
                                        value="{{ $kunjungan->pasien->nama_px ?? '' }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="No Sep">No SEP</label>
                                    <input type="text" name="no_sep" value="{{ $kunjungan->no_sep ?? '' }}"
                                        class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Poliklinik:</label>
                                    <div class="input-group input-group-md">
                                        <input type="date" class="form-control" name="poliklinik">
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-info btn-flat">Cari Dokter</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="Kontak">Kontak</label>
                                    <input type="text" name="kontak" value="{{ $kunjungan->pasien->no_hp ?? '' }}"
                                        class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="No Sukon">No Surat Kontrol (SPRI)</label>
                                    <input type="text" name="no_sukon" value="{{ $kunjungan->no_spri ?? '' }}"
                                        class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="Dokter">Dokter</label>
                                    <input type="text" name="dokter" class="form-control">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="Catatan">Catatan</label>
                                    <textarea name="catatan" id="catatan" cols="30" rows="3" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#searchSuratKontrol').submit(function(event) {
            event.preventDefault(); 
            let tglAntrian = $('input[name="tgl_antrian_pasien"]').val();
            let noKartu = $('input[name="no_kartu"]').val();
            let filter = $('#filter').val();

            let url = "{{route('bridging-igd.cari-sukon')}}";
            let params = {
                tgl_antrian_pasien: tglAntrian,
                no_kartu: noKartu,
                filter: filter
            };

            $.ajax({
                url: url,
                type: 'GET',
                data: params,
                success: function(response) {
                    console.log(response);
                    if (response.metadata.code == 200 && response.data.list.length > 0) {
                        let tableBody = $('#tableSuratKontrol tbody');
                        tableBody.empty();
                        $.each(response.data.list, function(index, item) {
                            let row = `<tr>
                                    <td>${item.tglRencanaKontrol}</td>
                                    <td>${item.noSuratKontrol}</td>
                                    <td>${item.jnsPelayanan}</td>
                                    <td>${item.namaPoliTujuan}</td>
                                    <td>${item.namaDokter}</td>
                                    <td>${item.noSepAsalKontrol}</td>
                                    <td>${item.terbitSEP}</td>
                                    <td>
                                        <button class="btn btn-xs btn-success" 
                                                onclick="printSuratKontrol(this)" 
                                                data-nomorsuratkontrol="1018R0011224K000030">
                                                <i class="fas fa-print"></i>
                                        </button> 
                                        <button class="btn btn-xs btn-warning" 
                                                onclick="editSuratKontrol(this)" 
                                                data-tglrencanakontrol="2024-12-10" 
                                                data-nosuratkontrol="1018R0011224K000030" 
                                                data-politujuan="ORT" 
                                                data-namapolitujuan="ORTHOPEDI" 
                                                data-nosepasalkontrol="1018R0011124V009516" 
                                                data-namadokter="RYAN LUQMAN HAMDANI" 
                                                data-kodedokter="260674">
                                                <i class="fas fa-edit"></i>
                                        </button> 
                                        <button class="btn btn-xs btn-danger" 
                                                onclick="deleteSuratKontrol(this)" 
                                                data-nomorsurat="1018R0011224K000030">
                                                <i class="fas fa-trash"></i>
                                        </button> 
                                        </td>
                                  </tr>`;
                            tableBody.append(row);
                        });
                    } else {
                        alert('Data tidak ditemukan.');
                    }
                },
                error: function(error) {
                    alert('Terjadi kesalahan saat mengambil data.');
                }
            });
        });
    });
</script>
