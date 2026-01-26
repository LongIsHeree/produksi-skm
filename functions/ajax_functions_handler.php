<?php
require_once 'db.php';

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
   if (isset($_GET['action'])) {
       $action = $_GET['action'];
      //  var_dump($action);
       switch($action){
         case "tampilkanPackingKartonFull":
            tampilkan_packing_karton_full();
            break;
         case "getDetailDataMasterOrderByOrc":
            if(isset($_GET['param'])){
               $orc = $_GET['param'];
               get_detail_data_master_order_by_orc($orc);
               break;
            }
         case 'cariPackingKartonFullById':
            if(isset($_GET['param'])){
               $idPacking = $_GET['param'];
               cari_packing_karton_full_by_id($idPacking);
               break;
            }
         case 'ajax_getCustomers':
            getCustomers();
            break;
         case 'ajax_getLines':
            getLines();
            break;
         case 'ajax_getAllProductionSummary':
            if(isset($_GET['param'])){
               $param = $_GET['param'];
               $arrParam = json_decode($param);
            }
            getAllProductionSummary($arrParam);
            break;
         case 'ajax_getAllQcEndlineOutputToday':
            getAllQcEndlineOutputToday();
            break;
         case 'ajax_getAllQcEndlineOutputYesterday':
            getAllQcEndlineOutputYesterday();
            break;
         case 'ajax_getQCEndlinePerLineYesterday':
            if(isset($_GET['param'])){
               $param = $_GET['param'];
               $line = $param['line'];
               getQCEndlinePerLineYesterday($line);
               break;
            }
         case 'ajax_getQCEndlineTarget':
            if(isset($_GET['param'])){
               $param = $_GET['param'];
               $line = $param['line'];
               getQCEndlineTarget($line);
               break;
            }
         case 'ajax_getAllQCEndlineTarget':
            getAllQCEndlineTarget();
            break;

         case 'ajax_getQCEndlineTodayTarget':
            getQCEndlineTodayTarget();
            break;
         case 'ajax_getAllLevel':
            getAllLevel();
            break;
         case 'ajax_getMemberByIdDepartment':
            if(isset($_GET['param'])){
               $param = $_GET['param'];
               $idDepartment = $param['id'];
               getMemberByIdDepartment($idDepartment);
               break;
            }
         case 'ajax_getStylePreProduction':
            getStylePreProduction();
            break;
         case 'ajax_getQtyPreProdByStyle':
            if(isset($_GET['param'])){
               $param = $_GET['param'];
               $idStyle = $param['idStyle'];
               getQtyPreProdByStyle($idStyle);
               break;
            }
         case 'ajax_getScheduleMeeting':
            getScheduleMeeting();
            break;
         case 'ajax_getMeetingSchedules':
            getMeetingSchedules();
            break;
         case 'ajax_cekDiundangMeeting':
            if(isset($_GET['param'])){
               $p = $_GET['param'];
               $idSchedule = $p['idSchedule'];
               $level = $p['level'];
               cekDiundangMeeting($idSchedule, $level);
               break;
            }
         case 'ajax_getPPMResult':
            if(isset($_GET['param'])){
               $p = $_GET['param'];
               $id = $p['id'];
               getPPMResult($id);
               break;
            }
         case 'ajax_getPPMDaftarHadir':
            if(isset($_GET['param'])){
               $p = $_GET['param'];
               $id = $p['id'];
               getPPMDaftarHadir($id);
               break;               
            }
         case 'ajax_getPreProductionSizeByORC':
            if(isset($_GET['param'])){
               $p = $_GET['param'];
               $orc = $p['orc'];
               getPreProductionSizeByORC($orc);
               break;               
            }
         case 'ajax_getTrimstoreOutputToday':
              getTrimstoreOutputToday();
              break;
         case 'ajax_getTrimstoreOutputTotal':
              getTrimstoreOutputTotal();
              break;
         case 'ajax_getTrimstoreQtySize':
            getTrimstoreQtySize();
            break;
         case 'ajax_getSewingQtySize':
            getSewingQtySize();
            break;
         case 'ajax_getQcEndlineQtySize':
            getQcEndlineQtySize();
            break;
         case 'ajax_getPackingQtySize':
            getPackingQtySize();
            break;
         case 'ajax_getOrderQtySize':
            getOrderQtySize();
            break;
         case 'ajax_getCuttingQtySize':
            getCuttingQtySize();
            break;
         case 'ajax_getBemisQtySize':
            getBemisQtySize();
            break;
         case 'ajax_getJuwitaQtySize':
            getJuwitaQtySize();
            break;
         case 'ajax_getPressQtySize':
            getPressQtySize();
            break;
         case 'ajax_getHTQtySize':
            getHTQtySize();
            break;
         case 'ajax_getProses':
            getProses();
            break;
       }
      //  }
   } else if(isset($_POST['action'])){
      $action = $_POST['action'];
      switch($action){
         case "simpanPackingKartoFull":
            if(isset($_POST['param'])){
               $param = $_POST['param'];
               simpan_packing_karton_full($param);
               break;
            }
         case "simpanDetailPackingKartoFull":
            if(isset($_POST['param'])){
               $param = $_POST['param'];
               simpan_detail_packing_karton_full($param);
               break;
            }
         case "ajax_postTargetOuputLine":
            if(isset($_POST['param'])){
               $param = $_POST['param'];
               $dataTarget = $param['dataTarget'];
               simpanTargetOutputLine($dataTarget);
               break;
            }
         case "ajax_updateTargetOutputLine":
            if(isset($_POST['param'])){
               $param = $_POST['param'];
               $dataTarget = $param['dataTarget'];
               updateTargetOutputLine($dataTarget);
               break;
            }
         case "ajax_PostDepartment":
            if(isset($_POST['param'])){
               $param = $_POST['param'];
               $dataDepartment = $param['dataDepartment'];
               simpanDepartemen($dataDepartment);
               break;
            }
         case 'ajax_UpdateDepartment':
            if(isset($_POST['param'])){
               $param = $_POST['param'];
               $dataDepartemen = $param['dataDepartemen'];
               updateDepartment($dataDepartemen);
               break;
            }
         case 'ajax_PostMemberDepartment':
            if(isset($_POST['param'])){
               $param = $_POST['param'];
               $dataMember = $param['dataMember'];
               simpanMemberDepartment($dataMember);
               break;
            }
         case 'ajax_UpdateMemberDepartment':
            if(isset($_POST['param'])){
               $param = $_POST['param'];
               $dMember = $param['dataMember'];
               updateMemberDepartment($dMember);
               break;
            }
         case 'ajax_postPreProductionMeetingSchedule':
            if(isset($_POST['param'])){
               $param = $_POST['param'];
               $dataPreProdSchedule = $param['dataPreProdSchedule'];
               postPreProdSchedule($dataPreProdSchedule);               
               break;
            }
         case 'ajax_updatePPMSchedule':
            if(isset($_POST['param'])){
               $param = $_POST['param'];
               $dataPPMSchedule = $param['dataPPMSchedule'];
               updatePPMSchedule($dataPPMSchedule);               
               break;
            }            
         case 'ajax_postPPMResult':
            if(isset($_POST['param'])){
               $p = $_POST['param'];
               $content = $p['content'];
               postPPMResult($content);
               break;
            }
         case 'ajax_postStartPPM':
            if(isset($_POST['param'])){
               $p = $_POST['param'];
               $idMeeting = $p['idMeeting'];
               postStartPPM($idMeeting);
               break;
            }
         case 'ajax_postJoiningPPM':
            if(isset($_POST['param'])){
               $p = $_POST['param'];
               $dataMeeting = $p['dataMeeting'];
               postJoiningPPM($dataMeeting);
               break;
            }
            case 'ajax_postFinishPPM':
               if(isset($_POST['param'])){
                  $p = $_POST['param'];
                  $id = $p['id'];
                  postFinishPPM($id);
                  break;
               }
            case 'ajax_postUpdatePPMStatusClient':
               if(isset($_POST['param'])){
                  $p = $_POST['param'];
                  $dm = $p['dataMeeting'];
                  postUpdatePPMStatusClient($dm);
                  break;
               }
            case 'ajax_postPPMUpdateNotes':
               if(isset($_POST['param'])){
                  $p = $_POST['param'];
                  $ctn = $p['content'];
                  postPPMUpdateNotes($ctn);
                  break;
               }

      }
   }else{
       echo json_encode(array('error' => 'Aksi tidak valid')); // Mengembalikan error
      
   }
} else {
   header("HTTP/1.0 403 Forbidden"); // Menolak permintaan bukan AJAX
   die();
}

function tampilkan_packing_karton_full(){
   global $koneksi;
   $query = "SELECT DISTINCT id, no_po, orc, style, color, qty_order, costomer, size, cup,qty, 
             kapasitas_karton,total_karton,qrcode_char from view_packing_karton_full GROUP BY id";
   $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
 
   $data = [];
   while($row =  mysqli_fetch_assoc($result)){
     $dtArr = [
      'id' => $row['id'],
      'no_po' => $row['no_po'],
      'orc' => $row['orc'],
      'style' => $row['style'],
      'color' => $row['color'],
      'qty_order' => $row['qty_order'],
      'costomer' => $row['costomer']
     ];
     array_push($data, $dtArr);
   }
   $retVal = json_encode($data);
   echo $retVal;

}

function cari_packing_karton_full_by_id($idPacking){
   global $koneksi;
   $query = "SELECT * FROM view_packing_karton_full WHERE id='$idPacking'";
   $response = mysqli_query($koneksi, $query);

   $data = [];
   while($row = mysqli_fetch_assoc($response)){
      $dtArr = [
         'orc' => $row['orc'],
         'style' => $row['style'],
         'color' => $row['color'],
         'size' => $row['size'],
         'cup' => $row['cup'],
         'qty' => $row['qty'],
         'kapasitas_karton' => $row['kapasitas_karton'],
         'total_karton' => $row['total_karton'],
         'no_urut' => $row['no_urut'],
         'qrcode_char' => $row['qrcode_char']
      ];
      array_push($data, $dtArr);
   }
   
   $retVal = json_encode($data);
   echo $retVal;
}

function tampilkan_packing_karton_Full_QRCODE($idPacking){
   global $koneksi;
   $query = "SELECT * FROM view_packing_karton_full WHERE id='$idPacking'";
   $response = mysqli_query($koneksi, $query);

   $data = [];
   while($row = mysqli_fetch_assoc($response)){
      $dtArr = [
         'orc' => $row['orc'],
         'style' => $row['style'],
         'color' => $row['color'],
         'size' => $row['size'],
         'cup' => $row['cup'],
         'qty' => $row['qty'],
         'kapasitas_karton' => $row['kapasitas_karton'],
         'total_karton' => $row['total_karton'],
         'no_urut' => $row['no_urut'],
         'qrcode_char' => $row['qrcode_char']
      ];
      array_push($data, $dtArr);
   }
   $retVal = json_encode($data);
   echo $retVal;

}

function get_detail_data_master_order_by_orc($orc){
   global $koneksi;
   
   $dataOrder = [];
   $queryCari = "SELECT COUNT(*) AS hitung FROM view_packing_karton_full WHERE orc='$orc'";
   $responseCari = mysqli_query($koneksi, $queryCari);
   $hasilCari = mysqli_fetch_assoc($responseCari);
   if((int)$hasilCari['hitung'] > 0){
      array_push($dataOrder, ["data" => "invalid"]);
      $jsonDataOrder = json_encode($dataOrder);
      echo $jsonDataOrder;
   }else{
      $queryOrder = "SELECT * FROM view_master_order_detail WHERE orc='$orc' AND status='open'";
      $responseOrder = mysqli_query($koneksi, $queryOrder) or die('gagal menampilkan data');
      if($responseOrder){
         while($rowOrder = mysqli_fetch_assoc($responseOrder)){
            $data = [
               'no_po' => $rowOrder['no_po'],
               'orc' => $rowOrder['orc'],
               'style' => $rowOrder['style'],
               'color' => $rowOrder['color'],
               'qty_order' => $rowOrder['qty_order'],
               'id_order_detail' => $rowOrder['id_order_detail'],
               'id_order' => $rowOrder['id_order'],
               'id_costomer' => $rowOrder['id_costomer'],
               'size' => $rowOrder['size'],
               'cup' => $rowOrder['cup'],
               'qty' => $rowOrder['qty_order_size'],            
            ];
            array_push($dataOrder, $data);
         }
      }
      array_push($dataOrder, ["data" => "valid"]);
      $jsonDataOrder = json_encode($dataOrder);
      echo $jsonDataOrder;

   }
}

function simpan_packing_karton_full($p){
   global $koneksi;

   $id_order = $p['id_order'];
   $id_costomer = $p['id_costomer'];
   $orc = $p['orc'];
   $style = $p['style'];
   $color = $p['color'];

   $query = "INSERT INTO packing_karton_full(id_order, id_costomer, orc, style, color) 
            VALUES('$id_order', '$id_costomer', '$orc', '$style', '$color')";
   $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

   $insertedID = mysqli_insert_id($koneksi);
  // return $result;
  echo $insertedID;
   
}

function simpan_detail_packing_karton_full($payload){
   global $koneksi;

   $idPacking = $payload[0]['id_packing_karton_full'];
   $query1 = "SELECT * FROM packing_karton_full WHERE id='$idPacking'";
   $response1 = mysqli_query($koneksi, $query1);
   $resultPacking = mysqli_fetch_assoc($response1);

   // $nourut = 1;
   // $dataArray = [];
   for($x = 0; $x < count($payload); $x++){
      $idPacking = $payload[$x]['id_packing_karton_full'];
      $size = $payload[$x]['size'];
      $cup = $payload[$x]['cup'];
      $qty = $payload[$x]['qty'];
      $kapasitasKarton = $payload[$x]['kapasitas_karton'];
      $totalKarton = $payload[$x]['total_karton'];
      $barcode = $resultPacking['orc'] .";". $payload[$x]['size'];
      $qrCode = 'orc: '.$resultPacking['orc'].'; style: '.$resultPacking['style'].'; color: '.$resultPacking['color'].'; size: '.
                           $payload[$x]['size'].'; cup: '.$payload[$x]['cup'].'; qty: '.$payload[$x]['qty'].
                           '; kapasitas_karton: '.$payload[$x]['kapasitas_karton'].'; total_karton: '. $payload[$x]['total_karton'];
                           
      $query2 = "INSERT INTO packing_karton_full_detail(id_packing_karton_full, size, cup, qty, kapasitas_karton, total_karton,
                  barcode_char, qrcode_char)VALUES('$idPacking', '$size', '$cup', '$qty', '$kapasitasKarton',
                  '$totalKarton', '$barcode', '$qrCode')";

      $response2 = mysqli_query($koneksi, $query2);

   }

   // var_dump($dataArray);
   echo true;
   
   // for($x = 0; $x < count($p); $x++){

   // }
}

function getCustomers(){
   global $koneksi;

   $query = "SELECT id_costomer,costomer FROM costomer";
   $responseCust = mysqli_query($koneksi, $query) or die('Gagal menampilkan data!');
   $dataCustomer = [];
   while($row =  mysqli_fetch_assoc($responseCust)){
     $dtArr = [
      'id' => $row['id_costomer'],
      'costomer' => $row['costomer']
     ];
     array_push($dataCustomer, $dtArr);
   }   
   $jsonCust = json_encode($dataCustomer);
   echo $jsonCust;
}

function getLines(){
   global $koneksi;

   $query = "SELECT id_line,nama_line FROM master_line WHERE `status`= 'aktif' ORDER BY nama_line";
   $responseLine = mysqli_query($koneksi, $query) or die('Gagal menampilkan data!');
   $dataLines = [];
   while($row =  mysqli_fetch_assoc($responseLine)){
     $dtArr = [
      'id_line' => $row['id_line'],
      'nama_line' => $row['nama_line']
     ];
     array_push($dataLines, $dtArr);
   }   
   $jsonLines = json_encode($dataLines);
   echo $jsonLines;
}

function getAllProductionSummary($arrP){
   $proses = $arrP->proses;
   $dtFrom = $arrP->dtFrom;
   $dtTo = $arrP->dtTo;
   $buyer = $arrP->buyer;
   $line = $arrP->line;
   // $orc = $arrP->orc;
   // $style = $arrP->style;
   // $po = $arrP->po;

   global $koneksi;

   $mainQuery = "SELECT `line`, buyer, po, `orc`, style, color, `size`, qty_order, shipment_plan,
               tgl_trimstore, output_trimstore, balance_trimstore,
               tgl_sewing, output_sewing, balance_sewing,
               tgl_qc_endline, output_qc_endline, balance_qc_endline,
               tgl_packing, output_packing, balance_packing
               FROM view_production_summary_all";
               // WHERE (tgl_".$proses. " >= '$dtFrom' AND tgl_".$proses. " <= '$dtTo')";

   if($proses != ''){
      $whereQuery = " WHERE (tgl_".$proses. " >= '$dtFrom' AND tgl_".$proses. " <= '$dtTo')";
   }else{
      $whereQuery = " WHERE (tgl_trimstore >= '$dtFrom' AND tgl_cutting <= '$dtTo') OR (tgl_sewing >= '$dtFrom' AND tgl_sewing <= '$dtTo') OR (tgl_qc_endline >= '$dtFrom' AND tgl_qc_endline <= '$dtTo') OR (tgl_packing >= '$dtFrom' AND tgl_packing <= '$dtTo')";
   }
   $buyerQuery = ($buyer != '' ? " AND buyer = '$buyer' " : '');
   $lineQuery = ($line != '' ? " AND `line` = '$line' " : '');

   // if($proses != ''){
   //    // $whereQuery = " WHERE (tgl_".$proses. " >= '$dtFrom' AND tgl_".$proses. " <= '$dtTo')";
   //    // $buyerQuery = " AND buyer LIKE " . ($buyer != '' ? " '%$buyer%' " : '');
   //    $buyerQuery = ($buyer != '' ? " AND buyer LIKE '%$buyer%' " : '');
   //    // $lineQuery = " AND `line` = '$line'";
   //    // $lineQuery = " AND `line` = " . ($line != '' ? " '$line' " : "");
   // }else{
   //    // $whereQuery = '';
   //    $buyerQuery = ($buyer != '' ? " AND buyer LIKE '%$buyer%' " : "");
   // }
   // // $lineQuery = " AND `line` = " . ($line != '' ? " '$line' " : '');
   // $lineQuery = ($line != '' ? " AND `line` = '$line' " : '');

   // // $orcrQuery = " AND `orc` LIKE '%$orc%'";
   // // $styleQuery = " AND style LIKE '%$style%'";
   // // $poQuery = " AND po LIKE '%$po%'";
   $orderBy = " ORDER BY tgl_trimstore DESC";

   // $query = $mainQuery . ($buyer != '' ? $buyerQuery : '') . ($line != '' ? $lineQuery : '') . ($orc != '' ? $orcrQuery : '') . ($style != '' ? $styleQuery : '') . ($po != '' ? $poQuery : '') . $orderBy;

   // $query = $mainQuery . ($buyer != '' ? $buyerQuery : '') . ($line != '' ? $lineQuery : '') .  $orderBy;

   $query = $mainQuery . $whereQuery . $buyerQuery . $lineQuery;

   $response = mysqli_query($koneksi, $query);
   $data = [];
   while($r = mysqli_fetch_assoc($response)){
      $row = [
         'line' => $r['line'],
         'buyer' => $r['buyer'],
         'po' => $r['po'],
         'orc' => $r['orc'],
         'style' => $r['style'],
         'color' => $r['color'],
         'size' => $r['size'],
         'qty_order' => $r['qty_order'],
         'shipment' => $r['shipment_plan'],

         'tgl_trimstore' => $r['tgl_trimstore'],
         'output_trimstore' => $r['output_trimstore'],
         'balance_trimstore' => $r['balance_trimstore'],

         'tgl_sewing' => $r['tgl_sewing'],
         'output_sewing' => $r['output_sewing'],
         'balance_sewing' => $r['balance_sewing'],

         'tgl_qc_endline' => $r['tgl_qc_endline'],
         'output_qc_endline' => $r['output_qc_endline'],
         'balance_qc_endline' => $r['balance_qc_endline'],

         'tgl_packing' => $r['tgl_packing'],
         'output_packing' => $r['output_packing'],
         'balance_packing' => $r['balance_packing'],
      ];
      array_push($data, $row);
   }
   // var_dump($data);
   $jsonData = json_encode($data);
   echo $jsonData;
}

function getAllQcEndlineOutputToday(){
   global $koneksi;

   // $query = "SELECT qty, `line` FROM transaksi_qc_endline WHERE tanggal=CURDATE()";
   $query = "SELECT qty, `line`, style FROM view_transaksi_qc_endline WHERE tanggal=CURDATE()";
   $response = mysqli_query($koneksi, $query) or die('Gagal menampilkan data!');
   $dataToday = [];
   while($r = mysqli_fetch_assoc($response)){
      $row = [
         'style' => $r['style'],
         'line' => $r['line'],
         'qty' => $r['qty']
      ];
      array_push($dataToday, $row);
   }
   // var_dump($data);
   $jsonDataToday = json_encode($dataToday);
   echo $jsonDataToday;   
}

function getAllQcEndlineOutputYesterday(){
   global $koneksi;

   $query = "SELECT qty, `line` FROM transaksi_qc_endline WHERE DATE(tanggal)=DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
   $response = mysqli_query($koneksi, $query) or die('Gagal menampilkan data!');
   $dataYesterday = [];
   while($r = mysqli_fetch_assoc($response)){
      $row = [
         'line' => $r['line'],
         'qty' => $r['qty']
      ];
      array_push($dataYesterday, $row);
   }
   // var_dump($data);
   $jsonDataYesterday = json_encode($dataYesterday);
   echo $jsonDataYesterday;   
}

function getQCEndlinePerLineYesterday($l){
   global $koneksi;

   // $query = "SELECT qty, `line` FROM transaksi_qc_endline WHERE tanggal=CURDATE()-1 AND `line`= '$l'";
   $query = "SELECT qty, `line` FROM transaksi_qc_endline WHERE DATE(tanggal)=DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND line='$l'";
   $response = mysqli_query($koneksi, $query) or die('Gagal menampilkan data!');
   $dataLineYesterday = [];
   while($r = mysqli_fetch_assoc($response)){
      $row = [
         'line' => $r['line'],
         'qty' => $r['qty']
      ];
      array_push($dataLineYesterday, $row);
   }
   // var_dump($data);
   $jsonDataLineYesterday = json_encode($dataLineYesterday);
   echo $jsonDataLineYesterday;   
}

function getQCEndlineTodayTarget(){
   global $koneksi;

   $query = "SELECT id, tanggal, `line`, `target` FROM daily_target_line WHERE tanggal=CURDATE()";
   $response = mysqli_query($koneksi, $query) or die('Gagal menampilkan data!');
   $result = mysqli_fetch_assoc($response);
   $jsonResult = json_encode($result);

   echo $jsonResult;
}

function getQCEndlineTarget($ln){
   global $koneksi;

   $sql = "SELECT id, tanggal, `line`, `target` FROM daily_target_line WHERE `line` = '$ln' AND tanggal=CURDATE()";
   $responseLineTarget = mysqli_query($koneksi, $sql) or die('Gagal menampilkan data!');
   $resultLineTargetToday = mysqli_fetch_assoc($responseLineTarget);
   $jsonResultLineTargetToday = json_encode($resultLineTargetToday);
   
   echo $jsonResultLineTargetToday;
   // $dataLineTarget = [];
   // while($r = mysqli_fetch_assoc($responseLineTarget)){
   //    $row = [
   //       'id' => $r['id'],
   //       'tanggal' => $r['tanggal'],
   //       'line' => $r['line'],
   //       'target' => $r['target'],
   //    ];
   //    array_push($dataLineTarget, $row);
   // }
   // $jsonResultLineTarget = json_encode($dataLineTarget);

   // echo $jsonResultLineTarget;
}

function getAllQCEndlineTarget(){
   global $koneksi;

   $sql = "SELECT id, tanggal, `line`, `target` FROM daily_target_line ORDER BY id DESC";
   $responseAllLineTarget = mysqli_query($koneksi, $sql) or die('Gagal menampilkan data!');
   $dataAllLineTarget = [];
   while($r = mysqli_fetch_assoc($responseAllLineTarget)){
      $row = [
         'id' => $r['id'],
         'tanggal' => $r['tanggal'],
         'line' => $r['line'],
         'target' => $r['target'],
      ];
      array_push($dataAllLineTarget, $row);
   }
   $jsonResultAllLineTarget = json_encode($dataAllLineTarget);

   echo $jsonResultAllLineTarget;   
}

function simpanTargetOutputLine($dt){
   global $koneksi;

   $tgl = $dt['tanggal'];
   $line = $dt['line'];
   $target = $dt['target'];

   $sql = "INSERT INTO daily_target_line(tanggal, `line`, `target`) VALUES('$tgl', '$line', '$target')";

   mysqli_query($koneksi, $sql) or die('Gagal menampilkan data!');

   $insertedID = mysqli_insert_id($koneksi);

   echo $insertedID;   
}

function updateTargetOutputLine($dt){
   global $koneksi;

   $id = $dt['id'];
   $target = $dt['target'];

   $sql = "UPDATE daily_target_line SET `target`='$target' WHERE id='$id'";
   $response = mysqli_query($koneksi, $sql) or die('Gagal...');

   echo $response;
}

function getAllLevel(){
   global $koneksi;

   $sql = "SELECT id_level, `level` FROM level_user";
   $responseAllLevel = mysqli_query($koneksi, $sql) or die('Gagal menampilkan data!');
   $dataAllLevel = [];
   while($r = mysqli_fetch_assoc($responseAllLevel)){
      $row = [
         'id_level' => $r['id_level'],
         'level' => $r['level'],
      ];
      array_push($dataAllLevel, $row);
   }
   $jsonResultAllLevel = json_encode($dataAllLevel);

   echo $jsonResultAllLevel;   
}

function getMemberByIdDepartment($id){
   global $koneksi;

   $sql = "SELECT id, idDepartemen, Nama FROM departemen_member WHERE idDepartemen='$id'";
   $responseMember = mysqli_query($koneksi, $sql) or die('Gagal menampilkan data!');
   $dataMember = [];
   while($r = mysqli_fetch_assoc($responseMember)){
      $row = [
         'id' => $r['id'],
         'idDepartemen' => $r['idDepartemen'],
         'Nama' => $r['Nama']
      ];
      array_push($dataMember, $row);
   }
   $jsonMember = json_encode($dataMember);

   // var_dump($jsonMember);

   echo $jsonMember;   
}

function simpanDepartemen($dtDepartment){
   global $koneksi;

   $namaDepartemen = $dtDepartment['namaDepartemen'];
   $descDepartemen = $dtDepartment['descDepartemen'];

   $sql = "INSERT INTO master_departemen(namaDepartemen, descDepartemen) VALUES('$namaDepartemen', '$descDepartemen')";
   
   mysqli_query($koneksi, $sql) or die('Gagal menampilkan data!');
   
   $id = mysqli_insert_id($koneksi);

   echo $id;   
}

function updateDepartment($dtDepartemen){
   global $koneksi;

   $id = $dtDepartemen['id'];
   $namaDepartemen = $dtDepartemen['namaDepartemen'];
   $descDepartemen = $dtDepartemen['descDepartemen'];

   $sql = "UPDATE master_departemen SET namaDepartemen='$namaDepartemen', descDepartemen='$descDepartemen' WHERE id='$id'";

   $response = mysqli_query($koneksi, $sql) or die('Gagal...');

   echo $response;
}

function simpanMemberDepartment($dtMember){
   global $koneksi;

   $idDepartemen = $dtMember['idDepartemen'];
   $nama = $dtMember['namaMember'];

   $sql = "INSERT INTO departemen_member(idDepartemen, Nama) VALUES('$idDepartemen', '$nama')";

   mysqli_query($koneksi, $sql) or die('Gagal menampilkan data!');
   
   $id = mysqli_insert_id($koneksi);

   echo $id;    
}

function updateMemberDepartment($member){
   global $koneksi;

   $id = $member['id'];
   $nama = $member['Nama'];
   $sql = "UPDATE departemen_member SET Nama='$nama' WHERE id='$id'";

   $response = mysqli_query($koneksi, $sql) or die('Gagal...');
   echo $response;   
}

function getStylePreProduction(){
   global $koneksi;

   $sql = "SELECT DISTINCT(id_style), style FROM view_order_preproduction";

   $responseStyle = mysqli_query($koneksi, $sql) or die('Gagal menampilkan data!');
   $dataStyle = [];
   while($r = mysqli_fetch_assoc($responseStyle)){
      $row = [
         'id_style' => $r['id_style'],
         'style' => $r['style']
      ];
      array_push($dataStyle, $row);
   }
   $jsonStyle = json_encode($dataStyle);

   // var_dump($jsonMember);

   echo $jsonStyle;   
}

function postPreProdSchedule($dtPreProdSchedule){
   global $koneksi;

   $meeting_date = $dtPreProdSchedule["meeting_date"];
   $place = $dtPreProdSchedule["place"];
   $meeting_style = $dtPreProdSchedule["meeting_style"];
   $dept_attendees = json_encode($dtPreProdSchedule["dept_attendees"]);
   $description = $dtPreProdSchedule["description"];
   $totalQTYOrder = $dtPreProdSchedule["total_qty_order"];

   $sql = "INSERT INTO pre_production_meeting_schedule(meeting_date, place, meeting_style, dept_attendees, `description`, total_qty_order, `status`) VALUES('$meeting_date', '$place', '$meeting_style', '$dept_attendees', '$description', '$totalQTYOrder', 'on hold')";

   mysqli_query($koneksi, $sql) or die('Gagal menampilkan data!');
   
   $id = mysqli_insert_id($koneksi);

   echo $id;   
}

function updatePPMSchedule($dtPPMSchedule){
   global $koneksi;

   $id = $dtPPMSchedule["id"];
   $meeting_date = $dtPPMSchedule["meeting_date"];
   $place = $dtPPMSchedule["place"];
   $meeting_style = $dtPPMSchedule["meeting_style"];
   $dept_attendees = json_encode($dtPPMSchedule["dept_attendees"]);
   $description = $dtPPMSchedule["description"];
   $totalQTYOrder = $dtPPMSchedule["total_qty_order"];
   
   $sql = "UPDATE pre_production_meeting_schedule SET meeting_date='$meeting_date', place='$place', meeting_style='$meeting_style', dept_attendees='$dept_attendees', `description`='$description', total_qty_order='$totalQTYOrder' WHERE id='$id'";

   $response = mysqli_query($koneksi, $sql) or die('Gagal...');

   if($response){
      $sql2 = "SELECT * FROM view_ppm_schedule WHERE id='$id'";
      $resp2 = mysqli_query($koneksi, $sql2) or die('Gagal...') ;
      $rst2 = mysqli_fetch_assoc($resp2);
      $jsonRest2 = json_encode($rst2);

      echo $jsonRest2;

   }

}

function getQtyPreProdByStyle($idS){
   global $koneksi;
   $sql = "SELECT id_style, `orc`, color, qty_order, `size` FROM view_order_preproduction WHERE id_style='$idS' GROUP BY `orc`";

   $responsePP = mysqli_query($koneksi, $sql) or die('Gagal menampilkan data!');
   $dataPP = [];
   while($r = mysqli_fetch_assoc($responsePP)){
      $row = [
         'id_style' => $r['id_style'],
         'orc' => $r['orc'],
         'color' => $r['color'],
         'qty_order' => $r['qty_order'],
         'size' => $r['size']
      ];
      array_push($dataPP, $row);
   }
   $data=[
      'data' => $dataPP
   ];
   $jsonPP = json_encode($data);

   echo $jsonPP;   
}

function getPreProductionSizeByORC($orc){
   global $koneksi;
   $sql = "SELECT `size`, qty_order_size FROM view_order_preproduction WHERE `orc`='$orc'";

   $responseSize = mysqli_query($koneksi, $sql) or die('Gagal menampilkan data!');
   $dataSizes = [];
   while($r = mysqli_fetch_assoc($responseSize)){
      $row = [
         'size' => $r['size'],
         'qty_order_size' => $r['qty_order_size']
      ];
      array_push($dataSizes, $row);
   }
   $jsonSizes = json_encode($dataSizes);

   echo $jsonSizes;   
}

function getScheduleMeeting(){
   global $koneksi;

   // $sql = "SELECT * FROM view_ppm_schedule WHERE DATE(meeting_date)=CURDATE() AND `status`='on progress'";
   $sql = "SELECT * FROM view_ppm_schedule WHERE `status`='on progress'";

   $responseSchedule = mysqli_query($koneksi, $sql) or die('Gagal menampilkan data!');
   $dataSchedule = [];
   while($r = mysqli_fetch_assoc($responseSchedule)){
      $row = [
         'id' => $r['id'],
         'meeting_date' => $r['meeting_date'],
         'place' => $r['place'],
         'meeting_style' => $r['meeting_style'],
         'dept_attendees' => $r['dept_attendees'],
         'description' => $r['description'],
         'total_qty_order' => $r['total_qty_order'],
         'status' => $r['status']
      ];
      array_push($dataSchedule, $row);
   }
   $jsonSchedule = json_encode($dataSchedule);

   // var_dump($jsonMember);

   echo $jsonSchedule;   

}

function getMeetingSchedules(){
   global $koneksi;

   // $sql = "SELECT id, meeting_date, place, meeting_style, style, dept_attendees, `description`, total_qty_order, `status`, dept_attendees FROM view_ppm_schedule WHERE DATE(meeting_date) >= CURDATE() AND DATE(meeting_date) <= DATE_ADD(CURDATE(), INTERVAl 7 DAY)";

   $sql = "SELECT id, meeting_date, place, meeting_style, style, dept_attendees, `description`, total_qty_order, `status`, dept_attendees FROM view_ppm_schedule";

   $respSchedule = mysqli_query($koneksi, $sql) or die('Gagal menampilkan data!');
   $dtSchedule = [];
   while($r = mysqli_fetch_assoc($respSchedule)){
      $row = [
         'id' => $r['id'],
         'meeting_date' => $r['meeting_date'],
         'place' => $r['place'],
         'meeting_style' => $r['meeting_style'],
         'style' => $r['style'],
         'dept_attendees' => $r['dept_attendees'],
         'description' => $r['description'],
         'total_qty_order' => $r['total_qty_order'],
         'status' => $r['status'],
         'dept_attendees' => $r['dept_attendees']
      ];
      array_push($dtSchedule, $row);
   }
   $jsonSchedule = json_encode($dtSchedule);
   
   echo $jsonSchedule;
}

function cekDiundangMeeting($id, $lvl){
   global $koneksi;

   $sql = "SELECT id, meeting_date, place, meeting_style, dept_attendees, `description`, total_qty_order FROM pre_production_meeting_schedule WHERE id='$id'";

   $respDiundang = mysqli_query($koneksi, $sql) or die('Gagal menampilkan data!');

   $rstDiundang = mysqli_fetch_assoc($respDiundang);
   $deptAttendees = json_decode($rstDiundang['dept_attendees']);
   $found = in_array($lvl, $deptAttendees);
   if($found == false){
      $jsonDiundang = json_encode(false);
   }else{
      $jsonDiundang = json_encode($rstDiundang);
   }
   echo $jsonDiundang;   
   

   // if(count($rstDiundang) > 0){
   //    $jsonDiundang = json_encode($rstDiundang);

   // }
   // $jsonSchedule = json_encode($dtSchedule);
   
   // echo $jsonSchedule;   
}

function postPPMResult($ctn){
   global $koneksi;

   $idSchedule = $ctn['id_meeting_schedule'];
   $username = $ctn['user_name'];
   $level = $ctn['level'];
   $effective_date = $ctn['effective_date'];
   $notes = json_encode($ctn['notes']);


   $sql = "INSERT INTO pre_production_meeting(id_meeting_schedule, user_name, `level`, effective_date, notes) VALUES('$idSchedule', '$username', '$level', '$effective_date', '$notes')";

   // var_dump($sql);

   mysqli_query($koneksi, $sql) or die('Gagal menampilkan data!');
   
   $id = mysqli_insert_id($koneksi);

   echo $id;   
}

function postStartPPM($id){
   global $koneksi;

   $sql = "UPDATE pre_production_meeting_schedule SET `status` = 'on progress' WHERE id='$id'";

   $responseUpdate = mysqli_query($koneksi, $sql) or die('Gagal...');
   if($responseUpdate > 0){
      $sql2 = "SELECT * FROM view_ppm_schedule WHERE id='$id'";
      $resp2 = mysqli_query($koneksi, $sql2) or die('Gagal...') ;
      $rst2 = mysqli_fetch_assoc($resp2);
      $jsonRest2 = json_encode($rst2);

      echo $jsonRest2;   
   }
}

function postJoiningPPM($dm){
   global $koneksi;

   $idSchedule = $dm['idSchedule'];
   $userName = $dm['user_name'];
   $level = $dm['level'];
   $start = date('Y-m-d H:i:s',strtotime($dm['start']));
   $status = $dm['status'];

   $sql = "INSERT INTO pre_production_meeting(id_meeting_schedule, user_name, `level`, `start`, `status`) VALUES('$idSchedule', '$userName', '$level', '$start', '$status')";

   mysqli_query($koneksi, $sql) or die('Gagal menampilkan data!');
   
   $id = mysqli_insert_id($koneksi);

   echo $id;   
}

function postFinishPPM($id){
   global $koneksi;

   $sql = "UPDATE pre_production_meeting_schedule SET `status`='finish' WHERE id='$id'";

   $response = mysqli_query($koneksi, $sql) or die('Gagal...');

   echo $response;
}

function postUpdatePPMStatusClient($d){
   global $koneksi;

   $status = $d['status'];
   $end = date('Y-m-d H:i:s', strtotime($d['end']));
   $id = $d['id'];

   $sql = "UPDATE pre_production_meeting SET `status`='$status', `end`='$end' WHERE id_meeting_schedule='$id'";

   $response = mysqli_query($koneksi, $sql) or die('Gagal...');

   echo $id;

}

function postPPMUpdateNotes($ctn){
   global $koneksi;

   $id = $ctn['id'];
   $effective_date = $ctn['effective_date'];
   $notes = json_encode($ctn['notes']);


   $sql = "UPDATE pre_production_meeting SET effective_date='$effective_date', notes='$notes' WHERE id='$id'";
   // var_dump($sql);

   $resp = mysqli_query($koneksi, $sql);
   

   echo $resp;   
}

function getPPMResult($id){
   global $koneksi;

   $sql = "SELECT * FROM view_ppm_result WHERE id='$id'";

   $respPPM = mysqli_query($koneksi, $sql) or die('Gagal menampilkan data!');
   $dtPPM = [];
   while($r = mysqli_fetch_assoc($respPPM)){
      $row = [
         'id' => $r['id'],
         'vendor' => $r['vendor'],
         'style' => $r['style'],
         'meeting_date' => $r['meeting_date'],
         'place' => $r['place'],
         'effective_date' => $r['effective_date'],
         'level' => $r['level'],
         'description' => $r['description'],
         'notes' => $r['notes']
      ];
      array_push($dtPPM, $row);
   }
   $jsonPPMResult = json_encode($dtPPM);
   
   echo $jsonPPMResult;   
}

function getPPMDaftarHadir($id){
   global $koneksi;

   $sql = "SELECT * FROM view_ppm_result WHERE id='$id'";

   $respPPM = mysqli_query($koneksi, $sql) or die('Gagal menampilkan data!');
   $dtDaftarHadir = [];
   while($r = mysqli_fetch_assoc($respPPM)){
      $dateStart = new DateTime($r['start']);
      $dateEnd = new DateTime($r['end']);
      $strStart = $dateStart->format('Y-m-d H:i:s');
      $strEnd = $dateEnd->format('Y-m-d H:i:s');
      $row = [
         'id' => $r['id'],
         'level' => $r['level'],
         'user_name' => $r['user_name'],
         'start_join' => date('d-m-Y H:i:s', strtotime($strStart)),
         'end_join' => date('d-m-Y H:i:s', strtotime($strEnd))
      ];
      array_push($dtDaftarHadir, $row);
   }
   $jsonPPMDaftarHadir = json_encode($dtDaftarHadir);
   
   echo $jsonPPMDaftarHadir;   
}

function getTrimstoreOutputToday(){
   global $koneksi;

   $sql = "SELECT `orc`, qty_order, plan_line, tanggal, SUM(qty) AS total_qty FROM view_transaksi_trimstore WHERE tanggal=CURDATE() GROUP BY orc";

   $respTrimstore = mysqli_query($koneksi, $sql) or die('Gagal menampilkan data!');
   $dtTrimstore = [];
   while($r = mysqli_fetch_assoc($respTrimstore)){
      $row = [
         'orc' => trim($r['orc']),
         'qty_order' => $r['qty_order'],
         'plan_line' => $r['plan_line'],
         'total_qty' => $r['total_qty']
      ];
      array_push($dtTrimstore, $row);
   }
   $jsonTrimstore = json_encode($dtTrimstore);
   
   echo $jsonTrimstore;      
}

function getTrimstoreOutputTotal(){
   global $koneksi;

   $sql = "SELECT orc, qty_order, plan_line, tanggal, SUM(qty) AS total_qty FROM `view_transaksi_trimstore` GROUP BY orc ORDER BY tanggal DESC";

   $respTrimstore = mysqli_query($koneksi, $sql) or die('Gagal menampilkan data!');
   $dtTrimstore = [];
   while($r = mysqli_fetch_assoc($respTrimstore)){
      $row = [
         'orc' => trim($r['orc']),
         'qty_order' => $r['qty_order'],
         'plan_line' => $r['plan_line'],
         'total_qty' => $r['total_qty']
      ];
      array_push($dtTrimstore, $row);
   }
   $jsonTrimstore = json_encode($dtTrimstore);
   
   echo $jsonTrimstore;
}

function getTrimstoreQtySize(){
   global $koneksi;

   $sql = "SELECT * FROM view_trimstore_qty_size";

   $respTrimstoreQtySize = mysqli_query($koneksi, $sql) or die('Gagal menampilkan data!');
   $dtTrimstoreQtySize = [];
   while($r = mysqli_fetch_assoc($respTrimstoreQtySize)){
      $row = [
         'buyer' => $r['buyer'],
         'style' => $r['style'],
         'orc' => trim($r['orc']),
         'size' => $r['size'],
         'qty_size' => $r['qty_size'],
         'sum_qty_trimstore' => $r['sum_qty_trimstore'],
      ];
      array_push($dtTrimstoreQtySize, $row);
   }
   $jsondtTrimstoreQtySize = json_encode($dtTrimstoreQtySize);
   
   echo $jsondtTrimstoreQtySize;   
}

function getSewingQtySize(){
   global $koneksi;

   $sql = "SELECT * FROM view_sewing_qty_size";

   $respSewingQtySize = mysqli_query($koneksi, $sql) or die('Gagal menampilkan data!');
   $dtSewingQtySize = [];
   while($r = mysqli_fetch_assoc($respSewingQtySize)){
      $row = [
         'style' => $r['style'],
         'orc' => trim($r['orc']),
         'size' => $r['size'],
         'qty_size' => $r['qty_size'],
         'sum_qty_sewing' => $r['sum_qty_sewing'],
      ];
      array_push($dtSewingQtySize, $row);
   }
   $jsondtSewingQtySize = json_encode($dtSewingQtySize);
   
   echo $jsondtSewingQtySize;   
}

function getQcEndlineQtySize(){
   global $koneksi;

   $sql = "SELECT * FROM view_qc_endline_qty_size";

   $respQCQtySize = mysqli_query($koneksi, $sql) or die('Gagal menampilkan data!');
   $dtQCQtySize = [];
   while($r = mysqli_fetch_assoc($respQCQtySize)){
      $row = [
         'style' => $r['style'],
         'orc' => trim($r['orc']),
         'size' => $r['size'],
         'qty_size' => $r['qty_size'],
         'sum_qty_qc_endline' => $r['sum_qty_qc_endline'],
      ];
      array_push($dtQCQtySize, $row);
   }
   $jsondtQCQtySize = json_encode($dtQCQtySize);
   
   echo $jsondtQCQtySize;   
}

function getPackingQtySize(){
   global $koneksi;

   $sql = "SELECT * FROM view_tatami_qty_size";

   $respTatamiQtySize = mysqli_query($koneksi, $sql) or die('Gagal menampilkan data!');
   $dtTatamiQtySize = [];
   while($r = mysqli_fetch_assoc($respTatamiQtySize)){
      $row = [
         'style' => $r['style'],
         'orc' => trim($r['orc']),
         'size' => $r['size'],
         'qty_size' => $r['qty_size'],
         'sum_qty_tatami' => $r['sum_qty_tatami'],
      ];
      array_push($dtTatamiQtySize, $row);
   }
   $jsondtTatamiQtySize = json_encode($dtTatamiQtySize);
   
   echo $jsondtTatamiQtySize;   
}

function getOrderQtySize(){
   global $koneksi;

   $sql = "SELECT * FROM view_order_qty_size";

   $respOrderQtySize = mysqli_query($koneksi, $sql) or die('Gagal menampilkan data!');
   $dtOrderQtySize = [];
   while($r = mysqli_fetch_assoc($respOrderQtySize)){
      $row = [
         'buyer' => $r['buyer'],
         'style' => $r['style'],
         'orc' => trim($r['orc']),
         'size' => $r['size'],
         'qty_order' => $r['qty_order'],
         // 'cup' => $r['cup'],
      ];
      array_push($dtOrderQtySize, $row);
   }
   $jsondtOrderQtySize = json_encode($dtOrderQtySize);
   
   echo $jsondtOrderQtySize;   
}

function getCuttingQtySize(){
   global $koneksi;

   $sql = "SELECT * FROM view_cutting_qty_size";

   $respCuttingQtySize = mysqli_query($koneksi, $sql) or die('Gagal menampilkan data!');
   $dtCuttingQtySize = [];
   while($r = mysqli_fetch_assoc($respCuttingQtySize)){
      $row = [
         'style' => $r['style'],
         'orc' => trim($r['orc']),
         'size' => $r['size'],
         'qty_size' => $r['qty_size'],
         // 'cup' => $r['cup'],
         'sum_qty_cutting' => $r['sum_qty_cutting']
      ];
      array_push($dtCuttingQtySize, $row);
   }
   $jsondtCuttingQtySize = json_encode($dtCuttingQtySize);
   
   echo $jsondtCuttingQtySize;   
}

function getBemisQtySize(){
   global $koneksi;

   $sql = "SELECT * FROM view_bemis_qty_size";

   $respBemisQtySize = mysqli_query($koneksi, $sql) or die('Gagal menampilkan data!');
   $dtBemisQtySize = [];
   while($r = mysqli_fetch_assoc($respBemisQtySize)){
      $row = [
         'style' => $r['style'],
         'orc' => trim($r['orc']),
         'size' => $r['size'],
         'qty_size' => $r['qty_size'],
         // 'cup' => $r['cup'],
         'sum_qty_bemis' => $r['sum_qty_bemis']
      ];
      array_push($dtBemisQtySize, $row);
   }
   $jsonBemisQtySize = json_encode($dtBemisQtySize);
   
   echo $jsonBemisQtySize;   
}

function getJuwitaQtySize(){
   global $koneksi;

   $sql = "SELECT * FROM view_juwita_qty_size";

   $respJuwitaQtySize = mysqli_query($koneksi, $sql) or die('Gagal menampilkan data!');
   $dtJuwitaQtySize = [];
   while($r = mysqli_fetch_assoc($respJuwitaQtySize)){
      $row = [
         'style' => $r['style'],
         'orc' => trim($r['orc']),
         'size' => $r['size'],
         'qty_size' => $r['qty_size'],
         // 'cup' => $r['cup'],
         'sum_qty_juwita' => $r['sum_qty_juwita']
      ];
      array_push($dtJuwitaQtySize, $row);
   }
   $jsonJuwitaQtySize = json_encode($dtJuwitaQtySize);
   
   echo $jsonJuwitaQtySize;   
}

function getPressQtySize(){
   global $koneksi;

   $sql = "SELECT * FROM view_press_qty_size";

   $respPressQtySize = mysqli_query($koneksi, $sql) or die('Gagal menampilkan data!');
   $dtPressQtySize = [];
   while($r = mysqli_fetch_assoc($respPressQtySize)){
      $row = [
         'style' => $r['style'],
         'orc' => trim($r['orc']),
         'size' => $r['size'],
         'qty_size' => $r['qty_size'],
         // 'cup' => $r['cup'],
         'sum_qty_press' => $r['sum_qty_press']
      ];
      array_push($dtPressQtySize, $row);
   }
   $jsonPressQtySize = json_encode($dtPressQtySize);
   
   echo $jsonPressQtySize;   
}

function getHTQtySize(){
   global $koneksi;

   $sql = "SELECT * FROM view_ht_qty_size";

   $respHTQtySize = mysqli_query($koneksi, $sql) or die('Gagal menampilkan data!');
   $dtHTsQtySize = [];
   while($r = mysqli_fetch_assoc($respHTQtySize)){
      $row = [
         'style' => $r['style'],
         'orc' => trim($r['orc']),
         'size' => $r['size'],
         'qty_size' => $r['qty_size'],
         // 'cup' => $r['cup'],
         'sum_qty_ht' => $r['sum_qty_ht']
      ];
      array_push($dtHTsQtySize, $row);
   }
   $jsonHTQtySize = json_encode($dtHTsQtySize);
   
   echo $jsonHTQtySize;   
}

function getProses(){
  global $koneksi;


  $query = "SELECT * FROM master_transaksi where status = 'jalan' ORDER BY urutan limit 16";
   $response = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
   $dataProses = [];
   while($row =  mysqli_fetch_assoc($response)){
     $dtArr = [
      'nama_transaksi' => $row['nama_transaksi'],
     ];
     array_push($dataProses, $dtArr);
   }   
   $jsonProses = json_encode($dataProses);
   echo $jsonProses;   

}
?>