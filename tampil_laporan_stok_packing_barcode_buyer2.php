<?php require_once 'core/init.php'; 
 $tgl = $_POST['tgl'];
 $orc = $_POST['orc'];
 $costomer = $_POST['costomer'];
 $style = $_POST['style'];
 $no_po = $_POST['no_po'];
 $var_sumsize = $_POST['var_sumsize'];


?>

<center>
  <head>
  <title>LAPORAN SCAN PACKING</title>
  <link rel="icon" href="img/skm_icon.png">
  </head>
  <h3>LAPORAN SCAN PACKING</h3>
  
  <h4>
    <?php if($orc != ''){
        echo "ORC : ".$orc;
    }
    
    ?>
    </h4>
  </center>
  <br>

<div style="margin-left: 20px; margin-right: 20px; margin-bottom: 20px;">
  <button style="background: #254681; color: white; margin: 4px 4px 4px; padding: 4px 4px 4px;" id="btnExportToExcel">Export To Excel</button>
  <button style="background: #9b0101; color: white; margin: 4px 4px 4px; padding: 4px 4px 4px;" id="btnExportToPdf">Print</button>
</div>

<div id="tableContainer">
<?php
   
   


   $ListSize = tampilkan_size_transaksi_packing2($tgl, $orc, $costomer, $no_po, $style);
   while($size = mysqli_fetch_array($ListSize)){
      ${$size['total_size']} = 0;
   }
 
   
    $subtotal =0;
    $qty_total=0;
    $qty_total_semua=0;
    $no_karton2=0;
    $no_karton3=0;
    $tot_jmlh_karton2 = 0;
    $tot_jmlh_karton3 = 0;

    if(cek_jumlah_size_packing_notmix2($tgl, $orc, $costomer, $no_po, $style) != 0){
     
      $laporan = tampilkan_laporan_stok_packing3($tgl, $orc, $costomer, $no_po, $style);
      while($pilih = mysqli_fetch_array($laporan)){
          
          $ctk[$pilih['orc']][$pilih['no_po']][$pilih['style']][$pilih['color']][$pilih['costomer']][$pilih['label']][]=array(
              'orc'=>$pilih['orc']
            
              
            );                                            
      }
      foreach($ctk as $orc2=>$no_po2)
      foreach($no_po2 as $po=>$kd_style)
      foreach($kd_style as $style2=>$kdcolor)
      foreach($kdcolor as $color=>$kdcostomer)
      foreach($kdcostomer as $costomer=>$kdlabel)
      foreach($kdlabel as $label=>$data){
      // print_r($ctk);
?>


<table class='hlap' width='100%' >
<tr>
    <td width='10%'>ORC</td><td width='1%'>:</td><td width='20%' align='left'><?= $orc2 ?>  </td>
    <td width='55%'></td>
    <td width='5%'>COSTOMER</td><td width='1%'>:</td><td width='20%' align='left'><?= $costomer ?></td>
  </tr>

  <tr>
    <td width='10%'>Style</td><td width='1%'>:</td><td width='20%' align='left'><?= $style2. ' ( ' .$color ?> ) </td>
    <td width='55%'></td>
    <td width='5%'>No PO</td><td width='1%'>:</td><td width='20%' align='left'><?= $po ?></td>
  </tr>
  <tr>
    <td width='10%'><b>Detail Transaksi</b></td><td width='1%'>:</td><td width='20%' align='left'></td>
    <td width='55%'></td>
    <td width='5%'>Label</td><td width='1%'>:</td><td width='20%' align='left'><?= $label ?></td>
  </tr>
</table>

<table  border='1' class='table table-striped table-hover' width=100% cellpadding="2px"; cellspacing="0" style="font-size: 13px;">
  <thead>
    <tr>
      <th style="background-color:#20B2AA; color: #ffffff" rowspan="2"><center>NO CTN</center></th>
      <th style="background-color:#20B2AA; color: #ffffff" rowspan="2"><center>BARCODE KARTON</center></th>
      <th style="background-color:#20B2AA; color: #ffffff" rowspan="2"><center>QR CODE</center></th>
      <th style="background-color:#20B2AA; color: #ffffff" rowspan="2"><center>TGL SCAN</center></th>
      <th style="background-color:#20B2AA; color: #ffffff" rowspan="2"><center>LABEL</center></th>
      <th style="background-color:#20B2AA; color: #ffffff" rowspan="2"><center>STYLE</center></th>
      <th style="background-color:#20B2AA; color: #ffffff" rowspan="2"><center>COLOR</center></th>
      <th style="background-color:#20B2AA; color: #ffffff" colspan="<?= cek_jumlah_size_orc2($tgl, $orc2); ?>"><center>SIZE</center></th>
      <th style="background-color:#20B2AA; color: #ffffff"><center>QTY</center></th>
      <th style="background-color:#20B2AA; color: #ffffff" rowspan="2"><center>KET CTN</center></th>
    </tr>
    <tr>
        <?php $ListSize2 = tampilkan_size_transaksi_packing_orc2($tgl, $orc2); 
        while($size2 = mysqli_fetch_array($ListSize2)){ ?>
          <th style="background-color:#20B2AA; color: #ffffff"><center><?= $size2['ukuran']; ?></center></th>
        <?php } ?>
        <th style="background-color:#20B2AA; color: #ffffff"><center>CTN</center></th>
    </tr>
  </thead>
  <tbody>
    <?php
        $no=0; 
        $laporan2 = tampilkan_laporan_stok_packing4($tgl, $orc2, $var_sumsize);
      while($pilih2 = mysqli_fetch_array($laporan2)){      
        // foreach($data as $pilih){
        $no++; 
      ?>
    <tr class="belang">
      <td align='center'><?= $no ?></td>
      <td align='center'><?= $pilih2['no_trx'] ?></td>
     <td align='center'>
  <div id="qrcode-<?= $no ?>" data-barcode="<?= $pilih2['no_trx'] ?>"></div>
</td>
      <td align='center'><?= tgl_indonesia3($pilih2['tanggal']) ?></td>
      <td align='center'><?= $pilih2['label'] ?></td>
      <td align='center'><?= $pilih2['style'] ?></td>
      <td align='center'><?= $pilih2['warna'] ?></td>
        <?php $ListSize2 = tampilkan_size_transaksi_packing_orc2($tgl, $orc2); 
        while($size2 = mysqli_fetch_array($ListSize2)){ ?>
      <td align='center'><?= $pilih2[$size2['detail_size']]; ?> 
        <?php 
          ${$size2['total_size']} +=  $pilih2[$size2['detail_size']];
        ?>
    </td>
        <?php } ?>
        <td align='center'><?= $pilih2['jumlah_size'] ?></td>
        <td align='center'><?php 
          if($pilih2['kelompok'] == 'full'){
            echo 'FULL';
          }elseif($pilih2['kelompok'] == 'ecer'){
            echo 'NOT FULL';
          }elseif($pilih2['kelompok'] == 'mix'){
            echo 'MIX SIZE';
          }elseif($pilih2['kelompok'] == 'mix_color'){
            echo 'MIX COLOR';
          }elseif($pilih2['kelompok'] == 'mix_style'){
            echo 'MIX STYLE';
          } ?></td>
    </tr>
     
    <?php
        $no_karton2++;
        $no_karton3++;
        $qty_total += $pilih2['jumlah_size'];
        $qty_total_semua += $pilih2['jumlah_size'];
        
      }      
      ?>
    <tr class="belang">
      <td colspan="7" style="background-color:#20B2AA; color: #ffffff; align=center">Total QTY :</td>
      <?php 
        $ListSize2 = tampilkan_size_transaksi_packing_orc2($tgl, $orc2); 
        while($size2 = mysqli_fetch_array($ListSize2)){ ?>
      <td align="center" style="background-color:#20B2AA; color: #ffffff;"><?= ${$size2['total_size']} ?></td>
      <?php } ?>
      <td align="center" style="background-color:#20B2AA; color: #ffffff; "><?= $qty_total ?></td>
      <td align="center" style="background-color:#20B2AA; color: #ffffff; "></td>
    </tr> 
    <tr>
      <td colspan="<?php $total_size = cek_jumlah_size_orc2($tgl, $orc2) + 9; echo $total_size;  ?>">
        Total Quantity : <?= $qty_total ?> PCS
      </td>
    </tr>
    <tr>
      <td colspan="<?php $total_size = cek_jumlah_size_orc2($tgl, $orc2) + 9; echo $total_size;  ?>">
        Total Karton : <?= $no_karton2 ?> Karton
      </td>
    </tr>
   
    </table>
    <?php 
      $qty_total=0;
      $ListSize = tampilkan_size_transaksi_packing2($tgl, $orc, $costomer, $no_po, $style);
      while($size = mysqli_fetch_array($ListSize)){
          ${$size['total_size']} = 0;
      }
      $no_karton2=0;

    ?>
    <br>

   
<?php } } ?>

 
<br>
TOTAL SCAN Semuanya : <br>
  Jumlah Barang dalam PCS :<?= $qty_total_semua; ?> PCS 
  </br>
  Jumlah Karton : <?php $total_ctn = $no_karton3 + $tot_jmlh_karton2 + $tot_jmlh_karton3; echo $total_ctn; ?> Karton

</div>
<script>
window.addEventListener('load', function() {
    document.querySelectorAll('[id^="qrcode-"]').forEach(function(element) {
        let barcodeValue = element.getAttribute('data-barcode');
        if(barcodeValue) {
            new QRCode(element, {
                text: barcodeValue,
                width: 80,
                height: 80,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.M
            });
        }
    });
});
</script>
<script src="assets/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
  
  $(document).ready(function(){
    $('#btnExportToExcel').click(function(e) {
      let file = new Blob([$('#tableContainer').html()], {
          type: "application/vnd.ms-excel"
      });
      let url = URL.createObjectURL(file);
      let a = $("<a />", {
          href: url,
          download: "scan_packing" + ".xls"
      }).appendTo("body").get(0).click();
      e.preventDefault();
    });    
 $('#btnExportToPdf').click(function(e) {
    e.preventDefault();
    window.print();
});
  });
</script>