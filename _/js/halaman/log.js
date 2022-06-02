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

    var periode = minPeriod + ' - ' + maxPeriod;

    $('.daterange').text('Periode: '+periode);

    tblSysLog.ajax.url(baseURI + '/log-sistem/data/' + range[0] + '/' + range[1]).load();
})

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
    "order": [[ 1, "desc" ]],
    "pageLength": 50,
    'columnDefs': [
        {
            "targets": 'no-sort',
            "orderable": false,
        },
        { "type": "date", "targets": 1 }
    ],
    dom: '<"left"l><"right"fr>tip',
    "ajax": {
        "url": baseURI + '/log-sistem/data/' + range[0] + '/' + range[1],
        "type": "GET"
    },
    "columns": [
        { "data": "log_type" },
        { "data": "log_timestamp" },
        { "data": "log_message" }
    ]
};

let tblSysLog = $('#tblSysLog').DataTable(tableCfg);

$.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) { 
    Toast.fire({
         type : 'error',
         icon: 'error',
         title: 'Terjadi Kesalahan tak Terduga!',
         text: 'Coba muat ulang halaman.',
    });
};