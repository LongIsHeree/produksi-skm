<?php

  require_once 'core/init.php';
    global $koneksi;
    if(ISSET($_SESSION['username'])){
    $user = $_SESSION['username'];
    $kode_barcode = trim($_POST['isi_barcode']);
    $tanggal = date("Y-m-d");
    $jam     = date("H:i:s");
   
    $temp_table = $_POST['temp_table'];
    $table = $_POST['table'];
    $proses = $_POST['proses'];
    $tipe = $_POST['tipe'];

    if(cek_status($_SESSION['username'] ) != 'admin'){
        if(cek_status($_SESSION['username'] ) != $proses){
            $pesan = "error_username";
            echo $pesan;
            die();
        }
    }

  // Tambahkan A.qty di query utama
$query = "SELECT E.costomer, B.orc, B.no_po, B.label, D.style, B.color, C.warna, A.no_trx, A.qty
          From transaksi_packing A
          JOIN master_order B On A.orc = B.orc
          JOIN Barang C On A.kode_barcode = C.kode_barcode
          JOIN Style D On C.id_style = D.id_style
          JOIN costomer E ON B.id_costomer = E.id_costomer
          LEFT OUTER JOIN size F on C.size = F.size AND IFNULL(C.cup, '') = IFNULL(F.cup, '')
          WHERE A.no_trx = $kode_barcode
          Group By A.no_trx, C.id_style, B.orc
          ORDER BY B.orc desc";

  $result = mysqli_query($koneksi, $query) or die('gagal menampilkan data');
  // Cek barcode ditemukan
if(mysqli_num_rows($result) == 0){
    echo "errorDb";
    die();
}

$data = mysqli_fetch_assoc($result);

// Cek apakah barcode sudah ada di temp table
$cek = mysqli_query($koneksi, "SELECT * FROM $temp_table 
                                WHERE kode_barcode = '$kode_barcode' 
                                AND username = '$user'");

if(mysqli_num_rows($cek) > 0){
     $pesan = 'over_bundle';
     echo $pesan;
} else {
   // Ambil no_trx terakhir dari transaksi_carton dan temp_table
$query_last_trx = mysqli_query($koneksi, "SELECT IFNULL(MAX(A.no_trx), 0) + 1 AS last_trx FROM
                                          (SELECT MAX(no_trx) as no_trx FROM $table
                                           UNION
                                           SELECT MAX(no_trx) as no_trx FROM $temp_table WHERE username != '$user') A");
$data_last_trx = mysqli_fetch_assoc($query_last_trx);
$no_trx_baru   = $data_last_trx['last_trx'];
// Ambil qty per size dari transaksi_packing
$query_size = mysqli_query($koneksi, "SELECT CONCAT('size_', lower(trim(replace(replace(B.size, '-', '_'), '/', '_'))), lower(TRIM(ifnull(B.cup,'')))) as detail_size,
                                             A.qty
                                      FROM transaksi_packing A
                                      JOIN barang B ON A.kode_barcode = B.kode_barcode
                                      LEFT OUTER JOIN size F ON B.size = F.size AND IFNULL(B.cup, '') = IFNULL(F.cup, '')
                                      WHERE A.no_trx = '$kode_barcode'
                                      ORDER BY F.urutan");

// Bangun kolom dan nilai size secara dinamis
$kolom_size = '';
$nilai_size  = '';
while($sz = mysqli_fetch_assoc($query_size)){
    $kolom_size .= ", `{$sz['detail_size']}`";
    $nilai_size  .= ", '{$sz['qty']}'";
}

// INSERT dengan kolom size dinamis
$proses_db = mysqli_query($koneksi, "INSERT INTO $temp_table 
                                        (no_trx, orc, no_po, label, style, kode_barcode, color, costomer, qty , qty_isi_karton, username, tanggal, jam)
                                     VALUES 
                                        ('$no_trx_baru', '{$data['orc']}', '{$data['no_po']}', 
                                         '{$data['label']}', '{$data['style']}', '{$data['no_trx']}', '{$data['color']}', 
                                         '{$data['costomer']}', 1 , '{$data['qty']}', '$user', '$tanggal', '$jam')");
if($proses_db){
    echo "success";
} else {
    echo "errorDb";
}
}



 
}
 
?>
