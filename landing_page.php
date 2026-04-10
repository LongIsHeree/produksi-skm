<?php
require_once 'core/init.php';
require_once 'view/header.php';

// cek apakah yang mengakses halaman ini sudah login
if (!isset($_SESSION['username'])) {
  echo "<script>alert('Silakan Login terlebih dahulu untuk mengakses halaman ini');window.location='index.php'</script>";
  exit();
}
?>

<style>
  .video-container {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: -1;
    overflow: hidden;
  }

  .video-container video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
</style>

<div class="video-container">
  <video autoplay muted loop playsinline>
    <source src="assets/images/COMPANY PROFILE PT. GLOBALINDO INTIMATES.mp4" type="video/mp4">
    Browser Anda tidak mendukung tag video.
  </video>
</div>

</div> <!-- Closes .container opened in view/header.php -->

</body>

</html>