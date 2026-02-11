<?php
require_once 'core/init.php';
date_default_timezone_set('Asia/Jakarta');

header('Content-Type: application/json; charset=utf-8');

/* ================== AMBIL & SANITASI PARAMETER FILTER ================== */
$tgl      = $_GET['tgl']      ?? date('Y-m-d');
$status   = $_GET['status']   ?? 'OPEN';
$orc      = $_GET['orc']      ?? '';
$style    = $_GET['style']    ?? '';
$line     = $_GET['line']     ?? 'all';
$no_po    = $_GET['no_po']    ?? '';
$category = $_GET['category'] ?? '';
$costomer = $_GET['costomer'] ?? '';

$koneksi->set_charset('utf8mb4');
$tgl      = mysqli_real_escape_string($koneksi, $tgl);
$status   = mysqli_real_escape_string($koneksi, $status);
$orc      = mysqli_real_escape_string($koneksi, $orc);
$style    = mysqli_real_escape_string($koneksi, $style);
$line     = mysqli_real_escape_string($koneksi, $line);
$no_po    = mysqli_real_escape_string($koneksi, $no_po);
$category = mysqli_real_escape_string($koneksi, $category);
$costomer = mysqli_real_escape_string($koneksi, $costomer);

/* kemarin */
$date = new DateTime($tgl);
$date->modify('-1 day');
$yesterday = $date->format('Y-m-d');

/* ================== FUNGSI AMBIL DATA ================== */
function getData($koneksi, $tgl, $status, $orc, $style, $line, $category, $costomer, $no_po) {
    $lineFilter = ($line !== 'all') ? " AND (AD.line = '$line' OR A.plan_line = '$line') " : "";

     $sql = "SELECT C.tanggal_max, A.costomer, A.id_order, A.no_po, A.orc, A.style, A.color, A.shipment_plan, 
    A.qty_order, IFNULL(B.daily,0) daily,
    IFNULL(C.output_total,0) total, (IFNULL(C.output_total,0) - A.qty_order) balance, 
    IFNULL(AD.line, 'not_yet') line, A.plan_line 
    FROM 
    (SELECT C.id_order, C.orc, D.style, C.color, E.costomer, C.no_po, A.barcode_bundle, A.id_order_detail, C.shipment_plan,
    SUM(A.qty_isi_bundle) qty_order, C.status, F.category, G.plan_line FROM master_bundle A
     JOIN order_detail B ON A.id_order_detail = B.id_order_detail
     JOIN master_order C ON B.id_order = C.id_order
     JOIN style D ON C.id_style = D.id_style
     JOIN costomer E ON C.id_costomer = E.id_costomer
     JOIN items F ON D.item = F.item 
     JOIN production_preparation G ON B.id_order = G.id_order
     WHERE C.status = 'OPEN'
       AND C.orc LIKE '%$orc%' 
       AND D.style LIKE '%$style%' 
       AND E.costomer LIKE '%$costomer%'
       AND F.category LIKE '%$category%' 
       AND C.no_po LIKE '%$no_po%'
     GROUP BY C.id_order
     ORDER BY C.id_order DESC
     LIMIT 1000) A 
     LEFT OUTER JOIN 
     (SELECT A.tanggal, C.id_order, SUM(IFNULL(A.qty,0)) daily FROM transaksi_tatami A
     JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
     JOIN order_detail C ON B.id_order_detail = C.id_order_detail
     WHERE tanggal = '$tgl' 
     GROUP BY C.id_order)B
     ON A.id_order = B.id_order
      LEFT OUTER JOIN 
     (SELECT MAX(A.tanggal) tanggal_max, C.id_order, SUM(IFNULL(A.qty,0)) output_total FROM transaksi_tatami A
     JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
     JOIN order_detail C ON B.id_order_detail = C.id_order_detail
     WHERE tanggal <= '$tgl' 
     GROUP BY C.id_order)C
     ON A.id_order = C.id_order
     JOIN proses_transaksi_orc AB ON A.id_order = AB.id_order
     JOIN master_transaksi AC ON AB.nama_transaksi = AC.nama_transaksi 
     LEFT OUTER JOIN
      (SELECT C.id_order, IFNULL(A.line, 'not_yet') line FROM transaksi_sewing A
      JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
      JOIN order_detail C ON B.id_order_detail = C.id_order_detail
      GROUP BY C.id_order)AD
     ON A.id_order = AD.id_order 
     WHERE AC.table_transaksi = 'transaksi_tatami'
     $lineFilter
    ";

    $result = mysqli_query($koneksi, $sql);
    
    if (!$result) {
        error_log("SQL Error: " . mysqli_error($koneksi));
        return [];
    }

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        // Tentukan line yang akan ditampilkan
        $displayLine = '';
        if (!empty($row['line']) && $row['line'] != 'not_yet') {
            $displayLine = $row['line'];
        } elseif (!empty($row['plan_line'])) {
            $displayLine = $row['plan_line'];
        }
        
        $data[] = [
            'line' => strtoupper($displayLine),
            'orc' => $row['orc'] ?? '',
            'qty' => (int)($row['daily'] ?? 0),
            'style' => $row['style'] ?? '',
            'no_po' => $row['no_po'] ?? '',
            'total' => (int)($row['total'] ?? 0),
            'balance' => (int)($row['balance'] ?? 0),
            'costomer' => $row['costomer'] ?? '',
            'color' => $row['color'] ?? '',
            'shipment_plan' => $row['shipment_plan'] ?? '',
            'qty_order' => (int)($row['qty_order'] ?? 0)
        ];
    }

    return $data;
}

/* ================== FUNGSI AMBIL BALANCE per ORC ================== */
function getBalances($koneksi, $tanggal, $status, $orc, $style, $line) {
    $sql = "
    SELECT
        MO.orc,
        COALESCE(SUM(MB.qty_isi_bundle),0) AS qty_order,
        COALESCE(SUM(C2.qty),0) AS output_total
    FROM master_order MO
    JOIN order_detail OD ON OD.id_order = MO.id_order
    JOIN master_bundle MB ON MB.id_order_detail = OD.id_order_detail
    LEFT JOIN transaksi_tatami C2 ON C2.kode_barcode = MB.barcode_bundle AND C2.tanggal <= '{$tanggal}'
    JOIN style ST ON MO.id_style = ST.id_style
    WHERE MO.status = '{$status}'
      AND MO.orc LIKE '%{$orc}%'
      AND ST.style LIKE '%{$style}%'
    GROUP BY MO.orc
    ";

    $res = mysqli_query($koneksi, $sql);
    $map = [];
    
    if ($res) {
        while ($r = mysqli_fetch_assoc($res)) {
            $orc_key = $r['orc'];
            $qty_order = (int)$r['qty_order'];
            $output_total = (int)$r['output_total'];
            $balance = $output_total - $qty_order;
            $map[$orc_key] = $balance;
        }
    }
    
    return $map;
}

/* ================== BUILD & OUTPUT ================== */
$todayRows = getData($koneksi, $tgl, $status, $orc, $style, $line, $category, $costomer, $no_po);
$yestRows  = getData($koneksi, $yesterday, $status, $orc, $style, $line, $category, $costomer, $no_po);
$balanceMap = getBalances($koneksi, $tgl, $status, $orc, $style, $line);

// Buat map untuk yesterday (key: line|orc)
$yesterdayMap = [];
foreach ($yestRows as $r) {
    $key = $r['line'] . '|' . $r['orc'];
    $yesterdayMap[$key] = $r['qty'];
}

// Buat map untuk today (key: line|orc)
$todayMap = [];
foreach ($todayRows as $r) {
    $key = $r['line'] . '|' . $r['orc'];
    $todayMap[$key] = $r['qty'];
}

echo json_encode([
    "today"         => $todayRows,
    "yesterday"     => $yestRows,
    "today_map"     => $todayMap,
    "yesterday_map" => $yesterdayMap,
    "balance_map"   => $balanceMap
], JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
exit;