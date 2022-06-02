    var tableCfg = {
        responsive: false,
        processing: true,
        "language": {
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            "emptyTable": "Tidak ada data",
            "lengthMenu": "_MENU_ &nbsp; data/halaman",
            "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw text-primary"></i><span class="sr-only">Loading...</span>',
            "search": "Cari: ",
            "zeroRecords": "Tidak ditemukan data yang cocok.",
            "paginate": {
              "previous": "<i class='fas fa-chevron-left'></i>",
              "next": "<i class='fas fa-chevron-right'></i>",
            },
        },
        "order": [[ 0, "asc" ]],
        'columnDefs': [
            {
                "targets": 'no-sort',
                "orderable": false,
            }
        ],
        dom: '<"left"l><"right"fr>tip',
        "ajax": {
            "url": baseURI + '/manajemen-user/data',
            "type": "GET"
        }
    };

    let tblUser = $('#tblUser').DataTable(tableCfg);

    $.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) { 
        Toast.fire({
             type : 'error',
             icon: 'error',
             title: 'Terjadi Kesalahan tak Terduga!',
             text: 'Coba muat ulang halaman.',
        });
    };

    $(function(){
        $('.tambah-user').on('click', function() {
        	$('.modal-title').html('Tambah User');
            $('.modal-footer button[type=submit]').html('Tambah');
            $('.modal-body form').attr('action', baseURI + '/tambah-user');
            $('#is_active_box').attr('class', 'col-md-6 d-none');
            
            $('#id_user').val('');
            $('#user_name').val('');
            $('#user_email').val('');
            $('#real_name').val('');
            $('#type_id').val('');
        });
        $("#tblUser").on('click', '.edit-user', function(){
            $('.modal-title').html('Ubah User');
            $('.modal-footer button[type=submit]').html('Simpan');
            $('.modal-body form').attr('action', baseURI + '/ubah-user');
            $('#is_active_box').attr('class', 'col-md-6');

            const id_user = $(this).data('id');
            $.ajax({
                url: baseURI + '/manajemen-user/get-user',
                data: {
                        id: id_user, 
                        bukutamu_token: $('meta[name="X-CSRF-TOKEN"]').attr('content')
                    },
                method: 'post',
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
                success: function(data){
                    $('.csrf_token').val(data.token);
                    $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);
                    $('#id_user').val(id_user)
                    $('#user_name').val(data.user_name);
                    $('#user_email').val(data.user_email);
                    $('#real_name').val(data.real_name);
                    $('#type_id').val(data.type_id);
                    if(data.user_status == 'enable') {
                        $('#user_status').prop('checked', true);
                    } else {
                        $('#user_status').prop('checked', false);
                    }
                }
            });
        });
    });

    $("#tblUser").on('click', '.delete-btn', function(e){
      e.preventDefault();

        Swal.fire({
            title: 'Peringatan!',
            text: 'Anda yakin ingin menghapus user ini?',
            showCancelButton: true,
            type: 'warning',
            confirmButtonText: 'Yes',
            reverseButtons: true
        }).then((result) => {

        if (result.value == true) {
            const id_user = $(this).data('id');

            $.ajax({
                url: baseURI + '/hapus-user',
                data: { 
                    id: id_user,
                    bukutamu_token: $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                method: 'post',
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
                        tblUser.ajax.reload();
                    } 
                    else {
                      Swal.fire('Gagal!', data.msg, 'error');
                    }
                }
            });
        }
        })
    });

    $("#userForm").on('submit', function() {
        var formAction = $("#userForm").attr('action');
        var dataUser = {
            id_user : $('#id_user').val(),
            user_name : $('#user_name').val(),
            user_email : $('#user_email').val(),
            real_name : $('#real_name').val(),
            type_id : $('#type_id').val(),
            user_status : ($('#user_status').is(":checked")) ? '1' : '0',
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
                        tblUser.ajax.reload();
                    } else {
                        Swal.fire('Gagal!', data.msg, 'error');
                    }
                }
            })
        ,1000))
        return false;
    });