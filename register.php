<?php
session_start();
include "koneksi.php";

if (isset($_REQUEST['submit'])) {
    $username = $_REQUEST['username'];
    $password = MD5($_REQUEST['password']);
    $nama = $_REQUEST['nama'];
    $alamat = $_REQUEST['alamat'];
    $hp = $_REQUEST['hp'];
    $level = 2; // Level untuk pelanggan

    $sql = mysqli_query($koneksi, "INSERT INTO user(username, password, nama, alamat, hp, level) VALUES('$username', '$password', '$nama', '$alamat', '$hp', '$level')");

    if ($sql) {
        header('Location: ./index.php');
        die();
    } else {
        echo 'ERROR! Periksa penulisan querynya.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Register</title>
    <link href="css/bootstrap.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2>Daftar Akun</h2>
    <form method="post" action="">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="nama">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
        </div>
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat" required>
        </div>
        <div class="form-group">
            <label for="hp">Nomor HP</label>
            <input type="text" class="form-control" id="hp" name="hp" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Daftar</button>
        <a href="index.php" class="btn btn-link">Sudah punya akun? Login</a>
    </form>
</div>
</body>
</html>