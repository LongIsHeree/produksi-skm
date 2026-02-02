<?php
include 'dbconnect.php';
date_default_timezone_set('Asia/Jakarta');

$tgl = date('Y-m-d');

function getData($conn, $tgl){
    $query = "SELECT line, SUM(qty) as qty
              FROM transaksi_qc_endline
              WHERE tanggal = '$tgl'
              GROUP BY line
              ORDER BY line";
    $res = mysqli_query($conn, $query);

    $data = [];
    while($r = mysqli_fetch_assoc($res)){
        $data[$r['line']] = (int)$r['qty'];
    }
    return $data;
}

$today = getData($conn_produksi, $tgl);

$date = new DateTime($tgl);
$date->modify('-1 day');
$yesterday = getData($conn_produksi, $date->format('Y-m-d'));

echo json_encode([
    "today" => $today,
    "yesterday" => $yesterday
]);
