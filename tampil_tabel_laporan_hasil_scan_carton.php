<?php
require_once 'core/init.php'; 
    $proses = 'carton';
    $orc2 = $_GET['orc'] ?? '%%';   
    $tanggal = date('Y-m-d');
    $sizes = [];
    $query = "SELECT kelompok, no_trx FROM transaksi_packing WHERE orc LIKE '%$orc2%'";
    $result = mysqli_query($koneksi, $query);
    $kelompok = null;
    $data_kelompok = mysqli_fetch_array($result);
    $kelompok = $data_kelompok['kelompok'] ?? null;
    $kode_barcode = $data_kelompok['no_trx'] ?? null;

      $ListSize2 = null;
        if($kelompok == 'full' OR $kelompok == 'mix' OR $kelompok == 'mix_color' OR $kelompok == 'ecer'){
          $ListSize2 = tampilkan_size_transaksi_packing_orc2($tanggal, $orc2);
        }
        else if($kelompok == 'mix_style'){
          $ListSize2 = tampilkan_size_transaksi_packing_mixstyle_notrx2($tanggal, $kode_barcode);
          //echo '<pre>' . json_encode('masuk mix style', JSON_PRETTY_PRINT) . '</pre>';
          }
          if($ListSize2 instanceof mysqli_result){
while($size2 = mysqli_fetch_array($ListSize2)){
    $sizes[] = $size2['detail_size']; 
}}
?>
<style>
  td{
    text-align: center;
  }
  .dataTables_scrollHeadInner {
    width: 100% !important;
}
table.dataTable {
    width: 100% !important;
}
</style>

<div class="row text-center">
  <div id="loading" style="display: none;">
      Loading...
      <img src="assets/images/loader.gif" alt="Loading" width="142" height="71" />
  </div>
</div> 

<h4 style="text-align: right; margin-right: 20px; color: blue">UPDATE PER <?= date('H:i:s'); ?></h4>
<div style="margin-left: 20px; margin-right: 20px; margin-bottom: 20px;">
  <button class="btn btn-info" style="background: #254681" id="btnExportToExcel">Export To Excel</button>
</div>
<div style="margin-left: 20px; margin-right: 20px" id="tableContainer">
  <table border="1px"  class="table table-striped table-bordered row-border order-column display " id="example" style="font-size: 12px;">
  <?php 
  $jumlahColspan = 1;
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
  ?>
  <?php if(count($sizes) > 0): ?>
    <thead>
      <tr>
        <th  style="text-align: center; background: #254681; vertical-align:middle; color: white;" rowspan=2>NO</th>
        <th  style="text-align: center; background: #254681; vertical-align:middle; color: white;" rowspan=2>LINE</th>
        <th  style="text-align: center; background: #254681; vertical-align:middle; color: white;" rowspan=2>COSTOMER</th>
        <th  style="text-align: center; background: #254681; vertical-align:middle; color: white;" rowspan=2>NO PO</th>
        <th  style="text-align: center; background: #254681; vertical-align:middle; color: white;" rowspan=2>ORC</th>
        <th  style="text-align: center; background: #254681; vertical-align:middle; color: white;" rowspan=2>STYLE</th>
        <th  style="text-align: center; background: #254681; vertical-align:middle; color: white;" rowspan=2>COLOR</th>
        <th  style="text-align: center; background: #254681; vertical-align:middle; color: white;" rowspan=2>SHIP DATE</th>
        <th  style="background-color:#20B2AA; color: #ffffff" colspan="<?= $jumlahColspan; ?>"><center>SIZE</center></th>
        <th  style="text-align: center; background: #254681; vertical-align:middle; color: white;" rowspan=2>TOTAL QTY ISI KARTON</th>
        <th  style="text-align: center; background: #254681; vertical-align:middle; color: white;" rowspan=2>JUMLAH CARTON</th>
        <th  style="text-align: center; background: #254681; vertical-align:middle; color: white;" rowspan=2>KETERANGAN</th>
      </tr>
      <tr>
        <?php 
        $ListSize2 = null;
        if($kelompok == 'full' OR $kelompok == 'mix' OR $kelompok == 'mix_color' OR $kelompok == 'ecer'){
          $ListSize2 = tampilkan_size_transaksi_packing_orc2($tanggal, $orc2);
        }
        else if($kelompok == 'mix_style'){
          $ListSize2 = tampilkan_size_transaksi_packing_mixstyle_notrx2($tanggal, $kode_barcode);
        }
        //$ListSize2 = tampilkan_size_transaksi_packing_orc2($tanggal, $orc2); 

        if($ListSize2 instanceof mysqli_result && mysqli_num_rows($ListSize2)>0){
        while($size2 = mysqli_fetch_array($ListSize2)){ ?>
          <th style="background-color:#20B2AA; color: #ffffff"><center><?= $size2['ukuran'] ?? '-'; ?></center></th>
        <?php } }?>
      </tr>
    </thead>
    <?php else: ?>
<thead>
      <tr>
        <th  style="text-align: center; background: #254681; vertical-align:middle; color: white;" >NO</th>
        <th  style="text-align: center; background: #254681; vertical-align:middle; color: white;" >LINE</th>
        <th  style="text-align: center; background: #254681; vertical-align:middle; color: white;" >COSTOMER</th>
        <th  style="text-align: center; background: #254681; vertical-align:middle; color: white;" >NO PO</th>
        <th  style="text-align: center; background: #254681; vertical-align:middle; color: white;" >ORC</th>
        <th  style="text-align: center; background: #254681; vertical-align:middle; color: white;" >STYLE</th>
        <th  style="text-align: center; background: #254681; vertical-align:middle; color: white;" >COLOR</th>
        <th  style="text-align: center; background: #254681; vertical-align:middle; color: white;" >SHIP DATE</th>
        <th  style="background-color:#20B2AA; color: #ffffff" ><center>SIZE</center></th>
        <th  style="text-align: center; background: #254681; vertical-align:middle; color: white;" >TOTAL QTY ISI KARTON</th>
        <th  style="text-align: center; background: #254681; vertical-align:middle; color: white;" >JUMLAH CARTON</th>
        <th  style="text-align: center; background: #254681; vertical-align:middle; color: white;" >KETERANGAN</th>
        <th  style="text-align: center; background: #254681; color: white;" width="9%">ACTION</th>
      </tr>
    </thead>
    <?php endif; ?>
    <tbody>
    </tbody>
    
  </table>
</div>

<script>
     $(document).ready(function() {
        var proses = $('#proses').val();
        var tgl = $('#tanggal').val();
        var no_po = $('#no_po').val();
        var orc = $('#orc').val();
        var style = $('#style').val();
        var status = $('#status').val();
        var costomer = $('#costomer').val();
        var category = $('#category').val();
        var line = $('#line').val();
        var check_style = $("#check_style:checked").val();
        if(check_style=='pilih_style'){
          checkstyle = 'iya';
        }else{
          checkstyle = 'tidak';
        }
        let sizes = <?php echo json_encode($sizes); ?>;
        //console.log("masuk sini");
 // kolom default
    let columns = [
        { data: "no" },
        { data: "line" },
        { data: "costomer" },
        { data: "no_po" },
        { data: "orc" },
        { data: "style" },
        { data: "color" },
        { data: "shipment_plan" },
    ];
if(sizes.length > 0){

    sizes.forEach(function(sz){
        columns.push({ data: sz });
    });

}else{

    columns.push({
        data: null,
        defaultContent: "-"
    });

}
    columns.push({ data: "total_qty" });
    columns.push({ data: "jumlah_carton"});
    columns.push({ data: "ket"});
    columns.push({data : "aksi"});

console.log("columns:", columns.length);
console.log("sizes:", sizes);
            $('#example').DataTable({
              autoWidth: false,
        paging: false,
        destroy: true,
        colReorder: true,
        processing: true,
        serverSide: true,
        deferRender: true,
        scrollY: 500,
        scrollCollapse: true,
        scroller: true,
        scrollX: true,
        
        order: [],
        ajax:{
            url: "tampil_laporan_hasil_scan_carton.php",
            dataType: "json",
            type: "POST",
            data : {
                action : "table_data",
                proses : proses,
                tgl : tgl,
                no_po : no_po,
                orc : orc,
                style : style,
                status : status,
                costomer : costomer,
                category : category,
                line : line,
                checkstyle : checkstyle,
            }
        },
        columns: columns,
        columnDefs: [
    { targets: "_all", className: "text-center" }
],
initComplete: function(){
        $('#example').css('width','100%');
    }
    });
            
        });
   
</script>
<!-- Modal Edit Data data kelas-->
<div id="myEdit" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
  <!-- konten modal-->
    <div class="modal-content">
      <!-- heading modal -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><font face="Calibri" color="red"><b>DETAIL SIZE PROSES <?php if($proses == 'sewing'){ echo "INPUT SEWING"; }else{
          echo strtoupper($proses); 
        } ?></b></font></h4>
      </div>
      <!-- body modal -->
      <div class="modal-body">
        <div class="lihat-data"></div>
      </div>
    </div>
  </div>
</div>
<!-- Modal Edit data kelas-->

<script type="text/javascript"> 
$(document).ready(function() {
  $('#btnExportToExcel').click(function(e) {
    let fileName = $('#proses').val();
    let file = new Blob([$('#tableContainer').html()], {
        type: "application/vnd.ms-excel"
    });
    let url = URL.createObjectURL(file);
    let a = $("<a />", {
        href: url,
        download: (fileName == "washing" ? "f_qc" : (fileName == "qc_buyer" ? "furushima" : fileName)) + ".xls"
    }).appendTo("body").get(0).click();
    e.preventDefault();
  });
	$('body').on('show.bs.modal','#myEdit', function (e) {
		    var rowedit = $(e.relatedTarget).data('id');
        var proses =  $('#proses').val();
        var tanggal = $('#tanggal').val();
		//menggunakan fungsi ajax untuk pengembalian data
		$.ajax({
			type : 'post',
			url	 : 'tampil_laporan_hasil_scan_carton_detail.php',
			data: { rowedit : rowedit,
                proses : proses,
                tanggal : tanggal
            },
			success : function(data) {
				setTimeout(function(){$('.lihat-data').html(data);}, 1000);//menampilkan data ke dalam modal
			}
		});
	});
});
</script>