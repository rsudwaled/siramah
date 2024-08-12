<script>
    $(function() {
        $('#tablePerkembanganPasien').DataTable({
            info: false,
            ordering: false,
            paging: false
        });
        getPerkembanganPasien();
    });

    function btnSavePerkembangan() {
        $.LoadingOverlay("show");
        $.ajax({
            type: "POST",
            url: "{{ route('simpan_perkembangan_ranap') }}",
            data: $("#formPerkembangan").serialize(),
            dataType: "json",
        }).done(function(data) {
            $.LoadingOverlay("hide");
            if (data.metadata.code == 200) {
                Swal.fire({
                    icon: 'success',
                    title: 'Data SOAP Berhasil Disimpan',
                    timer: 5000
                });
                $("#formPerkembangan").trigger('reset');
                getPerkembanganPasien();
            } else if (data.metadata.code == 422) {
                var errorMsg = '';
                $.each(data.errors, function(field, messages) {
                    errorMsg += field + ': ' + messages.join(', ') + '\n';
                });

                console.info("Error Message:", errorMsg);

                Swal.fire({
                    icon: 'error',
                    title: 'Upps... ada inputan yang belum diisi',
                    text: errorMsg.trim(),
                    timer: 10000
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Data SOAP Gagal Simpan',
                    timer: 5000
                });
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            $.LoadingOverlay("hide");

            console.log('AJAX Error:', {
                status: jqXHR.status,
                statusText: jqXHR.statusText,
                responseText: jqXHR.responseText,
                textStatus: textStatus,
                errorThrown: errorThrown
            });

            var errorMsg = 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.';

            try {
                var response = JSON.parse(jqXHR.responseText);
                if (response.errors) {
                    errorMsg = '';
                    $.each(response.errors, function(field, messages) {
                        errorMsg += field + ': ' + messages.join(', ') + '\n';
                    });
                } else if (response.metadata && response.metadata.message) {
                    errorMsg = response.metadata.message;
                }
            } catch (e) {
                console.error('Error parsing JSON response:', e);
            }

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: errorMsg.trim(),
                timer: 10000
            });
        });
    }


    function getPerkembanganPasien() {
        var url = "{{ route('get_perkembangan_ranap') }}?kode={{ $kunjungan->kode_kunjungan }}";
        var table = $('#tablePerkembanganPasien').DataTable();
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
                        '" data-tglinput="' + value.tanggal_input +
                        '" data-perkembangan="' + value.perkembangan +
                        '" data-instruksimedis="' + value.instruksi_medis +
                        '"><i class="fas fa-edit"></i> Edit</button><button class="btn btn-xs mb-1 btn-danger" onclick="hapusPerkembangan(this)" data-id="' +
                        value.id +
                        '"><i class="fas fa-trash"></i> Hapus</button>';
                    var btnVerify =
                        '<button class="btn btn-success btn-xs mb-1" onclick="verifikasiSoap(this)" data-id="' +
                        value.id + '"><i class="fas fa-check"></i> Verifikasi</button>';
                    var btnCancelVerify =
                        '<button class="btn btn-danger btn-xs mb-1" onclick="batalkanVerifikasiSoap(this)" data-id="' +
                        value.id + '"><i class="fas fa-times"></i> Batalkan</button>';

                    var verifikasi = value.verifikasi_by === null ? btnVerify : value.verifikasi_by +
                        ' ' + btnCancelVerify;

                    table.row.add([
                        btn,
                        value.tanggal_input,
                        '<pre>' + value.perkembangan + '</pre>',
                        '<pre>' + value.instruksi_medis + '</pre>',
                        value.pic,
                        verifikasi,
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

    function editPerkembangan(button) {
        $.LoadingOverlay("show");
        $("#tanggal_input-perkembangan").val($(button).data('tglinput'));
        $(".instruksi_medis-perkembangan").val($(button).data('instruksimedis'));
        $(".perkembangan-perkembangan").val($(button).data('perkembangan'));
        $('#modalPerkembanganPasien').modal('show');
        $.LoadingOverlay("hide");
    }

    function hapusPerkembangan(button) {
        $.LoadingOverlay("show");
        $.ajax({
            type: "POST",
            url: "{{ route('hapus_perkembangan_ranap') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": tarif = $(button).data('id')
            },
            dataType: "json",
            encode: true,
        }).done(function(data) {
            if (data.metadata.code == 200) {
                Toast.fire({
                    icon: 'success',
                    title: 'Perkembangan Ranap telah dihapuskan',
                });
                $("#formPerkembangan").trigger('reset');
                getPerkembanganPasien();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Keperawatan Ranap gagal dihapuskan',
                });
            }
            $.LoadingOverlay("hide");
        });
    }

    function verifikasiSoap(button) {
        $.LoadingOverlay("show");
        $.ajax({
            type: "POST",
            url: "{{ route('verifikasi_soap_ranap') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": $(button).data('id')
            },
            dataType: "json",
            encode: true,
            success: function(data) {
                console.log(data);
                if (data.metadata.code == 200) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Perkembangan Ranap telah diverifikasi',
                    });
                    $("#formPerkembangan").trigger('reset');
                    getPerkembanganPasien();
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Keperawatan Ranap gagal diverifikasi',
                    });
                }
                $.LoadingOverlay("hide");
            },
            error: function(data) {
                console.log(data);
                $.LoadingOverlay("hide");
            }
        });
    }

    function batalkanVerifikasiSoap(button) {
        $.LoadingOverlay("show");
        $.ajax({
            type: "POST",
            url: "{{ route('cancel_verifikasi_soap_ranap') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": $(button).data('id')
            },
            dataType: "json",
            encode: true,
            success: function(data) {
                console.log(data);
                if (data.metadata.code == 200) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Verifikasi dibatalkan',
                    });
                    $("#formPerkembangan").trigger('reset');
                    getPerkembanganPasien();
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'batalkan verifikasi gagal',
                    });
                }
                $.LoadingOverlay("hide");
            },
            error: function(data) {
                console.log(data);
                $.LoadingOverlay("hide");
            }
        });
    }
</script>
