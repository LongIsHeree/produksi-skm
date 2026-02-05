<?php
require_once 'core/init.php';

date_default_timezone_set('Asia/Jakarta');
function getTotalToday($tgl){
    global $koneksi;
    $q = mysqli_query($koneksi,"
        SELECT COALESCE(SUM(qty),0) AS total
        FROM transaksi_cutting
        WHERE tanggal = '$tgl'
    ");
    return mysqli_fetch_assoc($q)['total'] ?? 0;
}

function getTotalYesterday($tgl){
    global $koneksi;
    $date = new DateTime($tgl);
    $date->modify('-1 day');
    $yesterday = $date->format('Y-m-d');

    $q = mysqli_query($koneksi,"
        SELECT COALESCE(SUM(qty),0) AS total
        FROM transaksi_cutting
        WHERE tanggal = '$yesterday'
    ");
    return mysqli_fetch_assoc($q)['total'] ?? 0;
}

$tgl = date('Y-m-d');
$totalToday = getTotalToday($tgl);
$totalYesterday = getTotalYesterday($tgl);



?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/ico" href="favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>SEWING MONITORING</title>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <style>
    .main-header {
        position: relative;
        background: #0a0f1c;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-right: 40px;
        overflow: hidden;
    }
.lottie-wrapper {
    display: flex;
    justify-content: center;  /* center horizontal */
    align-items: center;      /* center vertical */
    gap: 40px;                /* jarak antar animasi */
    margin-top: 10px;
}

    /* Garis neon jalan */
    .header-line {
        position: absolute;
        bottom: 0;
        left: -50%;
        width: 50%;
        height: 3px;
        background: linear-gradient(90deg, transparent, #00f7ff, #00f7ff, transparent);
        box-shadow: 0 0 10px #00f7ff, 0 0 20px #00f7ff;
        animation: moveLine 3s linear infinite;
    }

    @keyframes moveLine {
        0% {
            left: -50%;
        }

        100% {
            left: 100%;
        }
    }

    /* Glow logo & lottie */
    .main-header img {
        filter: drop-shadow(0 0 6px #00f7ff);
    }

    .main-header lottie-player {
        filter: drop-shadow(0 0 8px #00f7ff);
    }

    /* ================= FOOTER NEON ================= */
    .main-footer {
        background: #0a0f1c;
        color: #00f7ff;
        position: relative;
        overflow: hidden;
        border-top: 1px solid rgba(0, 255, 255, 0.2);
    }

    .main-footer .marquee-text {
        text-shadow: 0 0 5px #00f7ff, 0 0 10px #00f7ff;
    }

    /* Garis neon atas footer */
    .main-footer::before {
        content: "";
        position: absolute;
        top: 0;
        left: -50%;
        width: 50%;
        height: 2px;
        background: linear-gradient(90deg, transparent, #00f7ff, transparent);
        box-shadow: 0 0 10px #00f7ff;
        animation: footerLine 4s linear infinite;
    }

    @keyframes footerLine {
        0% {
            left: -50%;
        }

        100% {
            left: 100%;
        }
    }
    </style>
</head>

<body>
    <header class="main-header">
        <div class="logo" style="margin-left: 50px;">
            <a href="admin/login.php" target="_blank">
                <img src="assets/images/gi.png" alt="Logo">
            </a>
        </div>
        <div class="header-line"></div>
    </header>
    <main>
        <section>
            <!-- Image Slider -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-7">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h3>
                                            <center><strong>TODAY & YESTERDAY OUTPUT CHART </strong></center>
                                        </h3>
                                        <div id="todayChart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <h2><i class="fas fa-bullhorn"></i> CUTTING TODAY & YESTERDAY OUTPUT</h2>
                                <br>
                               <table id="outputTable" class="table-striped table-hover">
<thead>
<tr>
<th style="text-align: center;">NO</th>
<th style="text-align: center;">LINE</th>
<th style="text-align: center;">ORC</th>
<th style="text-align: center;">ORDER</th>
<th style="text-align: center;">YDA</th>
<th style="text-align: center;">DAILY</th>
<th style="text-align: center;">BAL</th>

</tr>
</thead>
<tbody></tbody>
</table>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </main>

    <footer class="main-footer">
        <div class="date-time-container">
            <div id="day-date"></div>
            <div id="time"></div>
        </div>
        <div class="marquee-section">
            <div class="marquee-text">PT. GLOBALINDO INTIMATES | THANKS FOR YOUR WORK | TERIMAKASIH ATAS KERJA KERAS ANDA</div>
            <div class="lottie-wrapper" style="flex:auto;">
    <lottie-player src="assets/images/animation.json" speed="1"
        style="width:100px;height:70px" loop autoplay></lottie-player>

    <lottie-player src="assets/images/fish.json" speed="1"
        style="width:100px;height:70px" loop autoplay></lottie-player>
</div>
        </div>

    </footer>


    <?php




?>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

   <script>
$(document).ready(function() {
    $('#outputTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        order: [[5, 'asc']], 
        columnDefs: [
            { width: "10px", targets: 0, className:"text-center"},   // NO
            { width: "60px", targets: 1, className:"text-center" },   // LINE
            { width: "200px", targets: 2, className:"text-center" },  // ORC
            { width: "30px", targets: 3, className: "text-center" }, // YESTERDAY
            { width: "30px", targets: 4, className: "text-center" }, // TODAY
            { width: "30px", targets: 5, className: "text-center" }  // BALANCING
        ],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            paginate: {
                first: "Awal",
                last: "Akhir",
                next: "→",
                previous: "←"
            },
            zeroRecords: "Tidak ada data ditemukan"
        }
    });
});

var options = {
    chart:{ type:'bar', height:450, },
    series:[
        { name:'Yesterday', data:[] },
        { name:'Today', data:[] }
    ],
    xaxis:{ categories:[] },
    colors:['#009ffb','#00fba3'],
    dataLabels:{ enabled:true,style: {
    colors: ['#000000'] 
  } },
    plotOptions:{ bar:{ columnWidth:'50%' } }
};

var chart = new ApexCharts(document.querySelector("#todayChart"), options);
chart.render();

function sumByLine(arr){
    const map = {};
    arr.forEach(d => {
        map[d.line] = (map[d.line] || 0) + d.qty;
    });
    return map;
}

function fetchDataAndUpdate(){
    const params = new URLSearchParams({
        tgl: '<?= $tgl ?>',
        status: 'OPEN',
        orc: '',
        style: '',
        line: 'all'
    });

    fetch('get_outputcut_data.php?' + params.toString())
    .then(res => res.json())
    .then(data => {
        console.log('Data received:', data);

      
        const today = (data.today || []).filter(d => d.qty > 0);
        const yesterday = data.yesterday || [];
        const balanceMap = data.balance_map || {};
        const yesterdayMap = data.yesterday_map || {};

        // CHART aggregated per LINE
        const todayLine = sumByLine(today);
        const yLine = sumByLine(yesterday);
        
       
        const lines = Object.keys(todayLine).sort();

        chart.updateOptions({ xaxis: { categories: lines } });
        chart.updateSeries([
            { name: 'Yesterday', data: lines.map(l => yLine[l] || 0) },
            { name: 'Today', data: lines.map(l => todayLine[l] || 0) }
        ]);

       
        const table = $('#outputTable').DataTable();
        table.clear();
        const sortedToday = today.sort((a, b) => a.qty - b.qty);

        sortedToday.forEach((d, i) => {
            const key = d.line + '|' + d.orc;
            const bal = balanceMap[d.orc] || 0;
            
            table.row.add([
                i + 1,
                d.line,
                d.orc,
                d.qty_order,
                yesterdayMap[key] || 0,
                d.qty,
                bal,
                
            ]);
        });

        table.draw(false);
    })
    .catch(err => console.error('Error fetching data:', err));
}

// Panggil pertama kali
fetchDataAndUpdate();

// Auto refresh setiap 30 detik
setInterval(fetchDataAndUpdate, 30000);

// Fungsi untuk memperbarui waktu secara dinamis
function updateTime() {
    const now = new Date();
    const options = {
        timeZone: 'Asia/Jakarta',
        hour12: false
    };
    let timeString = now.toLocaleTimeString('id-ID', options);
    timeString = timeString.replace(/\./g, ':');
    document.getElementById('time').innerText = timeString;
}

setInterval(updateTime, 1000);

// Menampilkan hari, tanggal, bulan, dan tahun secara dinamis
function updateDate() {
    const now = new Date();
    const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
    const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September",
        "Oktober", "November", "Desember"
    ];
    const dayName = days[now.getDay()];
    const date = now.getDate();
    const monthName = months[now.getMonth()];
    const year = now.getFullYear();
    document.getElementById('day-date').innerText = `${dayName}, ${date} ${monthName} ${year}`;
}

updateDate();
</script>
</body>

</html>