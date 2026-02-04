<?php
require_once 'core/init.php';
date_default_timezone_set('Asia/Jakarta');

$tgl = date('Y-m-d');

function getTotal($koneksi, $tgl){
    $query = "SELECT COALESCE(SUM(qty),0) AS total
              FROM transaksi_cutting
              WHERE tanggal = '$tgl'";

    $res = mysqli_query($koneksi, $query);
    $row = mysqli_fetch_assoc($res);

    return (int)($row['total'] ?? 0);
}

$totalToday = getTotal($koneksi, $tgl);

$date = new DateTime($tgl);
$date->modify('-1 day');
$totalYesterday = getTotal($koneksi, $date->format('Y-m-d'));

echo json_encode([
    "today" => $totalToday,
    "yesterday" => $totalYesterday
]);
