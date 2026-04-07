<?php
require_once 'core/init.php';
date_default_timezone_set('Asia/Jakarta');

header('Content-Type: application/json; charset=utf-8');

$koneksi->set_charset('utf8mb4');

$tgl = $_GET['tgl'] ?? date('Y-m-d');
$tgl = mysqli_real_escape_string($koneksi, $tgl);

// Query: ambil data carton all time (sampai tanggal filter), group by ORC
$sql = "SELECT 
            tc.orc,
            tc.style,
            tc.color,
            tc.costomer,
            tc.no_po,
            SUM(tc.qty) as jumlah_carton,
            SUM(tc.qty_isi_karton) as total_qty
        FROM transaksi_carton tc
        WHERE tc.tanggal <= '$tgl' AND tc.shipment_status = 'no'
        GROUP BY tc.orc
        ORDER BY tc.orc ASC";

$result = mysqli_query($koneksi, $sql);

$data = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            'orc' => $row['orc'] ?? '',
            'style' => $row['style'] ?? '',
            'color' => $row['color'] ?? '',
            'costomer' => $row['costomer'] ?? '',
            'no_po' => $row['no_po'] ?? '',
            'jumlah_carton' => (int) ($row['jumlah_carton'] ?? 0),
            'total_qty' => (int) ($row['total_qty'] ?? 0),
        ];
    }
}

echo json_encode([
    "data" => $data
], JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
exit;
