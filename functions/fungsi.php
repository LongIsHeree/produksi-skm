<?php



function tambahSizeperOrder($id, $size, $qty)
{
  $query = "INSERT INTO order_detail (id_order, size, qty_order) VALUES ($id, '$size', $qty)";

  return run($query);
}


function tampilkan_transaksi_proses()
{
  global $koneksi;


  $query = "SELECT * FROM master_transaksi where status = 'jalan' ORDER BY urutan limit 16";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function check_proses_transaksi($id_order, $nama_transaksi)
{
  global $koneksi;


  $query = "SELECT B.urutan from proses_transaksi_orc A
  JOIN master_transaksi B on A.nama_transaksi = B.nama_transaksi
  where A.id_order = $id_order AND A.nama_transaksi = '$nama_transaksi'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function check_after_proses_transaksi($id_order, $urutan)
{
  global $koneksi;


  $query = "SELECT B.kolom_total, B.urutan from proses_transaksi_orc A
  JOIN master_transaksi B on A.nama_transaksi = B.nama_transaksi
  WHERE A.id_order = $id_order AND B.urutan > $urutan
  AND (A.nama_transaksi = 'cutting' OR A.nama_transaksi = 'trimstore' OR A.nama_transaksi = 'sewing' OR A.nama_transaksi = 'qc_endline' OR A.nama_transaksi='tatami')
  ORDER BY B.urutan ASC
  limit 1";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_transaksi_all_proses($orc, $style, $status, $costomer, $no_po, $color)
{
  global $koneksi;

  $query = "SELECT distinct(A.nama_transaksi) nama_transaksi, B.kolom_today, B.kolom_total, B.kolom_balance FROM proses_transaksi_orc A 
      JOIN master_transaksi B ON A.nama_transaksi = B.nama_transaksi
      JOIN master_order C ON A.id_order = C.id_order
      JOIN style D on C.id_style = D.id_style   
      WHERE B.status = 'jalan' AND C.orc LIKE '%$orc%' AND D.style like '%$style%' AND C.status = '$status' 
      AND C.no_po LIKE '%$no_po%' AND C.color LIKE '%$color%' 
      AND (B.nama_transaksi = 'cutting' OR B.nama_transaksi = 'trimstore' OR B.nama_transaksi = 'sewing' OR B.nama_transaksi = 'qc_endline' OR B.nama_transaksi = 'tatami') ";
  if ($costomer != 0) {
  // if ($costomer > 0) {
    $query .= " AND C.id_costomer = $costomer ";
  }
  $query .= " ORDER BY B.urutan";


  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_transaksi_proses_category($category)
{
  global $koneksi;


  $query = "SELECT * FROM master_transaksi WHERE ket = 'y' AND category = '$category' OR category = 'ALL'   ORDER BY urutan";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_transaksi_proses_pp()
{
  global $koneksi;


  $query = "SELECT * FROM master_transaksi_pp ORDER BY urutan";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_transaksi_proses_pp_after($urutan)
{
  global $koneksi;


  $query = "SELECT * FROM master_transaksi_pp where urutan > $urutan ORDER BY urutan";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_transaksi_proses_pp_proses($proses)
{
  global $koneksi;


  $query = "SELECT * FROM master_transaksi_pp where nama_transaksi = '$proses'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function tampilkan_item()
{
  global $koneksi;


  $query = "SELECT * FROM items ORDER BY item";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_karton()
{
  global $koneksi;


  $query = "SELECT  A.id, A.id_style, B.style, A.qty_karton, C.costomer FROM master_qty_karton A JOIN style B on A.id_style = B.id_style
  JOIN costomer C on B.id_costomer = C.id_costomer  ORDER BY id desc";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_karton_full()
{
  global $koneksi;

  $query = "SELECT * FROM view_karton_full ORDER by id DESC";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  $data = [];
  while($row =  mysqli_fetch_assoc($result)){
    $dtArr = [
      'orc' => $row['orc'],
      'style' => $row['style'],
      'color' => $row['color'],
      'qty_order' => $row['qty_order'],
      'costomer' => $row['costomer'],
    ];
    array_push($data, $dtArr);
  }
  var_dump($data);
  return json_encode($data);
}

function tampilkan_master_smv()
{
  global $koneksi;


  $query = "SELECT  A.id, A.id_style, B.style, A.nilai_smv, ifnull(C.costomer, '') costomer FROM master_smv A JOIN style B on A.id_style = B.id_style
  LEFT outer JOIN costomer C on B.id_costomer = C.id_costomer  ORDER BY id desc";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function tampilkan_transaksi_proses_id($id)
{
  global $koneksi;


  $query = "SELECT * FROM proses_transaksi_orc where id_order = '$id' ORDER BY urutan";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}




function tampilkan_transaksi_proses_id_ticket($id, $offset, $limit)
{
  global $koneksi;


  $query = "SELECT A.nama_transaksi, A.urutan, B.singkatan FROM proses_transaksi_orc A 
  JOIN master_transaksi B ON A.nama_transaksi = B.nama_transaksi
  where id_order = $id AND B.ket = 'y' ORDER BY A.urutan limit $offset, $limit";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function countJumlahTransaksi($id)
{
  global $koneksi;


  $query = "SELECT A.nama_transaksi, A.urutan, B.singkatan FROM proses_transaksi_orc A 
  JOIN master_transaksi B ON A.nama_transaksi = B.nama_transaksi
  where id_order = $id AND B.ket = 'y' ORDER BY A.urutan ";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}


function tampilkan_transaksi_proses_urutan($id)
{
  global $koneksi;


  $query = "SELECT * FROM proses_transaksi_orc where id_proses = '$id'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_temp_kenzin($user)
{
  global $koneksi;


  $query = "SELECT A.id_transaksi_kenzin, C.orc,  A.kode_barcode, D.style, B.warna, B.size, B.cup,
  A.jam, A.tanggal, A.qty, C.no_po, C.label, (A.qty/B.qty_barcode) qty_pack
  FROM temp_kenzin A, barang B, master_order C, style D where
  A.kode_barcode = B.kode_barcode and A.orc = C.orc and B.id_style = D.id_style AND A.username = '$user' 
  ORDER BY A.tanggal, A.jam DESC";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_total_temp_qcfinal($user)
{
  global $koneksi;


  $query = "SELECT IFNULL(sum(qty), 0) jumlah_size FROM temp_qcfinal WHERE username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_total_temp_kenzin($user)
{
  global $koneksi;


  $query = "SELECT IFNULL(sum(qty), 0) jumlah_size FROM temp_kenzin WHERE username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_total_temp_packing($user)
{
  global $koneksi;


  $query = "SELECT IFNULL(sum(qty), 0) jumlah_size FROM temp_packing WHERE username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_total_packing_trx($trx)
{
  global $koneksi;


  $query = "SELECT IFNULL(sum(qty), 0) jumlah_size FROM transaksi_packing WHERE no_trx = '$trx'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_temp_qcfinal($user)
{
  global $koneksi;


  $query = "SELECT group_concat(A.id_transaksi_qcfinal) AS ids_to_delete, C.orc,  A.kode_barcode, D.style, B.warna, B.size,
  A.jam, A.tanggal, A.qty, C.no_po, C.label, COUNT(B.size) AS jumlah_size
  FROM temp_qcfinal A, barang B, master_order C, style D where
  A.kode_barcode = B.kode_barcode and A.orc = C.orc and B.id_style = D.id_style AND A.username = '$user' group by  A.kode_barcode, C.orc
  order by A.kode_barcode desc";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_temp_tatami_in($user)
{
  global $koneksi;


  $query = "SELECT A.id_transaksi_tatami_in, C.orc,  A.kode_barcode, D.style, C.color, B.size, A.jam, A.tanggal, A.qty, C.no_po, C.label
  FROM temp_tatami_in A, order_detail B, master_order C, style D where
  A.kode_barcode = B. barcode_number AND B.id_order = C.id_order AND C.id_style = D.id_style AND A.username = '$user'
  ORDER BY A.tanggal, A.jam DESC";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_temp_tatami_reject($user)
{
  global $koneksi;


  $query = "SELECT group_concat(A.id_transaksi_reject) AS ids_to_delete, max(A.id_transaksi_reject) id_reject, C.orc,  A.kode_barcode, D.style, C.color, B.size, A.jam, A.tanggal, A.qty, C.no_po, C.label, COUNT(B.size) AS jumlah_size
  FROM temp_reject_tatami A, order_detail B, master_order C, style D where
  A.kode_barcode = B. barcode_number AND B.id_order = C.id_order AND C.id_style = D.id_style AND A.username = '$user'
  group by A.kode_barcode ORDER BY id_reject desc";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_temp_qc_kensa($user)
{
  global $koneksi;


  $query = "SELECT A.id_transaksi_qc_kensa, C.orc,  A.kode_barcode, D.style, C.color, B.size, A.jam, A.tanggal, A.qty, C.no_po, C.label, E.costomer
  FROM temp_qc_kensa A, order_detail B, master_order C, style D, costomer E where
  A.kode_barcode = B. barcode_number AND B.id_order = C.id_order AND C.id_style = D.id_style AND C.id_costomer = E.id_costomer AND A.username = '$user'
   ORDER BY A.tanggal, A.jam DESC";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_temp_production_bundle($user, $temp_table, $table)
{
  global $koneksi;


  $query = "SELECT A.id_transaksi, B.id_order, A.jam, A.kode_barcode, B.no_bundle, B.costomer, B.orc, B.no_po, B.label, B.style, B.color, B.size, B.cup,  B.qty_isi_bundle, A.qty qty_scan, IFNULL(C.qty_tersimpan, 0) qty_tersimpan, (A.qty + IFNULL(C.qty_tersimpan, 0) - B.qty_isi_bundle) balance   FROM 
  (SELECT id_transaksi, kode_barcode, qty, username, jam FROM $temp_table) A
  JOIN
  (SELECT C.id_order, A.id_bundle, A.id_order_detail, A.no_bundle, A.barcode_bundle, B.size, B.cup, A.qty_isi_bundle, C.orc, D.style, C.color, C.no_po, C.label, E.costomer FROM master_bundle A
  JOIN order_detail B ON A.id_order_detail = B.id_order_detail
  JOIN master_order C ON B.id_order = C.id_order
  JOIN style D ON C.id_style = D.id_style
  JOIN costomer E ON C.id_costomer = E.id_costomer) B
  ON A.kode_barcode = B.barcode_bundle
  LEFT OUTER JOIN
  (SELECT kode_barcode, sum(qty) qty_tersimpan  FROM $table
  group by kode_barcode)C
  ON A.kode_barcode = C.kode_barcode
  WHERE A.username = '$user' ORDER BY id_transaksi desc";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_data_temp_scan_produksi_bundle_cek_scan($user, $temp_table, $table)
{
  global $koneksi;


  $query = "SELECT A.barcode_bundle, A.qty_isi_bundle, ifnull(B.total, 0) total, IFNULL(D.total_temp, 0) total_temp, D.username FROM
  (SELECT A.barcode_bundle, A.qty_isi_bundle FROM master_bundle A) A
  LEFT OUTER JOIN
  (SELECT A.kode_barcode, SUM(qty) total, username FROM $table A
  GROUP BY A.kode_barcode) B
  ON A.barcode_bundle = B.kode_barcode
  LEFT OUTER JOIN
  
  (SELECT A.kode_barcode, SUM(qty) total_temp, username FROM $temp_table A
  GROUP BY A.kode_barcode) D
  ON A.barcode_bundle = D.kode_barcode
  WHERE  D.username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_data_temp_scan_kenzin($user)
{
  global $koneksi;


  $query = "SELECT  A.qty_order, ifnull(B.total_temp, 0) total_temp, IFNULL(C.total, 0) total, B.username FROM
  (SELECT B.orc, B.id_style, A.size, A.cup, A.qty_order FROM order_detail A
  JOIN master_order B ON A.id_order = B.id_order) A
  LEFT OUTER JOIN
  (SELECT A.orc, A.kode_barcode, B.id_style, B.size, B.cup, ifnull(SUM(qty), 0) total_temp, username FROM temp_kenzin A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  GROUP BY A.orc, A.kode_barcode) B
  ON A.orc = B.orc AND A.id_style = B.id_style AND A.size = B.size AND A.cup = B.cup
LEFT OUTER JOIN
(SELECT A.orc, A.kode_barcode, B.id_style, B.size, B.cup, ifnull(SUM(qty), 0) total FROM transaksi_kenzin A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  GROUP BY A.orc, A.kode_barcode) C
  ON A.orc = C.orc AND A.id_style = C.id_style AND A.size = C.size AND A.cup = C.cup
  WHERE B.username = '$user'
 ";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_data_temp_scan_packing($user, $no_kenzin)
{
  global $koneksi;


  $query = "SELECT  A.qty_order, ifnull(B.total_temp, 0) total_temp, IFNULL(C.total, 0) total, IFNULL(D.total_before, 0) total_before, IFNULL(E.total_before_trx, 0) total_before_trx, B.username FROM
  (SELECT B.orc, B.id_style, A.size, A.cup, A.qty_order FROM order_detail A
  JOIN master_order B ON A.id_order = B.id_order) A
  LEFT OUTER JOIN
  (SELECT A.orc, A.kode_barcode, B.id_style, B.size, B.cup, ifnull(SUM(qty), 0) total_temp, username FROM temp_packing A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  GROUP BY A.orc, A.kode_barcode) B
  ON A.orc = B.orc AND A.id_style = B.id_style AND A.size = B.size AND A.cup = B.cup
LEFT OUTER JOIN
(SELECT A.orc, A.kode_barcode, B.id_style, B.size, B.cup, ifnull(SUM(qty), 0) total FROM transaksi_packing A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  GROUP BY A.orc, A.kode_barcode) C
  ON A.orc = C.orc AND A.id_style = C.id_style AND A.size = C.size AND A.cup = C.cup
LEFT OUTER JOIN
(SELECT A.orc, A.kode_barcode, B.id_style, B.size, B.cup, ifnull(SUM(qty), 0) total_before FROM transaksi_kenzin A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  GROUP BY A.orc, A.kode_barcode) D
  ON A.orc = D.orc AND A.id_style = D.id_style AND A.size = D.size AND A.cup = D.cup
LEFT OUTER JOIN
(SELECT A.orc, A.kode_barcode, B.id_style, B.size, B.cup, ifnull(SUM(qty), 0) total_before_trx FROM transaksi_kenzin A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
   WHERE A.no_trx = $no_kenzin
  GROUP BY A.orc, A.kode_barcode
 ) E
  ON A.orc = E.orc AND A.id_style = E.id_style AND A.size = E.size AND A.cup = E.cup 
  WHERE B.username = '$user' ";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_temp_production_bundle_id($user, $temp_table, $table, $edit, $table_transaksi_sebelum)
{
  global $koneksi;


  $query = "SELECT A.id_transaksi, A.jam, A.kode_barcode, B.no_bundle, B.costomer, B.orc, B.no_po, B.label, B.style, B.color, B.size, B.cup,  B.qty_isi_bundle, A.qty qty_scan, IFNULL(C.qty_tersimpan, 0) qty_tersimpan, 
  IFNULL(D.qty_proses_before, 0) qty_proses_before, (A.qty + IFNULL(C.qty_tersimpan, 0) - B.qty_isi_bundle) balance, 
  (A.qty + IFNULL(C.qty_tersimpan, 0) - IFNULL(D.qty_proses_before, 0)) balance_before   FROM 
  (SELECT id_transaksi, kode_barcode, qty, username, jam FROM $temp_table) A
  JOIN
  (SELECT A.id_bundle, A.id_order_detail, A.no_bundle, A.barcode_bundle, B.size, B.cup, A.qty_isi_bundle, C.orc, D.style, C.color, C.no_po, C.label, E.costomer FROM master_bundle A
  JOIN order_detail B ON A.id_order_detail = B.id_order_detail
  JOIN master_order C ON B.id_order = C.id_order
  JOIN style D ON C.id_style = D.id_style
  JOIN costomer E ON C.id_costomer = E.id_costomer) B
  ON A.kode_barcode = B.barcode_bundle
  LEFT OUTER JOIN
  (SELECT kode_barcode, sum(qty) qty_tersimpan  FROM $table
  GROUP BY kode_barcode)C
  ON A.kode_barcode = C.kode_barcode
  LEFT OUTER JOIN
  (SELECT kode_barcode, sum(qty) qty_proses_before  FROM $table_transaksi_sebelum
  GROUP BY kode_barcode)D
  ON A.kode_barcode = D.kode_barcode
  WHERE A.username = '$user' AND A.id_transaksi = $edit ORDER BY id_transaksi desc";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_temp_tatami_out($user)
{
  global $koneksi;


  $query = "SELECT group_concat(A.id_transaksi_tatami_out) AS ids_to_delete, max(A.id_transaksi_tatami_out) id_tatami, C.orc,  A.kode_barcode, D.style, C.color, B.size, A.jam, A.tanggal, A.qty, C.no_po, C.label, COUNT(B.size) AS jumlah_size
  FROM temp_tatami_out A, order_detail B, master_order C, style D where
  A.kode_barcode = B. barcode_number AND B.id_order = C.id_order AND C.id_style = D.id_style AND A.username = '$user'
  group by A.kode_barcode ORDER BY id_tatami desc";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_temp_ganti_label()
{
  global $koneksi;


  $query = "SELECT group_concat(A.id_trx_ganti_label) AS ids_to_delete, A.kode_barcode, D.style, B.warna, B.size,
  A.jam, A.tanggal, A.qty, A.orc,  COUNT(B.size) AS jumlah_size, A.ke_label, E.label, F.no_po
  FROM temp_ganti_label A, barang B, master_order C, style D, Label E, PO F where
  A.kode_barcode = B.kode_barcode AND A.orc = C.orc and B.id_style = D.id_style AND C.id_label = E.id_label AND C.id_po = F.id_po
  group by  A.kode_barcode, A.orc, A.ke_label
  order by A.kode_barcode desc ";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_temp_packing($user)
{
  global $koneksi;


  $query = "SELECT A.id_transaksi_packing, C.orc,  A.kode_barcode, D.style, B.warna, B.size,
  A.jam, A.tanggal, A.qty, C.no_po, C.label
  FROM temp_packing A, barang B, master_order C, style D where
  A.kode_barcode = B.kode_barcode and A.orc = C.orc and B.id_style = D.id_style AND A.username = '$user'
  ORDER BY A.tanggal, A.jam DESC";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_temp_packing_lockkenzin($user, $no_kenzin)
{
  global $koneksi;


  $query = "SELECT B.id_transaksi_packing, A.no_trx, A.orc, A.no_po, A.label, A.kode_barcode,  A.style, A.warna,  A.size, A.cup, B.jam, ifnull(A.total_kenzin,0) total_kenzin, ifnull(qty_scan,0) qty_scan, (ifnull(qty_scan,0)/A.qty_barcode) qty_pack from
  (SELECT A.no_trx, A.orc, B.no_po, A.kode_barcode, D.style, C.warna, B.label, C.size, C.cup, SUM(qty) total_kenzin, C.qty_barcode   FROM transaksi_kenzin A 
  JOIN master_order B ON A.orc = B.orc
  JOIN barang C ON A.kode_barcode = C.kode_barcode
  JOIN style D ON C.id_style = D.id_style
  WHERE A.no_trx = $no_kenzin
  GROUP BY A.no_trx, A.orc, A.kode_barcode) A
  LEFT OUTER JOIN 
  (SELECT id_transaksi_packing, orc, kode_barcode, IFNULL(SUM(qty), 0) qty_scan, username, tanggal, jam FROM temp_packing
  WHERE username = '$user'
  group by orc, kode_barcode)B
  ON A.kode_barcode = B.kode_barcode AND A.orc = B.orc
  ORDER BY B.tanggal desc, B.jam desc
  ";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function cek_jumlah_style_temp_packing($user)
{
  global $koneksi;

  $query = "SELECT B.id_style FROM temp_packing A JOIN barang B ON A.kode_barcode = B.kode_barcode
    WHERE username = '$user' GROUP BY B.id_style ";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_jumlah_orc_temp_packing($user)
{
  global $koneksi;

  $query = "SELECT orc FROM temp_packing 
      WHERE username = '$user'  GROUP BY orc";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_jumlah_orc_size_temp_packing($user)
{
  global $koneksi;

  $query = "SELECT A.orc FROM temp_packing A JOIN barang B ON A.kode_barcode = B.kode_barcode
        WHERE username = '$user'  GROUP BY A.orc";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_jumlah_size_temp_packing($user)
{
  global $koneksi;

  $query = "SELECT A.kode_barcode FROM temp_packing A JOIN barang B ON A.kode_barcode = B.kode_barcode
      WHERE username = '$user'  GROUP BY A.orc, A.kode_barcode ";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}


function cek_jumlah_size_temp_packing_bundle_style_size($user)
{
  global $koneksi;

  $query = "SELECT D.id_style, B.id_order_detail, C.size FROM temp_packing_bundle A 
    JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
    JOIN order_detail C ON B.id_order_detail = C.id_order_detail
    JOIN master_order D ON C.id_order = D.id_order
    WHERE A.username = '$user' 
    GROUP BY D.id_style, C.size";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_jumlah_size_temp_kenzin_orc_barcode($user)
{
  global $koneksi;

  $query = "SELECT orc, kode_barcode FROM temp_kenzin 
      WHERE username = '$user' 
      GROUP BY orc, kode_barcode";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_jumlah_size_temp_packing_orc_barcode($user)
{
  global $koneksi;

  $query = "SELECT orc, kode_barcode FROM temp_packing
    WHERE username = '$user' 
    GROUP BY orc, kode_barcode";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_jumlah_style_temp_packing_bundle($user)
{
  global $koneksi;

  $query = "SELECT D.id_style FROM temp_packing_bundle A 
    JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
    JOIN order_detail C ON B.id_order_detail = C.id_order_detail
    JOIN master_order D ON C.id_order = D.id_order
    WHERE A.username = '$user' 
    GROUP BY D.id_style";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_jumlah_orc_temp_kenzin($user)
{
  global $koneksi;

  $query = "SELECT orc FROM temp_kenzin 
    WHERE username = '$user' 
    GROUP BY orc";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}



function cek_jumlah_buyer_temp_packing_bundle($user)
{
  global $koneksi;

  $query = "SELECT D.id_costomer FROM temp_packing_bundle A 
      JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
      JOIN order_detail C ON B.id_order_detail = C.id_order_detail
      JOIN master_order D ON C.id_order = D.id_order
      WHERE A.username = '$user' 
      GROUP BY D.id_costomer";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_jumlah_buyer_temp_kenzin($user)
{
  global $koneksi;

  $query = "SELECT B.id_costomer FROM temp_kenzin A 
      JOIN master_order B on A.orc = B.orc WHERE A.username = '$user' 
      GROUP BY B.id_costomer";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_jumlah_buyer_temp_packing($user)
{
  global $koneksi;

  $query = "SELECT B.id_costomer FROM temp_packing A 
        JOIN master_order B on A.orc = B.orc WHERE A.username = '$user' 
        GROUP BY B.id_costomer";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_no_before_in_packing($no_kenzin)
{
  global $koneksi;

  $query = "SELECT no_trx FROM transaksi_packing where no_before = $no_kenzin";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_jumlah_transaksi_pecahan_orc($id_order)
{
  global $koneksi;

  $query = "SELECT A.nama_transaksi FROM proses_transaksi_orc A 
      JOIN master_transaksi B ON A.nama_transaksi = B.nama_transaksi 
      WHERE A.id_order = $id_order AND B.tipe = 'pecahan'";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_ketersediaan_cup_order($id_order)
{
  global $koneksi;

  $query = "SELECT cup FROM order_detail WHERE id_order = $id_order GROUP BY id_order";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function tampilkan_transaksi_packing($trx)
{
  global $koneksi;


  $query = "SELECT A.id_transaksi_packing, C.orc,  A.kode_barcode, D.style, C.color, B.size,
  A.jam, A.tanggal, A.qty, C.no_po, C.label, A.qty, A.no_trx, B.warna
  FROM transaksi_packing A, barang B, master_order C, style D where
  A.kode_barcode = B.kode_barcode and A.orc = C.orc and B.id_style = D.id_style AND A.no_trx = '$trx'
   ORDER BY A.tanggal, A.jam DESC";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_temp_order_detail($user)
{
  global $koneksi;

  $query = "SELECT * FROM temp_order_detail where username = '$user' order by id_order_detail desc";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function tampilkan_edit_order_id2($id)
{
  global $koneksi;

  $query = "SELECT B.id_order, B.id_order_detail, D.style, C.color, C.label, C.no_po, B.barcode_number, B.size, B.cup, B.qty_order, C.qty_bundle, C.username FROM order_detail B 
  JOIN master_order C ON B.id_order = C.id_order
  JOIN style D ON C.id_style = D.id_style
  WHERE B.id_order = $id
  GROUP BY B.id_order_detail 
 order BY size='10L', size='9L',
   size='8L', size='7L', size='6L', size='5L', size='4L', size='3L', size='LL', size='L', 
   size='M', size='S', size='SS', B.id_order_detail desc";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_line_register_hrd($id)
{
  global $koneksi;

  $query = "SELECT A.id, B.nama_line, A.id_line, A.date_register, A.jml_register_hrd  FROM master_line_operator A JOIN master_line B ON A.id_line = B.id_line
  WHERE A.id_line = $id ORDER BY A.date_register desc";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_line_register_hrd_id($id)
{
  global $koneksi;

  $query = "SELECT id, id_line, date_register, jml_register_hrd FROM master_line_operator WHERE id = $id";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function tampilkan_barcode_order_id($id)
{
  global $koneksi;

  $query = "SELECT A.id_order, A.id_order_detail, A.style, A.color, A.label, A.no_po, A.barcode_number, A.size, A.cup, A.qty_order, A.qty_bundle, B.tot_qty_bundle, A.full_box, A.pecahan, B.username  FROM
  (SELECT A.id_order_detail, A.id_order, C.style, B.color, B.label, B.no_po, A.barcode_number, A.size, A.cup, A.qty_order, B.qty_bundle, FLOOR(A.qty_order/B.qty_bundle) full_box, MOD(A.qty_order, B.qty_bundle) pecahan FROM order_detail A 
  JOIN master_order B ON A.id_order = B.id_order
  JOIN style C ON B.id_style = C.id_style) A
  LEFT OUTER JOIN
  (SELECT id_order_detail, COUNT(no_bundle) tot_qty_bundle, username FROM master_bundle GROUP BY id_order_detail )B
  ON A.id_order_detail = B.id_order_detail
  WHERE A.id_order = $id
  
 ";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_count_size($id)
{
  global $koneksi;

  $query = "SELECT COUNT(A.size) total, B.orc, B.no_po, B.label, B.color, C.style  FROM order_detail A 
  join master_order B join style C on B.id_style = C.id_style  WHERE A.id_order = $id ";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function tampilkan_jumlah_temp_order($user)
{
  global $koneksi;

  $query = "SELECT SUM(qty_order) AS total_order FROM temp_order_detail where username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_jumlah_order_edit($id)
{
  global $koneksi;

  $query = "SELECT SUM(qty_order) AS total_order FROM order_detail where id_order = '$id'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_temp_order_detail_id($edit)
{
  global $koneksi;

  $query = "SELECT * FROM temp_order_detail where id_order_detail = '$edit'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_size_order_detail_id($edit)
{
  global $koneksi;

  $query = "SELECT A.id_order_detail, A.id_order, A.size, A.cup, A.barcode_number, A.qty_order, B.orc, C.style FROM order_detail A join master_order B ON A.id_order = B.id_order JOIN style C ON B.id_style = C.id_style   where id_order_detail = '$edit'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_order_detail_id($edit)
{
  global $koneksi;

  $query = "SELECT * FROM order_detail where id_order = '$edit' order BY size='10L', size='9L',
   size='8L', size='7L', size='6L', size='5L', size='4L', size='3L', size='LL', size='L', 
   size='M', size='S', size='SS', size";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}



function tampilkan_orc_po_label_master_order($orc)
{
  global $koneksi;


  $query = "SELECT A.orc, B.no_po, C.label, A. FROM master_order A join po B on A.id_po = B.id_po join label C 
  on A.id_label = C.id_label where A.orc = '$orc' order by no_po";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_masterContract()
{
  global $koneksi;


  $query = "SELECT * FROM contract_number";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function tampilkan_po_packing()
{
  global $koneksi;

  $query = "SELECT DISTINCT A.id_po, C.no_po, A.kriteria FROM transaksi_packing A join po C on A.id_po=C.id_po 
            where A.kriteria = 'tidak' order by C.no_po";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_po_packing_mix()
{
  global $koneksi;

  $query = "SELECT DISTINCT A.id_po, C.no_po, A.kriteria FROM transaksi_packing A join po C on A.id_po=C.id_po 
            where A.kriteria = 'mix_style' order by C.no_po";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_po_shipment()
{
  global $koneksi;

  $query = "SELECT id_shipment, no_invoice FROM shipment WHERE status='aktif'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_bundle_orc($id_order)
{
  global $koneksi;

  $query = "SELECT C.orc, C.no_po, C.label, D.style, D.item, C.color, E.costomer, B.size, B.cup, C.qty_bundle,
  C.prepare_on, C.shipment_plan, SUM(A.qty_isi_bundle) qty_order, COUNT(A.barcode_bundle) total_bundle  FROM master_bundle A
JOIN order_detail B ON A.id_order_detail = B.id_order_detail
JOIN master_order C ON B.id_order = C.id_order
JOIN style D ON C.id_style = D.id_style
JOIN costomer E ON C.id_costomer = E.id_costomer 
WHERE B.id_order = $id_order";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_preparartion_production($po, $category, $orc, $style, $status, $costomer)
{
  global $koneksi;

  $query = "SELECT C.orc, C.no_po, C.label, D.style, D.item, C.color, E.costomer, C.qty_order, C.prepare_on, C.shipment_plan,
  F.plan_line, F.days_proses, F.plan_production, F.id_prod, 
  F.date_in_team_sample, F.team_sample_pic, F.team_sample_date, F.kesiapan_team_sample,
  F.date_in_fit_sample, F.fit_sample_pic, F.fit_sample_date, F.kesiapan_fit_sample,
  F.date_in_size_set_sample, F.size_set_sample_pic, F.size_set_sample_date, F.kesiapan_size_set_sample,
  F.date_in_ppm, F.ppm_pic, F.kesiapan_ppm, F.ppm_date, 
  F.date_in_pattern_check, F.pattern_check_date, F.kesiapan_pattern_check, F.pattern_check_pic,
  F.date_in_template_sewing, F.template_sewing_pic, F.kesiapan_template_sewing, F.template_sewing_date, 
  F.date_in_marker, F.marker_pic, F.kesiapan_marker, F.marker_date,
  F.moulding_pic, F.moulding_date, F.machines_setting_pic, F.machines_setting_date, F.layout_pic, F.layout_date,
  F.ready_produksi_pic, F.ready_produksi_date, F.fabric_edit_date, F.inhouse_fabric_date, F.kesiapan_fabric_date, F.kesiapan_fabric, F.fabric_pic, 
  F.inhouse_acc_sewing_date, F.acc_sewing_edit_date, F.kesiapan_acc_sewing, F.acc_sewing_pic,
  F.acc_packing_edit_date, F.kesiapan_acc_packing, F.acc_packing_pic, 
  H.start_date_cutting, ROUND(H.output_cutting/C.qty_order*100, 1) status_cutting,
  I.start_date_trimstore, ROUND(I.output_trimstore/C.qty_order*100, 1) status_trimstore,
  J.start_date_qc_endline, ROUND(J.output_qc_endline/C.qty_order*100, 1) status_qc_endline,
  K.start_date_sewing, K.line
    FROM  master_order C 
  JOIN style D ON C.id_style = D.id_style
  JOIN costomer E ON C.id_costomer = E.id_costomer 
  JOIN production_preparation F ON C.id_order = F.id_order
  JOIN items G ON D.item = G.item
  LEFT JOIN (
    SELECT C.id_order, MIN(A.tanggal) start_date_cutting, sum(ifnull(A.qty,0)) output_cutting FROM transaksi_cutting A
    JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
    JOIN order_detail C ON B.id_order_detail = C.id_order_detail
    GROUP BY C.id_order
  ) H ON C.id_order = H.id_order
  LEFT JOIN (
    SELECT C.id_order, MIN(A.tanggal) start_date_trimstore, sum(ifnull(A.qty,0)) output_trimstore FROM transaksi_trimstore A
    JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
    JOIN order_detail C ON B.id_order_detail = C.id_order_detail
    GROUP BY C.id_order
  ) I ON C.id_order = I.id_order
  LEFT JOIN (
    SELECT C.id_order, MIN(A.tanggal) start_date_qc_endline, sum(ifnull(A.qty,0)) output_qc_endline FROM transaksi_qc_endline A
    JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
    JOIN order_detail C ON B.id_order_detail = C.id_order_detail
    GROUP BY C.id_order
  ) J ON C.id_order = J.id_order
  LEFT JOIN (
    SELECT C.id_order, MIN(A.tanggal) start_date_sewing, sum(ifnull(A.qty,0)) output_sewing, A.line FROM transaksi_sewing A
    JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
    JOIN order_detail C ON B.id_order_detail = C.id_order_detail
    GROUP BY C.id_order
  ) K ON C.id_order = K.id_order
  WHERE G.category LIKE '%$category%' AND C.orc LIKE '%$orc%' AND C.no_po LIKE '%$po%' AND D.style LIKE '%$style%'
  AND F.status LIKE '%$status%' AND E.costomer LIKE '%$costomer%' 
  GROUP BY F.id_order
  ORDER BY F.id_prod desc limit 50
  ";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_plan_production($po, $category, $orc, $style, $status, $costomer)
{
  global $koneksi;

  $query = "SELECT C.orc, C.no_po, C.label, D.style, D.item, C.color, E.costomer, C.qty_order, C.prepare_on, C.shipment_plan,
  F.plan_line, F.days_proses, F.plan_production, F.id_prod
    FROM  master_order C 
  JOIN style D ON C.id_style = D.id_style
  JOIN costomer E ON C.id_costomer = E.id_costomer 
  JOIN production_preparation F ON C.id_order = F.id_order
  JOIN items G ON D.item = G.item
  WHERE G.category LIKE '%$category%' AND C.orc LIKE '%$orc%' AND C.no_po LIKE '%$po%' AND D.style LIKE '%$style%'
  AND F.status LIKE '%$status%' AND E.costomer LIKE '%$costomer%' 
  GROUP BY F.id_order
  ORDER BY F.id_prod desc limit 50
  ";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_bundle_orc_size($id_order, $b)
{
  global $koneksi;

  $query = "SELECT size, cup, qty_order, id_order_detail FROM order_detail 
   WHERE id_order = $id_order limit $b, 1";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}



function cekTotalBundleMax($id_order, $offset, $limitSize)
{
  global $koneksi;

  $query = "SELECT count(A.no_bundle) total_bundle_max from
            (SELECT * from master_bundle)A
            JOIN
            (SELECT id_order_detail, size, qty_order FROM order_detail 
              WHERE id_order = $id_order LIMIT $offset, $limitSize)B
            ON A.id_order_detail = B.id_order_detail
            GROUP BY B.size
            ORDER BY total_bundle_max DESC LIMIT 1";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_bundle_orc_nomer($id_order_detail, $no_urut)
{
  global $koneksi;

  $query = "SELECT A.id_order_detail, ifnull(B.no_bundle, ' ') no_bundle FROM 
  (SELECT id_order_detail FROM order_detail WHERE id_order_detail= $id_order_detail) A
  LEFT OUTER JOIN
  (SELECT IFNULL(no_bundle, '0') no_bundle, id_order_detail FROM master_bundle WHERE id_order_detail= $id_order_detail and no_urut = $no_urut)B
  ON A.id_order_detail = B.id_order_detail";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_bundle_orc_nomer_new($id_order_detail, $offsetbundle, $limit_baris)
{
  global $koneksi;

  $query = "SELECT no_bundle FROM master_bundle WHERE id_order_detail= $id_order_detail limit $offsetbundle, $limit_baris";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_bundle_orc_nomer_new_transaksi($id_order_detail, $offsetbundle, $limit_baris, $table, $tgl)
{
  global $koneksi;

  $query = "SELECT A.no_bundle, A.barcode_bundle, B.tanggal_max, A.qty_isi_bundle,  B.output_total, (ifnull(B.output_total,0)-A.qty_isi_bundle) balance  FROM 
  (SELECT no_bundle, barcode_bundle, qty_isi_bundle FROM master_bundle WHERE id_order_detail= $id_order_detail limit $offsetbundle, $limit_baris) A
  LEFT OUTER JOIN 
  (SELECT max(A.tanggal) tanggal_max, A.kode_barcode, sum(ifnull(A.qty,0)) output_total FROM $table A
     JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
     JOIN order_detail C ON B.id_order_detail = C.id_order_detail
     WHERE tanggal <= '$tgl' 
     GROUP BY A.kode_barcode) B
  ON A.barcode_bundle = B.kode_barcode";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_bundle_orc_nomer_new_transaksi_sewing_in_out($id_order_detail, $offsetbundle, $limit_baris, $tgl)
{
  global $koneksi;

  $query = "SELECT A.no_bundle, A.barcode_bundle, C.tanggal_max, A.qty_isi_bundle, IFNULL(B.total_input, 0) total_input, (ifnull(B.total_input,0)-A.qty_isi_bundle) balance_input,
  IFNULL(C.total_output, 0) total_output, (ifnull(C.total_output,0)-A.qty_isi_bundle) balance_output, C.line  FROM 
  (SELECT no_bundle, barcode_bundle, qty_isi_bundle FROM master_bundle WHERE id_order_detail= $id_order_detail limit $offsetbundle, $limit_baris) A
  LEFT OUTER JOIN 
  (SELECT A.kode_barcode, sum(ifnull(A.qty,0)) total_input FROM transaksi_sewing A
     JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
     JOIN order_detail C ON B.id_order_detail = C.id_order_detail
     WHERE tanggal <= '$tgl' 
     GROUP BY A.kode_barcode) B
  ON A.barcode_bundle = B.kode_barcode
  LEFT OUTER JOIN 
  (SELECT max(A.tanggal) tanggal_max, A.kode_barcode, sum(ifnull(A.qty,0)) total_output, A.line FROM transaksi_qc_endline A
     JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
     JOIN order_detail C ON B.id_order_detail = C.id_order_detail
     WHERE tanggal <= '$tgl' 
     GROUP BY A.kode_barcode) C
  ON A.barcode_bundle = C.kode_barcode";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_bundle_orc_nomer_new_transaksi_qc_buyer($id_order_detail, $offsetbundle, $limit_baris, $tgl)
{
  global $koneksi;

  $query = "SELECT A.no_bundle, A.barcode_bundle, C.tanggal_max, A.qty_isi_bundle, IFNULL(B.total_input, 0) total_input, (ifnull(B.total_input,0)-A.qty_isi_bundle) balance_input,
  IFNULL(C.total_output, 0) total_output, (ifnull(C.total_output,0)-A.qty_isi_bundle) balance_output FROM 
  (SELECT no_bundle, barcode_bundle, qty_isi_bundle FROM master_bundle WHERE id_order_detail= $id_order_detail limit $offsetbundle, $limit_baris) A
  LEFT OUTER JOIN 
  (SELECT A.kode_barcode, sum(ifnull(A.qty,0)) total_input FROM transaksi_qc_endline A
     JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
     JOIN order_detail C ON B.id_order_detail = C.id_order_detail
     WHERE tanggal <= '$tgl' 
     GROUP BY A.kode_barcode) B
  ON A.barcode_bundle = B.kode_barcode
  LEFT OUTER JOIN 
  (SELECT max(A.tanggal) tanggal_max, A.kode_barcode, sum(ifnull(A.qty,0)) total_output FROM transaksi_qc_buyer A
     JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
     JOIN order_detail C ON B.id_order_detail = C.id_order_detail
     WHERE tanggal <= '$tgl' 
     GROUP BY A.kode_barcode) C
  ON A.barcode_bundle = C.kode_barcode";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_bundle_orc_nomer_new_transaksi_tatami($id_order_detail, $offsetbundle, $limit_baris, $tgl, $table_transaksi_sebelum)
{
  global $koneksi;

  $query = "SELECT A.no_bundle, A.barcode_bundle, C.tanggal_max, A.qty_isi_bundle, IFNULL(B.total_input, 0) total_input, (ifnull(B.total_input,0)-A.qty_isi_bundle) balance_input,
  IFNULL(C.total_output, 0) total_output, (ifnull(C.total_output,0)-A.qty_isi_bundle) balance_output FROM 
  (SELECT no_bundle, barcode_bundle, qty_isi_bundle FROM master_bundle WHERE id_order_detail= $id_order_detail limit $offsetbundle, $limit_baris) A
  LEFT OUTER JOIN 
  (SELECT A.kode_barcode, sum(ifnull(A.qty,0)) total_input FROM $table_transaksi_sebelum A
     JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
     JOIN order_detail C ON B.id_order_detail = C.id_order_detail
     WHERE tanggal <= '$tgl' 
     GROUP BY A.kode_barcode) B
  ON A.barcode_bundle = B.kode_barcode
  LEFT OUTER JOIN 
  (SELECT max(A.tanggal) tanggal_max, A.kode_barcode, sum(ifnull(A.qty,0)) total_output FROM transaksi_tatami A
     JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
     JOIN order_detail C ON B.id_order_detail = C.id_order_detail
     WHERE tanggal <= '$tgl' 
     GROUP BY A.kode_barcode) C
  ON A.barcode_bundle = C.kode_barcode";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_bundle_orc_nomer_new_transaksi_packing_bundle($id_order_detail, $offsetbundle, $limit_baris, $tgl)
{
  global $koneksi;

  $query = "SELECT A.no_bundle, A.barcode_bundle, C.tanggal_max, A.qty_isi_bundle, IFNULL(B.total_input, 0) total_input, (ifnull(B.total_input,0)-A.qty_isi_bundle) balance_input,
  IFNULL(C.total_output, 0) total_output, (ifnull(C.total_output,0)-A.qty_isi_bundle) balance_output FROM 
  (SELECT no_bundle, barcode_bundle, qty_isi_bundle FROM master_bundle WHERE id_order_detail= $id_order_detail limit $offsetbundle, $limit_baris) A
  LEFT OUTER JOIN 
  (SELECT A.kode_barcode, sum(ifnull(A.qty,0)) total_input FROM transaksi_tatami_in2 A
     JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
     JOIN order_detail C ON B.id_order_detail = C.id_order_detail
     WHERE tanggal <= '$tgl' 
     GROUP BY A.kode_barcode) B
  ON A.barcode_bundle = B.kode_barcode
  LEFT OUTER JOIN 
  (SELECT max(A.tanggal) tanggal_max, A.kode_barcode, sum(ifnull(A.qty,0)) total_output FROM transaksi_packing_bundle A
     JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
     JOIN order_detail C ON B.id_order_detail = C.id_order_detail
     WHERE tanggal <= '$tgl' 
     GROUP BY A.kode_barcode) C
  ON A.barcode_bundle = C.kode_barcode";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function cekMaksimalUrutanBundle($id_order)
{
  global $koneksi;


  $query = "SELECT MAX(no_urut) max_nourut FROM order_detail A JOIN master_bundle B ON A.id_order_detail = B.id_order_detail WHERE A.id_order = $id_order";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function cekUrutanProsesIdOrder($id, $urutan)
{
  global $koneksi;


  $query = "SELECT A.id_order, B.urutan, B.nama_transaksi FROM 
  (SELECT id_order from master_order) A
  LEFT outer JOIN 
  (SELECT * FROM proses_transaksi_orc where urutan = $urutan)B
  ON A.id_order = B.id_order 
  WHERE A.id_order = $id";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function cekjumlahSize($id_order)
{

  global $koneksi;
  $id_order = escape($id_order);
  $query = "SELECT size, cup FROM order_detail where id_order = $id_order";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_jumlah_bundle_persize($id_order_detail, $offsetbundle, $limit_baris)
{
  global $koneksi;

  $query = "SELECT no_bundle FROM master_bundle WHERE id_order_detail= $id_order_detail limit $offsetbundle, $limit_baris";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}


function cekCountSize($id_order, $offset,  $limitSize)
{
  global $koneksi;

  $query = "SELECT size FROM order_detail where id_order = $id_order limit $offset, $limitSize";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function tampilkanNamaPerusahaan()
{
  global $koneksi;

  $query = "SELECT * FROM perusahaan limit 1";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function tampilkan_ticket_bundle($id_order, $offsetLembar, $limitTicket)
{
  global $koneksi;

  $query = "SELECT D.costomer, C.orc, C.no_po, C.label, E.style, B.size, B.cup, E.item, C.prepare_on, C.color, A.qty_isi_bundle, A.no_bundle, C.shipment_plan, A.barcode_bundle, A.lot
   FROM master_bundle A 
  JOIN order_detail B ON A.id_order_detail = B.id_order_detail
  JOIN master_order C ON B.id_order = C.id_order
  JOIN costomer D ON C.id_costomer = D.id_costomer
  JOIN style E ON C.id_style = E.id_style
  where C.id_order = $id_order limit $offsetLembar, $limitTicket";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_ticket_bundle1($id_order)
{
  global $koneksi;

  $query = "SELECT D.costomer, C.orc, C.no_po, C.label, E.style, B.size, B.cup, E.item, C.prepare_on, C.color, A.qty_isi_bundle, A.no_bundle, C.shipment_plan, A.barcode_bundle, A.lot
   FROM master_bundle A 
  JOIN order_detail B ON A.id_order_detail = B.id_order_detail
  JOIN master_order C ON B.id_order = C.id_order
  JOIN costomer D ON C.id_costomer = D.id_costomer
  JOIN style E ON C.id_style = E.id_style
  where C.id_order = $id_order";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_ticket_bundle_id_array($id, $offsetLembar, $limitTicket)
{
  global $koneksi;

  $query = "SELECT D.costomer, C.orc, C.no_po, E.style, B.size, B.cup, E.item, C.prepare_on, C.color, A.qty_isi_bundle, A.no_bundle, C.shipment_plan, A.barcode_bundle, A.lot
   FROM master_bundle A 
  JOIN order_detail B ON A.id_order_detail = B.id_order_detail
  JOIN master_order C ON B.id_order = C.id_order
  JOIN costomer D ON C.id_costomer = D.id_costomer
  JOIN style E ON C.id_style = E.id_style
  where A.id_bundle in ($id) limit $offsetLembar, $limitTicket";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_ticket_bundle_pecah_bundle($id_order, $barcode)
{
  global $koneksi;

  $query = "SELECT D.costomer, C.orc, C.no_po, E.style, B.size, B.cup, E.item, C.prepare_on, C.color, A.qty_isi_bundle, A.no_bundle, C.shipment_plan, A.barcode_bundle FROM master_bundle A 
  JOIN order_detail B ON A.id_order_detail = B.id_order_detail
  JOIN master_order C ON B.id_order = C.id_order
  JOIN costomer D ON C.id_costomer = D.id_costomer
  JOIN style E ON C.id_style = E.id_style
  where C.id_order = $id_order AND A.barcode_bundle = '$barcode' ";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function cek_jumlah_ticket_bundle_hal($id_order, $offsetLembar, $limitTicket)
{
  global $koneksi;

  $query = "SELECT A.barcode_bundle FROM master_bundle A 
  JOIN order_detail B ON A.id_order_detail = B.id_order_detail
  where B.id_order = $id_order limit $offsetLembar, $limitTicket";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_jumlah_ticket_bundle_hal_id_array($id, $offsetLembar, $limitTicket)
{
  global $koneksi;

  $query = "SELECT A.barcode_bundle FROM master_bundle A 
  JOIN order_detail B ON A.id_order_detail = B.id_order_detail
  where A.id_bundle in ($id) limit $offsetLembar, $limitTicket";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}


function Cek_jumlah_ticket_bundle($id_order)
{
  global $koneksi;

  $query = "SELECT A.barcode_bundle FROM master_bundle A 
  JOIN order_detail B ON A.id_order_detail = B.id_order_detail
  where B.id_order = $id_order";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function Cek_jumlah_bundle_size($id_order_detail)
{
  global $koneksi;

  $query = "SELECT A.barcode_bundle FROM master_bundle A 
  JOIN order_detail B ON A.id_order_detail = B.id_order_detail
  where A.id_order_detail = $id_order_detail";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function Cek_jumlah_bundle_size_id_order($id_order, $limit)
{
  global $koneksi;

  $query = "SELECT A.barcode_bundle FROM
  (SELECT barcode_bundle, id_order_detail FROM master_bundle )A 
  RIGHT OUTER JOIN
  (SELECT id_order_detail FROM order_detail where id_order = $id_order LIMIT $limit)B
  ON A.id_order_detail = B.id_order_detail";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function tampilkan_barang_style()
{
  global $koneksi;


  $query = "SELECT * FROM barang join style on barang.id_style = style.id_style group by style";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_hd_transaksi_packing_bundle($no_trx)
{
  global $koneksi;


  $query = "SELECT barcode_ctn, no_trx FROM hd_transaksi_packing_bundle WHERE no_trx in ($no_trx)
  order by no_trx asc";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function tampilkan_data_scan_packing_bundle($no_trx)
{
  global $koneksi;


  $query = "SELECT E.style, D.color FROM transaksi_packing_bundle A
  JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
  JOIN order_detail C ON B.id_order_detail = C.id_order_detail
  JOIN master_order D ON C.id_order = D.id_order
  JOIN style E ON D.id_style = E.id_style
   WHERE no_trx = $no_trx
   GROUP BY style, color";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_data_scan_packing_bundle_costomer($no_trx)
{
  global $koneksi;


  $query = "SELECT E.costomer FROM transaksi_packing_bundle A
  JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
  JOIN order_detail C ON B.id_order_detail = C.id_order_detail
  JOIN master_order D ON C.id_order = D.id_order
  JOIN costomer E ON D.id_costomer = E.id_costomer
   WHERE no_trx = $no_trx
   GROUP BY D.id_costomer";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_data_scan_packing_bundle_po_buyer($no_trx)
{
  global $koneksi;


  $query = "SELECT D.no_po FROM transaksi_packing_bundle A
  JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
  JOIN order_detail C ON B.id_order_detail = C.id_order_detail
  JOIN master_order D ON C.id_order = D.id_order
  JOIN costomer E ON D.id_costomer = E.id_costomer
   WHERE no_trx = $no_trx
   GROUP BY  D.no_po";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_data_scan_packing_bundle_size($no_trx, $style, $color)
{
  global $koneksi;


  $query = "SELECT C.size, C.cup, SUM(qty) total FROM transaksi_packing_bundle A
  JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
  JOIN order_detail C ON B.id_order_detail = C.id_order_detail
  JOIN master_order D ON C.id_order = D.id_order
  JOIN style E ON D.id_style = E.id_style
  WHERE A.no_trx = '$no_trx' AND E.style = '$style' AND D.color = '$color'
  GROUP BY E.style, D.color, C.size, C.cup";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function Cek_jumlah_bundle_size_id_order_new($id_order, $limit)
{
  global $koneksi;


  $query = "SELECT CEIL((COUNT(A.barcode_bundle)/21)) total  FROM
  (SELECT barcode_bundle, id_order_detail from master_bundle )A 
  RIGHT OUTER JOIN
  (SELECT id_order_detail FROM order_detail where id_order = $id_order LIMIT $limit)B
  ON A.id_order_detail = B.id_order_detail
   GROUP BY A.id_order_detail";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_barang_id($edit)
{
  global $koneksi;


  $query = "SELECT A.id_style, B.style, A.kode_barcode, A.warna, A.size, A.cup, A.qty_barcode, A.weight FROM 
  barang A join style B on A.id_style = B.id_style 
  where A.kode_barcode = '$edit'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_barang_idstyle($idstyle)
{
  global $koneksi;


  $query = "SELECT A.id_style, B.style, A.kode_barcode, A.warna, A.size, A.weight FROM 
  barang A join style B on A.id_style = B.id_style 
  where A.id_style = '$idstyle' 
  order by A.size='10L', A.size='9L', A.size='8L', A.size='7L', A.size='6L', A.size='5L', A.size='4L', A.size='3L', A.size='LL', A.size='L', A.size='M', A.size='S', A.size='SS', A.size";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function tampilkan_barang_costomer_idstyle($idstyle)
{
  global $koneksi;


  $query = "SELECT DISTINCT(B.style) style, C.costomer FROM master_order A 
  JOIN style B ON A.id_style = B.id_style JOIN costomer C ON A.id_costomer = C.id_costomer 
  WHERE A.id_style = $idstyle";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanBarangStyleSize($kode_barcode)
{
  global $koneksi;


  $query = "SELECT id_style, size, cup, warna, qty_barcode FROM barang where kode_barcode = '$kode_barcode'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyOrderBarcodeBuyer($orc, $size, $cup)
{
  global $koneksi;


  $query = "SELECT A.barcode_number, IFNULL(SUM(A.qty_order),0)qty_order
    FROM order_detail A JOIN master_order B ON A.id_order = B.id_order 
  WHERE B.orc = '$orc' AND A.size = '$size' AND A.cup = '$cup'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanOrderBarcodeBuyer($orc)
{
  global $koneksi;


  $query = "SELECT id_style, color, id_costomer from master_order
  WHERE orc = '$orc'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyOrderBarcodeBundle($kode_barcode)
{
  global $koneksi;


  $query = "SELECT qty_isi_bundle FROM master_bundle WHERE barcode_bundle = '$kode_barcode'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanDataOrder($kode_barcode)
{
  global $koneksi;


  $query = "SELECT B.orc, B.id_style, A.size, IFNULL(SUM(A.qty_order),0)qty_order, C.barcode_costomer FROM order_detail A 
  JOIN master_order B ON A.id_order = B.id_order
  JOIN costomer C on B.id_costomer = C.id_costomer WHERE A.barcode_number = '$kode_barcode'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyOrder($kode_barcode)
{
  global $koneksi;


  $query = "SELECT IFNULL(SUM(A.qty_order),0)qty_order FROM order_detail A 
  JOIN master_order B ON A.id_order = B.id_order WHERE A.barcode_number = '$kode_barcode'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function mencari_id_order($kode_barcode)
{
  global $koneksi;


  $query = "SELECT B.id_order FROM master_bundle A JOIN order_detail B ON A.id_order_detail = B.id_order_detail WHERE A.barcode_bundle = '$kode_barcode'  LIMIT 1";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function mencari_no_urutan_proses($proses, $id_order)
{
  global $koneksi;


  $query = "SELECT urutan FROM proses_transaksi_orc WHERE id_order = '$id_order' AND nama_transaksi = '$proses'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function mencari_no_urutan_proses_kode_barcode($proses, $kode_barcode)
{
  global $koneksi;


  $query = "SELECT C.urutan, B.id_order FROM master_bundle A 
  JOIN order_detail B ON A.id_order_detail = B.id_order_detail
  JOIN proses_transaksi_orc C on B.id_order = C.id_order
  WHERE A.barcode_bundle = '$kode_barcode' AND C.nama_transaksi = '$proses'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function mencari_nama_tabel_transaksi_sebelum($proses_before, $id_order)
{
  global $koneksi;


  $query = "SELECT B.table_transaksi FROM proses_transaksi_orc A 
  JOIN master_transaksi B ON A.nama_transaksi = B.nama_transaksi
  WHERE A.urutan = $proses_before AND id_order = $id_order ";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function mencari_qty_transaksi_sebelum($table_transaksi_sebelum, $kode_barcode)
{
  global $koneksi;


  $query = "SELECT IFNULL(SUM(A.qty), 0) qty_before FROM $table_transaksi_sebelum A WHERE A.kode_barcode = '$kode_barcode'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function mencari_data_master_transaksi($transaksi)
{
  global $koneksi;


  $query = "SELECT table_temporary, table_transaksi, tipe, urutan FROM master_transaksi WHERE nama_transaksi = '$transaksi'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function mencari_transaksi_pecahan($id_order)
{
  global $koneksi;


  $query = "SELECT A.nama_transaksi, B.table_transaksi, B.table_temporary, B.tipe FROM proses_transaksi_orc A 
  JOIN master_transaksi B ON A.nama_transaksi = B.nama_transaksi 
  WHERE A.id_order = $id_order AND B.tipe = 'pecahan'
   ORDER BY A.urutan";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function mencari_data_di_master_order($id_order)
{
  global $koneksi;


  $query = "SELECT id_style from master_order WHERE id_order = $id_order";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function mencari_data_di_master_bom($id_style)
{
  global $koneksi;


  $query = "SELECT id_bom from master_bom WHERE id_style = $id_style";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function mencari_data_di_master_bom_orc($id_order)
{
  global $koneksi;


  $query = "SELECT A.id_bom_orc, A.id_bom from master_bom_orc A
  JOIN master_order B ON A.id_order = B.id_order
   WHERE A.id_order = $id_order";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function mencari_data_di_master_bom_detail_orc($id_bom_orc)
{
  global $koneksi;


  $query = "SELECT id_bom_detail_orc, id_bom_detail  from master_bom_detail_orc WHERE id_bom_orc = $id_bom_orc";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function mencari_no_trx_temp_part_cutting_id_order($id_order)
{
  global $koneksi;


  $query = "SELECT A.no_trx FROM temp_part_cutting A 
  JOIN order_detail B ON A.id_order_detail = B.id_order_detail
  WHERE id_order = $id_order";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function mencari_no_trx_temp_part_cutting_reject_id_order($id_order)
{
  global $koneksi;


  $query = "SELECT A.no_trx FROM temp_part_cutting_reject A 
  JOIN order_detail B ON A.id_order_detail = B.id_order_detail
  WHERE id_order = $id_order";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function mencari_no_trx_temp_part_cutting()
{
  global $koneksi;


  $query = "SELECT ifnull(max(no_trx),0) no_trx FROM temp_part_cutting";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function mencari_no_trx_temp_part_cutting_reject()
{
  global $koneksi;


  $query = "SELECT ifnull(max(no_trx),0) no_trx FROM temp_part_cutting_reject";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function mencari_no_transaksi_part_cutting()
{
  global $koneksi;


  $query = "SELECT ifnull(max(no_trx),0) no_trx FROM transaksi_part_cutting";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function mencari_no_hd_transaksi_part_cutting()
{
  global $koneksi;


  $query = "SELECT ifnull(max(no_trx),0) no_trx FROM hd_transaksi_part_cutting";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function mencari_no_transaksi_part_cutting_reject()
{
  global $koneksi;


  $query = "SELECT ifnull(max(no_trx),0) no_trx FROM transaksi_part_cutting_reject";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function mencari_data_total_qty_part_cutting($idiod, $idibdp)
{
  global $koneksi;


  $query = "SELECT B.id_transaksi, A.qty_order, IFNULL(SUM(B.qty_total),0) qty_total, IFNULL(SUM(C.total_reject),0) total_reject FROM
  (SELECT C.id_order, F.id_order_detail, A.id_bom_detail_part, F.qty_order  FROM master_bom_detail_part_orc A
      JOIN master_bom_detail_orc B ON A.id_bom_detail_orc = B.id_bom_detail_orc
      JOIN master_bom_orc C ON B.id_bom_orc = C.id_bom_orc
      JOIN order_detail F ON C.id_order = F.id_order)A
  LEFT OUTER JOIN 
  (SELECT A.id_transaksi, A.id_bom_detail_part, A.id_order_detail, SUM(A.qty) qty_total FROM transaksi_part_cutting A
    GROUP BY A.id_order_detail, A.id_bom_detail_part)B
  ON A.id_bom_detail_part = B.id_bom_detail_part AND A.id_order_detail = B.id_order_detail
  LEFT OUTER JOIN 
  (SELECT A.id_transaksi, A.id_bom_detail_part, A.id_order_detail, SUM(A.qty) total_reject FROM transaksi_part_cutting_reject A
    GROUP BY A.id_order_detail, A.id_bom_detail_part)C
  ON A.id_bom_detail_part = C.id_bom_detail_part AND A.id_order_detail = C.id_order_detail
  WHERE A.id_order_detail = $idiod AND A.id_bom_detail_part = $idibdp";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function mencari_nilai_qty_temp_part_cutting($id_order)
{
  global $koneksi;


  $query = "SELECT ifnull(SUM(A.qty),0) qty_total, no_trx FROM temp_part_cutting A 
  JOIN order_detail B ON A.id_order_detail = B.id_order_detail WHERE id_order = $id_order";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function mencari_nilai_qty_temp_part_cutting_reject($id_order)
{
  global $koneksi;


  $query = "SELECT ifnull(SUM(A.qty),0) qty_total FROM temp_part_cutting_reject A 
  JOIN order_detail B ON A.id_order_detail = B.id_order_detail WHERE id_order = $id_order";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_laporan_bundle_record_before_sewing($table, $tgl, $orc, $style, $status, $costomer, $category, $plan_line, $no_po, $color)
{
  global $koneksi;


  $query = "SELECT C.tanggal_max, A.costomer, A.id_order, A.no_po, A.orc, A.style, A.color, A.qty_order, ifnull(B.daily,0) daily,
  ifnull(C.output_total,0) output_total, (ifnull(C.output_total,0) - sum(IFNULL(A.qty_order,0))) balance_order, A.plan_line FROM 
 (SELECT C.id_order, C.orc, D.style, C.color, E.costomer, C.no_po, A.barcode_bundle, A.id_order_detail, 
  sum(A.qty_isi_bundle) qty_order, C.status, F.category, G.plan_line FROM master_bundle A
   JOIN order_detail B ON A.id_order_detail = B.id_order_detail
   JOIN master_order C ON B.id_order = C.id_order
   JOIN style D ON C.id_style = D.id_style
   JOIN costomer E ON C.id_costomer = E.id_costomer
   JOIN items F on D.item = F.item 
   JOIN production_preparation G on B.id_order = G.id_order
   GROUP BY C.id_order) A
   LEFT OUTER JOIN 
   (SELECT A.tanggal, C.id_order, sum(ifnull(A.qty,0)) daily FROM $table A
   JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
   JOIN order_detail C ON B.id_order_detail = C.id_order_detail
   WHERE tanggal = '$tgl' 
   GROUP BY C.id_order)B
   ON A.id_order = B.id_order
    LEFT OUTER JOIN 
   (SELECT max(A.tanggal) tanggal_max, C.id_order, sum(ifnull(A.qty,0)) output_total FROM $table A
   JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
   JOIN order_detail C ON B.id_order_detail = C.id_order_detail
   WHERE tanggal <= '$tgl' 
   GROUP BY C.id_order)C
   ON A.id_order = C.id_order
   JOIN proses_transaksi_orc AB ON A.id_order = AB.id_order
   JOIN master_transaksi AC ON AB.nama_transaksi = AC.nama_transaksi 
   
    WHERE A.orc LIKE '%$orc%' AND A.style LIKE '%$style%' AND AC.table_transaksi = '$table' AND A.status = '$status' 
    AND A.costomer like '%$costomer%' AND A.category LIKE '%$category%' AND A.plan_line LIKE '%$plan_line%'
    AND A.no_po LIKE '%$no_po%' AND A.color LIKE '%$color%'
  GROUP BY A.id_order
  ORDER BY C.tanggal_max desc, B.daily asc
  limit 50
";


  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_laporan_bundle_record_after_sewing($table, $tgl, $orc, $style, $status, $costomer, $category, $jalan_line, $no_po, $color)
{
  global $koneksi;


  $query = "SELECT C.tanggal_max, A.costomer, A.id_order, A.no_po, A.orc, A.style, A.color, A.qty_order, ifnull(B.daily,0) daily,
  ifnull(C.output_total,0) output_total, (ifnull(C.output_total,0) - sum(IFNULL(A.qty_order,0))) balance_order, AD.line  FROM 
 (SELECT C.id_order, C.orc, D.style, C.color, E.costomer, C.no_po, A.barcode_bundle, A.id_order_detail, 
  sum(A.qty_isi_bundle) qty_order, C.status, F.category FROM master_bundle A
   JOIN order_detail B ON A.id_order_detail = B.id_order_detail
   JOIN master_order C ON B.id_order = C.id_order
   JOIN style D ON C.id_style = D.id_style
   JOIN costomer E ON C.id_costomer = E.id_costomer
   JOIN items F on D.item = F.item 
   GROUP BY C.id_order) A
   LEFT OUTER JOIN 
   (SELECT A.tanggal, C.id_order, sum(ifnull(A.qty,0)) daily FROM $table A
   JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
   JOIN order_detail C ON B.id_order_detail = C.id_order_detail
   WHERE tanggal = '$tgl' 
   GROUP BY C.id_order)B
   ON A.id_order = B.id_order
    LEFT OUTER JOIN 
   (SELECT max(A.tanggal) tanggal_max, C.id_order, sum(ifnull(A.qty,0)) output_total FROM $table A
   JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
   JOIN order_detail C ON B.id_order_detail = C.id_order_detail
   WHERE tanggal <= '$tgl' 
   GROUP BY C.id_order)C
   ON A.id_order = C.id_order
   JOIN proses_transaksi_orc AB ON A.id_order = AB.id_order
   JOIN master_transaksi AC ON AB.nama_transaksi = AC.nama_transaksi 
   LEFT OUTER JOIN
    (SELECT C.id_order, IFNULL(A.line, '') line FROM transaksi_sewing A
    JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
    JOIN order_detail C ON B.id_order_detail = C.id_order_detail
    GROUP BY C.id_order)AD
   ON A.id_order = AD.id_order
    WHERE A.orc LIKE '%$orc%' AND A.style LIKE '%$style%' AND AC.table_transaksi = '$table' AND A.status = '$status' 
    AND A.costomer like '%$costomer%' AND A.category LIKE '%$category%' AND AD.line LIKE '%$jalan_line%'
    AND A.no_po LIKE '%$no_po%' AND A.color LIKE '%$color%'
  GROUP BY A.id_order
  ORDER BY C.tanggal_max desc, B.daily asc
  limit 50
";


  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_laporan_bundle_record_global_detail($table, $tgl, $id_order)
{
  global $koneksi;


  $query = "SELECT A.id_order_detail, IFNULL(C.tanggal_min, 'blm_proses') tanggal_min, IFNULL(C.tanggal_max, 'blm_proses') tanggal_max, A.id_order, A.orc, A.size, A.cup, sum(IFNULL(A.qty_isi_bundle,0)) qty_order, ifnull(B.daily,0) daily,
  ifnull(C.output_total,0) output_total, (ifnull(C.output_total,0) - sum(IFNULL(A.qty_isi_bundle,0))) balance_order FROM 
 (SELECT C.id_order, C.orc, A.barcode_bundle, A.id_order_detail, A.qty_isi_bundle, C.status,
   B.size, B.cup FROM master_bundle A
   JOIN order_detail B ON A.id_order_detail = B.id_order_detail
   JOIN master_order C ON B.id_order = C.id_order
   ) A
   LEFT OUTER JOIN 
   (SELECT A.tanggal, B.id_order_detail, sum(ifnull(A.qty,0)) daily FROM $table A
   JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
   JOIN order_detail C ON B.id_order_detail = C.id_order_detail
   WHERE tanggal = '$tgl' 
   GROUP BY B.id_order_detail)B
   ON A.id_order_detail = B.id_order_detail
    LEFT OUTER JOIN 
   (SELECT max(A.tanggal) tanggal_max, min(A.tanggal) tanggal_min, B.id_order_detail, sum(ifnull(A.qty,0)) output_total FROM $table A
   JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
   JOIN order_detail C ON B.id_order_detail = C.id_order_detail
   WHERE tanggal <= '$tgl' 
   GROUP BY B.id_order_detail)C
   ON A.id_order_detail = C.id_order_detail
   WHERE A.id_order = $id_order
    GROUP BY A.id_order_detail
    order by A.id_order_detail ASC
    limit 150
";


  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_laporan_bundle_record_tv($table, $tgl, $orc, $style, $status, $costomer, $category, $plan_line, $jalan_line, $lantai)
{
  global $koneksi;


  $query = "SELECT C.tanggal_max, A.costomer, A.id_order, A.no_po, A.orc, A.style, A.color, sum(IFNULL(A.qty_isi_bundle,0)) qty_order, ifnull(B.daily,0) daily,
  ifnull(C.output_total,0) output_total, (ifnull(C.output_total,0) - sum(IFNULL(A.qty_isi_bundle,0))) balance_order, A.plan_line, A.line  FROM 
 (SELECT C.id_order, C.orc, D.style, C.color, E.costomer, C.no_po, A.barcode_bundle, A.id_order_detail, 
  A.qty_isi_bundle, C.status, F.category, G.plan_line, IFNULL(H.line, '') line  FROM master_bundle A
   JOIN order_detail B ON A.id_order_detail = B.id_order_detail
   JOIN master_order C ON B.id_order = C.id_order
   JOIN style D ON C.id_style = D.id_style
   JOIN costomer E ON C.id_costomer = E.id_costomer
   JOIN items F on D.item = F.item 
   JOIN production_preparation G on B.id_order = G.id_order 
   LEFT OUTER JOIN transaksi_sewing H ON A.barcode_bundle = H.kode_barcode) A
   LEFT OUTER JOIN 
   (SELECT A.tanggal, C.id_order, sum(ifnull(A.qty,0)) daily FROM $table A
   JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
   JOIN order_detail C ON B.id_order_detail = C.id_order_detail
   WHERE tanggal = '$tgl' 
   GROUP BY C.id_order)B
   ON A.id_order = B.id_order
    LEFT OUTER JOIN 
   (SELECT max(A.tanggal) tanggal_max, C.id_order, sum(ifnull(A.qty,0)) output_total FROM $table A
   JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
   JOIN order_detail C ON B.id_order_detail = C.id_order_detail
   WHERE tanggal <= '$tgl' 
   GROUP BY C.id_order)C
   ON A.id_order = C.id_order
   JOIN proses_transaksi_orc AB ON A.id_order = AB.id_order
   JOIN master_transaksi AC ON AB.nama_transaksi = AC.nama_transaksi 
   LEFT OUTER JOIN master_line AD ON A.line = AD.nama_line
    WHERE A.orc LIKE '%$orc%' AND A.style LIKE '%$style%' AND AC.table_transaksi = '$table' AND A.status = '$status' 
    AND A.costomer like '%$costomer%' AND A.category LIKE '%$category%' AND A.plan_line LIKE '%$plan_line%' AND A.line LIKE '%$jalan_line%'
    AND AD.line like '%$lantai%'
  GROUP BY A.id_order
  ORDER BY C.tanggal_max desc, B.daily asc
";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}



function tampilkan_laporan_bundle_record_perjam($table, $tgl, $orc, $style, $status, $costomer, $category, $plan_line, $jalan_line)
{
  global $koneksi;


  $query = "SELECT C.tanggal_max, A.costomer, A.id_order, A.no_po, A.orc, A.style, A.color, A.qty_order, ifnull(B.daily,0) daily,
  ifnull(C.output_total,0) output_total, (ifnull(C.output_total,0) - sum(IFNULL(A.qty_order,0))) balance_order,
  ifnull(B.jam_8, 0) jam_8, ifnull(B.jam_9, 0) jam_9, ifnull(B.jam_10, 0) jam_10, ifnull(B.jam_11, 0) jam_11, ifnull(B.jam_11, 0) jam_11,
  ifnull(B.jam_12, 0) jam_12, ifnull(B.jam_13, 0) jam_13, ifnull(B.jam_14,0) jam_14, ifnull(B.jam_15, 0) jam_15, ifnull(B.jam_16, 0) jam_16,
  ifnull(B.jam_17, 0) jam_17, ifnull(B.jam_18,0) jam_18, ifnull(B.jam_19, 0) jam_19, ifnull(B.jam_20, 0) jam_20, ifnull(B.jam_21, 0) jam_21,
   ifnull(B.jam_22, 0) jam_22, ifnull(B.jam_23, 0) jam_23,
   A.plan_line, IFNULL(D.line, '') line  FROM 
 (SELECT C.id_order, C.orc, D.style, C.color, E.costomer, C.no_po, A.barcode_bundle, A.id_order_detail, 
  sum(A.qty_isi_bundle) qty_order, C.status, F.category, G.plan_line  FROM master_bundle A
   JOIN order_detail B ON A.id_order_detail = B.id_order_detail
   JOIN master_order C ON B.id_order = C.id_order
   JOIN style D ON C.id_style = D.id_style
   JOIN costomer E ON C.id_costomer = E.id_costomer
   JOIN items F on D.item = F.item 
   JOIN production_preparation G on B.id_order = G.id_order
   GROUP BY C.id_order ) A
   LEFT OUTER JOIN 
   (SELECT A.tanggal, C.id_order, sum(ifnull(A.qty,0)) daily, 
    sum(IF(A.jam BETWEEN '07:00:01' AND '08:05:00' , A.qty ,0)) as jam_8,
    sum(IF(A.jam BETWEEN '08:05:01' AND '09:05:00', A.qty ,0)) as jam_9,
    sum(IF(A.jam BETWEEN '09:05:01' AND '10:05:00' , A.qty ,0)) as jam_10,
    sum(IF(A.jam BETWEEN '10:05:01' AND '11:05:00' , A.qty ,0)) as jam_11,
    sum(IF(A.jam BETWEEN '11:05:01' AND '12:05:00', A.qty ,0)) as jam_12,
    sum(IF(A.jam BETWEEN '12:05:01' AND '13:05:00', A.qty ,0)) as jam_13,
    sum(IF(A.jam BETWEEN '13:05:01' AND '14:05:00', A.qty ,0)) as jam_14,
    sum(IF(A.jam BETWEEN '14:05:01' AND '15:05:00', A.qty ,0)) as jam_15,
    sum(IF(A.jam BETWEEN '15:05:01' AND '16:05:00', A.qty ,0)) as jam_16,
    sum(IF(A.jam BETWEEN '16:05:01' AND '17:05:00', A.qty ,0)) as jam_17,
    sum(IF(A.jam BETWEEN '17:05:01' AND '18:05:00', A.qty ,0)) as jam_18,
    sum(IF(A.jam BETWEEN '18:05:01' AND '19:05:00', A.qty ,0)) as jam_19,
    sum(IF(A.jam BETWEEN '19:05:01' AND '20:05:00', A.qty ,0)) as jam_20,
    sum(IF(A.jam BETWEEN '20:05:01' AND '21:05:00', A.qty ,0)) as jam_21,
    sum(IF(A.jam BETWEEN '21:05:01' AND '22:05:00', A.qty ,0)) as jam_22,
    sum(IF(A.jam BETWEEN '22:05:01' AND '23:05:00', A.qty ,0)) as jam_23 FROM $table A
   JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
   JOIN order_detail C ON B.id_order_detail = C.id_order_detail
   WHERE A.tanggal = '$tgl' 
   GROUP BY C.id_order)B
   ON A.id_order = B.id_order
    LEFT OUTER JOIN 
   (SELECT max(A.tanggal) tanggal_max, C.id_order, sum(ifnull(A.qty,0)) output_total FROM $table A
   JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
   JOIN order_detail C ON B.id_order_detail = C.id_order_detail
   WHERE A.tanggal <= '$tgl' 
   GROUP BY C.id_order)C
   ON A.id_order = C.id_order
   LEFT OUTER JOIN 
   (SELECT  IFNULL(A.line, '') line, C.id_order FROM transaksi_qc_endline A
   JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
   JOIN order_detail C ON B.id_order_detail = C.id_order_detail
   WHERE A.tanggal <= '$tgl' 
   GROUP BY C.id_order)D
   ON A.id_order = D.id_order
   JOIN proses_transaksi_orc AB ON A.id_order = AB.id_order
   JOIN master_transaksi AC ON AB.nama_transaksi = AC.nama_transaksi";
  if ($jalan_line == '') {
    $query .= " WHERE A.orc LIKE '%$orc%' AND A.style LIKE '%$style%' AND AC.table_transaksi = '$table' AND A.status = '$status' 
    AND A.costomer like '%$costomer%' AND A.category LIKE '%$category%' AND A.plan_line LIKE '%$plan_line%' AND IFNULL(D.line, '') LIKE '%$jalan_line%'";
  } else {
    $query .= " WHERE A.orc LIKE '%$orc%' AND A.style LIKE '%$style%' AND AC.table_transaksi = '$table' AND A.status = '$status' 
    AND A.costomer like '%$costomer%' AND A.category LIKE '%$category%' AND A.plan_line LIKE '%$plan_line%' AND IFNULL(D.line, '') = '$jalan_line'";
  }
  $query .= " GROUP BY A.id_order
  ORDER BY C.tanggal_max desc, B.daily asc
  limit 100";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_laporan_bundle_record_perjam_qc_endline($tgl, $orc, $style, $status, $costomer, $category, $line)
{
  global $koneksi;


  $query = "SELECT A.id_order, B.id, A.orc, A.style, A.color, B.nilai_smv, IFNULL(B.line,'') line_target, IFNULL(E.line, '') line_qc,
 B.man_power, A.item,  A.costomer, A.no_po, IFNULL(A.qty_order,0) qty_order, IFNULL(B.persentase_target,0) persentase,  IFNULL(B.target_jam, 0) target_jam,
 IFNULL(B.target_100, 0) target_100, IFNULL(B.target_80, 0) target_80,
 IFNULL(C.jam_8, 0) jam_8, IFNULL(C.jam_9, 0) jam_9, IFNULL(C.jam_10, 0) jam_10,  IFNULL(C.jam_11, 0) jam_11,
  IFNULL(C.jam_12, 0) jam_12, IFNULL(C.jam_13, 0) jam_13, IFNULL(C.jam_14, 0) jam_14, IFNULL(C.jam_15, 0) jam_15, 
  IFNULL(C.jam_16, 0) jam_16, IFNULL(C.jam_17, 0) jam_17, IFNULL(C.jam_18, 0) jam_18, IFNULL(C.jam_19, 0) jam_19,
   IFNULL(C.jam_20, 0) jam_20, IFNULL(C.jam_21, 0) jam_21, IFNULL(C.jam_22, 0) jam_22, IFNULL(C.jam_23, 0) jam_23,  
   IFNULL(B.target_days, 0) target_days, IFNULL(C.daily, 0) daily, IFNULL(E.total, 0) output_total, B.jml_jam_normal, IFNULL(B.jml_lembur, 0) jml_lembur,
   IFNULL(B.man_power_lembur, 0) man_power_lembur,
   (IFNULL(F.total_gabungan, 0)-IFNULL(A.qty_order,0)) balance_order, B.remaks, ROUND(IFNULL(B.nilai_smv,0)*IFNULL(C.daily,0)/60,0) sah,
    IFNULL(B.target_days_lembur, 0) target_days_lembur, ROUND(IFNULL(B.nilai_smv,0)*IFNULL(C.daily,0)/60/IFNULL(B.total_mah,0)*100,2) efficiency,
    (IFNULL(B.target_days, 0)+IFNULL(B.target_days_lembur, 0)) total_target,  IFNULL(total_mah,0) total_mah FROM 
(SELECT C.id_order, C.orc, D.style, C.color, E.costomer, C.no_po, D.item, A.barcode_bundle, A.id_order_detail, 
sum(A.qty_isi_bundle) qty_order, C.status, F.category FROM master_bundle A
JOIN order_detail B ON A.id_order_detail = B.id_order_detail
JOIN master_order C ON B.id_order = C.id_order
JOIN style D ON C.id_style = D.id_style
JOIN costomer E ON C.id_costomer = E.id_costomer
JOIN items F on D.item = F.item
GROUP BY C.id_order) A
LEFT OUTER JOIN
(SELECT id, id_order, date_target, nilai_smv, persentase_target, line, man_power, jml_jam_normal, jml_lembur, man_power_lembur,
 IFNULL(ROUND(((60/nilai_smv)*man_power*(persentase_target/100)),0), 0) target_jam, 
 IFNULL(ROUND(((60/nilai_smv)*man_power*(100/100)),0), 0) target_100,
 IFNULL(ROUND(((60/nilai_smv)*man_power*(80/100)),0), 0) target_80, 
 (ROUND(((60/nilai_smv)*man_power*(persentase_target/100)),0) * jml_jam_normal) target_days,
 (ROUND(((60/nilai_smv)*man_power_lembur*(persentase_target/100)),0) * jml_lembur) target_days_lembur,
 remaks, ((man_power*jml_jam_normal)+(IFNULL(man_power_lembur, 0)*IFNULL(jml_lembur, 0))) total_mah
FROM master_target WHERE date_target = '$tgl')B
ON A.id_order = B.id_order
LEFT OUTER JOIN
(SELECT A.tanggal, C.id_order, sum(ifnull(A.qty,0)) daily, 
sum(IF(A.jam BETWEEN '07:00:01' AND '08:05:00' , A.qty ,0)) as jam_8,
sum(IF(A.jam BETWEEN '08:05:01' AND '09:05:00', A.qty ,0)) as jam_9,
sum(IF(A.jam BETWEEN '09:05:01' AND '10:05:00' , A.qty ,0)) as jam_10,
sum(IF(A.jam BETWEEN '10:05:01' AND '11:05:00' , A.qty ,0)) as jam_11,
sum(IF(A.jam BETWEEN '11:05:01' AND '12:05:00', A.qty ,0)) as jam_12,
sum(IF(A.jam BETWEEN '12:05:01' AND '13:05:00', A.qty ,0)) as jam_13,
sum(IF(A.jam BETWEEN '13:05:01' AND '14:05:00', A.qty ,0)) as jam_14,
sum(IF(A.jam BETWEEN '14:05:01' AND '15:05:00', A.qty ,0)) as jam_15,
sum(IF(A.jam BETWEEN '15:05:01' AND '16:05:00', A.qty ,0)) as jam_16,
sum(IF(A.jam BETWEEN '16:05:01' AND '17:05:00', A.qty ,0)) as jam_17,
sum(IF(A.jam BETWEEN '17:05:01' AND '18:05:00', A.qty ,0)) as jam_18,
sum(IF(A.jam BETWEEN '18:05:01' AND '19:05:00', A.qty ,0)) as jam_19,
sum(IF(A.jam BETWEEN '19:05:01' AND '20:05:00', A.qty ,0)) as jam_20,
sum(IF(A.jam BETWEEN '20:05:01' AND '21:05:00', A.qty ,0)) as jam_21,
sum(IF(A.jam BETWEEN '21:05:01' AND '22:05:00', A.qty ,0)) as jam_22,
sum(IF(A.jam BETWEEN '22:05:01' AND '23:05:00', A.qty ,0)) as jam_23, 
ifnull(A.line, '') line  FROM transaksi_qc_endline A
JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
JOIN order_detail C ON B.id_order_detail = C.id_order_detail
WHERE A.tanggal = '$tgl' 
GROUP BY C.id_order, A.line)C
ON B.id_order = C.id_order AND B.date_target = C.tanggal AND B.line = C.line 
LEFT OUTER JOIN
(SELECT id, id_order, line FROM master_target GROUP BY id_order, line)D
ON A.id_order = D.id_order AND B.line = D.line  
LEFT OUTER JOIN
(SELECT A.tanggal, C.id_order, sum(ifnull(A.qty,0)) total, ifnull(A.line, '') line 
 FROM transaksi_qc_endline A
JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
JOIN order_detail C ON B.id_order_detail = C.id_order_detail
WHERE A.tanggal <= '$tgl' 
GROUP BY C.id_order, A.line)E
ON D.id_order = E.id_order AND D.line = E.line
LEFT OUTER JOIN
(SELECT C.id_order, sum(ifnull(A.qty,0)) total_gabungan
 FROM transaksi_qc_endline A
JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
JOIN order_detail C ON B.id_order_detail = C.id_order_detail
WHERE A.tanggal <= '$tgl' 
GROUP BY C.id_order)F
ON D.id_order = F.id_order
JOIN proses_transaksi_orc AB ON A.id_order = AB.id_order";
  if ($line == '') {
    $query .= " WHERE A.orc LIKE '%$orc%' AND A.style LIKE '%$style%' AND AB.nama_transaksi = 'qc_endline' AND A.status = '$status' 
    AND A.costomer like '%$costomer%' AND A.category LIKE '%$category%' AND IFNULL(E.line, '') LIKE '%$line%'";
  } else {
    $query .= " WHERE A.orc LIKE '%$orc%' AND A.style LIKE '%$style%' AND AB.nama_transaksi = 'qc_endline' AND A.status = '$status' 
    AND A.costomer like '%$costomer%' AND A.category LIKE '%$category%' AND IFNULL(E.line, '') = '$line'";
  }
  $query .= " GROUP BY A.id_order, B.line
  ORDER BY IFNULL(B.line, '') desc limit 50";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_laporan_reminder_qc_endline_all($tanggal, $waktu_awal, $waktu_akhir, $target, $lantai, $line, $costomer, $no_po, $orc, $style, $checkstyle)
{
  global $koneksi;


  $query = "SELECT A.date_target, A.item, A.orc,  A.style, A.color, A.no_po, A.costomer, A.id_order, A.lantai, A.line, 
  IFNULL(A.target_jam, 0) target_jam, A.jml_jam_normal,
  IFNULL(B.total_output, 0) total_output, (IFNULL(B.total_output, 0)-IFNULL(A.target_jam, 0)) balance_target 
  FROM 
  (SELECT A.date_target, D.item, B.orc, D.style, B.color, B.no_po, A.jml_jam_normal, E.costomer, A.id_order, C.lantai, A.line, 
   ROUND(((60/A.nilai_smv)*A.man_power*(A.persentase_target/100)),0) target_jam  
  FROM master_target A 
  JOIN master_order B ON A.id_order = B.id_order
  JOIN master_line C ON A.line = C.nama_line
  JOIN style D ON B.id_style = D.id_style
  JOIN costomer E ON B.id_costomer = E.id_costomer
  WHERE A.date_target = '$tanggal' AND C.lantai = $lantai
   GROUP BY A.date_target, A.id_order, A.line) A
  LEFT OUTER JOIN 
  (SELECT C.id_order, SUM(A.qty) total_output  FROM transaksi_qc_endline A 
  JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle 
  JOIN order_detail C ON B.id_order_detail = C.id_order_detail
  WHERE A.tanggal = '$tanggal' AND A.jam BETWEEN '$waktu_awal' AND '$waktu_akhir' ";
  $query .= " GROUP BY C.id_order)B
  ON A.id_order = B.id_order
  WHERE A.costomer like '%$costomer%' AND A.lantai = $lantai AND A.no_po like '%$no_po%' AND A.orc like '%$orc%'";
  if ($target == 'tidak') {
    $query .= " AND IFNULL(B.total_output, 0) < (IFNULL(A.target_jam, 0))";
  } else {
    $query .= " AND IFNULL(B.total_output, 0) >= (IFNULL(A.target_jam, 0))";
  }
  if ($line != 'all') {
    $query .= " AND A.line = '$line'";
  }
  if ($checkstyle == 'iya') {
    $query .= " AND A.style = '$style'";
  } else {
    $query .= " AND A.style LIKE '%$style%'";
  }

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_laporan_bundle_record_allproses($tgl, $orc, $style, $status, $costomer, $jalan_line, $no_po, $color)
{
  global $koneksi;

  $query = "SELECT A.costomer, A.id_order, A.no_po, A.orc, A.style, A.color, A.qty_order, IFNULL(B.daily,0) cutting_daily, IFNULL(B.total,0) cutting_total, (IFNULL(B.total,0) -  A.qty_order) cutting_balance, 
      IFNULL((B.total - H.total), 0) ready_trimstore,
      -- IFNULL(C.daily,0) qc_cutpart_daily, IFNULL(C.total,0) qc_cutpart_total, (IFNULL(C.total,0) - sum(IFNULL(A.qty_isi_bundle,0))) qc_cutpart_balance, 
      -- IFNULL(D.daily,0) press_daily, IFNULL(D.total,0) press_total, (IFNULL(D.total,0) - sum(IFNULL(A.qty_isi_bundle,0))) press_balance,
      --  IFNULL(E.daily,0) bemis_daily, IFNULL(E.total,0) bemis_total, (IFNULL(E.total,0) - sum(IFNULL(A.qty_isi_bundle,0))) bemis_balance, 
      --  IFNULL(E2.daily,0) moulding_daily, IFNULL(E2.total,0) moulding_total, (IFNULL(E2.total,0) - sum(IFNULL(A.qty_isi_bundle,0))) moulding_balance, 
      --   IFNULL(F.daily,0) preparation_daily, IFNULL(F.total,0) preparation_total, (IFNULL(F.total,0) - sum(IFNULL(A.qty_isi_bundle,0))) preparation_balance, 
      --   IFNULL(G.daily,0) ht_daily, IFNULL(G.total,0) ht_total, (IFNULL(G.total,0) - sum(IFNULL(A.qty_isi_bundle,0))) ht_balance, 
     IFNULL(H.daily,0) trimstore_daily, IFNULL(H.total,0) trimstore_total, (IFNULL(H.total,0) -  A.qty_order) trimstore_balance, 
     IFNULL((H.total - I.total),0) ready_sewing,
     IFNULL(I.daily,0) sewing_daily, IFNULL(I.total,0) sewing_total, (IFNULL(I.total,0) -  A.qty_order) sewing_balance,   
     IFNULL((I.total - J.total),0) ready_qc_endline,
     IFNULL(J.daily,0) qc_endline_daily, IFNULL(J.total,0) qc_endline_total, (IFNULL(J.total,0) -  A.qty_order) qc_endline_balance,
    --  IFNULL(K.daily,0) iron_daily, IFNULL(K.total,0) iron_total, (IFNULL(K.total,0) - sum(IFNULL(A.qty_isi_bundle,0))) iron_balance,
    --  IFNULL(L.daily,0) qc_kensa_daily, IFNULL(L.total,0) qc_kensa_total, (IFNULL(L.total,0) - sum(IFNULL(A.qty_isi_bundle,0))) qc_kensa_balance,
    --  IFNULL(O.daily,0) kenzin_daily, IFNULL(O.total,0) kenzin_total, (IFNULL(O.total,0) - sum(IFNULL(A.qty_isi_bundle,0))) kenzin_balance,
    -- IFNULL(P.daily,0) qc_buyer_daily, IFNULL(P.total,0) qc_buyer_total, (IFNULL(P.total,0) -  A.qty_order) qc_buyer_balance,
    -- IFNULL((J.total - N.total),0) ready_qc_transfer,
    -- IFNULL(N.daily,0) qc_transfer_daily, IFNULL(N.total,0) qc_transfer_total, (IFNULL(N.total,0) -  A.qty_order) qc_transfer_balance,
    -- IFNULL(R.daily,0) tatami_out_daily, IFNULL(R.total,0) tatami_out_total, (IFNULL(R.total,0) - A.qty_order) tatami_out_balance,
    -- IFNULL(Q.daily,0) packing_bun_daily, IFNULL(Q.total,0) packing_bun_total, (IFNULL(Q.total,0) -  A.qty_order) packing_bun_balance,
    -- IFNULL(O.daily,0) packing_bun_daily, IFNULL(O.total,0) packing_bun_total, (IFNULL(O.total,0) -  A.qty_order) packing_bun_balance,
    IFNULL(O.daily,0) tatami_out_daily, IFNULL(O.total,0) tatami_out_total, (IFNULL(O.total,0) -  A.qty_order) tatami_out_balance,
    -- IFNULL(J.line, 'not_yet') line 
    A.plan_line as line
       FROM 
      (SELECT C.id_order, C.orc, D.style, C.color, E.costomer, C.no_po, A.barcode_bundle, A.id_order_detail, 
       sum(A.qty_isi_bundle) qty_order, C.status, F.category,  C.id_costomer, G.plan_line FROM master_bundle A
        JOIN order_detail B ON A.id_order_detail = B.id_order_detail
        JOIN master_order C ON B.id_order = C.id_order
        JOIN style D ON C.id_style = D.id_style
        JOIN costomer E ON C.id_costomer = E.id_costomer
        JOIN items F on D.item = F.item 
        JOIN production_preparation G on C.id_order = G.id_order
        GROUP BY C.id_order
       ) A
        
       LEFT OUTER JOIN 
        (SELECT max(A.tanggal) tanggal_max, C.id_order, sum(if(A.tanggal='$tgl', A.qty, 0)) daily, sum(if(A.tanggal<='$tgl', A.qty, 0)) total 
        FROM transaksi_cutting A
        JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
        JOIN order_detail C ON B.id_order_detail = C.id_order_detail
        WHERE tanggal <= '$tgl' 
        GROUP BY C.id_order)B
        ON A.id_order = B.id_order 
        -- LEFT OUTER JOIN 
        -- (SELECT max(A.tanggal) tanggal_max, C.id_order, sum(if(A.tanggal='$tgl', A.qty, 0)) daily, sum(if(A.tanggal<='$tgl', A.qty, 0)) total 
        -- FROM transaksi_qc_cutpart A
        -- JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
        -- JOIN order_detail C ON B.id_order_detail = C.id_order_detail
        -- WHERE tanggal <= '$tgl' 
        -- GROUP BY C.id_order)C
        -- ON A.id_order = C.id_order 
     
    --  LEFT OUTER JOIN 
    --     (SELECT max(A.tanggal) tanggal_max, C.id_order, sum(if(A.tanggal='$tgl', A.qty, 0)) daily, sum(if(A.tanggal<='$tgl', A.qty, 0)) total FROM transaksi_press A
    --     JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
    --     JOIN order_detail C ON B.id_order_detail = C.id_order_detail
    --     WHERE tanggal <= '$tgl' 
    --     GROUP BY C.id_order)D
    --     ON A.id_order = D.id_order 
     
    --  LEFT OUTER JOIN 
    --     (SELECT max(A.tanggal) tanggal_max, C.id_order, sum(if(A.tanggal='$tgl', A.qty, 0)) daily, sum(if(A.tanggal<='$tgl', A.qty, 0)) total FROM transaksi_bemis A
    --     JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
    --     JOIN order_detail C ON B.id_order_detail = C.id_order_detail
    --     WHERE tanggal <= '$tgl' 
    --     GROUP BY C.id_order)E
    --     ON A.id_order = E.id_order
    
    -- LEFT OUTER JOIN 
    --     (SELECT max(A.tanggal) tanggal_max, C.id_order, sum(if(A.tanggal='$tgl', A.qty, 0)) daily, sum(if(A.tanggal<='$tgl', A.qty, 0)) total FROM transaksi_moulding A
    --     JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
    --     JOIN order_detail C ON B.id_order_detail = C.id_order_detail
    --     WHERE tanggal <= '$tgl' 
    --     GROUP BY C.id_order)E2
    --     ON A.id_order = E2.id_order     
        
    --  LEFT OUTER JOIN 
    --     (SELECT max(A.tanggal) tanggal_max, C.id_order, sum(if(A.tanggal='$tgl', A.qty, 0)) daily, sum(if(A.tanggal<='$tgl', A.qty, 0)) total FROM transaksi_preparation A
    --     JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
    --     JOIN order_detail C ON B.id_order_detail = C.id_order_detail
    --     WHERE tanggal <= '$tgl' 
    --     GROUP BY C.id_order)F
    --     ON A.id_order = F.id_order 
     
    --  LEFT OUTER JOIN 
    --     (SELECT max(A.tanggal) tanggal_max, C.id_order, sum(if(A.tanggal='$tgl', A.qty, 0)) daily, sum(if(A.tanggal<='$tgl', A.qty, 0)) total FROM transaksi_ht A
    --     JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
    --     JOIN order_detail C ON B.id_order_detail = C.id_order_detail
    --     WHERE tanggal <= '$tgl' 
    --     GROUP BY C.id_order)G
    --     ON A.id_order = G.id_order    
       
     LEFT OUTER JOIN 
        (SELECT max(A.tanggal) tanggal_max, C.id_order, sum(if(A.tanggal='$tgl', A.qty, 0)) daily, sum(if(A.tanggal<='$tgl', A.qty, 0)) total FROM transaksi_trimstore A
        JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
        JOIN order_detail C ON B.id_order_detail = C.id_order_detail
        WHERE tanggal <= '$tgl' 
        GROUP BY C.id_order)H
        ON A.id_order = H.id_order 
       
       LEFT OUTER JOIN 
        (SELECT max(A.tanggal) tanggal_max, C.id_order, sum(if(A.tanggal='$tgl', A.qty, 0)) daily, sum(if(A.tanggal<='$tgl', A.qty, 0)) total 
        FROM transaksi_sewing A
        JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
        JOIN order_detail C ON B.id_order_detail = C.id_order_detail
        WHERE tanggal <= '$tgl' 
        GROUP BY C.id_order)I
        ON A.id_order = I.id_order

      LEFT OUTER JOIN 
       (SELECT max(A.tanggal) tanggal_max, IFNULL(A.line, 'not_yet') line, A.tanggal, C.id_order, sum(if(A.tanggal='$tgl', A.qty, 0)) daily, sum(if(A.tanggal<='$tgl', A.qty, 0)) total
        FROM transaksi_qc_endline A
       JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
       JOIN order_detail C ON B.id_order_detail = C.id_order_detail
       WHERE tanggal <= '$tgl' 
       GROUP BY C.id_order)J
       ON A.id_order = J.id_order

      --  LEFT OUTER JOIN 
      --    (SELECT max(A.tanggal) tanggal_max, A.tanggal, C.id_order, sum(if(A.tanggal='$tgl', A.qty, 0)) daily, sum(if(A.tanggal<='$tgl', A.qty, 0)) total
      --     FROM transaksi_qc_transfer A
      --      JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
      --     JOIN order_detail C ON B.id_order_detail = C.id_order_detail
      --     WHERE tanggal <= '$tgl' 
      --     GROUP BY C.id_order)N
      --     ON A.id_order = N.id_order

      --  LEFT OUTER JOIN 
      --    (SELECT max(A.tanggal) tanggal_max, A.tanggal, C.id_order, sum(if(A.tanggal='$tgl', A.qty, 0)) daily, sum(if(A.tanggal<='$tgl', A.qty, 0)) total
      --     FROM transaksi_packing A
      --      JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
      --     JOIN order_detail C ON B.id_order_detail = C.id_order_detail
      --     WHERE tanggal <= '$tgl' 
      --     GROUP BY C.id_order)O          
      --    ON A.id_order = O.id_order

       LEFT OUTER JOIN 
         (SELECT max(A.tanggal) tanggal_max, A.tanggal, C.id_order, sum(if(A.tanggal='$tgl', A.qty, 0)) daily, sum(if(A.tanggal<='$tgl', A.qty, 0)) total
          FROM transaksi_tatami A
           JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
          JOIN order_detail C ON B.id_order_detail = C.id_order_detail
          WHERE tanggal <= '$tgl' 
          GROUP BY C.id_order)O          
         ON A.id_order = O.id_order
         
         WHERE A.orc LIKE '%$orc%' AND A.style LIKE '%$style%' AND A.status = '$status' 
  -- AND IFNULL(J.line, 'not_yet') LIKE '%$jalan_line%'
      AND A.plan_line LIKE '%$jalan_line%'
       AND A.no_po LIKE '%$no_po%'
      AND A.color LIKE '%$color%' ";
  if ($costomer != 0) {
  // if ($costomer > 0) {
    $query .= " AND A.id_costomer = $costomer";
  }
  $query .= " GROUP BY A.id_order
      order by B.daily desc, H.daily desc, I.daily desc, J.tanggal_max desc
      limit 1000";

  // var_dump($query);
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  // print_r($result);

  return $result;
}



function tampilkan_laporan_bundle_record_detail_size_old($table, $tgl, $orc, $style, $status, $costomer, $category, $jalan_line, $plan_line, $no_po, $color, $checkstyle)
{
  global $koneksi;


  $query = "SELECT C.tanggal_max, A.costomer, A.no_po, A.orc, A.style, A.color, A.size, A.cup, sum(IFNULL(A.qty_isi_bundle,0)) qty_order, ifnull(B.daily,0) daily,
  ifnull(C.output_total,0) output_total, (ifnull(C.output_total,0) - sum(IFNULL(A.qty_isi_bundle,0))) balance_order, AD.line, A.plan_line FROM 
 (SELECT C.id_order, C.orc, D.style, C.color, E.costomer, C.no_po, A.barcode_bundle, A.id_order_detail, A.qty_isi_bundle, C.status, F.category,
   B.size, B.cup, G.plan_line FROM master_bundle A
   JOIN order_detail B ON A.id_order_detail = B.id_order_detail
   JOIN master_order C ON B.id_order = C.id_order
   JOIN style D ON C.id_style = D.id_style
   JOIN costomer E ON C.id_costomer = E.id_costomer
   JOIN items F on D.item = F.item
   JOIN production_preparation G on B.id_order = G.id_order) A
   LEFT OUTER JOIN 
   (SELECT A.tanggal, B.id_order_detail, sum(ifnull(A.qty,0)) daily FROM $table A
   JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
   JOIN order_detail C ON B.id_order_detail = C.id_order_detail
   WHERE tanggal = '$tgl' 
   GROUP BY B.id_order_detail)B
   ON A.id_order_detail = B.id_order_detail
    LEFT OUTER JOIN 
   (SELECT max(A.tanggal) tanggal_max, B.id_order_detail, sum(ifnull(A.qty,0)) output_total FROM $table A
   JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
   JOIN order_detail C ON B.id_order_detail = C.id_order_detail
   WHERE tanggal <= '$tgl' 
   GROUP BY B.id_order_detail)C
   ON A.id_order_detail = C.id_order_detail
   JOIN proses_transaksi_orc AB ON A.id_order = AB.id_order
   JOIN master_transaksi AC ON AB.nama_transaksi = AC.nama_transaksi 
   LEFT OUTER JOIN
    (SELECT C.id_order, IFNULL(A.line, '') line FROM transaksi_qc_endline A
    JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
    JOIN order_detail C on B.id_order_detail = C.id_order_detail
    GROUP BY C.id_order)AD
    ON A.id_order = AD.id_order";
  if ($checkstyle == "iya") {
    if ($jalan_line == "") {
      $query .= " WHERE A.orc LIKE '%$orc%' AND A.style = '$style' AND AC.table_transaksi = '$table' AND A.status = '$status' 
      AND A.costomer like '%$costomer%' AND A.category LIKE '%$category%' AND AD.line LIKE '%$jalan_line%' AND A.plan_line LIKE '%$plan_line%'
      AND A.no_po LIKE '%$no_po%' AND A.color LIKE '%$color%'";
    } else {
      $query .= " WHERE A.orc LIKE '%$orc%' AND A.style = '$style' AND AC.table_transaksi = '$table' AND A.status = '$status' 
      AND A.costomer like '%$costomer%' AND A.category LIKE '%$category%' AND AD.line = '$jalan_line' AND A.plan_line LIKE '%$plan_line%'
      AND A.no_po LIKE '%$no_po%' AND A.color LIKE '%$color%'";
    }
  } else {
    if ($jalan_line == "") {
      $query .= " WHERE A.orc LIKE '%$orc%' AND A.style LIKE '%$style%' AND AC.table_transaksi = '$table' AND A.status = '$status' 
      AND A.costomer like '%$costomer%' AND A.category LIKE '%$category%' AND AD.line LIKE '%$jalan_line%' AND A.plan_line LIKE '%$plan_line%'
      AND A.no_po LIKE '%$no_po%' AND A.color LIKE '%$color%'";
    } else {
      $query .= " WHERE A.orc LIKE '%$orc%' AND A.style LIKE '%$style%' AND AC.table_transaksi = '$table' AND A.status = '$status' 
      AND A.costomer like '%$costomer%' AND A.category LIKE '%$category%' AND AD.line = '$jalan_line' AND A.plan_line LIKE '%$plan_line%'
      AND A.no_po LIKE '%$no_po%' AND A.color LIKE '%$color%'";
    }
  }
  $query .= " GROUP BY A.id_order_detail

  ORDER BY A.ORC, A.id_order_detail
  limit 200";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function tampilkan_laporan_bundle_record_detail_size($table, $tgl, $orc, $style, $status, $costomer, $category, $jalan_line, $plan_line, $no_po, $color, $checkstyle)
{
  global $koneksi;


  $query = "SELECT C.tanggal_max, A.costomer, A.no_po, A.orc, A.style, A.color, A.size, A.cup, sum(IFNULL(A.qty_isi_bundle,0)) qty_order, ifnull(B.daily,0) daily,
  ifnull(C.output_total,0) output_total, (ifnull(C.output_total,0) - sum(IFNULL(A.qty_isi_bundle,0))) balance_order, AD.line, A.plan_line FROM 
 (SELECT C.id_order, C.orc, D.style, C.color, E.costomer, C.no_po, A.barcode_bundle, A.id_order_detail, A.qty_isi_bundle, C.status, F.category,
   B.size, B.cup, G.plan_line FROM master_bundle A
   JOIN order_detail B ON A.id_order_detail = B.id_order_detail
   JOIN master_order C ON B.id_order = C.id_order
   JOIN style D ON C.id_style = D.id_style
   JOIN costomer E ON C.id_costomer = E.id_costomer
   JOIN items F on D.item = F.item
   JOIN production_preparation G on B.id_order = G.id_order) A
   LEFT OUTER JOIN 
   (SELECT A.tanggal, B.id_order_detail, sum(ifnull(A.qty,0)) daily FROM $table A
   JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
   JOIN order_detail C ON B.id_order_detail = C.id_order_detail
   WHERE tanggal = '$tgl' 
   GROUP BY B.id_order_detail)B
   ON A.id_order_detail = B.id_order_detail
    LEFT OUTER JOIN 
   (SELECT max(A.tanggal) tanggal_max, B.id_order_detail, sum(ifnull(A.qty,0)) output_total FROM $table A
   JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
   JOIN order_detail C ON B.id_order_detail = C.id_order_detail
   WHERE tanggal <= '$tgl' 
   GROUP BY B.id_order_detail)C
   ON A.id_order_detail = C.id_order_detail
   JOIN proses_transaksi_orc AB ON A.id_order = AB.id_order
   JOIN master_transaksi AC ON AB.nama_transaksi = AC.nama_transaksi 
   LEFT OUTER JOIN
    (SELECT C.id_order, IFNULL(A.line, '') line FROM transaksi_qc_endline A
    JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
    JOIN order_detail C on B.id_order_detail = C.id_order_detail
    GROUP BY C.id_order)AD
    ON A.id_order = AD.id_order";
  if ($checkstyle == "iya") {
    if ($jalan_line == "") {
      $query .= " WHERE A.orc LIKE '%$orc%' AND A.style = '$style' AND AC.table_transaksi = '$table' AND A.status = '$status' 
      AND A.costomer like '%$costomer%' AND A.category LIKE '%$category%' AND AD.line LIKE '%$jalan_line%' AND A.plan_line LIKE '%$plan_line%'
      AND A.no_po LIKE '%$no_po%' AND A.color LIKE '%$color%'";
    } else {
      $query .= " WHERE A.orc LIKE '%$orc%' AND A.style = '$style' AND AC.table_transaksi = '$table' AND A.status = '$status' 
      AND A.costomer like '%$costomer%' AND A.category LIKE '%$category%' AND AD.line = '$jalan_line' AND A.plan_line LIKE '%$plan_line%'
      AND A.no_po LIKE '%$no_po%' AND A.color LIKE '%$color%'";
    }
  } else {
    if ($jalan_line == "") {
      $query .= " WHERE A.orc LIKE '%$orc%' AND A.style LIKE '%$style%' AND AC.table_transaksi = '$table' AND A.status = '$status' 
      AND A.costomer like '%$costomer%' AND A.category LIKE '%$category%' AND AD.line LIKE '%$jalan_line%' AND A.plan_line LIKE '%$plan_line%'
      AND A.no_po LIKE '%$no_po%' AND A.color LIKE '%$color%'";
    } else {
      $query .= " WHERE A.orc LIKE '%$orc%' AND A.style LIKE '%$style%' AND AC.table_transaksi = '$table' AND A.status = '$status' 
      AND A.costomer like '%$costomer%' AND A.category LIKE '%$category%' AND AD.line = '$jalan_line' AND A.plan_line LIKE '%$plan_line%'
      AND A.no_po LIKE '%$no_po%' AND A.color LIKE '%$color%'";
    }
  }
  $query .= " GROUP BY A.id_order_detail

  ORDER BY A.ORC, A.id_order_detail
  limit 200";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_laporan_bundle_record_detail_size_before_qc($table, $tgl, $orc, $style, $status, $costomer, $category, $plan_line, $no_po, $color, $checkstyle)
{
  global $koneksi;


  $query = "SELECT C.tanggal_max, A.costomer, A.no_po, A.orc, A.style, A.color, A.size, A.cup, sum(IFNULL(A.qty_isi_bundle,0)) qty_order, ifnull(B.daily,0) daily,
  ifnull(C.output_total,0) output_total, (ifnull(C.output_total,0) - sum(IFNULL(A.qty_isi_bundle,0))) balance_order, A.plan_line FROM 
 (SELECT C.id_order, C.orc, D.style, C.color, E.costomer, C.no_po, A.barcode_bundle, A.id_order_detail, A.qty_isi_bundle, C.status, F.category,
   B.size, B.cup, G.plan_line FROM master_bundle A
   JOIN order_detail B ON A.id_order_detail = B.id_order_detail
   JOIN master_order C ON B.id_order = C.id_order
   JOIN style D ON C.id_style = D.id_style
   JOIN costomer E ON C.id_costomer = E.id_costomer
   JOIN items F on D.item = F.item
   JOIN production_preparation G on B.id_order = G.id_order) A
   LEFT OUTER JOIN 
   (SELECT A.tanggal, B.id_order_detail, sum(ifnull(A.qty,0)) daily FROM $table A
   JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
   JOIN order_detail C ON B.id_order_detail = C.id_order_detail
   WHERE tanggal = '$tgl' 
   GROUP BY B.id_order_detail)B
   ON A.id_order_detail = B.id_order_detail
    LEFT OUTER JOIN 
   (SELECT max(A.tanggal) tanggal_max, B.id_order_detail, sum(ifnull(A.qty,0)) output_total FROM $table A
   JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
   JOIN order_detail C ON B.id_order_detail = C.id_order_detail
   WHERE tanggal <= '$tgl' 
   GROUP BY B.id_order_detail)C
   ON A.id_order_detail = C.id_order_detail
   JOIN proses_transaksi_orc AB ON A.id_order = AB.id_order
   JOIN master_transaksi AC ON AB.nama_transaksi = AC.nama_transaksi";
  if ($checkstyle == "iya") {
    if ($plan_line == "") {
      $query .= " WHERE A.orc LIKE '%$orc%' AND A.style = '$style' AND AC.table_transaksi = '$table' AND A.status = '$status' 
      AND A.costomer like '%$costomer%' AND A.category LIKE '%$category%' AND A.plan_line LIKE '%$plan_line%'
      AND A.no_po LIKE '%$no_po%' AND A.color LIKE '%$color%'";
    } else {
      $query .= " WHERE A.orc LIKE '%$orc%' AND A.style = '$style' AND AC.table_transaksi = '$table' AND A.status = '$status' 
      AND A.costomer like '%$costomer%' AND A.category LIKE '%$category% AND A.plan_line LIKE '%$plan_line%'
      AND A.no_po LIKE '%$no_po%' AND A.color LIKE '%$color%'";
    }
  } else {
    if ($plan_line == "") {
      $query .= " WHERE A.orc LIKE '%$orc%' AND A.style LIKE '%$style%' AND AC.table_transaksi = '$table' AND A.status = '$status' 
      AND A.costomer like '%$costomer%' AND A.category LIKE '%$category%' AND A.plan_line LIKE '%$plan_line%'
      AND A.no_po LIKE '%$no_po%' AND A.color LIKE '%$color%'";
    } else {
      $query .= " WHERE A.orc LIKE '%$orc%' AND A.style LIKE '%$style%' AND AC.table_transaksi = '$table' AND A.status = '$status' 
      AND A.costomer like '%$costomer%' AND A.category LIKE '%$category% AND A.plan_line LIKE '%$plan_line%'
      AND A.no_po LIKE '%$no_po%' AND A.color LIKE '%$color%'";
    }
  }
  $query .= " GROUP BY A.id_order_detail

  ORDER BY A.ORC, A.id_order_detail
  limit 200";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function tampilkanQtykenzinfull($orc, $kode_barcode)
{
  global $koneksi;

  $query = "SELECT SUM(A.qty_kenzin)qty_kenzin FROM
  (SELECT ifnull(SUM(qty),0) qty_kenzin FROM transaksi_kenzin WHERE orc = '$orc' AND kode_barcode = '$kode_barcode'
  UNION 
  SELECT ifnull(SUM(qty),0) qty_kenzin FROM temp_kenzin WHERE orc = '$orc' AND kode_barcode = '$kode_barcode')A";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyQcFinalfull($orc, $kode_barcode)
{
  global $koneksi;

  $query = "SELECT SUM(A.qty_qcfinal)qty_qcfinal FROM
  (SELECT SUM(qty) qty_qcfinal FROM transaksi_qcfinal WHERE orc = '$orc' AND kode_barcode = '$kode_barcode'
  UNION 
  SELECT SUM(qty) qty_qcfinal FROM temp_qcfinal WHERE orc = '$orc' AND kode_barcode = '$kode_barcode')A";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyPackingfull($orc, $kode_barcode)
{
  global $koneksi;

  $query = "SELECT SUM(A.qty_packing)qty_packing FROM
  (SELECT ifnull(SUM(qty), 0) qty_packing FROM transaksi_packing WHERE orc = '$orc' AND kode_barcode = '$kode_barcode'
  UNION 
  SELECT ifnull(SUM(qty),0) qty_packing FROM temp_packing WHERE orc = '$orc' AND kode_barcode = '$kode_barcode')A";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyTatamiInFull($kode_barcode)
{
  global $koneksi;

  $query = "SELECT SUM(A.qty_tatami_in)qty_tatami_in FROM
  (SELECT SUM(qty) qty_tatami_in FROM transaksi_tatami_in WHERE kode_barcode = '$kode_barcode'
  UNION 
  SELECT SUM(qty) qty_tatami_in FROM temp_tatami_in WHERE kode_barcode = '$kode_barcode')A";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyRejectTatamiFull($kode_barcode)
{
  global $koneksi;

  $query = "SELECT ifnull(SUM(A.qty_tatami_reject), 0) qty_tatami_reject FROM
  (SELECT SUM(qty) qty_tatami_reject FROM transaksi_reject_tatami WHERE kode_barcode = '$kode_barcode'
  UNION 
  SELECT SUM(qty) qty_tatami_reject FROM temp_reject_tatami WHERE kode_barcode = '$kode_barcode')A";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyQcKensaFull($kode_barcode)
{
  global $koneksi;

  $query = "SELECT SUM(A.qty_qc_kensa)qty_qc_kensa FROM
  (SELECT SUM(qty) qty_qc_kensa FROM transaksi_qc_kensa WHERE kode_barcode = '$kode_barcode'
  UNION 
  SELECT SUM(qty) qty_qc_kensa FROM temp_qc_kensa WHERE kode_barcode = '$kode_barcode')A";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyProductionBundleFull($kode_barcode, $temp_table, $table)
{
  global $koneksi;

  $query = "SELECT IFNULL(SUM(A.qty_production),0) qty_production FROM
  (SELECT SUM(qty) qty_production FROM $table WHERE kode_barcode = '$kode_barcode'
  UNION 
  SELECT SUM(qty) qty_production FROM $temp_table WHERE kode_barcode = '$kode_barcode')A";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyProductionBundleTemp($kode_barcode, $temp_table, $user)
{
  global $koneksi;

  $query = "SELECT SUM(qty) qty_production FROM $temp_table WHERE kode_barcode = '$kode_barcode' AND username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function tampilkanQtyTempQCKensaUser($kode_barcode, $user)
{
  global $koneksi;

  $query = "SELECT SUM(qty)qty_qc_kensa FROM temp_qc_kensa where kode_barcode = '$kode_barcode' 
  and username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyTempQCKensaID($id)
{
  global $koneksi;

  $query = "SELECT SUM(qty)qty_qc_kensa FROM temp_qc_kensa where id_transaksi_qc_kensa = '$id'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyTempTatamiInID($id)
{
  global $koneksi;

  $query = "SELECT SUM(qty)qty_tatami_in FROM temp_tatami_in where id_transaksi_tatami_in = '$id'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyTempKenzinID($id)
{
  global $koneksi;

  $query = "SELECT SUM(qty)qty_kenzin, kode_barcode FROM temp_kenzin where id_transaksi_kenzin = '$id'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyTempPackingID($id)
{
  global $koneksi;

  $query = "SELECT SUM(qty)qty_packing, kode_barcode FROM temp_packing where id_transaksi_packing = '$id'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyTransaksiPackingID($id)
{
  global $koneksi;

  $query = "SELECT SUM(qty)qty_packing FROM transaksi_packing where id_transaksi_packing = '$id'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyTempTatamiInUser($kode_barcode, $user)
{
  global $koneksi;

  $query = "SELECT SUM(qty)qty_tatami_in FROM temp_tatami_in where kode_barcode = '$kode_barcode' 
  and username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyTempKenzinKarton($user)
{
  global $koneksi;

  $query = "SELECT SUM(qty)total_qty FROM temp_kenzin where username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyTempPackingKarton($user)
{
  global $koneksi;

  $query = "SELECT SUM(qty)total_qty FROM temp_packing where username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyTempKenzinUser($orc, $kode_barcode, $user)
{
  global $koneksi;

  $query = "SELECT ifnull(SUM(qty), 0) qty_kenzin FROM temp_kenzin where orc = '$orc' and kode_barcode = '$kode_barcode' 
  and username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanOrcTempKenzinUser($user)
{
  global $koneksi;

  $query = "SELECT orc FROM temp_kenzin where username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanOrcTempPackingUser($user)
{
  global $koneksi;

  $query = "SELECT orc FROM temp_packing where username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanBuyerTempKenzinUser($user)
{
  global $koneksi;

  $query = "SELECT B.id_costomer FROM temp_kenzin A join master_order B on A.orc = B.orc
  where A.username = '$user'
  GROUP BY B.id_costomer";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanBuyerTempPackingUser($user)
{
  global $koneksi;

  $query = "SELECT B.id_costomer FROM temp_packing A join master_order B on A.orc = B.orc
  where A.username = '$user'
  GROUP BY B.id_costomer";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanBarangTempKenzinUserOrc($user, $orc)
{
  global $koneksi;

  $query = "SELECT kode_barcode, orc FROM temp_kenzin where orc = '$orc' AND username = '$user' group by orc, kode_barcode";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanBarangTempPackingUserOrc($user, $orc)
{
  global $koneksi;

  $query = "SELECT kode_barcode, orc FROM temp_packing where orc = '$orc' AND username = '$user' group by orc, kode_barcode";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyTempPackingUser($orc, $kode_barcode, $user)
{
  global $koneksi;

  $query = "SELECT ifnull(SUM(qty),0) qty_packing FROM temp_packing where orc = '$orc' and kode_barcode = '$kode_barcode' 
  and username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyPackingNoTrx($orc, $kode_barcode, $trx)
{
  global $koneksi;

  $query = "SELECT SUM(qty)qty_packing FROM transaksi_packing where orc = '$orc' and kode_barcode = '$kode_barcode' 
  and no_trx = '$trx'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyTatamiOutFull($kode_barcode)
{
  global $koneksi;

  $query = "SELECT SUM(A.qty_tatami_out)qty_tatami_out FROM
  (SELECT SUM(qty) qty_tatami_out FROM transaksi_tatami_out WHERE kode_barcode = '$kode_barcode'
  UNION 
  SELECT SUM(qty) qty_tatami_out FROM temp_tatami_out WHERE kode_barcode = '$kode_barcode')A";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyScan($orc, $kode_barcode)
{
  global $koneksi;

  $query = "SELECT SUM(A.qty_scan)totalpacking FROM 
    (SELECT COUNT(qty) qty_scan FROM transaksi_packing WHERE orc = '$orc' AND kode_barcode = '$kode_barcode'
      UNION
    SELECT COUNT(qty) qty_scan FROM transaksi_shipment WHERE orc = '$orc' AND kode_barcode = '$kode_barcode'
      UNION
    SELECT COUNT(qty) qty_scan FROM temp_packing WHERE orc = '$orc' AND kode_barcode = '$kode_barcode')A";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtykenzinNoTrx($orc, $kode_barcode, $no_kenzin)
{
  global $koneksi;

  $query = "SELECT ifnull(sum(qty), 0) qty_kenzin_trx FROM transaksi_kenzin WHERE orc = '$orc' AND kode_barcode = '$kode_barcode' AND no_trx = $no_kenzin ";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function tampilkanQtykenzin($orc, $kode_barcode)
{
  global $koneksi;

  $query = "SELECT ifnull(sum(qty), 0) qty_kenzin FROM transaksi_kenzin WHERE orc = '$orc' AND kode_barcode = '$kode_barcode'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyTatamiOut($barcode_number)
{
  global $koneksi;

  $query = "SELECT sum(qty) qty_tatami_out FROM transaksi_tatami_out WHERE kode_barcode = '$barcode_number'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyTatamiIn($barcode_number)
{
  global $koneksi;

  $query = "SELECT ifnull(sum(qty),0) qty_tatami_in FROM transaksi_tatami_in WHERE kode_barcode = '$barcode_number'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyScanQCKensa($barcode_number)
{
  global $koneksi;

  $query = "SELECT ifnull(sum(qty),0) qty_qc_kensa FROM transaksi_qc_kensa WHERE kode_barcode = '$barcode_number'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyTatamiReject($barcode_number)
{
  global $koneksi;

  $query = "SELECT sum(qty) qty_reject_tatami FROM transaksi_reject_tatami WHERE adjuzt =  'y' and kode_barcode = '$barcode_number'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyToRejectQcKensa($barcode_number)
{
  global $koneksi;

  $query = "SELECT ifnull(sum(qty), 0) qty_reject_tatami FROM transaksi_reject_tatami WHERE adjuzt =  'y' and kode_barcode = '$barcode_number' and keterangan != 'ganti_label'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyToRejectQcKensaGantiLabel($barcode_number)
{
  global $koneksi;

  $query = "SELECT ifnull(sum(qty), 0) qty_reject_tatami FROM transaksi_reject_tatami WHERE adjuzt =  'y' and kode_barcode = '$barcode_number' and keterangan = 'ganti_label'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyGantiLabel($orc, $kode_barcode)
{
  global $koneksi;

  $query = "SELECT COUNT(qty) qty_gantilabel FROM transaksi_ganti_label WHERE orc = '$orc' AND kode_barcode = '$kode_barcode'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyGantiLabelfull($orc, $kode_barcode)
{
  global $koneksi;

  $query = "SELECT SUM(a.qty_gantilabel) qty_gantilabel 
    FROM (SELECT COUNT(qty) qty_gantiLabel FROM transaksi_ganti_label WHERE orc = '$orc' AND kode_barcode = '$kode_barcode'
    UNION
    SELECT COUNT(qty) qty_gantiLabel FROM temp_ganti_label WHERE orc = '$orc' AND kode_barcode = '$kode_barcode') A";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyScanLabel($orc, $kode_barcode)
{
  global $koneksi;

  $query = "SELECT SUM(A.qty_scan)totalpacking FROM 
    (SELECT COUNT(qty) qty_scan FROM transaksi_packing A WHERE orc = '$orc' AND kode_barcode = '$kode_barcode'
      UNION
    SELECT COUNT(qty) qty_scan FROM transaksi_shipment A WHERE orc = '$orc' AND kode_barcode = '$kode_barcode'
      UNION
    SELECT COUNT(qty) qty_scan FROM temp_packing A WHERE orc = '$orc' AND kode_barcode = '$kode_barcode')A";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_line_id($edit)
{
  global $koneksi;


  $query = "SELECT id_line, nama_line, lantai, supervisor, chief, status FROM master_line where id_line = '$edit'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_contract_id($edit)
{
  global $koneksi;


  $query = "SELECT * FROM contract_number where id_contract = '$edit'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_item_id($edit)
{
  global $koneksi;


  $query = "SELECT * FROM items where id_item = '$edit'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_qty_karton_id($edit)
{
  global $koneksi;


  $query = "SELECT A.id, A.id_style, B.style, A.qty_karton FROM master_qty_karton A join style B on A.id_style = B.id_style where A.id = '$edit'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_smv_id($edit)
{
  global $koneksi;


  $query = "SELECT A.id, A.id_style, B.style, A.nilai_smv FROM master_smv A join style B on A.id_style = B.id_style where A.id = '$edit'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_style_id($edit)
{
  global $koneksi;
  $query = "SELECT id_style, description, style, item, id_costomer FROM style where id_style = '$edit'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_material_id($edit)
{
  global $koneksi;
  $query = "SELECT id_material, material_code, material_name FROM master_material where id_material = '$edit'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_description_id($edit)
{
  global $koneksi;
  $query = "SELECT * FROM costomer where id_costomer = '$edit'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_label_id($edit)
{
  global $koneksi;
  $query = "SELECT id_label, label, bulan, tahun, status, right(label,1) as substLabel FROM label where id_label = '$edit'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_size_id($edit)
{
  global $koneksi;

  $query = "SELECT * FROM size where id_size = '$edit'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_size()
{
  global $koneksi;

  $query = "SELECT * FROM size order by urutan";
  // $query = "SELECT size FROM size order by urutan";
  // $query = "SELECT * FROM style group by style";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_cup()
{
  global $koneksi;

  $query = "SELECT cup FROM size group by cup order by cup";
  // $query = "SELECT * FROM style group by style";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_style()
{
  global $koneksi;

  $query = "SELECT * FROM style order by style";
  // $query = "SELECT * FROM style group by style";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_style_karton()
{
  global $koneksi;

  $query = "SELECT id_style, style FROM style WHERE id_style NOT IN (SELECT id_style FROM master_qty_karton)";
  // $query = "SELECT * FROM style group by style";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_style_smv()
{
  global $koneksi;

  $query = "SELECT id_style, style FROM style WHERE id_style NOT IN (SELECT id_style FROM master_smv)";
  // $query = "SELECT * FROM style group by style";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_style_karton_edit()
{
  global $koneksi;

  $query = "SELECT id_style, style FROM style WHERE id_style  IN (SELECT id_style FROM master_qty_karton)";
  // $query = "SELECT * FROM style group by style";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_style()
{
  global $koneksi;

  $query = "SELECT * FROM style order by id_style desc ";
  // $query = "SELECT * FROM style group by style";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_style_costomer()
{
  global $koneksi;

  $query = "SELECT A.id_style, A.style, A.description, A.item, ifnull(B.costomer, '') costomer FROM style A left outer join costomer B on A.id_costomer = B.id_costomer order by A.id_style desc ";
  // $query = "SELECT * FROM style group by style";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}
function tampilkan_master_material()
{
  global $koneksi;

  $query = "SELECT id_material, material_code, material_name FROM master_material order by id_material desc ";
  // $query = "SELECT * FROM style group by style";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_part()
{
  global $koneksi;

  $query = "SELECT * from master_part order by id_part desc ";


  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_part_id($id)
{
  global $koneksi;

  $query = "SELECT * from master_part where id_part = $id ";


  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}



function tampilkan_master_part_table_bom($id, $search)
{
  global $koneksi;

  $query = "SELECT id_part, part FROM master_part  where part LIKE '%$search%'
    and id_part not in (SELECT id_part FROM master_bom_detail_part where id_bom_detail = $id)
     order by part ";


  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_part_table_bom_orc($id, $search)
{
  global $koneksi;

  $query = "SELECT id_part, part FROM master_part  where part LIKE '%$search%'
    and id_part not in (SELECT id_part FROM master_bom_detail_part_orc where id_bom_detail_orc = $id)
     order by part ";


  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_part_table_bom_terpilih($id, $search)
{
  global $koneksi;

  $query = "SELECT A.id_part, B.part, A.id_bom_detail_part FROM master_bom_detail_part A
    JOIN master_part B ON A.id_part = B.id_part 
    WHERE A.id_bom_detail = $id AND B.part LIKE '%$search%' order by A.id_bom_detail_part desc";
  // $query = "SELECT * FROM style group by style";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function tampilkan_master_part_table_bom_terpilih_search($id, $search)
{
  global $koneksi;

  $query = "SELECT A.id_part, B.part, A.id_bom_detail_part FROM master_bom_detail_part_orc A
    JOIN master_part B ON A.id_part = B.id_part 
    WHERE A.id_bom_detail_orc = $id AND B.part LIKE '%$search%' order by A.id_bom_detail_part desc";
  // $query = "SELECT * FROM style group by style";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function tampilkan_master_part_table_bom_part($id)
{
  global $koneksi;

  $query = "SELECT A.id_part, B.part, A.id_bom_detail_part FROM master_bom_detail_part A
    JOIN master_part B ON A.id_part = B.id_part 
    WHERE A.id_bom_detail = $id order by A.id_bom_detail_part desc";
  // $query = "SELECT * FROM style group by style";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_part_table_bom_orc_terpilih($id)
{
  global $koneksi;

  $query = "SELECT A.id_part, B.part, A.id_bom_detail_part FROM master_bom_detail_part_orc A
    JOIN master_part B ON A.id_part = B.id_part 
    WHERE A.id_bom_detail_orc = $id order by A.id_bom_detail_part desc";
  // $query = "SELECT * FROM style group by style";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_part_orc_transaksi($id, $search)
{
  global $koneksi;

  $query = "SELECT A.id_bom_detail_orc, D.material_code, D.material_name, A.id_bom_detail_part, E.part FROM master_bom_detail_part_orc A 
    JOIN master_bom_detail_orc B ON A.id_bom_detail_orc = B.id_bom_detail_orc
    JOIN master_bom_orc C ON B.id_bom_orc = C.id_bom_orc
    JOIN master_material D ON B.id_material = D.id_material
    JOIN master_part E ON A.id_part = E.id_part 
    WHERE C.id_order = $id AND E.part LIKE '%$search%' 
    AND A.id_bom_detail_part NOT IN ( SELECT id_bom_detail_part FROM temp_part_cutting_part where id_order = $id)
    order by A.id_bom_detail_part desc";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_part_orc_transaksi_terpilih($id, $search)
{
  global $koneksi;

  $query = "SELECT A.id_transaksi,  E.material_code, E.material_name, A.id_bom_detail_part, F.part
     FROM temp_part_cutting_part A 
    JOIN master_bom_detail_part_orc B ON A.id_bom_detail_part = B.id_bom_detail_part
    JOIN master_bom_detail_orc C ON  B.id_bom_detail_orc = C.id_bom_detail_orc
    JOIN master_bom_orc D ON C.id_bom_orc = D.id_bom_orc
    JOIN master_material E ON C.id_material = E.id_material
    JOIN master_part F ON B.id_part = F.id_part
    
    WHERE D.id_order = $id AND F.part LIKE '%$search%' order by A.id_bom_detail_part desc";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_temp_part_cutting_part_id_order($id_order)
{
  global $koneksi;

  $query = "SELECT id_bom_detail_part FROM temp_part_cutting_part 
    WHERE id_order = $id_order  order by id_transaksi asc";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_material_search($cari)
{
  global $koneksi;

  $query = "SELECT id_material, material_code, material_name FROM master_material 
    WHERE material_code LIKE '%$cari%'
    OR material_name LIKE '%$cari%'
    order by id_material desc ";
  // $query = "SELECT * FROM style group by style";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_size_orc_transaksi($id, $size, $cup)
{
  global $koneksi;
  if ($cup != '') {
    $query = "SELECT id_order_detail, id_order, size, cup FROM order_detail 
      WHERE id_order = $id AND size LIKE '%$size%' AND cup = '$cup'
      AND id_order_detail NOT IN (SELECT id_order_detail FROM temp_part_cutting_size)
      order by id_order_detail desc";
  } else {
    $query = "SELECT id_order_detail, id_order, size, cup FROM order_detail 
      WHERE id_order = $id AND size LIKE '%$size%' 
      AND id_order_detail NOT IN (SELECT id_order_detail FROM temp_part_cutting_size)
      order by id_order_detail desc";
  }

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_size_orc_transaksi_terpilih($id, $size, $cup)
{
  global $koneksi;
  if ($cup != '') {
    $query = "SELECT A.id_transaksi, A.id_order_detail, B.size, B.cup, IFNULL(A.rasio,0) rasio FROM 
      temp_part_cutting_size A 
      JOIN order_detail B ON A.id_order_detail = B.id_order_detail 
      WHERE B.id_order = $id AND B.size LIKE '%$size%' AND B.cup = '$cup'
      order by id_order_detail desc";
  } else {
    $query = "SELECT A.id_transaksi, A.id_order_detail, B.size, B.cup, IFNULL(A.rasio,0) rasio FROM 
      temp_part_cutting_size A 
      JOIN order_detail B ON A.id_order_detail = B.id_order_detail 
      WHERE B.id_order = $id AND B.size LIKE '%$size%' 
      order by id_order_detail desc";
  }

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_temp_part_cutting_size_id_order($id_order)
{
  global $koneksi;

  $query = "SELECT A.id_order_detail, IFNULL(A.rasio,0) rasio FROM 
      temp_part_cutting_size A 
      JOIN order_detail B ON A.id_order_detail = B.id_order_detail 
      WHERE B.id_order = $id_order order by id_order_detail desc";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function tampilkan_master_size_search_id_order($cari, $id_order)
{
  global $koneksi;

  $query = "SELECT id_order_detail, size, cup FROM order_detail WHERE id_order = $id_order
    AND size like '%$cari%'

    order by id_order_detail desc ";
  // $query = "SELECT * FROM style group by style";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_bom_detail_style($id)
{
  global $koneksi;

  $query = "SELECT A.id_bom_detail, A.id_material, C.material_code, C.material_name, B.id_style FROM master_bom_detail A
    JOIN master_bom B ON A.id_bom = B.id_bom
    JOIN master_material C ON A.id_material = C.id_material
    WHERE B.id_style = $id
    ORDER BY A.id_bom_detail desc";
  // $query = "SELECT * FROM style group by style";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_bom_detail_orc($id)
{
  global $koneksi;

  $query = "SELECT A.id_bom_detail_orc, A.id_material, C.material_code, C.material_name FROM master_bom_detail_orc A
    JOIN master_bom_orc B ON A.id_bom_orc = B.id_bom_orc
    JOIN master_material C ON A.id_material = C.id_material
    WHERE B.id_order = $id
    ORDER BY A.id_bom_detail_orc desc";
  // $query = "SELECT * FROM style group by style";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_bom_detail_id($id)
{
  global $koneksi;

  $query = "SELECT A.id_bom_detail, A.id_material, C.material_code, C.material_name, B.id_style FROM master_bom_detail A
    JOIN master_bom B ON A.id_bom = B.id_bom
    JOIN master_material C ON A.id_material = C.id_material
    WHERE A.id_bom_detail = '$id'";
  // $query = "SELECT * FROM style group by style";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_bom_detail_orc_id($id)
{
  global $koneksi;

  $query = "SELECT A.id_bom_detail_orc, A.id_material, C.material_code, C.material_name FROM master_bom_detail_orc A
   -- JOIN master_bom_orc B ON A.id_bom_orc = B.id_bom_orc
    JOIN master_material C ON A.id_material = C.id_material
    WHERE A.id_bom_detail_orc = $id";
  // $query = "SELECT * FROM style group by style";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_style_color($id)
{
  global $koneksi;

  $query = "SELECT * FROM style_color where id_style = $id ORDER BY id_color_style DESC";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function tampilkan_master_material_color($id)
{
  global $koneksi;

  $query = "SELECT * FROM master_material_color where id_material = $id ORDER BY id_color_material DESC";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_costomer()
{
  global $koneksi;

  $query = "SELECT * FROM costomer order by costomer ASC ";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_country()
{
  global $koneksi;

  $query = "SELECT country FROM country order by country ASC ";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_label()
{
  global $koneksi;

  $query = "SELECT * FROM label order by label asc ";
  // $query = "SELECT * FROM style group by style";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function tampilkan_no_transaksi_packing($user)
{
  global $koneksi;

  $query = "SELECT IFNULL(MAX(A.no_trx),0) AS no_trx from
  (SELECT max(no_trx) as no_trx FROM transaksi_packing
  union select max(no_trx) as no_trx from temp_packing WHERE username != '$user')A";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_no_transaksi_kenzin($user)
{
  global $koneksi;

  $query = "SELECT IFNULL(MAX(A.no_trx),0) AS no_trx from
  (SELECT max(no_trx) as no_trx FROM transaksi_kenzin
  union select max(no_trx) as no_trx from temp_kenzin WHERE username != '$user')A";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_no_transaksi_qcfinal($user)
{
  global $koneksi;

  $query = "SELECT IFNULL(MAX(A.no_trx),0) AS no_trx from
  (SELECT max(no_trx) as no_trx FROM transaksi_qcfinal
  union select max(no_trx) as no_trx from temp_qcfinal WHERE username != '$user')A";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_no_transaksi_reject_tatami($user)
{
  global $koneksi;

  $query = "SELECT IFNULL(MAX(A.no_trx),0) AS no_trx from
  (SELECT max(no_trx) as no_trx FROM transaksi_reject_tatami
  union select max(no_trx) as no_trx from temp_reject_tatami WHERE username != '$user')A";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_no_transaksi_tatami_in($user)
{
  global $koneksi;

  $query = "SELECT IFNULL(MAX(A.no_trx),0) AS no_trx from
  (SELECT max(no_trx) as no_trx FROM transaksi_tatami_in
  union select max(no_trx) as no_trx from temp_tatami_in WHERE username != '$user')A";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_no_transaksi_qc_kensa($user)
{
  global $koneksi;

  $query = "SELECT IFNULL(MAX(A.no_trx),0) AS no_trx from
  (SELECT max(no_trx) as no_trx FROM transaksi_qc_kensa
  union select max(no_trx) as no_trx from temp_qc_kensa WHERE username != '$user')A";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_no_transaksi_production_bundle($user, $temp_table, $table)
{
  global $koneksi;

  $query = "SELECT IFNULL(MAX(A.no_trx),0) AS no_trx from
  (SELECT max(no_trx) as no_trx FROM $table
  union select max(no_trx) as no_trx from $temp_table WHERE username != '$user')A";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_no_transaksi_produksi_bundle($user)
{
  global $koneksi;

  $query = "SELECT IFNULL(MAX(A.no_trx),0) AS no_trx from
  (SELECT max(no_trx) as no_trx FROM transaksi_qc_kensa
  union select max(no_trx) as no_trx from temp_qc_kensa WHERE username != '$user')A";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_no_transaksi_tatami_out($user)
{
  global $koneksi;

  $query = "SELECT IFNULL(MAX(A.no_trx),0) AS no_trx from
  (SELECT max(no_trx) as no_trx FROM transaksi_tatami_out
  union select max(no_trx) as no_trx from temp_tatami_out WHERE username != '$user')A";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_no_transaksi_kenzin0($user)
{
  global $koneksi;

  $query = "SELECT IFNULL(MAX(no_trx),0) AS no_trx from temp_kenzin where username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_no_transaksi_qcfinal0($user)
{
  global $koneksi;

  $query = "SELECT IFNULL(MAX(no_trx),0) AS no_trx from temp_qcfinal where username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_no_transaksi_tatami_in0($user)
{
  global $koneksi;

  $query = "SELECT IFNULL(MAX(no_trx),0) AS no_trx from temp_tatami_in where username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_no_transaksi_tatami_out0($user)
{
  global $koneksi;

  $query = "SELECT IFNULL(MAX(no_trx),0) AS no_trx from temp_tatami_out where username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_no_transaksi_packing0($user)
{
  global $koneksi;

  $query = "SELECT IFNULL(MAX(no_trx),0) AS no_trx from temp_packing where username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_data_temp_kenzin($user)
{
  global $koneksi;

  $query = "SELECT IFNULL(MAX(no_trx),0) AS data_no, SUM(qty) total from temp_kenzin where username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}



function tampilkan_data_temp_qcfinal($user)
{
  global $koneksi;

  $query = "SELECT IFNULL(MAX(no_trx),0) AS data_no from temp_qcfinal where username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_data_temp_tatami_in($user)
{
  global $koneksi;

  $query = "SELECT IFNULL(MAX(no_trx),0) AS data_no from temp_tatami_in where username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_data_temp_reject_tatami($user)
{
  global $koneksi;

  $query = "SELECT IFNULL(MAX(no_trx),0) AS data_no from temp_reject_tatami where username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_data_produksi_bundle($user, $temp_table)
{
  global $koneksi;

  $query = "SELECT IFNULL(MAX(no_trx),0) AS data_no, sum(qty) total from $temp_table where username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_data_temp_qc_kensa($user)
{
  global $koneksi;

  $query = "SELECT IFNULL(MAX(no_trx),0) AS data_no from temp_qc_kensa where username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_data_temp_tatami_out($user)
{
  global $koneksi;

  $query = "SELECT IFNULL(MAX(no_trx),0) AS data_no from temp_tatami_out where username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_data_temp_packing($user)
{
  global $koneksi;

  $query = "SELECT IFNULL(MAX(no_trx),0) AS data_no, SUM(qty) total from temp_packing where username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_data_packing($trx)
{
  global $koneksi;

  $query = "SELECT kelompok from transaksi_packing where no_trx = $trx";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_shipment()
{
  global $koneksi;

  $query = "SELECT A.id_shipment, A.no_invoice, A.inspection, A.id_costomer, B.costomer, A.shipment_by, A.`status`, A.ukuran_karton, A.cut_off, A.approve 
  FROM shipment A JOIN costomer B ON A.id_costomer = B.id_costomer";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_shipment_id($invoice)
{
  global $koneksi;

  $query = "SELECT * FROM shipment A join costomer B on A.id_costomer = B.id_costomer where id_shipment = '$invoice'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_shipment_id($edit)
{
  global $koneksi;

  $query = "SELECT A.id_shipment, A.no_invoice, A.inspection, A.id_costomer, B.costomer, A.shipment_by, A.`status`, A.ukuran_karton, A.cut_off, A.approve
   FROM shipment A JOIN costomer B ON A.id_costomer = B.id_costomer where A.id_shipment = '$edit'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_data_preparation_production_id($id)
{
  global $koneksi;

  $query = "SELECT A.id_prod, A.id_order, D.costomer, B.no_po, B.orc, C.style, C.item, B.color, B.qty_order, B.prepare_on,  A.plan_line, A.days_proses, A.plan_production, B.shipment_plan,
    A.inhouse_fabric_date, A.kesiapan_fabric_date, A.kesiapan_fabric, A.fabric_pic, A.remaks_fabric,
    A.inhouse_acc_sewing_date, A.kesiapan_acc_sewing_date, A.kesiapan_acc_sewing, A.acc_sewing_pic,  A.remaks_acc_sewing,
    A.kesiapan_acc_packing_date, A.kesiapan_acc_packing, A.acc_packing_pic, A.remaks_acc_packing,
    A.date_in_team_sample, A.team_sample_date, A.team_sample_pic, A.remaks_team_sample, A.kesiapan_team_sample,
    A.date_in_fit_sample, A.fit_sample_date, A.fit_sample_pic, A.remaks_fit_sample, A.kesiapan_fit_sample,
    A.date_in_size_set_sample, A.size_set_sample_date, A.size_set_sample_pic, A.remaks_size_set_sample, A.kesiapan_size_set_sample,
    A.date_in_ppm, A.ppm_date, A.ppm_pic, A.remaks_ppm, A.kesiapan_ppm,
    A.date_in_pattern_check, A.pattern_check_date, A.kesiapan_pattern_check, A.pattern_check_pic, A.remaks_pattern_check,
    A.date_in_template_sewing, A.template_sewing_date, A.kesiapan_template_sewing, A.template_sewing_pic, A.remaks_template_sewing ,
    A.date_in_marker, A.marker_date, A.kesiapan_marker, A.marker_pic, A.remaks_marker ,
    A.moulding_date, A.moulding_pic, A.remaks_moulding, A.machines_setting_date, A.machines_setting_pic, A.remaks_machines_setting, A.layout_date, A.layout_pic, A.remaks_layout, 
   A.ready_produksi_date, A.ready_produksi_pic, A.remaks_ready_produksi FROM production_preparation A 
  JOIN master_order B ON A.id_order = B.id_order
  JOIN style C ON B.id_style = C.id_style
  JOIN costomer D on B.id_costomer = D.id_costomer 
  where id_prod = '$id'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_no_invoice()
{
  global $koneksi;

  $query = "SELECT no_invoice, id_shipment FROM shipment where status = 'aktif' and no_invoice like '%skm%' ";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_no_invoice_fgx()
{
  global $koneksi;

  $query = "SELECT no_invoice, id_shipment FROM shipment where status = 'aktif' and no_invoice like '%fgx%' ";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function tampilkan_master_order_prod_prep()
{
  global $koneksi;

  $query = "SELECT D.costomer,  B.orc, B.id_order, B.no_po, B.label, C.style, B.color, B.status, ifnull(SUM(A.qty_order),0)total  FROM order_detail A
    Right join master_order B ON A.id_order = B.id_order JOIN style C ON B.id_style = C.id_style JOIN costomer D ON D.id_costomer = B.id_costomer
    WHERE B.status = 'open' AND B.prep_prod = 'belum' 
    GROUP BY B.orc 
    ORDER BY B.id_order desc";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_order_bom_open()
{
  global $koneksi;

  // $query = "SELECT D.costomer, A.id_order, B.orc, B.no_po, C.style, B.label, B.color, C.item FROM master_bom_orc A 
  // JOIN master_order B ON A.id_order = B.id_order
  // JOIN style C ON B.id_style = C.id_style 
  // JOIN costomer D ON D.id_costomer = B.id_costomer 
  // WHERE B.status = 'open' ORDER BY B.id_order desc ";

  $query = "SELECT D.costomer, A.id_order, B.orc, B.no_po, C.style, B.label, B.color, C.item
            FROM master_bom_orc AS A
	          RIGHT JOIN master_order AS B ON A.id_order = B.id_order
	          LEFT JOIN style AS C ON B.id_style = C.id_style
	          LEFT JOIN costomer AS D ON D.id_costomer = B.id_costomer
            WHERE B.`status` = 'open' ORDER BY B.id_order DESC";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function tampilkan_master_order_open()
{
  global $koneksi;

  $query = "SELECT D.costomer,  B.orc, B.id_order, B.no_po, B.label, B.id_style, C.style, B.color, B.status, ifnull(SUM(A.qty_order),0)total FROM order_detail A
  Right join master_order B ON A.id_order = B.id_order JOIN style C ON B.id_style = C.id_style JOIN costomer D ON D.id_costomer = B.id_costomer WHERE B.status = 'open' GROUP BY B.orc ORDER BY B.id_order desc";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_order_barcode_buyer_open()
{
  global $koneksi;

  $query = "SELECT D.costomer,  B.orc, B.id_order, B.no_po, B.label, B.id_style, C.style, B.color, B.status, ifnull(SUM(A.qty_order),0)total FROM order_detail A
  Right join master_order B ON A.id_order = B.id_order JOIN style C ON B.id_style = C.id_style JOIN costomer D ON D.id_costomer = B.id_costomer WHERE B.status = 'open' and D.barcode_costomer = 'y' GROUP BY B.orc ORDER BY B.id_order desc";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_order_barcode_buyer_kenzin($style, $no_po, $costomer)
{
  global $koneksi;

  $query = "SELECT A.costomer, A.orc, A.no_po, A.label, A.style, A.color, A.qty_order, (ifnull(B.qty_output,0)-A.qty_order) balance, ifnull(A.qty_karton, 0) qty_karton FROM 
  (SELECT C.costomer, A.id_order, A.orc, A.no_po, A.label, B.style, A.color, A.status, C.barcode_costomer, SUM(D.qty_order) qty_order , ifnull(E.qty_karton, 0) qty_karton
  FROM master_order A 
  JOIN style B ON A.id_style = B.id_style
  JOIN costomer C ON A.id_costomer = C.id_costomer
  JOIN order_detail D ON A.id_order = D.id_order
  LEFT OUTER JOIN master_qty_karton E ON A.id_style = E.id_style
  GROUP BY A.id_order
  ) A
  LEFT OUTER JOIN 
  (SELECT orc, SUM(qty) qty_output FROM transaksi_kenzin
  GROUP BY orc)B
  ON A.orc = B.orc
  WHERE A.status = 'open' AND A.barcode_costomer = 'y' and (ifnull(B.qty_output,0)-A.qty_order) != 0 
  AND A.style LIKE '%$style%' AND A.no_po LIKE '%$no_po%' AND A.costomer LIKE '%$costomer%'
  GROUP BY A.id_order
  order by A.no_po, A.style, A.color";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_input_target_harian($style, $no_po, $costomer, $today)
{
  global $koneksi;

  $query = "SELECT A.id_order, A.orc, A.costomer, A.style, A.color, A.no_po, ifnull(A.qty_order, 0) qty_order, (IFNULL(B.qty_output, 0)-ifnull(A.qty_order, 0)) balance, A.nilai_smv, ifnull(A.jmlh_operator,0) jml_operator, A.plan_line From

  (SELECT C.id_order, C.orc, D.style, C.color, E.costomer, C.no_po, A.barcode_bundle, A.id_order_detail, sum(A.qty_isi_bundle) qty_order, C.status, F.nilai_smv, G.plan_line, (SELECT B.jml_register_hrd FROM master_line_operator B WHERE B.id_line = H.id_line AND B.date_register <= '$today' ORDER BY B.date_register desc LIMIT 1 ) jmlh_operator FROM master_bundle A
      JOIN order_detail B ON A.id_order_detail = B.id_order_detail
      JOIN master_order C ON B.id_order = C.id_order
      JOIN style D ON C.id_style = D.id_style
      JOIN costomer E ON C.id_costomer = E.id_costomer
      JOIN master_smv F ON D.id_style = F.id_style
      JOIN production_preparation G ON B.id_order = G.id_order
      JOIN master_line H ON G.plan_line = H.nama_line
     
      GROUP BY C.id_order)A
  LEFT OUTER JOIN 
  (SELECT A.kode_barcode, SUM(A.qty) qty_output FROM transaksi_qc_endline A
  JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle
      JOIN order_detail C ON B.id_order_detail = C.id_order_detail
     GROUP BY C.id_order)B
  ON A.barcode_bundle = B.kode_barcode
  WHERE A.status = 'open' and (ifnull(B.qty_output,0)-ifnull(A.qty_order, 0)) != 0 
  AND A.style LIKE '%$style%' AND A.no_po LIKE '%$no_po%' AND A.costomer LIKE '%$costomer%'
  GROUP BY A.id_order
  order by A.no_po, A.style, A.color";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_output_qc_endline_pilih_tanggal_grafik($tanggal, $lantai, $costomer)
{
  global $koneksi;

  $query = "SELECT A.line, B.supervisor, SUM(A.qty) total_output FROM transaksi_qc_endline A 
  JOIN master_line B ON A.line = B.nama_line 
  JOIN master_bundle C ON A.kode_barcode = C.barcode_bundle
  JOIN order_detail D ON C.id_order_detail = D.id_order_detail
  JOIN master_order E ON D.id_order = E.id_order
  JOIN costomer F ON E.id_costomer = F.id_costomer
   WHERE tanggal = '$tanggal' AND B.lantai = $lantai AND F.costomer like '%$costomer%'
   GROUP BY A.line
   order by A.line asc";


  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_output_qc_endline_pilih_bulan_grafik($bulan, $line, $costomer)
{
  global $koneksi;

  $query = "SELECT A.tanggal, SUM(A.qty) total_output FROM transaksi_qc_endline A 
  JOIN master_line B ON A.line = B.nama_line 
  JOIN master_bundle C ON A.kode_barcode = C.barcode_bundle
  JOIN order_detail D ON C.id_order_detail = D.id_order_detail
  JOIN master_order E ON D.id_order = E.id_order
  JOIN costomer F ON E.id_costomer = F.id_costomer
   WHERE MONTH(A.tanggal) = $bulan AND F.costomer LIKE '%$costomer%' AND A.line = '$line'
   GROUP BY A.tanggal";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}



function tampilkan_master_order_barcode_buyer_packing($style, $no_po, $costomer, $no_kenzin)
{
  global $koneksi;

  $query = "SELECT A.costomer, A.orc, A.no_po, A.label, A.style, A.color, A.qty_order, 
  (ifnull(C.qty_packing, 0)-A.qty_order) balance, (ifnull(B.qty_kenzin, 0)-ifnull(C.qty_packing, 0)) outstanding,
    ifnull(A.qty_karton, 0) qty_karton FROM 
  (SELECT C.costomer, A.id_order, A.orc, A.no_po, A.label, B.style, A.color, A.status, C.barcode_costomer, SUM(D.qty_order) qty_order , ifnull(E.qty_karton, 0) qty_karton
  FROM master_order A 
  JOIN style B ON A.id_style = B.id_style
  JOIN costomer C ON A.id_costomer = C.id_costomer
  JOIN order_detail D ON A.id_order = D.id_order
  LEFT OUTER JOIN master_qty_karton E ON A.id_style = E.id_style
  GROUP BY A.id_order
  ) A
  LEFT OUTER JOIN 
  (SELECT orc, SUM(qty) qty_kenzin FROM transaksi_kenzin
  GROUP BY orc)B
  ON A.orc = B.orc
  LEFT OUTER JOIN 
  (SELECT orc, SUM(qty) qty_packing FROM transaksi_packing
  GROUP BY orc)C
  ON A.orc = C.orc
  WHERE A.status = 'open' AND A.barcode_costomer = 'y' and A.style LIKE '%$style%' 
  AND A.no_po LIKE '%$no_po%' AND A.costomer like '%$costomer%' AND A.orc IN (SELECT orc from transaksi_kenzin WHERE no_trx = $no_kenzin)
  GROUP BY A.id_order
  order by A.no_po, A.style, A.color";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_data_no_transaksi_kenzin($style, $no_po, $costomer)
{
  global $koneksi;

  $query = "SELECT A.no_trx, D.costomer, A.orc, B.no_po, B.label, E.style, B.color, C.size, C.cup, sum(qty) qty_output, ifnull(A.qty_full_karton, 0) qty_karton, A.kelompok,
  (SELECT COUNT(no_trx) FROM transaksi_kenzin WHERE no_trx = A.no_trx) AS jumlah_trx,
  (SELECT COUNT(A2.no_po) FROM transaksi_kenzin A1 JOIN master_order A2 ON A1.orc = A2.orc  WHERE A1.no_trx = A.no_trx AND A2.no_po = B.no_po) AS jumlah_po,
  (SELECT COUNT(A2.orc) FROM transaksi_kenzin A1 JOIN master_order A2 ON A1.orc = A2.orc  WHERE A1.no_trx = A.no_trx AND A2.no_po = B.no_po AND A2.orc = B.orc) AS jumlah_orc,
  (SELECT SUM(qty) FROM transaksi_kenzin WHERE no_trx = A.no_trx) AS isi_karton  FROM transaksi_kenzin A
  JOIN master_order B ON A.orc = B.orc
  JOIN barang C ON A.kode_barcode = C.kode_barcode
  JOIN costomer D ON B.id_costomer = D.id_costomer
  JOIN style E ON C.id_style = E.id_style
  WHERE B.no_po LIKE '%$no_po%' AND E.style LIKE '%$style%' AND D.costomer LIKE '%$costomer%' AND A.status_kenzin = 'kenzin' 
  GROUP BY A.no_trx, B.orc, B.no_po, B.label, A.kode_barcode
  ORDER BY A.no_trx asc, E.style, A.kode_barcode";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_data_no_transaksi_kenzin_pilih($no_kenzin)
{
  global $koneksi;

  $query = "SELECT A.no_trx, D.costomer, A.orc, B.no_po, B.label, E.style, B.color, C.size, C.cup, sum(qty) qty_output, ifnull(A.qty_full_karton, 0)  qty_karton, A.kelompok,
  (SELECT COUNT(no_trx) FROM transaksi_kenzin WHERE no_trx = A.no_trx) AS jumlah_trx,
  (SELECT COUNT(A2.no_po) FROM transaksi_kenzin A1 JOIN master_order A2 ON A1.orc = A2.orc  WHERE A1.no_trx = A.no_trx AND A2.no_po = B.no_po) AS jumlah_po,
  (SELECT COUNT(A2.orc) FROM transaksi_kenzin A1 JOIN master_order A2 ON A1.orc = A2.orc  WHERE A1.no_trx = A.no_trx AND A2.no_po = B.no_po AND A2.orc = B.orc) AS jumlah_orc,
  (SELECT SUM(qty) FROM transaksi_kenzin WHERE no_trx = A.no_trx) AS isi_karton  FROM transaksi_kenzin A
  JOIN master_order B ON A.orc = B.orc
  JOIN barang C ON A.kode_barcode = C.kode_barcode
  JOIN costomer D ON B.id_costomer = D.id_costomer
  JOIN style E ON C.id_style = E.id_style
  WHERE A.no_trx = $no_kenzin
  GROUP BY A.no_trx, B.orc, B.no_po, B.label, A.kode_barcode
  ORDER BY A.no_trx asc, E.style, A.kode_barcode";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_balance_order_lookup_orc($id_order)
{
  global $koneksi;

  $query = "SELECT A.id_order, A.orc, A.id_style, A.size, A.qty_order, B.output, (B.output-A.qty_order) balance   FROM 
  (SELECT A.id_order, B.orc, B.id_style, A.size, A.qty_order FROM order_detail A 
  JOIN master_order B ON A.id_order = B.id_order )A
  LEFT OUTER JOIN 
  (SELECT A.orc, B.id_style, B.size, SUM(A.qty) output FROM transaksi_kenzin A
  JOIN barang B ON A.kode_barcode = B.kode_barcode
  GROUP BY A.orc, A.kode_barcode)B
  ON A.orc = B.orc AND A.id_style = B.id_style AND A.size = B.size
  WHERE (B.output-A.qty_order) != 0 AND A.id_order = $id_order
  ";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_style_bom($keterangan)
{
  global $koneksi;

  $query = "SELECT A.id_style, A.style, A.description, if(B.id_style = A.id_style, 'already', 'not_yet') keterangan, B.id_bom  FROM style A LEFT JOIN master_bom B ON A.id_style = B.id_style
 WHERE if(B.id_style = A.id_style, 'already', 'not_yet') = '$keterangan'
  order by A.id_style desc";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}



function tampilkan_master_style_bom_id($id)
{
  global $koneksi;

  $query = "SELECT A.id_style, A.style, A.description, if(B.id_style = A.id_style, 'already', 'not_yet') keterangan, B.id_bom  FROM style A LEFT JOIN master_bom B ON A.id_style = B.id_style
  WHERE A.id_style = $id
  order by A.id_style desc";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_bom_detail_part_id($id)
{
  global $koneksi;

  $query = "SELECT A.id_bom_detail, D.style  FROM master_bom_detail_part A

  WHERE A.id_bom_detail = $id";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_order_id($edit)
{
  global $koneksi;

  $query = "SELECT B.id_order, D.costomer, B.id_costomer, B.id_order, B.label, B.orc, B.no_po, B.label, B.id_style, C.style, C.item, B.color, B.status, SUM(A.qty_order)total,
            B.shipment_plan, B.prepare_on, B.qty_bundle, B.qty_order, E.category
            FROM order_detail A right join master_order B ON A.id_order = B.id_order JOIN style C ON B.id_style = C.id_style 
            JOIN costomer D ON B.id_costomer = D.id_costomer
            JOIN items E ON C.item = E.item
             where B.id_order = '$edit' GROUP BY b.orc";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_data_order_id($id_order)
{
  global $koneksi;

  $query = "SELECT A.id_order_detail, B.orc, B.qty_bundle, A.size, A.cup, A.qty_order FROM order_detail A JOIN master_order B ON A.id_order = B.id_order WHERE A.id_order = $id_order";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_temp_transaksi_part_cutting($id_order, $tanggal)
{
  global $koneksi;

  $query = "SELECT A.id_order, A.id_bom_detail_part, concat(A.material_code, ' - ', A.material_name) material, A.part, A.id_order_detail, A.size, A.cup, A.qty_order, ifnull(B.qty_temp,0) qty_temp, 
  B.id_transaksi, (IFNULL(C.qty_daily,0)+IFNULL(B.qty_temp,0)) qty_daily,(IFNULL(D.qty_total,0)+IFNULL(B.qty_temp,0)) qty_total, (IFNULL(D.qty_total,0)+IFNULL(B.qty_temp,0)-A.qty_order) balance,
  IFNULL(E.total_reject,0) total_reject, (IFNULL(D.qty_total,0)+IFNULL(B.qty_temp,0)-IFNULL(E.total_reject,0)) total_ok FROM

  (SELECT C.id_order, A.id_bom_detail_part, D.material_code, D.material_name, E.part, F.id_order_detail, F.size, F.cup, F.qty_order  FROM master_bom_detail_part_orc A
    JOIN master_bom_detail_orc B ON A.id_bom_detail_orc = B.id_bom_detail_orc
    JOIN master_bom_orc C ON B.id_bom_orc = C.id_bom_orc
    JOIN master_material D ON B.id_material = D.id_material
    JOIN master_part E ON A.id_part = E.id_part
    JOIN order_detail F ON C.id_order = F.id_order
    WHERE C.id_order = '$id_order'
    order by F.id_order_detail, D.material_code, E.part) A
    
    LEFT OUTER JOIN
  (SELECT A.id_bom_detail_part, A.id_order_detail, ifnull(SUM(A.qty), 0) qty_temp, A.id_transaksi FROM 
  temp_part_cutting A
  GROUP BY A.id_bom_detail_part , A.id_order_detail)B
  ON A.id_order_detail = B.id_order_detail AND A.id_bom_detail_part = B.id_bom_detail_part
  
  LEFT OUTER JOIN
  (SELECT A.id_bom_detail_part, A.id_order_detail, ifnull(SUM(A.qty), 0) qty_daily 
  FROM transaksi_part_cutting A 
  JOIN hd_transaksi_part_cutting B on A.no_trx = B.no_trx
  WHERE B.tanggal = '$tanggal' GROUP BY A.id_bom_detail_part , A.id_order_detail
  )C
  ON A.id_order_detail = C.id_order_detail AND A.id_bom_detail_part = C.id_bom_detail_part
  
  LEFT OUTER JOIN
  (SELECT A.id_bom_detail_part, A.id_order_detail, ifnull(SUM(A.qty), 0) qty_total FROM 
  transaksi_part_cutting A 
  JOIN hd_transaksi_part_cutting B on A.no_trx = B.no_trx
  WHERE B.tanggal <= '$tanggal' GROUP BY A.id_bom_detail_part , A.id_order_detail
  )D
  ON A.id_order_detail = D.id_order_detail AND A.id_bom_detail_part = D.id_bom_detail_part
  LEFT OUTER JOIN
  (SELECT A.id_bom_detail_part, A.id_order_detail, ifnull(SUM(A.qty), 0) total_reject FROM 
  transaksi_part_cutting_reject A 
  WHERE A.tanggal <= '$tanggal' GROUP BY A.id_bom_detail_part , A.id_order_detail
  )E
  ON A.id_order_detail = E.id_order_detail AND A.id_bom_detail_part = E.id_bom_detail_part  ";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_temp_transaksi_part_cutting_reject($id_order, $tanggal)
{
  global $koneksi;

  $query = "SELECT A.id_order, A.id_bom_detail_part, concat(A.material_code, ' - ', A.material_name) material,
   A.part, A.id_order_detail, A.size, A.cup, A.qty_order, IFNULL(B.qty_total,0) qty_total, IFNULL(C.temp_reject,0) temp_reject, 
  (IFNULL(D.days_reject, 0)+IFNULL(C.temp_reject,0)) days_reject, (IFNULL(E.total_reject, 0)+IFNULL(C.temp_reject,0)) total_reject, 
  (IFNULL(B.qty_total,0)-IFNULL(E.total_reject, 0)-IFNULL(C.temp_reject,0))total_ok, C.id_transaksi
  FROM
 
   (SELECT C.id_order, A.id_bom_detail_part, D.material_code, D.material_name, E.part, F.id_order_detail, F.size, F.cup, F.qty_order  FROM master_bom_detail_part_orc A
     JOIN master_bom_detail_orc B ON A.id_bom_detail_orc = B.id_bom_detail_orc
     JOIN master_bom_orc C ON B.id_bom_orc = C.id_bom_orc
     JOIN master_material D ON B.id_material = D.id_material
     JOIN master_part E ON A.id_part = E.id_part
     JOIN order_detail F ON C.id_order = F.id_order
     WHERE C.id_order = '$id_order'
     order by F.id_order_detail, D.material_code, E.part) A
     
   LEFT OUTER JOIN
   (SELECT A.id_bom_detail_part, A.id_order_detail, ifnull(SUM(A.qty), 0) qty_total FROM 
   transaksi_part_cutting A
   JOIN hd_transaksi_part_cutting B on A.no_trx = B.no_trx 
   WHERE B.tanggal <= '$tanggal' GROUP BY A.id_bom_detail_part , A.id_order_detail
   )B
   ON A.id_order_detail = B.id_order_detail AND A.id_bom_detail_part = B.id_bom_detail_part
     
   LEFT OUTER JOIN 
   (SELECT A.id_transaksi, A.id_bom_detail_part, A.id_order_detail, ifnull(SUM(A.qty), 0) temp_reject FROM 
   temp_part_cutting_reject A 
   WHERE A.tanggal <= '$tanggal' GROUP BY A.id_bom_detail_part , A.id_order_detail
   )C
   ON A.id_order_detail = C.id_order_detail AND A.id_bom_detail_part = C.id_bom_detail_part
 
   LEFT OUTER JOIN 
   (SELECT A.id_bom_detail_part, A.id_order_detail, ifnull(SUM(A.qty), 0) days_reject FROM 
   transaksi_part_cutting_reject A 
   WHERE A.tanggal = '$tanggal' GROUP BY A.id_bom_detail_part , A.id_order_detail
   )D
   ON A.id_order_detail = D.id_order_detail AND A.id_bom_detail_part = D.id_bom_detail_part	
 
   LEFT OUTER JOIN 
   (SELECT A.id_bom_detail_part, A.id_order_detail, ifnull(SUM(A.qty), 0) total_reject FROM 
   transaksi_part_cutting_reject A 
   WHERE A.tanggal <= '$tanggal' GROUP BY A.id_bom_detail_part , A.id_order_detail
   )E
   ON A.id_order_detail = E.id_order_detail AND A.id_bom_detail_part = E.id_bom_detail_part";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_temp_transaksi_part_cutting_transaksi($idiod, $idibdp, $tanggal)
{
  global $koneksi;

  $query = "SELECT A.id_transaksi, A.qty_order, IFNULL(A.qty_temp, 0) qty_temp, (IFNULL(B.qty_today, 0) + IFNULL(A.qty_temp, 0)) qty_today,
   (IFNULL(C.qty_total, 0) + IFNULL(A.qty_temp, 0)) qty_total,(IFNULL(C.qty_total, 0) + IFNULL(A.qty_temp, 0) - A.qty_order) balance ,
   IFNULL(D.total_reject, 0) total_reject, (IFNULL(C.qty_total, 0) + IFNULL(A.qty_temp, 0)-IFNULL(D.total_reject, 0)) total_ok
  FROM
 
 (SELECT A.id_transaksi, A.id_order_detail, A.id_bom_detail_part, B.qty_order, IFNULL(SUM(A.qty),0) qty_temp FROM temp_part_cutting A
 JOIN order_detail B ON A.id_order_detail = B.id_order_detail
 GROUP BY A.id_order_detail, A.id_bom_detail_part) A
 
 LEFT OUTER JOIN
 (SELECT A.id_order_detail, A.id_bom_detail_part, IFNULL(SUM(A.qty),0) qty_today FROM transaksi_part_cutting A
  WHERE A.tanggal = '$tanggal' GROUP BY A.id_order_detail, A.id_bom_detail_part) B
  ON A.id_order_detail = B.id_order_detail AND A.id_bom_detail_part = B.id_bom_detail_part
 
  LEFT OUTER JOIN
 (SELECT A.id_order_detail, A.id_bom_detail_part, IFNULL(SUM(A.qty),0) qty_total FROM transaksi_part_cutting A
  WHERE A.tanggal <= '$tanggal' GROUP BY A.id_order_detail, A.id_bom_detail_part) C
  ON A.id_order_detail = C.id_order_detail AND A.id_bom_detail_part = C.id_bom_detail_part
 
  LEFT OUTER JOIN
 (SELECT A.id_order_detail, A.id_bom_detail_part, IFNULL(SUM(A.qty),0) total_reject FROM transaksi_part_cutting_reject A
  WHERE A.tanggal <= '$tanggal' GROUP BY A.id_order_detail, A.id_bom_detail_part) D
  ON A.id_order_detail = D.id_order_detail AND A.id_bom_detail_part = D.id_bom_detail_part

  WHERE A.id_bom_detail_part = $idibdp AND A.id_order_detail = $idiod";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_temp_transaksi_part_cutting_reject_transaksi($idiod, $idibdp, $tanggal)
{
  global $koneksi;

  $query = "SELECT A.id_transaksi, A.qty_order, IFNULL(A.temp_reject, 0) temp_reject, (IFNULL(B.days_reject, 0) + IFNULL(A.temp_reject, 0)) days_reject, (IFNULL(C.total_reject, 0) + IFNULL(A.temp_reject, 0)) total_reject, 
  IFNULL(D.qty_total, 0) qty_total, (IFNULL(D.qty_total, 0) - IFNULL(C.total_reject, 0) - IFNULL(A.temp_reject, 0)) total_ok
    FROM
   
   (SELECT A.id_transaksi, A.id_order_detail, A.id_bom_detail_part, B.qty_order, IFNULL(SUM(A.qty),0) temp_reject FROM temp_part_cutting_reject A
   JOIN order_detail B ON A.id_order_detail = B.id_order_detail
   GROUP BY A.id_order_detail, A.id_bom_detail_part) A
   
   LEFT OUTER JOIN
   (SELECT A.id_order_detail, A.id_bom_detail_part, IFNULL(SUM(A.qty),0) days_reject FROM transaksi_part_cutting_reject A
    WHERE A.tanggal = '$tanggal' GROUP BY A.id_order_detail, A.id_bom_detail_part) B
    ON A.id_order_detail = B.id_order_detail AND A.id_bom_detail_part = B.id_bom_detail_part
   
    LEFT OUTER JOIN
   (SELECT A.id_order_detail, A.id_bom_detail_part, IFNULL(SUM(A.qty),0) total_reject FROM transaksi_part_cutting_reject A
    WHERE A.tanggal <= '$tanggal' GROUP BY A.id_order_detail, A.id_bom_detail_part) C
    ON A.id_order_detail = C.id_order_detail AND A.id_bom_detail_part = C.id_bom_detail_part
  
  LEFT OUTER JOIN
   (SELECT A.id_order_detail, A.id_bom_detail_part, IFNULL(SUM(A.qty),0) qty_total FROM transaksi_part_cutting A
    WHERE A.tanggal <= '$tanggal' GROUP BY A.id_order_detail, A.id_bom_detail_part) D
    ON A.id_order_detail = D.id_order_detail AND A.id_bom_detail_part = d.id_bom_detail_part
 
  WHERE A.id_bom_detail_part = $idibdp AND A.id_order_detail = $idiod";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_temp_transaksi_part_cutting_size($id_transaksi, $layer)
{
  global $koneksi;

  $query = "SELECT IFNULL(A.rasio,0) rasio, (IFNULL(A.rasio,0) * $layer) qty_total 
  FROM temp_part_cutting_size A 
  JOIN order_detail B on A.id_order_detail = B.id_order_detail 
  where A.id_transaksi = $id_transaksi";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_laporan_transaksi_part_cutting_udah_potong($tanggal, $category, $costomer, $no_po, $status, $orc, $style)
{
  global $koneksi;

  $query = "SELECT A.id_order, A.costomer, A.orc, A.no_po, A.style, A.item, A.color, A.id_bom_detail_part,
  concat(A.material_code, ' - ', A.material_name) material, IFNULL(H.tgl_orc_min, 'orc_blm') tgl_orc_min, IFNULL(F.tgl_mat_min, 'mat_blm') tgl_mat_min, 
  IFNULL(C.tgl_min, 'blm_cutting') tgl_min, IFNULL(C.tgl_max, 'blm_cutting') tgl_max, A.part, 
  IFNULL(A.qty_order, 0) qty_order, IFNULL(B.total_day, 0) total_day, IFNULL(C.total_qty, 0) total_qty,
   (IFNULL(C.total_qty, 0) - IFNULL(A.qty_order, 0)) balance, IFNULL(D.days_reject, 0) days_reject, 
   IFNULL(E.total_reject, 0) total_reject, (IFNULL(C.total_qty, 0) - IFNULL(E.total_reject, 0))total_ok, (IFNULL(E.total_reject, 0)/IFNULL(C.total_qty, 0)*100) persentase, G.full_set_ok
  FROM
    (SELECT  G.prepare_on, C.id_order, I.costomer, G.orc, G.no_po, H.style, G.color, H.item, J.category, A.id_bom_detail_orc, A.id_bom_detail_part, D.material_code, D.material_name, E.part, sum(F.qty_order) qty_order, G.status FROM master_bom_detail_part_orc A
      JOIN master_bom_detail_orc B ON A.id_bom_detail_orc = B.id_bom_detail_orc
      JOIN master_bom_orc C ON B.id_bom_orc = C.id_bom_orc
      JOIN master_material D ON B.id_material = D.id_material
      JOIN master_part E ON A.id_part = E.id_part
      JOIN order_detail F ON C.id_order = F.id_order
      JOIN master_order G ON C.id_order = G.id_order
      JOIN style H ON G.id_style = H.id_style
      JOIN costomer I ON G.id_costomer = I.id_costomer
      JOIN items J ON H.item = J.item
      GROUP BY C.id_order, A.id_bom_detail_part
      order BY C.id_order, D.material_code, E.part) A
   LEFT OUTER JOIN
    (SELECT B.id_order, A.id_bom_detail_part, ifnull(SUM(A.qty), 0) total_day
    FROM transaksi_part_cutting A
    JOIN order_detail B ON A.id_order_detail = B.id_order_detail
    JOIN hd_transaksi_part_cutting C on A.no_trx = C.no_trx 
    WHERE C.tanggal = '$tanggal'
    GROUP BY B.id_order, A.id_bom_detail_part)B
    ON A.id_order = B.id_order AND A.id_bom_detail_part = B.id_bom_detail_part
   LEFT OUTER JOIN
    (SELECT B.id_order, A.id_bom_detail_part, ifnull(SUM(A.qty), 0) total_qty, MIN(C.tanggal) tgl_min, MAX(A.tanggal) tgl_max
    FROM transaksi_part_cutting A
    JOIN order_detail B ON A.id_order_detail = B.id_order_detail
    JOIN hd_transaksi_part_cutting C on A.no_trx = C.no_trx 
    WHERE C.tanggal <= '$tanggal'
    GROUP BY B.id_order, A.id_bom_detail_part)C
    ON A.id_order = C.id_order AND A.id_bom_detail_part = C.id_bom_detail_part
  LEFT OUTER JOIN
    (SELECT B.id_order, A.id_bom_detail_part, ifnull(SUM(A.qty), 0) days_reject
    FROM transaksi_part_cutting_reject A
    JOIN order_detail B ON A.id_order_detail = B.id_order_detail
    WHERE A.tanggal = '$tanggal'
    GROUP BY B.id_order, A.id_bom_detail_part)D
    ON A.id_order = D.id_order AND A.id_bom_detail_part = D.id_bom_detail_part  
  LEFT OUTER JOIN
    (SELECT B.id_order, A.id_bom_detail_part, ifnull(SUM(A.qty), 0) total_reject
    FROM transaksi_part_cutting_reject A
    JOIN order_detail B ON A.id_order_detail = B.id_order_detail
    WHERE A.tanggal <= '$tanggal'
    GROUP BY B.id_order, A.id_bom_detail_part)E
    ON A.id_order = E.id_order AND A.id_bom_detail_part = E.id_bom_detail_part
  LEFT OUTER JOIN
    (SELECT B.id_order, C.id_bom_detail_orc, MIN(D.tanggal) tgl_mat_min 
    FROM transaksi_part_cutting A
    JOIN order_detail B ON A.id_order_detail = B.id_order_detail
    JOIN master_bom_detail_part_orc C ON A.id_bom_detail_part = C.id_bom_detail_part
    JOIN hd_transaksi_part_cutting D on A.no_trx = D.no_trx 
    WHERE D.tanggal <= '$tanggal'
    GROUP BY B.id_order, C.id_bom_detail_orc)F
    ON A.id_order = F.id_order AND A.id_bom_detail_orc = F.id_bom_detail_orc 
	LEFT OUTER JOIN
	(SELECT GA.id_order, MIN(GA.full_set_ok) full_set_ok FROM 
	  (SELECT G1.id_order, (IFNULL(G2.total_qty_cut,0)-IFNULL(G3.total_qty_rej,0))full_set_ok FROM
			(SELECT C.id_order, A.id_bom_detail_part, D.orc, E.style, F.costomer, G.category, D.status, D.no_po FROM master_bom_detail_part_orc A JOIN 
			master_bom_detail_orc B ON A.id_bom_detail_orc = B.id_bom_detail_orc
			JOIN master_bom_orc C ON B.id_bom_orc = C.id_bom_orc
			JOIN master_order D ON C.id_order = D.id_order
			JOIN style E ON D.id_style = E.id_style
			JOIN costomer F ON D.id_costomer = F.id_costomer
			JOIN items G ON E.item = G.item
			GROUP BY C.id_order, A.id_bom_detail_part)G1
		LEFT OUTER JOIN 
		(SELECT B.id_order, A.id_bom_detail_part, SUM(A.qty) total_qty_cut 
    FROM transaksi_part_cutting A 
    JOIN order_detail B ON A.id_order_detail = B.id_order_detail
    JOIN hd_transaksi_part_cutting C on A.no_trx = C.no_trx  
		 WHERE C.tanggal <= '$tanggal'
		 GROUP BY B.id_order, A.id_bom_detail_part)G2
		 ON G1.id_order = G2.id_order AND G1.id_bom_detail_part = G2.id_bom_detail_part
	LEFT OUTER JOIN 
		(SELECT B.id_order, A.id_bom_detail_part, SUM(A.qty) total_qty_rej FROM
		 transaksi_part_cutting_reject A JOIN order_detail B ON A.id_order_detail = B.id_order_detail
		 WHERE A.tanggal <= '$tanggal'
		 GROUP BY B.id_order, A.id_bom_detail_part)G3
		 ON G1.id_order = G3.id_order AND G1.id_bom_detail_part = G3.id_bom_detail_part
		  WHERE G1.category LIKE '%$category%' AND G1.costomer LIKE '%$costomer%' AND G1.no_po LIKE '%$no_po%'
    AND G1.orc LIKE '%$orc%' AND G1.style LIKE '%$style%' AND G1.status = 'open'
		 )GA
	GROUP BY GA.id_order)G
	ON A.id_order = G.id_order
	LEFT OUTER JOIN
    (SELECT B.id_order, MIN(C.tanggal) tgl_orc_min 
    FROM transaksi_part_cutting A
    JOIN order_detail B ON A.id_order_detail = B.id_order_detail
    JOIN hd_transaksi_part_cutting C on A.no_trx = C.no_trx 
    WHERE C.tanggal <= '$tanggal'
    GROUP BY B.id_order)H
    ON A.id_order = H.id_order

	
    WHERE A.category LIKE '%$category%' AND A.costomer LIKE '%$costomer%' AND A.no_po LIKE '%$no_po%'
    AND A.orc LIKE '%$orc%' AND A.style LIKE '%$style%' AND A.status = '$status'  AND  IFNULL(H.tgl_orc_min, 'orc_blm') NOT LIKE '%orc_blm%'
    ORDER BY A.prepare_on desc";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_laporan_transaksi_part_cutting_blm_potong($tanggal, $category, $costomer, $no_po, $status, $orc, $style)
{
  global $koneksi;

  $query = "SELECT A.id_order, A.costomer, A.orc, A.no_po, A.style, A.item, A.color, A.id_bom_detail_part,
  concat(A.material_code, ' - ', A.material_name) material, IFNULL(H.tgl_orc_min, 'orc_blm') tgl_orc_min, IFNULL(F.tgl_mat_min, 'mat_blm') tgl_mat_min, 
  IFNULL(C.tgl_min, 'blm_cutting') tgl_min, IFNULL(C.tgl_max, 'blm_cutting') tgl_max, A.part, 
  IFNULL(A.qty_order, 0) qty_order, IFNULL(B.total_day, 0) total_day, IFNULL(C.total_qty, 0) total_qty,
   (IFNULL(C.total_qty, 0) - IFNULL(A.qty_order, 0)) balance, IFNULL(D.days_reject, 0) days_reject, 
   IFNULL(E.total_reject, 0) total_reject, (IFNULL(C.total_qty, 0) - IFNULL(E.total_reject, 0))total_ok, (IFNULL(E.total_reject, 0)/IFNULL(C.total_qty, 0)*100) persentase, G.full_set_ok
  FROM
    (SELECT  G.prepare_on, C.id_order, I.costomer, G.orc, G.no_po, H.style, G.color, H.item, J.category, A.id_bom_detail_orc, A.id_bom_detail_part, D.material_code, D.material_name, E.part, sum(F.qty_order) qty_order, G.status FROM master_bom_detail_part_orc A
      JOIN master_bom_detail_orc B ON A.id_bom_detail_orc = B.id_bom_detail_orc
      JOIN master_bom_orc C ON B.id_bom_orc = C.id_bom_orc
      JOIN master_material D ON B.id_material = D.id_material
      JOIN master_part E ON A.id_part = E.id_part
      JOIN order_detail F ON C.id_order = F.id_order
      JOIN master_order G ON C.id_order = G.id_order
      JOIN style H ON G.id_style = H.id_style
      JOIN costomer I ON G.id_costomer = I.id_costomer
      JOIN items J ON H.item = J.item
      GROUP BY C.id_order, A.id_bom_detail_part
      order BY C.id_order, D.material_code, E.part) A
   LEFT OUTER JOIN
    (SELECT B.id_order, A.id_bom_detail_part, ifnull(SUM(A.qty), 0) total_day
    FROM transaksi_part_cutting A
    JOIN order_detail B ON A.id_order_detail = B.id_order_detail
    JOIN hd_transaksi_part_cutting C on A.no_trx = C.no_trx 
    WHERE C.tanggal = '$tanggal'
    GROUP BY B.id_order, A.id_bom_detail_part)B
    ON A.id_order = B.id_order AND A.id_bom_detail_part = B.id_bom_detail_part
   LEFT OUTER JOIN
    (SELECT B.id_order, A.id_bom_detail_part, ifnull(SUM(A.qty), 0) total_qty, MIN(C.tanggal) tgl_min, MAX(A.tanggal) tgl_max
    FROM transaksi_part_cutting A
    JOIN order_detail B ON A.id_order_detail = B.id_order_detail
    JOIN hd_transaksi_part_cutting C on A.no_trx = C.no_trx 
    WHERE A.tanggal <= '$tanggal'
    GROUP BY B.id_order, A.id_bom_detail_part)C
    ON A.id_order = C.id_order AND A.id_bom_detail_part = C.id_bom_detail_part
  LEFT OUTER JOIN
    (SELECT B.id_order, A.id_bom_detail_part, ifnull(SUM(A.qty), 0) days_reject
    FROM transaksi_part_cutting_reject A
    JOIN order_detail B ON A.id_order_detail = B.id_order_detail
    WHERE A.tanggal = '$tanggal'
    GROUP BY B.id_order, A.id_bom_detail_part)D
    ON A.id_order = D.id_order AND A.id_bom_detail_part = D.id_bom_detail_part  
  LEFT OUTER JOIN
    (SELECT B.id_order, A.id_bom_detail_part, ifnull(SUM(A.qty), 0) total_reject
    FROM transaksi_part_cutting_reject A
    JOIN order_detail B ON A.id_order_detail = B.id_order_detail
    WHERE A.tanggal <= '$tanggal'
    GROUP BY B.id_order, A.id_bom_detail_part)E
    ON A.id_order = E.id_order AND A.id_bom_detail_part = E.id_bom_detail_part
  LEFT OUTER JOIN
    (SELECT B.id_order, C.id_bom_detail_orc, MIN(D.tanggal) tgl_mat_min 
    FROM transaksi_part_cutting A
    JOIN order_detail B ON A.id_order_detail = B.id_order_detail
    JOIN master_bom_detail_part_orc C ON A.id_bom_detail_part = C.id_bom_detail_part
    JOIN hd_transaksi_part_cutting D on A.no_trx = D.no_trx 
    WHERE D.tanggal <= '$tanggal'
    GROUP BY B.id_order, C.id_bom_detail_orc)F
    ON A.id_order = F.id_order AND A.id_bom_detail_orc = F.id_bom_detail_orc 
	LEFT OUTER JOIN
	(SELECT GA.id_order, MIN(GA.full_set_ok) full_set_ok FROM 
	  (SELECT G1.id_order, (IFNULL(G2.total_qty_cut,0)-IFNULL(G3.total_qty_rej,0))full_set_ok FROM
			(SELECT C.id_order, A.id_bom_detail_part FROM master_bom_detail_part_orc A JOIN 
			master_bom_detail_orc B ON A.id_bom_detail_orc = B.id_bom_detail_orc
			JOIN master_bom_orc C ON B.id_bom_orc = C.id_bom_orc
			GROUP BY C.id_order, A.id_bom_detail_part)G1
		LEFT OUTER JOIN 
		(SELECT B.id_order, A.id_bom_detail_part, SUM(A.qty) total_qty_cut 
    FROM transaksi_part_cutting A 
    JOIN order_detail B ON A.id_order_detail = B.id_order_detail
    JOIN hd_transaksi_part_cutting C on A.no_trx = C.no_trx 
		 WHERE C.tanggal <= '$tanggal'
		 GROUP BY B.id_order, A.id_bom_detail_part)G2
		 ON G1.id_order = G2.id_order AND G1.id_bom_detail_part = G2.id_bom_detail_part
	LEFT OUTER JOIN 
		(SELECT B.id_order, A.id_bom_detail_part, SUM(A.qty) total_qty_rej FROM
		 transaksi_part_cutting_reject A JOIN order_detail B ON A.id_order_detail = B.id_order_detail
		 WHERE A.tanggal <= '$tanggal'
		 GROUP BY B.id_order, A.id_bom_detail_part)G3
		 ON G1.id_order = G3.id_order AND G1.id_bom_detail_part = G3.id_bom_detail_part)GA
	GROUP BY GA.id_order)G
	ON A.id_order = G.id_order
	LEFT OUTER JOIN
    (SELECT B.id_order, MIN(C.tanggal) tgl_orc_min 
    FROM transaksi_part_cutting A
    JOIN order_detail B ON A.id_order_detail = B.id_order_detail
    JOIN hd_transaksi_part_cutting C on A.no_trx = C.no_trx 
    WHERE C.tanggal <= '$tanggal'
    GROUP BY B.id_order)H
    ON A.id_order = H.id_order
	
    WHERE A.category LIKE '%$category%' AND A.costomer LIKE '%$costomer%' AND A.no_po LIKE '%$no_po%'
    AND A.orc LIKE '%$orc%' AND A.style LIKE '%$style%' AND A.status = '$status'  AND  IFNULL(H.tgl_orc_min, 'orc_blm') = 'orc_blm'
    ORDER BY A.prepare_on desc";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_laporan_transaksi_part_cutting_detail($id_bom_detail_part, $id_order)
{
  global $koneksi;

  $query = "SELECT A.id_order, A.orc, A.style, A.color, A.no_po, A.item, A.qty_order,  B.id_bom_detail_part, concat(B.material_code, ' - ', B.material_name) material, B.part FROM 
  (SELECT A.id_order, A.orc, C.style, A.color, A.no_po, C.item, sum(B.qty_order) qty_order FROM master_order A
  JOIN order_detail B ON A.id_order = B.id_order
  JOIN style C ON A.id_style = C.id_style
  GROUP BY A.id_order
  ) A
  LEFT OUTER JOIN
  (SELECT C.id_order, A.id_bom_detail_part, D.material_code, D.material_name, E.part FROM master_bom_detail_part_orc A
  JOIN master_bom_detail_orc B ON A.id_bom_detail_orc = B.id_bom_detail_orc
  JOIN master_bom_orc C ON B.id_bom_orc = C.id_bom_orc
  JOIN master_material D ON B.id_material = D.id_material
  JOIN master_part E ON A.id_part = E.id_part
  )B
  ON A.id_order = B.id_order
  WHERE A.id_order = $id_order AND B.id_bom_detail_part = $id_bom_detail_part
  ";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function tampilkan_laporan_transaksi_part_cutting_detail_size($id_order, $id_bom_detail_part, $tanggal)
{
  global $koneksi;

  $query = "SELECT A.id_order, A.id_order_detail, A.size, A.cup, IFNULL(C.tgl_min_potong,'blm_potong') tgl_min_potong,IFNULL(C.tgl_max_potong,'blm_potong') tgl_max_potong, A.qty_order,
   IFNULL(B.qty_day,0) total_day, IFNULL(C.total_qty,0) total_qty, (IFNULL(C.total_qty,0) - A.qty_order) balance, IFNULL(D.days_reject,0) days_reject,
   IFNULL(E.total_reject,0) total_reject, (IFNULL(E.total_reject,0)/IFNULL(C.total_qty,0)*100)persentase, ( IFNULL(C.total_qty,0) - IFNULL(E.total_reject,0)  ) total_ok  FROM 
  (SELECT C.id_order, F.size, F.cup, A.id_bom_detail_part, D.material_code, D.material_name, E.part, F.id_order_detail, F.qty_order  FROM master_bom_detail_part_orc A
      JOIN master_bom_detail_orc B ON A.id_bom_detail_orc = B.id_bom_detail_orc
      JOIN master_bom_orc C ON B.id_bom_orc = C.id_bom_orc
      JOIN master_material D ON B.id_material = D.id_material
      JOIN master_part E ON A.id_part = E.id_part
      JOIN order_detail F ON C.id_order = F.id_order
      GROUP BY F.id_order_detail, A.id_bom_detail_part
      order by F.id_order_detail, D.material_code, E.part
      )A
  LEFT OUTER JOIN 
    (SELECT A.id_order_detail, A.id_bom_detail_part, IFNULL(SUM(A.qty),0) qty_day 
    FROM transaksi_part_cutting A
    JOIN hd_transaksi_part_cutting B on A.no_trx = B.no_trx 
    WHERE B.tanggal = '$tanggal' 
    GROUP BY A.id_order_detail, A.id_bom_detail_part)B
  ON A.id_order_detail = B.id_order_detail AND A.id_bom_detail_part = B.id_bom_detail_part
  LEFT OUTER JOIN 
    (SELECT A.id_order_detail, A.id_bom_detail_part, MIN(B.tanggal) tgl_min_potong, MAX(B.tanggal) tgl_max_potong, IFNULL(SUM(A.qty),0) total_qty 
    FROM transaksi_part_cutting A
    JOIN hd_transaksi_part_cutting B on A.no_trx = B.no_trx 
    WHERE B.tanggal <= '$tanggal' 
    GROUP BY A.id_order_detail, A.id_bom_detail_part)C
    ON A.id_order_detail = c.id_order_detail AND A.id_bom_detail_part = C.id_bom_detail_part
  LEFT OUTER JOIN 
    (SELECT A.id_order_detail, A.id_bom_detail_part, IFNULL(SUM(A.qty),0) days_reject 
    FROM transaksi_part_cutting_reject A
    WHERE A.tanggal = '$tanggal' 
    GROUP BY A.id_order_detail, A.id_bom_detail_part)D
  ON A.id_order_detail = D.id_order_detail AND A.id_bom_detail_part = D.id_bom_detail_part
  LEFT OUTER JOIN 
    (SELECT A.id_order_detail, A.id_bom_detail_part, IFNULL(SUM(A.qty),0) total_reject 
    FROM transaksi_part_cutting_reject A
    WHERE A.tanggal <= '$tanggal' 
    GROUP BY A.id_order_detail, A.id_bom_detail_part)E
  ON A.id_order_detail = E.id_order_detail AND A.id_bom_detail_part = E.id_bom_detail_part
  WHERE A.id_order = $id_order AND A.id_bom_detail_part = $id_bom_detail_part
  ";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function tampil_master_bundle($id_order)
{
  global $koneksi;

  $query = "SELECT A.id_bundle, A.barcode_bundle, B.size, B.cup, A.no_urut, A.no_bundle, A.qty_isi_bundle, A.lot, IF(qty_isi_bundle >= C.qty_bundle, 'FULL', 'PECAHAN') keterangan FROM master_bundle A
  JOIN order_detail B ON A.id_order_detail = B.id_order_detail
  JOIN master_order C ON B.id_order = C.id_order
  WHERE B.id_order = $id_order
  order by B.id_order_detail, A.no_urut";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function tampil_master_bundle_id($id)
{
  global $koneksi;

  $query = "SELECT A.id_bundle, A.barcode_bundle, B.size, B.cup, A.no_urut, A.no_bundle, A.qty_isi_bundle, A.lot FROM master_bundle A
  JOIN order_detail B ON A.id_order_detail = B.id_order_detail
  JOIN master_order C ON B.id_order = C.id_order
  WHERE A.id_bundle = $id";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampil_master_target_id($id)
{
  global $koneksi;

  $query = "SELECT A.id, A.id_order, B.orc, D.costomer, B.no_po, C.style, B.color, A.nilai_smv, A.date_target, A.man_power, 
  A.jml_jam_normal, A.man_power_lembur, A.jml_lembur, A.persentase_target, A.line, A.remaks  FROM master_target A
  JOIN master_order B ON A.id_order = B.id_order
  JOIN style C ON B.id_style = C.id_style
  JOIN  costomer D ON B.id_costomer = D.id_costomer
  WHERE A.id = $id";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}



function edit_data_master_order($id, $style, $costomer, $po, $label, $color, $qty_order, $qty_bundle, $prepare_on, $shipment_plan)
{
  global $koneksi;

  $id = escape($id);
  $costomer = escape($costomer);
  $style = escape($style);
  $po = escape($po);
  $label = escape($label);
  $color = escape($color);
  $qty_order = escape($qty_order);
  $qty_bundle = escape($qty_bundle);
  $prepare_on = escape($prepare_on);
  $shipment_plan = escape($shipment_plan);

  $query = "UPDATE master_order SET id_costomer=$costomer, id_style=$style, no_po='$po', label = '$label', color = '$color', qty_order=$qty_order, qty_bundle=$qty_bundle, prepare_on= '$prepare_on', shipment_plan = '$shipment_plan'
  WHERE id_order='$id'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function edit_data_master_order2($id, $style, $costomer, $po, $label, $color, $qty_order)
{
  global $koneksi;

  $id = escape($id);
  $costomer = escape($costomer);
  $style = escape($style);
  $po = escape($po);
  $label = escape($label);
  $color = escape($color);
  $qty_order = escape($qty_order);

  $query = "UPDATE master_order SET id_costomer=$costomer, id_style=$style, no_po='$po', label = '$label', color = '$color', qty_order=$qty_order
  WHERE id_order='$id'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function edit_data_master_target($id, $username, $man_power, $jml_jam, $man_power_lembur, $jml_lembur, $line, $persentase)
{
  global $koneksi;

  $query = "UPDATE master_target SET man_power = '$man_power', jml_jam_normal = '$jml_jam', man_power_lembur = '$man_power_lembur', jml_lembur = '$jml_lembur', line = '$line'
  , persentase_target = $persentase, username_edit = '$username', waktu_edit = now()
  WHERE id='$id'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function edit_data_master_target_remaks($id, $username, $remaks)
{
  global $koneksi;

  $query = "UPDATE master_target SET remaks = '$remaks', username_edit = '$username', waktu_edit = now()
  WHERE id='$id'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function ubahsize_perorderdetail($id, $qty)
{
  global $koneksi;

  $query = "UPDATE order_detail SET qty_order = $qty WHERE id_order_detail= $id";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_sizeperoderterpilih($id)
{
  global $koneksi;

  $query = "SELECT id_order, qty_order, SUM(qty_order)total FROM order_detail where id_order_detail = $id";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanQtyperOrder($id)
{
  global $koneksi;

  $query = "SELECT sum(qty_order)total FROM order_detail where id_order = $id order by id_order_detail desc";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkanMasterOrder($id)
{
  global $koneksi;

  $query = "SELECT id_order_detail, id_order, size, qty_order FROM order_detail where id_order = $id order by id_order_detail desc LIMIT 1";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_line()
{
  global $koneksi;

  $query = "SELECT id_line, nama_line, lantai, supervisor, chief  FROM master_line WHERE `status`='aktif' ORDER BY nama_line";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_line_lantai($lantai)
{
  global $koneksi;

  $query = "SELECT nama_line from master_line where lantai = $lantai and status = 'aktif' order by nama_line";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_reject_type($type_reject)
{
  global $koneksi;

  $query = "SELECT id, nama_reject_eng, nama_reject_ind from master_reject where kategori like '%$type_reject%' order by id";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_line2($tgl)
{
  global $koneksi;

  $query = "SELECT A.id_line, A.nama_line, A.lantai, A.supervisor, A.chief, (SELECT B.jml_register_hrd FROM master_line_operator B WHERE B.id_line = A.id_line AND B.date_register <= '$tgl' ORDER BY B.date_register desc LIMIT 1 ) jmlh_operator from master_line A
  GROUP BY A.id_line order BY nama_line";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}



function tampilkan_master_line_open()
{
  global $koneksi;

  $query = "SELECT id_line, nama_line, lantai, supervisor, chief  from master_line where `status` = 'aktif' order by nama_line";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function tampilkan_level_user()
{
  global $koneksi;

  $query = "SELECT * from level_user order by urutan";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_master_consignee()
{
  global $koneksi;

  $query = "SELECT * from consignee";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function tampilkan_packinglist_aktif()
{
  global $koneksi;

  $query = "SELECT no_invoice, id_shipment from shipment where status='aktif'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_packinglist_aktif_no_approve()
{
  global $koneksi;

  $query = "SELECT no_invoice, id_shipment from shipment where status='aktif' and approve = 'n'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function transaksi_scan_packing($costomer, $po, $orc, $style)
{
  global $koneksi;

  $query = "SELECT C.orc, C.no_po, C.label, D.style, B.warna, A.no_trx, A.tanggal, A.jam, 
  group_concat(A.id_transaksi_packing) AS ids_to_delete,  
  A.no_trx,
            SUM(IF(B.size='W71', A.qty,0)) as size_w71,
            SUM(IF(B.size='W72', A.qty,0)) as size_w72,
            SUM(IF(B.size='W73', A.qty,0)) as size_w73,
            SUM(IF(B.size='W74', A.qty,0)) as size_w74,
            SUM(IF(B.size='W75', A.qty,0)) as size_w75,
            SUM(IF(B.size='W76', A.qty,0)) as size_w76,
            SUM(IF(B.size='W77', A.qty,0)) as size_w77,
            SUM(IF(B.size='W78', A.qty,0)) as size_w78,
            SUM(IF(B.size='W79', A.qty,0)) as size_w79,
            SUM(IF(B.size='W80', A.qty,0)) as size_w80,
            SUM(IF(B.size='W81', A.qty,0)) as size_w81,
            SUM(IF(B.size='W82', A.qty,0)) as size_w82,
            SUM(IF(B.size='W83', A.qty,0)) as size_w83,
            SUM(IF(B.size='W84', A.qty,0)) as size_w84,
            SUM(IF(B.size='W85', A.qty,0)) as size_w85,
            SUM(IF(B.size='W86', A.qty,0)) as size_w86,
            SUM(IF(B.size='W87', A.qty,0)) as size_w87,
            SUM(IF(B.size='W88', A.qty,0)) as size_w88,
            SUM(IF(B.size='W89', A.qty,0)) as size_w89,
            SUM(IF(B.size='W90', A.qty,0)) as size_w90,
            SUM(IF(B.size='W91', A.qty,0)) as size_w91,
            SUM(IF(B.size='W95', A.qty,0)) as size_w95,
            SUM(IF(B.size='W96', A.qty,0)) as size_w96,
            SUM(IF(B.size='W100', A.qty,0)) as size_w100,
            SUM(IF(B.size='W105', A.qty,0)) as size_w105,
            SUM(IF(B.size='W106', A.qty,0)) as size_w106,
            SUM(IF(B.size='W110', A.qty,0)) as size_w110,
            SUM(IF(B.size='W115', A.qty,0)) as size_w115,
            SUM(IF(B.size='W120', A.qty,0)) as size_w120,
            SUM(IF(B.size='W125', A.qty,0)) as size_w125,
            SUM(IF(B.size='W130', A.qty,0)) as size_w130,
            Sum(IF(B.size='70', A.qty,0)) as size_70,
            Sum(IF(B.size='73', A.qty,0)) as size_73,
            Sum(IF(B.size='76', A.qty,0)) as size_76,
            Sum(IF(B.size='79', A.qty,0)) as size_79,
            Sum(IF(B.size='82', A.qty,0)) as size_82,
            Sum(IF(B.size='85', A.qty,0)) as size_85,
            Sum(IF(B.size='88', A.qty,0)) as size_88,
            Sum(IF(B.size='91', A.qty,0)) as size_91,
            Sum(IF(B.size='95', A.qty,0)) as size_95,
            Sum(IF(B.size='100', A.qty,0)) as size_100,
            Sum(IF(B.size='105', A.qty,0)) as size_105,
            Sum(IF(B.size='110', A.qty,0)) as size_110,
            Sum(IF(B.size='115', A.qty,0)) as size_115,
            Sum(IF(B.size='120', A.qty,0)) as size_120,
            Sum(IF(B.size='130', A.qty,0)) as size_130,
            Sum(IF(B.size='140', A.qty,0)) as size_140,
            Sum(IF(B.size='150', A.qty,0)) as size_150,
            SUM(IF(B.size='86-3', A.qty,0)) as size_86_3,
            SUM(IF(B.size='90-4', A.qty,0)) as size_90_4,
            SUM(IF(B.size='94-5', A.qty,0)) as size_94_5,
            SUM(IF(B.size='98-6', A.qty,0)) as size_98_6, 
            SUM(IF(B.size='SS', A.qty,0)) AS size_ss,
            SUM(IF(B.size='S', A.qty,0)) AS size_s,
            SUM(IF(B.size='M', A.qty,0)) AS size_m,
            SUM(IF(B.size='L', A.qty,0)) AS size_l,
            SUM(IF(B.size='LL', A.qty,0)) AS size_ll,
            SUM(IF(B.size='3L', A.qty,0)) AS size_3l,
            SUM(IF(B.size='4L', A.qty,0)) AS size_4l,
            SUM(IF(B.size='5L', A.qty,0)) AS size_5l,
            SUM(IF(B.size='6L', A.qty,0)) AS size_6l,
            SUM(IF(B.size='7L', A.qty,0)) AS size_7l,
            SUM(IF(B.size='8L', A.qty,0)) AS size_8l,
            SUM(IF(B.size='0', A.qty,0)) as size_0,
            SUM(IF(B.size='1', A.qty,0)) as size_1,
            SUM(IF(B.size='2', A.qty,0)) as size_2,
            SUM(IF(B.size='3', A.qty,0)) as size_3,
            SUM(IF(B.size='4', A.qty,0)) as size_4,
            SUM(IF(B.size='5', A.qty,0)) as size_5,
            SUM(IF(B.size='6', A.qty,0)) as size_6,
            SUM(IF(B.size='7', A.qty,0)) as size_7,
            SUM(IF(B.size='8', A.qty,0)) as size_8,
            SUM(IF(B.size='9', A.qty,0)) as size_9,
            SUM(IF(B.size='10', A.qty,0)) as size_10,
            SUM(IF(B.size='11', A.qty,0)) as size_11,
            SUM(IF(B.size='12', A.qty,0)) as size_12,
            SUM(IF(B.size='13', A.qty,0)) as size_13,
            SUM(IF(B.size='14', A.qty,0)) as size_14,
            SUM(IF(B.size='15', A.qty,0)) as size_15,
            SUM(IF(B.size='16', A.qty,0)) as size_16,
            SUM(IF(B.size='17', A.qty,0)) as size_17,
            SUM(IF(B.size='18', A.qty,0)) as size_18,
            SUM(IF(B.size='19', A.qty,0)) as size_19,  
           sum(A.qty) AS jumlah_size,
           COUNT(DISTINCT A.no_trx) AS karton
	FROM transaksi_packing A
	join barang B ON A.kode_barcode = B.kode_barcode
	JOIN master_order	C ON A.orc = C.orc 
	JOIN style D ON B.id_style = D.id_style
	JOIN costomer E ON C.id_costomer = E.id_costomer
	WHERE C.no_po LIKE '%$po%' AND A.orc LIKE '%$orc%' AND D.style LIKE '%$style%' AND C.id_costomer = $costomer AND A.shipment = 'n' 
group by A.no_trx, A.orc, D.style, B.warna
order BY A.no_trx desc";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function transaksi_temp_shipment($invoice)
{
  global $koneksi;

  $query = "SELECT C.orc, C.no_po, C.label, D.style, B.warna, A.no_trx, A.tanggal_scan as tanggal,
  A.no_trx,
  				  Sum(IF(B.size='W70', A.qty,0)) as size_w70,
            SUM(IF(B.size='W71', A.qty,0)) as size_w71,
            SUM(IF(B.size='W72', A.qty,0)) as size_w72,
            SUM(IF(B.size='W73', A.qty,0)) as size_w73,
            SUM(IF(B.size='W74', A.qty,0)) as size_w74,
            SUM(IF(B.size='W75', A.qty,0)) as size_w75,
            SUM(IF(B.size='W76', A.qty,0)) as size_w76,
            SUM(IF(B.size='W77', A.qty,0)) as size_w77,
            SUM(IF(B.size='W78', A.qty,0)) as size_w78,
            SUM(IF(B.size='W79', A.qty,0)) as size_w79,
            SUM(IF(B.size='W80', A.qty,0)) as size_w80,
            SUM(IF(B.size='W81', A.qty,0)) as size_w81,
            SUM(IF(B.size='W82', A.qty,0)) as size_w82,
            SUM(IF(B.size='W83', A.qty,0)) as size_w83,
            SUM(IF(B.size='W84', A.qty,0)) as size_w84,
            SUM(IF(B.size='W85', A.qty,0)) as size_w85,
            SUM(IF(B.size='W86', A.qty,0)) as size_w86,
            SUM(IF(B.size='W87', A.qty,0)) as size_w87,
            SUM(IF(B.size='W88', A.qty,0)) as size_w88,
            SUM(IF(B.size='W89', A.qty,0)) as size_w89,
            SUM(IF(B.size='W90', A.qty,0)) as size_w90,
            SUM(IF(B.size='W91', A.qty,0)) as size_w91,
            SUM(IF(B.size='W95', A.qty,0)) as size_w95,
            SUM(IF(B.size='W96', A.qty,0)) as size_w96,
            SUM(IF(B.size='W100', A.qty,0)) as size_w100,
            SUM(IF(B.size='W105', A.qty,0)) as size_w105,
            SUM(IF(B.size='W106', A.qty,0)) as size_w106,
            SUM(IF(B.size='W110', A.qty,0)) as size_w110,
            SUM(IF(B.size='W115', A.qty,0)) as size_w115,
            SUM(IF(B.size='W120', A.qty,0)) as size_w120,
            SUM(IF(B.size='W125', A.qty,0)) as size_w125,
            SUM(IF(B.size='W130', A.qty,0)) as size_w130,
            Sum(IF(B.size='70', A.qty,0)) as size_70,
            Sum(IF(B.size='73', A.qty,0)) as size_73,
            Sum(IF(B.size='76', A.qty,0)) as size_76,
            Sum(IF(B.size='79', A.qty,0)) as size_79,
            Sum(IF(B.size='82', A.qty,0)) as size_82,
            Sum(IF(B.size='85', A.qty,0)) as size_85,
            Sum(IF(B.size='88', A.qty,0)) as size_88,
            Sum(IF(B.size='91', A.qty,0)) as size_91,
            Sum(IF(B.size='95', A.qty,0)) as size_95,
            Sum(IF(B.size='100', A.qty,0)) as size_100,
            Sum(IF(B.size='105', A.qty,0)) as size_105,
            Sum(IF(B.size='110', A.qty,0)) as size_110,
            Sum(IF(B.size='115', A.qty,0)) as size_115,
            Sum(IF(B.size='120', A.qty,0)) as size_120,
            Sum(IF(B.size='130', A.qty,0)) as size_130,
            Sum(IF(B.size='140', A.qty,0)) as size_140,
            Sum(IF(B.size='150', A.qty,0)) as size_150,	
            SUM(IF(B.size='86-3', A.qty,0)) as size_86_3,
            SUM(IF(B.size='90-4', A.qty,0)) as size_90_4,
            SUM(IF(B.size='94-5', A.qty,0)) as size_94_5,
            SUM(IF(B.size='98-6', A.qty,0)) as size_98_6, 
            SUM(IF(B.size='SS', A.qty,0)) AS size_ss,
            SUM(IF(B.size='S', A.qty,0)) AS size_s,
            SUM(IF(B.size='M', A.qty,0)) AS size_m,
            SUM(IF(B.size='L', A.qty,0)) AS size_l,
            SUM(IF(B.size='LL', A.qty,0)) AS size_ll,
            SUM(IF(B.size='3L', A.qty,0)) AS size_3l,
            SUM(IF(B.size='4L', A.qty,0)) AS size_4l,
            SUM(IF(B.size='5L', A.qty,0)) AS size_5l,
            SUM(IF(B.size='6L', A.qty,0)) AS size_6l,
            SUM(IF(B.size='7L', A.qty,0)) AS size_7l,
            SUM(IF(B.size='8L', A.qty,0)) AS size_8l,
            SUM(IF(B.size='0', A.qty,0)) as size_0,
            SUM(IF(B.size='1', A.qty,0)) as size_1,
            SUM(IF(B.size='2', A.qty,0)) as size_2,
            SUM(IF(B.size='3', A.qty,0)) as size_3,
            SUM(IF(B.size='4', A.qty,0)) as size_4,
            SUM(IF(B.size='5', A.qty,0)) as size_5,
            SUM(IF(B.size='6', A.qty,0)) as size_6,
            SUM(IF(B.size='7', A.qty,0)) as size_7,
            SUM(IF(B.size='8', A.qty,0)) as size_8,
            SUM(IF(B.size='9', A.qty,0)) as size_9,
            SUM(IF(B.size='10', A.qty,0)) as size_10,
            SUM(IF(B.size='11', A.qty,0)) as size_11,
            SUM(IF(B.size='12', A.qty,0)) as size_12,
            SUM(IF(B.size='13', A.qty,0)) as size_13,
            SUM(IF(B.size='14', A.qty,0)) as size_14,
            SUM(IF(B.size='15', A.qty,0)) as size_15,
            SUM(IF(B.size='16', A.qty,0)) as size_16,
            SUM(IF(B.size='17', A.qty,0)) as size_17,
            SUM(IF(B.size='18', A.qty,0)) as size_18,
            SUM(IF(B.size='19', A.qty,0)) as size_19,  
           SUM(A.qty) AS jumlah_size,
           COUNT(DISTINCT A.no_trx) AS karton
	FROM transaksi_shipment A
	join barang B ON A.kode_barcode = B.kode_barcode
	JOIN master_order	C ON A.orc = C.orc 
	JOIN style D ON B.id_style = D.id_style
	JOIN costomer E ON C.id_costomer = E.id_costomer
	JOIN shipment F ON A.id_shipment = F.id_shipment
	WHERE A.id_shipment = $invoice 
group by A.no_trx, A.orc, D.style, B.warna
order BY A.no_trx desc";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function transaksi_scan_packing_b()
{
  global $koneksi;

  $query = "SELECT E.no_po, F.label, D.style, B.warna, A.no_karton, A.tanggal, A.jam, 
  group_concat(A.id_transaksi_packing) AS ids_to_delete,   
      Sum(IF(B.size='W70', 1,0)) as size_w70,
      Sum(IF(B.size='W73', 1,0)) as size_w73,
      Sum(IF(B.size='W74', 1,0)) as size_w74,
      Sum(IF(B.size='W76', 1,0)) as size_w76,
      Sum(IF(B.size='W78', 1,0)) as size_w78,
      Sum(IF(B.size='W79', 1,0)) as size_w79,
      Sum(IF(B.size='W82', 1,0)) as size_w82,
      Sum(IF(B.size='W85', 1,0)) as size_w85,
      Sum(IF(B.size='W86', 1,0)) as size_w86,
      Sum(IF(B.size='W88', 1,0)) as size_w88,
      Sum(IF(B.size='W90', 1,0)) as size_w90,
      Sum(IF(B.size='W91', 1,0)) as size_w91,
      Sum(IF(B.size='W95', 1,0)) as size_w95,
      Sum(IF(B.size='W96', 1,0)) as size_w96,
      Sum(IF(B.size='W100', 1,0)) as size_w100,
      Sum(IF(B.size='W105', 1,0)) as size_w105,
      Sum(IF(B.size='W106', 1,0)) as size_w106,
      Sum(IF(B.size='W110', 1,0)) as size_w110,
      Sum(IF(B.size='W115', 1,0)) as size_w115,
      Sum(IF(B.size='W120', 1,0)) as size_w120,
      Sum(IF(B.size='W125', 1,0)) as size_w125,
     COUNT(B.size) AS jumlah_size,
     COUNT(DISTINCT A.no_karton) AS karton
  FROM transaksi_packing A
  join barang B ON A.kode_barcode = B.kode_barcode
  JOIN master_order	C ON A.orc = C.orc 
  JOIN style D ON B.id_style = D.id_style
  JOIN po E ON C.id_po = E.id_po
  JOIN label F ON C.id_label = F.id_label
  JOIN size G ON B.size = G.size		
  WHERE G.kelompok_size = 'b' 
  group by A.no_karton, A.orc, D.style, B.warna
  order BY A.no_karton desc";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function transaksi_shipment()
{
  global $koneksi;

  $query = "SELECT E.no_po, F.label, D.style, B.warna, A.no_karton, A.tanggal_scan, A.jam_scan, 
  group_concat(A.id_transaksi_shipment) AS ids_to_delete,   
           SUM(IF(B.size='SS',1,0)) AS size_ss,
           SUM(IF(B.size='S',1,0)) AS size_s,
           SUM(IF(B.size='M',1,0)) AS size_m,
           SUM(IF(B.size='L',1,0)) AS size_l,
           SUM(IF(B.size='LL',1,0)) AS size_ll,
           SUM(IF(B.size='3L',1,0)) AS size_3l,
           SUM(IF(B.size='4L',1,0)) AS size_4l,
           SUM(IF(B.size='5L',1,0)) AS size_5l,
           SUM(IF(B.size='6L',1,0)) AS size_6l,
           SUM(IF(B.size='7L',1,0)) AS size_7l,
           SUM(IF(B.size='8L',1,0)) AS size_8l,
           COUNT(B.size) AS jumlah_size,
           COUNT(DISTINCT A.no_karton) AS karton, H.no_invoice
	FROM transaksi_shipment A
	join barang B ON A.kode_barcode = B.kode_barcode
	JOIN master_order	C ON A.orc = C.orc 
	JOIN style D ON B.id_style = D.id_style
	JOIN po E ON C.id_po = E.id_po
	JOIN label F ON C.id_label = F.id_label
	JOIN size G ON B.size = G.size
	JOIN shipment H ON A.id_shipment = H.id_shipment		
	  WHERE G.kelompok_size = 'a' AND H.`status` = 'aktif'
group by A.no_karton, A.orc, D.style, B.warna
order BY A.no_karton desc";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function transaksi_shipment_b()
{
  global $koneksi;

  $query = "SELECT E.no_po, F.label, D.style, B.warna, A.no_karton, A.tanggal_scan, A.jam_scan, 
  group_concat(A.id_transaksi_shipment) AS ids_to_delete,   
            Sum(IF(B.size='W70', 1,0)) as size_w70,
            Sum(IF(B.size='W73', 1,0)) as size_w73,
            Sum(IF(B.size='W76', 1,0)) as size_w76,
            Sum(IF(B.size='W79', 1,0)) as size_w79,
            Sum(IF(B.size='W82', 1,0)) as size_w82,
            Sum(IF(B.size='W85', 1,0)) as size_w85,
            Sum(IF(B.size='W88', 1,0)) as size_w88,
            Sum(IF(B.size='W90', 1,0)) as size_w90,
            Sum(IF(B.size='W91', 1,0)) as size_w91,
            Sum(IF(B.size='W95', 1,0)) as size_w95,
            Sum(IF(B.size='W96', 1,0)) as size_w96,
            Sum(IF(B.size='W100', 1,0)) as size_w100,
            Sum(IF(B.size='W105', 1,0)) as size_w105,
            Sum(IF(B.size='W106', 1,0)) as size_w106,
            Sum(IF(B.size='W110', 1,0)) as size_w110,
            Sum(IF(B.size='W115', 1,0)) as size_w115,
            Sum(IF(B.size='W120', 1,0)) as size_w120,
            Sum(IF(B.size='W125', 1,0)) as size_w125,
           COUNT(B.size) AS jumlah_size,
           COUNT(DISTINCT A.no_karton) AS karton, H.no_invoice
	FROM transaksi_shipment A
	join barang B ON A.kode_barcode = B.kode_barcode
	JOIN master_order	C ON A.orc = C.orc 
	JOIN style D ON B.id_style = D.id_style
	JOIN po E ON C.id_po = E.id_po
	JOIN label F ON C.id_label = F.id_label
	JOIN size G ON B.size = G.size
	JOIN shipment H ON A.id_shipment = H.id_shipment		
	  WHERE G.kelompok_size = 'b' AND H.`status` = 'aktif'
group by A.no_karton, A.orc, D.style, B.warna
order BY A.no_karton desc";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function transaksi_shipment_c()
{
  global $koneksi;

  $query = "SELECT E.no_po, F.label, D.style, B.warna, A.no_karton, A.tanggal_scan, A.jam_scan, 
  group_concat(A.id_transaksi_shipment) AS ids_to_delete,   
  SUM(IF(B.size='7',1,0)) AS size_7,
           SUM(IF(B.size='9',1,0)) AS size_9,
           SUM(IF(B.size='11',1,0)) AS size_11,
           SUM(IF(B.size='13',1,0)) AS size_13,
           SUM(IF(B.size='15',1,0)) AS size_15,
           SUM(IF(B.size='17',1,0)) AS size_17,
           SUM(IF(B.size='19',1,0)) AS size_19,
           COUNT(B.size) AS jumlah_size,
           COUNT(DISTINCT A.no_karton) AS karton, H.no_invoice
	FROM transaksi_shipment A
	join barang B ON A.kode_barcode = B.kode_barcode
	JOIN master_order	C ON A.orc = C.orc 
	JOIN style D ON B.id_style = D.id_style
	JOIN po E ON C.id_po = E.id_po
	JOIN label F ON C.id_label = F.id_label
	JOIN size G ON B.size = G.size
	JOIN shipment H ON A.id_shipment = H.id_shipment		
	  WHERE G.kelompok_size = 'c' AND H.`status` = 'aktif'
group by A.no_karton, A.orc, D.style, B.warna
order BY A.no_karton desc";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function transaksi_reject_packing()
{
  global $koneksi;

  $query = "SELECT po.no_po, style.style, barang.warna, reject_packing.no_karton, reject_packing.waktu_reject,
         reject_packing.keterangan, 
         group_concat(reject_packing.id_transaksi_reject) AS ids_to_delete,   
                  SUM(IF(barang.size='SS',1,0)) AS size_ss,
                  SUM(IF(barang.size='S',1,0)) AS size_s,
                  SUM(IF(barang.size='M',1,0)) AS size_m,
                  SUM(IF(barang.size='L',1,0)) AS size_l,
                  SUM(IF(barang.size='LL',1,0)) AS size_ll,
                  SUM(IF(barang.size='3L',1,0)) AS size_3l,
                  SUM(IF(barang.size='4L',1,0)) AS size_4l,
                  SUM(IF(barang.size='5L',1,0)) AS size_5l,
                  SUM(IF(barang.size='6L',1,0)) AS size_6l,
                  SUM(IF(barang.size='7L',1,0)) AS size_7l,
                  SUM(IF(barang.size='8L',1,0)) AS size_8l,
                  COUNT(barang.size) AS jumlah_size ,
                  COUNT(DISTINCT reject_packing.no_karton) AS karton
                  FROM barang join reject_packing on barang.kode_barcode = reject_packing.kode_barcode
  join po on po.id_po = reject_packing.id_po join style on barang.id_style = style.id_style  
   group by reject_packing.no_karton, reject_packing.id_po, barang.warna
   order by no_karton desc";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

// ================================== TAMBAH DATA  ==================================================

function tambah_data_master_bundle($id_order_detail, $i, $no_bundle, $barcode_bundle, $qtyisibundle, $username)
{

  $query = "INSERT INTO master_bundle (id_order_detail, no_urut, no_bundle, barcode_bundle, qty_isi_bundle, username, waktu)
  VALUES ($id_order_detail, $i, '$no_bundle', '$barcode_bundle', $qtyisibundle, '$username', now())";
  return run($query);
}

function tambah_data_master_target($id_order, $username, $nilai_smv, $date_target, $man_power, $jml_jam, $man_power_lembur, $jml_lembur, $line, $persentase)
{

  $query = "INSERT INTO master_target (date_target, id_order, nilai_smv, persentase_target, line, man_power, jml_jam_normal, man_power_lembur, jml_lembur, username, waktu)
  VALUES ('$date_target', $id_order, $nilai_smv, $persentase, '$line', $man_power, $jml_jam, $man_power_lembur, $jml_lembur, '$username', now())";

  return run($query);
}

function tambah_data_master_part($part, $status, $username)
{

  $query = "INSERT INTO master_part (part, status, username, waktu)
  VALUES ('$part', '$status', '$username', now())";
  return run($query);
}

function tambah_data_consignee($consignee, $address, $country)
{

  $query = "INSERT INTO master_part (part, status, username, waktu)
  VALUES ('$part', '$status', '$username', now())";
  return run($query);
}

function tambah_data_master_bom_orc($id_order, $id_bom, $username)
{

  $query = "INSERT INTO master_bom_orc (id_order, id_bom, username, waktu)
  VALUES ($id_order, $id_bom, '$username', now())";
  return run($query);
}


function tambah_data_proses_transaksi_orc($id_order, $proses, $urutan, $username)
{

  $query = "INSERT INTO proses_transaksi_orc (id_order, nama_transaksi, urutan, waktu, username)
  VALUES ($id_order, '$proses', $urutan, now(), '$username')";
  return run($query);
}

function tambah_data_temp_kenzin($tanggal, $jam, $kode_barcode, $orc, $qty, $no_trx, $user)
{
  $kode_barcode = escape($kode_barcode);

  $query = "INSERT INTO temp_kenzin (tanggal, jam, kode_barcode, orc, qty, no_trx, username)
  VALUES ('$tanggal', '$jam', '$kode_barcode', '$orc', $qty, $no_trx, '$user')";
  return run($query);
}

function tambah_data_temp_production_bundle($tanggal, $jam, $kode_barcode, $qty_scan, $no_trx, $user, $temp_table)
{
  $kode_barcode = escape($kode_barcode);

  $query = "INSERT INTO $temp_table (tanggal, jam, kode_barcode, qty, no_trx, username)
  VALUES ('$tanggal', '$jam', '$kode_barcode', $qty_scan, $no_trx, '$user')";
  return run($query);
}


function tambah_data_temp_qcfinal($tanggal, $jam, $kode_barcode, $orc, $qty, $no_trx, $user)
{
  $kode_barcode = escape($kode_barcode);

  $query = "INSERT INTO temp_qcfinal (tanggal, jam, kode_barcode, orc, qty, no_trx, username)
  VALUES ('$tanggal', '$jam', '$kode_barcode', '$orc', $qty, $no_trx, '$user')";
  return run($query);
}

function tambah_data_temp_tatami_in($tanggal, $jam, $kode_barcode, $qty, $no_trx, $user)
{
  $kode_barcode = escape($kode_barcode);

  $query = "INSERT INTO temp_tatami_in (tanggal, jam, kode_barcode, qty, no_trx, username)
  VALUES ('$tanggal', '$jam', '$kode_barcode', $qty, $no_trx, '$user')";
  return run($query);
}

function tambah_data_temp_tatami_reject($tanggal, $jam, $kode_barcode, $qty, $no_trx, $user)
{
  $kode_barcode = escape($kode_barcode);

  $query = "INSERT INTO temp_reject_tatami (tanggal, jam, kode_barcode, qty, no_trx, username)
  VALUES ('$tanggal', '$jam', '$kode_barcode', $qty, $no_trx, '$user')";
  return run($query);
}

function tambah_data_temp_qc_kensa($tanggal, $jam, $kode_barcode, $qty, $no_trx, $user)
{
  $kode_barcode = escape($kode_barcode);

  $query = "INSERT INTO temp_qc_kensa (tanggal, jam, kode_barcode, qty, no_trx, username)
  VALUES ('$tanggal', '$jam', '$kode_barcode', $qty, $no_trx, '$user')";
  return run($query);
}

function tambah_data_temp_tatami_out($tanggal, $jam, $kode_barcode, $qty, $no_trx, $user)
{
  $kode_barcode = escape($kode_barcode);

  $query = "INSERT INTO temp_tatami_out (tanggal, jam, kode_barcode, qty, no_trx, username)
  VALUES ('$tanggal', '$jam', '$kode_barcode', $qty, $no_trx, '$user')";
  return run($query);
}

function tambah_data_temp_ganti_label($tanggal, $jam, $kode_barcode, $orc, $tolabel, $qty)
{
  $query = "INSERT INTO temp_ganti_label (tanggal, jam, kode_barcode, orc, ke_label, qty)
  VALUES ('$tanggal', '$jam', '$kode_barcode', '$orc', '$tolabel', $qty)";
  return run($query);
}

function tambah_data_temp_packing($tanggal, $jam, $kode_barcode, $orc, $qty, $no_trx, $user)
{
  $kode_barcode = escape($kode_barcode);

  $query = "INSERT INTO temp_packing (tanggal, jam, kode_barcode, orc, qty, no_trx, username)
  VALUES ('$tanggal', '$jam', '$kode_barcode', '$orc', $qty, $no_trx, '$user')";
  return run($query);
}

function tambah_data_packing($tanggal, $jam, $kode_barcode, $orc, $qty, $no_trx, $user, $kelompokTrx)
{
  $kode_barcode = escape($kode_barcode);

  $query = "INSERT INTO transaksi_packing (tanggal, jam, kode_barcode, orc, qty, no_trx, user_input, kelompok)
  VALUES ('$tanggal', '$jam', '$kode_barcode', '$orc', $qty, $no_trx, '$user', '$kelompokTrx')";
  return run($query);
}

function tambah_data_temp_order($size, $qtyorder, $user, $barcode, $cup)
{
  $query = "INSERT INTO temp_order_detail (size, qty_order, username, barcode, cup) VALUES ('$size', $qtyorder, '$user', '$barcode', '$cup')";
  return run($query);
}

function tambah_size_order($id, $size, $cup, $qtyorder, $user, $barcode)
{
  $query = "INSERT INTO order_detail (id_order, size, cup, qty_order, username, barcode_number) VALUES ($id, '$size', '$cup', $qtyorder, '$user', '$barcode')";
  return run($query);
}

function tambah_master_line_operator($id_line, $date_register, $jml_register_hrd, $user)
{
  $query = "INSERT INTO master_line_operator (id_line, date_register, jml_register_hrd, username, waktu) VALUES ($id_line, '$date_register', '$jml_register_hrd', '$user', now())";
  return run($query);
}

function tambah_data_preparation_production($id_order, $line, $day_proses, $plan_date, $username)
{

  $query = "INSERT INTO production_preparation (id_order, plan_line, days_proses, plan_production, user_add, create_date)
  VALUES ($id_order, '$line',  $day_proses, '$plan_date', '$username', now())";
  return run($query);
}


function tambah_data_style($style, $description, $item, $costomer, $username)
{
  $query = "INSERT INTO style (style, description, item, id_costomer, username, waktu) VALUES ('$style', '$description', '$item', $costomer, '$username', now())";
  return run($query);
}

function tambah_data_style_color($id, $color, $username)
{
  $query = "INSERT INTO style_color (id_style, color_style, username, waktu) VALUES ($id, '$color', '$username', now() )";
  return run($query);
}

function tambah_data_material($material_code, $material_name, $username)
{
  $query = "INSERT INTO master_material (material_code, material_name, username, waktu) VALUES 
  ('$material_code', '$material_name', '$username', now())";
  return run($query);
}

function tambah_data_material_color($id, $color, $username)
{
  $query = "INSERT INTO master_material_color (id_material, color_material, username, waktu) VALUES ($id, '$color', '$username', now() )";
  return run($query);
}

function tambah_data_barang($kode_barcode, $style, $warna, $size, $cup, $qty_barcode)
{
  $query = "INSERT INTO barang (kode_barcode, id_style, warna, size, cup, qty_barcode, date_create, from_costomer)
  VALUES ('$kode_barcode', $style, '$warna', '$size', '$cup', $qty_barcode, now(), 'y')";
  return run($query);
}

function tambah_master_barang_no_barcode_buyer($barcode2, $idstyle, $size, $color)
{
  $query = "INSERT INTO barang (kode_barcode, id_style, warna, size, weight, date_create, from_costomer)
  VALUES ('$barcode2', $idstyle, '$color', '$size', 0, now(), 'n'";
  return run($query);
}

function tambah_data_size($size)
{
  $ct = escape($size);
  $query = "INSERT INTO size (size) VALUES ('$ct')";
  $result = run($query);
  var_dump($result);
  // return run($query);
}

function tambah_data_description($costomer, $barcode_costomer)
{
  $costomer = escape($costomer);
  $barcode_costomer = escape($barcode_costomer);
  $query = "INSERT INTO costomer (costomer, barcode_costomer) VALUES ('$costomer', '$barcode_costomer')";
  return run($query);
}

function tambah_data_line($line, $lantai, $supervisor, $chief, $user)
{
  $query = "INSERT INTO master_line (nama_line, lantai, supervisor, chief, status, created_by, time_create)
  VALUES ('$line', $lantai, '$supervisor', '$chief', 'aktif', '$user', now())";

  return run($query);
}

function tambah_data_contract($contract, $total_order)
{
  $contract = escape($contract);
  $query = "INSERT INTO contract_number (no_contract, total_order, status)
  VALUES ('$contract', $total_order, 'open')";

  return run($query);
}

function tambah_data_item($item, $category)
{
  $contract = escape($item);
  $query = "INSERT INTO items (item, category)
  VALUES ('$item', '$category')";

  return run($query);
}

function tambah_data_master_qty_karton($style, $qty_karton, $username)
{
  global $koneksi;

  $style = escape($style);
  $qty_karton = escape($qty_karton);
  $query = "INSERT INTO master_qty_karton (id_style, qty_karton, username, waktu)
  VALUES ($style, $qty_karton, '$username', now())";

  return run($query);
}

function tambah_data_master_qty_karton_full($orc, $qty_karton, $username)
{
  global $koneksi;
  $orc = escape($orc);
  $qty_karton = escape($qty_karton);

  $queryOrder = "SELECT * FROM master_order WHERE orc='$orc'";
  // $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  $responseOrder = mysqli_query($koneksi, $queryOrder) or die('gagal');
  $rstOrder = mysqli_fetch_assoc($responseOrder);
  // var_dump($rstOrder);
  if($rstOrder){
    $id_order = $rstOrder['id_order'];
    $id_style = $rstOrder['id_style'];
    $qty_order = $rstOrder['qty_order'];
    $qty_qrcode = ceil($qty_order/$qty_karton);
    $dateNow = date('Y-m-d H:i:s');

    $queryKartonFull = "INSERT INTO master_qty_karton_full 
                        (id_style, id_order, qty_karton, qty_qrcode, username, waktu, username_edit, waktu_edit)
                        VALUES ('$id_style', '$id_order', '$qty_karton', '$qty_qrcode', '$username', '$dateNow', '$username', '$dateNow')";
    
    $rst = mysqli_query($koneksi, $queryKartonFull) or die('gagal menampilkan data');

    $insertedID = mysqli_insert_id($koneksi);
  
    return $insertedID;
  }
}

function get_data_master_order_by_orc($orc){
  global $koneksi;

  $queryOrder = "SELECT * FROM master_order WHERE orc='$orc'";
  $responseOrder = mysqli_query($koneksi, $queryOrder) or die('gagal');
  $rstOrder = mysqli_fetch_assoc($responseOrder);

  return $rstOrder;
}

function tambah_data_master_smv($style, $nilai_smv, $username)
{
  $style = escape($style);
  $nilai_smv = escape($nilai_smv);
  $query = "INSERT INTO master_smv (id_style, nilai_smv, username, waktu)
  VALUES ($style, $nilai_smv, '$username', now())";

  return run($query);
}


function tambah_bom_style($id_style, $username)
{
  $id_style = escape($id_style);

  $query = "INSERT INTO master_bom (id_style, username, waktu)
  VALUES ($id_style, '$username', now())";

  return run($query);
}

function tambah_bom_style_material($id_bom, $id_material, $username)
{
  $id_bom = escape($id_bom);
  $id_material = escape($id_material);

  $query = "INSERT INTO master_bom_detail (id_bom, id_material, username, waktu)
  VALUES ($id_bom, $id_material, '$username', now())";

  return run($query);
}

function tambah_bom_orc_material($id_bom_orc, $id_material, $username)
{
  $id_bom_orc = escape($id_bom_orc);
  $id_material = escape($id_material);

  $query = "INSERT INTO master_bom_detail_orc (id_bom_orc, id_material, username, waktu)
  VALUES ($id_bom_orc, $id_material, '$username', now())";

  return run($query);
}

function tambah_master_bom_detail_part($id_bom_detail, $id_part, $username)
{
  $id_bom_detail = escape($id_bom_detail);
  $id_part = escape($id_part);

  $query = "INSERT INTO master_bom_detail_part (id_bom_detail, id_part, username, waktu)
  VALUES ($id_bom_detail, $id_part, '$username', now())";

  return run($query);
}

function tambah_master_bom_detail_orc_part($id_bom_detail_orc, $id_part, $username)
{
  $id_bom_detail_orc = escape($id_bom_detail_orc);
  $id_part = escape($id_part);

  $query = "INSERT INTO master_bom_detail_part_orc (id_bom_detail_orc, id_part, username, waktu)
  VALUES ($id_bom_detail_orc, $id_part, '$username', now())";

  return run($query);
}

function tambah_master_bom_orc($id)
{

  $query = "INSERT INTO master_bom_orc (id_order, username, waktu)
  VALUES ($id_order, '$username', now())";

  return run($query);
}

function tambah_data_label($label, $bulan, $tahun)
{
  $query = "INSERT INTO label (label, bulan, tahun, status) VALUES ('$label', '$bulan', '$tahun', 'open')";

  return run($query);
}


function tambah_qty_temp_part_cutting($no_trx, $tanggal, $jam, $idiod, $idibdp, $valTemp, $username)
{
  $query = "INSERT INTO temp_part_cutting (no_trx, tanggal, jam, id_order_detail, id_bom_detail_part, qty, username)
   VALUES ('$no_trx', '$tanggal', '$jam', $idiod , $idibdp, $valTemp, '$username')";

  return run($query);
}

function tambah_qty_temp_part_cutting_reject($no_trx, $tanggal, $jam, $idiod, $idibdp, $valTemp, $username)
{
  $query = "INSERT INTO temp_part_cutting_reject (no_trx, tanggal, jam, id_order_detail, id_bom_detail_part, qty, username)
   VALUES ('$no_trx', '$tanggal', '$jam', $idiod , $idibdp, $valTemp, '$username')";

  return run($query);
}

function tambah_temp_part_cutting_part_terpilih($id_order, $id_bom_detail_part, $username)
{
  $query = "INSERT INTO temp_part_cutting_part (id_order, id_bom_detail_part, username, waktu)
   VALUES ($id_order, $id_bom_detail_part, '$username', now())";

  return run($query);
}

function tambah_temp_part_cutting_size_terpilih($id_order_detail, $username)
{
  $query = "INSERT INTO temp_part_cutting_size (id_order_detail, username, waktu)
   VALUES ($id_order_detail, '$username', now())";

  return run($query);
}

function tambah_temp_part_cutting_generate($no_trx, $id_order, $id_order_detail, $id_bom_detail_part, $rasio, $username, $tanggal, $jam, $qty_temp)
{
  $query = "INSERT INTO temp_part_cutting (no_trx, tanggal, jam, id_order_detail, id_bom_detail_part, rasio, qty, username)
   VALUES ($no_trx, '$tanggal', '$jam', $id_order_detail, $id_bom_detail_part, $rasio, $qty_temp, '$username')";

  return run($query);
}

function register_invoice($invoice, $inspection, $cut_off, $costomer, $shipment_by, $status, $ukuran_karton)
{
  $invoice = escape($invoice);
  $inspection = escape($inspection);
  $cut_off = escape($cut_off);
  $costomer = escape($costomer);
  $shipment_by = escape($shipment_by);
  $status = escape($status);
  $ukuran_karton = escape($ukuran_karton);

  $query = "INSERT INTO shipment (no_invoice, inspection, cut_off, id_costomer, shipment_by, ukuran_karton, status) VALUES ('$invoice', '$inspection', '$cut_off', $costomer, '$shipment_by', '$ukuran_karton', '$status')";

  return run($query);
}

// Trasaksi reject shipment kepacking
function transfer_shipment_packing($data)
{
  global $koneksi;

  $query = "INSERT INTO transaksi_packing (no_karton, tanggal, jam, kode_barcode, orc, qty, kelompok)
  (SELECT no_karton, tanggal_scan, jam_scan, kode_barcode, orc, qty, kelompok from transaksi_shipment where id_transaksi_shipment IN($data))";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}
// ======================================== cek Data ========================================

function cek_master_bundle($id_order)
{
  global $koneksi;

  $query = "SELECT A.id_bundle FROM master_bundle A JOIN order_detail B ON A.id_order_detail = B.id_order_detail WHERE B.id_order = $id_order";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}


function cek_input_target_harian($id_order, $date_target, $line)
{
  global $koneksi;

  $query = "SELECT id_order FROM master_target where id_order = $id_order AND date_target = '$date_target' AND line = '$line'";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}


function cek_output_target_qc_endline($tanggal, $waktu_awal, $waktu_akhir, $lantai)
{
  global $koneksi;

  $query = "SELECT A.date_target, A.orc, A.id_order, A.lantai, A.line, IFNULL(A.target_jam, 0) target_jam, 
    IFNULL(B.total_output, 0) total_output FROM 
    (SELECT A.date_target, B.orc, A.id_order, C.lantai, A.line,  ROUND(((60/A.nilai_smv)*A.man_power*(A.persentase_target/100)),0) target_jam  
    FROM master_target A 
    JOIN master_order B ON A.id_order = B.id_order
    JOIN master_line C ON A.line = C.nama_line
    WHERE A.date_target = '$tanggal' AND C.lantai = $lantai
     GROUP BY A.date_target, A.id_order, A.line) A
    LEFT OUTER JOIN 
    (SELECT C.id_order, SUM(A.qty) total_output  FROM transaksi_qc_endline A 
    JOIN master_bundle B ON A.kode_barcode = B.barcode_bundle 
    JOIN order_detail C ON B.id_order_detail = C.id_order_detail
    WHERE A.tanggal = '$tanggal' AND A.jam BETWEEN '$waktu_awal' AND '$waktu_akhir'
    GROUP BY C.id_order)B
    ON A.id_order = B.id_order
    WHERE IFNULL(B.total_output, 0) < (IFNULL(A.target_jam, 0))";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_input_master_target($tanggal, $lantai)
{
  global $koneksi;

  $query = "SELECT A.id from master_target A join master_line B on A.line = B.nama_line
     WHERE date_target = '$tanggal' AND B.lantai = $lantai ";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_jumlah_data_master_order()
{
  global $koneksi;

  $query = "SELECT id_order FROM master_order";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}



function cek_jumlah_data_master_order_filtered($search)
{
  global $koneksi;

  $query = "SELECT B.id_order FROM master_order B JOIN style C ON B.id_style = C.id_style JOIN costomer D ON D.id_costomer = B.id_costomer
      WHERE D.costomer LIKE '%$search%' or B.orc LIKE '%$search%' or B.no_po LIKE '%$search%' or C.style LIKE '%$search%' or B.color LIKE '%$search%' or B.qty_order LIKE '%$search%'";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_proses_transaksi_orc($id_order)
{
  global $koneksi;

  $query = "SELECT nama_transaksi FROM proses_transaksi_orc where id_order = $id_order";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_category_style($style)
{
  global $koneksi;

  $query = "SELECT B.category FROM style A JOIN items B ON A.item = B.item
     WHERE id_style = '$style'";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_ketersediaan_proses($id_order, $proses)
{
  global $koneksi;

  $query = "SELECT nama_transaksi FROM proses_transaksi_orc where id_order = $id_order AND nama_transaksi = '$proses'";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_style_karton($style)
{
  global $koneksi;

  $query = "SELECT id_style FROM master_qty_karton where id_style='$style'";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_style_smv($style)
{
  global $koneksi;

  $query = "SELECT id_style FROM master_smv where id_style='$style'";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_style($style)
{
  global $koneksi;

  $query = "SELECT style FROM style where style='$style'";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_material_code($cari)
{
  global $koneksi;

  $query = "SELECT material_code FROM master_material where
     material_code LIKE '%$cari%'
     OR material_name LIKE '%$cari%'";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_part_duplicate($part)
{
  global $koneksi;
  $query = "SELECT part FROM master_part where part='$part'";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_costomer_barcode_costomer($costomer)
{
  global $koneksi;


  $query = "SELECT barcode_costomer FROM costomer WHERE id_costomer = '$costomer'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}



function cekKelompokTrx($trx)
{
  global $koneksi;


  $query = "SELECT kelompok FROM transaksi_packing WHERE no_trx = '$trx'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function cek_description($description)
{
  global $koneksi;

  $query = "SELECT description FROM description where description='$description'";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}


function cek_line($line)
{
  global $koneksi;

  $query = "SELECT nama_line FROM master_line where nama_line='$line' and status='aktif'";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_scan_qc_kensa($kode_barcode, $user)
{
  global $koneksi;

  $query = "SELECT kode_barcode FROM temp_qc_kensa where kode_barcode = '$kode_barcode' and username = '$user'";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_scan_tatami_in($kode_barcode, $user)
{
  global $koneksi;

  $query = "SELECT kode_barcode FROM temp_tatami_in where kode_barcode = '$kode_barcode' and username = '$user'";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_scan_produksi_bundle($kode_barcode, $user, $temp_table)
{
  global $koneksi;

  $query = "SELECT kode_barcode FROM $temp_table where kode_barcode = '$kode_barcode' and username = '$user'";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}



function cek_scan_kenzin($orc, $kode_barcode, $user)
{
  global $koneksi;

  $query = "SELECT kode_barcode FROM temp_kenzin where orc = '$orc' and kode_barcode = '$kode_barcode' and username = '$user'";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_scan_kenzin_kelompok_user_orc($user)
{
  global $koneksi;

  $query = "SELECT orc FROM temp_kenzin where username = '$user' group by orc ";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_scan_packing_kelompok_user_orc($user)
{
  global $koneksi;

  $query = "SELECT orc FROM temp_packing where username = '$user' group by orc ";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_scan_kenzin_kelompok_user_orc_size($user, $orc)
{
  global $koneksi;

  $query = "SELECT orc, kode_barcode FROM temp_kenzin where orc = '$orc' and username = '$user' group by orc, kode_barcode";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_scan_packing_kelompok_user_orc_size($user, $orc)
{
  global $koneksi;

  $query = "SELECT orc, kode_barcode FROM temp_packing where orc = '$orc' and username = '$user' group by orc, kode_barcode";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_scan_packing($orc, $kode_barcode, $user)
{
  global $koneksi;

  $query = "SELECT kode_barcode FROM temp_packing where orc = '$orc' and kode_barcode = '$kode_barcode' and username = '$user'";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_scan_packing_edit($orc, $kode_barcode, $trx)
{
  global $koneksi;

  $query = "SELECT kode_barcode FROM transaksi_packing where orc = '$orc' and kode_barcode = '$kode_barcode' and no_trx = '$trx'";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_contract($contract)
{
  global $koneksi;
  $contract = escape($contract);
  $query = "SELECT no_contract FROM contract_number where no_contract='$contract'";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_item($item)
{
  global $koneksi;

  $contract = escape($item);
  $query = "SELECT item FROM items where item='$item'";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}



function cek_size($size)
{
  global $koneksi;

  $query = "SELECT size FROM size where size='$size'";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_invoice($invoice)
{
  global $koneksi;
  $invoice = escape($invoice);
  $query = "SELECT no_invoice FROM shipment where no_invoice='$invoice'";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_consignee($consignee)
{
  global $koneksi;

  $query = "SELECT consignee FROM consignee where consignee='$consignee'";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}


function cek_label($label)
{
  global $koneksi;

  $query = "SELECT label FROM label where label='$label'";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}


function check_barcode_barang_buyer($idstyle, $size)
{
  global $koneksi;

  $query = "SELECT kode_barcode FROM barang where id_style = $idstyle and size = '$size'";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cekSizeID($id, $size)
{
  global $koneksi;

  $query = "SELECT size FROM order_detail where id_order = '$id' and size = '$size' ";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_jumlah_qty_scan_temp_trx($no_trx)
{
  global $koneksi;


  $query = "SELECT SUM(qty) total_scan FROM temp_packing_bundle where no_trx = $no_trx";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function cek_color_style($id, $color)
{
  global $koneksi;

  $query = "SELECT color_style FROM style_color WHERE id_style = '$id' AND color_style = '$color' ";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_color_material($id, $color)
{
  global $koneksi;

  $query = "SELECT color_material FROM master_color_material WHERE id_masterial = '$id' AND color_material = '$color' ";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_bom_style($id_style)
{
  global $koneksi;

  $query = "SELECT id_style FROM master_bom 
    WHERE id_style = $id_style";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_kode_barcode_barang($kode_barcode)
{
  global $koneksi;

  $query = "SELECT kode_barcode FROM barang 
      WHERE kode_barcode = '$kode_barcode'";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_bom_material($id_bom, $id_material)
{
  global $koneksi;

  $query = "SELECT id_material FROM master_bom_detail A 
      WHERE A.id_bom = $id_bom AND A.id_material = $id_material ";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_bom_material_part($id)
{
  global $koneksi;

  $query = "SELECT id_part FROM master_bom_detail_part WHERE id_bom_detail = $id ";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_bom_material_part_orc($id)
{
  global $koneksi;

  $query = "SELECT id_part FROM master_bom_detail_part_orc WHERE id_bom_detail_orc = $id ";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_bom_material_part_duplicate($id_part, $id_bom_detail)
{
  global $koneksi;

  $query = "SELECT id_part FROM master_bom_detail_part WHERE id_bom_detail = $id_bom_detail and id_part = $id_part";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_bom_material_part_orc_duplicate($id_part, $id_bom_detail_orc)
{
  global $koneksi;

  $query = "SELECT id_part FROM master_bom_detail_part_orc WHERE id_bom_detail_orc = $id_bom_detail_orc and id_part = $id_part";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_bom_orc($id)
{
  global $koneksi;

  $query = "SELECT id_order FROM master_bom_orc WHERE id_order = $id ";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_temp_part_cutting_id_order($id_order)
{
  global $koneksi;

  $query = "SELECT A.no_trx FROM temp_part_cutting A 
      JOIN order_detail B ON A.id_order_detail = B.id_order_detail
      WHERE id_order = $id_order ";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_temp_part_cutting_reject_id_order($id_order)
{
  global $koneksi;

  $query = "SELECT A.no_trx FROM temp_part_cutting_reject A 
      JOIN order_detail B ON A.id_order_detail = B.id_order_detail
      WHERE id_order = $id_order ";


  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_temp_part_cutting_part_terpilih($id_order, $id_bom_detail_part)
{
  global $koneksi;

  $query = "SELECT id_bom_detail_part FROM temp_part_cutting_part
        WHERE id_order = $id_order AND id_bom_detail_part = $id_bom_detail_part";


  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_temp_part_cutting_size_terpilih_id($id_order_detail)
{
  global $koneksi;

  $query = "SELECT id_order_detail FROM temp_part_cutting_size
      WHERE id_order_detail = $id_order_detail";


  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_temp_part_cutting_size_isi($id_order)
{
  global $koneksi;

  $query = "SELECT A.id_order_detail FROM temp_part_cutting_size A
      JOIN order_detail B ON A.id_order_detail = B.id_order_detail
      WHERE B.id_order = $id_order";


  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_temp_part_cutting_part_isi($id_order)
{
  global $koneksi;
  $query = "SELECT id_bom_detail_part FROM temp_part_cutting_part
    WHERE id_order = $id_order";

  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}

function cek_temp_part_cutting_size_rasio($id_order)
{
  global $koneksi;

  $query = "SELECT A.id_order_detail, A.rasio FROM temp_part_cutting_size A
      JOIN order_detail B ON A.id_order_detail = B.id_order_detail
      WHERE B.id_order = $id_order AND IFNULL(A.RASIO,0) = 0 ";


  if ($result = mysqli_query($koneksi, $query)) {
    return mysqli_num_rows($result);
  }
}
// ===================================== Edit Data=============================================


function edit_data_barang($barcode, $style, $warna, $size, $cup, $qty_barcode, $weight)
{
  global $koneksi;

  $query = "UPDATE barang SET id_style=$style, warna='$warna',
    size='$size', cup = '$cup', qty_barcode = '$qty_barcode', weight = '$weight' WHERE kode_barcode='$barcode'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function edit_data_master_line($id, $line, $lantai, $supervisor, $chief, $status, $user)
{
  global $koneksi;


  $query = "UPDATE master_line SET nama_line='$line', lantai = $lantai, supervisor = '$supervisor', chief = '$chief', status='$status', edit_by = '$user', time_edit = now() WHERE id_line='$id'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function edit_data_preparation_production($id, $pic_pp, $date_in_pp, $date_pp, $username, $kolom_date_in, $kolom_date_transaksi, $kolom_pic_transaksi, $kolom_username_edit, $kolom_user_date_edit, $remaks_kolom, $remaks, $kolom_persentase, $kesiapan, $status_persentase)
{
  global $koneksi;

  if ($status_persentase == 'ya') {
    $query = "UPDATE production_preparation SET $kolom_pic_transaksi='$pic_pp', $kolom_date_in = '$date_in_pp', $kolom_date_transaksi = '$date_pp', $kolom_username_edit = '$username', $kolom_user_date_edit = now(), $remaks_kolom = '$remaks',
    $kolom_persentase = '$kesiapan'
     where id_prod = $id";
  } else {
    $query = "UPDATE production_preparation SET $kolom_pic_transaksi='$pic_pp',  $kolom_date_transaksi = '$date_pp', $kolom_username_edit = '$username', $kolom_user_date_edit = now(), $remaks_kolom = '$remaks'
     where id_prod = $id";
  }


  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function edit_data_kesiapan_fabric($id, $kesiapan_date, $kesiapan, $pic, $remaks, $username, $inhouse_fabric_date)
{
  global $koneksi;


  $query = "UPDATE production_preparation SET inhouse_fabric_date='$inhouse_fabric_date', kesiapan_fabric_date='$kesiapan_date', kesiapan_fabric = $kesiapan, fabric_pic = '$pic', fabric_edit_date = now(), remaks_fabric = '$remaks', fabric_edit_user = '$username'  where id_prod = $id";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function edit_data_kesiapan_acc_sewing($id, $kesiapan_date, $kesiapan, $pic, $remaks, $username, $inhouse_acc_sewing_date)
{
  global $koneksi;


  $query = "UPDATE production_preparation SET inhouse_acc_sewing_date='$inhouse_acc_sewing_date', kesiapan_acc_sewing_date='$kesiapan_date', kesiapan_acc_sewing = $kesiapan, acc_sewing_pic = '$pic', acc_sewing_edit_date = now(), remaks_acc_sewing = '$remaks', acc_sewing_edit_user = '$username'  where id_prod = $id";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function edit_data_kesiapan_acc_pack($id, $kesiapan_date, $kesiapan, $pic, $remaks, $username)
{
  global $koneksi;


  $query = "UPDATE production_preparation SET kesiapan_acc_packing_date='$kesiapan_date', kesiapan_acc_packing = $kesiapan, acc_packing_pic = '$pic', acc_packing_edit_date = now(), remaks_acc_packing = '$remaks', acc_packing_edit_user = '$username'  where id_prod = $id";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function edit_data_preparation_production_header($id, $line, $days_proses, $plan_production, $username)
{
  global $koneksi;


  $query = "UPDATE production_preparation SET plan_line='$line', days_proses = $days_proses, plan_production = '$plan_production', edit_date = now(), user_edit = '$username'  where id_prod = $id";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function edit_data_production_preparation_date($id, $kolom_date_transaksi, $tanggals, $username)
{
  global $koneksi;


  $query = "UPDATE production_preparation SET $kolom_date_transaksi = '$tanggals', team_sample_edit_user = '$username', team_sample_edit_date = now() where id_prod = $id";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function edit_data_production_preparation_kesiapan($id, $kolom_persentase, $kesiapan)
{
  global $koneksi;


  $query = "UPDATE production_preparation SET $kolom_persentase = $kesiapan where id_prod = $id";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function edit_data_item($id, $item, $category)
{
  global $koneksi;

  $item = escape($item);
  $category = escape($category);

  $query = "UPDATE items SET item = '$item', category='$category' WHERE id_item ='$id'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function edit_master_qty_karton($id, $qty_karton, $username)
{
  global $koneksi;


  $qty_karton = escape($qty_karton);

  $query = "UPDATE master_qty_karton SET qty_karton = $qty_karton, username_edit = '$username', waktu_edit = now() WHERE id ='$id'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function edit_master_nilai_smv($id, $nilai_smv, $username)
{
  global $koneksi;


  $nilai_smv = escape($nilai_smv);

  $query = "UPDATE master_smv SET nilai_smv = $nilai_smv, username_edit = '$username', waktu_edit = now() WHERE id ='$id'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function edit_data_master_part($id, $part, $status, $username)
{
  global $koneksi;

  $part = escape($part);
  $status = escape($status);
  $username = escape($username);

  $query = "UPDATE master_part SET part = '$part', status='$status', username_edit = '$username', waktu = now() WHERE id_part ='$id'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function edit_data_style($style, $id, $description, $item, $costomer, $username)
{
  global $koneksi;

  $description = escape($description);

  $query = "UPDATE style SET style='$style', description='$description', item = '$item', id_costomer = $costomer, username_edit = '$username', waktu_edit = now() WHERE id_style='$id'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function edit_data_material($id, $material_code, $material_name, $username)
{
  global $koneksi;

  $material_code = escape($material_code);
  $material_name = escape($material_name);

  $query = "UPDATE master_material SET material_code='$material_code', material_name='$material_name', username_edit = '$username', waktu_edit = now() WHERE id_material = '$id'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function edit_data_bom_material($id, $id_material, $username)
{
  global $koneksi;

  $id = escape($id);
  $id_material = escape($id_material);

  $query = "UPDATE master_bom_detail SET id_material ='$id_material', username_edit = '$username', waktu_edit = now() WHERE id_bom_detail = '$id'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function edit_data_bom_material_orc($id_bom_detail_orc, $id_material, $username)
{
  global $koneksi;

  $id_bom_detail_orc = escape($id_bom_detail_orc);
  $id_material = escape($id_material);

  $query = "UPDATE master_bom_detail_orc SET id_material ='$id_material', username_edit = '$username', waktu_edit = now() WHERE id_bom_detail_orc = '$id_bom_detail_orc'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function edit_data_costomer($id, $costomer, $barcode_costomer)
{
  global $koneksi;

  $costomer = escape($costomer);
  $barcode_costomer = escape($barcode_costomer);

  $query = "UPDATE costomer SET costomer='$costomer', barcode_costomer = '$barcode_costomer' WHERE id_costomer='$id'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function approve_transaksi_shipment($invoice)
{
  global $koneksi;

  $query = "UPDATE shipment SET approve = 'y' WHERE id_shipment = $invoice";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function update_prod_pred_master_order($id_order)
{
  global $koneksi;

  $query = "UPDATE master_order SET prep_prod = 'sudah' WHERE id_order = $id_order";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function update_tambah_qty_temp_qc_kensa($tanggal, $jam, $kode_barcode, $user, $update_qty_tambah)
{
  global $koneksi;

  $query = "UPDATE temp_qc_kensa SET tanggal = '$tanggal', jam = '$jam', qty = $update_qty_tambah 
        WHERE kode_barcode = '$kode_barcode' and username = '$user' ";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function update_tambah_qty_temp_qc_tatami_in($tanggal, $jam, $kode_barcode, $user, $update_qty_tambah)
{
  global $koneksi;

  $query = "UPDATE temp_tatami_in SET tanggal = '$tanggal', jam = '$jam', qty = $update_qty_tambah 
        WHERE kode_barcode = '$kode_barcode' and username = '$user' ";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function update_tambah_qty_temp_kenzin($tanggal, $jam, $orc, $kode_barcode, $user, $update_qty_tambah)
{
  global $koneksi;

  $query = "UPDATE temp_kenzin SET tanggal = '$tanggal', jam = '$jam', qty = $update_qty_tambah 
        WHERE orc = '$orc' and kode_barcode = '$kode_barcode' and username = '$user' ";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function update_tambah_qty_temp_packing($tanggal, $jam, $orc, $kode_barcode, $user, $update_qty_tambah)
{
  global $koneksi;

  $query = "UPDATE temp_packing SET tanggal = '$tanggal', jam = '$jam', qty = $update_qty_tambah 
        WHERE orc = '$orc' and kode_barcode = '$kode_barcode' and username = '$user' ";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function update_tambah_qty_transaksi_packing($tanggal, $jam, $orc, $kode_barcode, $trx, $update_qty_tambah)
{
  global $koneksi;

  $query = "UPDATE transaksi_packing SET tanggal = '$tanggal', jam = '$jam', qty = $update_qty_tambah 
        WHERE orc = '$orc' and kode_barcode = '$kode_barcode' and no_trx = '$trx' ";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function update_tambah_qty_temp_production_bundle($tanggal, $jam, $kode_barcode, $user, $update_qty_tambah, $temp_table)
{
  global $koneksi;

  $query = "UPDATE $temp_table SET tanggal = '$tanggal', jam = '$jam', qty = $update_qty_tambah 
        WHERE kode_barcode = '$kode_barcode' and username = '$user' ";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function update_tambah_qty_production_idx($tanggal, $jam, $id, $update_qty_tambah, $temp_table)
{
  global $koneksi;

  $query = "UPDATE $temp_table SET tanggal = '$tanggal', jam = '$jam', qty = $update_qty_tambah 
        WHERE id_transaksi = '$id' ";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function update_kurangi_qty_temp_qc_kensa($tanggal, $jam, $id, $update_qty_delete)
{
  global $koneksi;

  $query = "UPDATE temp_qc_kensa SET tanggal = '$tanggal', jam = '$jam', qty = $update_qty_delete WHERE id_transaksi_qc_kensa = '$id'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function update_kurangi_qty_temp_tatami_in($tanggal, $jam, $id, $update_qty_delete)
{
  global $koneksi;

  $query = "UPDATE temp_tatami_in SET tanggal = '$tanggal', jam = '$jam', qty = $update_qty_delete WHERE id_transaksi_tatami_in = '$id'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function update_kurangi_qty_temp_kenzin($tanggal, $jam, $id, $update_qty_delete)
{
  global $koneksi;

  $query = "UPDATE temp_kenzin SET tanggal = '$tanggal', jam = '$jam', qty = $update_qty_delete WHERE id_transaksi_kenzin= '$id'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function update_transaksi_packing($trx, $kelompok)
{
  global $koneksi;

  $query = "UPDATE transaksi_packing SET kelompok = '$kelompok' WHERE no_trx = $trx";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function update_kurangi_qty_temp_packing($tanggal, $jam, $id, $update_qty_delete)
{
  global $koneksi;

  $query = "UPDATE temp_packing SET tanggal = '$tanggal', jam = '$jam', qty = $update_qty_delete WHERE id_transaksi_packing = '$id'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function update_kurangi_qty_transaksi_packing($tanggal, $jam, $id, $update_qty_delete)
{
  global $koneksi;

  $query = "UPDATE transaksi_packing SET tanggal = '$tanggal', jam = '$jam', qty = $update_qty_delete WHERE id_transaksi_packing = '$id'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function update_qty_temp_part_cutting($idTemp, $username, $tanggal, $jam, $valTemp)
{
  global $koneksi;

  $query = "UPDATE temp_part_cutting SET tanggal = '$tanggal', jam = '$jam', qty = $valTemp, username='$username' WHERE id_transaksi = $idTemp";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function update_qty_temp_part_cutting_reject($idTemp, $username, $tanggal, $jam, $valTemp)
{
  global $koneksi;

  $query = "UPDATE temp_part_cutting_reject SET tanggal = '$tanggal', jam = '$jam', qty = $valTemp, username='$username' WHERE id_transaksi = $idTemp";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function update_temp_part_cutting_rasio_size($id_transaksi, $nilai_rasio)
{
  global $koneksi;

  $query = "UPDATE temp_part_cutting_size SET rasio = $nilai_rasio, waktu = now() WHERE id_transaksi = $id_transaksi";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function close_master_order($idorder)
{
  global $koneksi;

  $query = "UPDATE master_order SET status = 'close' WHERE id_order = $idorder";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function open_master_order($idorder)
{
  global $koneksi;

  $query = "UPDATE master_order SET status = 'open' WHERE id_order = $idorder";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function edit_data_size($id, $size, $kelompok)
{
  global $koneksi;

  $query = "UPDATE size SET size='$size', kelompok_size = '$kelompok' WHERE id_size='$id'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function edit_proses_orc_urutan($idproses, $urutan)
{
  global $koneksi;

  $query = "UPDATE proses_transaksi_orc SET urutan=$urutan WHERE id_proses=$idproses";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function edit_data_invoice($id, $invoice, $inspection, $cut_off, $costomer, $shipment_by, $status, $ukuran_karton, $approve)
{
  global $koneksi;

  $invoice = escape($invoice);
  $inspection = escape($inspection);
  $cut_off = escape($cut_off);
  $costomer = escape($costomer);
  $status = escape($status);
  $ukuran_karton = escape($ukuran_karton);
  $approve = escape($approve);

  $query = "UPDATE shipment SET no_invoice='$invoice', inspection='$inspection', cut_off = '$cut_off', id_costomer=$costomer, shipment_by='$shipment_by', 
  status='$status', ukuran_karton = '$ukuran_karton', approve = '$approve'
   WHERE id_shipment='$id'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function edit_data_temp_order($id, $qtyorder_edit)
{
  global $koneksi;

  $query = "UPDATE temp_order_detail SET qty_order=$qtyorder_edit WHERE id_order_detail='$id'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function edit_data_size_order($id, $size, $cup, $barcode, $qtyorder_edit)
{
  global $koneksi;

  $query = "UPDATE order_detail SET size='$size', barcode_number = '$barcode', qty_order=$qtyorder_edit, cup = '$cup' WHERE id_order_detail='$id'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function edit_data_master_line_register_hrd($id, $date_register, $jml_register_hrd, $user)
{
  global $koneksi;

  $query = "UPDATE master_line_operator SET date_register='$date_register', jml_register_hrd = '$jml_register_hrd', username_edit = '$user', waktu_edit = now() WHERE id='$id'";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function edit_data_style_color($id, $color, $username)
{
  global $koneksi;

  $query = "UPDATE style_color SET color_style ='$color', username_edit = '$username', waktu_edit = now() WHERE id_color_style = $id";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function edit_data_material_color($id, $color, $username)
{
  global $koneksi;

  $query = "UPDATE master_material_color SET color_material ='$color', username_edit = '$username', waktu_edit = now() WHERE id_color_material = $id";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

// ===================================== Reset Data=============================================

function reset_temp_kenzin($user)
{
  global $koneksi;


  $query = "DELETE FROM temp_kenzin where username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function reset_temp_shipment($invoice)
{
  global $koneksi;

  $query = "DELETE FROM temp_shipment where id_shipment = $invoice";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function reset_temp_kenzin3()
{
  global $koneksi;

  $query = "DELETE FROM temp_kenzin_3";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function reset_temp_ganti_label()
{
  global $koneksi;

  $query = "DELETE FROM temp_ganti_label";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function reset_temp_packing($user)
{
  global $koneksi;


  $query = "DELETE FROM temp_packing where username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function reset_temp_qcfinal($user)
{
  global $koneksi;


  $query = "DELETE FROM temp_qcfinal where username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function reset_temp_tatami_in($user)
{
  global $koneksi;


  $query = "DELETE FROM temp_tatami_in where username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function reset_temp_tatami_reject($user)
{
  global $koneksi;


  $query = "DELETE FROM temp_reject_tatami where username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function reset_temp_qc_kensa($user)
{
  global $koneksi;


  $query = "DELETE FROM temp_qc_kensa where username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function reset_temp_produksi_bundle($user, $temp_table)
{
  global $koneksi;


  $query = "DELETE FROM $temp_table where username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function reset_temp_tatami_out($user)
{
  global $koneksi;


  $query = "DELETE FROM temp_tatami_out where username = '$user'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}
function reset_temp_master_order($user)
{
  global $koneksi;


  $query = "DELETE FROM temp_order_detail where username = '$user' ";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

// ================================== KIRIM DATA KE TABEL UTAMA ================================

function kirim_data_master_kenzin($user, $kelompok, $qty_karton)
{
  global $koneksi;

  $query = "INSERT INTO transaksi_kenzin (no_trx, tanggal, jam, kode_barcode, orc, qty, user_input, kelompok, qty_full_karton) (select no_trx, tanggal, jam, kode_barcode, orc, qty, username, '$kelompok', $qty_karton from temp_kenzin where username = '$user')";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function kirim_data_transaksi_delete_kenzin_packing($trx_kenzin, $username)
{
  global $koneksi;

  $query = "INSERT INTO delete_transaksi_kenzin_packing
   (no_trx_kenzin, tanggal_kenzin, jam_kenzin, user_kenzin, no_trx_packing, tanggal_packing, jam_packing, user_packing, 
   kode_barcode, orc, qty, kelompok, status_kenzin, qty_full_karton, user_delete, waktu_delete) 
    (SELECT A.no_trx AS no_trx_kenzin, A.tanggal AS tanggal_kenzin, A.jam AS jam_kenzin, A.user_input AS user_kenzin, B.no_trx AS no_trx_packing,
     B.tanggal AS tanggal_packing, B.jam AS jam_packing, B.user_input AS user_packing, A.kode_barcode, A.orc, A.qty, A.kelompok, A.status_kenzin, 
     A.qty_full_karton, '$username', now() FROM transaksi_kenzin A 
     LEFT OUTER JOIN transaksi_packing B ON A.no_trx = B.no_before AND A.kode_barcode = B.kode_barcode AND A.orc = B.orc WHERE A.no_trx = $trx_kenzin)";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function kirim_data_master_qc_kensa($user)
{
  global $koneksi;

  $query = "INSERT INTO transaksi_qc_kensa (no_trx, tanggal, jam, kode_barcode, qty, user_input) 
  (select no_trx, tanggal, jam, kode_barcode, qty, username from temp_qc_kensa where username = '$user')";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function kirim_data_ganti_label()
{
  global $koneksi;

  $query = "INSERT INTO transaksi_ganti_label (tanggal, jam, kode_barcode, orc, ke_label, qty) select tanggal, jam, kode_barcode, orc, ke_label, qty from temp_ganti_label";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function kirim_data_master_packing($kelompok, $user, $no_kenzin)
{
  global $koneksi;

  $query = "INSERT INTO transaksi_packing (no_trx, tanggal, jam, kode_barcode, orc, qty, user_input, kelompok, no_before) (select no_trx, tanggal, jam, kode_barcode, orc, qty, username, '$kelompok', $no_kenzin from temp_packing where username = '$user')";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function kirim_data_master_qcfinal($user)
{
  global $koneksi;

  $query = "INSERT INTO transaksi_qcfinal (no_trx, tanggal, jam, kode_barcode, orc, qty, user_input) (select no_trx, tanggal, jam, kode_barcode, orc, qty, username from temp_qcfinal where username = '$user')";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function kirim_data_transaksi_produksi_bundle($user, $temp_table, $table)
{
  global $koneksi;

  $query = "INSERT INTO $table (no_trx, tanggal, jam, kode_barcode, qty, username) 
  (select no_trx, tanggal, jam, kode_barcode, qty, username from $temp_table where username = '$user')";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  $insertedID = mysqli_insert_id($koneksi);
  // return $result;
  return $insertedID;
}

function kirim_data_transaksi_produksi_bundle_packing($user, $no_trx, $barcode_ctn, $kelompok)
{
  global $koneksi;

  $query1 = "INSERT INTO hd_transaksi_packing_bundle (no_trx, barcode_ctn, kelompok, waktu, username, status_trx)
  VALUES ('$no_trx', '$barcode_ctn', '$kelompok', now(), '$user', 'packing')";


  return run($query1);
}

function kirim_data_transaksi_produksi_bundle_packing2($user, $temp_table, $table, $no_trx)
{
  global $koneksi;


  $query2 = "INSERT INTO $table (no_trx, tanggal, jam, kode_barcode, qty, username) 
  (select $no_trx, tanggal, jam, kode_barcode, qty, username from $temp_table where username = '$user')";

  return run($query2);
}

function kirim_data_transaksi_produksi_bundle_sewing($user, $temp_table, $table, $line)
{
  global $koneksi;

  $query = "INSERT INTO $table (no_trx, tanggal, jam, kode_barcode, qty, username, line) 
  (select no_trx, tanggal, jam, kode_barcode, qty, username, '$line' from $temp_table where username = '$user')";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  $insertedID = mysqli_insert_id($koneksi);
  // if($insertedID != null){
  //   $query2 = "SELECT * FROM $table WHERE username='$user' AND id_transaksi='$insertedID'";
  //   $rst = mysqli_query($koneksi, $query2);

  //   return $rst;
  // }

  // return $result;
  return $insertedID;
}

function kirim_data_master_tatami_in($user)
{
  global $koneksi;

  $query = "INSERT INTO transaksi_tatami_in (no_trx, tanggal, jam, kode_barcode, qty, user_input) (select no_trx, tanggal, jam, kode_barcode, qty, username from temp_tatami_in where username = '$user')";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function kirim_data_master_reject_tatami($user, $adjuzt, $keterangan, $tujuan)
{
  global $koneksi;

  $query = "INSERT INTO transaksi_reject_tatami (no_trx, tanggal, jam, kode_barcode, qty, user_input, to_reject, keterangan, adjuzt) (select no_trx, tanggal, jam, kode_barcode, qty, username, '$tujuan', '$keterangan', '$adjuzt' from temp_reject_tatami where username = '$user')";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function kirim_data_master_tatami_out($user)
{
  global $koneksi;

  $query = "INSERT INTO transaksi_tatami_out (no_trx, tanggal, jam, kode_barcode, qty, user_input) (select no_trx, tanggal, jam, kode_barcode, qty, username from temp_tatami_out where username = '$user')";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function kirim_data_master_order($costomer, $orc, $po, $label, $style, $color, $qty_order, $qty_bundle, $prepare_on, $shipment_plan, $user)
{
  global $koneksi;

  $query = "INSERT INTO master_order (id_costomer, orc, no_po, label, id_style, color, qty_order, qty_bundle, prepare_on, shipment_plan, username) values ($costomer, '$orc', '$po', '$label', $style, '$color', $qty_order, $qty_bundle, '$prepare_on', '$shipment_plan', '$user')";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  $id = mysqli_insert_id($koneksi);
  $query2 = "INSERT INTO order_detail (id_order, size, cup, qty_order, username, barcode_number) (SELECT $id, size, cup, qty_order, username, barcode from temp_order_detail where username = '$user')";

  $result2 = mysqli_query($koneksi, $query2) or die('gagal menampilkan data');

  return $result;
  return $result2;
}

function kirim_data_master_order2($costomer, $orc, $po, $label, $style, $color, $qty_order, $user)
{
  global $koneksi;

  $query = "INSERT INTO master_order (id_costomer, orc, no_po, label, id_style, color, qty_order, username) values ($costomer, '$orc', '$po', '$label', $style, '$color', $qty_order, '$user')";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  $id = mysqli_insert_id($koneksi);
  $query2 = "INSERT INTO order_detail (id_order, size, cup, qty_order, username, barcode_number) (SELECT $id, size, cup, qty_order, username, barcode from temp_order_detail where username = '$user')";

  $result2 = mysqli_query($koneksi, $query2) or die('gagal menampilkan data');

  return $result;
  return $result2;
}

function kirim_data_transaksi_part_cutting($id_order)
{
  global $koneksi;

  $query = "INSERT INTO transaksi_part_cutting (no_trx, tanggal, jam, id_order_detail, id_bom_detail_part, rasio, qty, username, waktu) 
  (SELECT A.no_trx, A.tanggal, A.jam, A.id_order_detail, A.id_bom_detail_part, A.rasio, A.qty, A.username, now() from temp_part_cutting A JOIN order_detail B ON A.id_order_detail = B.id_order_detail  WHERE B.id_order = $id_order AND A.qty > 0)";

  return run($query);
}

function kirim_data_transaksi_part_cutting_reject($id_order, $remaks)
{
  global $koneksi;

  $query = "INSERT INTO transaksi_part_cutting_reject (no_trx, tanggal, jam, id_order_detail, id_bom_detail_part, qty, keterangan, username) 
  (SELECT A.no_trx, A.tanggal, A.jam, A.id_order_detail, A.id_bom_detail_part, A.qty, '$remaks', A.username from temp_part_cutting_reject A 
  JOIN order_detail B ON A.id_order_detail = B.id_order_detail  WHERE B.id_order = $id_order AND A.qty > 0)";

  return run($query);
}

function kirim_balik_reject_packing($data, $nokarton)
{
  global $koneksi;

  $query = "INSERT INTO transaksi_packing (no_karton, tanggal, jam, kode_barcode, id_po, qty)
    (SELECT no_karton, tanggal_scan, jam_scan, kode_barcode, id_po, qty from reject_packing where id_transaksi_reject IN($data))";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function kirim_data_hd_transaksi_part_cutting($no_trx, $tgl_potong, $start_time, $end_time, $jmlh_layer, $operator, $username, $item_potong, $id_order)
{
  global $koneksi;

  $query = "INSERT INTO hd_transaksi_part_cutting (no_trx, tanggal, start_time, end_time, jmlh_layer, operator, item_potong, username, waktu, id_order) VALUES
      ($no_trx, '$tgl_potong', '$start_time', '$end_time', $jmlh_layer, '$operator', '$item_potong', '$username', now(), $id_order)";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function copy_master_bom_detail_to_orc($id_bom_orc, $id_bom, $username)
{
  global $koneksi;

  $query = "INSERT INTO master_bom_detail_orc (id_bom_detail, id_bom_orc, id_material, conz, username, waktu) 
  (select id_bom_detail, $id_bom_orc, id_material, conz, '$username', now() from master_bom_detail where id_bom = $id_bom)";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function copy_master_bom_detail_part_to_orc($id_bom_detail_orc, $id_bom_detail, $username)
{
  global $koneksi;

  $query = "INSERT INTO master_bom_detail_part_orc (id_bom_detail_orc, id_part, username, waktu) 
  (SELECT $id_bom_detail_orc, id_part, '$username', now() from master_bom_detail_part where id_bom_detail = $id_bom_detail)";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function kirim_transaksi_shipment($data, $invoice, $user)
{
  global $koneksi;

  $query = "INSERT INTO transaksi_shipment (no_trx, tanggal_scan, jam_scan, kode_barcode, orc, qty, waktu_kirim, kelompok, id_shipment, username)
  (select no_trx, tanggal, jam, kode_barcode, orc, qty, now(), kelompok, $invoice, '$user' from transaksi_packing where id_transaksi_packing IN($data))";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function kirim_data_transaksi_shipment($user, $invoice)
{
  global $koneksi;

  $query = "INSERT INTO transaksi_shipment (no_trx, tanggal_scan, jam_scan, kode_barcode, orc, qty, waktu_kirim, kelompok, id_shipment, username)
  (select no_trx, tanggal_scan, jam_scan, kode_barcode, orc, qty, now(), kelompok, id_shipment, '$user' from temp_shipment where id_shipment = $invoice)";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function update_shipment_transaksi_scan_packing_y($data, $invoice)
{
  global $koneksi;

  $query = "UPDATE transaksi_packing SET shipment = 'y', id_shipment = $invoice where id_transaksi_packing IN($data)";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function update_status_kenzin($no_kenzin)
{
  global $koneksi;

  $query = "UPDATE transaksi_kenzin SET status_kenzin = 'packing' where no_trx = $no_kenzin";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function update_status_master_order($editStatus, $data)
{
  global $koneksi;

  $query = "UPDATE master_order SET status = '$editStatus' where id_order IN($data)";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function update_shipment_transaksi_scan_packing_n($data, $invoice)
{
  global $koneksi;

  $query = "UPDATE transaksi_packing SET shipment = 'n', id_shipment = null where no_trx IN($data) AND id_shipment = $invoice";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function update_master_bundle_lot($data, $lot, $user)
{
  global $koneksi;

  $query = "UPDATE master_bundle SET lot = '$lot', username_lot = '$user', waktu_lot = now() where id_bundle IN($data)";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function hapus_transaksi_shipment($data)
{
  global $koneksi;

  $query = "DELETE FROM transaksi_shipment where id_transaksi_shipment IN($data)";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

// ---------------Monitor-------------------------------
function tampil_monitor_qc_endline($tgl, $line){
  global $koneksi;
  // $dateYesterday = date_sub($tgl, date_interval_create_from_date_string("1 days"));
  // $strYesterday = date_format($dateYesterday, "Y-m-d");
 
  $query = "SELECT B.id, B.orc, B.line, B.`status`, B.style, B.smv, B.color, B.size, B.cup, B.qty_order AS `QTY_ORDER`,B.tanggal,
            (SELECT MAX(A.jam) FROM view_transaksi_qc_endline A WHERE A.tanggal = '$tgl' AND A.orc = B.orc ) AS JAM,
            (SELECT IFNULL( SUM( A.qty ), 0 ) FROM view_transaksi_qc_endline A WHERE A.tanggal = '$tgl' AND A.orc = B.orc AND A.line = B.line ) AS TODAY,
            (SELECT SUM( A.qty ) FROM view_transaksi_qc_endline A WHERE A.tanggal <= '$tgl' AND A.orc = B.orc) AS TOTAL,
            ((SELECT SUM( A.qty ) FROM view_transaksi_qc_endline A WHERE A.tanggal <= '$tgl' AND A.orc = B.orc) - B.qty_order) AS BAL 
            FROM `view_transaksi_qc_endline` B 
            WHERE B.line = '$line' 
              AND B.tanggal = '$tgl' 
              AND B.`status` = 'open' 
            GROUP BY B.orc ORDER BY B.id DESC";
  
  $rst = mysqli_query($koneksi, $query);
  return $rst;
}

function get_output_qc_endline($tgl, $line){
  global $koneksi;

  $query = "SELECT id, orc, line, style, smv, qty_order, qty, tanggal, jam 
            FROM view_transaksi_qc_endline WHERE tanggal='$tgl' AND line='$line' AND status='open' ORDER BY jam";

  $rst = mysqli_query($koneksi, $query);
  return $rst;

}

function get_output_qc_endline_yesterday($tgl, $line){
  global $koneksi;
  $date = date_create($tgl);
  date_sub($date, date_interval_create_from_date_string("1 day"));
  $strDate = date_format($date, "Y-m-d");

  $query = "SELECT SUM(qty) AS Output_Yesterday FROM `transaksi_qc_endline` WHERE tanggal='$strDate' AND line='$line'";
  $rst = mysqli_query($koneksi, $query);
  return $rst;  

}

function tampil_monitor_tatami($tgl){
  global $koneksi;

  $yesterday = date('Y-m-d', strtotime("-1 days"));

  $query = "SELECT B.id, B.orc, B.`status`, B.style, B.color, B.size, B.cup, B.qty_order AS `QTY_ORDER`,B.tanggal,
            (SELECT MAX(A.jam) FROM view_transaksi_tatami A WHERE A.tanggal = '$tgl' AND A.orc = B.orc ) AS JAM,
            (SELECT IFNULL( SUM( A.qty ), 0 ) FROM view_transaksi_tatami A WHERE A.tanggal = '$tgl' AND A.orc = B.orc) AS TODAY,
            (SELECT SUM( A.qty ) FROM view_transaksi_tatami A WHERE A.tanggal <= '$tgl' AND A.orc = B.orc) AS TOTAL,
            ((SELECT SUM( A.qty ) FROM view_transaksi_tatami A WHERE A.tanggal <= '$tgl' AND A.orc = B.orc) - B.qty_order) AS BAL 
            FROM `view_transaksi_tatami` B 
            WHERE B.tanggal = '$tgl' 
              AND B.`status` = 'open' 
            GROUP BY B.orc ORDER BY B.id DESC";
  
  $rst = mysqli_query($koneksi, $query);
  return $rst;
}

function get_output_packing_yesterday($tgl,$line=''){
  global $koneksi;
  $date = date_create($tgl);
  date_sub($date, date_interval_create_from_date_string("1 day"));
  $strDate = date_format($date, "Y-m-d");

  $query = "SELECT SUM(qty) AS Packing_Yesterday FROM `view_transaksi_tatami_perline` WHERE tanggal='$strDate' 
            AND `line` LIKE '%$line%'";
            
  $rst = mysqli_query($koneksi, $query);

  return $rst;  

}

function get_output_packing_today($line){
  global $koneksi;

  // $query = "SELECT SUM(qty) AS Packing_Today,`line` FROM `view_transaksi_tatami_perline` WHERE tanggal=CURDATE() 
  //           AND `line`='$line'";

  $query = "SELECT SUM(qty) AS Packing_Today,`line` FROM `view_transaksi_tatami_perline` WHERE tanggal=CURDATE() 
            AND `line`='$line' GROUP BY `line`";
            
  $response = mysqli_query($koneksi, $query);
  $result = mysqli_fetch_assoc($response);
  $jsonResult = json_encode($result);

  return $jsonResult;  
}



// ==================================== HAPUS DATA ========================================

function hapus_data_kenzin($id)
{
  $query = "DELETE FROM temp_kenzin where id_transaksi_kenzin='$id'";
  return run($query);
}

function hapus_data_packing($id)
{
  $query = "DELETE FROM temp_packing where id_transaksi_packing='$id'";
  return run($query);
}

function hapus_data_barang($id)
{
  $query = "DELETE FROM barang where kode_barcode='$id'";
  return run($query);
}

function hapus_data_line($id)
{
  $query = "DELETE FROM master_line where id_line='$id'";
  return run($query);
}

function hapus_data_contract($id)
{
  $query = "DELETE FROM contract_number where id_contract='$id'";
  return run($query);
}

function hapus_data_item($id)
{
  $query = "DELETE FROM items where id_item='$id'";
  return run($query);
}

function hapus_data_style($id)
{
  $query = "DELETE FROM style where id_style='$id'";
  return run($query);
}

function hapus_data_material($id)
{
  $query = "DELETE FROM master_material where id_material='$id'";
  return run($query);
}

function hapus_data_costomer($id)
{
  $query = "DELETE FROM costomer where id_costomer='$id'";
  return run($query);
}

function hapus_data_shipment($id)
{
  $query = "DELETE FROM shipment where id_shipment='$id'";
  return run($query);
}

function hapus_data_label($id)
{
  $query = "DELETE FROM label where id_label='$id'";
  return run($query);
}


function hapus_data_temp_packing_grup($id)
{

  $query = "DELETE FROM temp_packing WHERE id_transaksi_packing = $id;
       ";
  return run($query);
}

function hapus_data_packing_edit_grup($id)
{

  $query = "DELETE FROM transaksi_packing WHERE id_transaksi_packing = $id;
       ";
  return run($query);
}

function hapus_data_temp_kenzin_grup($id)
{

  $query = "DELETE FROM temp_kenzin WHERE id_transaksi_kenzin = $id;
     ";

  return run($query);
}

function hapus_data_temp_qcfinal_grup($id)
{

  $query = "DELETE FROM temp_qcfinal WHERE id_transaksi_qcfinal = $id;
       ";

  return run($query);
}


function hapus_data_qc_kensa_grup($id)
{

  $query = "DELETE FROM temp_qc_kensa WHERE id_transaksi_qc_kensa = $id;
       ";
  return run($query);
}


function hapus_data_tatami_in_grup($id)
{

  $query = "DELETE FROM temp_tatami_in WHERE id_transaksi_tatami_in = $id;
       ";
  return run($query);
}


function hapus_data_reject_tatami_grup($id)
{

  $query = "DELETE FROM temp_reject_tatami WHERE id_transaksi_reject = $id;
       ";
  return run($query);
}

function hapus_data_tatami_out_grup($id)
{

  $query = "DELETE FROM temp_tatami_out WHERE id_transaksi_tatami_out = $id;
       ";
  return run($query);
}

function hapus_data_temp_ganti_label_grup($id)
{

  $query = "DELETE FROM temp_ganti_label WHERE id_trx_ganti_label='{$id}';
     ";

  return run($query);
}

function hapus_data_qtyordersize($id)
{

  $query = "DELETE FROM temp_order_detail WHERE id_order_detail = $id";

  return run($query);
}

function hapus_data_qtyOrder($id)
{

  $query = "DELETE FROM order_detail WHERE id_order = $id;
     ";

  return run($query);
}

function hapusDataMasterOrder($id)
{

  $query = "DELETE FROM master_order WHERE id_order = $id;
     ";

  return run($query);
}


function hapusDataMasterTarget($id)
{

  $query = "DELETE FROM master_target WHERE id = $id;
     ";

  return run($query);
}

function hapus_data_check($data)
{
  $query = "DELETE FROM transaksi_packing WHERE id_transaksi_packing IN ($data)";

  return run($query);
}

function delete_transaksi_temp_shipment($data, $invoice)
{
  $query = "DELETE FROM transaksi_shipment WHERE no_trx IN ($data) AND id_shipment = $invoice";

  return run($query);
}

function delete_transaksi_kenzin($trx_kenzin)
{
  $query = "DELETE FROM transaksi_kenzin WHERE no_trx = $trx_kenzin";

  return run($query);
}

function delete_transaksi_packing($trx_kenzin)
{
  $query = "DELETE FROM transaksi_packing WHERE no_before = $trx_kenzin";

  return run($query);
}

function hapus_trx_produksi_bundle($id, $temp_table)
{
  $query = "DELETE FROM $temp_table where id_transaksi='$id'";
  return run($query);
}

function hapus_bom_detail_material_part($id)
{
  $query = "DELETE FROM master_bom_detail_part where id_bom_detail = '$id'";
  return run($query);
}

function hapus_bom_detail_material_part_orc($id)
{
  $query = "DELETE FROM master_bom_detail_part_orc where id_bom_detail_orc = '$id'";
  return run($query);
}

function hapus_bom_detail_material_part_id($id_bom_detail_part)
{
  $query = "DELETE FROM master_bom_detail_part where id_bom_detail_part = '$id_bom_detail_part'";
  return run($query);
}

function hapus_bom_detail_material_part_orc_id($id_bom_detail_part)
{
  $query = "DELETE FROM master_bom_detail_part_orc where id_bom_detail_part = '$id_bom_detail_part'";
  return run($query);
}


function hapus_bom_detail_material($id)
{
  $query = "DELETE FROM master_bom_detail where id_bom_detail = '$id'";
  return run($query);
}

function hapus_bom_detail_material_orc($id)
{
  $query = "DELETE FROM master_bom_detail_orc where id_bom_detail_orc = '$id'";
  return run($query);
}

function hapus_bom_detail_material_orc_id_order($id_bom)
{
  $query = "DELETE FROM master_bom_detail_orc where id_bom_orc = '$id_bom'";
  return run($query);
}

function hapus_bom_detail_material_part_orc_id_order($id_bom_orc)
{
  $query = "DELETE master_bom_detail_part_orc FROM master_bom_detail_part_orc
  JOIN master_bom_detail_orc ON master_bom_detail_part_orc.id_bom_detail_orc = master_bom_detail_orc.id_bom_detail_orc
  WHERE master_bom_detail_orc.id_bom_orc = $id_bom_orc";

  return run($query);
}

function hapus_transaksi_reject($data)
{
  global $koneksi;

  $query = "DELETE FROM reject_packing where id_transaksi_reject IN($data)";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}


function hapus_data_qtyordersize_perorder($id)
{

  $query = "DELETE FROM order_detail WHERE id_order_detail = $id;
     ";

  return run($query);
}

function hapus_master_line_operator($id)
{

  $query = "DELETE FROM master_line_operator WHERE id = $id;
     ";

  return run($query);
}


function hapusMasterBundle($id_order)
{

  $query = "DELETE master_bundle FROM master_bundle left join order_detail  on master_bundle.id_order_detail = order_detail.id_order_detail WHERE order_detail.id_order = $id_order;
     ";

  return run($query);
}

function hapusProsesTransaksiOrc($id_order)
{

  $query = "DELETE FROM proses_transaksi_orc WHERE id_order = $id_order;
     ";

  return run($query);
}

function hapus_data_transaksi_packing($trx)
{

  $query = "DELETE FROM transaksi_packing WHERE no_trx = $trx;
     ";

  return run($query);
}

function hapus_data_style_color($id)
{

  $query = "DELETE FROM style_color WHERE id_color_style = $id;
     ";

  return run($query);
}

function hapus_data_material_color($id)
{

  $query = "DELETE FROM master_material_color WHERE id_color_material = $id;
     ";

  return run($query);
}

function hapus_data_master_part($id)
{

  $query = "DELETE FROM master_part WHERE id_part = $id;
     ";

  return run($query);
}

function hapus_data_temp_part_cutting($id_order)
{

  $query = "DELETE temp_part_cutting FROM temp_part_cutting JOIN order_detail on temp_part_cutting.id_order_detail = order_detail.id_order_detail
  WHERE order_detail.id_order = $id_order ";

  return run($query);
}

function hapus_data_temp_part_cutting_size_id_order($id_order)
{

  $query = "DELETE temp_part_cutting_size FROM temp_part_cutting_size JOIN order_detail on temp_part_cutting_size.id_order_detail = order_detail.id_order_detail
  WHERE order_detail.id_order = $id_order ";

  return run($query);
}

function hapus_data_temp_part_cutting_part_id_order($id_order)
{

  $query = "DELETE FROM temp_part_cutting_part 
  WHERE id_order = $id_order ";

  return run($query);
}


function hapus_data_temp_part_cutting_reject($id_order)
{

  $query = "DELETE temp_part_cutting_reject FROM temp_part_cutting_reject JOIN order_detail on temp_part_cutting_reject.id_order_detail = order_detail.id_order_detail
  WHERE order_detail.id_order = $id_order ";

  return run($query);
}

function hapus_data_temp_part_cutting_part($id_transaksi)
{

  $query = "DELETE temp_part_cutting_part FROM temp_part_cutting_part 
  WHERE id_transaksi = $id_transaksi ";

  return run($query);
}

function hapus_data_temp_part_cutting_size($id_transaksi)
{

  $query = "DELETE temp_part_cutting_size FROM temp_part_cutting_size 
  WHERE id_transaksi = $id_transaksi ";

  return run($query);
}


function delete_qty_temp_part_cutting($idTemp)
{
  global $koneksi;

  $query = "DELETE FROM temp_part_cutting where id_transaksi = $idTemp";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');

  return $result;
}

function tampilkan_spv_by_namaline($namaline){
  global $koneksi;
  // $query = "SELECT * FROM master_line WHERE nama_line = '$namaline'";
  $query = "SELECT * FROM view_master_line_operator WHERE nama_line = '$namaline'";
  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  return $result;  
}

function get_data_transaksi($id, $tb){
  global $koneksi;
  $query = "SELECT * FROM $tb WHERE id_transaksi='$id'";
  $rst = mysqli_query($koneksi, $query);

  return $rst;
}


function run($query)
{
  global $koneksi;

  if (mysqli_query($koneksi, $query)) return true;
  else return false;
}


//tanggal indonesia


function tanggal_indo($tanggal, $cetak_hari = false)
{
  $hari = array(
    1 =>    'Senin',
    'Selasa',
    'Rabu',
    'Kamis',
    'Jumat',
    'Sabtu',
    'Minggu'
  );

  $bulan = array(
    1 =>   'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  );
  $split     = explode('-', $tanggal);
  $tgl_indo = $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];

  if ($cetak_hari) {
    $num = date('N', strtotime($tanggal));
    return $hari[$num] . ', ' . $tgl_indo;
  }
  return $tgl_indo;
}

function tanggal_indo2($tanggal, $cetak_hari = false)
{
  $hari = array(
    1 =>    'SENIN',
    'SELASA',
    'RABU',
    'KAMIS',
    'JUMAT',
    'SABTU',
    'MINGGU'
  );

  $bulan = array(
    1 =>   'JANUARI',
    'FEBRUARI',
    'MARET',
    'APRIL',
    'MEI',
    'JUNI',
    'JULI',
    'AGUSTUS',
    'SEPTEMBER',
    'OKTOBER',
    'NOVEMBER',
    'DESEMBER'
  );
  $split     = explode('-', $tanggal);
  $tgl_indo = $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];


  if ($cetak_hari) {
    $num = date('N', strtotime($tanggal));
    // return $hari[$num] . ', ' . $tgl_indo;
  }
  return $tgl_indo;
}

function tanggal_indo3($tanggal)
{

  $split     = explode('-', $tanggal);
  $tgl_indo = $split[2] . '-' . $split[1] . '-' . $split[0];

  return $tgl_indo;
}

function tgl_indonesia($date)
{
  $Hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu",);
  $Bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
  $tahun = substr($date, 0, 4);
  $bulan = substr($date, 5, 2);
  $tgl   = substr($date, 8, 2);
  $waktu = substr($date, 11, 5);
  $hari   = date("w", strtotime($date));
  $result = $Hari[$hari] . ", " . $tgl . " " . $Bulan[(int)$bulan - 1] . " " . $tahun . " " . $waktu . " WIB";
  return $result;
}

function tgl_indonesia2($date)
{
  $tahun = substr($date, 0, 4);
  $bulan = substr($date, 5, 2);
  $tgl   = substr($date, 8, 2);
  $waktu = substr($date, 11, 8);
  $hari   = date("w", strtotime($date));
  $result = $tgl . "-" . $bulan . "-" . $tahun . " - " . $waktu . "";
  return $result;
}

function tgl_indonesia3($date)
{
  $tahun = substr($date, 0, 4);
  $bulan = substr($date, 5, 2);
  $tgl   = substr($date, 8, 2);
  $hari   = date("w", strtotime($date));
  $result = $tgl . "-" . $bulan . "-" . $tahun . "";
  return $result;
}

function tgl_indonesia4($date)
{
  $tahun = substr($date, 0, 4);
  $bulan = substr($date, 5, 2);
  $tgl   = substr($date, 8, 2);
  $hari   = date("w", strtotime($date));
  $result = $tgl . "/" . $bulan;
  return $result;
}

function tgl_indonesia5($date)
{
  $Hari = array("MINGGU", "SENIN", "SELASA", "RABU", "KAMIS", "JUM'AT", "SABTU",);
  $Bulan = array("JANUARI", "FEBRUARI", "MARET", "APRIL", "MEI", "JUNI", "JULI", "AGUSTUS", "SEPTEMBER", "OKTOBER", "NOVEMBER", "DESEMBER");
  $tahun = substr($date, 0, 4);
  $bulan = substr($date, 5, 2);
  $tgl   = substr($date, 8, 2);
  $waktu = substr($date, 11, 5);
  $hari   = date("w", strtotime($date));
  $result = $Hari[$hari] . ", " . $tgl . " " . $Bulan[(int)$bulan - 1] . " " . $tahun;
  return $result;
}

function tgl_indonesia6($date)
{
  $Hari = array("MG", "SN", "SL", "RB", "KM", "JM", "SB",);

  $tgl   = substr($date, 8, 2);
  $hari   = date("w", strtotime($date));
  $result = $tgl . "-" . $Hari[$hari];
  return $result;
}

function tgl_indonesia_hari($date)
{
  $Hari = array("MINGGU", "SENIN", "SELASA", "RABU", "KAMIS", "JUM'AT", "SABTU",);

  $hari   = date("w", strtotime($date));
  $result = $Hari[$hari];
  return $result;
}


function getRomawi($bln)
{
  switch ($bln) {
    case 1:
      return "I";
      break;
    case 2:
      return "II";
      break;
    case 3:
      return "III";
      break;
    case 4:
      return "IV";
      break;
    case 5:
      return "V";
      break;
    case 6:
      return "VI";
      break;
    case 7:
      return "VII";
      break;
    case 8:
      return "VIII";
      break;
    case 9:
      return "IX";
      break;
    case 10:
      return "X";
      break;
    case 11:
      return "XI";
      break;
    case 12:
      return "XII";
      break;
  }
}

function get_temp_tatami_barcode_by_user($user){
  global $koneksi;
  $query = "SELECT kode_barcode, qty, username FROM temp_tatami WHERE
            username='$user' AND tanggal=CURDATE()";
  // var_dump($query);

  $rst = mysqli_query($koneksi, $query);

  return $rst;  
}

function get_temp_trimstore_barcode_by_user($user){
  global $koneksi;

  $query = "SELECT kode_barcode, qty, username FROM temp_trimstore WHERE
            username='$user' AND tanggal=CURDATE()";
  // var_dump($query);

  $rst = mysqli_query($koneksi, $query);

  return $rst;
}

function get_data_qc_endline_by_barcode($barcode){
  global $koneksi;

  $query = "SELECT `line`, qty FROM transaksi_qc_endline WHERE kode_barcode='$barcode'";
  $rst = mysqli_query($koneksi, $query);

  return $rst;  
}

function get_data_trimstore_by_barcode($barcode){
  global $koneksi;

  $query = "SELECT `orc`, qty_order, plan_line, tanggal, qty FROM view_transaksi_trimstore WHERE kode_barcode='$barcode'";
  $rst = mysqli_query($koneksi, $query);

  return $rst;  
}