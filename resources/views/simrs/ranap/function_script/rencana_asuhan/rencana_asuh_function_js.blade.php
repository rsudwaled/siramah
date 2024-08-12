
<script>
    function editRencanaAsuh(button) {
        const id = $(button).data('id');
        const url ="{{ route('edit-rencana-asuhan') }}";
        $.LoadingOverlay("show");
        $.ajax({
            url: url,
            method: 'GET',
            data:{
                id:id,
            },
            success: function(data) {
                if (data.error) {
                    console.error('Error:', data.error);
                    return;
                }
                
                // Isi form dengan data yang diterima
                $('#id_asuhan').val(data.id);
                $('.tglwaktu').val(data.tgl_waktu);
                $('.profesi').val(data.profesi);
                $('#pic').val(data.pic);
                $('#kode').val(data.kode);
                $('#kode_unit').val(data.kode_unit);
                $('#rm_counter').val(data.rm_counter);
                $('#kode_kunjungan').val(data.kode_kunjungan);
                $('#counter').val(data.counter);
                $('#no_rm').val(data.no_rm);
                $('.nama').val(data.nama);
                $('.rencana_asuhan').val(data.rencana_asuhan);
                $('.capaian_diharapkan').val(data.capaian_diharapkan);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
        $.LoadingOverlay("hide");
    }

</script>

