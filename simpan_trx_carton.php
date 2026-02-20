<?php require_once "core/init.php";

if(isset($_POST['kirim'])){
    $user       = $_SESSION['username'];
    $temp_table = $_POST['temp_table'];
    $table      = $_POST['table'];
    $proses     = $_POST['proses'];
    $tipe       = $_POST['tipe'];

    // Ambil semua data dari temp table milik user
    $query_temp = mysqli_query($koneksi, "SELECT * FROM $temp_table WHERE username = '$user'");

    if(mysqli_num_rows($query_temp) == 0){
        $_SESSION['pesan'] = 'Tidak ada data yang disimpan';
        header("Location: transaksi_carton.php");
        die();
    }

    $tanggal = date("Y-m-d");
    $jam     = date("H:i:s");
    $sukses  = true;

    while($row = mysqli_fetch_assoc($query_temp)){
       $insert = mysqli_query($koneksi, "INSERT INTO $table 
                                    (no_trx, kode_barcode, qty, qty_isi_karton, username, style, orc, color, no_po, costomer, tanggal, jam)
                                  VALUES
                                    ('{$row['no_trx']}', '{$row['kode_barcode']}', '{$row['qty']}', '{$row['qty_isi_karton']}',
                                     '$user', '{$row['style']}', '{$row['orc']}', '{$row['color']}', 
                                     '{$row['no_po']}', '{$row['costomer']}', '$tanggal', '$jam')");
        if(!$insert){
            $sukses = false;
            break;
        }
    }

    if($sukses){
        // Reset temp table setelah simpan
        mysqli_query($koneksi, "DELETE FROM $temp_table WHERE username = '$user'");
        $_SESSION['pesan'] = 'Data Transaksi Carton Berhasil Disimpan';
    } else {
        $_SESSION['pesan'] = 'Gagal menyimpan data, hubungi Team IT';
    }

    header("Location: temp_carton.php");
    die();
}
?>