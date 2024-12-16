<?php
if (session_status() == PHP_SESSION_NONE) {
  
}
if (!empty($_SESSION['id_user'])) {
    include "koneksi.php";
?>
<!-- Include Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

<!-- Fixed navbar -->
<div class="navbar navbar-inverse navbar-fixed-top animate__animated animate__fadeInDown" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href=""><span class="	glyphicon glyphicon-calendar"></span> Aplikasi 3FG Carwash</a>
    </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li><a href="./admin.php">Beranda</a></li>
        <li><a href="?hlm=paket">Paket</a></li>
        <li><a href="./admin.php?hlm=transaksi">Transaksi</a></li>  
        
        <?php
        // Menampilkan opsi Laporan hanya untuk level 2 (Pemilik)
        if ($_SESSION['level'] == 2) {
        ?>
          <li><a href="./admin.php?hlm=laporan">Laporan</a></li> 
        <?php
        }
        
        // Menampilkan opsi untuk level 1 (Admin)
        if ($_SESSION['level'] == 1) {
        ?>
          <li><a href="./admin.php?hlm=transaksi">Transaksi</a></li>  
          <li><a href="?hlm=paket">Paket</a></li>
          <li><a href="./admin.php?hlm=laporan">Laporan</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Data Master <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="./admin.php?hlm=biaya">Data Biaya</a></li>
              <li><a href="./admin.php?hlm=user">Data User</a></li>
            </ul>
          </li>
        <?php
        }
        ?>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <?php echo $_SESSION['nama']; ?> <b class="caret"></b>
          </a>
          <ul class="dropdown-menu">
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</div>

<?php
} else {
    header("Location: ./");
    die();
}
?>