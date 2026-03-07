<?php 
    require_once 'core/init.php';
    
    $username = $_SESSION['username'];
    $id_order = $_POST['id_order'];
    $proses=$_POST['proses']; 
    $jml_dipilih =count($proses);
    if(cek_master_bundle($id_order) == 0){

        $qty_bundle = $_POST['qty_bundle'];
        $i = 0;
        $data1 = tampilkan_data_order_id($id_order);
        $qtyisibundle = 0;
        while($row=mysqli_fetch_assoc($data1)){
            $jumlah_bundle = ceil($row['qty_order'] / $qty_bundle);
            if($jumlah_bundle > 1){
                $qty_bundle_terakhir = $row['qty_order'] - ($qty_bundle * ($jumlah_bundle-1));
            }else{
                $qty_bundle_terakhir = $row['qty_order'];
            }
            // echo $qty_bundle_terakhir.'<br>';

            for($i=1; $i<=$jumlah_bundle; $i++){
                if($i != $jumlah_bundle){
                    $qtyisibundle = $qty_bundle;
                }else{
                    $qtyisibundle = $qty_bundle_terakhir;
                }
            
                $size = str_replace("/","-", $row['size']);
                $cup = str_replace ("/","-", $row['cup']);



                $no_bundle = sprintf("%02d", $qtyisibundle).sprintf("%02d", $i).sprintf("%02d", $jumlah_bundle);
                $barcode_bundle = sprintf("%02d", $i)."-".$size.$cup.$row['orc'];
                $id_order_detail = $row['id_order_detail'];
            
                tambah_data_master_bundle($id_order_detail, $i, $no_bundle, $barcode_bundle, $qtyisibundle, $username);
                
            }
        }
        for($x=0; $x<$jml_dipilih; $x++){
            $urutan= $x+1;
           if(tambah_data_proses_transaksi_orc($id_order, $proses[$x], $urutan, $username)){
            $_SESSION['pesan'] = 'DATA PROSES TRANSAKSI BERHASIL TERGENERATE ULANG';
            header("Location:barcode_master_order.php?id=$id_order");
           }else{
            echo 'gagal';
           }
        }
    }else{
        
        $_SESSION['pesan'] = 'MAAF BUNDLE RECORD UDAH TER GENERATE SEBELUMNYA';
        header("Location:barcode_master_order.php?id=$id_order");
        echo $id_order;
    }
    
?>