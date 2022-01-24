    $("#formTamuKeluar").on('submit', function() {
        var formAction = $("#formTamuKeluar").attr('action');
        var dataTamu = {
            token_tamu : $('#token_tamu').val(),
            submit : $('#submit').val(),
            bukutamu_token : $('.csrf_token').val()
        };

        Swal.fire({
            title: 'Tunggu!',
            text: 'Memvalidasi data tamu...',
            showConfirmButton: false,
            type: 'info'
        }).then(setTimeout(() =>
            $.ajax({
                type: "POST",
                url: formAction,
                data: dataTamu,
                dataType: 'json',
                error: function(xhr, status, error) {
                    var data = 'Mohon refresh kembali halaman ini. ' + '(status code: ' + xhr.status + ')';
                    Swal.fire({
                        title: 'Terjadi Kesalahan!',
                        text: data,
                        showConfirmButton: false,
                        type: 'error'
                    })
                },
                success: function(data) {
                    
                    $('.csrf_token').val(data.token);
                    $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);

                    if (data.result == 1) {
                        Swal.fire('Berhasil!', data.msg, 'success');
                        document.getElementById("formTamuKeluar").reset();
                    } else {
                        Swal.fire('Gagal!', data.msg, 'error');
                    }
                }
            })
        ,1000))
        return false;
    });