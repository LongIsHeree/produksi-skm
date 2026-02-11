<?php
require_once 'core/init.php';

date_default_timezone_set('Asia/Jakarta');
function getTotalToday($tgl){
    global $koneksi;
    $q = mysqli_query($koneksi,"
        SELECT COALESCE(SUM(qty),0) AS total
        FROM transaksi_qc_endline
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
        FROM transaksi_qc_endline
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
    <link rel="icon" href="img/icon.PNG">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
 <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>GI MLESE | PRODUCTION MONITORING</title>
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

.dataTables_wrapper .dataTables_scrollBody {
    border: 1px solid #ddd;
}


.dataTables_wrapper {
    position: relative;
}

.dataTables_wrapper::before {
    content: '';
    position: absolute;
    top: 50px; /* Setelah header */
    left: 0;
    right: 17px; /* Space untuk scrollbar */
    height: 30px;
    background: linear-gradient(to bottom, rgba(255,255,255,0.9), transparent);
    z-index: 10;
    pointer-events: none;
}

.dataTables_wrapper::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 17px;
    height: 30px;
    background: linear-gradient(to top, rgba(255,255,255,0.9), transparent);
    z-index: 10;
    pointer-events: none;
}
.animated-title {
            display: inline-block;
            background: linear-gradient(45deg, #000000, #2b80ff, #000000);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradient 3s ease infinite;
            text-shadow: 0 0 20px rgba(0, 247, 255, 0.5);
            font-weight: bold;
        }
        
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
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
            <a href="cetak_laporan_hasil_scan_global.php" target="_blank">
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
                        <div class="col-md-4">
<div class="card shadow mb-4">
                            <div class="card-body">
                                <h2 id="cuttingHeader" style="font-weight: bold;"><center></i> CUTTING OUTPUT</center></h2>
                                <br>
                               <table id="cuttingTable" class="table table-striped table-hover table-bordered nowrap w-100">

<thead>
<tr>
<th >NO</th>
<th >LINE</th>
<th >ORC</th>
<th >ORDER</th>
<th >YDA</th>
<th >DAILY</th>
<th >BAL</th>

</tr>
</thead>
<tbody></tbody>
</table>
                   
                            </div>
                        </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow mb-4">
                            <div class="card-body">
                                <h2 id="qcHeader" style="font-weight: bold;"><center></i> QC ENDLINE OUTPUT</center></h2>
                                <br>
                               <table id="qcTable" class="table table-striped table-hover table-bordered nowrap w-100">

<thead>
<tr>
<th >NO</th>
<th >LINE</th>
<th >ORC</th>
<th >ORDER</th>
<th >YDA</th>
<th >DAILY</th>
<th >BAL</th>

</tr>
</thead>
<tbody></tbody>
</table>
                   
                            </div>
                        </div>
                        </div>
                        <div class="col-md-4">
                               <div class="card shadow mb-4">
                            <div class="card-body">
                                <h2 id="packingHeader" style="font-weight: bold;"><center>PACKING OUTPUT</center></h2>
                                <br>
                               <table id="packingTable" class="table table-striped table-hover table-bordered nowrap w-100">

<thead>
<tr>
<th >NO</th>
<th >LINE</th>
<th >ORC</th>
<th >ORDER</th>
<th >YDA</th>
<th >DAILY</th>
<th >BAL</th>

</tr>
</thead>
<tbody></tbody>
</table>
                   
                            </div>
                        </div>
                        </div>
                        </div>
                     
               
                <div class="row">
                    <div class="col-md-12">
                    <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h3>
                                            <center><strong class="animated-title" id="chartTitle">DAILY OUTPUT CHART </strong></center>
                                        </h3>
                                        <div id="todayChart"></div>
                                    </div>
                                </div>
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
     <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

   <script>
$(document).ready(function() {
     anime({
            targets: '#chartTitle',
            translateY: [
                { value: -20, duration: 1200, easing: 'easeOutQuad' },
                { value: 0, duration: 1200, easing: 'easeOutBounce' }
            ],
            rotate: [
              
                { value: 0, duration: 400 }
            ],
            scale: [
                { value: 1.1, duration: 400 },
                { value: 1, duration: 400 }
            ],
            loop: true,
            delay: 2000, 
            direction: 'normal'
        });

    // Initialize semua tabel
    $('#cuttingTable, #qcTable, #packingTable').DataTable({
        responsive: false, 
        paging: false,     
        searching: false,  
        info: false,      
        scrollY: '450px',  
        scrollCollapse: true,
        order: [[5, 'asc']],
        columnDefs: [
            { width: "5%", targets: 0, className:"text-center"},
            { width: "15%", targets: 1, className:"text-center" },
            { width: "30%", targets: 2, className:"text-center" },
            { width: "15%", targets: 3, className: "text-center" },
            { width: "10%", targets: 4, className: "text-center" },
            { width: "15%", targets: 5, className: "text-center" },
            { width: "10%", targets: 6, className: "text-center" }
        ]
    });
});

// Chart dengan 3 series
var options = {
    chart: { 
        type: 'area',
        height: 515,
        toolbar: {
            show: true
        }
    },
    series: [
        { name: 'Cutting', data: [] },
        { name: 'QC Endline', data: [] },
        { name: 'Packing', data: [] }
    ],
    xaxis: { 
        categories: [],
        title: {
            text: 'Production Line'
        }
    },
    yaxis: {
        title: {
            text: 'Output Quantity'
        }
    },
    colors: ['#FF6B6B', '#4ECDC4', '#eeea1b'],
    dataLabels: { 
        enabled: true,
        style: {
            colors: ['#000000']
        }
    },
    stroke: {
        curve: 'smooth',
        width: 3
    },
    markers: {
        size: 6,
        strokeWidth: 2,
        hover: {
            size: 8
        }
    },
    legend: {
        position: 'top',
        horizontalAlign: 'center',
        fontSize: '20px',
        fontWeight : 700,
        markers: {
            width: 14,
            height: 14
        }
    },
    tooltip: {
        shared: true,
        intersect: false,
        y: {
            formatter: function(value) {
                return value + " pcs";
            }
        }
    }
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

// Variable global untuk menyimpan data dari 3 API
let cuttingData = {};
let qcData = {};
let packingData = {};

function fetchDataAndUpdate(){
    const params = new URLSearchParams({
        tgl: '<?= $tgl ?>',
        status: 'OPEN',
        orc: '',
        style: '',
        line: 'all'
    });

    // Fetch CUTTING data
    fetch('get_outputcut_data.php?' + params.toString())
    .then(res => res.json())
    .then(data => {
        console.log('Cutting data received:', data);
        const today = (data.today || []).filter(d => d.qty > 0);
        const balanceMap = data.balance_map || {};
        const yesterdayMap = data.yesterday_map || {};

        // Update cutting table
        const cuttingTable = $('#cuttingTable').DataTable();
        cuttingTable.clear();
        const sortedToday = today.sort((a, b) => a.qty - b.qty);

        sortedToday.forEach((d, i) => {
            const key = d.line + '|' + d.orc;
            const bal = balanceMap[d.orc] || 0;
            
            cuttingTable.row.add([
                i + 1,
                d.line,
                d.orc,
                d.qty_order,
                yesterdayMap[key] || 0,
                d.qty,
                bal,
            ]);
        });
        cuttingTable.draw(false);

        // Simpan data untuk chart - HANYA SIMPAN, JANGAN UPDATE CHART
        cuttingData = sumByLine(today);
        updateChart();
    })
    .catch(err => console.error('Error fetching cutting data:', err));

    // Fetch QC ENDLINE data
    fetch('get_outputqc_data.php?' + params.toString())
    .then(res => res.json())
    .then(data => {
        console.log('QC data received:', data);
        const today = (data.today || []).filter(d => d.qty > 0);
        const balanceMap = data.balance_map || {};
        const yesterdayMap = data.yesterday_map || {};

        // Update QC table
        const qcTable = $('#qcTable').DataTable();
        qcTable.clear();
        const sortedToday = today.sort((a, b) => a.qty - b.qty);

        sortedToday.forEach((d, i) => {
            const key = d.line + '|' + d.orc;
            const bal = balanceMap[d.orc] || 0;
            
            qcTable.row.add([
                i + 1,
                d.line,
                d.orc,
                d.qty_order,
                yesterdayMap[key] || 0,
                d.qty,
                bal,
            ]);
        });
        qcTable.draw(false);

        // Simpan data untuk chart - HANYA SIMPAN, JANGAN UPDATE CHART
        qcData = sumByLine(today);
        updateChart();
    })
    .catch(err => console.error('Error fetching QC data:', err));

    // Fetch PACKING data
    fetch('get_outputpack_data.php?' + params.toString())
    .then(res => res.json())
    .then(data => {
        console.log('Packing data received:', data);
        const today = (data.today || []).filter(d => d.qty > 0);
        const balanceMap = data.balance_map || {};
        const yesterdayMap = data.yesterday_map || {};

        // Update packing table
        const packingTable = $('#packingTable').DataTable();
        packingTable.clear();
        const sortedToday = today.sort((a, b) => a.qty - b.qty);

        sortedToday.forEach((d, i) => {
            const key = d.line + '|' + d.orc;
            const bal = balanceMap[d.orc] || 0;
            
            packingTable.row.add([
                i + 1,
                d.line,
                d.orc,
                d.qty_order,
                yesterdayMap[key] || 0,
                d.qty,
                bal,
            ]);
        });
        packingTable.draw(false);

        // Simpan data untuk chart - HANYA SIMPAN, JANGAN UPDATE CHART
        packingData = sumByLine(today);
        updateChart();
    })
    .catch(err => console.error('Error fetching packing data:', err));
}

// Fungsi untuk update chart - INI SATU-SATUNYA TEMPAT CHART DI-UPDATE
function updateChart() {
    // Gabungkan semua lines yang ada dari 3 source
    const allLines = new Set([
        ...Object.keys(cuttingData),
        ...Object.keys(qcData),
        ...Object.keys(packingData)
    ]);
    
    const lines = Array.from(allLines).sort();
    
    // Debug: Log data untuk verifikasi
    console.log('Chart Update - Lines:', lines);
    console.log('Cutting Data:', cuttingData);
    console.log('QC Data:', qcData);
    console.log('Packing Data:', packingData);
    
    // Update chart dengan data dari 3 source
    chart.updateOptions({ 
        xaxis: { 
            categories: lines,
            title: {
                text: 'Production Line'
            }
        } 
    });
    
    chart.updateSeries([
        { 
            name: 'Cutting', 
            data: lines.map(l => cuttingData[l] || 0) 
        },
        { 
            name: 'QC Endline', 
            data: lines.map(l => qcData[l] || 0) 
        },
        { 
            name: 'Packing', 
            data: lines.map(l => packingData[l] || 0) 
        }
    ]);
}

// Panggil pertama kali
fetchDataAndUpdate();

// Auto refresh setiap 30 detik
setInterval(fetchDataAndUpdate, 30000);

// Auto scroll tabel
function initAutoScroll() {
    const scrollStates = {
        cutting: { position: 0, paused: false },
        qc: { position: 0, paused: false },
        packing: { position: 0, paused: false }
    };
    
    const scrollSpeed = 0.5;
    
    setInterval(function() {
        // Scroll untuk cutting table
        const cuttingScrollBody = $('#cuttingTable').closest('.dataTables_wrapper').find('.dataTables_scrollBody')[0];
        if (cuttingScrollBody && !scrollStates.cutting.paused) {
            scrollStates.cutting.position += scrollSpeed;
            if (scrollStates.cutting.position >= cuttingScrollBody.scrollHeight - cuttingScrollBody.clientHeight) {
                scrollStates.cutting.position = 0;
            }
            cuttingScrollBody.scrollTop = scrollStates.cutting.position;
        }
        
        // Scroll untuk qc table
        const qcScrollBody = $('#qcTable').closest('.dataTables_wrapper').find('.dataTables_scrollBody')[0];
        if (qcScrollBody && !scrollStates.qc.paused) {
            scrollStates.qc.position += scrollSpeed;
            if (scrollStates.qc.position >= qcScrollBody.scrollHeight - qcScrollBody.clientHeight) {
                scrollStates.qc.position = 0;
            }
            qcScrollBody.scrollTop = scrollStates.qc.position;
        }
        
        // Scroll untuk packing table
        const packingScrollBody = $('#packingTable').closest('.dataTables_wrapper').find('.dataTables_scrollBody')[0];
        if (packingScrollBody && !scrollStates.packing.paused) {
            scrollStates.packing.position += scrollSpeed;
            if (scrollStates.packing.position >= packingScrollBody.scrollHeight - packingScrollBody.clientHeight) {
                scrollStates.packing.position = 0;
            }
            packingScrollBody.scrollTop = scrollStates.packing.position;
        }
    }, 50);
    
    // Pause on hover
    $('#cuttingTable').hover(
        function() { scrollStates.cutting.paused = true; },
        function() { scrollStates.cutting.paused = false; }
    );
    
    $('#qcTable').hover(
        function() { scrollStates.qc.paused = true; },
        function() { scrollStates.qc.paused = false; }
    );
    
    $('#packingTable').hover(
        function() { scrollStates.packing.paused = true; },
        function() { scrollStates.packing.paused = false; }
    );
}

setTimeout(initAutoScroll, 2000);
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