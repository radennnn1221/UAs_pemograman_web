<?php
session_start();
require 'koneksi.php';

// Otentikasi: Pastikan hanya PETUGAS yang bisa menjalankan aksi ini
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'petugas') {
    die("Akses ditolak. Anda harus login sebagai petugas.");
}

// Ambil jenis aksi dan ID dari URL
$aksi = $_GET['aksi'] ?? '';
$id = $_GET['id'] ?? 0;

// Logika untuk menghapus transaksi
if ($aksi === 'hapus_transaksi' && $id > 0) {
    // Gunakan prepared statement untuk keamanan
    $stmt = $koneksi->prepare("DELETE FROM transaksi WHERE id_transaksi = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    // Alihkan kembali ke halaman kelola pembayaran
    header("Location: kelola_pembayaran.php");
    exit;
}

// Jika aksi tidak dikenali, redirect ke dashboard
header("Location: dashboard.php");
exit;
?>