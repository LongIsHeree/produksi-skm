<?php

require_once 'core/init.php';
$style = $_POST['style'];
$no_po = $_POST['no_po'];
$costomer = $_POST['costomer'];
$no_kenzin = $_POST['no_kenzin'];

?>
<style>
  .col-md-12 {
    height: 500px;
    overflow-y: scroll;
    padding: 0px 0px;
  }

  #dsTable {
    padding: 0px 0px;
  }

  table #example3 {
    width: 100%;
  }
</style>
<div class="col-md-12">
  <div id="dsTable" class="container">

    <table border="1px" id="example3" class="table table-hover table-bordered display"
      style="font-size: 13px; width: 96%">
      <thead>
        <tr>
          <th style="background: #0000FF; text-align: center">NO TRX</th>
          <th style="background: #0000FF; text-align: center">COSTOMER</th>
          <th style="background: #0000FF; text-align: center">NO PO</th>
          <th style="background: #0000FF; text-align: center">ORC</th>
          <th style="background: #0000FF; text-align: center">LABEL</th>
          <th style="background: #0000FF; text-align: center">STYLE</th>
          <th style="background: #0000FF; text-align: center">COLOR</th>
          <th style="background: #0000FF; text-align: center">SIZE</th>
          <th style="background: #0000FF; text-align: center">QTY KENZIN</th>
          <!-- <th class="tengah theader">BALANCE</th> -->
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        $jum = 1;
        $jum_po = 1;
        $jum_orc = 1;
        if ($no_kenzin == '') {
          $shipment = tampilkan_data_no_transaksi_kenzin($style, $no_po, $costomer);
        } else {
          $shipment = tampilkan_data_no_transaksi_kenzin_pilih($no_kenzin);
        }
        while ($row = mysqli_fetch_assoc($shipment)) {
          ?>
          <tr class="pilih2" data-trx2="<?= $row['no_trx']; ?>" data-order2="<?= $row['orc']; ?>"
            data-po2="<?= $row['no_po']; ?>" data-label2="<?= $row['label']; ?>" data-style2="<?= $row['style']; ?>"
            data-color2="<?= $row['color']; ?>" data-qtykarton2="<?= $row['qty_karton']; ?>"
            data-isikarton2="<?= $row['isi_karton']; ?>" data-costomer2="<?= $row['costomer']; ?>"
            data-kelompok2="<?= $row['kelompok']; ?>" data-dismiss="modal">
            <?php
            if ($jum <= 1) {
              echo '<td align="center" style="vertical-align: middle" rowspan="' . $row['jumlah_trx'] . '">' . $row['no_trx'] . '</td>';
              echo '<td align="center" style="vertical-align: middle" rowspan="' . $row['jumlah_trx'] . '">' . $row['costomer'] . '</td>';
              $jum = $row['jumlah_trx'];
              $no++;
            } else {
              $jum = $jum - 1;
            }
            ?>
            <!-- <td class="tengah"><?= $row['no_trx']; ?></td> -->
            <!-- <td class="tengah"><?= $row['costomer']; ?></td> -->
            <?php
            if ($jum_po <= 1) {
              echo '<td align="center" style="vertical-align: middle" rowspan="' . $row['jumlah_po'] . '">' . $row['no_po'] . '</td>';
              $jum_po = $row['jumlah_po'];
              $no++;
            } else {
              $jum_po = $jum_po - 1;
            }
            ?>
            <!-- <td class="tengah"><?= $row['no_po']; ?></td> -->
            <?php
            if ($jum_orc <= 1) {
              echo '<td align="center" style="vertical-align: middle" rowspan="' . $row['jumlah_orc'] . '">' . $row['orc'] . '</td>';
              echo '<td align="center" style="vertical-align: middle" rowspan="' . $row['jumlah_orc'] . '">' . $row['label'] . '</td>';
              echo '<td align="center" style="vertical-align: middle" rowspan="' . $row['jumlah_orc'] . '">' . $row['style'] . '</td>';
              echo '<td align="center" style="vertical-align: middle" rowspan="' . $row['jumlah_orc'] . '">' . $row['color'] . '</td>';
              $jum_orc = $row['jumlah_orc'];
              $no++;
            } else {
              $jum_orc = $jum_orc - 1;
            }
            ?>
            <!-- <td class="tengah"><?= $row['orc']; ?></td> -->
            <!-- <td class="tengah"><?= $row['style']; ?></td>
              <td class="tengah"><?= $row['label']; ?></td>
              <td class="tengah"><?= $row['color']; ?></td> -->
            <td class="tengah"><?= $row['size'] . $row['cup']; ?></td>
            <td class="tengah"><?= $row['qty_output']; ?></td>
            <!-- <?php
            // $sql = tampilkan_balance_order_lookup_orc($row['id_order']);
            // while($row2=mysqli_fetch_assoc($sql))
            // {
            //   echo $row2['size']." : ".$row2['balance'].", ";
            // }
            ?> -->
            <!-- </td> -->
          </tr>
          <?php
          $no++;
        }
        ?>
      </tbody>
    </table>
  </div>
</div>
<div class="modal-footer">
  <input name="tambah" type="button" value="Close" id="button" class="btn btn-success" data-dismiss="modal" />
  </form>
</div>


<script type="text/javascript">
  $(document).on('click', '.pilih2', function (e) {
    document.getElementById("orc").value = $(this).attr('data-order2');
    document.getElementById("orc2").value = $(this).attr('data-order2');
    document.getElementById("no_po").value = $(this).attr('data-po2');
    document.getElementById("label").value = $(this).attr('data-label2');
    document.getElementById("color").value = $(this).attr('data-color2');
    document.getElementById("style").value = $(this).attr('data-style2');
    document.getElementById("qty_karton").value = $(this).attr('data-qtykarton2');
    document.getElementById("qty_karton2").value = $(this).attr('data-qtykarton2');
    document.getElementById("costomer").value = $(this).attr('data-costomer2');
    document.getElementById("isi_karton2").value = $(this).attr('data-isikarton2');
    document.getElementById("isi_karton").value = $(this).attr('data-isikarton2');
    document.getElementById("isi_karton").value = $(this).attr('data-isikarton2');
    document.getElementById("kelompok").value = $(this).attr('data-kelompok2');
    document.getElementById("kelompok2").value = $(this).attr('data-kelompok2');
    document.getElementById("no_kenzin").value = $(this).attr('data-trx2');
    document.getElementById("no_kenzin2").value = $(this).attr('data-trx2');
    var no_kenzin = $(this).attr('data-trx2');
    url = "tampil_packing2.php?no_trx=" + no_kenzin;
    $('#myModal2').modal('hide');
    $('#tampil_tabel').load(url);
  });


  // tabel lookup mahasiswa

</script>