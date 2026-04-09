<?php
require_once 'core/init.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';
$arr_id = explode(",", $id);
?>
<!DOCTYPE html>
<html>

<head>
  <title>Print Barcode Carton</title>
  <link rel="icon" href="img/skm_icon.png">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
  <style>
    body {
      font-family: calibri, sans-serif;
      font-size: 9px;
      margin: 5px;
    }

    .label-container {
      display: inline-block;
      width: 32%;
      vertical-align: top;
      margin-bottom: 5px;
      page-break-inside: avoid;
    }

    .label-table {
      border-collapse: collapse;
      width: 100%;
      font-size: 9px;
    }

    .label-table td {
      border: 1px solid #000;
      padding: 2px 4px;
    }

    .qr-cell {
      text-align: center;
      vertical-align: middle;
      width: 65px;
    }

    .qr-cell>div:first-child {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .data-inner {
      width: 100%;
      border-collapse: collapse;
    }

    .data-inner td {
      border: none;
      padding: 2px 4px;
    }

    .data-inner tr {
      border-bottom: 1px solid #000;
    }

    .data-inner tr:last-child {
      border-bottom: none;
    }

    .data-inner .lbl {
      width: 52px;
      white-space: nowrap;
      font-weight: bold;
    }

    .data-inner .sep {
      width: 8px;
      text-align: center;
    }

    .qr-text {
      font-size: 7px;
      margin-top: 2px;
      word-break: break-all;
    }

    .data-label {
      font-weight: bold;
    }

    @media print {
      body {
        margin: 0;
      }

      .no-print {
        display: none;
      }
    }
  </style>
</head>

<body>

  <div class="no-print" style="margin-bottom: 10px;">
    <button onclick="window.print()"
      style="background: #254681; color: white; padding: 6px 12px; cursor: pointer;">Print</button>
  </div>

  <?php
  if (!empty($id)) {
    $count = 0;
    $prev_orc = '';
    foreach ($arr_id as $no_trx) {
      $no_trx = trim($no_trx);
      if (empty($no_trx))
        continue;

      // Query data karton dari transaksi_packing
      $query = "SELECT B.orc, D.style, B.color, C.size, C.cup, F.urutan, SUM(A.qty) as qty
              FROM transaksi_packing A
              JOIN master_order B ON A.orc = B.orc
              JOIN barang C ON A.kode_barcode = C.kode_barcode
              JOIN style D ON C.id_style = D.id_style
              LEFT JOIN size F ON C.size = F.size AND IFNULL(C.cup, '') = IFNULL(F.cup, '')
              WHERE A.no_trx = '$no_trx' AND B.status = 'open'
              GROUP BY B.orc, D.style, B.color, C.size, C.cup
              ORDER BY F.urutan ASC";
      $result = mysqli_query($koneksi, $query);

      $orcs = [];
      $styles = [];
      $colors = [];
      $sizes = [];
      $qty_ctn = 0;

      while ($row = mysqli_fetch_array($result)) {
          if (!in_array($row['orc'], $orcs)) $orcs[] = $row['orc'];
          if (!in_array($row['style'], $styles)) $styles[] = $row['style'];
          if (!in_array($row['color'], $colors)) $colors[] = $row['color'];
          
          $size_str = trim($row['size'] . $row['cup']);
          $sizes[] = $size_str . " [" . $row['qty'] . "]";
          $qty_ctn += $row['qty'];
      }

      if (empty($orcs))
        continue;

      $orc_val = implode(', ', $orcs);
      $style_val = implode(', ', $styles);
      $color_val = implode(', ', $colors);
      $size_val = implode(', ', $sizes);
      $qty_val = $qty_ctn;
      $count++;

      // Separator antar ORC
      if ($prev_orc != '' && $prev_orc != $orc_val) {
        echo '<div style="width:100%; clear:both; border-top: 2px dashed #999; margin: 15px 0 10px 0;"></div>';
      }
      if ($prev_orc != $orc_val) {
        echo '<div style="widths:100%; clear:both; font-size:11px; font-weight:bold; margin-bottom:5px; padding:3px 0; background:#f0f0f0; padding-left:5px;">ORC: ' . $orc_val . '</div>';
      }
      $prev_orc = $orc_val;
      ?>

      <div class="label-container">
        <table class="label-table">
          <tr>
            <td colspan="2" style="text-align:center; font-weight:bold; font-size:9px; padding:3px 4px;"><img
                src="assets/images/gi.png" width="100" height="20">
            </td>
          </tr>
          <tr>
            <td class="qr-cell">
              <div id="qrcode-<?= $count ?>" data-barcode="<?= $no_trx ?>"></div>
              <div class="qr-text"><?= $no_trx ?></div>
            </td>
            <td style="padding:0;">
              <table class="data-inner">
                <tr>
                  <td class="lbl">ORC</td>
                  <td class="sep">:</td>
                  <td><?= $orc_val ?></td>
                </tr>
                <tr>
                  <td class="lbl">STYLE</td>
                  <td class="sep">:</td>
                  <td><?= $style_val ?></td>
                </tr>
                <tr>
                  <td class="lbl">COLOR</td>
                  <td class="sep">:</td>
                  <td><?= $color_val ?></td>
                </tr>
                <tr>
                  <td class="lbl">SIZE</td>
                  <td class="sep">:</td>
                  <td><?= $size_val ?></td>
                </tr>
                <tr>
                  <td class="lbl">QTY CTN</td>
                  <td class="sep">:</td>
                  <td><?= $qty_val ?> PCS</td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </div>

      <?php
    }
  }
  ?>

  <script>
    window.addEventListener('load', function () {
      document.querySelectorAll('[id^="qrcode-"]').forEach(function (element) {
        var barcodeValue = element.getAttribute('data-barcode');
        if (barcodeValue) {
          new QRCode(element, {
            text: barcodeValue,
            width: 55,
            height: 55,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.M
          });
        }
      });
    });
  </script>

</body>

</html>