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
$query_orc = mysqli_query($koneksi, "SELECT A.kode_barcode, TP.orc, TP.kelompok FROM $temp_table A join transaksi_packing TP on A.kode_barcode = TP.no_trx WHERE username = '$user' ");

$data_orc = mysqli_fetch_assoc($query_orc);
$orc2      = $data_orc['orc'] ?? '';
 $kelompok = $data_orc['kelompok'] ?? '';
//echo '<pre>' . json_encode($orc2, JSON_PRETTY_PRINT) . '</pre>';
$kode_barcode = $data_orc['kode_barcode']??'';
//echo '<pre>' . json_encode($kelompok, JSON_PRETTY_PRINT) . '</pre>';
// die();


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
    $query = "SELECT qty FROM $temp_table 
              WHERE username = '$user'";
    $res = mysqli_query($koneksi, $query);
    $subtotal_qty=0;
    while($data=mysqli_fetch_assoc($res)){

    $subtotal_qty += $data['qty'];
    }
    echo $subtotal_qty;

 ?> Carton
</font>
<!-- </div> -->
</td>
</tr>
</table>
<?php
if($kelompok == 'full' OR $kelompok == 'mix' OR $kelompok == 'mix_color' OR $kelompok == 'ecer'){
$query = "SELECT  A.no_trx, A.kode_barcode, A.orc, A.qty, A.qty_isi_karton,
                 B.no_po, B.label, B.color,
                 D.style,
                 E.costomer,
                 TP.kelompok,
                 TP.total_qty
          FROM $temp_table A
          JOIN master_order B ON A.orc = B.orc
          JOIN style D ON B.id_style = D.id_style
          JOIN costomer E ON B.id_costomer = E.id_costomer
          JOIN (SELECT no_trx, SUM(qty) as total_qty,kelompok FROM transaksi_packing GROUP BY no_trx) TP ON A.kode_barcode = TP.no_trx
          WHERE A.username = '$user'
          ORDER BY A.no_trx DESC";
}else if($kelompok == 'mix_style'){
  $query = "SELECT  A.no_trx, A.kode_barcode, TP.orc,
                 B.no_po, B.label, B.color,
                 D.style,
                 E.costomer,
                 TP.kelompok,
                 '' as qty
          FROM transaksi_packing TP
          JOIN master_order B ON TP.orc = B.orc
          JOIN style D ON B.id_style = D.id_style
          JOIN costomer E ON B.id_costomer = E.id_costomer
          JOIN $temp_table A ON A.kode_barcode = TP.no_trx
          WHERE A.username = '$user' AND TP.kelompok = 'mix_style' AND TP.no_trx = A.kode_barcode
          GROUP BY A.no_trx, D.id_style,  B.orc
          ORDER BY A.no_trx DESC";
}


$result = mysqli_query($koneksi, $query) or die('gagal menampilkan data: ' . mysqli_error($koneksi));
?>

<table border="1px" id="example" class="table table-striped table-bordered data" style="font-size: 12px">
  <thead>
  <tr>
    <?php 
    //cek jumlah size untuk colspan header table
    $jumlahColspan = 0;
      if($kelompok == 'full' OR $kelompok == 'mix' OR $kelompok == 'mix_color' OR $kelompok == 'ecer'){
        $jumlahColspan = cek_jumlah_size_orc2($tanggal, $orc2); 

      }else if ($kelompok == 'mix_style'){
        $query = mysqli_query($koneksi,
        "SELECT C.size, C.cup
   FROM transaksi_packing A
  JOIN master_order B On A.orc = B.orc
  JOIN Barang C On A.kode_barcode = C.kode_barcode
  JOIN style D ON C.id_style = D.id_style
  JOIN costomer E ON B.id_costomer = E.id_costomer
  WHERE A.tanggal <= '$tanggal' AND A.no_trx LIKE '%$kode_barcode%' and A.shipment = 'n' 
  AND A.kelompok = 'mix_style' AND B.status = 'open'
  GROUP BY C.size, C.cup");
          $jumlahColspan = mysqli_num_rows($query);


      }
   // echo '<pre>' . json_encode($jumlahColspan, JSON_PRETTY_PRINT) . '</pre>';
    // die();
    ?>
    <th class="tengah theader" rowspan=2 style="vertical-align:middle; background: #254681;"><center>NO</center></th>
    <th class="tengah theader" rowspan=2 style="vertical-align:middle; background: #254681;"><center>BARCODE</center></th>
    <th class="tengah theader" rowspan=2 style="vertical-align:middle; background: #254681;"><center>ORC</center></th>
    <th class="tengah theader" rowspan=2 style="vertical-align:middle; background: #254681;"><center>No PO</center></th>
    <th class="tengah theader" rowspan=2 style="vertical-align:middle; background: #254681;"><center>STYLE</center></th>
    <th class="tengah theader" rowspan=2 style="vertical-align:middle; background: #254681;"><center>Color</center></th>
    <th class="tengah theader" rowspan=2 style="vertical-align:middle; background: #254681;"><center>Label</center></th>
    <th style="background-color:#20B2AA; color: #ffffff" colspan="<?= $jumlahColspan; ?>"><center>SIZE</center></th>
    <th class="tengah theader" rowspan=2 style="background: #254681;"><center>Isi Carton</center></th>
    <th class="tengah theader" rowspan=2 style="background: #254681;"><center>QTY</center></th>
    <th class="tengah theader" rowspan=2 style="vertical-align:middle; background: #254681;"><center>Ket CTN</center></th>
  </tr>
   <tr>
        
        <?php
        $ListSize2 = [];
        if($kelompok == 'full' OR $kelompok == 'mix' OR $kelompok == 'mix_color' OR $kelompok == 'ecer'){
          $ListSize2 = tampilkan_size_transaksi_packing_orc2($tanggal, $orc2);
        }
        else if($kelompok == 'mix_style'){
          $ListSize2 = tampilkan_size_transaksi_packing_mixstyle_notrx2($tanggal, $kode_barcode);
        }
        
        // while($row = mysqli_fetch_assoc($result)){
        //   if($row['kelompok'] == 'full' OR $row['kelompok'] == 'mix' OR $row['kelompok'] == 'mix_color' OR $row['kelompok'] == 'ecer'){
        //     $ListSize2 = tampilkan_size_transaksi_packing_orc2($tanggal, $row['orc']); 

        //   }else{
        //     $ListSize2 = tampilkan_size_transaksi_packing_mixstyle_notrx2($tanggal, $row['kode_barcode']); 
        //     echo '<pre>' . json_encode('masuk mix style', JSON_PRETTY_PRINT) . '</pre>';
        // }}

        //echo '<pre>' . json_encode($ListSize2, JSON_PRETTY_PRINT) . '</pre>';
        while($size2 = mysqli_fetch_array($ListSize2 )){ ?>
          <th style="background-color:#20B2AA; color: #ffffff"><center><?= $size2['ukuran']; ?></center></th>
        <?php } ?>
    </tr>
</thead>
<tbody>
<?php
$no=1;
$subtotal_qty=0;
// while($row = mysqli_fetch_assoc($result)){
// var_dump($row);
// echo '<br>';
// }


// die();
while($row = mysqli_fetch_assoc($result)){
  $total_ctn = 0;
    // Ambil qty per size dari transaksi_packing berdasarkan kode_barcode
    if($kelompok == 'full' OR $kelompok == 'mix' OR $kelompok == 'mix_color' OR $kelompok == 'ecer'){
$query_sz = mysqli_query($koneksi, "SELECT CONCAT('size_', lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) as detail_size,
                                               A.qty as qty_size
                                        FROM transaksi_packing A
                                        JOIN barang B ON A.kode_barcode = B.kode_barcode
                                        LEFT OUTER JOIN size F ON B.size = F.size AND IFNULL(B.cup, '') = IFNULL(F.cup, '')
                                        WHERE A.no_trx = '{$row['kode_barcode']}'
                                        ORDER BY F.urutan");
    }
    
    else if($kelompok == 'mix_style'){
      $query_sz = "SELECT CONCAT(B.size, IFNULL(B.cup, ''))  as ukuran,
  CONCAT('size_', lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) as detail_size ,
  CONCAT('total_', lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) as total_size,
  CONCAT('pilih2[&#39;size_',lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,''))),'&#39;]') as pilih_size,
  A.qty as qty_size
    FROM transaksi_packing A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order C ON A.orc = C.orc
  LEFT OUTER JOIN size F ON B.size = F.size AND IFNULL(B.cup, '') = IFNULL(F.cup, '')
  WHERE A.tanggal <= '$tanggal' AND A.no_trx = '{$row['kode_barcode']}' AND A.shipment = 'n' AND
  A.kelompok = 'mix_style' AND C.status = 'open' AND  A.orc = '{$row['orc']}'
  group by B.size, B.cup
  ORDER BY F.urutan";
      $query_sz = mysqli_query($koneksi, $query_sz);

  }
  
    
    
    $size_data = [];
    
    while($sz = mysqli_fetch_assoc($query_sz)){
      if($kelompok == 'full' OR $kelompok == 'mix' OR $kelompok == 'mix_color' OR $kelompok == 'ecer'){
$size_data[$sz['detail_size']] = $sz['qty_size'];

      }
        else if($kelompok == 'mix_style'){
          $size_data[$sz['detail_size']] = $sz['qty_size'];

        }

    }
  //echo '<pre>' . json_encode($size_data, JSON_PRETTY_PRINT) . '</pre>';
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
    $ListSize2 = [];
        if($kelompok == 'full' OR $kelompok == 'mix' OR $kelompok == 'mix_color' OR $kelompok == 'ecer'){
          $ListSize2 = tampilkan_size_transaksi_packing_orc2($tanggal, $orc2);
        }
        else if($kelompok == 'mix_style'){
          $ListSize2 = tampilkan_size_transaksi_packing_mixstyle_notrx2($tanggal, $kode_barcode);
          //echo '<pre>' . json_encode('masuk mix style', JSON_PRETTY_PRINT) . '</pre>';
          }
      while($size2 = mysqli_fetch_array($ListSize2)){ ?>
      <?php
$val = $size_data[$size2['detail_size']] ?? 0;
$total_ctn += $val;
?>
        <td class="tengah"><?= $val ?></td>
    <?php } ?>
    <?php 
    if($row['kelompok'] == 'full'){
    ?>
    <td class="tengah"><b><?= $row['qty_isi_karton']; ?></b></td>
    <?php } else { ?>
    <td class="tengah"><b><?= $total_ctn ?></b></td>
    <?php } ?>
    <td class="tengah"><b><?= $row['qty']; ?></b></td>
   
    <td class="tengah"><?php 
          if($row['kelompok'] == 'full'){
            echo 'FULL';
          }elseif($row['kelompok'] == 'ecer'){
            echo 'NOT FULL';
          }elseif($row['kelompok'] == 'mix'){
            echo 'MIX SIZE';
          }elseif($row['kelompok'] == 'mix_color'){
            echo 'MIX COLOR';
          }elseif($row['kelompok'] == 'mix_style'){
            echo 'MIX STYLE';
          } ?></td>
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


