<?php
session_start();
require 'koneksi.php';

// Otentikasi Petugas
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'petugas') {
    die("Akses ditolak.");
}

if (isset($_GET['id'])) {
    $id_transaksi = $_GET['id'];
    
    // Update status transaksi menjadi 'Lunas'
    $query = "UPDATE transaksi SET status = 'Lunas' WHERE id_transaksi = $id_transaksi";
    mysqli_query($koneksi, $query);
}

// Redirect kembali ke halaman kelola pembayaran
header("Location: kelola_pembayaran.php");
exit;
?>