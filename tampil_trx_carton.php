<?php
  require_once 'core/init.php';
  // if(cek_status($_SESSION['username'] ) == 'admin' OR cek_status($_SESSION['username'] ) == 'cutting' 
  // OR cek_status($_SESSION['username'] ) == 'SEWING' ) {
    $user = $_SESSION['username'];
    $transaksi = $_GET['trx'];
   

    $temp1 = mencari_data_master_transaksi($transaksi);
    $datatransaksi = mysqli_fetch_array($temp1);
    $temp_table = $datatransaksi['table_temporary'];
    $table = $datatransaksi['table_transaksi'];
  
?>
  <link rel="stylesheet" href="view/style.css">

<br>
<input type="hidden" id="proses" name="proses" value="<?= $transaksi ?>">
<table class="table atas">
<tr>
<td style="text-align:left">
 <font color="red" size="5">
 <?php
 $tanggal = date("Y-m-d");
 echo tanggal_indo ($tanggal, true);
 
?>
</font>
</td>
<td style="text-align:center">
<?php 
  $data1 = tampilkan_data_produksi_bundle($user, $temp_table);
    while($temp = mysqli_fetch_array($data1)){

    if($temp['data_no'] > 0){
        $no_scan=$temp['data_no'];
    }else{
      $data2 = tampilkan_no_transaksi_production_bundle($user, $temp_table, $table);
      $trx = mysqli_fetch_array($data2);
        $no_scan=$trx['no_trx'];
        $no_scan+=1;
    }
    ?>


<font color="blue" size="5" background="green">
NO TRANSAKSI : <?= $no_scan;  } ?>
</font>
</td>
<td style="text-align:right">
<!-- <div class="qty"> -->
<font color="blue" size="5" background="green">
Total Qty Scan :
<?php
    $temp_temp_qc_kensa = tampilkan_temp_production_bundle($user, $temp_table, $table);
    $subtotal_qty=0;
    while($data=mysqli_fetch_assoc($temp_temp_qc_kensa)){

    $subtotal_qty += $data['qty_scan'];
    }
    echo $subtotal_qty;

 ?> PCS
</font>
<!-- </div> -->
</td>
</tr>
</table>
<?php
$temp_produksi = tampilkan_temp_production_bundle($user, $temp_table, $table);
?>

<table border="1px" id="example" class="table table-striped table-bordered data" style="font-size: 12px">
  <thead>
  <tr>
    <th class="tengah theader" rowspan=2 style="vertical-align:middle; background: #254681;"><center>NO</center></th>
    <th class="tengah theader" rowspan=2 style="vertical-align:middle; background: #254681;"><center>BARCODE</center></th>
    <th class="tengah theader" rowspan=2 style="vertical-align:middle; background: #254681;"><center>ORC</center></th>
    <th class="tengah theader" rowspan=2 style="vertical-align:middle; background: #254681;"><center>No PO</center></th>
    <th class="tengah theader" rowspan=2 style="vertical-align:middle; background: #254681;"><center>STYLE</center></th>
    <th class="tengah theader" rowspan=2 style="vertical-align:middle; background: #254681;"><center>Color</center></th>
    <th class="tengah theader" rowspan=2 style="vertical-align:middle; background: #254681;"><center>Label</center></th>
    <th style="background-color:#20B2AA; color: #ffffff" colspan="<?= cek_jumlah_size_orc2($tgl, $orc2); ?>"><center>SIZE</center></th>
    <th class="tengah theader" rowspan=2 style="background: #254681;"><center>Qty</center></th>
    <th class="tengah theader" rowspan=2 style="vertical-align:middle; background: #254681;"><center>Act</center></th>
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
$no=1;
$subtotal_qty=0;
while($row=mysqli_fetch_assoc($temp_produksi))
{ 

// $subtotal_qty += $row['qty'];
   ?>
  <tr>
  <script type="text/javascript" language="JavaScript">
function konfirmasi_kurangi()
{
tanya3 = confirm("Yakin ingin kurangi stok ini");
if (tanya3 == true) return true;
else return false;
}</script>

<td class="tengah"><?= $no; ?></td>
  <td class="tengah"><?= $row['kode_barcode']; ?></td>
  <td class="tengah"><?= $row['orc']; ?></td>
  <td class="tengah"><?= $row['no_po']; ?></td>
  <td class="tengah"><?= $row['no_bundle']; ?></td>
  <td class="tengah"><?= $row['style'];  ?> </td>
  <td class="tengah"><?= $row['color'];  ?> </td>
  <td class="tengah"><?= $row['label'];  ?> </td>
  <td class="tengah"><?= $row['size'].$row['cup'];  ?> </td> 
  <td class="tengah"><?= $row['qty_isi_bundle']; ?></td>
  <td class="tengah"><?= $row['qty_tersimpan']; ?></td>
  <td class="tengah"><font color="blue"><b><?= $row['qty_scan']; ?></b></font></td>
  <td class="tengah"><?= $row['balance']; ?></td>
  <td>
  <!-- <button type="button" id="edit" data-toggle="modal" data-target="#myEdit" class="btn btn-success edit_komentar kecil" data-order="<//?= $row['id_order']; ?>" data-id="<//?= $row['id_transaksi']; ?>"><i class="glyphicon glyphicon-edit"></i></button>   -->

  <!-- <button type="button" data-id="<//?= $row['id_transaksi'] ?>" class="btn btn-xs btn-danger kecil kurangi"><i class="glyphicon glyphicon-trash"></i></button> -->

  <!-- <a href="hapus_trx_produksi_bundle.php?id=<//?= $row['id_transaksi'] ?>&tbl=<//?= $temp_table ?>"><button type="button" onclick="return konfirmasi()" class="btn btn-xs btn-danger kecil"><i class="glyphicon glyphicon-trash"></i></button></a> -->
  
  <!-- <td class="tengah"><a href="hapus_qc_kensa_satu.php?id=<//?= $row['id_transaksi']; ?>" onclick="return konfirmasi_kurangi()">DEL</a></td> -->
  </td>  
  </tr>

  <?php
    $no++;
    }
  ?>
</tbody>
</table>
</div>

<center>
  <!-- <button type="button" class="btn btn-danger" >RESET</button> -->
<!-- <a href="simpan_master_kenzin.php" name="simpan"><button type="button" class="btn btn-primary" onclick="return konfirmasi_simpan()">SIMPAN</button></a>
<a href="hapus_kenzin.php" name="reset"><button type="button" class="btn btn-danger" onclick="return konfirmasi()">RESET</button></a> -->
</center>

<script type="text/javascript">
	$(document).ready(function(){
		$('.data').DataTable();
	});
</script>

<!-- Modal Edit Data data kelas-->
<div id="myEdit" class="modal fade" tabindex="-1" role="dialog">
<div class="modal-dialog">
    <!-- konten modal-->
    <div class="modal-content">
        <!-- heading modal -->
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><font face="Calibri" color="red"><b>Edit QTY Produksi Bundle</b></font></h4>
        </div>
        <!-- body modal -->
        <div class="modal-body">
           <div class="lihat-data"></div>
        </div>

    </div>
</div>
</div>
<!-- Modal Edit data kelas-->

<!-- Script ajax menampilkan Edit kelas -->
<script type="text/javascript"> 
$(document).ready(function() {
	$('body').on('show.bs.modal','#myEdit', function (e) {
		var rowedit = $(e.relatedTarget).data('id');
    var order = $(e.relatedTarget).data('order');
    var proses = $('#proses').val();
    var url = 'edit_produksi_bundle.php?rowedit='+rowedit+'&trx='+proses+'&order='+order;
    console.log(order); 
    console.log(url);
		//menggunakan fungsi ajax untuk pengembalian data
		$.ajax({
			type : 'get',
			url	 : url,
			// data : 'rowedit='+ rowedit,
			success : function(data) {
			$('.lihat-data').html(data);//menampilkan data ke dalam modal
			}
		});
	});
});

$('#example tbody').on('click', '.kurangi', function () {
  swal.fire({
      title: "Anda Yakin ingin Menghapus Hasil Scan Terpilih ini?",
      text: "Jika Sudah yakin, tekan Yes.!",
      type: "warning",

      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, Delete',
      cancelButtonText: "Cancel",
      showCancelButton: true,
      reverseButtons: false,
    }).then((result) => {
      if (result.dismiss !== 'cancel') {
       var id = $(this).data('id');
       var temp_table = $('#temp_table').val();
       var proses = $('#proses').val();
       $.ajax({
        method: "POST",
        url: "proses_trx_produksi_bundle2.php",
        data: { id : id,
            temp_table : temp_table,
            type : "delete"
        },
        success: function(data){
          console.log(data);
            if(data.trim() == "success"){
              swal("Data Berhasil di Hapus !", "Klik Ok untuk melanjutkan!", "success");
              $('#tampil_tabel').load("tampil_trx_produksi.php?trx="+proses);
            }else if(data.trim() == "errorDb"){
                alert("Gagal, Hubungi Team IT");
            }
        }
      });
    }else {
      swal.close();
    }
  });
  });
</script>
<!-- Script ajax menampilkan Edit kelas -->



<script type="text/javascript" language="JavaScript">
function konfirmasi_simpan()
{
tanya2 = confirm("Yakin Data Sudah Benar dan ingin disimpan?");
if (tanya2 == true) return true;
else return false;
}</script>

<?php
// } else {
//   echo 'Anda tidak memiliki akses kehalaman ini'; } 
  ?>


