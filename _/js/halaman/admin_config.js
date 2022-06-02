$(".show-btn-password").click(function() {
  var showBtn = $('.show-btn-password');
  var formPassword = $('#user_password').attr('type');

  if(formPassword === "password"){
      showBtn.attr('class', 'input-group-text show-btn-password d-flex hide-btn');
      $('.password').attr('class', 'fa fa-eye-slash password');
      $('#user_password').attr('type', 'text');
    }else{
      $('.password').attr('class', 'fa fa-eye password');
      $('#user_password').attr('type', 'password');
      showBtn.attr('class', 'input-group-text show-btn-password d-flex');
    }
});

$(".show-btn-repeat").click(function() {
  var showBtn = $('.show-btn-repeat');
  var formPassword = $('#repeat_password').attr('type');

  if(formPassword === "password"){
      showBtn.attr('class', 'input-group-text show-btn-repeat d-flex hide-btn');
      $('.repeat').attr('class', 'fa fa-eye-slash repeat');
      $('#repeat_password').attr('type', 'text');
    }else{
      $('#repeat_password').attr('type', 'password');
      $('.repeat').attr('class', 'fa fa-eye repeat');
      showBtn.attr('class', 'input-group-text show-btn-repeat d-flex');
    }
});

    $("#userForm").on('submit', function() {
        var formAction = $("#userForm").attr('action');
        var dataUser = {
            user_name : $('#user_name').val(),
            user_email : $('#user_email').val(),
            user_password : $('#user_password').val(),
            repeat_password : $('#repeat_password').val(),
            real_name : $('#real_name').val(),
            bukutamu_token : $('.csrf_token').val()
        };

        Swal.fire({
            title: 'Tunggu!',
            text: 'Membuat profil user...',
            showConfirmButton: false,
            type: 'info'
        }).then(setTimeout(() =>
            $.ajax({
                type: "POST",
                url: formAction,
                data: dataUser,
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
                        $('#userModal').modal('hide');
                        Swal.fire('Berhasil!', data.msg, 'success');
                        setTimeout(function () { window.location.href = baseURI + "/konfigurasi-smtp";}, 2000);
                    } else {
                        Swal.fire('Gagal!', data.msg, 'error');
                    }
                }
            })
        ,1000))
        return false;
    });