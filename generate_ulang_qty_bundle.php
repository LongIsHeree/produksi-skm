<?php 
    require_once 'core/init.php';
    
    $username = $_SESSION['username'];
    $id_order = $_POST['id_order'];
   
    if(cek_master_bundle($id_order) != 0){
       hapusMasterBundle($id_order);
         
        // $qty_bundle = $_POST['qty_bundle'];
        $i = 0;
        $data1 = tampilkan_data_order_id($id_order);
        $qtyisibundle = 0;
        while($row=mysqli_fetch_assoc($data1)){
            $qty_bundle = $row['qty_bundle'];
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
                $_SESSION['pesan'] = 'DATA BERHASIL TERGENERATE ULANG';
                header("Location:barcode_master_order.php?id=$id_order");
            }
        }
    }else{
        $_SESSION['pesan'] = 'DATA BELUM PERNAH SAMA SEKALI TERGENERATE, SILAKAN COBA GENERATE ULANG DISINI';
        header("Location:barcode_master_order.php?id=$id_order");
    }
        
 
    
?>