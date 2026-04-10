<?php
ob_start();

require_once 'core/init.php';
require_once 'view/header.php';

// session_unset();
// session_destroy();
// ini_set('session.gc_maxlifetime', 36000);
// session_set_cookie_params(36000);
// session_start();

if( isset($_SESSION['username'])){
  header("HTTP/1.1 301 Moved Permanently");
  header('Location: master-barang.php');
}

?>
<style>
/* Bordered form */
/* Full-width inputs */
input[type=text], input[type=password] {
  width: 100%;
  padding: 8px 20px;
  margin: 10px 0;
  /* display: inline-block; */
  border: 1px solid #ccc;
  box-sizing: border-box;
}

/* Set a style for all buttons */
button {
  background-color:#254681;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

/* Add a hover effect for buttons */
button:hover {
  opacity: 0.8;
}

/* Extra style for the cancel button (red) */
.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

/* Center the avatar image inside this container */
.imgcontainer {
  text-align: center;
  margin: 15px 0 12px 0;
}

/* Avatar image */
img.avatar {
  width: 15%;
  /* border-radius: 50%; */
}

/* Add padding to containers */
.container {
  padding: 16px;
}

/* The "Forgot password" text */
span.psw {
  float: right;
  padding-top: 16px;
}

.alert{
	/* background: #e44e4e; */
	color: red;
	padding: 10px;
	text-align: center;
	border:1px solid #b32929;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
    display: block;
    float: none;
  }

}

</style>
<?php
$error = '';

  if( isset($_POST['submit'])){
    $username = $_POST['username'];
    $pass =  $_POST['password'];
    

    if(!empty(trim($username)) && !empty(trim($pass))){
      if (cek_username($username) != 0){
        if($pilih = cek_data($username, $pass) == true){       
            $_SESSION['username'] = $username;
            $_SESSION['monitor'] = $username;
          if(cek_status($_SESSION['username'] ) == 'admin'){
          header('Location: landing_page.php');
          }elseif(cek_status($_SESSION['username'] ) == 'packing_outerware'){
            header('Location: temp_packing.php');
          }elseif(cek_status($_SESSION['username'] ) == 'kenzin'){
            header('Location: temp_kenzin.php');
          }elseif(cek_status($_SESSION['username'] ) == 'shipment'){
            header('Location: transaksi-shipment.php');
          }elseif(cek_status($_SESSION['username'] ) == 'cutting'){
            header('Location: temp_cutting.php');
          }elseif(cek_status($_SESSION['username'] ) == 'press'){
            header('Location: temp_press.php');
          }elseif(cek_status($_SESSION['username'] ) == 'bemis'){
            header('Location: temp_bemis.php');
          }elseif(cek_status($_SESSION['username'] ) == 'qc_cutpart'){
            header('Location: temp_qc_cutpart.php');
          }elseif(cek_status($_SESSION['username'] ) == 'preparation'){
            header('Location: temp_preparation.php');
          }elseif(cek_status($_SESSION['username'] ) == 'sewing'){
            header('Location: temp_sewing.php');
          }elseif(cek_status($_SESSION['username'] ) == 'bbl'){
            header('Location: temp_bbl.php');
          }elseif(cek_status($_SESSION['username'] ) == 'qc_endline'){
            header('Location: temp_qc_endline.php');
          }elseif(cek_status($_SESSION['username'] ) == 'ht'){
            header('Location: temp_ht.php');
          }elseif(cek_status($_SESSION['username'] ) == 'ht2'){
            header('Location: temp_ht2.php');
          }elseif(cek_status($_SESSION['username'] ) == 'washing'){
            header('Location: temp_washing.php');
          }elseif(cek_status($_SESSION['username'] ) == 'iron'){
            header('Location: temp_iron.php');
          }elseif(cek_status($_SESSION['username'] ) == 'qc_buyer'){
            header('Location: temp_qc_buyer.php');
          }elseif(cek_status($_SESSION['username'] ) == 'qc_transfer'){
            header('Location: temp_qc_transfer.php');
          }elseif(cek_status($_SESSION['username'] ) == 'tatami_in'){
            header('Location: temp_tatami_in2.php');
          }elseif(cek_status($_SESSION['username'] ) == 'tatami'){
            header('Location: temp_tatami.php');
          }elseif(cek_status($_SESSION['username'] ) == 'marubeni'){
            header('Location: cetak_laporan_hasil_kenzin_buyer.php');
          }elseif(cek_status($_SESSION['username'] ) == 'report'){
            header('Location: cetak_laporan_hasil_scan_global.php');
          }elseif(cek_status($_SESSION['username'] ) == 'warehouse' || cek_status($_SESSION['username'] ) == 'team_sample'
          || cek_status($_SESSION['username'] ) == 'ppm' || cek_status($_SESSION['username'] ) == 'pattern_check'
          || cek_status($_SESSION['username'] ) == 'moulding_bounding' || cek_status($_SESSION['username'] ) == 'template_sewing'
          || cek_status($_SESSION['username'] ) == 'machines_setting' || cek_status($_SESSION['username'] ) == 'layout'
          || cek_status($_SESSION['username'] ) == 'ready_produksi'){
            header('Location: temp_preparation_production.php');
          }
        }else{
          $error = 'Kombinasi Username dan Password salah';
        }

          }else{
            $error = 'Username tidak terdaftar'; 
          }
        }else{
          $error = 'Data tidak boleh ada yang kosong';
        }
    }
    // session_destroy();
    // session_set_cookie_params(3600*24,"/");
    // session_start();

?>
<center>
<h2>SISTEM PRODUKSI<br>PT. Globalindo Intimates</h2>
</center>

  <form method="post" id="form">
  <div class="imgcontainer">
    <!-- <img src="img/skm2.png" alt="Avatar" class="avatar"> -->
    <img src="img/gi-logo.png" alt="Avatar" class="avatar">
  </div>

  <div class="container">
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="username" class="form-control" required>

    <label for="password"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" id="password" class="form-control" required>
    <input type="checkbox" id="show-hide" onclick="myFunction()">
    <label for="show-hide" style="color:blue">Show Password</label>
    <button type="submit" name="submit">Login</button>
  </form>
  </div>

  <div class="container" style="background-color:#f1f1f1">
    <span class="error">
    <?php
    	echo $error;
    ?>
    </span> 
    <span class="psw">Forgot <a href="#">password?</a></span>
  </div>
</body>
</html>

<!-- Melihat Password -->
<script>
   function myFunction() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>
