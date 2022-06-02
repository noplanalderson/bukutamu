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
        },
        {
            "class": "wrapok", 
            "targets": [1],
            "width": '700px'
        }
    ],
    dom: '<"left"l><"right"fr>tip',
    "ajax": {
        "url": baseURI + '/manajemen-akses/data',
        "type": "GET"
    }
};

let access_lists = $('#access_lists').DataTable(tableCfg);

$.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) { 
    Toast.fire({
         type : 'error',
         icon: 'error',
         title: 'Terjadi Kesalahan tak Terduga!',
         text: 'Coba muat ulang halaman.',
    });
};

$(function(){
    $('.add-access').on('click', function() {
    	$('.modal-title').html('Tambah Tipe Akses');
        $('.modal-footer button[type=submit]').html('Tambah');
        $('.modal-body form').attr('action', baseURI + '/tambah-akses');

        $('#type_id').val('');
        $('#type_code').val('');
        $('#menu_id').select2({
            width: '100%',
            dropdownParent: $('#accessModal'),
            minimumResultsForSearch: Infinity,
            placeholder: 'Pilih Role'
        }).val('').trigger('change');
    });
    $("#access_lists").on('click', '.edit-access', function() {
        $('.modal-title').html('Ubah Tipe Akses');
        $('.modal-footer button[type=submit]').html('Simpan');
        $('.modal-body form').attr('action', baseURI + '/ubah-akses');

        const type_id = $(this).data('id');
        $.ajax({
            url: baseURI + '/manajemen-akses/get-akses',
            data: {
                    id: type_id, 
                    bukutamu_token: $('.csrf_token').attr('value')
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
                $('#type_id').val(type_id);
                $('#type_code').val(data.type_name);

                var priv = data.priv;

                if (priv) {
                    var arrayRoles = priv.split(',');
                    $('#menu_id').select2({
                        width: '100%',
                        dropdownParent: $('#accessModal'),
                        minimumResultsForSearch: Infinity,
                        placeholder: 'Choose Privileges'
                    }).val(arrayRoles).trigger('change');
                }
                else
                {
                    $('#menu_id').select2({
                        width: '100%',
                        dropdownParent: $('#accessModal'),
                        minimumResultsForSearch: Infinity,
                        placeholder: 'Choose Privileges'
                    }).val('').trigger('change');
                }
            }
        });
    });
});

$("#accessForm").on('submit', function() {
    var formAction = $("#accessForm").attr('action');
    var accessData = {
        type_id: $("#type_id").val(),
        type_code: $("#type_code").val(),
        menu_id: $("#menu_id").val(),
        bukutamu_token: $('.csrf_token').attr('value')
    };

    $.ajax({
        type: "POST",
        url: formAction,
        data: accessData,
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
                $('#accessModal').modal('hide');
                Swal.fire('Berhasil!', data.msg, 'success');
                access_lists.ajax.reload();
            } else {
                Swal.fire('Gagal!', data.msg, 'error');
            }
        }
    });
    return false;
});

$("#access_lists").on('click', '.delete-btn', function(e){
  e.preventDefault();

    Swal.fire({
        title: 'Peringatan!',
        text: 'Anda yakin ingin menghapus tipe akses ini?',
        showCancelButton: true,
        type: 'warning',
        confirmButtonText: 'Yes',
        reverseButtons: true
    }).then((result) => {

        if (result.value == true) {

            const type_id = $(this).data('id');
            $.ajax({
                url: baseURI + '/hapus-akses',
                data: {
                        id: type_id, 
                        bukutamu_token: $('.csrf_token').attr('value')
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
                        Swal.fire('Berhasil!', data.msg, 'success');
                        access_lists.ajax.reload();
                    } else {
                        Swal.fire('Gagal!', data.msg, 'error');
                    }
                }
            });
        }
    })
});

$("#access_lists").on('change', '.index_page', function(){
    
    const type_id = $(this).data('id');
    var index_page = $('select[data-id="'+type_id+'"]').val();

    $.ajax({
        url: baseURI + '/manajemen-akses/update-index',
        data: { 
            id: type_id,
            index_page: index_page,
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

            if(data.result == 0) {
                $('.index_page option').prop('selected', function() {
                    return this.defaultSelected;
                });;
            }
        }
    });
});