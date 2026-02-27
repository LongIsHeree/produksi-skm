<?php
require_once 'core/init.php';

$start = 0;

if($_POST['action'] == "table_data"){

    $proses = 'carton';
    $tgl = $_POST['tgl'];
    $orc = $_POST['orc'];
    $style = $_POST['style'];
    $checkstyle = $_POST['checkstyle'];
    $costomer = $_POST['costomer'];
    $no_po = $_POST['no_po'];
    $category = $_POST['category'];
    $line = $_POST['line'];
    $status = $_POST['status'];

    $temp1 = mencari_data_master_transaksi($proses);
    $datatransaksi = mysqli_fetch_array($temp1);
    $table = $datatransaksi['table_transaksi'];

    $columns = array(
        0 => 'od.id_order',
        1 => 'line',
        2 => 'od.costomer',
        3 => 'od.no_po',
        4 => 'tc.orc',
        5 => 'od.style',
        6 => 'tc.color',
        7 => 'sp.shipment_date',
        8 => 'i.category',
        9 => 'size'
    );


    
    $sql = "
        SELECT 
            od.id_order,
            IFNULL(ts.line, 'pp.plan_line') as line,
            tc.costomer,
            tc.no_po,
            tc.orc,
            tc.style,
            tc.color,
            tc.total_qty,
            mo.shipment_plan,
            i.category,
            tc.jumlah_carton,
            mo.status,
            s.style
        FROM (
    SELECT 
        orc,costomer,no_po,style,color,tanggal,
        SUM(qty_isi_karton) as total_qty,
        COUNT(kode_barcode) as jumlah_carton
    FROM $table
    WHERE tanggal = '$tgl'
    GROUP BY orc
) tc
        JOIN master_bundle mb 
            ON RIGHT(mb.barcode_bundle, LENGTH(tc.orc)) = tc.orc
        JOIN order_detail od 
            ON mb.id_order_detail = od.id_order_detail
        JOIN master_order mo 
            ON od.id_order = mo.id_order
        JOIN production_preparation pp 
            ON od.id_order = pp.id_order
        JOIN style s
            ON mo.id_style = s.id_style
        JOIN items i
            ON i.item = s.item
        LEFT JOIN transaksi_sewing ts 
            ON ts.kode_barcode = mb.barcode_bundle
    ";
    if($checkstyle === 'iya'){
if($line === 'all'){
        $sql .= " WHERE tc.tanggal = '$tgl'
        AND tc.orc LIKE '%$orc%'
        AND tc.style LIKE '%$style%'
        AND tc.costomer LIKE '%$costomer%'
        AND tc.no_po LIKE '%$no_po%'
        AND i.category LIKE '%$category%'
        AND mo.status = '$status'
        AND s.style = '$style'
        GROUP BY tc.orc";
    } else {
        $sql .= " WHERE tc.tanggal = '$tgl'
        AND tc.orc LIKE '%$orc%'
        AND tc.style LIKE '%$style%'
        AND tc.costomer LIKE '%$costomer%'
        AND tc.no_po LIKE '%$no_po%'
        AND i.category LIKE '%$category%'
        AND line = '$line'
        AND mo.status = '$status'
        AND s.style = '$style'
        GROUP BY tc.orc";
    }
    }else{
if($line === 'all'){
        $sql .= " WHERE tc.tanggal = '$tgl'
        AND tc.orc LIKE '%$orc%'
        AND tc.style LIKE '%$style%'
        AND tc.costomer LIKE '%$costomer%'
        AND tc.no_po LIKE '%$no_po%'
        AND i.category LIKE '%$category%'
        AND mo.status = '$status'
        GROUP BY tc.orc";
    } else {
        $sql .= " WHERE tc.tanggal = '$tgl'
        AND tc.orc LIKE '%$orc%'
        AND tc.style LIKE '%$style%'
        AND tc.costomer LIKE '%$costomer%'
        AND tc.no_po LIKE '%$no_po%'
        AND i.category LIKE '%$category%'
        AND line = '$line'
        AND mo.status = '$status'
        GROUP BY tc.orc";
    }
    }
    
    if(isset($_POST['search']['value']) && $_POST['search']['value'] != ''){
        $search = $_POST['search']['value'];
        $sql .= " HAVING 
            line LIKE '%$search%' OR
            costomer LIKE '%$search%' OR
            no_po LIKE '%$search%' OR
            orc LIKE '%$search%' OR
            style LIKE '%$search%' ";
    }
    if(isset($_POST['order'])){
        $column_name = $_POST['order'][0]['column'];
        $order = $_POST['order'][0]['dir'];
        $sql .= " ORDER BY ".$columns[$column_name]." ".$order;
    } else {
        $sql .= " ORDER BY od.id_order DESC";
    }

    if($_POST['length'] != -1){
        $start = $_POST['start'];
        $length = $_POST['length'];
        $sql .= " LIMIT ".$start.", ".$length;
    }


    $query = mysqli_query($koneksi, $sql);
    $count_rows = mysqli_num_rows($query);

    $data = array();
    $no = $start + 1;
    $sizes = get_size_orc($tgl, $orc) ?? [];

    while($r = mysqli_fetch_array($query)){
      $size_data = [];
        $orc_now = $r['orc'];

$qSize = mysqli_query($koneksi,"
    SELECT 
        CONCAT(
            'size_',
            LOWER(REPLACE(REPLACE(B.size,'-','_'),'/','_')),
            LOWER(TRIM(IFNULL(B.cup,'')))
        ) as detail_size,
        SUM(TP.qty) as qty_size
    FROM $table tc
    JOIN transaksi_packing TP 
        ON tc.kode_barcode = TP.no_trx
    JOIN barang B 
        ON TP.kode_barcode = B.kode_barcode
    WHERE TP.orc = '$orc_now'
    AND tc.tanggal = '$tgl'
    GROUP BY B.size, B.cup
");

        while($sz = mysqli_fetch_array($qSize)){
            $size_data[$sz['detail_size']] = $sz['qty_size'];
        }
        $nestedData = array();
        $nestedData['no'] = $no;
        $nestedData['line'] = strtoupper($r['line']);
        $nestedData['costomer'] = $r['costomer'];
        $nestedData['no_po'] = $r['no_po'];
        $nestedData['orc'] = $r['orc'];
        $nestedData['style'] = $r['style'];
        $nestedData['color'] = $r['color'];
        $nestedData['shipment_plan'] = tgl_indonesia3($r['shipment_plan']);
        $nestedData['category'] = $r['category'];
        $nestedData['total_qty'] = $r['total_qty'];
        $nestedData['jumlah_carton'] = $r['jumlah_carton'];

        foreach($sizes as $sz){
        $nestedData[$sz] = $size_data[$sz] ?? 0;
    }

        $data[] = $nestedData;
        $no++;
    }

    $output = array(
        "draw" => intval($_POST['draw']),
        "recordsTotal" => $count_rows,
        "recordsFiltered" => $count_rows,
        "data" => $data
    );

    echo json_encode($output);
}
?>