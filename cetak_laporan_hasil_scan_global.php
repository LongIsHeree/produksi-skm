<?php
require_once 'core/init.php';
require_once 'view/header.php';
// date_default_timezone_set('Asia/Jakarta');


  if( !isset($_SESSION['username']) ){
    echo "<script>alert('Silakan Login terlebih dahulu untuk mengakses halaman ini');window.location='index.php'</script>";
    // header('Location: index.php');    
  }
?>


<style>
  hr {
    display: block;
    margin-top: 0.5em;
    margin-bottom: 0.5em;
    border-style: inset;
    border-width: 1px;
    border-color:blue;
  }
    
    ul.list-unstyled{
        background-color:#eee;
        cursor:pointer;
        position: absolute;
        width:25%;
        padding-left:0px;
        z-index: 2;
      }
      li.po{
        padding:7px;
        border:thin solid #F0F8FF;
        z-index: 2;
        padding-left:15px;
      }
      li.po:hover{
        background-color:#1E90FF;
        z-index: 2;
        padding-left:15px;
      }
  
</style>
<center>
  <font color="#254681"><b><h3>LAPORAN HASIL PRODUKSI</h3></font><br></b>
</center><br>
</div>


<div class="container-fluid">
  <div class="row">  
    <div class="col-sm-2">
      <font color="#254681"><b>s/d Tanggal</font><br></b>
      <input type="date" id="tanggal" value="<?= date("Y-m-d") ?>" class="form-control ganti" required>
    </div>
      
    <div class="col-sm-2">
      <font color="#254681"><b>CATEGORY</font><br></b>
      <select id="category" class="form-control ganti" name="category" required>
      <option value="">- Category -</option>
      <option value="UNDERWEAR">UNDERWEAR</option>
      <option value="OUTERWEAR">OUTERWEAR</option>
      </select>
      </div>

    <div class="col-sm-3">

    <font color="#254681"><b>COSTOMER</font><br></b>
      <select id="costomer" class="form-control ganti" name="costomer" required>
      <option value="">- Pilih Costomer -</option>
        <?php
        $costomer = tampilkan_master_costomer();
        while($pilih = mysqli_fetch_assoc($costomer)){
        echo '<option value='.$pilih['costomer'].'>'.$pilih['costomer'].'</option>';

        }
        ?>
      </select>
    </div>  

    <div class="col-sm-3">
      <font color="#254681"><b> PO BUYER</font><br></b>
          <input type="text" id="no_po" class="form-control ganti" required>
      </div>


    <div class="col-sm-2">
      <font color="#254681"><b>STATUS</font><br></b>
          <select type="text" id="status" class="form-control ganti" required>
              <option value="open" selected>OPEN</option>
              <option value="close">CLOSE</option>
          </select>
      </div>
  </div>
  <br/>

  <div class="row">

    <div class="col-sm-2">
      <font color="#254681"><b>Proses</font><br></b>
      <select id="proses" class="form-control ganti" name="proses" required >
              <option value="">- Pilih Proses -</option>
                <?php
                $proses = tampilkan_transaksi_proses();
                while($hasil = mysqli_fetch_assoc($proses)){
                  if($hasil['nama_transaksi'] == 'sewing'){
                    echo "<option value = '$hasil[nama_transaksi]'>INPUT SEWING</option>";
                  }elseif($hasil['nama_transaksi'] == 'tatami'){
                    echo "<option value = '$hasil[nama_transaksi]'>INPUT TATAMI</option>";
                  // }elseif($hasil['nama_transaksi'] == 'press'){
                  //   echo "<option value='$hasil[nama_transaksi]'>WASHING</option>";
                  }elseif($hasil['nama_transaksi'] == 'washing'){
                    echo "<option value='$hasil[nama_transaksi]'>F QC</option>";
                  }elseif($hasil['nama_transaksi'] == 'qc_buyer'){
                    echo "<option value='$hasil[nama_transaksi]'>FURUSHIMA</option>";
                  // }elseif($hasil['nama_transaksi'] == 'press'){
                  //   echo "<option value='$hasil[nama_transaksi]'>PADPRINT</option>";
                  }elseif($hasil['nama_transaksi'] == 'ht'){
                    echo "<option value='$hasil[nama_transaksi]'>HT</option>";
                  }elseif($hasil['nama_transaksi'] == 'bemis'){
                    // echo "<option value='$hasil[nama_transaksi]'>FUSE</option>";
                    echo "<option value='$hasil[nama_transaksi]'>BEMIS</option>";
                  }elseif($hasil['nama_transaksi'] == 'preparation'){
                    echo "<option value='$hasil[nama_transaksi]'>JUWITA</option>";
                  }else{
                    echo "<option value = '$hasil[nama_transaksi]'>".strtoupper($hasil['nama_transaksi'])."</option>";
                  }
                }
                ?>
              </select>
    </div>


    <div class="col-sm-2">
      <font color="#254681"><b> ORC</font><br></b>
      <input type="text" id="orc" class="form-control ganti" required>
    </div>

    <div class="col-sm-3">
      <font color="#254681"><b> <input type="checkbox" class="ganti" id="check_style" value="pilih_style"> STYLE </b></font> ( CHECKLIST UTK FILTER = )<br>
      <input type="text" id="style" class="form-control ganti" required>
    </div>

    <div class="col-sm-2">
      <font color="#254681"><b><input type="checkbox"  id="check_line" value="pilih_line"> LINE</font></b> ( PRINT DAILY )<br>
      <select id="line" class="form-control ganti" name="line" required >
        <option value="all" selected>-- Pilih Line --</option>
        <option value="not_yet" >BLM OUTPUT SEWING</option>
        <?php
          $line = tampilkan_master_line_open();
          while($hasil = mysqli_fetch_assoc($line)){ ?>
            <option value = "<?= $hasil['nama_line'] ?>"> <?= strtoupper($hasil['nama_line']) ?></option>
          <?php } ?>
      </select>
    </div>

    <div class="col-sm-1">
      <button type="button" id="refresh" class="btn btn-primary"><i class="glyphicon glyphicon-refresh"></i> REFRESH</button>
    </div>  

    <div class="col-sm-2">
      <button type="button" id="print_daily" class="btn btn-success"><i class="glyphicon glyphicon-print"></i> DAILY REPORT</button>
    </div>  
  </div>

  <br/>

  <!-- <div class="row text-center">
    <div id="loading" style="display: none;">
        Loading...
        <img src="assets/images/loader.gif" alt="Loading" width="142" height="71" />
    </div>
  </div>  -->
   
  <div class="row">
    <div id="tampil_tabel"></div>
  </div>
  
</div>

<script type="text/javascript">
  $('.ganti').on('change',function(){
    var proses = $('#proses').val();
   
 
    if(proses != 'packing_bundle'){
      var url = "tampil_laporan_hasil_scan_global2.php?proses="+proses;
    }else{
      var url = "tampil_laporan_hasil_scan_global_packing.php"
    }
    $('#loading').show();
    // $('#example').hide();  
    $('#tampil_tabel').load(url);
  });

  $('#refresh').on('click',function(){
    var proses = $('#proses').val();

    // var tgl = $('#tanggal').val();
    // var orc = $('#orc').val();
    // var no_po = $('#no_po').val();
    // var style = $('#style').val();
    // var status = $('#status').val();
    // var costomer = $('#costomer').val();
    // var category = $('#category').val();
    // var line = $('#line').val();
    // var url = "tampil_laporan_hasil_scan_global2.php?trx="+proses+"&tgl="+tgl+"&orc="+orc+"&style="+style+"&status="+status+"&costomer="+costomer+"&no_po="+no_po+"&category="+category+"&line="+line+"&layar=laptop";
    // console.log(url);
    // $('#tampil_tabel').load(url);
    
    if(proses != 'packing_bundle'){
    var url = "tampil_laporan_hasil_scan_global2.php?proses="+proses;
    }else{
      var url = "tampil_laporan_hasil_scan_global_packing.php"
    }

    $('#tampil_tabel').load(url);
  });

  $('#print_daily').on('click',function(){ 
    var proses = $('#proses').val();

    var tgl = $('#tanggal').val();
    var orc = $('#orc').val();
    var no_po = $('#no_po').val();
    var style = $('#style').val();
    var status = $('#status').val();
    var costomer = $('#costomer').val();
    var category = $('#category').val();
    var line = $('#line').val();
    var check_line = $("#check_line:checked").val();
        if((check_line=='pilih_line') && ((proses == 'sewing') || (proses == 'qc_endline'))){
          var url = "laporan_daily_production_output_line.php?trx="+proses+"&tgl="+tgl+"&orc="+orc+"&style="+style+"&costomer="+costomer+"&no_po="+no_po+"&category="+category+"&line="+line;
        }else{
          var url = "laporan_daily_production_output.php?trx="+proses+"&tgl="+tgl+"&orc="+orc+"&style="+style+"&costomer="+costomer+"&no_po="+no_po+"&category="+category;
        }

   
    window.open(url, '_blank');
    
  });  

$(document).ready(function(){
    $('#tampil_tabel').load("kosong.php");
});


</script>


</body>
</html>
