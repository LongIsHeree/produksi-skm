<?php
require_once 'core/init.php'; 
    $proses = 'carton';
    $orc2 = $_GET['orc'] ?? '%';   
    $tanggal = date('Y-m-d');
    $sizes = [];
$ListSize2 = tampilkan_size_transaksi_packing_orc2($tanggal, $orc2);
while($size2 = mysqli_fetch_array($ListSize2)){
    $sizes[] = $size2['detail_size']; 
}
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
        <th style="background-color:#20B2AA; color: #ffffff" colspan="<?= cek_jumlah_size_orc2($tanggal, $orc2); ?>"><center>SIZE</center></th>
        <th  style="text-align: center; background: #254681; vertical-align:middle; color: white;" rowspan=2>TOTAL QTY ISI KARTON</th>
        <th  style="text-align: center; background: #254681; vertical-align:middle; color: white;" rowspan=2>JUMLAH CARTON</th>
      </tr>
      <tr>
        <?php $ListSize2 = tampilkan_size_transaksi_packing_orc2($tanggal, $orc2); 
        while($size2 = mysqli_fetch_array($ListSize2)){ ?>
          <th style="background-color:#20B2AA; color: #ffffff"><center><?= $size2['ukuran']; ?></center></th>
        <?php } ?>
      </tr>
    </thead>
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
 // kolom default
    let columns = [
        { data: "no" },
        { data: "line" },
        { data: "costomer" },
        { data: "no_po" },
        { data: "orc" },
        { data: "style" },
        { data: "color" },
        { data: "shipment_plan" }
    ];
 // tambahin kolom size dinamis
    sizes.forEach(function(sz){
        columns.push({ data: sz });
    });
    columns.push({ data: "total_qty" });
    columns.push({ data: "jumlah_carton" });
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

});
</script>