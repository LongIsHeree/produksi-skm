<!DOCTYPE html>
<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<head>
  <title>APLIKASI PRODUKSI GI</title>
  <script src="/produksi-skm/assets/js/jquery.js"></script>
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
  <script type="text/javascript" src="/produksi-skm/assets/DataTables/js/jquery.js"></script>
  <script type="text/javascript" src="/produksi-skm/assets/js/bootstrap.js"></script>
  <script type="text/javascript" src="/produksi-skm/assets/DataTables/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="/produksi-skm/assets/popper.min.js"></script>
  <link rel="stylesheet" type="text/css" href="/produksi-skm/assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="/produksi-skm/assets/DataTables/css/jquery.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="/produksi-skm/assets/DataTables/css/dataTables.bootstrap.css">
  <link rel="stylesheet" type="text/css" href="/produksi-skm/assets/DataTables/css/select2.min.css" />

  <!-- jika menggunakan bootstrap4 gunakan css ini  -->
  <link rel="stylesheet" href="/produksi-skm/assets/css/select2-bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="/produksi-skm/assets/FixedColumns/css/fixedColumns.dataTables.min.css">
  <script type="text/javascript" src="/produksi-skm/assets/FixedColumns/js/dataTables.fixedColumns.min.js"></script>
  <!-- <link rel="stylesheet" type="text/css" href="assets/row-reorder/css/rowReorder.dataTables.min.css">
<script type="text/javascript" src="assets/row-reorder/js/dataTables.rowReorder.min.js"></script> -->
  <link rel="stylesheet" type="text/css" href="/produksi-skm/assets/FixedHeader/css/fixedHeader.dataTables.min.css">
  <script type="text/javascript" src="/produksi-skm/assets/FixedHeader/js/dataTables.fixedHeader.min.js"></script>

  <!-- <link rel="stylesheet" href="assets/sweetalert2/sweetalert2.min.css" /> -->
  <script src="/produksi-skm/assets/sweetalert2/sweetalert2.all.min.js"></script>
  <!-- <script src="assets/sweetalert2/sweetalert2.all.min.js"></script> -->

  <!-- cdn bootstrap4 -->
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
            integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous"> -->

  <!-- <link rel="stylesheet" href="view/nav_style.css"> -->
  <link rel="stylesheet" href="/produksi-skm/view/style.css">
  <!-- <link rel="icon" href="img/skm_icon.png"> -->
  <!-- <link rel="icon" href="img/gi-logo-removebg.png"> -->
  <link rel="icon" href="img/icon.PNG">

  <link rel="stylesheet" href="/produksi-skm/assets/Datatables2/css/cdn.datatables.net_1.13.5_css_jquery.dataTables.min.css">
  <link rel="stylesheet" href="/produksi-skm/assets/Datatables2/css/cdn.datatables.net_buttons_2.4.1_css_buttons.dataTables.min.css">
  <link rel="stylesheet" href="/produksi-skm/assets/Datatables2/css/cdn.datatables.net_select_1.7.0_css_select.dataTables.min.css">

  <!-- <script src="assets/Datatables2/js/code.jquery.com_jquery-3.7.0.js"></script> -->
  <script src="/produksi-skm/assets/Datatables2/js/cdn.datatables.net_1.13.5_js_jquery.dataTables.min.js"></script>

  <script src="/produksi-skm/assets/Datatables2/js/cdn.datatables.net_buttons_2.4.1_js_dataTables.buttons.min.js"></script>

  <script src="/produksi-skm/assets/Datatables2/js/cdnjs.cloudflare.com_ajax_libs_jszip_3.10.1_jszip.min.js"></script>
  <script src="/produksi-skm/assets/Datatables2/js/cdnjs.cloudflare.com_ajax_libs_pdfmake_0.1.53_pdfmake.min.js"></script>
  <script src="/produksi-skm/assets/Datatables2/js/cdnjs.cloudflare.com_ajax_libs_pdfmake_0.1.53_vfs_fonts.js"></script>
  <!--<script src="assets/Datatables2/js/cdn.datatables.net_buttons_2.4.1_js_buttons.html5.min.js"></script>-->
  <script src="/produksi-skm/assets/Datatables2/js/cdn.datatables.net_buttons_2.4.1_js_buttons.html5.js"></script>
  <script src="/produksi-skm/assets/Datatables2/js/cdn.datatables.net_buttons_2.4.1_js_buttons.print.min.js"></script>
  <script src="/produksi-skm/assets/Datatables2/js/cdn.datatables.net_select_1.7.0_js_dataTables.select.min.js"></script>

  <style>
    .swal2-modal {
      width: 40%;
    }

    .swal2-popup {
      padding: 3em;
    }

    .swal2-icon-text {
      font-size: 5em;
    }

    .swal2-icon {
      width: 5em;
      height: 5em;
    }

    .swal2-icon {
      line-height: 5em;
      font-size: 1.3em;
    }

    .swal2-popup .swal2-title {
      font-size: 2.5em;
    }

    .swal2-popup .swal2-content {
      font-size: 1.5em;
    }

    .swal2-popup .swal2-styled.swal2-confirm {
      font-size: 1.5em;
    }

    .swal2-popup .swal2-styled.swal2-cancel {
      font-size: 1.5em;
    }

    .nav-link:after {
      content: "|";
      position: absolute;
      color: white;
      top: 15px;
      margin-left: -5px;

    }
  </style>
</head>

<body>

  <nav>

    <ul style="background: #254681">
      <?php
      if (isset($_SESSION['username'])) {
        if (
          cek_status($_SESSION['username']) == 'admin' or
          cek_status($_SESSION['username']) == 'ppic' or
          cek_status($_SESSION['username']) == 'MERCHANDISER'
          // cek_status($_SESSION['username']) == 'warehouse' or
          // cek_status($_SESSION['username']) == 'team_sample' or
          // cek_status($_SESSION['username']) == 'ppm' or
          // cek_status($_SESSION['username']) == 'pattern_check' or
          // cek_status($_SESSION['username']) == 'moulding_bounding' or
          // cek_status($_SESSION['username']) == 'team_marker' or
          // cek_status($_SESSION['username']) == 'machines_setting' or
          // cek_status($_SESSION['username']) == 'layout' or
          // cek_status($_SESSION['username']) == 'ready_produksi'
        ) {
      ?>
          <li class="nav-link" style="background: #254681"><a href="#">DATA MASTER</a>
            <ul>
              <!-- <li style="background: #254681"><a style="background: #254681" href="master_department.php">MASTER DEPARTMENT</a></li> -->
              <li><a href="master-order.php" style="background: #254681">MASTER ORDER</a>
                <ul>
                  <li style="background: #254681"><a href="tambah-order.php">TAMBAH ORDER</a></li>
                </ul>
              </li>
              <li style="background: #254681"><a style="background: #254681" href="master_barang2.php">MASTER BARANG</a></li>
              <li style="background: #254681"><a style="background: #254681" href="master-size.php">MASTER SIZE</a></li>
              <li style="background: #254681"><a style="background: #254681" href="master-costomer.php">MASTER COSTOMER</a></li>
              <li style="background: #254681"><a style="background: #254681" href="master_item.php">MASTER ITEMS</a></li>
              <li style="background: #254681"><a style="background: #254681" href="master-style.php">MASTER STYLE</a></li>
              <li style="background: #254681"><a style="background: #254681" href="master_smv.php">MASTER SMV</a></li>
              <li style="background: #254681"><a style="background: #254681" href="master-material.php">MASTER MATERIAL</a></li>
              <li style="background: #254681"><a style="background: #254681" href="master-part.php">MASTER PART</a></li>
              <li style="background: #254681"><a style="background: #254681" href="master-bom.php">MASTER BOM</a></li>
              <li style="background: #254681"><a style="background: #254681" href="master-line.php">MASTER LINE</a></li>
              <li style="background: #254681"><a style="background: #254681" href="master_karton.php">MASTER QTY CTN</a></li>
              <li style="background: #254681"><a style="background: #254681" href="master-user.php">MASTER USER</a></li>
              <li style="background: #254681"><a style="background: #254681" href="master_karton_full.php">MASTER KARTON FULL</a></li>
              <li style="background: #254681"><a style="background: #254681" href="CancelScan.php">CANCEL SCAN</a></li>
            </ul>

          </li>

          <li style="background: #254681" class="nav-link"><a href="#">PRE PRODUCTION</a>
            <ul style="background: #254681">

              <li style="background: #254681"><a target="_blank" style="background: #254681" href="pre_production_meeting.php">PPM SCHEDULE</a></li>

              <!-- <li style="background: #254681"><a target="_blank" style="background: #254681" href="pre_production_meeting_running.php">PRE PRODUCTION MEETING</a></li> -->

              <li style="background: #254681"><a style="background: #254681" href="temp_plan_production.php">PLAN PRODUCTION</a></li>
              <li style="background: #254681"><a style="background: #254681" href="temp_preparation_production.php">PRE PRODUCTION</a></li>
              <li style="background: #254681"><a style="background: #254681" href="master_target_harian.php">INPUT TARGET</a></li>

              <li style="background: #254681"><a style="background: #254681" href="output_line_target.php">OUTPUT LINE TARGET</a></li>
            </ul>
          </li>

          <li style="background: #254681" class="nav-link"><a href="#">PART CUTTING</a>
            <ul style="background: #254681">
              <li style="background: #254681"><a style="background: #254681" href="temp_part_cutting2.php">OUTPUT OK</a></li>
              <li style="background: #254681"><a style="background: #254681" href="temp_part_cutting_reject.php">REJECT</a></li>
            </ul>
          </li>

          <li style="background: #254681" class="nav-link"><a style="background: #254681" href="#">TRANSAKSI BUNDLE</a>
            <ul style="background: #254681">
              <li style="background: #254681"><a style="background: #254681" href="temp_cutting.php">CUTTING</a></li>
              <!-- <li><a href="temp_qc_cutpart.php">QC CUTPART</a></li> -->
              <!-- <li><a href="temp_press.php">PRESS</a></li> -->
              <li><a href="temp_press.php">PRESS</a></li>
              <!-- <li><a href="temp_press.php">PAD PRINT</a></li> -->
              <li><a href="temp_moulding.php">MOULDING</a></li>
              <li><a href="temp_bemis.php">BEMIS</a></li>
              <!-- <li><a href="temp_bemis.php">FUSE</a></li> -->
              <!-- <li><a href="temp_preparation.php">PREPARATION</a></li> -->
              <li><a href="temp_preparation.php">JUWITA</a></li>
              <li><a href="temp_ht.php">HT</a></li>
              <li style="background: #254681"><a style="background: #254681" href="temp_trimstore.php">TRIMSTORE</a></li>
              <li style="background: #254681"><a style="background: #254681" href="temp_sewing.php">IN SEWING</a></li>
              <li style="background: #254681"><a style="background: #254681" href="temp_bbl.php">BBL</a></li>
              <li style="background: #254681"><a style="background: #254681" href="temp_qc_endline.php">QC ENDLINE</a></li>
              <li><a href="temp_qc_kensa.php">QC KENSA</a></li>
              <!-- <li><a href="temp_ht2.php">HT AFTER SEWING</a></li> -->
              <!-- <li style="background: #254681"><a style="background: #254681" href="temp_washing.php">WASHING</a></li> -->
              <li style="background: #254681"><a style="background: #254681" href="temp_washing.php">F QC</a></li>
              <li style="background: #254681"><a style="background: #254681" href="temp_iron.php">IRON</a></li>
              <!-- <li style="background: #254681"><a style="background: #254681" href="temp_qc_buyer.php">QC BUYER</a></li> -->
              <li style="background: #254681"><a style="background: #254681" href="temp_qc_buyer.php">FURUSHIMA</a></li>
              <li style="background: #254681"><a style="background: #254681" href="temp_qc_transfer.php">QC TRANSFER</a></li>
              <li style="background: #254681"><a style="background: #254681" href="temp_tatami.php">TATAMI OUT</a></li>
              <li style="background: #254681"><a style="background: #254681" href="temp_packing_bundle.php">PACKING</a></li>
            </ul>
          </li>

          <li style="background: #254681" class="nav-link"><a style="background: #254681" href="#">TRANSAKSI</a>
            <ul style="background: #254681">
              <!-- <li><a href="temp_qc_kensa.php">QC KENSA</a></li> -->
              <!-- <li><a href="temp_tatami_in.php">TATAMI</a></li> -->
              <li style="background: #254681"><a style="background: #254681" href="temp_kenzin.php">NEEDLE DETECTOR</a></li>
              <li style="background: #254681"><a style="background: #254681" href="temp_packing.php">PACKING</a></li>
              <li style="background: #254681"><a style="background: #254681" href="#">REJECT</a>
              <li style="background: #254681"><a style="background: #254681" href="temp_carton.php">SCAN KARTON FULL</a>
                <ul>
                  <!-- <li><a href="temp_reject_tatami.php">TATAMI REJECT</a></li> -->
                </ul>
              </li>
            </ul>
          </li>

          <li style="background: #254681" class="nav-link"><a style="background: #254681" href="#">SHIPMENT</a>
            <ul style="background: #254681">
              <li style="background: #254681"><a style="background: #254681" href="master-shipment.php">CREATE PACKINGLIST</a></li>
              <li style="background: #254681"><a style="background: #254681" href="transaksi_shipment_all7.php">KIRIM SHIPMENT</a></li>
              <li style="background: #254681"><a style="background: #254681" href="transaksi_shipment_to_packing4.php">KEMBALI KE PACKING</a></li>
              <li style="background: #254681"><a style="background: #254681" href="transaksi_shipment_all_bundle.php">PRINT BARCODE CARTON</a></li>
              <li style="background: #254681"><a style="background: #254681" href="transaksi_reset_scan_barcode_buyer.php">RESET SCAN</a></li>
            </ul>
          </li>
          <li style="background: #254681" class="nav-link"><a style="background: #254681" href="#">LAPORAN &nbsp&nbsp&nbsp&nbsp |</a>

            <ul style="background: #254681">
              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_part_cutting.php">PART CUTTING</a></li>
              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_balance_order_barcode_buyer.php">BAL ORDER </a></li>
              <li style="background: #254681"><a style="background: #254681" href="#">HASIL SCAN</a>
                <ul style="background: #254681">
                  <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_scan_global.php">GLOBAL SIZE</a></li>
                  <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_scan_periode.php">GLOBAL PER PERIODE</a></li>
                  <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_scan_global_perjam.php">GLOBAL PERJAM</a></li>
                  <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_scan_global_perjam_qc_endline.php">ENDLINE PERJAM</a></li>
                  <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_scan_size_detail.php">DETAIL SIZE</a></li>
                  <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_scan_global_allproses.php">ALL PROSES</a></li>
                  <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_scan_global_sewing.php">SEWING LANTAI</a></li>
                  <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_reminder_target_qc_endline.php">REMINDER TARGET</a></li>
                  <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_summary_produksi.php">Summary Production</a></li>
                </ul>
              </li>
              <li style="background: #254681"><a style="background: #254681" href="#">REPORT TV</a>
                <ul style="background: #254681">
                  <li style="background: #254681"><a style="background: #254681" href="tampilkan_qcendline_Monitoring_all_line.php" target="_blank">QC Endline All Line</a></li>

                  <li style="background: #254681"><a style="background: #254681" href="tamplikan_trimstore_monitoring.php" target="_blank">Trimstore Output Monitoring</a></li>


                  <li style="background: #254681"><a style="background: #254681" href="tv_laporan_hasil_scan_global.php">GLOBAL SIZE</a></li>
                  <li style="background: #254681"><a style="background: #254681" href="tv_laporan_hasil_scan_global_sewing2.php">SEWING PROD</a></li>
                  <li style="background: #254681"><a style="background: #254681" href="tv_laporan_preparation_production.php">REPORT TV</a></li>
                  <li style="background: #254681"><a style="background: #254681" href="reminder_qc_endline_target.php?lantai=1">REMINDER TARGET LT.1</a></li>
                  <li style="background: #254681"><a style="background: #254681" href="tampilkan_monitoring_all_proses.php" target="_blank">PRODUCTION MONITORING</a></li>
                  <li style="background: #254681"><a style="background: #254681" href="tampilkan_monitoring_qcendline.php" target="_blank">CHART QC ENDLINE ALL LINE</a></li>
                  <li style="background: #254681"><a style="background: #254681" href="tampilkan_monitoring_cutting.php" target="_blank">CHART CUTTING</a></li>
                  <li style="background: #254681"><a style="background: #254681" href="tampilkan_monitoring_trimstore.php" target="_blank">CHART TRIMSTORE</a></li>
                  <li style="background: #254681"><a style="background: #254681" href="tampilkan_monitoring_packing.php" target="_blank">CHART PACKING</a></li>
                </ul>
              </li>
              <li style="background: #254681"><a style="background: #254681" href="#">PREPARATION PRODUCTION</a>
                <ul style="background: #254681">
                  <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_preparation_production.php">REPORT FULL</a></li>

                </ul>
              </li>
              <li><a href="cetak_laporan_hasil_qc_kensa.php">QC KENSA</a></li>
              <!-- <li><a href="cetak_laporan_hasil_tatami_buyer.php">TATAMI</a></li> -->

              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_kenzin_buyer.php">NEEDLE DETECTOR</a></li>
              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_packing_buyer.php">PACKING OUTER</a>
                <ul style="background: #254681">
                  <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_packing_buyer.php">REPORT HARIAN</a></li>
                  <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_stok_packing_barcode_buyer.php">KARTON</a></li>
                </ul>
              </li>
              <li style="background: #254681"><a style="background: #254681" href="cetak_grafik_batang_all_line.php">GRAFIK</a>
                <ul style="background: #254681">
                  <li style="background: #254681"><a style="background: #254681" href="cetak_grafik_batang_all_line.php">ALL LINE</a></li>
                  <li style="background: #254681"><a style="background: #254681" href="cetak_grafik_batang_line.php">LINE</a></li>
                </ul>
              </li>
              <li style="background: #254681">
                <a style="background: #254681" href="cetak_wip.php" target="_blank">WIP</a>
              </li>


            </ul>
          </li>
          <li style="float:right; background:#254681;"><a style="background: #254681" href="logout.php">LOG OUT</a></li>
        <?php } else if (cek_status($_SESSION['username']) == 'report') { ?>
          <li style="background: #254681"><a style="background: #254681" target="_blank" href="cetak_laporan_hasil_scan_global.php">REPORT SCAN BUNDLE</a>
            <ul style="background: #254681">
              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_scan_global.php">GLOBAL SIZE</a></li>
              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_scan_global_perjam.php">GLOBAL PERJAM</a></li>
              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_scan_size_detail.php">DETAIL SIZE</a></li>
              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_scan_global_allproses.php">ALL PROSES</a></li>
              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_scan_global_sewing.php">SEWING LANTAI</a></li>
            </ul>
          </li>
          <li style="background: #254681"><a style="background: #254681" href="#">REPORT PACKING OUTER</a>
            <ul style="background: #254681">
              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_balance_order_barcode_buyer.php">BAL ORDER</a></li>
              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_packing_buyer.php">PACKING OUTER</a>
                <ul style="background: #254681">
                  <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_packing_buyer.php">REPORT HARIAN</a></li>
                  <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_stok_packing_barcode_buyer.php">KARTON</a></li>
                </ul>
              </li>
              <li style="background: #254681"><a style="background: #254681" href="master-shipment.php">LIST PACKINGLIST</a></li>

            </ul>

          </li>
          
          <li style="background: #254681"><a target="_blank" style="background: #254681" href="pre_production_meeting_running.php">JOIN PPM</a></li>

          <li style="float:right; background:#254681;"><a href="logout.php">LOG OUT</a></li>
        <?php } else if (cek_status($_SESSION['username']) == 'packing_outerware' or cek_status($_SESSION['username']) == 'kenzin') {  ?>
          <li style="background: #254681"><a style="background: #254681" href="#">DATA MASTER</a>
            <ul style="background: #254681">
              <li style="background: #254681"><a style="background: #254681" href="master-order.php">MASTER ORDER</a></li>
              <li style="background: #254681"><a style="background: #254681" href="master_barang2.php">MASTER BARANG</a></li>
              <li style="background: #254681"><a style="background: #254681" href="master-style.php">MASTER STYLE</a></li>
              <li style="background: #254681"><a style="background: #254681" href="master_karton.php">MASTER QTY CTN</a></li>
            </ul>
          </li>

          <li style="background: #254681"><a target="_blank" style="background: #254681" href="pre_production_meeting_running.php">JOIN PPM</a></li>

          <li style="background: #254681"><a style="background: #254681" href="#">TRANSAKSI</a>
            <ul style="background: #254681">

              <li style="background: #254681"><a style="background: #254681" href="temp_kenzin.php">NEEDLE DETECTOR</a></li>
              <li style="background: #254681"><a style="background: #254681" href="temp_packing.php">PACKING</a></li>

            </ul>
          </li>
          <li style="background: #254681"><a style="background: #254681" href="#">SHIPMENT</a>
            <ul style="background: #254681">
              <li style="background: #254681"><a style="background: #254681" href="master-shipment.php">CREATE PACKINGLIST</a></li>
              <li style="background: #254681"><a style="background: #254681" href="transaksi_shipment_all7.php">KIRIM SHIPMENT</a></li>
              <li style="background: #254681"><a style="background: #254681" href="transaksi_shipment_to_packing4.php">KEMBALI KE PACKING</a></li>
            </ul>
          </li>
          <li style="background: #254681"><a style="background: #254681" target="_blank" href="cetak_laporan_hasil_scan_global.php">REPORT SCAN</a>
            <ul style="background: #254681">
              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_balance_order_barcode_buyer.php">BAL ORDER</a></li>
              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_kenzin_buyer.php">NEEDLE DETECTOR</a></li>
              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_packing_buyer.php">PACKING OUTER</a>
                <ul style="background: #254681">
                  <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_packing_buyer.php">REPORT HARIAN</a></li>
                  <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_stok_packing_barcode_buyer.php">KARTON</a></li>
                </ul>
              </li>

            </ul>
          </li>
          <li style="float:right; background:#254681;"><a href="logout.php">LOG OUT</a></li>
        <?php } else if(cek_status($_SESSION['username']) == 'qc_endline') { ?>
          <li style="background: #254681"><a style="background: #254681" target="_blank" href="cetak_laporan_hasil_scan_global.php">REPORT SCAN BUNDLE</a>
            <ul style="background: #254681">

              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_scan_global.php">GLOBAL SIZE</a></li>
              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_scan_global_perjam.php">GLOBAL PERJAM</a></li>
              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_scan_size_detail.php">DETAIL SIZE</a></li>
              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_scan_global_allproses.php">ALL PROSES</a></li>
              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_scan_global_perjam_qc_endline.php">ENDLINE PERJAM</a></li>
              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_reminder_target_qc_endline.php">REMINDER TARGET</a></li>

            </ul>
          </li>          
          <li style="background: #254681">
            <a style="background: #254681" target="_blank" href="input_target_line.php">
              INPUT TARGET LINE
            </a>
          </li>

          <li style="background: #254681"><a target="_blank" style="background: #254681" href="pre_production_meeting_running.php">JOIN PPM</a></li>

          <li style="background: #254681"><a style="background: #254681" target="_blank" href="tamplikan_sewing_monitoring.php">TAMPILKAN MONITOR OUTPUT SEWING  </a></li>
          <li style="float:right; background:#254681;"><a href="logout.php">LOG OUT</a></li>
        <?php } else if(cek_status($_SESSION['username']) == 'tatami') { ?>
          <li class="nav-link" style="background: #254681"><a href="#">DATA MASTER</a>
            <ul>
              <li style="background: #254681"><a style="background: #254681" href="master_karton_full.php">MASTER KARTON FULL</a></li>
            </ul>
          </li>

          <li style="background: #254681"><a target="_blank" style="background: #254681" href="pre_production_meeting_running.php">JOIN PPM</a></li>

          <li style="background: #254681" class="nav-link"><a style="background: #254681" href="#">TRANSAKSI</a>
            <ul style="background: #254681">
              <li><a href="temp_qc_kensa.php">QC KENSA</a></li>
              <!-- <li><a href="temp_tatami_in.php">TATAMI</a></li> -->
              <li style="background: #254681"><a style="background: #254681" href="#">SCAN KARTON FULL</a>
                <ul>
                  <!-- <li><a href="temp_reject_tatami.php">TATAMI REJECT</a></li> -->
                </ul>
              </li>
            </ul>
          </li>                    
          <li style="background: #254681"><a style="background: #254681" target="_blank" href="cetak_laporan_hasil_scan_global.php">REPORT SCAN BUNDLE</a>
            <ul style="background: #254681">

              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_scan_global.php">GLOBAL SIZE</a></li>
              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_scan_global_perjam.php">GLOBAL PERJAM</a></li>
              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_scan_size_detail.php">DETAIL SIZE</a></li>
              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_scan_global_allproses.php">ALL PROSES</a></li>
              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_scan_global_perjam_qc_endline.php">ENDLINE PERJAM</a></li>
              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_reminder_target_qc_endline.php">REMINDER TARGET</a></li>

            </ul>
          </li>          
          <li style="background: #254681"><a style="background: #254681" target="_blank" href="tampilkan_tatami_monitoring.php">TAMPILKAN MONITOR PACKING  </a></li>
          <li style="float:right; background:#254681;"><a href="logout.php">LOG OUT</a></li>
        <?php } else { ?>
          <!-- <li class="nav-link" style="background: #254681"><a href="#">DATA MASTER</a>
            <ul>
              <li style="background: #254681"><a style="background: #254681" href="master_karton_full.php">MASTER KARTON FULL</a></li>
            </ul>
          </li> -->
          <!-- <li style="background: #254681" class="nav-link"><a style="background: #254681" href="#">TRANSAKSI</a>
            <ul style="background: #254681">
              <li><a href="temp_qc_kensa.php">QC KENSA</a></li>
              <li><a href="temp_tatami_in.php">TATAMI</a></li>
              <li style="background: #254681"><a style="background: #254681" href="#">SCAN KARTON FULL</a>
                <ul>
                  <li><a href="temp_reject_tatami.php">TATAMI REJECT</a></li>
                </ul>
              </li>
            </ul>
          </li>-->

          <li style="background: #254681"><a style="background: #254681" target="_blank" href="cetak_laporan_hasil_scan_global.php">REPORT SCAN BUNDLE</a>
            <ul style="background: #254681">

              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_scan_global.php">GLOBAL SIZE</a></li>
              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_scan_global_perjam.php">GLOBAL PERJAM</a></li>
              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_scan_size_detail.php">DETAIL SIZE</a></li>
              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_scan_global_allproses.php">ALL PROSES</a></li>
              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_hasil_scan_global_perjam_qc_endline.php">ENDLINE PERJAM</a></li>
              <li style="background: #254681"><a style="background: #254681" href="cetak_laporan_reminder_target_qc_endline.php">REMINDER TARGET</a></li>

            </ul>
          </li>

          <li style="background: #254681"><a target="_blank" style="background: #254681" href="pre_production_meeting_running.php">JOIN PPM</a></li>

          <li style="float:right; background:#254681 ;"><a href="logout.php">LOG OUT</a></li>
        <?php }} ?>
      <!-- <//?php } else { ?>
        <li style="float:right; background:#254681 ;"><a href="index.php">LOG IN</a></li>
      <//?php } ?> -->

  </nav>

  <div class="container">