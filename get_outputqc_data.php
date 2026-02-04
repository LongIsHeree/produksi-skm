<?php
require_once 'core/init.php';
date_default_timezone_set('Asia/Jakarta');

$tgl = date('Y-m-d');
global $koneksi;
function getData($koneksi, $tgl){
    $query = "SELECT line, SUM(qty) as qty
              FROM transaksi_qc_endline
              WHERE tanggal = '$tgl'
              GROUP BY line
              ORDER BY line";
    $res = mysqli_query($koneksi, $query);

    $data = [];
    while($r = mysqli_fetch_assoc($res)){
        $data[$r['line']] = (int)$r['qty'];
    }
    return $data;
}

$today = getData($koneksi, $tgl);

$date = new DateTime($tgl);
$date->modify('-1 day');
$yesterday = getData($koneksi, $date->format('Y-m-d'));

echo json_encode([
    "today" => $today,
    "yesterday" => $yesterday
]);
