<?php
  require_once 'core/init.php';
  // if(cek_status($_SESSION['username'] ) == 'admin' OR cek_status($_SESSION['username'] ) == 'cutting' 
  // OR cek_status($_SESSION['username'] ) == 'SEWING' ) {
    $user = $_SESSION['username'];
    $transaksi = 'carton';
   

    $temp1 = mencari_data_master_transaksi($transaksi);
    $datatransaksi = mysqli_fetch_array($temp1);
    $temp_table = $datatransaksi['table_temporary'];
    $table = $datatransaksi['table_transaksi'];
    // Ambil orc dari temp table berdasarkan user yang login
$query_orc = mysqli_query($koneksi, "SELECT orc FROM $temp_table WHERE username = '$user' LIMIT 1");
$data_orc  = mysqli_fetch_assoc($query_orc);
$orc2      = $data_orc['orc'];
    
    

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
$query = "SELECT  A.no_trx, A.kode_barcode, A.orc, A.qty,
                 B.no_po, B.label, B.color,
                 D.style,
                 E.costomer,
                 TP.kelompok
          FROM $temp_table A
          JOIN master_order B ON A.orc = B.orc
          JOIN style D ON B.id_style = D.id_style
          JOIN costomer E ON B.id_costomer = E.id_costomer
          JOIN transaksi_packing TP ON A.kode_barcode = TP.no_trx
          WHERE A.username = '$user'
          ORDER BY A.no_trx DESC";

$result = mysqli_query($koneksi, $query) or die('gagal menampilkan data: ' . mysqli_error($koneksi));
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
    <th style="background-color:#20B2AA; color: #ffffff" colspan="<?= cek_jumlah_size_orc2($tanggal, $orc2); ?>"><center>SIZE</center></th>
    <th class="tengah theader" rowspan=2 style="background: #254681;"><center>Qty</center></th>
    <th class="tengah theader" rowspan=2 style="vertical-align:middle; background: #254681;"><center>Ket CTN</center></th>
  </tr>
   <tr>
        <?php $ListSize2 = tampilkan_size_transaksi_packing_orc2($tanggal, $orc2); 
        while($size2 = mysqli_fetch_array($ListSize2)){ ?>
          <th style="background-color:#20B2AA; color: #ffffff"><center><?= $size2['ukuran']; ?></center></th>
        <?php } ?>
    </tr>
</thead>
<tbody>
<?php
$no=1;
$subtotal_qty=0;
while($row = mysqli_fetch_assoc($result)){
    // Ambil qty per size dari transaksi_packing berdasarkan kode_barcode
    $query_sz = mysqli_query($koneksi, "SELECT CONCAT('size_', lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) as detail_size,
                                               A.qty as qty_size
                                        FROM transaksi_packing A
                                        JOIN barang B ON A.kode_barcode = B.kode_barcode
                                        LEFT OUTER JOIN size F ON B.size = F.size AND IFNULL(B.cup, '') = IFNULL(F.cup, '')
                                        WHERE A.no_trx = '{$row['kode_barcode']}'
                                        ORDER BY F.urutan");
    
    $size_data = [];
    while($sz = mysqli_fetch_assoc($query_sz)){
        $size_data[$sz['detail_size']] = $sz['qty_size'];
    }
?>
  <tr>
    <td class="tengah"><?= $no; ?></td>
    <td class="tengah"><?= $row['kode_barcode']; ?></td>
    <td class="tengah"><?= $row['orc']; ?></td>
    <td class="tengah"><?= $row['no_po']; ?></td>
    <td class="tengah"><?= $row['style']; ?></td>
    <td class="tengah"><?= $row['color']; ?></td>
    <td class="tengah"><?= $row['label']; ?></td>

    <?php 
      $ListSize2 = tampilkan_size_transaksi_packing_orc2($tanggal, $orc2); 
      while($size2 = mysqli_fetch_array($ListSize2)){ ?>
        <td class="tengah"><?= $size_data[$size2['detail_size']] ?? 0; ?></td>
    <?php } ?>

    <td class="tengah"><b><?= $row['qty']; ?></b></td>
    <td class="tengah"><?= $row['kelompok']; ?></td>
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


