$(function() {

    var start = moment().startOf('month');
    var end = moment().endOf('month');

    function cb(start, end) {
        $('#range span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
    }

    $('#range').daterangepicker({
        startDate: start,
        endDate: end,
        "locale": {
            "cancelLabel": 'Clear',
            "format": "YYYY-MM-DD",
        },
        ranges: {
           '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
           '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
           'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
           'Tahun Ini': [moment().startOf('year'), moment().endOf('year')]
        }
    }, cb);

    cb(start, end);

});

var periode;
var start = moment().subtract(29, 'days');
var end = moment();
var range = start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD');

$('#range').on('change', function (e) {
    e.preventDefault();

    var range = $('#range').val().split(' - ');
    var min = new Date(range[0]);
    var max = new Date(range[1]);
    const options = { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric'
    };
    var minPeriod = min.toLocaleDateString('id-ID', options);  
    var maxPeriod = max.toLocaleDateString('id-ID', options);

    periode = minPeriod + ' - ' + maxPeriod;

    $('.daterange').text('Periode: '+periode);

    tblTamu.ajax.url(baseURI + '/data-tamu/data/' + range[0] + '/' + range[1]).load();
});

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
    "pageLength": 50,
    'columnDefs': [
        {
            "targets": 'no-sort',
            "orderable": false,
        },
        {
            "type":"unix",
            "targets":0,
            "render": function (data, type, full, meta) {
                let date = new Date(data * 1000);
                return date.toLocaleDateString('id-ID', { 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric'
                });
            }
        },
        {
            "type":"unix",
            "targets":2,
            "render": function (data, type, full, meta) {
                return moment.unix(data).format("HH:mm (Z)");
            }
        },
        {
            "type":"unix",
            "targets":3,
            "render": function (data, type, full, meta) {
                return moment.unix(data).format("HH:mm (Z)");
            }
        }
    ],
    dom: '<"left"l><"right"fr>Btip',
    "ajax": {
        "url": baseURI + '/data-tamu/data/' + range[0] + '/' + range[1],
        "type": "GET"
    },
    buttons: [
    {
        extend: 'excelHtml5',
        className: 'btn btn-outline-primary',
        pageSize: 'Legal',
        orientation: 'landscape',
        title: function () { return 'Daftar Tamu - Periode ' + periode;},
        filename: function () { return 'Daftar Tamu - Periode ' + periode;},
        exportOptions: {
            columns: [':visible'],
            // orthogonal: 'export'
        },
        action: function(e, dt, button, config) {
            responsiveToggle(dt);
            $.fn.dataTable.ext.buttons.excelHtml5.action.call(dt.button(button), e, dt, button, config);
            responsiveToggle(dt);
        }
    },
    {
        extend: 'pdfHtml5',
        className: 'btn btn-outline-primary',
        pageSize: 'Legal',
        orientation: 'landscape',
        filename: function () { return 'Daftar Tamu - Periode ' + periode;},
        action: function(e, dt, button, config) {
            responsiveToggle(dt);
            $.fn.dataTable.ext.buttons.pdfHtml5.action.call(dt.button(button), e, dt, button, config);
            responsiveToggle(dt);
        },
        customize : function(doc) {
            doc.content.splice(0, 1, {
                text: [{
                    text: "Daftar Tamu\n\n",
                    fontSize: 14,
                    alignment: 'center'
                },
                {
                    text: 'Periode: ' + periode + "\n\n",
                    fontSize: 10,
                    alignment: 'left'
                }]
            });

            margin: [5, 0, 0, 5];
            alignment: 'center';
            doc.styles.tableHeader.alignment = 'center'
            doc.defaultStyle.fontSize = 10;
            doc.styles.tableHeader.fontSize = 10;

            var colCount = new Array();
            var tr = $('#tblTamu tbody tr:first-child');
            var trWidth = $(tr).width();

            var length = $('#tblTamu tbody tr:first-child td').length;

            $('#tblTamu').find('tbody tr:first-child td').each(function()
            {
                var tdWidth = $(this).width();
                var widthFinal = parseFloat(tdWidth * 120);
                widthFinal = widthFinal.toFixed(2) / trWidth.toFixed(2);
                if ($(this).attr('colspan')) 
                {
                    for (var i = 1; i <= $(this).attr('colspan'); i++) {
                        colCount.push('*');
                    }
                } 
                else 
                {
                    colCount.push(parseFloat(widthFinal.toFixed(2)) + '%');
                }
            });
            doc.content[1].table.widths = colCount;
        },
        exportOptions: {
            columns: [':visible'],
            // orthogonal: 'export'
        }
    },
    {
        extend: 'colvis',
        className: 'btn btn-outline-primary',
        text: 'Sembunyikan Kolom'
    }],
    // "columns": [
    //     { "data": "time_in" },
    //     { "data": "nama_tamu" },
    //     { "data": "time_in" },
    //     { "data": "time_out" },
    //     { "data": "organisasi" },
    //     { "data": "keperluan" }
    // ]
};

let tblTamu = $('#tblTamu').DataTable(tableCfg);

$.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) { 
    Toast.fire({
         type : 'error',
         icon: 'error',
         title: 'Terjadi Kesalahan tak Terduga!',
         text: 'Coba muat ulang halaman.',
    });
};

$("#tblTamu").on('click', '.detail-tamu', function() {
    $('.modal-title').html('Detail Tamu');

    const visitor_hash = $(this).data('id');
    $.ajax({
        url: baseURI + '/detail-tamu',
        data: {
                hash: visitor_hash, 
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

            $('.nama_tamu').text(data.nama_tamu);
            $('.time_in').text(new Date(data.time_in * 1000).toLocaleDateString('id-ID', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric'
            }));
            $('.time_out').text(new Date(data.time_out * 1000).toLocaleDateString('id-ID', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric'
            }));
            $('.organisasi').text(data.organisasi);
            $('.nomor_telepon').text('+62'+data.nomor_telepon);
            $('.keperluan').text(data.keperluan);
            $('.foto_tamu').html('<img src="'+data.foto+'" class="w-50 h-50">');
        }
    });


});

//Create PDf from HTML...
$('.export-pdf').on('click',function() {
    const table = document.querySelector('#data-tamu');
    var filename = $('.title').text();
    var HTML_Width = table.clientWidth / 2;
    var HTML_Height = table.clientHeight / 2;
    var top_left_margin = 2;
    var top_right_margin = 2;
    var PDF_Width = table.offsetWidth;
    var PDF_Height = table.offsetHeight;
    var canvas_image_width = HTML_Width;
    var canvas_image_height = HTML_Height;

    var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;

    html2canvas($("#data-tamu")[0]).then(function (canvas) {
        var imgData = canvas.toDataURL("image/png");
        var pdf = new jsPDF('p', 'pt', [PDF_Width, PDF_Height]);
        pdf.addImage(imgData, 'PNG', top_left_margin, top_left_margin, canvas_image_width, canvas_image_height);
        for (var i = 1; i <= totalPDFPages; i++) { 
            pdf.addPage(PDF_Width, PDF_Height);
            pdf.addImage(imgData, 'PNG', top_left_margin, -(PDF_Height*i)+(top_left_margin*1),canvas_image_width,canvas_image_height);
        }
        pdf.save(filename + ".pdf");
    });
})