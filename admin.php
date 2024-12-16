<?php
session_start();
if (empty($_SESSION['id_user'])) {
    $_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
    header('Location: ./');
    die();
} else {
    include "koneksi.php"; // Ensure this file exists and is correct
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Aplikasi 3FG Carwash</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/jquery-ui.min.css" rel="stylesheet">
    <script src="js/jquery.min.js"></script>
    <style type="text/css">
        body {
            min-height: 200px;
            padding-top: 70px;
        }
        @media print {
            .container {
                margin-top: -30px;
            }
            #tombol,
            .noprint {
                display: none;
            }
        }
    </style>
</head>
<body>

<?php include "menu.php"; ?>

<div class="container">

<?php
if (isset($_REQUEST['hlm'])) {
    $hlm = $_REQUEST['hlm'];

    // Sanitize the input to prevent security issues
    $hlm = htmlspecialchars($hlm);

    switch ($hlm) {
        case 'transaksi':
            include "transaksi.php";
            break;
        case 'laporan':
            include "laporan.php";
            break;
        case 'user':
            include "user.php";
            break;
        case 'biaya':
            include "biaya.php";
            break;
        case 'cetak':
            include "cetak_nota.php";
            break;
        case 'paket':
            include "paket.php";
            break;	
        default:
            echo '<p>Halaman tidak ditemukan.</p>';
            break;
    }
} else {
?>
    <div class="jumbotron">
        <h2>Selamat Datang di Aplikasi 3FG Carwash</h2>
        <p>Halo <strong ><?php echo $_SESSION['nama']; ?></strong>, Anda login sebagai <strong>
        <?php
            if ($_SESSION['level'] == 1) {
                echo 'Admin.';
            } elseif ($_SESSION['level'] == 2) {
                echo 'Pemilik.';
            } elseif ($_SESSION['level'] == 3) {
                echo 'Pelanggan.';
            } else {
                echo 'Akun tidak ada.';
            }
        ?>
        </strong></p>
    </div>
<?php
}
?>
</div> <!-- /container -->

<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-ui.min.js"></script>

</body>
</html>
<?php
}
?>