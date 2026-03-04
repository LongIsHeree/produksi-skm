<?php require_once 'core/init.php'; 
 $tgl = $_POST['tgl'];
 $costomer = $_POST['costomer'];
 $var_sumsize = $_POST['var_sumsize'];


?>

<center>
  <title>LAPORAN SCAN PACKING</title>
  <h3>LAPORAN SCAN PACKING</h3>
  
  </center>
  <br>


<?php
   
   


   $ListSize = tampilkan_size_transaksi_packing_mixstyle2($tgl, $costomer);
   while($size = mysqli_fetch_array($ListSize)){
      ${$size['total_size']} = 0;
   }

   
    $subtotal =0;
    $qty_total=0;
    $qty_total_semua=0;
    $no_karton2=0;
    $no_karton3=0;
    
    $laporan = tampilkan_laporan_stok_packing_mix_style3($tgl, $costomer);
    while($pilih = mysqli_fetch_array($laporan)){
        
        $ctk[$pilih['no_trx']][$pilih['costomer']][$pilih['no_po']][]=array(
            'no_trx'=>$pilih['no_trx']
           
            
          );                                            
    }
    foreach($ctk as $no_trx=>$cost)
    foreach($cost as $costomer=>$no_po)
    foreach($no_po as $po=>$data){
    $no_karton2++;
    $no_karton2 = 1;
    $no_karton3++;
    $no_karton3 = 1;
      // print_r($ctk);
?>


<table class='hlap' width='100%' >
<tr>
    <td width='10%'>NO PO</td><td width='1%'>:</td><td width='20%' align='left'><?= $po ?>  </td>
    <td width='55%'></td>
    <td width='5%'>COSTOMER</td><td width='1%'>:</td><td width='20%' align='left'><?= $costomer ?></td>
  </tr>

  <tr>
    <td width='10%'>NO TRX</td><td width='1%'>:</td><td width='20%' align='left'><?= $no_trx ?> ( MIX STYLE/COLOR/MIX ORC )</td>
    <td width='55%'></td>
    <td width='5%'></td><td width='1%'></td><td width='20%' align='left'></td>
    </tr>
</table>

<table  border='1' class='table table-striped table-hover' width=100% cellpadding="2px"; cellspacing="0" style="font-size: 13px;">
  <thead>
    <tr>
      <th style="background-color:#20B2AA; color: #ffffff" rowspan="2"><center>NO SCAN</center></th>
      <th style="background-color:#20B2AA; color: #ffffff" rowspan="2"><center>TGL SCAN</center></th>
      <th style="background-color:#20B2AA; color: #ffffff" rowspan="2"><center>ORC</center></th>
      <th style="background-color:#20B2AA; color: #ffffff" rowspan="2"><center>LABEL</center></th>
      <th style="background-color:#20B2AA; color: #ffffff" rowspan="2"><center>STYLE</center></th>
      <th style="background-color:#20B2AA; color: #ffffff" rowspan="2"><center>COLOR</center></th>
      <th style="background-color:#20B2AA; color: #ffffff" colspan="<?= cek_jumlah_size_packing_mix_style2($tgl, $no_trx); ?>"><center>SIZE</center></th>
      <th style="background-color:#20B2AA; color: #ffffff"><center>QTY</center></th>
    </tr>
    <tr>
        <?php $ListSize2 = tampilkan_size_transaksi_packing_mixstyle_notrx2($tgl, $no_trx); 
        while($size2 = mysqli_fetch_array($ListSize2)){ ?>
          <th style="background-color:#20B2AA; color: #ffffff"><center><?= $size2['ukuran']; ?></center></th>
        <?php } ?>
        <th style="background-color:#20B2AA; color: #ffffff"><center>CTN</center></th>
    </tr>
  </thead>
  <tbody>
    <?php
        
        $laporan2 = tampilkan_laporan_stok_packing_mix_style4($tgl, $no_trx, $var_sumsize);
      while($pilih2 = mysqli_fetch_array($laporan2)){      
        // foreach($data as $pilih){

      ?>
    <tr class="belang">
      
      <td align='center'><?= $pilih2['no_trx'] ?></td>
      <td align='center'><?= $pilih2['orc'] ?></td>
      <td align='center'><?= tgl_indonesia3($pilih2['tanggal']) ?></td>
      <td align='center'><?= $pilih2['label'] ?></td>
      <td align='center'><?= $pilih2['style'] ?></td>
      <td align='center'><?= $pilih2['warna'] ?></td>
        <?php $ListSize2 = tampilkan_size_transaksi_packing_mixstyle_notrx2($tgl, $no_trx); 
       
        while($size2 = mysqli_fetch_array($ListSize2)){ ?>
      <td align='center'><?= $pilih2[$size2['detail_size']]; ?> 
        <?php 
          ${$size2['total_size']} +=  $pilih2[$size2['detail_size']];

        ?>
    </td>
        <?php } ?>
        <td align='center'><?= $pilih2['jumlah_size'] ?></td>
    </tr>
    <?php

        
        $qty_total += $pilih2['jumlah_size'];
        $qty_total_semua += $pilih2['jumlah_size'];
      }      
      ?>
    <tr class="belang">
      <td colspan="6" style="background-color:#20B2AA; color: #ffffff; align=center">Total QTY :</td>
      <?php 
        $ListSize2 = tampilkan_size_transaksi_packing_mixstyle_notrx2($tgl, $no_trx); 
        while($size2 = mysqli_fetch_array($ListSize2)){ ?>
      <td align="center" style="background-color:#20B2AA; color: #ffffff;"><?= ${$size2['total_size']} ?></td>
      <?php } ?>
      <td align="center" style="background-color:#20B2AA; color: #ffffff; "><?= $qty_total ?></td>
    </tr> 
    <tr>
      <td colspan="<?php $total_size = cek_jumlah_size_packing_mix_style2($tgl, $no_trx) + 7; echo $total_size;  ?>">
        Total Quantity : <?= $qty_total ?> PCS
      </td>
    </tr>
    <tr>
      <td colspan="<?php $total_size = cek_jumlah_size_packing_mix_style2($tgl, $no_trx) + 7; echo $total_size;  ?>">
        Total Karton : <?= $no_karton2 ?> Karton
      </td>
    </tr>
   
    </table>
    <?php 
      $qty_total=0;
      $ListSize2 = tampilkan_size_transaksi_packing_mixstyle2($tgl, $costomer); 
        while($size2 = mysqli_fetch_array($ListSize2)){
          ${$size2['total_size']} = 0;
        }  
        $no_karton2=0;

    ?>
    <br>

   
<?php } ?>
TOTAL SCAN Semuanya : <br>
  Jumlah Barang dalam PCS :<?= $qty_total_semua; ?> PCS 
  </br>
  Jumlah Karton : <?= $no_karton3; ?> Karton
