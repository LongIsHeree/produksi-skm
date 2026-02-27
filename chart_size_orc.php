<?php
require_once 'core/init.php';

$orc = $_POST['orc'] ?? '';
$tgl = $_POST['tgl'] ?? date('Y-m-d');

$data = [];

$q = mysqli_query($koneksi,"
SELECT 
    CONCAT(
        B.size,
        IFNULL(B.cup,'')
    ) as ukuran,
    SUM(TP.qty) as qty
FROM transaksi_carton tc
    JOIN transaksi_packing TP 
        ON tc.kode_barcode = TP.no_trx
    JOIN barang B 
        ON TP.kode_barcode = B.kode_barcode
    WHERE TP.orc = '$orc'
    AND tc.tanggal = '$tgl'
    GROUP BY B.size, B.cup
");

$labels = [];
$series = [];

while($r = mysqli_fetch_assoc($q)){
    $labels[] = $r['ukuran'];
    $series[] = (int)$r['qty'];
}

echo json_encode([
    "labels"=>$labels,
    "series"=>$series
]);