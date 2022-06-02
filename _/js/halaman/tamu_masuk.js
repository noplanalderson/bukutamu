let camera_button = document.querySelector("#start-camera");
let video = document.querySelector("#video");
let click_button = document.querySelector("#click-photo");
let canvas = document.querySelector("#canvas");
let dataurl = document.querySelector("#dataurl");
let dataurl_container = document.querySelector("#dataurl-container");

camera_button.addEventListener('click', async function() {
   	let stream = null;

    try {
    	stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
    }
    catch(error) {
    	alert(error.message);
    	return;
    }

    video.srcObject = stream;

    video.style.display = 'block';
    camera_button.style.display = 'none';
    click_button.style.display = 'block';
});

click_button.addEventListener('click', function() {
    canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
   	let image_data_url = canvas.toDataURL('image/jpeg');
    
    dataurl.value = image_data_url;
    camera_button.style.display = 'none';
    video.style.display = 'none';
    canvas.classList.remove('d-none');
});

    $("#formTamuMasuk").on('submit', function() {
        var formAction = $("#formTamuMasuk").attr('action');
        var dataTamu = {
            visitor_hash : $('#visitor_hash').val(),
            nama_tamu : $('#nama_tamu').val(),
            nomor_telepon : $('#nomor_telepon').val(),
            organisasi : $('#organisasi').val(),
            keperluan : $('#keperluan').val(),
            email_tamu : $('#email_tamu').val(),
            dataurl : $('#dataurl').val(),
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
                        setTimeout(location.reload.bind(location), 1000);
                    } else {
                        Swal.fire('Gagal!', data.msg, 'error');
                    }
                }
            })
        ,1000))
        return false;
    });