<?php
   require_once 'core/init.php';
   require_once 'view/header_dashboard.php';

   date_default_timezone_set('Asia/Jakarta');

   if( !isset($_SESSION['monitor']) ){
      echo "<script>alert('Silakan Login terlebih dahulu untuk mengakses halaman ini');window.location='index.php'</script>";
    }

    $userName = $_SESSION['monitor'];
   //  $dataUser = tampilkan_line_username($_SESSION['username']);
    $dataUser = tampilkan_line_username($userName);
    $tempLine = mysqli_fetch_array($dataUser);
    $line = $tempLine['line'];
    
    $dataSPV = tampilkan_spv_by_namaline($line);
    $tempSPV = mysqli_fetch_array($dataSPV);
    $spv = $tempSPV['supervisor'];
    $operators = $tempSPV['operators'];
    $tgl = date('Y-m-d');

    $dataArray = array();
   //  $hasil = init_table_monitor_qc_endline($tgl, $line);
   $hasil = tampil_monitor_qc_endline($tgl, $line);

   while($row = mysqli_fetch_assoc($hasil)){
      $data = [
         "id" => $row["id"], 
         "orc" => preg_replace("/\s+/","",$row["orc"]), 
         "line" => $row["line"], 
         "status" => $row["status"], 
         "style" => $row["style"], 
         "color" => $row["color"],
         "size" => $row["size"], 
         "cup" => $row["cup"], 
         "qty_order" => $row["QTY_ORDER"], 
         "today" => $row["TODAY"],
         // "yesterday" => $row["YESTERDAY"],
         "total" => $row["TOTAL"], 
         "bal" => $row["BAL"], 
         "tanggal" => $row["tanggal"], 
         "jam" => $row["JAM"],
         "smv" => $row["smv"]
      ];
      array_push($dataArray, $data);
   }

   $dataInit = json_encode($dataArray);

   $dataOutput = get_output_qc_endline($tgl, $line);
   $dtArrOutput = [];
   while($r = mysqli_fetch_assoc($dataOutput)){
      $dt = [
         "id" => $r["id"], 
         "orc" => preg_replace("/\s+/","",$r["orc"]), 
         "line" => $r["line"], 
         "style" => $r["style"], 
         "smv" => $r["smv"],
         "qty_order" => $r["qty_order"],
         "qty" => $r["qty"], 
         "tanggal" => $r["tanggal"], 
         "jam" => $r["jam"]
      ];
      array_push($dtArrOutput, $dt);
   }
   $dataOutputInit = json_encode($dtArrOutput);

   $dataQCYesterday = get_output_qc_endline_yesterday($tgl, $line);

   $dtQCEndLineYesterday = mysqli_fetch_assoc($dataQCYesterday);

   // $dataPackingLineToday = get_output_packing_today($line);

   $dtPackingLineToday = get_output_packing_today($line);

   // $dtPackingLineToday = mysqli_fetch_assoc($dataPackingLineToday);

   $dataPackingYesterday = get_output_packing_yesterday($tgl, $line);

   $dtPackingYesterday = mysqli_fetch_assoc($dataPackingYesterday);

   
?>

<html>
   <head>
      <link rel="icon" href="img/icon.PNG">
      <style>
         body{
            overflow: hidden;
         }
         th.dt-center, td.dt-center { text-align: center; }

         #qcEndlineEffTable.table td{
            font-size: 0.9em;
            padding-left: 2px;
            padding-right: 2px;
            padding-top: 8px;
            padding-bottom: 8px;
         }         
         #qcEndlineEffTable.table th{
            font-size: 0.8em;
            padding-left: 2px;
            padding-right: 2px;
            padding-top: 4px;
            padding-bottom: 4px;
         }         
      </style>
   </head>
   <body class="g-sidenav-show" onload="showTime()">
      <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
         <div class="container-fluid py-2">

            <!-- Background -->
            <svg class="position-absolute top-0" width="2000" height="2000" viewBox="0 0 1231 1421" fill="none" xmlns="http://www.w3.org/2000/svg">
               <g opacity="0.12786" filter="url(#filter0_f_31_15)">
                  <ellipse cx="811.5" cy="602.5" rx="675.5" ry="682.5" fill="url(#paint0_linear_31_15)" />
               </g>
               <defs>
                  <filter id="filter0_f_31_15" x="0.085907" y="-215.914" width="1622.83" height="1636.83" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                     <feFlood flood-opacity="0" result="BackgroundImageFix" />
                     <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape" />
                     <feGaussianBlur stdDeviation="67.957" result="effect1_foregroundBlur_31_15" />
                  </filter>
                  <linearGradient id="paint0_linear_31_15" x1="804.405" y1="-136.203" x2="160.281" y2="643.776" gradientUnits="userSpaceOnUse">
                     <stop stop-color="#7B4CFF" />
                     <stop offset="0.469471" stop-color="#EC407A" />
                     <stop offset="1" stop-color="white" />
                  </linearGradient>
               </defs>
            </svg>
            
            <div class="row mx-0 px-1">
               <div class="col-md-8 pl-2">
                  <div class="ms-3">
                     <h3 class="mb-0 h4 font-weight-bolder">Sewing Screen Output Result</h3>
                     <p class="mb-4">
                        (Menampilkan Hasil Output Sewing).
                     </p>
                  </div>

                  <div class="row">

                     <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                        <div class="card shadow">
                           <div class="card-header p-2 ps-3 bg-gradient-dark">
                              <div class="d-flex justify-content-between">
                                 <div>
                                    <p class="text-sm mb-0 text-capitalize text-white">Date</p>
                                    <h4 class="mb-0 text-white"><?= date('d/m/Y') ?></h4>
                                 </div>
                                 <div class="icon icon-md icon-shape bg-gradient-success shadow-dark shadow text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">timer</i>
                                 </div>
                              </div>
                           </div>
                           <hr class="dark horizontal my-0">
                           <div class="card-footer p-2 ps-3">
                              <p class="mb-0 text-sm">
                                 <span class="text-success font-weight-bolder" id="jam"></span>
                              </p>
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                        <div class="card shadow">
                           <div class="card-header p-2 ps-3 bg-gradient-dark">
                           <div class="d-flex justify-content-between">
                              <div>
                                 <p class="text-sm mb-0 text-capitalize text-white">Line</p>
                                 <h4 class="mb-0 text-white"><?= $line; ?></h4>
                              </div>
                              <div class="icon icon-md icon-shape bg-gradient-success shadow-dark shadow text-center border-radius-lg">
                                 <i class="material-symbols-rounded opacity-10">person</i>
                              </div>
                           </div>
                           </div>
                           <hr class="dark horizontal my-0">
                           <div class="card-footer p-2 ps-3">
                           <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">SPV </span><?= $spv; ?></p>
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                        <div class="card shadow">
                           <div class="card-header p-2 ps-3 bg-gradient-dark">
                              <div class="d-flex justify-content-between">
                                 <div>
                                    <p class="text-sm mb-0 text-capitalize text-white">Operators</p>
                                    <h4 class="mb-0 text-white"><?= $operators; ?></h4>
                                 </div>
                                 <div class="icon icon-md icon-shape bg-gradient-success shadow-dark shadow text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">groups</i>
                                 </div>
                              </div>
                           </div>
                           <hr class="dark horizontal my-0">
                           <div class="card-footer p-2 ps-3">
                              <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">Show </span></p>
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                        <div class="card shadow">
                           <div class="card-header p-2 ps-3 bg-gradient-dark">
                              <div class="d-flex justify-content-between">
                                 <div>
                                    <!-- <p class="text-sm mb-0 text-capitalize text-white">Machines Fixed</p> -->
                                    <p class="text-sm mb-0 text-capitalize text-white">Today Target</p>
                                    <h4 class="mb-0 text-white" id="todayTarget">0</h4>
                                 </div>
                                 <div class="icon icon-md icon-shape bg-gradient-warning shadow-dark shadow text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">build</i>
                                 </div>
                              </div>
                           </div>
                           <hr class="dark horizontal my-0">
                           <div class="card-footer p-2 ps-3">
                              <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">Show </span></p>
                           </div>
                        </div>
                     </div>

                     <!-- Table -->
                     <div class="row mx-0 px-1">
                        <div class="mt-2">
                           <div class="card">
                              <div class="card-header p-0 position-relative mt-4 mx-3 z-index-2">
                                 <div class="bg-gradient-dark shadow-dark border-radius-lg pt-2 pb-1">
                                    <h6 class="text-white text-capitalize ps-3">Output Result</h6>
                                 </div>
                              </div>
                              <div class="card-body px-0 pb-2">
                                 <!-- <div class="table-responsive p-0"> -->
                                    <table class="table align-items-center mb-0" id="qcEndlineOutputTable">
                                       <thead>
                                          <tr>
                                             <th class="text-uppercase text-secondary font-weight-bolder align-middle text-center">ID</th>
                                             <th class="text-uppercase text-secondary font-weight-bolder align-middle text-center">ORC</th>
                                             <th class="text-uppercase text-secondary font-weight-bolder align-middle text-center">Style</th>
                                             <th class="text-uppercase text-secondary font-weight-bolder align-middle text-center">Qty Order</th>
                                             <th class="text-uppercase text-secondary font-weight-bolder align-middle text-center">Today</th>
                                             <th class="text-uppercase text-secondary font-weight-bolder align-middle text-center">Total</th>
                                             <th class="text-uppercase text-secondary font-weight-bolder align-middle text-center">Balance</th>
                                             <th class="text-uppercase text-secondary font-weight-bolder align-middle text-center">Tanggal</th>
                                             <th class="text-uppercase text-secondary font-weight-bolder align-middle text-center">Jam</th>
                                             <!-- <th class="text-uppercase text-secondary font-weight-bolder align-middle text-center">Eff(%)</th> -->
                                          </tr>
                                       </thead>
                                    </table>
                                 <!-- </div> -->
                              </div> 
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="col-md-4 px-0">
                  <div class="row mb-6"></div>
                  <div class="row pt-3">

                     <!-- Line Performanfe -->
                     <div class="col-md-6 col-sm-6 mb-xl-0 mb-2" style="display: none;">
                        <div class="card shadow">
                           <div class="card-header p-2 ps-3 bg-gradient-dark">
                              <div class="d-flex justify-content-between">
                                 <div>
                                    <p class="text-sm mb-0 text-capitalize text-white">Today Line Efficiency</p>
                                    <h4 class="mb-0 text-white" id="todayEff"></h4>
                                 </div>
                                 <div class="icon icon-md icon-shape bg-gradient-success shadow-dark shadow text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">percent</i>
                                 </div>
                              </div>
                           </div>
                           <hr class="dark horizontal my-0">
                           <div class="card-footer p-2 ps-3">
                              <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">Show </span></p>
                           </div>
                        </div>
                     </div>

                     <div class="col-xl-6 col-sm-6 mb-xl-0 mb-2" style="display: none;">
                        <div class="card shadow">
                           <div class="card-header p-2 ps-3 bg-gradient-dark">
                              <div class="d-flex justify-content-between">
                                 <div>
                                    <p class="text-sm mb-0 text-capitalize text-white">Downtime Machine</p>
                                    <h4 class="mb-0 text-white">00:00:00</h4>
                                 </div>
                                 <div class="icon icon-md icon-shape bg-gradient-success shadow-dark shadow text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">manufacturing</i>
                                 </div>
                              </div>
                           </div>
                           <hr class="dark horizontal my-0">
                           <div class="card-footer p-2 ps-3">
                           <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">Show </span></p>
                           </div>
                        </div>
                     </div>

                     <div class="col-md-6 col-sm-6 mb-xl-0 mb-2 mt-2">
                        <div class="card shadow">
                           <div class="card-header p-2 ps-3 bg-gradient-dark">
                              <div class="d-flex justify-content-between">
                                 <div>
                                    <p class="text-sm mb-0 text-capitalize text-white">Sewing Today</p>
                                    <h4 class="mb-0 text-white" id="sewingToday"></h4>
                                 </div>
                                 <div class="icon icon-md icon-shape bg-gradient-success shadow-dark shadow text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">manufacturing</i>
                                 </div>
                              </div>
                           </div>
                           <hr class="dark horizontal my-0">
                           <div class="card-footer p-2 ps-3">
                           <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">Show </span></p>
                           </div>
                        </div>
                     </div>

                     <div class="col-md-6 col-sm-6 mb-xl-0 mb-2 mt-2">
                        <div class="card shadow">
                           <div class="card-header p-2 ps-3 bg-gradient-dark">
                              <div class="d-flex justify-content-between">
                                 <div>
                                    <p class="text-sm mb-0 text-capitalize text-white">Sewing Yesterday</p>
                                    <h4 class="mb-0 text-white" id="sewingYesterday">0</h4>
                                 </div>
                                 <div class="icon icon-md icon-shape bg-gradient-info shadow-dark shadow text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">manufacturing</i>
                                 </div>
                              </div>
                           </div>
                           <hr class="dark horizontal my-0">
                           <div class="card-footer p-2 ps-3">
                           <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">Show </span></p>
                           </div>
                        </div>
                     </div>

                     <div class="col-md-6 col-sm-6 mb-xl-0 mb-2 mt-2">
                        <div class="card shadow">
                           <div class="card-header p-2 ps-3 bg-gradient-dark">
                              <div class="d-flex justify-content-between">
                                 <div>
                                    <p class="text-sm mb-0 text-capitalize text-white">Packing Line Today</p>
                                    <h4 class="mb-0 text-white" id="packingLineToday">0</h4>
                                 </div>
                                 <div class="icon icon-md icon-shape bg-gradient-success shadow-dark shadow text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">inventory_2</i>
                                 </div>
                              </div>
                           </div>
                           <hr class="dark horizontal my-0">
                           <div class="card-footer p-2 ps-3">
                           <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">Show </span></p>
                           </div>
                        </div>
                     </div>

                     <div class="col-md-6 col-sm-6 mb-xl-0 mb-2 mt-2">
                        <div class="card shadow">
                           <div class="card-header p-2 ps-3 bg-gradient-dark">
                              <div class="d-flex justify-content-between">
                                 <div>
                                    <p class="text-sm mb-0 text-capitalize text-white">Packing line Yesterday</p>
                                    <h4 class="mb-0 text-white" id="packingYesterday">0</h4>
                                 </div>
                                 <div class="icon icon-md icon-shape bg-gradient-info shadow-dark shadow text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">inventory_2</i>
                                 </div>
                              </div>
                           </div>
                           <hr class="dark horizontal my-0">
                           <div class="card-footer p-2 ps-3">
                           <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">Show </span></p>
                           </div>
                        </div>
                     </div>

                  </div>

               </div>
            </div>

            <!-- <div class="row mx-0 px-1">
               <div class="mt-4">
                  <div class="card">
                     <div class="card-header p-0 position-relative mt-4 mx-3 z-index-2">
                        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-2 pb-1">
                           <h6 class="text-white text-capitalize ps-3">Line Output Hourly</h6>
                        </div>
                     </div>
                     <div class="card-body px-0 pb-2">
                           <table class="table compact table-bordered align-items-center mb-0" id="qcEndlineEffTable" style="width:100%">
                              <thead>
                                 <tr>
                                    <th rowspan="2">ORC</th>
                                    <th rowspan="2">STYLE</th>
                                    <th class="dt-center" colspan="2">1st</th>
                                    <th class="dt-center" colspan="2">2nd</th>
                                    <th class="dt-center" colspan="2">3rd</th>
                                    <th class="dt-center" colspan="2">4th</th>
                                    <th class="dt-center" colspan="2">5th</th>
                                    <th class="dt-center" colspan="2">6th</th>
                                    <th class="dt-center" colspan="2">7th</th>
                                    <th class="dt-center" colspan="2">8th</th>
                                    <th class="dt-center" colspan="2">9th</th>
                                    <th class="dt-center" colspan="2">10th</th>
                                 </tr>
                                 <tr>
                                    <th>Output</th><th>Eff(%)</th>
                                    <th>Output</th><th>Eff(%)</th>
                                    <th>Output</th><th>Eff(%)</th>
                                    <th>Output</th><th>Eff(%)</th>
                                    <th>Output</th><th>Eff(%)</th>
                                    <th>Output</th><th>Eff(%)</th>
                                    <th>Output</th><th>Eff(%)</th>
                                    <th>Output</th><th>Eff(%)</th>
                                    <th>Output</th><th>Eff(%)</th>
                                    <th>Output</th><th>Eff(%)</th>
                                 </tr>
                              </thead>
                           </table>
                     </div> 
                  </div>
               </div>               
            </div> -->

            <footer class="footer py-4  ">
               <div class="container-fluid">
                  <div class="row align-items-center justify-content-lg-between">
                     <div class="col-lg-6 mb-lg-0 mb-4">
                     <div class="copyright text-center text-sm text-muted text-lg-start">
                        © <script>
                           document.write(new Date().getFullYear())
                        </script>,
                        made with <i class="fa fa-heart"></i> by
                        <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Globalindo - MIS</a>
                        for a better future.
                     </div>
                     </div>
                  </div>
               </div>
            </footer>
         </div>
      </main>
      <!--   Core JS Files   -->
      <script>
         var line = '<?= $line; ?>';
         var operators = parseInt('<?= $operators; ?>');
         var totEff = 0;

         var todayQCEndLineSUM = 0, yesterdayQCEndLineSUM = 0;
         var qcEndlineOutputTable;
         var qcEndlineEffTable;
         var dataInit = '<?= $dataInit; ?>';
         var objDataQCEndline = JSON.parse(dataInit);
         
         var dataOutputInit = '<?= $dataOutputInit; ?>';
         var objDataOutputInit = JSON.parse(dataOutputInit);
         
         var strCurrentDate = new Date().toJSON().slice(0, 10);

         var dtQCEndLineYesterday = '<?= $dtQCEndLineYesterday['Output_Yesterday']; ?>';

         var packingToday = 0;

         // var dtPackingLineToday = ('<//?= $dtPackingLineToday['Packing_Today']; ?>' == "" ? 0 : parseInt('<//?= //$dtPackingLineToday['Packing_Today']; ?>'));

         // var dtPackingLineToday = ("<//?= $dtPackingLineToday; ?>" == "" ? 0 : parseInt("<//?= $dtPackingLineToday['Packing_Today']; ?>"));

         var dtPackingLineToday = JSON.parse('<?= $dtPackingLineToday; ?>');
         console.log('dtPackingLineToday: ', dtPackingLineToday);

         var dtPackingYesterday = '<?= $dtPackingYesterday['Packing_Yesterday']; ?>';

         packingToday = dtPackingLineToday == null ? 0 : parseInt(dtPackingLineToday.Packing_Today);

         // $('#packingLineToday').text(dtPackingLineToday == null ? 0 : parseInt(dtPackingLineToday.Packing_Today));

         $('#packingLineToday').text(packingToday);

         $('#packingYesterday').text(dtPackingYesterday == "" ? 0 : dtPackingYesterday);

         $('#sewingYesterday').text(dtQCEndLineYesterday == "" ? 0 : dtQCEndLineYesterday);
         
         var arrWorkingHours = [
            {'JamKe': 1, "start": new Date(strCurrentDate + " 07:30:00"), "end": new Date(strCurrentDate + " 08:30:00")},
            {'JamKe': 2, "start": new Date(strCurrentDate + " 08:31:00"), "end": new Date(strCurrentDate + " 09:30:00")},
            {'JamKe': 3, "start": new Date(strCurrentDate + " 09:31:00"), "end": new Date(strCurrentDate + " 10:30:00")},
            {'JamKe': 4, "start": new Date(strCurrentDate + " 10:31:00"), "end": new Date(strCurrentDate + " 11:30:00")},
            {'JamKe': 5, "start": new Date(strCurrentDate + " 11:31:00"), "end": new Date(strCurrentDate + " 12:30:00")},
            {'JamKe': 6, "start": new Date(strCurrentDate + " 12:31:00"), "end": new Date(strCurrentDate + " 13:30:00")},
            {'JamKe': 7, "start": new Date(strCurrentDate + " 13:31:00"), "end": new Date(strCurrentDate + " 14:30:00")},
            {'JamKe': 8, "start": new Date(strCurrentDate + " 14:31:00"), "end": new Date(strCurrentDate + " 15:30:00")},
            {'JamKe': 9, "start": new Date(strCurrentDate + " 15:31:00"), "end": new Date(strCurrentDate + " 16:30:00")},
            {'JamKe': 10, "start": new Date(strCurrentDate + " 16:31:00"), "end": new Date(strCurrentDate +" 17:30:00")},
            {'JamKe': 11, "start": new Date(strCurrentDate + " 17:31:00"), "end": new Date(strCurrentDate +" 18:30:00")},
            {'JamKe': 12, "start": new Date(strCurrentDate + " 18:31:00"), "end": new Date(strCurrentDate +" 19:30:00")}
         ];
         
         var today = new Date();
         
         var jamKe = arrWorkingHours.reduce((a, b) => Math.abs(a.start - today) < Math.abs(b.start - today) ? a : b);

         var arrEffPros = [];

         // var qc_endline = new WebSocket("ws://192.168.90.100:10000/?service=qc_endline");
         // var qc_endline = new WebSocket("ws://localhost:10000/?service=qc_endline");

         function LoadDataEffQCEndline(dataArr){
            arrEffPros = [];

            const effHourly = dataArr.map((el) => {
               let dateTime = new Date(el.tanggal + " " + el.jam);
               let jKe = arrWorkingHours.reduce((a, b) => Math.abs(a.start - dateTime) < Math.abs(b.start - dateTime) ? a : b);

               return {
                  "orc": el.orc,
                  "style": el.style,
                  "smv": parseFloat(el.smv),
                  "line": el.line,
                  "jamKe": parseInt(jKe.JamKe),
                  "qty": parseInt(el.qty)
               }
            }).reduce((acc, curr) => {
               const existing = acc.find(item => item.orc === curr.orc && item.style === curr.style && item.jamKe == curr.jamKe);
               if(existing){
                  existing.qty += curr.qty;
               }else{
                  acc.push({ ...curr});
               }
               return acc;
            }, []).map((el, idx, effHourly) => {
               let smv = el.smv;
               let qty = el.qty;
               let totalMinutesProduced = smv * qty;
               let jamKe = el.jamKe;
               let totalMinutesWorked = operators * jamKe * 60;
               let efficiency = (totalMinutesProduced/totalMinutesWorked) * 100;

               return {
                  "orc": el.orc,
                  "style": el.style,
                  "line": el.line,

                  "output1": (jamKe == 1 ? qty : 0),
                  "eff1": (jamKe == 1 ? efficiency : 0),

                  "output2": (jamKe == 2 ? qty : 0),
                  "eff2": (jamKe == 2 ? efficiency : 0),

                  "output3": (jamKe == 3 ? qty : 0),
                  "eff3": (jamKe == 3 ? efficiency : 0),

                  "output4": (jamKe == 4 ? qty : 0),
                  "eff4": (jamKe == 4 ? efficiency : 0),

                  "output5": (jamKe == 5 ? qty : 0),
                  "eff5": (jamKe == 5 ? efficiency : 0),

                  "output6": (jamKe == 6 ? qty : 0),
                  "eff6": (jamKe == 6 ? efficiency : 0),

                  "output7": (jamKe == 7 ? qty : 0),
                  "eff7": (jamKe == 7 ? efficiency : 0),

                  "output8": (jamKe == 1 ? qty : 0),
                  "eff8": (jamKe == 1 ? efficiency : 0),

                  "output9": (jamKe == 9 ? qty : 0),
                  "eff9": (jamKe == 9 ? efficiency : 0),

                  "output10": (jamKe == 10 ? qty : 0),
                  "eff10": (jamKe == 10 ? efficiency : 0),
               };

            });

            let z=0, effHourlyLength = effHourly.length;
            var objHourly = {};
            while(z < effHourlyLength){
               if(z == 0){
                  objHourly = {
                     "orc": effHourly[0].orc,
                     "style": effHourly[0].style,
                     "line": effHourly[0].line,

                     "output1": effHourly[0].output1,
                     "eff1": effHourly[0].eff1,

                     "output2": effHourly[0].output2,
                     "eff2": effHourly[0].eff2,

                     "output3": effHourly[0].output3,
                     "eff3": effHourly[0].eff3,

                     "output4": effHourly[0].output4,
                     "eff4": effHourly[0].eff4,

                     "output5": effHourly[0].output5,
                     "eff5": effHourly[0].eff5,

                     "output6": effHourly[0].output6,
                     "eff6": effHourly[0].eff6,

                     "output7": effHourly[0].output7,
                     "eff7": effHourly[0].eff7,

                     "output8": effHourly[0].output8,
                     "eff8": effHourly[0].eff8,

                     "output9": effHourly[0].output9,
                     "eff9": effHourly[0].eff9,

                     "output10": effHourly[0].output10,
                     "eff10": effHourly[0].eff10,
                  };
                  arrEffPros.push(objHourly);
               }else{
                  var curObj = effHourly[z];
                  var prevObj = effHourly[z-1];
                  if(curObj.orc === prevObj.orc && curObj.style === prevObj.style){
                     arrEffPros.forEach((item) => {
                        item.output1 = (item.output1 == 0 ? curObj.output1 : item.output1);
                        item.eff1 = (item.eff1 == 0 ? curObj.eff1 : item.eff1);

                        item.output2 = (item.output2 == 0 ? curObj.output2 : item.output2);
                        item.eff2 = (item.eff2 == 0 ? curObj.eff2 : item.eff2);

                        item.output3 = (item.output3 == 0 ? curObj.output3 : item.output3);
                        item.eff3 = (item.eff3 == 0 ? curObj.eff3 : item.eff3);

                        item.output4 = (item.output4 == 0 ? curObj.output4 : item.output4);
                        item.eff4 = (item.eff4 == 0 ? curObj.eff4 : item.eff4);

                        item.output5 = (item.output5 == 0 ? curObj.output5 : item.output5);
                        item.eff5 = (item.eff5 == 0 ? curObj.eff5 : item.eff5);
                        
                        item.output6 = (item.output6 == 0 ? curObj.output6 : item.output6);
                        item.eff6 = (item.eff6 == 0 ? curObj.eff6 : item.eff6);

                        item.output7 = (item.output7 == 0 ? curObj.output7 : item.output7);
                        item.eff7 = (item.eff7 == 0 ? curObj.eff7 : item.eff7);

                        item.output8 = (item.output8 == 0 ? curObj.output8 : item.output8);
                        item.eff8 = (item.eff8 == 0 ? curObj.eff8 : item.eff8);

                        item.output9 = (item.output9 == 0 ? curObj.output9 : item.output9);
                        item.eff9 = (item.eff9 == 0 ? curObj.eff9 : item.eff9);

                        item.output10 = (item.output10 == 0 ? curObj.output10 : item.output10);
                        item.eff10 = (item.eff10 == 0 ? curObj.eff10 : item.eff10);


                     })
                  }else{
                     let objHourly1 = {
                        "orc": curObj.orc,
                        "style": curObj.style,
                        "line": curObj.line,
      
                        "output1": curObj.output1,
                        "eff1": curObj.eff1,
      
                        "output2": curObj.output2,
                        "eff2": curObj.eff2,
      
                        "output3": curObj.output3,
                        "eff3": curObj.eff3,
      
                        "output4": curObj.output4,
                        "eff4": curObj.eff4,
      
                        "output5": curObj.output5,
                        "eff5": curObj.eff5,
      
                        "output6": curObj.output6,
                        "eff6": curObj.eff6,
      
                        "output7": curObj.output7,
                        "eff7": curObj.eff7,
      
                        "output8": curObj.output8,
                        "eff8": curObj.eff8,
      
                        "output9": curObj.output9,
                        "eff9": curObj.eff9,
      
                        "output10": curObj.output10,
                        "eff10": curObj.eff10,
                     };
                     arrEffPros.push(objHourly1);
                  }
               }
               ++z;
            }
         }

         $(document).ready(function(){
            // var output_target = new WebSocket("ws://127.0.0.1:10000/?service=ouput_target");
            var output_target = new WebSocket("ws://192.168.90.100:10000/?service=ouput_target");

            fetchQCEndlineTarget(line);

            initTableQCOutput();

            initTableQCEff();

            function fetchQCEndlineTarget(l){
               // var rLine = l.slice(0,4) + " " + ln.slice(4);
                  $.ajax({
                     type: 'GET',
                     url: 'functions/ajax_functions_handler.php',
                     data: {
                        action: 'ajax_getQCEndlineTarget',
                        param: {
                           'line': l
                        }
                     },
                     dataType: 'JSON'
                  }).done(function(dt){
                     if(dt != null){
                        $('#todayTarget').text(dt.target);
                     }else{
                        $('#todayTarget').text('0');
                     }
                  });
            }            

            function initTableQCOutput(){
               qcEndlineOutputTable = $('#qcEndlineOutputTable').DataTable({
                  autoWidth: true,
                  processing: true,
                  destroy: true,
                  info: false,
                  searching: false,
                  paging: false,
                  fixedHeader: true,
                  order: [[0, 'desc']],
                  columnDefs: [
                     {'className': 'dt-center', 'targets': '_all'},
                     {'targets': [0,7,8], 'visible': false},
                  ]
               });
               // console.table(jamKe);
               // if(jamKe.JamKe > 0){
                  var x = 0, arrLength = objDataQCEndline.length;
                  while(x < arrLength){
                     if(line == objDataQCEndline[x].line){
                        todayQCEndLineSUM += parseInt(objDataQCEndline[x].today);
                        let smv = parseFloat(objDataQCEndline[x].smv);
                        let totalMinutesProduced = smv * parseInt(objDataQCEndline[x].today);
                        let totalMinutesWorked = operators * jamKe.JamKe * 60;
                        let efficiency = (totalMinutesProduced/totalMinutesWorked) * 100;
                        totEff += efficiency;                     
                        qcEndlineOutputTable.row.add([
                           objDataQCEndline[x].id,
                           objDataQCEndline[x].orc,
                           objDataQCEndline[x].style,
                           objDataQCEndline[x].qty_order,
                           objDataQCEndline[x].today,
                           objDataQCEndline[x].total,
                           objDataQCEndline[x].bal,
                           objDataQCEndline[x].tanggal,
                           objDataQCEndline[x].jam
                           // efficiency.toFixed(2)
                        ]).draw();
                     }
                     ++x;
                  }
                  let totEffPros = totEff/arrLength;
                  $('#todayEff').text(totEffPros.toFixed(2));
                  $('#sewingToday').text(todayQCEndLineSUM);            
               // }
               // qcEndlineOutputTable.columns([6,7]).visible(false);
            }

            function initTableQCEff(){
               qcEndlineEffTable = $('#qcEndlineEffTable').DataTable({
                  // autoWidth: false,
                  processing: true,
                  destroy: true,
                  info: false,
                  searching: false,
                  paging: false,
                  // fixedHeader: false,
                  responsive: true,
                  columnDefs: [
                     {'className': 'dt-center', 'targets': '_all'},
                  ]
               });

               LoadDataEffQCEndline(objDataOutputInit);
               // table eff qc endline
               for(let c = 0; c < arrEffPros.length; c++){
                  qcEndlineEffTable.row.add([
                     arrEffPros[c].orc,
                     arrEffPros[c].style,

                     arrEffPros[c].output1,
                     arrEffPros[c].eff1.toFixed(2),

                     arrEffPros[c].output2,
                     arrEffPros[c].eff2.toFixed(2),

                     arrEffPros[c].output3,
                     arrEffPros[c].eff3.toFixed(2),

                     arrEffPros[c].output4,
                     arrEffPros[c].eff4.toFixed(2),

                     arrEffPros[c].output5,
                     arrEffPros[c].eff5.toFixed(2),

                     arrEffPros[c].output6,
                     arrEffPros[c].eff6.toFixed(2),

                     arrEffPros[c].output7,
                     arrEffPros[c].eff7.toFixed(2),

                     arrEffPros[c].output8,
                     arrEffPros[c].eff8.toFixed(2),

                     arrEffPros[c].output9,
                     arrEffPros[c].eff9.toFixed(2),

                     arrEffPros[c].output10,
                     arrEffPros[c].eff10.toFixed(2),

                  ]).draw();
               }               
            }

            output_target.onmessage = function(msg){
               var objDataTargetOnMessage = JSON.parse(msg.data);
               if(line == objDataTargetOnMessage.line){
                  $('#todayTarget').text(objDataTargetOnMessage.target);
               }
            }

         });
         
         var qc_endline = new WebSocket("ws://192.168.90.100:10000/?service=qc_endline");
         var packing = new WebSocket("ws://192.168.90.100:10000/?service=packing");
         // var output_target = new WebSocket("ws://192.168.90.100:10000/?service=output_target");
         
         // var packing = new WebSocket("ws://127.0.0.1:10000/?service=packing");

         qc_endline.onmessage = function(msg){
            var objDataQCEndlineOnMessage = JSON.parse(msg.data);

            if(line == objDataQCEndlineOnMessage.dataOutput[0].line){
               // if(jamKe.JamKe > 0){
                  totEff = 0;
                  todayQCEndLineSUM = 0;
                  qcEndlineOutputTable.clear().draw();
   
                  var y = 0, arrLengthOnMessage = objDataQCEndlineOnMessage.dataOutput.length;
                  while(y < arrLengthOnMessage){
                     todayQCEndLineSUM += parseInt(objDataQCEndlineOnMessage.dataOutput[y].today);
                     let smv = parseFloat(objDataQCEndlineOnMessage.dataOutput[y].smv);
                     let totalMinutesProduced = smv * parseInt(objDataQCEndlineOnMessage.dataOutput[y].today);
                     let totalMinutesWorked = operators * jamKe.JamKe * 60;
                     let efficiency = (totalMinutesProduced/totalMinutesWorked) * 100;
                     totEff += efficiency;
                     qcEndlineOutputTable.row.add([
                        objDataQCEndlineOnMessage.dataOutput[y].id,
                        objDataQCEndlineOnMessage.dataOutput[y].orc,
                        objDataQCEndlineOnMessage.dataOutput[y].style,
                        objDataQCEndlineOnMessage.dataOutput[y].qty_order,
                        objDataQCEndlineOnMessage.dataOutput[y].today,
                        objDataQCEndlineOnMessage.dataOutput[y].total,
                        objDataQCEndlineOnMessage.dataOutput[y].bal,
                        objDataQCEndlineOnMessage.dataOutput[y].tanggal,
                        objDataQCEndlineOnMessage.dataOutput[y].jam,
                        efficiency.toFixed(2)
                     ]).draw();                  
                     ++y;
                  }
                  let totEffPros = totEff/arrLengthOnMessage;
                  $('#todayEff').text(totEffPros.toFixed(2));
                  $('#sewingToday').text(todayQCEndLineSUM);
                  // $('#sewingYesterday').text(yesterdayQCEndLineSUM);

                  LoadDataEffQCEndline(objDataQCEndlineOnMessage.dataEff);
                  qcEndlineEffTable.clear().draw();
                  for(let c = 0; c < arrEffPros.length; c++){
                     qcEndlineEffTable.row.add([
                        arrEffPros[c].orc,
                        arrEffPros[c].style,

                        arrEffPros[c].output1,
                        arrEffPros[c].eff1.toFixed(2),

                        arrEffPros[c].output2,
                        arrEffPros[c].eff2.toFixed(2),

                        arrEffPros[c].output3,
                        arrEffPros[c].eff3.toFixed(2),

                        arrEffPros[c].output4,
                        arrEffPros[c].eff4.toFixed(2),

                        arrEffPros[c].output5,
                        arrEffPros[c].eff5.toFixed(2),

                        arrEffPros[c].output6,
                        arrEffPros[c].eff6.toFixed(2),

                        arrEffPros[c].output7,
                        arrEffPros[c].eff7.toFixed(2),

                        arrEffPros[c].output8,
                        arrEffPros[c].eff8.toFixed(2),

                        arrEffPros[c].output9,
                        arrEffPros[c].eff9.toFixed(2),

                        arrEffPros[c].output10,
                        arrEffPros[c].eff10.toFixed(2),

                     ]).draw();
                  }                  
               // }
            }

         }

         packing.onmessage = function(msg){
            var objDataPackingOnMessage = JSON.parse(msg.data);
            console.log(objDataPackingOnMessage);
            if(line == objDataPackingOnMessage.line){
               packingToday +=parseInt(objDataPackingOnMessage.qty_today);
               $('#packingLineToday').text(packingToday);
            }
         }


         function showTime(){
            const date = new Date();
            let h = date.getHours();
            let m = date.getMinutes();
            let s = date.getSeconds();

            h = (h < 10) ? h = "0" + h : h;
            m = (m < 10) ? m = "0" + m : m;
            s = (s < 10) ? s = "0" + s : s;

            let time = h + ":" + m + ":" + s;
            document.getElementById('jam').innerHTML = time;
            setTimeout(showTime, 1000);            
         }

      </script>
      

   </body>

</html>
