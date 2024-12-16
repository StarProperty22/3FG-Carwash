<?php
    $host = "localhost";
    $user = "root";
    $password = "";
    $db = "ajc";

    $koneksi = mysqli_connect($host, $user, $password, $db);

    if(!$koneksi){
        die("Koneksi Database Gagal ." .mysqli_connect_error());
    }

?>