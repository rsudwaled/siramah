
    {{-- <div class="card card-info mb-1">
        <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#colPerkembangan">
            <h3 class="card-title">
                SOAP & Perkembangan Pasien
            </h3>
        </a>
        <div id="colPerkembangan" class="collapse">
            <div class="card-body">
                <x-adminlte-button label="Input SOAP" icon="fas fa-plus" theme="success" class="btn-xs"
                    onclick="btnInputPerkembangan()" />
                <x-adminlte-button icon="fas fa-sync" theme="primary" class="btn-xs" onclick="getObservasiRanap()" />
                <a href="{{ route('print_perkembangan_ranap') }}?kunjungan={{ $kunjungan->kode_kunjungan }}" target="_blank"
                    class="btn btn-xs btn-warning"><i class="fas fa-print"></i> Print</a>
                <table class="table table-sm table-bordered table-hover" id="tablePerkembanganPasien">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Tanggal Jam</th>
                            <th>SOAP, Hasil Pemeriksaan, Analisis & Catatan Lainnya</th>
                            <th>Instruksi Medis</th>
                            <th>Ttd Pengisi,</th>
                            <th>Verifikasi DPJP</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div> --}}
@push('js')
    <x-adminlte-modal id="modalAssesmentGizi" title="Assesment Gizi" theme="warning"
        icon="fas fa-file-medical" size='xl'>
        <form id="formAssesmentGizi" name="formAssesmentGizi" method="POST">
            @csrf
            @php
                $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
            @endphp
            <input type="hidden" class="kode_kunjungan-perkembangan" name="kode_kunjungan"
                value="{{ $kunjungan->kode_kunjungan }}">
            <input type="hidden" class="counter-keperawatan" name="counter" value="{{ $kunjungan->counter }}">
            <input type="hidden" class="norm-keperawatan" name="norm" value="{{ $kunjungan->no_rm }}">
            <form action="{{ route('simrs.gizi.store.assesment') }}" method="post">
                @csrf
                <input type="hidden" name="kode_kunjungan" value="{{ $kunjungan->kode_kunjungan }}">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <u><strong>ANTROPOMETRI</strong></u>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="col-lg-12">
                                            <x-adminlte-input name="BB" id="BB" type="number" label="BB" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <x-adminlte-input name="TB" id="TB" type="number" label="TB" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <x-adminlte-input name="LILA" id="LILA" type="number" label="LILA" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <x-adminlte-input name="T_LUTUT" id="T_LUTUT" type="number"
                                                label="Tinggi Lutut" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <x-adminlte-input name="LK_ANAK" id="LK_ANAK" type="number"
                                                label="LK Anak" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <x-adminlte-input name="BB_IDEAL" id="BB_IDEAL" type="number"
                                                label="BB Ideal" />
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group ">
                                        <div class="col-lg-12">
                                            <u><strong>STATUS GIZI</strong></u>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <x-adminlte-input name="IMT" id="IMT" type="number" label="IMT" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <x-adminlte-input name="BB_U" id="BB_U" type="number" label="BB/U" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <x-adminlte-input name="TB_U" id="TB_U" type="number" label="TB/U" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <x-adminlte-input name="BB_TB" id="BB_TB" type="number" label="BB/TB" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <x-adminlte-input name="LILA_U" id="LILA_U" type="number"
                                                label="LILA/U" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="col-lg-12"><strong>RIWAYAT GIZI : </strong></div>
                            <div class="col-lg-12">
                                <ol>
                                    <li>
                                        <strong>Kebiasaan Makan Utama :</strong> <br>
                                        <table class="mb-3">
                                            <tr>
                                                <td style="width: 30%;"><strong>Pagi :</strong></td>
                                                <td style="width: 25%;"><input type="radio" id="pagi_ya"
                                                        name="makan_pagi" value="pagi_ya">
                                                    <label for="pagi_ya"><strong>YA</strong></label>
                                                </td>
                                                <td style="width: 25%; padding-left:10px;"><input type="radio"
                                                        id="pagi_tidak" name="pagi" value="pagi_tidak">
                                                    <label for="pagi_tidak"><strong>TIDAK</strong></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 30%;"><strong>Siang :</strong></td>
                                                <td style="width: 25%;"><input type="radio" id="siang_ya"
                                                        name="makan_siang" value="siang_ya">
                                                    <label for="siang_ya"><strong>YA</strong></label>
                                                </td>
                                                <td style="width: 25%; padding-left:10px;"><input type="radio"
                                                        id="siang_tidak" name="siang" value="siang_tidak">
                                                    <label for="siang_tidak"><strong>TIDAK</strong></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 30%;"><strong>Sore :</strong></td>
                                                <td style="width: 25%;"><input type="radio" id="sore_ya"
                                                        name="makan_sore" value="sore_ya">
                                                    <label for="sore_ya"><strong>YA</strong></label>
                                                </td>
                                                <td style="width: 25%; padding-left:10px;"><input type="radio"
                                                        id="sore_tidak" name="sore" value="sore_tidak">
                                                    <label for="sore_tidak"><strong>TIDAK</strong></label>
                                                </td>
                                            </tr>
                                        </table>
                                    </li>
                                    <li>
                                        <strong>Kebiasaan Selingan / Cemilan</strong>
                                        <div class="form-group row col-md-5 mb-3">
                                            <div class="input-group input-group-sm">
                                                <input name="kebiasaan_selingan_cemilan" type="text"
                                                    class="form-control">
                                                <div class="input-group-append"><button
                                                        class="btn btn-secondary btn-sm">kali/hari </button>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <strong>Alergi Makanan dan pantangan makanan :</strong>
                                        <div class="form-group row col-md-6 mb-3">
                                            <div class="input-group input-group-sm">
                                                <input name="alergi_malanan_&_pantangan_makanan" type="text"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <strong>Gangguan Gastrointestinal : </strong>
                                        <table class="mb-3">
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="form-check-input"
                                                        style="margin-left:4px;" name="gangguan_gastrointestinal[]"
                                                        value="a">
                                                    <strong style="margin-left:20px;">a. anoreksia</strong>
                                                </td>
                                                <td>
                                                    <input type="checkbox" class="form-check-input"
                                                        style="margin-left:4px;" value="b"
                                                        name="gangguan_gastrointestinal[]">
                                                    <strong style="margin-left:20px;">b. mual</strong>
                                                </td>
                                                <td>
                                                    <input type="checkbox" class="form-check-input"
                                                        style="margin-left:4px;" value="c"
                                                        name="gangguan_gastrointestinal[]">
                                                    <strong style="margin-left:20px;">c. muntah</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="form-check-input"
                                                        style="margin-left:4px;" name="gangguan_gastrointestinal[]"
                                                        value="d">
                                                    <strong style="margin-left:20px;">d. diare</strong>
                                                </td>
                                                <td>
                                                    <input type="checkbox" class="form-check-input" value="e"
                                                        name="gangguan_gastrointestinal[]" style="margin-left:4px;">
                                                    <strong style="margin-left:20px;">e. kesulitan
                                                        mengunyah</strong>
                                                </td>
                                                <td>
                                                    <input type="checkbox" class="form-check-input" value="f"
                                                        name="gangguan_gastrointestinal[]" style="margin-left:4px;">
                                                    <strong style="margin-left:20px;">f. kesulitan
                                                        menelan</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="form-check-input" value="g"
                                                        style="margin-left:4px;" name="gangguan_gastrointestinal[]">
                                                    <strong style="margin-left:20px;">g. konstipasi</strong>
                                                </td>
                                                <td>
                                                    <input type="checkbox" class="form-check-input" value="h"
                                                        name="gangguan_gastrointestinal[]" style="margin-left:4px;">
                                                    <strong style="margin-left:20px;">h. gangguan gigi
                                                        geligi</strong>
                                                </td>
                                            </tr>

                                        </table>
                                    </li>
                                    <li>
                                        <strong>Bentuk Makanan Sebelum Masuk RS :</strong>
                                        <table class="mb-3">
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="form-check-input"
                                                        style="margin-left:4px;" name="bentuk_makanan_sebelum_masuk_rs_a">
                                                    <strong style="margin-left:20px;">a. Biasa</strong>
                                                </td>
                                                <td>
                                                    <input type="checkbox" class="form-check-input"
                                                        style="margin-left:4px;">
                                                    <strong style="margin-left:20px;"
                                                        name="bentuk_makanan_sebelum_masuk_rs_b">b.
                                                        Lunak</strong>
                                                </td>
                                                <td>
                                                    <input type="checkbox" class="form-check-input"
                                                        style="margin-left:4px;">
                                                    <strong style="margin-left:20px;"
                                                        name="bentuk_makanan_sebelum_masuk_rs_c">c.
                                                        Saring</strong>
                                                </td>
                                                <td>
                                                    <input type="checkbox" class="form-check-input"
                                                        style="margin-left:4px;" name="bentuk_makanan_sebelum_masuk_rs_d">
                                                    <strong style="margin-left:20px;">d. Cair</strong>
                                                </td>
                                            </tr>
                                        </table>
                                    </li>
                                    <li>
                                        <strong>Asupan Makanan Sebelum Masuk RS :</strong>
                                        <table class="mb-3">
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="form-check-input"
                                                        style="margin-left:4px;" name="asupan_makanan_sebelum_masuk_rs_a">
                                                    <strong style="margin-left:20px;">a. Lebih</strong>
                                                </td>
                                                <td>
                                                    <input type="checkbox" class="form-check-input"
                                                        style="margin-left:4px;">
                                                    <strong style="margin-left:20px;"
                                                        name="asupan_makanan_sebelum_masuk_rs_b">b.
                                                        Baik</strong>
                                                </td>
                                                <td>
                                                    <input type="checkbox" class="form-check-input"
                                                        style="margin-left:4px;">
                                                    <strong style="margin-left:20px;"
                                                        name="asupan_makanan_sebelum_masuk_rs_c">c.
                                                        Kurang</strong>
                                                </td>
                                                <td>
                                                    <input type="checkbox" class="form-check-input"
                                                        style="margin-left:4px;" name="asupan_makanan_sebelum_masuk_rs_d">
                                                    <strong style="margin-left:20px;">d. Buruk</strong>
                                                </td>
                                            </tr>
                                        </table>
                                    </li>
                                </ol>
                            </div>
                            <div class="col-lg-12">
                                <x-adminlte-textarea igroup-size="sm" name="fisik_klinis" label="Fisik/Klinis"
                                    placeholder="silahkan masukan data fisik atau klinis" rows=5>
                                </x-adminlte-textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </form>
        <x-slot name="footerSlot">
            <button class="btn btn-success mr-auto" onclick="tambahPerkembangan()"><i class="fas fa-save"></i>
                Simpan</button>
            <x-adminlte-button theme="danger" label="Close" icon="fas fa-times" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <script>
        $(function() {
            $('#tableAssesmentGizi').DataTable({
                info: false,
                ordering: false,
                paging: false
            });
            // getPerkembanganPasien();
        });

        function btnInputAssesment() {
            $.LoadingOverlay("show");
            $("#formAssesmentGizi").trigger('reset');
            let today = moment().format('yyyy-MM-DD HH:mm:ss');
            $('#tanggal_input-perkembangan').val(today);
            $('#modalAssesmentGizi').modal('show');
            $.LoadingOverlay("hide");
        }

        function tambahAssesment() {
            $.LoadingOverlay("show");
            $.ajax({
                type: "POST",
                url: "{{ route('simrs.gizi.store.assesment') }}",
                data: $("#formAssesmentGizi").serialize(),
                dataType: "json",
                encode: true,
            }).done(function(data) {
                if (data.metadata.code == 200) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Assesment Gizi Berhasil di Tambahkan',
                    });
                    $("#formAssesmentGizi").trigger('reset');
                    getAssesmentGizi();
                    $('#modalAssesmentGizi').modal('hide');
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Error Simpan Assesment Gizi',
                    });
                }
                $.LoadingOverlay("hide");
            });
        }
        function getAssesmentGizi() {
            var url = "{{ route('simrs.gizi.get-assesment') }}?kode={{ $kunjungan->kode_kunjungan }}";
            var table = $('#tableAssesmentGizi').DataTable();
            $.ajax({
                type: "GET",
                url: url,
            }).done(function(data) {
                table.rows().remove().draw();
                if (data.metadata.code == 200) {
                    $.each(data.response, function(key, value) {
                        var btn =
                            '<button class="btn btn-xs mb-1 btn-warning" onclick="editPerkembangan(this)" data-id="' +
                            value.id +
                            '" data-tglinput="' + value.kode_kunjungan +
                            '" data-perkembangan="' + value.kode_kunjungan +
                            '" data-instruksimedis="' + value.kode_kunjungan +
                            '"><i class="fas fa-edit"></i> Edit</button> <button class="btn btn-success btn-xs mb-1" onclick="verifikasiSoap(this)" data-id="' +
                            value.id +
                            '"><i class="fas fa-check"></i> Verifikasi</button>  <button class="btn btn-xs mb-1 btn-danger" onclick="hapusPerkembangan(this)" data-id="' +
                            value.id +
                            '"><i class="fas fa-trash"></i> Hapus</button>';
                        table.row.add([
                            btn,
                            value.tanggal_input,
                            '<pre>' + value.kode_kunjungan + '</pre>',
                            '<pre>' + value.kode_kunjungan + '</pre>',
                            value.user,
                            value.kode_kunjungan,
                        ]).draw(false);
                    });
                } else {
                    Swal.fire(
                        'Mohon Maaf !',
                        data.metadata.message,
                        'error'
                    );
                }
            });
        }

        // function editPerkembangan(button) {
        //     $.LoadingOverlay("show");
        //     $("#tanggal_input-perkembangan").val($(button).data('tglinput'));
        //     $(".instruksi_medis-perkembangan").val($(button).data('instruksimedis'));
        //     $(".perkembangan-perkembangan").val($(button).data('perkembangan'));
        //     $('#modalPerkembanganPasien').modal('show');
        //     $.LoadingOverlay("hide");
        // }

        // function hapusPerkembangan(button) {
        //     $.LoadingOverlay("show");
        //     $.ajax({
        //         type: "POST",
        //         url: "{{ route('hapus_perkembangan_ranap') }}",
        //         data: {
        //             "_token": "{{ csrf_token() }}",
        //             "id": tarif = $(button).data('id')
        //         },
        //         dataType: "json",
        //         encode: true,
        //     }).done(function(data) {
        //         if (data.metadata.code == 200) {
        //             Toast.fire({
        //                 icon: 'success',
        //                 title: 'Perkembangan Ranap telah dihapuskan',
        //             });
        //             $("#formPerkembangan").trigger('reset');
        //             getPerkembanganPasien();
        //         } else {
        //             Toast.fire({
        //                 icon: 'error',
        //                 title: 'Keperawatan Ranap gagal dihapuskan',
        //             });
        //         }
        //         $.LoadingOverlay("hide");
        //     });
        // }

        // function verifikasiSoap(button) {
        //     $.LoadingOverlay("show");
        //     $.ajax({
        //         type: "POST",
        //         url: "{{ route('verifikasi_soap_ranap') }}",
        //         data: {
        //             "_token": "{{ csrf_token() }}",
        //             "id": $(button).data('id')
        //         },
        //         dataType: "json",
        //         encode: true,
        //         success: function(data) {
        //             console.log(data);
        //             if (data.metadata.code == 200) {
        //                 Toast.fire({
        //                     icon: 'success',
        //                     title: 'Perkembangan Ranap telah diverifikasi',
        //                 });
        //                 $("#formPerkembangan").trigger('reset');
        //                 getPerkembanganPasien();
        //             } else {
        //                 Toast.fire({
        //                     icon: 'error',
        //                     title: 'Keperawatan Ranap gagal diverifikasi',
        //                 });
        //             }
        //             $.LoadingOverlay("hide");
        //         },
        //         error: function(data) {
        //             console.log(data);
        //             $.LoadingOverlay("hide");
        //         }
        //     });
        // }
    </script>
@endpush
