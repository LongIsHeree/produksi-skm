<?php
  require_once 'core/init.php';
?>

<!-- Script untuk menampilkan kalender -->
<?php
if($_POST['rowedit']) {
        $id_order = @$_POST['rowedit'];
        $proses = 'carton';
        $tgl = $_POST['tanggal'];
        $total_order = 0;
        $total_day = 0;
        $total_qty = 0;
        $total_bal = 0;

        $temp1 = mencari_data_master_transaksi($proses);
        $datatransaksi = mysqli_fetch_array($temp1);
        $table = $datatransaksi['table_transaksi'];
        


        $sql = tampilkan_master_order_id($id_order);; 
		$data = mysqli_fetch_array($sql);
    $orc = $data['orc'];

        
        $sql4 = cek_ketersediaan_cup_order($id_order);
        $data4 = mysqli_fetch_array($sql4);
        $sql5 = mysqli_query($koneksi, "SELECT * from $table");
        $data5 = mysqli_fetch_array($sql5);
     
?>
<b><font color="blue">
    <?= "COSTOMER : ".$data['costomer']." - | - PO BUYER : ".$data['no_po']; ?>
    <br><?= "ORC : ".$data['orc']." - | - STYLE : ".$data['style']." - | - COLOR : ".$data['color']." - | - ( ITEM : ".$data['item']." )"; ?></b>
<hr></font>
<table border="1px" class="table table-striped table-bordered display" id="example2" style="font-size: 13px; width: 100%">
  <thead>
  <tr>
    <th  class="theader" style="text-align: center; display: none" rowspan="2">ID</th>
    <th class="theader" style="text-align: center;" colspan="1">NO TRX</th>
    <th style="text-align: center; " class="theader" colspan="1">KODE BARCODE</th>
    <th class="theader" style="text-align: center" rowspan="2" >SIZE</th>
    <?php if($data4['cup'] != ''){ ?>
    <th class="theader" style="text-align: center" rowspan="2" >CUP</th>
    <?php } ?>
    <th class="theader" style="text-align: center" colspan="4" >QTY PRODUCTION</th>
  </tr>

</thead>
<tbody>
<?php
    $sql = "SELECT * from $table where orc = $orc ";
    $temp = tampilkan_laporan_bundle_record_carton_detail($table, $tgl, $id_order);
    while($row=mysqli_fetch_assoc($temp))
    //   var_dump($row);
    // die();
    { 
   ?>
  <tr>
  <td class="tengah" style="display: none"><?= $row['id_order_detail']; ?></td>
  <td class="tengah"><?= $row['kode_barcode']; ?></td>
  <td class="tengah"><?= $row['orc']; ?></td>
  <td class="tengah"><?= $row['size']; ?></td>
  <?php if($data4['cup'] != ''){ ?>
  <td class="tengah"><?= $row['cup']; ?></td>
  <?php } ?>
  </tr>
<?php 

}
 ?>
</tbody>
<tfoot>
  <?php if($data4['cup'] != ''){ ?>
    <th class="theader" colspan=4></th>
  <?php }else{ ?>
    <th class="theader" colspan=3></th>
  <?php } ?>
  <th class="theader" style="text-align: center"><?= $total_order ?></th>
  <th class="theader" style="text-align: center"><?= $total_day ?></th>
  <th class="theader" style="text-align: center"><?= $total_qty ?></th>
  <th class="theader" style="text-align: center"><?= $total_bal ?></th>
  
</tfoot>
</table>


<script type="text/javascript">
   $(document).ready(function() {
    $('#example2').DataTable( {
		paging: false,
        deferRender:    true,
        scrollY:        380,
        scrollCollapse: true,
        scroller:       true,
        searching: true,
    } );
} );
</script>

<?php } ?>