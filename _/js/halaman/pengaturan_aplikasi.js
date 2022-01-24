(function($) {
  'use strict';
  $(function() {
    $('#cari_logo').on('click', function() {
      var file = $(this).parent().parent().parent().find('#logo_file');
      file.trigger('click');
    });
    $('#logo_file').on('change', function() {
      $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
    });
  });
})(jQuery);

(function($) {
  'use strict';
  $(function() {
    $('#cari_logo_dashboard').on('click', function() {
      var file = $(this).parent().parent().parent().find('#logo_dashboard_file');
      file.trigger('click');
    });
    $('#logo_dashboard_file').on('change', function() {
      $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
    });
  });
})(jQuery);

$(document).ready(function(e){
  $("#formSetting").on('submit', function(e) {
    e.preventDefault();

    var formAction = $("#formSetting").attr('action');

    $.ajax({
        type: "POST",
        data: new FormData(this),
        processData: false,
        contentType: false,
        cache: false,
        timeout: 800000,
        url: formAction,
        dataType: 'json',
        error: function(xhr, status, error) {
        var data = 'Mohon refresh kembali halaman ini. ' + '(status code: ' + xhr.status + ')';
            Toast.fire({
                 type : 'error',
                 icon: 'error',
                 title: '',
                 text: data,
            });
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
    });
    return false;
  });
});