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
      width: 24%;
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
    .qr-text {
      font-size: 7px;
      margin-top: 2px;
      word-break: break-all;
    }
    .data-label {
      font-weight: bold;
    }
    @media print {
      body { margin: 0; }
      .no-print { display: none; }
    }
  </style>
</head>
<body>

<div class="no-print" style="margin-bottom: 10px;">
  <button onclick="window.print()" style="background: #254681; color: white; padding: 6px 12px; cursor: pointer;">Print</button>
</div>

<?php
if (!empty($id)) {
  $count = 0;
  foreach ($arr_id as $no_trx) {
    $no_trx = trim($no_trx);
    if (empty($no_trx)) continue;

    // Query data karton dari transaksi_packing
    $query = "SELECT B.orc, D.style, B.color, SUM(A.qty) as qty_ctn
              FROM transaksi_packing A
              JOIN master_order B ON A.orc = B.orc
              JOIN barang C ON A.kode_barcode = C.kode_barcode
              JOIN style D ON C.id_style = D.id_style
              WHERE A.no_trx = '$no_trx' AND B.status = 'open'
              GROUP BY B.orc, D.style, B.color
              LIMIT 1";
    $result = mysqli_query($koneksi, $query);
    $row = mysqli_fetch_array($result);

    if (!$row) continue;

    $orc_val = $row['orc'];
    $style_val = $row['style'];
    $color_val = $row['color'];
    $qty_val = $row['qty_ctn'];
    $count++;
?>

<div class="label-container">
  <table class="label-table">
    <tr>
      <td class="qr-cell" rowspan="4">
        <div id="qrcode-<?= $count ?>" data-barcode="<?= $no_trx ?>"></div>
        <div class="qr-text"><?= $no_trx ?></div>
      </td>
      <td><span class="data-label">ORC</span>: <?= $orc_val ?></td>
    </tr>
    <tr>
      <td><span class="data-label">STYLE</span>: <?= $style_val ?></td>
    </tr>
    <tr>
      <td><span class="data-label">COLOR</span>: <?= $color_val ?></td>
    </tr>
    <tr>
      <td><span class="data-label">QTY CTN</span>: <?= $qty_val ?> PCS</td>
    </tr>
  </table>
</div>

<?php
  }
}
?>

<script>
window.addEventListener('load', function() {
  document.querySelectorAll('[id^="qrcode-"]').forEach(function(element) {
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