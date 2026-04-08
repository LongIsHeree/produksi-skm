<?php
require_once 'core/init.php';
$query = "SELECT no_trx FROM transaksi_packing WHERE qty > 0 LIMIT 1";
$result = mysqli_query($koneksi, $query);
$row = mysqli_fetch_array($result);
echo $row['no_trx'];
