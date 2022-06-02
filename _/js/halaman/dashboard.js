$(function(){

    $.ajax({
        url: baseURI + '/dashboard/statistik',
        method: 'get',
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

            $('#tamu_mtd').text(data.tamu_mtd.total);
            $('#tamu_ytd').text(data.tamu_ytd.total);
            $('#log_info').text(data.log_info.total);
            $('#log_warning').text(data.log_warning.total);
        }
    });
})

$(function () {
    var canvas = document.getElementById("grafik-tamu");
    var ctx = canvas.getContext("2d");
    var json_url = baseURI + "/dashboard/grafik";

    var visitorGraph = new Chart(ctx, {
        type: 'line',
        responsive:true,
        data: {
            labels: [],
            datasets: [
                {
                    label: "Grafik Tamu",
                    fill: true,
                    lineTension: 0.1,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "rgba(75,192,192,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 100,
                    data: [],
                    spanGaps: false,
                }
            ]
        },
        options: {
            tooltips: {
                mode: 'index',
                intersect: false
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true,
                        stepSize: 5
                    }
                }]
            }
        }
    });

    ajax_chart(visitorGraph, json_url);

    function ajax_chart(chart, url, data) {
        var data = data || {};

        $.getJSON(url, data).done(function(response) {
            chart.data.labels = response.labels;
            chart.data.datasets[0].data = response.data.jumlah;
            chart.update();
        });
    }

    document.getElementById('btn-download').onclick = function() {
        // Trigger the download
        var a = document.createElement('a');
        a.href = visitorGraph.toBase64Image();
        a.download = 'grafik-tamu.png';
        a.click();
    }
});

$(function () {
    let tableCfg = {
        responsive: true,
        "language": {
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            "emptyTable": "Tidak ada data",
            "lengthMenu": "_MENU_ &nbsp; data/halaman",
            "search": "Cari: ",
            "zeroRecords": "Tidak ditemukan data yang cocok.",
            "paginate": {
              "previous": "<i class='fas fa-chevron-left'></i>",
              "next": "<i class='fas fa-chevron-right'></i>",
            },
        },
        "order": [[ 1, "desc" ]],
        'columnDefs': [
            {
                "targets": 'no-sort',
                "orderable": false,
            }
        ],
        dom: '<"left"l><"right"fr>tip',
        "ajax": {
            "url": baseURI + '/dashboard/org',
            "type": "GET"
        }
    }

    $('#tblOrg').DataTable(tableCfg);
})