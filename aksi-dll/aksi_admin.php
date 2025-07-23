<?php
session_start();
require 'koneksi.php';

// Otentikasi: Pastikan hanya ADMIN yang bisa menjalankan aksi ini
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Akses ditolak. Anda harus login sebagai admin.");
}

// Ambil jenis aksi dan ID dari URL
$aksi = $_GET['aksi'] ?? '';
$id = $_GET['id'] ?? 0;

if ($aksi === 'hapus_pesan' && $id > 0) {
    // Hapus pesan dari tabel pesan_kesan
    $stmt = $koneksi->prepare("DELETE FROM pesan_kesan WHERE id_pesan = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    // Redirect kembali ke halaman pesan
    header("Location: lihat_pesan.php");
    exit;

} elseif ($aksi === 'hapus_transaksi' && $id > 0) {
    // Hapus transaksi dari tabel transaksi
    // Detail transaksi akan terhapus otomatis karena ON DELETE CASCADE
    $stmt = $koneksi->prepare("DELETE FROM transaksi WHERE id_transaksi = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Redirect kembali ke halaman laporan
    header("Location: laporan_keuangan.php");
    exit;
}

// Jika aksi tidak dikenali, redirect ke dashboard
header("Location: dashboard.php");
exit;
?>