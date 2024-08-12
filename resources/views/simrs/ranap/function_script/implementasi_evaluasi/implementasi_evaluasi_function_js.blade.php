<script>
    $(function() {
        $('#tableKeperawatan').DataTable({
            info: false,
            ordering: false,
            paging: false
        });
        getKeperawatanRanap();
    });

    function btnInputKeperawatan() {
        $.LoadingOverlay("show");
        $("#formPerkembangan").trigger('reset');

        let today = moment().format('yyyy-MM-DD HH:mm:ss');
        $('#tanggal_input-keperawatan').val(today);
        // $('#modalInputKeperawatan').modal('show');
        $.LoadingOverlay("hide");
    }

    function tambahKeperawatan() {
        $.LoadingOverlay("show");
        $.ajax({
            type: "POST",
            url: "{{ route('simpan_keperawatan_ranap') }}",
            data: $("#formKeperawatan").serialize(),
            dataType: "json",
            encode: true,
        }).done(function(data) {
            if (data.metadata.code == 200) {
                Toast.fire({
                    icon: 'success',
                    title: 'Evaluasi Berhasil ditambahkan',
                });
                $("#formKeperawatan").trigger('reset');
                getKeperawatanRanap();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Simpan evaluasi error',
                });
            }
            $.LoadingOverlay("hide");
        });

    }

    function getKeperawatanRanap() {
        var url = "{{ route('get_keperawatan_ranap') }}?kode={{ $kunjungan->kode_kunjungan }}";
        var table = $('#tableKeperawatan').DataTable();
        $.ajax({
            type: "GET",
            url: url,
        }).done(function(data) {
            table.rows().remove().draw();
            if (data.metadata.code == 200) {
                $.each(data.response, function(key, value) {
                    var btn =
                        '<button class="btn btn-xs mb-1 btn-warning" onclick="editKeperawatan(this)" data-id="' +
                        value.id +
                        '" data-tglinput="' + value.tanggal_input +
                        '" data-keperawatan="' + value.keperawatan +
                        '"><i class="fas fa-edit"></i> Edit</button> <button class="btn btn-xs mb-1 btn-danger" onclick="hapusKeperawatan(this)" data-id="' +
                        value.id +
                        '"><i class="fas fa-trash"></i> Hapus</button>';
                    table.row.add([
                        btn,
                        value.tanggal_input,
                        '<pre>' + value.keperawatan + '</pre>',
                        value.pic,
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

    function editKeperawatan(button) {
        $.LoadingOverlay("show");
        $("#tanggal_input-keperawatan").val($(button).data('tglinput'));
        $(".keperawatan-keperawatan").val($(button).data('keperawatan'));
        $('#modalInputKeperawatan').modal('show');
        $.LoadingOverlay("hide");
    }

    function hapusKeperawatan(button) {
        $.LoadingOverlay("show");
        $.ajax({
            type: "POST",
            url: "{{ route('hapus_keperawatan_ranap') }}",
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
                    title: 'Evaluasi telah dihapuskan',
                });
                $("#formKeperawatan").trigger('reset');
                getKeperawatanRanap();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Evaluasi gagal dihapuskan',
                });
            }
            $.LoadingOverlay("hide");
        });
        $.LoadingOverlay("hide");
    }
</script>
