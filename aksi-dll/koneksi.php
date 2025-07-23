<?php
$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "toko_sepatu_db";

$koneksi = mysqli_connect($host, $db_user, $db_pass, $db_name);

if (!$koneksi) {
    die("KONEKSI GAGAL: " . mysqli_connect_error());
}
?>