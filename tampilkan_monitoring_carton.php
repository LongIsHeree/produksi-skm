<?php
require_once 'core/init.php';
date_default_timezone_set('Asia/Jakarta');
$tgl = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/ico" href="favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>SHIPMENT GI 2</title>
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
            justify-content: center;
            align-items: center;
            gap: 40px;
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
            top: 50px;
            left: 0;
            right: 17px;
            height: 30px;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.9), transparent);
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
            background: linear-gradient(to top, rgba(255, 255, 255, 0.9), transparent);
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
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
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

        /* Filter section */
        .filter-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 12px 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .filter-section label {
            font-weight: 600;
            color: #333;
            margin: 0;
            white-space: nowrap;
        }

        .filter-section input[type="date"] {
            border: 2px solid #dee2e6;
            border-radius: 6px;
            padding: 6px 12px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .filter-section input[type="date"]:focus {
            border-color: #2b80ff;
            outline: none;
            box-shadow: 0 0 0 3px rgba(43, 128, 255, 0.15);
        }

        .filter-section .btn-filter {
            background: linear-gradient(135deg, #2b80ff, #0056d6);
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 7px 20px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .filter-section .btn-filter:hover {
            background: linear-gradient(135deg, #0056d6, #003fa3);
            box-shadow: 0 4px 12px rgba(0, 86, 214, 0.3);
        }

        #cartonTable thead th {
            background-color: #1a5276 !important;
            color: #ffffff !important;
            text-align: center;
            font-weight: bold;
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
            <div class="container-fluid">
                <!-- Filter Date -->
                <div class="filter-section">
                    <label for="filterDate"><i class="fas fa-calendar-alt"></i> Tanggal :</label>
                    <input type="date" id="filterDate" value="<?= $tgl ?>">
                    <button class="btn-filter" onclick="fetchDataAndUpdate()"><i class="fas fa-search"></i>
                        Filter</button>
                </div>

                <div class="row">
                    <div class="col-md-7">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h3>
                                            <center><strong class="animated-title" id="chartTitle">SHIPMENT GI 2
                                                </strong></center>
                                        </h3>
                                        <div id="cartonChart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <h2>
                                    <center><i class="fas fa-boxes-stacked"></i> SHIPMENT GI 2</center>
                                </h2>
                                <br>

                                <table id="cartonTable"
                                    class="table table-striped table-hover table-bordered nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>ORC</th>
                                            <th>STYLE</th>
                                            <th>COLOR</th>
                                            <th>CUSTOMER</th>
                                            <th>JML CTN</th>
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
            <div class="marquee-text">PT. GLOBALINDO INTIMATES | THANKS FOR YOUR
                WORK | TERIMAKASIH ATAS KERJA KERAS ANDA</div>
            <div class="lottie-wrapper" style="flex:auto;">
                <lottie-player src="assets/images/animation.json" speed="1" style="width:100px;height:70px" loop
                    autoplay></lottie-player>
                <lottie-player src="assets/images/fish.json" speed="1" style="width:100px;height:70px" loop
                    autoplay></lottie-player>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

    <script>
        $(document).ready(function () {
            // anime({
            //     targets: '#chartTitle',
            //     translateY: [
            //         { value: -20, duration: 1200, easing: 'easeOutQuad' },
            //         { value: 0, duration: 1200, easing: 'easeOutBounce' }
            //     ],
            //     rotate: [
            //         { value: 0, duration: 400 }
            //     ],
            //     scale: [
            //         { value: 1.1, duration: 400 },
            //         { value: 1, duration: 400 }
            //     ],
            //     loop: true,
            //     delay: 2000,
            //     direction: 'normal'
            // });

            $('#cartonTable').DataTable({
                responsive: false,
                paging: false,
                searching: false,
                info: false,
                scrollY: '450px',
                scrollCollapse: true,
                order: [[5, 'desc']],
                columnDefs: [
                    { width: "5%", targets: 0, className: "text-center" },  // NO
                    { width: "20%", targets: 1, className: "text-center" },  // ORC
                    { width: "20%", targets: 2, className: "text-center" },  // STYLE
                    { width: "15%", targets: 3, className: "text-center" },  // COLOR
                    { width: "25%", targets: 4, className: "text-center" },  // CUSTOMER
                    { width: "15%", targets: 5, className: "text-center" },  // JML CTN
                ]
            });
        });

        // Area chart config
        var options = {
            chart: { type: 'area', height: 515 },
            series: [
                { name: 'Jumlah Carton', data: [] }
            ],
            xaxis: {
                categories: [],
                labels: {
                    rotate: -45,
                    style: { fontSize: '11px' }
                }
            },
            colors: ['#00fba3'],
            dataLabels: {
                enabled: true,
                style: { colors: ['#000000'] }
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.3
                }
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + ' Carton';
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#cartonChart"), options);
        chart.render();

        function fetchDataAndUpdate() {
            var tgl = document.getElementById('filterDate').value;

            fetch('get_output_carton_data.php?tgl=' + tgl)
                .then(res => res.json())
                .then(response => {
                    console.log('Data received:', response);

                    var data = response.data || [];

                    // Chart: ORC as categories, jumlah_carton as values
                    var orcs = data.map(d => d.orc);
                    var cartonCounts = data.map(d => d.jumlah_carton);

                    chart.updateOptions({ xaxis: { categories: orcs } });
                    chart.updateSeries([
                        { name: 'Jumlah Carton', data: cartonCounts }
                    ]);

                    // Table
                    var table = $('#cartonTable').DataTable();
                    table.clear();

                    data.forEach(function (d, i) {
                        table.row.add([
                            i + 1,
                            d.orc,
                            d.style,
                            d.color,
                            d.costomer,
                            d.jumlah_carton
                        ]);
                    });

                    table.draw(false);
                })
                .catch(err => console.error('Error fetching data:', err));
        }

        // First load
        fetchDataAndUpdate();

        // Auto refresh every 5 seconds
        setInterval(fetchDataAndUpdate, 5000);

        // Auto scroll table
        function initAutoScroll() {
            var scrollPosition = 0;
            var scrollSpeed = 0.5;
            var isPaused = false;

            setInterval(function () {
                if (isPaused) return;

                var scrollBody = document.querySelector('.dataTables_scrollBody');

                if (!scrollBody) return;

                scrollPosition += scrollSpeed;

                if (scrollPosition >= scrollBody.scrollHeight - scrollBody.clientHeight) {
                    scrollPosition = 0;
                }

                scrollBody.scrollTop = scrollPosition;
            }, 50);

            $('#cartonTable').hover(
                function () { isPaused = true; },
                function () { isPaused = false; }
            );
        }

        setTimeout(initAutoScroll, 2000);

        // Dynamic clock
        function updateTime() {
            var now = new Date();
            var options = { timeZone: 'Asia/Jakarta', hour12: false };
            var timeString = now.toLocaleTimeString('id-ID', options);
            timeString = timeString.replace(/\./g, ':');
            document.getElementById('time').innerText = timeString;
        }

        setInterval(updateTime, 1000);

        // Dynamic date
        function updateDate() {
            var now = new Date();
            var days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
            var months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September",
                "Oktober", "November", "Desember"];
            var dayName = days[now.getDay()];
            var date = now.getDate();
            var monthName = months[now.getMonth()];
            var year = now.getFullYear();
            document.getElementById('day-date').innerText = dayName + ', ' + date + ' ' + monthName + ' ' + year;
        }

        updateDate();
    </script>
</body>

</html>